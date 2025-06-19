<?php
header('Content-Type: application/json');

$inc = include "../db/Conexion.php";

// Verifica si vienen los datos requeridos vía POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $asignado = $_POST['asignado'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $status = 1; // Por defecto: 1 = Activa / Pendiente

    // Validación básica
    if (empty($nombre) || empty($asignado) || empty($descripcion)) {
        echo json_encode([
            'success' => false,
            'message' => 'Todos los campos son obligatorios.'
        ]);
        exit;
    }

    // Escapar valores
    $nombre = mysqli_real_escape_string($con, $nombre);
    $descripcion = mysqli_real_escape_string($con, $descripcion);
    $asignado = (int)$asignado;

    $query = "INSERT INTO mobility_solutions.tmx_tareas (nombre, asignado, descripcion, status, created_at)
              VALUES ('$nombre', $asignado, '$descripcion', $status, NOW())";

    if (mysqli_query($con, $query)) {
        echo json_encode([
            'success' => true,
            'message' => 'Tarea registrada correctamente.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al guardar la tarea: ' . mysqli_error($con)
        ]);
    }

    mysqli_close($con);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}
?>
