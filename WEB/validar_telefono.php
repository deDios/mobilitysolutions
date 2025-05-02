<?php
$telefono = $_REQUEST['telefono'];
header('Content-Type: application/json');

$inc = include "../db/Conexion.php";

if (!$inc || !$con) {
    echo json_encode(["success" => false, "message" => "Error de conexión"]);
    exit();
}

// Escapamos el valor para evitar inyección SQL
$telefono = mysqli_real_escape_string($con, $telefono);

// Consulta para verificar si el teléfono ya está registrado
$query = "SELECT COUNT(*) AS total FROM mobility_solutions.moon_cliente WHERE Telefono = '$telefono' AND Status = 1;";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row['total'] > 0) {
        echo json_encode(["success" => false, "message" => "El teléfono ya está registrado"]);
    } else {
        echo json_encode(["success" => true, "message" => "El teléfono está disponible"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Error al ejecutar la consulta"]);
}

mysqli_close($con);
?>
