<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: https://mobilitysolutionscorp.com");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

require_once "../db/Conexion.php";

$input = file_get_contents("php://input");
$data  = json_decode($input, true);

if (!$data || !isset($data['user_id']) || !isset($data['new_password'])) {
    echo json_encode([
        "success" => false,
        "message" => "Parámetros incompletos."
    ]);
    exit;
}

$user_id      = (int)$data['user_id'];
$new_password = $data['new_password']; // TEXTO PLANO

// OJO: aquí NO usamos password_hash ni md5, se guarda tal cual
$sql  = "UPDATE mobility_solutions.tmx_acceso_usuario
         SET user_password = ?
         WHERE user_id = ?";

$stmt = $con->prepare($sql);
if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Error al preparar statement."
    ]);
    exit;
}

$stmt->bind_param("si", $new_password, $user_id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Contraseña actualizada correctamente."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Error al actualizar la contraseña."
    ]);
}

$stmt->close();
$con->close();
