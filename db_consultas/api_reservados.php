<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

// ===== 1) Autenticación =====
if (!isset($_SESSION['username'])) {
  http_response_code(401);
  echo json_encode(["error" => "No autenticado"]);
  exit;
}

// ===== 2) Conexión =====
$inc = include "../db/Conexion.php";
if (!$inc || !isset($con)) {
  http_response_code(500);
  echo json_encode(["error" => "Falla en la conexión a la BD"]);
  exit;
}

// ===== 3) Traer info del usuario (desde tmx_acceso_usuario) =====
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
  WHERE acc.user_name = ?
  LIMIT 1
";
if (!($stmtUser = $con->prepare($sqlUser))) {
  http_response_code(500);
  echo json_encode(["error" => "Error preparando consulta de usuario"]);
  exit;
}
$stmtUser->bind_param("s", $_SESSION['username']);
$stmtUser->execute();
$resUser = $stmtUser->get_result();
$userRow = $resUser ? $resUser->fetch_assoc() : null;

if (!$userRow) {
  http_response_code(403);
  echo json_encode(["error" => "Usuario no encontrado"]);
  exit;
}

$currentUserId   = (int)$userRow['user_id'];        // ID en tmx_usuario
$currentUserType = (int)$userRow['user_type'];      // NUMÉRICO (FK a tmx_tipo_usuario)
$r_autorizador   = (int)($userRow['r_autorizador'] ?? 0);

// ===== 4) Reglas de acceso (vista full para CTO=5 / CEO=6) =====
$isFullView = ($currentUserType === 5 || $currentUserType === 6);

// ===== 5) Estatus (por compatibilidad con tu API actual) =====
$estatus = isset($_GET['estatus']) ? (int)$_GET['estatus'] : 3; // 3 = reservado (según tu API original)

// ===== 6) SELECT base =====
// Nota: unimos el ÚLTIMO requerimiento de tipo 'reserva' por auto para saber
// quién lo reservó, su estado y la fecha. Si quieres solo los que realmente
// tienen requerimiento de reserva, el LEFT JOIN se puede volver INNER JOIN.
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

// ===== 7) Filtros por jerarquía =====
$params = [];
$types  = "i"; // estatus

if (!$isFullView) {
  // Usuario normal: solo lo que él reservó (según último req de 'reserva')
  $sql .= " AND r.id_usuario = ? ";
  $params[] = $estatus;
  $params[] = $currentUserId;
  $types   .= "i";
} else {
  // Vista completa: CTO/CEO/autorizador ven todos los reservados
  $params[] = $estatus;
}

// Ordenar por más recientes
$sql .= " ORDER BY a.id DESC";

// ===== 8) Ejecutar =====
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
    // Por seguridad, si NO es full view, no exponemos id_usuario de otros
    if (!$isFullView) {
      unset($row['id_usuario']);
    }
    $data[] = $row;
  }
}

echo json_encode($data);

// ===== 9) Cierre =====
$stmt->close();
$stmtUser->close();
$con->close();
