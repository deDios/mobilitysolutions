<?php
// Conexión a la base de datos
require_once '../db/Conexion.php'; // Asegúrate que este archivo establece correctamente $conn

// Validar que los datos han sido enviados
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitizar entradas
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $cumpleanos = $_POST["cumpleanos"];
    $telefono = trim($_POST["telefono"]);

    // Puedes obtener el ID del usuario desde la sesión o como un input oculto en el formulario
    session_start();
    $user_id = $_SESSION["user_id"] ?? null;

    if (!$user_id) {
        die("ID de usuario no válido.");
    }

    // Validar datos
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email no válido.");
    }

    // Preparar consulta
    $sql = "UPDATE usuarios SET email = ?, cumpleaños = ?, telefono = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("sssi", $email, $cumpleanos, $telefono, $user_id);

    if ($stmt->execute()) {
        // Redirigir a la página del perfil (puedes cambiar la ruta)
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
