<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

// Obtener datos desde el cuerpo del request
$data = json_decode(file_get_contents("php://input"), true);

// Validación de campos obligatorios
$required_fields = ['tipo', 'reconocimiento', 'asignado', 'mes', 'anio', 'descripcion', 'creado_por'];
foreach ($required_fields as $field) {
    if (empty($data[$field]) && $data[$field] !== 0) {
        echo json_encode([
            "success" => false,
            "message" => "Falta el campo requerido: $field"
        ]);
        exit;
    }
}

// Extraer datos
$tipo = $data['tipo'];
$reconocimiento = $data['reconocimiento'];
$asignado = $data['asignado'];
$mes = $data['mes'];
$anio = $data['anio'];
$descripcion = $data['descripcion'];
$creado_por = $data['creado_por'];

// Insertar reconocimiento
$sql = "INSERT INTO mobility_solutions.tmx_reconocimientos 
            (tipo, reconocimiento, asignado, mes, anio, descripcion, creado_por, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $con->prepare($sql);
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Error en la preparación: " . $con->error]);
    exit;
}

$stmt->bind_param("isiiisi", $tipo, $reconocimiento, $asignado, $mes, $anio, $descripcion, $creado_por);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Reconocimiento registrado correctamente."]);
} else {
    echo json_encode(["success" => false, "message" => "Error al registrar el reconocimiento: " . $stmt->error]);
}

$stmt->close();
$con->close();
?>
