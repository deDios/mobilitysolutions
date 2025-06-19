<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

// Obtener parámetros
$asignado = isset($_GET['asignado']) ? intval($_GET['asignado']) : 0;
$anio = date("Y");

if (!$asignado) {
    echo json_encode(["success" => false, "message" => "Falta el parámetro 'asignado'."]);
    exit;
}

// Preparar array base con meses en 0
$metas = [
    "enero" => 0, "febrero" => 0, "marzo" => 0, "abril" => 0,
    "mayo" => 0, "junio" => 0, "julio" => 0, "agosto" => 0,
    "septiembre" => 0, "octubre" => 0, "noviembre" => 0, "diciembre" => 0
];

// Consulta SQL
$sql = "SELECT * FROM mobility_solutions.tmx_metas WHERE asignado = ? AND anio = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("ii", $asignado, $anio);
$stmt->execute();
$result = $stmt->get_result();

// Si hay resultados, sumar metas agrupadas por tipo (opcional si solo quieres uno)
while ($row = $result->fetch_assoc()) {
    foreach ($metas as $mes => $_) {
        $metas[$mes] += intval($row[$mes]);
    }
}

echo json_encode(["success" => true, "anio" => $anio, "metas" => $metas]);

$stmt->close();
$con->close();
?>
