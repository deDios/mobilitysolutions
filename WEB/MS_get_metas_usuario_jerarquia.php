<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;
$user_type = isset($_GET['user_type']) ? intval($_GET['user_type']) : null;

if (!$user_id || !$user_type) {
    echo json_encode(["error" => "Faltan parámetros"]);
    exit;
}

// Obtener usuarios subordinados o asignados con metas si es CTO/CEO
function getSubordinados($user_id, $user_type, $con) {
    $anioActual = date("Y");

    if (in_array($user_type, [5, 6])) {
        // CTO o CEO: solo usuarios que tienen metas en el año actual
        $query = "
            SELECT DISTINCT asignado AS id 
            FROM mobility_solutions.tmx_metas 
            WHERE anio = $anioActual
        ";
    } else {
        // Jerarquía descendente desde el usuario actual
        $query = "
            WITH RECURSIVE jerarquia AS (
                SELECT id FROM mobility_solutions.tmx_acceso_usuario WHERE id = $user_id
                UNION ALL
                SELECT u.id FROM mobility_solutions.tmx_acceso_usuario u
                INNER JOIN jerarquia j ON u.reporta_a = j.id
            )
            SELECT id FROM jerarquia
        ";
    }

    $res = mysqli_query($con, $query);
    $ids = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $ids[] = $row['id'];
    }

    return $ids;
}

$ids = getSubordinados($user_id, $user_type, $con);
$anioActual = date("Y");
$id_list = implode(',', $ids);

// Consulta de metas
$query = "
    SELECT tipo_meta, asignado, enero, febrero, marzo, abril, mayo, junio,
           julio, agosto, septiembre, octubre, noviembre, diciembre
    FROM mobility_solutions.tmx_metas
    WHERE asignado IN ($id_list)
      AND anio = $anioActual
";

$result = mysqli_query($con, $query);
$metas = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $metas[] = $row;
    }

    echo json_encode([
        "success" => true,
        "metas" => $metas
    ]);
} else {
    echo json_encode([
        "success" => false,
        "error" => "Error al ejecutar la consulta de metas"
    ]);
}

mysqli_close($con);
?>
