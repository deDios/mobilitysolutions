<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_clean(); // Limpia cualquier salida previa

// Obtener datos de la solicitud
$data = json_decode(file_get_contents("php://input"), true);

// Si no hay datos válidos, enviar error
if (!$data || !isset($data['vehiculo']) || !isset($data['usuario'])) {
    echo json_encode(["success" => false, "message" => "Datos inválidos."]);
    exit;
}

// Conectar a la base de datos con manejo de errores
require "../db/Conexion.php";
if (!$con) {
    echo json_encode(["success" => false, "message" => "Error de conexión a la base de datos."]);
    exit;
}

$vehiculo = $data['vehiculo'];
$usuario = $data['usuario'];

// Verificar que los valores requeridos existen
$requiredFields = ['id', 'nombre', 'modelo', 'marca', 'mensualidad', 'costo', 'sucursal', 
                   'color', 'transmision', 'interior', 'kilometraje', 'combustible', 
                   'cilindros', 'eje', 'pasajeros', 'propietarios', 'c_type'];

foreach ($requiredFields as $field) {
    if (!isset($vehiculo[$field])) {
        echo json_encode(["success" => false, "message" => "Falta el campo: $field"]);
        exit;
    }
}

if (!isset($usuario['id'])) {
    echo json_encode(["success" => false, "message" => "Falta el ID de usuario."]);
    exit;
}

// Datos para la inserción
$tipo_req = "Reserva de vehículo";
$status_req = 1; // Estado inicial de la solicitud
$estatus = 1; // Estatus del requerimiento

// Consulta SQL
$insert_requerimiento = "INSERT INTO mobility_solutions.tmx_requerimiento (
    tipo_req, status_req, id_auto, nombre, modelo, marca, mensualidad, costo, sucursal, color, 
    transmision, interior, kilometraje, combustible, cilindros, eje, estatus, pasajeros, 
    propietarios, c_type, created_by, created_at
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $con->prepare($insert_requerimiento);
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Error preparando consulta SQL: " . $con->error]);
    exit;
}

// Asignar valores desde el array de vehículo y usuario
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
    $usuario['id']
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


