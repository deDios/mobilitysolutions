<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido; usa POST"
    ]);
    exit;
}

include "../db/Conexion.php";

$raw    = file_get_contents("php://input");
$input  = json_decode($raw, true) ?: [];

$asignado     = isset($input['asignado']) ? (int)$input['asignado'] : 0;
$user_type    = isset($input['user_type']) ? (int)$input['user_type'] : 0;
$solo_usuario = !empty($input['solo_usuario']); // bool
$anio         = isset($input['year']) ? (int)$input['year'] : (int)date('Y');

if ($asignado <= 0 || $user_type <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Faltan parámetros requeridos (asignado, user_type)"
    ]);
    exit;
}

// 🔁 Función recursiva para obtener todos los subordinados
function obtenerSubordinadosMetasDash($con, $userId, &$subordinados) {
    $stmt = $con->prepare("
        SELECT user_id 
        FROM mobility_solutions.tmx_acceso_usuario 
        WHERE reporta_a = ?
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $subId = (int)$row['user_id'];
        if (!in_array($subId, $subordinados, true)) {
            $subordinados[] = $subId;
            obtenerSubordinadosMetasDash($con, $subId, $subordinados); // recursivo
        }
    }

    $stmt->close();
}

// 🧠 Determinar qué usuarios consultar
$ids_consultados = [];

if ($solo_usuario) {
    // Solo el usuario indicado
    $ids_consultados = [$asignado];
} elseif (in_array($user_type, [5, 6], true)) {
    // CTO o CEO: TODOS los usuarios que tienen metas en ese año
    $stmt = $con->prepare("
        SELECT DISTINCT asignado 
        FROM mobility_solutions.tmx_metas 
        WHERE anio = ?
    ");
    $stmt->bind_param("i", $anio);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $ids_consultados[] = (int)$row['asignado'];
    }

    $stmt->close();
} else {
    // Usuario normal: él + subordinados
    $ids_consultados = [$asignado];
    obtenerSubordinadosMetasDash($con, $asignado, $ids_consultados);
}

$ids_consultados = array_values(array_unique(array_map('intval', $ids_consultados)));

if (empty($ids_consultados)) {
    echo json_encode([
        "success" => true,
        "anio"    => $anio,
        "metas"   => []
    ]);
    exit;
}

// 🧱 Armar la consulta dinámica
$placeholders = implode(',', array_fill(0, count($ids_consultados), '?'));
$tipos        = str_repeat('i', count($ids_consultados)) . 'i'; // usuarios + año

$sql = "
    SELECT 
        tipo_meta, 
        asignado, 
        enero, febrero, marzo, abril, mayo, junio,
        julio, agosto, septiembre, octubre, noviembre, diciembre
    FROM mobility_solutions.tmx_metas
    WHERE asignado IN ($placeholders)
      AND anio = ?
";

$stmt = $con->prepare($sql);

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
    "anio"    => $anio,
    "metas"   => $metas
], JSON_UNESCAPED_UNICODE);

$stmt->close();
$con->close();
