<?php
ob_start();
header('Content-Type: application/json');

$telefono = $_REQUEST['telefono'] ?? '';
$telefono = trim($telefono);

if (empty($telefono)) {
    echo json_encode(["success" => false, "message" => "Número de teléfono no proporcionado"]);
    exit();
}

$inc = include "../db/Conexion.php";
if (!$inc || !$con) {
    echo json_encode(["success" => false, "message" => "Error de conexión"]);
    exit();
}

$telefono = mysqli_real_escape_string($con, $telefono);

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

ob_end_flush();
?>
