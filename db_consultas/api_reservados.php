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

// ===== 3) Obtener info/roles del usuario actual =====
//   Reutilizamos tu misma lógica para traer user_id y privilegios.
$sqlUser = "
  SELECT 
    acc.user_id,
    acc.user_name,
    acc.user_type,
    acc.r_ejecutivo,
    acc.r_editor,
    acc.r_autorizador,
    acc.r_analista
  FROM mobility_solutions.tmx_acceso_usuario acc
  WHERE acc.user_name = ?
  LIMIT 1
";
$stmtUser = $con->prepare($sqlUser);
$stmtUser->bind_param("s", $_SESSION['username']);
$stmtUser->execute();
$resUser = $stmtUser->get_result();
$userRow = $resUser ? $resUser->fetch_assoc() : null;

if (!$userRow) {
  http_response_code(403);
  echo json_encode(["error" => "Usuario no encontrado"]);
  exit;
}

$userId         = (int)($userRow['user_id'] ?? 0);
$userType       = strtoupper(trim($userRow['user_type'] ?? ''));
$r_ejecutivo    = (int)($userRow['r_ejecutivo'] ?? 0);
$r_editor       = (int)($userRow['r_editor'] ?? 0);
$r_autorizador  = (int)($userRow['r_autorizador'] ?? 0);
$r_analista     = (int)($userRow['r_analista'] ?? 0);

// ===== 4) Reglas de acceso =====
//  - CEO/CTO: vista full
//  - resto: solo sus reservas
$isFullView = in_array($userType, ['CEO','CTO'], true);

// ===== 5) Parámetros opcionales =====
$estatus = isset($_GET['estatus']) ? (int)$_GET['estatus'] : 3;

// ===== 6) SQL base =====
//  - auto: datos del vehículo
//  - modelo/marca/m_auto: nombres legibles
//  - sucursal: añade si la quieres en la respuesta (útil en “entrega”)
$selectBase = "
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
  LEFT JOIN mobility_solutions.tmx_modelo mo      ON a.modelo   = mo.id
  LEFT JOIN mobility_solutions.tmx_marca ma       ON a.marca    = ma.id
  LEFT JOIN mobility_solutions.tmx_marca_auto m_auto ON a.nombre = m_auto.id
  LEFT JOIN mobility_solutions.tmx_sucursal s     ON a.sucursal = s.id
  /* Traemos el ÚLTIMO requerimiento de tipo 'reserva' por auto,
     para saber quién lo reservó y su estado actual */
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

// ===== 7) Filtro por jerarquía =====
$params = [];
$types  = "i"; // estatus

if (!$isFullView) {
  // Usuarios normales: solo sus reservas
  $selectBase .= " AND r.id_usuario = ? ";
  $params[] = $estatus;
  $params[] = $userId;
  $types   .= "i";
} else {
  // Full view: CTO/CEO/autorizadores
  $params[] = $estatus;
}

// Orden
$selectBase .= " ORDER BY a.id DESC";

// ===== 8) Ejecutar =====
$stmt = $con->prepare($selectBase);
if (!$stmt) {
  http_response_code(500);
  echo json_encode(["error" => "Error al preparar la consulta"]);
  exit;
}

$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    // Si no es full view, por seguridad evita exponer id_usuario de otros.
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
