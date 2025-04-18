<?php
header("Content-Type: application/json");
include "../db/Conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
    exit;
}

// Recibir JSON
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Validar JSON
if (!$data) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Formato JSON inválido."]);
    exit;
}

// Obtener y validar campos
$user_id = isset($data["user_id"]) ? intval($data["user_id"]) : 0;
$email = isset($data["email"]) ? trim($data["email"]) : "";
$cumpleanos = isset($data["cumpleanos"]) ? $data["cumpleanos"] : "";
$telefono = isset($data["telefono"]) ? trim($data["telefono"]) : "";

if (!$user_id || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Parámetros inválidos."]);
    exit;
}

// Preparar consulta
$sql = "UPDATE mobility_solutions.tmx_usuario 
        SET email = ?, cumpleaños = ?, telefono = ? 
        WHERE id = ?";

$stmt = mysqli_prepare($con, $sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error preparando la consulta.", "error" => mysqli_error($con)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "sssi", $email, $cumpleanos, $telefono, $user_id);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    echo json_encode(["success" => true, "message" => "Perfil actualizado correctamente."]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al ejecutar el update.", "error" => mysqli_error($con)]);
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>