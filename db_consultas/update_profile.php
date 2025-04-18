<?php
require_once '../db/Conexion.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Leer el cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        http_response_code(400);
        echo json_encode(["error" => "Datos JSON inválidos."]);
        exit;
    }

    $email = filter_var(trim($data["email"] ?? ""), FILTER_SANITIZE_EMAIL);
    $cumpleanos = $data["cumpleanos"] ?? "";
    $telefono = trim($data["telefono"] ?? "");
    $user_id = intval($data["user_id"] ?? 0);

    if (!$user_id || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["error" => "Datos incompletos o inválidos."]);
        exit;
    }

    $sql = "UPDATE mobility_solutions.tmx_usuario SET email = ?, cumpleaños = ?, telefono = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["error" => "Error al preparar la consulta."]);
        exit;
    }

    $stmt->bind_param("sssi", $email, $cumpleanos, $telefono, $user_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Perfil actualizado correctamente."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error al actualizar: " . $stmt->error]);
    }

    $stmt->close();
} else {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido."]);
}

$conn->close();
?>
