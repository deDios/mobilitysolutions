<?php
/**
 * API: Autos reservados con jerarquía
 * GET:
 *   - user_id  (int)  -> id del usuario (tmx_usuario.id)  [OBLIGATORIO]
 *   - estatus  (int)  -> estatus del auto (default 3 = reservado)
 *   - debug    (int)  -> 1..5 checkpoints de depuración (opcional)
 *
 * Vista completa:
 *   - user_type 5 (CTO), 6 (CEO)  [y puedes añadir r_autorizador si quieres]
 *
 * Si NO tiene vista completa, solo devuelve autos cuyo **último** req 'reserva'
 * fue hecho por ese usuario.
 */

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');

$debug   = isset($_GET['debug'])   ? (int)$_GET['debug']   : 0;
$userId  = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
$estatus = isset($_GET['estatus']) ? (int)$_GET['estatus'] : 3; // 3 = reservado

// Helper para salidas de depuración
function out($step, $extra = []) {
  $base = [
    'ok'      => true,
    'step'    => $step,
    'message' => [
      1 => 'script reachable',
      2 => 'db connected',
      3 => 'user loaded',
      4 => 'sql built',
      5 => 'query executed',
    ][$step] ?? 'debug'
  ];
  echo json_encode(array_merge($base, $extra), JSON_UNESCAPED_UNICODE);
  exit;
}

// ===== Paso 1: script reachable =====
if ($debug === 1) {
  out(1, ['raw_get' => $_GET]);
}

// Validación user_id
if ($userId <= 0) {
  http_response_code(400);
  echo json_encode(["ok"=>false,"step"=>1,"error"=>"Falta el parámetro user_id (numérico)"]);
  exit;
}

// ===== Paso 2: conexión a BD =====
$inc = include "../db/Conexion.php";
if (!$inc || !isset($con) || !$con) {
  http_response_code(500);
  echo json_encode(["ok"=>false,"step"=>2,"error"=>"Falla en la conexión a la BD"]);
  exit;
}
if (function_exists('mysqli_set_charset')) { mysqli_set_charset($con, "utf8mb4"); }

if ($debug === 2) {
  out(2, ['db_connected'=>true, 'user_id'=>$userId, 'estatus'=>$estatus]);
}

// ===== Paso 3: cargar rol del usuario =====
$sqlUser = "
  SELECT 
    acc.user_id,
    acc.user_name,
    acc.user_type,        -- 5=CTO, 6=CEO
    acc.reporta_a,
    acc.r_ejecutivo,
    acc.r_editor,
    acc.r_autorizador,
    acc.r_analista
  FROM mobility_solutions.tmx_acceso_usuario acc
  WHERE acc.user_id = ?
  LIMIT 1
";
$stmtUser = $con->prepare($sqlUser);
if (!$stmtUser) {
  http_response_code(500);
  echo json_encode(["ok"=>false,"step"=>3,"error"=>"Error preparando consulta de usuario"]);
  exit;
}
$stmtUser->bind_param("i", $userId);
$stmtUser->execute();
$resUser = $stmtUser->get_result();
$userRow = $resUser ? $resUser->fetch_assoc() : null;

if (!$userRow) {
  http_response_code(404);
  echo json_encode(["ok"=>false,"step"=>3,"error"=>"Usuario no encontrado","user_id"=>$userId]);
  $stmtUser->close();
  $con->close();
  exit;
}

$currentUserId   = (int)$userRow['user_id'];   // tmx_usuario.id
$currentUserType = (int)$userRow['user_type']; // 5/6
$r_autorizador   = (int)($userRow['r_autorizador'] ?? 0);

// Ajusta aquí si quieres que autorizador también sea FullView:
$isFullView = ($currentUserType === 5 || $currentUserType === 6 /* || $r_autorizador === 1 */);

if ($debug === 3) {
  out(3, [
    'user' => [
      'user_id'       => $currentUserId,
      'user_type'     => $currentUserType,
      'r_autorizador' => $r_autorizador,
      'is_full_view'  => $isFullView
    ]
  ]);
}

// ===== Paso 4: construir SQL =====
$sql = "
  SELECT 
    a.id,
    m_auto.auto          AS nombre,
    mo.nombre            AS modelo,
    ma.nombre            AS marca,
    s.nombre             AS sucursal,
    r.status_req,
    r.tipo_req,
    r.created_at,
    r.id_usuario
  FROM mobility_solutions.tmx_auto a
  LEFT JOIN mobility_solutions.tmx_modelo mo          ON a.modelo   = mo.id
  LEFT JOIN mobility_solutions.tmx_marca  ma          ON a.marca    = ma.id
  LEFT JOIN mobility_solutions.tmx_marca_auto m_auto  ON a.nombre   = m_auto.id
  LEFT JOIN mobility_solutions.tmx_sucursal s         ON a.sucursal = s.id
  /* Último requerimiento de tipo 'reserva' por auto */
  LEFT JOIN (
    SELECT rr.*
    FROM mobility_solutions.tmx_requerimiento rr
    INNER JOIN (
      SELECT id_auto, MAX(id) AS max_id
      FROM mobility_solutions.tmx_requerimiento
      WHERE tipo_req = 'reserva'
      GROUP BY id_auto
    ) mx ON rr.id = mx.max_id
  ) r ON r.id_auto = a.id
  WHERE a.estatus = ?
";

$params = [];
$types  = "i";         // estatus primero
$params[] = $estatus;

if (!$isFullView) {
  $sql .= " AND r.id_usuario = ? ";
  $types  .= "i";
  $params[] = $currentUserId;
}

$sql .= " ORDER BY a.id DESC";

if ($debug === 4) {
  out(4, [
    'is_full_view' => $isFullView,
    'sql_preview'  => $sql,
    'bind_types'   => $types,
    'bind_params'  => $params
  ]);
}

// ===== Paso 5: ejecutar consulta =====
$stmt = $con->prepare($sql);
if (!$stmt) {
  http_response_code(500);
  echo json_encode(["ok"=>false,"step"=>5,"error"=>"Error al preparar la consulta principal"]);
  $stmtUser->close(); $con->close(); exit;
}

$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

if ($debug === 5) {
  $rows = [];
  if ($result && $result->num_rows > 0) {
    while ($r = $result->fetch_assoc()) { $rows[] = $r; }
  }
  out(5, [
    'row_count' => count($rows),
    'sample'    => array_slice($rows, 0, 5),
    'note'      => $isFullView ? 'full rows returned' : 'id_usuario se oculta en salida normal'
  ]);
}

// ===== Salida normal (sin debug) =====
$data = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    if (!$isFullView) { unset($row['id_usuario']); }
    $data[] = $row;
  }
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

// ===== Cierre =====
$stmt->close();
$stmtUser->close();
$con->close();
