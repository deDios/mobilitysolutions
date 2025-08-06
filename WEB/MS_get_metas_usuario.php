<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

// Obtener parámetros
$asignado = isset($_GET['asignado']) ? intval($_GET['asignado']) : null;
$user_type = isset($_GET['user_type']) ? intval($_GET['user_type']) : null;
$anio = date("Y");

// Validación
if (!$asignado || $user_type === null) {
    echo json_encode([
        "success" => false,
        "message" => "Faltan parámetros requeridos (asignado, user_type)"
    ]);
    exit;
}

// Si es CEO o CTO, no se filtra
if (in_array($user_type, [4, 5, 6])) {
    $query = "
        SELECT tipo_meta, asignado, enero, febrero, marzo, abril, mayo, junio,
               julio, agosto, septiembre, octubre, noviembre, diciembre
        FROM mobility_solutions.tmx_metas
        WHERE anio = ?
    ";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $anio);
} else {
    // Obtener subordinados recursivamente
    $ids = [$asignado];

    function obtenerSubordinados($id, $conexion, &$resultado) {
        $sql = "SELECT user_id FROM mobility_solutions.tmx_acceso_usuario WHERE reporta_a = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();

        while ($row = $res->fetch_assoc()) {
            $sub_id = $row['user_id'];
            if (!in_array($sub_id, $resultado)) {
                $resultado[] = $sub_id;
                obtenerSubordinados($sub_id, $conexion, $resultado);
            }
        }

        $stmt->close();
    }

    obtenerSubordinados($asignado, $con, $ids);
    $inClause = implode(',', array_fill(0, count($ids), '?'));
    
    $query = "
        SELECT tipo_meta, asignado, enero, febrero, marzo, abril, mayo, junio,
               julio, agosto, septiembre, octubre, noviembre, diciembre
        FROM mobility_solutions.tmx_metas
        WHERE asignado IN ($inClause) AND anio = ?
    ";

    $stmt = $con->prepare($query);
    $types = str_repeat("i", count($ids)) . "i"; // i...i + i
    $params = [...$ids, $anio];
    $stmt->bind_param($types, ...$params);
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
