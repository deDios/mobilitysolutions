<?php
/**
 * API: Autos reservados con jerarquía
 * GET params:
 *   - user_id  (int)  -> id del usuario (tmx_usuario.id)
 *   - estatus  (int)  -> estatus del auto (por defecto 3 = reservado)
 *
 * Perfiles con vista completa:
 *   - user_type = 5 (CTO)
 *   - user_type = 6 (CEO)
 *   - r_autorizador = 1
 *
 * Si NO tiene vista completa, solo se devuelven autos cuyo último
 * requerimiento de tipo 'reserva' pertenece a ese usuario.
 */
header('Content-Type: application/json');

// -------------------------------
// 1) Parámetros de entrada
// -------------------------------
$userId  = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
$estatus = isset($_GET['estatus']) ? (int)$_GET['estatus'] : 3; // 3 = reservado

if ($userId <= 0) {
  http_response_code(400);
  echo json_encode(["error" => "Falta el parámetro user_id (numérico)"]);
  exit;
}

// -------------------------------
// 2) Conexión BD
// -------------------------------
$inc = include "../db/Conexion.php";
if (!$inc || !isset($con) || !$con) {
  http_response_code(500);
  echo json_encode(["error" => "Falla en la conexión a la BD"]);
  exit;
}

// Forzar charset (evita problemas con acentos)
if (function_exists('mysqli_set_charset')) {
  mysqli_set_charset($con, "utf8mb4");
}

// -------------------------------
// 3) Cargar rol del usuario
// -------------------------------
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

// -------------------------------
// 4) Regla de acceso (vista completa)
// -------------------------------
$isFullView = ($currentUserType === 5 || $currentUserType === 6 );

// -------------------------------
// 5) Consulta principal
//    - Une info del auto
//    - Suma el último req de tipo 'reserva' por auto
//    - Filtra por a.estatus (p.ej. 3 = reservado)
//    - Si NO es vista completa: además filtra por r.id_usuario
// -------------------------------
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

/* bind de parámetros: primero estatus */
$params[] = $estatus;
$types   .= "i";

/* si no es vista completa, filtra por r.id_usuario */
if (!$isFullView) {
  $sql .= " AND r.id_usuario = ? ";
  $params[] = $currentUserId;
  $types   .= "i";
}

$sql .= " ORDER BY a.id DESC";

// -------------------------------
// 6) Ejecutar consulta
// -------------------------------
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
      // No exponemos id_usuario a perfiles sin vista completa
      unset($row['id_usuario']);
    }
    $data[] = $row;
  }
}

// -------------------------------
// 7) Respuesta
// -------------------------------
echo json_encode($data);

// -------------------------------
// 8) Cierre
// -------------------------------
$stmt->close();
$stmtUser->close();
$con->close();
