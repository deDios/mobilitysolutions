<?php
include "../db/Conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Leer JSON del body
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    $email = filter_var(trim($data["email"]), FILTER_SANITIZE_EMAIL);
    $cumpleanos = $data["cumpleanos"];
    $telefono = trim($data["telefono"]);
    $user_id = intval($data["user_id"]);

    if (!$user_id) {
        http_response_code(400);
        echo "ID de usuario inválido.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Email no válido.";
        exit;
    }

    $sql = "UPDATE mobility_solutions.tmx_usuario SET email = ?, cumpleaños = ?, telefono = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        http_response_code(500);
        echo "Error al preparar la consulta: " . $conn->error;
        exit;
    }

    $stmt->bind_param("sssi", $email, $cumpleanos, $telefono, $user_id);

    if ($stmt->execute()) {
        echo "Perfil actualizado correctamente";
    } else {
        http_response_code(500);
        echo "Error al actualizar: " . $stmt->error;
    }

    $stmt->close();
} else {
    http_response_code(405); // Método no permitido
    echo "Método no permitido.";
}

$conn->close();
?>
