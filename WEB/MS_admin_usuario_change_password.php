<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://mobilitysolutionscorp.com');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

include "../db/Conexion.php";

$input = json_decode(file_get_contents("php://input"), true);

$userId      = isset($input["user_id"])      ? (int)$input["user_id"]      : 0;
$newPassword = isset($input["new_password"]) ? trim($input["new_password"]) : "";

if ($userId <= 0 || $newPassword === "") {
    echo json_encode([
        "success" => false,
        "message" => "Parámetros 'user_id' y 'new_password' son obligatorios."
    ]);
    exit;
}

// Verificar que exista el usuario en tmx_acceso_usuario
$stmt = $con->prepare("
    SELECT id FROM mobility_solutions.tmx_acceso_usuario
    WHERE user_id = ?
    LIMIT 1
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "No se encontró el usuario de acceso."
    ]);
    $stmt->close();
    $con->close();
    exit;
}
$stmt->close();

// Actualizar contraseña
$passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);

$stmt = $con->prepare("
    UPDATE mobility_solutions.tmx_acceso_usuario
       SET user_password = ?,
           updated_at    = NOW()
     WHERE user_id = ?
");
$stmt->bind_param("si", $passwordHash, $userId);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Contraseña actualizada correctamente."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Error al actualizar la contraseña.",
        "error"   => $con->error
    ]);
}

$stmt->close();
$con->close();
