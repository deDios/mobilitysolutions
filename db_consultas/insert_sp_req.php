<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_clean();

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['vehiculo']) || !isset($data['usuario']) || !isset($data['vehiculo']['id'])) {
    echo json_encode(["success" => false, "message" => "Datos inválidos o incompletos."]);
    exit;
}

require "../db/Conexion.php";
if (!$con) {
    echo json_encode(["success" => false, "message" => "Error de conexión a la base de datos."]);
    exit;
}

$vehiculoId = $data['vehiculo']['id'];
$usuarioId = $data['usuario']['id'];

// 1️⃣ **Consultar los datos completos del vehículo**
$query = "SELECT id, nombre, modelo, marca, mensualidad, costo, sucursal, color, transmision, 
                 interior, kilometraje, combustible, cilindros, eje, estatus, pasajeros, 
                 propietarios, c_type
          FROM mobility_solutions.tmx_auto
          WHERE id = ?";

$stmt = $con->prepare($query);
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Error preparando consulta de vehículo: " . $con->error]);
    exit;
}

$stmt->bind_param("i", $vehiculoId);
$stmt->execute();
$result = $stmt->get_result();
$vehiculo = $result->fetch_assoc();
$stmt->close();

// Si no se encontró el vehículo, enviar error
if (!$vehiculo) {
    echo json_encode(["success" => false, "message" => "Vehículo no encontrado."]);
    exit;
}

// 2️⃣ **Insertar en la tabla tmx_requerimiento**
$tipo_req = "Reserva de vehículo";
$status_req = 1; // Estado inicial de la solicitud
$estatus = 1; // Estatus del requerimiento

$insert_requerimiento = "INSERT INTO mobility_solutions.tmx_requerimiento (
    tipo_req, status_req, id_auto, nombre, modelo, marca, mensualidad, costo, sucursal, color, 
    transmision, interior, kilometraje, combustible, cilindros, eje, estatus, pasajeros, 
    propietarios, c_type, created_by, created_at
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $con->prepare($insert_requerimiento);
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Error preparando consulta de inserción: " . $con->error]);
    exit;
}

$stmt->bind_param(
    "siiiiiddisssdsisiiisi",
    $tipo_req,
    $status_req,
    $vehiculo['id'],
    $vehiculo['nombre'],
    $vehiculo['modelo'],
    $vehiculo['marca'],
    $vehiculo['mensualidad'],
    $vehiculo['costo'],
    $vehiculo['sucursal'],
    $vehiculo['color'],
    $vehiculo['transmision'],
    $vehiculo['interior'],
    $vehiculo['kilometraje'],
    $vehiculo['combustible'],
    $vehiculo['cilindros'],
    $vehiculo['eje'],
    $estatus,
    $vehiculo['pasajeros'],
    $vehiculo['propietarios'],
    $vehiculo['c_type'],
    $usuarioId
);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Reserva registrada correctamente."]);
} else {
    error_log("Error en la consulta SQL: " . $stmt->error);
    echo json_encode(["success" => false, "message" => "Error en la base de datos."]);
}

$stmt->close();
$con->close();
exit;
?>


