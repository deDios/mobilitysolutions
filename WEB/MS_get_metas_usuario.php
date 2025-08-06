<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

$asignado = isset($_GET['asignado']) ? intval($_GET['asignado']) : null;
$anio = date("Y");

if (!$asignado) {
    echo json_encode([
        "success" => false,
        "message" => "Falta el parámetro asignado"
    ]);
    exit;
}

if ($asignado == 9999) {
    $query = "
        SELECT tipo_meta, enero, febrero, marzo, abril, mayo, junio,
               julio, agosto, septiembre, octubre, noviembre, diciembre
        FROM mobility_solutions.tmx_metas
        WHERE anio = ?
    ";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $anio);
} else {
    $query = "
        SELECT tipo_meta, enero, febrero, marzo, abril, mayo, junio,
               julio, agosto, septiembre, octubre, noviembre, diciembre
        FROM mobility_solutions.tmx_metas
        WHERE asignado = ? AND anio = ?
    ";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ii", $asignado, $anio);
}

$stmt->execute();
$result = $stmt->get_result();

$metas = [];
while ($row = $result->fetch_assoc()) {
    $metas[] = $row;
}

echo json_encode([
    "success" => true,
    "metas" => $metas
]);

$stmt->close();
$con->close();
?>

