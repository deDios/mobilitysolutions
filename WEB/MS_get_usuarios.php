<?php
header('Content-Type: application/json');
$inc = include "../db/Conexion.php";

// Leer parámetros POST
$input = json_decode(file_get_contents("php://input"), true);
$user_id = isset($input['user_id']) ? (int)$input['user_id'] : 0;
$user_type = isset($input['user_type']) ? (int)$input['user_type'] : 0;

$data = [];

if ($user_id === 0 || $user_type === 0) {
    echo json_encode([]);
    exit;
}

// Si es CTO o CEO, devuelve a todos
if ($user_type == 5 || $user_type == 6) {
    $query = "SELECT id, CONCAT(user_name, ' ', last_name) AS nombre_completo 
              FROM mobility_solutions.tmx_usuario 
              ORDER BY nombre_completo ASC";
} else {
    // Recursivamente obtener subordinados
    function obtenerSubordinados($con, $id, &$subordinados = []) {
        $sql = "SELECT user_id FROM mobility_solutions.tmx_acceso_usuario WHERE reporta_a = $id";
        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $sub_id = (int)$row["user_id"];
            if (!in_array($sub_id, $subordinados)) {
                $subordinados[] = $sub_id;
                obtenerSubordinados($con, $sub_id, $subordinados); // llamada recursiva
            }
        }
    }

    $subordinados = [];
    obtenerSubordinados($con, $user_id, $subordinados);

    if (empty($subordinados)) {
        echo json_encode([]);
        exit;
    }

    $ids = implode(",", array_map('intval', $subordinados));
    $query = "SELECT id, CONCAT(user_name, ' ', last_name) AS nombre_completo 
              FROM mobility_solutions.tmx_usuario 
              WHERE id IN ($ids)
              ORDER BY nombre_completo ASC";
}

$result = mysqli_query($con, $query);

if ($result && $result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            "id" => (int)$row["id"],
            "nombre" => $row["nombre_completo"]
        ];
    }
}

echo json_encode($data);
$con->close();
?>
