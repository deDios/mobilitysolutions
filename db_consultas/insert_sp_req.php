<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data) || !isset($data['vehiculo']['id']) || !isset($data['usuario']['id'])) {
    echo json_encode(["success" => false, "message" => "Error: Datos inválidos"]);
    exit;
}

require "../db/Conexion.php";

$id_auto = $data['vehiculo']['id'];

$query = "SELECT id, nombre, modelo, marca, mensualidad, costo, sucursal, 
                 color, transmision, interior, kilometraje, combustible, 
                 cilindros, eje, estatus, pasajeros, propietarios, c_type 
          FROM mobility_solutions.tmx_auto WHERE id = ?";

$stmt = $con->prepare($query);
$stmt->bind_param("i", $id_auto);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Error: Vehículo no encontrado"]);
    exit;
}

$vehiculo = $result->fetch_assoc();
$stmt->close();

$id_usuario = intval(trim($data['usuario']['id'], "\""));

if ($id_usuario === 0) {
    echo json_encode(["success" => false, "message" => "Error: Usuario no válido"]);
    exit;
}


// Insertar requerimiento en la base de datos
$insert_requerimiento = "INSERT INTO mobility_solutions.tmx_requerimiento (
    tipo_req, status_req, id_auto, nombre, modelo, marca, mensualidad, 
    costo, sucursal, color, transmision, interior, kilometraje, combustible, 
    cilindros, eje, estatus, pasajeros, propietarios, c_type, created_by, created_at
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $con->prepare($insert_requerimiento);

$tipo_req = "Reserva de vehículo";
$status_req = 1;
$estatus = 1;

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
    $id_usuario
);

// Ejecutar la consulta y verificar si fue exitosa
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Reserva registrada correctamente"]);
} else {
    echo json_encode(["success" => false, "message" => "Error en la base de datos: " . $stmt->error]);
}

$stmt->close();
$con->close();
?>


