<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

$asignado = isset($_GET['asignado']) ? intval($_GET['asignado']) : null;
$user_type = isset($_GET['user_type']) ? intval($_GET['user_type']) : null;
$anio = date("Y");

if (!$asignado) {
    echo json_encode([
        "success" => false,
        "message" => "Falta el parámetro asignado"
    ]);
    exit;
}

// Si el usuario es CEO o CTO (tipos 5 o 6), traemos todas las metas
if ($user_type === 5 || $user_type === 6 || $asignado == 9999) {
    $query = "
        SELECT tipo_meta, asignado, enero, febrero, marzo, abril, mayo, junio,
               julio, agosto, septiembre, octubre, noviembre, diciembre
        FROM mobility_solutions.tmx_metas
        WHERE anio = ?
    ";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $anio);
} else {
    $query = "
        SELECT tipo_meta, asignado, enero, febrero, marzo, abril, mayo, junio,
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
