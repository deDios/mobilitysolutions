<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

$input = json_decode(file_get_contents('php://input'), true);
$asignado = $input['asignado'] ?? null;
$tipo_meta = $input['tipo_meta'] ?? null;
$anio = $input['anio'] ?? date('Y');

if (!$asignado || !$tipo_meta) {
    echo json_encode([
        'success' => false,
        'message' => 'Parámetros incompletos.'
    ]);
    exit;
}

$query = "SELECT enero, febrero, marzo, abril, mayo, junio, julio, agosto, septiembre, octubre, noviembre, diciembre
          FROM mobility_solutions.tmx_metas
          WHERE asignado = ? AND tipo_meta = ? AND anio = ? LIMIT 1";

$stmt = $con->prepare($query);
$stmt->bind_param("iii", $asignado, $tipo_meta, $anio);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'success' => true,
        'metas' => $row
    ]);
} else {
    // Retornar metas vacías
    echo json_encode([
        'success' => true,
        'metas' => [
            "enero" => 0,
            "febrero" => 0,
            "marzo" => 0,
            "abril" => 0,
            "mayo" => 0,
            "junio" => 0,
            "julio" => 0,
            "agosto" => 0,
            "septiembre" => 0,
            "octubre" => 0,
            "noviembre" => 0,
            "diciembre" => 0
        ]
    ]);
}

$stmt->close();
$con->close();
?>
