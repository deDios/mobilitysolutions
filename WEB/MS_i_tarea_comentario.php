<?php
header('Content-Type: application/json; charset=utf-8');
$inc = include "../db/Conexion.php";

if (!$inc || !$con) {
    echo json_encode([
        'success' => false,
        'message' => 'Error de conexión a la base de datos.'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $tarea_id   = $input['tarea_id']   ?? null;
    $usuario_id = $input['usuario_id'] ?? null;
    $comentario = $input['comentario'] ?? '';
    // si no mandan created_by, usamos usuario_id
    $created_by = $input['created_by'] ?? $usuario_id;

    if (empty($tarea_id) || empty($usuario_id) || trim($comentario) === '') {
        echo json_encode([
            'success' => false,
            'message' => 'tarea_id, usuario_id y comentario son obligatorios.'
        ]);
        exit;
    }

    $tarea_id   = (int)$tarea_id;
    $usuario_id = (int)$usuario_id;
    $created_by = $created_by !== null ? (int)$created_by : 'NULL';
    $comentario = mysqli_real_escape_string($con, $comentario);

    $query = "
        INSERT INTO mobility_solutions.tmx_tarea_comentario
            (tarea_id, usuario_id, comentario, estatus, created_by, created_at)
        VALUES
            ($tarea_id, $usuario_id, '$comentario', 1, $created_by, NOW())
    ";

    if (mysqli_query($con, $query)) {
        echo json_encode([
            'success' => true,
            'message' => 'Comentario registrado correctamente.',
            'id'      => mysqli_insert_id($con)
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al guardar el comentario: ' . mysqli_error($con)
        ]);
    }

    mysqli_close($con);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}
