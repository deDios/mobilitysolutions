<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

// Obtener datos del cuerpo POST
$input = json_decode(file_get_contents("php://input"), true);
if (!isset($input['user_id']) || !isset($input['user_type'])) {
    echo json_encode([
        "success" => false,
        "message" => "Faltan parámetros obligatorios"
    ]);
    exit;
}

$user_id = (int)$input['user_id'];
$user_type = (int)$input['user_type'];

if ($user_id === 1 || $user_id === 3 || $user_id === 4) {
    // CEO o CTO ven todos
    $query = "SELECT id, CONCAT(user_name, ' ', last_name) AS nombre_completo 
              FROM mobility_solutions.tmx_usuario 
              ORDER BY nombre_completo ASC";

    $result = mysqli_query($con, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            "id" => (int)$row["id"],
            "nombre" => $row["nombre_completo"]
        ];
    }

    echo json_encode([
        "success" => true,
        "usuarios" => $data
    ]);
    $con->close();
    exit;
}

function obtenerSubordinadosRecursivos($con, $user_id) {
    $subordinados = [];
    $visitados = [];

    $pendientes = [$user_id];

    while (!empty($pendientes)) {
        $actual = array_pop($pendientes);
        $visitados[] = $actual;

        $sql = "SELECT user_id FROM mobility_solutions.tmx_acceso_usuario WHERE reporta_a = $actual";
        $res = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $sub_id = (int)$row['user_id'];
            if (!in_array($sub_id, $visitados) && !in_array($sub_id, $pendientes)) {
                $subordinados[] = $sub_id;
                $pendientes[] = $sub_id;
            }
        }
    }

    return $subordinados;
}

$sub_ids = obtenerSubordinadosRecursivos($con, $user_id);
if (empty($sub_ids)) {
    echo json_encode([
        "success" => false,
        "message" => "No se encontraron subordinados"
    ]);
    $con->close();
    exit;
}

// Armar lista separada por comas para el IN
$id_list = implode(',', $sub_ids);

$query = "SELECT id, CONCAT(user_name, ' ', last_name) AS nombre_completo 
          FROM mobility_solutions.tmx_usuario 
          WHERE id IN ($id_list)
          ORDER BY nombre_completo ASC";

$result = mysqli_query($con, $query);
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        "id" => (int)$row["id"],
        "nombre" => $row["nombre_completo"]
    ];
} 

echo json_encode([
    "success" => true,
    "usuarios" => $data
]);

$con->close();
