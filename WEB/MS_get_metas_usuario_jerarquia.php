<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

$asignado = isset($_GET['asignado']) ? intval($_GET['asignado']) : null;
$user_type = isset($_GET['user_type']) ? intval($_GET['user_type']) : null;
$solo_usuario = isset($_GET['solo_usuario']) ? intval($_GET['solo_usuario']) === 1 : false;
$anio = date("Y");

if (!$asignado || !$user_type) {
    echo json_encode([
        "success" => false,
        "message" => "Faltan parámetros requeridos"
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

// 🧠 Determinar qué usuarios consultar
$ids_consultados = [];

if ($solo_usuario) {
    // Solo consultar al usuario indicado, sin subordinados ni jerarquía
    $ids_consultados = [$asignado];
} elseif (in_array($user_type, [5, 6])) {
    // CTO o CEO: consultar TODOS los usuarios que tienen metas este año
    $query = "SELECT DISTINCT asignado FROM mobility_solutions.tmx_metas WHERE anio = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $anio);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $ids_consultados[] = $row['asignado'];
    }

    $stmt->close();
} else {
    // Usuario común: incluir a sí mismo y subordinados
    $ids_consultados = [$asignado];
    obtenerSubordinados($con, $asignado, $ids_consultados);
}

// 🧱 Armar la consulta
$placeholders = implode(',', array_fill(0, count($ids_consultados), '?'));
$tipos = str_repeat('i', count($ids_consultados)) . 'i'; // usuarios + año

$query = "
    SELECT tipo_meta, asignado, enero, febrero, marzo, abril, mayo, junio,
           julio, agosto, septiembre, octubre, noviembre, diciembre
    FROM mobility_solutions.tmx_metas
    WHERE asignado IN ($placeholders) AND anio = ?
";

$stmt = $con->prepare($query);

// 🧷 Bind dinámico
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
