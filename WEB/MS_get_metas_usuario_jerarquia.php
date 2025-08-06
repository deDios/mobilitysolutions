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

// 🔁 Función recursiva para obtener todos los subordinados
function obtenerSubordinados($con, $userId, &$subordinados) {
    $stmt = $con->prepare("SELECT user_id FROM mobility_solutions.tmx_acceso_usuario WHERE reporta_a = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $subId = $row['user_id'];
        if (!in_array($subId, $subordinados)) {
            $subordinados[] = $subId;
            obtenerSubordinados($con, $subId, $subordinados); // recursivo
        }
    }

    $stmt->close();
}

$ids_consultados = [$asignado]; // incluye a sí mismo
obtenerSubordinados($con, $asignado, $ids_consultados);

// 📦 Construir placeholders para IN (...)
$placeholders = implode(',', array_fill(0, count($ids_consultados), '?'));
$tipos = str_repeat('i', count($ids_consultados) + 1); // +1 por $anio

$query = "
    SELECT tipo_meta, asignado, enero, febrero, marzo, abril, mayo, junio,
           julio, agosto, septiembre, octubre, noviembre, diciembre
    FROM mobility_solutions.tmx_metas
    WHERE asignado IN ($placeholders) AND anio = ?
";

$stmt = $con->prepare($query);

// 📌 Bind dinámico
$params = array_merge($ids_consultados, [$anio]);
$stmt->bind_param($tipos, ...$params);

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
