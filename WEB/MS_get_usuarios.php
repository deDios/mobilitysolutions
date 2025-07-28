<?php
session_start(); // Activar la sesión
header('Content-Type: application/json');

$inc = include "../db/Conexion.php";

if (!$con) {
    echo json_encode(["error" => "No se pudo conectar a la base de datos"]);
    exit;
}

// Validar sesión
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    echo json_encode([]);
    exit;
}

$user_id = intval($_SESSION['user_id']);
$user_type = intval($_SESSION['user_type']);

$data = [];

if ($user_type === 5 || $user_type === 6) {
    // CTO o CEO pueden ver a todos
    $query = "SELECT id, CONCAT(user_name, ' ', last_name) AS nombre_completo 
              FROM mobility_solutions.tmx_usuario 
              ORDER BY nombre_completo ASC";
} else {
    // Otros usuarios solo ven a los que les reportan directamente
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

if ($result && mysqli_num_rows($result) > 0) {
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


