<?php
// Forzar que PHP no imprima errores o contenido inesperado
ob_start();
header('Content-Type: application/json');

// Leer parámetro
$telefono = $_REQUEST['telefono'] ?? '';
$telefono = trim($telefono);

// Validar formato básico
if (empty($telefono)) {
    echo json_encode(["success" => false, "message" => "Número de teléfono no proporcionado"]);
    exit();
}

// Conexión
$inc = include "../db/Conexion.php";
if (!$inc || !$con) {
    echo json_encode(["success" => false, "message" => "Error de conexión"]);
    exit();
}

// Escapar valor
$telefono = mysqli_real_escape_string($con, $telefono);

// Consulta
$query = "SELECT COUNT(*) AS total FROM mobility_solutions.moon_cliente WHERE Telefono = '$telefono' AND Status = 1;";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $exists = intval($row['total']) > 0;
    echo json_encode([
        "success" => !$exists,
        "message" => $exists ? "El teléfono ya está registrado" : "El teléfono está disponible"
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Error al ejecutar la consulta"]);
}

mysqli_close($con);

// Limpiar cualquier posible salida extra
ob_end_flush();
?>
