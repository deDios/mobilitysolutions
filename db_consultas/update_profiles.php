<?php
// Conexión a la base de datos
require_once '../db/Conexion.php'; // Asegúrate que este archivo establece correctamente $conn

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $cumpleanos = $_POST["cumpleanos"];
    $telefono = trim($_POST["telefono"]);
    $user_id = intval($_POST["user_id"]); // Asegura que es un número

    if (!$user_id) {
        die("ID de usuario inválido.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email no válido.");
    }

    $sql = "UPDATE mobility_solutions.tmx_usuario SET email = ?, cumpleaños = ?, telefono = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("sssi", $email, $cumpleanos, $telefono, $user_id);

    if ($stmt->execute()) {
        header("Location: perfil.php?mensaje=Perfil actualizado correctamente");
        exit;
    } else {
        echo "Error al actualizar: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Método no permitido.";
}

$conn->close();
?>