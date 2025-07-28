<?php
header('Content-Type: application/json');
session_start();
include "../db/Conexion.php";

// Limpieza segura de valores en sesión
function limpiar_sesion($valor) {
    return (int)trim(str_replace('"', '', $valor));
}

// Validación de sesión
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    echo json_encode([
        "success" => false,
        "message" => "Sesión no válida",
        "session_data" => $_SESSION
    ]);
    exit;
}

$user_id = limpiar_sesion($_SESSION['user_id']);
$user_type = limpiar_sesion($_SESSION['user_type']);

// Validación secundaria
if ($user_id <= 0 || $user_type <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Datos de sesión inválidos",
        "session_data" => $_SESSION
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
        "message" => "No se encontraron usuarios subordinados",
        "query" => $query
    ]);
}

$con->close();
