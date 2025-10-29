<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

$asignado = isset($_GET['asignado']) ? intval($_GET['asignado']) : null;

if (!$asignado) {
    echo json_encode([
        "success" => false,
        "message" => "Parámetro 'asignado' es requerido."
    ]);
    exit;
}

$query = "SELECT tipo, reconocimiento, mes, anio, descripcion 
          FROM mobility_solutions.tmx_reconocimientos 
          WHERE asignado = ? 
          ORDER BY anio DESC, mes DESC";

$stmt = $con->prepare($query);
$stmt->bind_param("i", $asignado);
$stmt->execute();
$result = $stmt->get_result();

$reconocimientos = [];
while ($row = $result->fetch_assoc()) {
    $reconocimientos[] = $row;
}

echo json_encode([
    "success" => true,
    "reconocimientos" => $reconocimientos
]);

$stmt->close();
$con->close();
?>
