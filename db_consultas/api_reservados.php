<?php
header('Content-Type: application/json; charset=utf-8');

// ===============================
// 1) Parámetros de entrada
// ===============================
$userId  = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0; // <-- ahora por GET
$estatus = isset($_GET['estatus']) ? (int)$_GET['estatus'] : 3; // 3 = reservado (por tu API original)

if ($userId <= 0) {
  http_response_code(400);
  echo json_encode(["error" => "Falta el parámetro user_id (numérico)"]);
  exit;
}

// ===============================
// 2) Conexión BD
// ===============================
$inc = include "../db/Conexion.php";
if (!$inc || !isset($con)) {
  http_response_code(500);
  echo json_encode(["error" => "Falla en la conexión a la BD"]);
  exit;
}

// ===============================
// 3) Cargar rol del usuario (por user_id)
// ===============================
$sqlUser = "
  SELECT 
    acc.user_id,
    acc.user_name,
    acc.user_type,        -- NUMÉRICO (FK a tmx_tipo_usuario)
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
  exit;
}

$currentUserId   = (int)$userRow['user_id'];        // ID en tmx_usuario
$currentUserType = (int)$userRow['user_type'];      // 5=CTO, 6=CEO
$r_autorizador   = (int)($userRow['r_autorizador'] ?? 0);

// ===============================
// 4) Regla de acceso
// ===============================
$isFullView = ($currentUserType === 5 || $currentUserType === 6 || $r_autorizador === 1);

// ===============================
// 5) Consulta principal
//    - Unimos la info del auto
//    - Sumamos el ÚLTIMO requerimiento de tipo 'reserva' por auto
// ===============================
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
  LEFT JOIN mobility_solutions.tmx_marca ma           ON a.marca    = ma.id
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
$types  = "i"; // estatus primero

if (!$isFullView) {
  // Usuario normal: solo los autos donde el ÚLTIMO req de 'reserva'
  // fue creado por ese usuario
  $sql .= " AND r.id_usuario = ? ";
  $params[] = $estatus;
  $params[] = $currentUserId;
  $types   .= "i";
} else {
  // Vista completa: CTO/CEO/autorizador ven todos los reservados
  $params[] = $estatus;
}

$sql .= " ORDER BY a.id DESC";

// ===============================
// 6) Ejecutar consulta
// ===============================
$stmt = $con->prepare($sql);
if (!$stmt) {
  http_response_code(500);
  echo json_encode(["error" => "Error al preparar la consulta principal"]);
  exit;
}

$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    if (!$isFullView) {
      // Por seguridad: no exponemos id_usuario a perfiles no-full
      unset($row['id_usuario']);
    }
    $data[] = $row;
  }
}

echo json_encode($data);

// ===============================
// 7) Cierre
// ===============================
$stmt->close();
$stmtUser->close();
$con->close();
