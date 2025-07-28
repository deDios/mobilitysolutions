<?php
header('Content-Type: application/json');
session_start(); // Asegura que se active la sesión

$inc = include "../db/Conexion.php";

// Depuración: mostrar contenido de la sesión
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    echo json_encode([
        "success" => false,
        "message" => "Sesión no válida",
        "session_data" => $_SESSION
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

// Si es CTO o CEO
if ($user_type == 5 || $user_type == 6) {
    $query = "SELECT id, CONCAT(user_name, ' ', last_name) AS nombre_completo 
              FROM mobility_solutions.tmx_usuario 
              ORDER BY nombre_completo ASC";
} else {
    // Solo usuarios subordinados
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
}

echo json_encode([
    "success" => true,
    "usuarios" => $data
]);

$con->close();
?>
