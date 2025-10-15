<?php
/**
 * API: Autos reservados con jerarquía (con depuración por pasos)
 * GET:
 *   - user_id  (int)  -> tmx_usuario.id
 *   - estatus  (int)  -> estatus del auto (default 3 = reservado)
 *   - debug    (int)  -> pasos de depuración:
 *                       1 = Ping del script + echo de GET (no valida nada)
 *                       2 = Valida parámetros mínimos
 *                       3 = Prueba conexión BD
 *                       4 = Busca rol del usuario
 *                       5 = Ejecuta consulta principal (modo normal)
 */

header('Content-Type: application/json; charset=utf-8');

// ---------- Depuración ----------
$debug = isset($_GET['debug']) ? (int)$_GET['debug'] : 0;

// PASO 1: confirmar que el archivo se carga y que Nginx lo encuentra
if ($debug === 1) {
  echo json_encode([
    'ok'      => true,
    'step'    => 1,
    'message' => 'script reachable',
    'raw_get' => $_GET
  ]);
  exit;
}

// ---------- 1) Parámetros ----------
$userId  = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
$estatus = isset($_GET['estatus']) ? (int)$_GET['estatus'] : 3; // 3 = reservado

if ($debug === 2) {
  // Solo valida parámetros y muestra resultado
  $valid = $userId > 0;
  http_response_code($valid ? 200 : 400);
  echo json_encode([
    'ok'        => $valid,
    'step'      => 2,
    'message'   => $valid ? 'parámetros OK' : 'Falta el parámetro user_id (numérico)',
    'user_id'   => $userId,
    'estatus'   => $estatus
  ]);
  exit;
}

if ($userId <= 0) {
  http_response_code(400);
  echo json_encode(["error" => "Falta el parámetro user_id (numérico)"]);
  exit;
}

// ---------- 2) Conexión BD ----------
$inc = include "../db/Conexion.php";
if ($debug === 3) {
  $ok = ($inc && isset($con) && $con);
  http_response_code($ok ? 200 : 500);
  echo json_encode([
    'ok'      => $ok,
    'step'    => 3,
    'message' => $ok ? 'Conexión BD OK' : 'Falla en la conexión a la BD',
  ]);
  exit;
}

if (!$inc || !isset($con) || !$con) {
  http_response_code(500);
  echo json_encode(["error" => "Falla en la conexión a la BD"]);
  exit;
}
if (function_exists('mysqli_set_charset')) {
  mysqli_set_charset($con, "utf8mb4");
}

// ---------- 3) Rol del usuario ----------
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

if (!($stmtUser = $con->prepare($sqlUser))) {
  http_response_code(500);
  echo json_encode(["error" => "Error preparando consulta de usuario"]);
  exit;
}
$stmtUser->bind_param("i", $userId);
$stmtUser->execute();
$resUser = $stmtUser->get_result();
$userRow = $resUser ? $resUser->fetch_assoc() : null;

if ($debug === 4) {
  $found = (bool)$userRow;
  http_response_code($found ? 200 : 404);
  echo json_encode([
    'ok'      => $found,
    'step'    => 4,
    'message' => $found ? 'Usuario encontrado' : 'Usuario no encontrado',
    'user'    => $userRow
  ]);
  $stmtUser->close();
  $con->close();
  exit;
}

if (!$userRow) {
  http_response_code(404);
  echo json_encode(["error" => "Usuario no encontrado"]);
  $stmtUser->close();
  $con->close();
  exit;
}

$currentUserId   = (int)$userRow['user_id'];        // tmx_usuario.id
$currentUserType = (int)$userRow['user_type'];      // 5/6
$r_autorizador   = (int)($userRow['r_autorizador'] ?? 0);

// Vista completa: CTO, CEO o autorizador
$isFullView = ($currentUserType === 5 || $currentUserType === 6 || $r_autorizador === 1);

// ---------- 5) Consulta principal ----------
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
$types  = "";

// bind de parámetros: primero estatus
$params[] = $estatus;
$types   .= "i";

// si no es vista completa, filtra por r.id_usuario
if (!$isFullView) {
  $sql .= " AND r.id_usuario = ? ";
  $params[] = $currentUserId;
  $types   .= "i";
}

$sql .= " ORDER BY a.id DESC";

// Ejecutar
$stmt = $con->prepare($sql);
if (!$stmt) {
  http_response_code(500);
  echo json_encode(["error" => "Error al preparar la consulta principal"]);
  $stmtUser->close();
  $con->close();
  exit;
}
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    if (!$isFullView) {
      unset($row['id_usuario']); // ocultar para vista limitada
    }
    $data[] = $row;
  }
}

// En modo debug=5 mostramos también metadatos útiles
if ($debug === 5) {
  echo json_encode([
    'ok'         => true,
    'step'       => 5,
    'full_view'  => $isFullView,
    'params'     => ['estatus'=>$estatus, 'user_id'=>$currentUserId],
    'rows'       => count($data),
    'data'       => $data
  ]);
} else {
  // Modo normal
  echo json_encode($data);
}

// Cierre
$stmt->close();
$stmtUser->close();
$con->close();
