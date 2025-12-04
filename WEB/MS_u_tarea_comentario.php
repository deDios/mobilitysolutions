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

    $id         = $input['id']         ?? null;
    $comentario = $input['comentario'] ?? null;
    $estatus    = $input['estatus']    ?? null;
    $usuario_id = $input['usuario_id'] ?? null; // quien hace el cambio

    if (empty($id)) {
        echo json_encode([
            'success' => false,
            'message' => 'El campo id es obligatorio.'
        ]);
        exit;
    }

    // Validar que haya algo que actualizar
    if ($comentario === null && $estatus === null && $usuario_id === null) {
        echo json_encode([
            'success' => false,
            'message' => 'No hay campos para actualizar.'
        ]);
        exit;
    }

    $id = (int)$id;

    $setParts = [];

    if ($comentario !== null) {
        $comentarioEsc = mysqli_real_escape_string($con, $comentario);
        $setParts[] = "comentario = '$comentarioEsc'";
    }

    if ($estatus !== null) {
        $estatus = (int)$estatus;
        $setParts[] = "estatus = $estatus";
    }

    if ($usuario_id !== null) {
        $usuario_id = (int)$usuario_id;
        $setParts[] = "updated_by = $usuario_id";
    }

    // Siempre actualizamos updated_at
    $setParts[] = "updated_at = NOW()";

    $setClause = implode(", ", $setParts);

    $query = "
        UPDATE mobility_solutions.tmx_tarea_comentario
        SET $setClause
        WHERE id = $id
    ";

    if (mysqli_query($con, $query)) {
        echo json_encode([
            'success' => true,
            'message' => 'Comentario actualizado correctamente.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al actualizar el comentario: ' . mysqli_error($con)
        ]);
    }

    mysqli_close($con);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}
