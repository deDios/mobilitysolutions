<?php
header('Content-Type: application/json');
$inc = include "../db/Conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $nombre = $input['nombre'] ?? '';
    $asignado = $input['asignado'] ?? '';
    $descripcion = $input['descripcion'] ?? '';
    $creado_por = $input['creado_por'] ?? null;
    $status = 1;

    if (empty($nombre) || empty($asignado) || empty($descripcion) || empty($creado_por)) {
        echo json_encode([
            'success' => false,
            'message' => 'Todos los campos son obligatorios.'
        ]);
        exit;
    }

    $nombre = mysqli_real_escape_string($con, $nombre);
    $descripcion = mysqli_real_escape_string($con, $descripcion);
    $asignado = (int)$asignado;
    $creado_por = (int)$creado_por;

    $query = "INSERT INTO mobility_solutions.tmx_tareas 
              (nombre, asignado, descripcion, status, creado_por, created_at)
              VALUES ('$nombre', $asignado, '$descripcion', $status, $creado_por, NOW())";

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
