<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

// Obtener datos del cuerpo del POST (formato JSON)
$input = json_decode(file_get_contents("php://input"), true);

// Validar que se mandaron user_id y user_type
if (!isset($input['user_id']) || !isset($input['user_type'])) {
    echo json_encode([
        "success" => false,
        "message" => "Faltan parámetros obligatorios"
    ]);
    exit;
}

$user_id = (int) $input['user_id'];
$user_type = (int) $input['user_type'];

if ($user_id <= 0 || $user_type <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Parámetros inválidos"
    ]);
    exit;
}

// Si es CTO o CEO, mostrar todos
if ($user_type === 5 || $user_type === 6) {
    $query = "SELECT id, CONCAT(user_name, ' ', last_name) AS nombre_completo 
              FROM mobility_solutions.tmx_usuario 
              ORDER BY nombre_completo ASC";
} else {
    // Mostrar solo subordinados directos
    $query = "SELECT id, CONCAT(user_name, ' ', last_name) AS nombre_completo 
              FROM mobility_solutions.tmx_usuario 
              WHERE id IN (
                  SELECT user_id
                  FROM mobility_solutions.tmx_acceso_usuario
                  WHERE reporta_a = $user_id
              )
              ORDER BY nombre_completo ASC";
}

$result = mysqli_query($con, $query);
$data = [];

if ($result && $result->num_rows > 0) {
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
} else {
    echo json_encode([
        "success" => false,
        "message" => "No se encontraron usuarios",
        "query" => $query
    ]);
}

$con->close();
