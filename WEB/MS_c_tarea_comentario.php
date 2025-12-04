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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $tarea_id = $_GET['tarea_id'] ?? null;
    $estatus  = $_GET['estatus']  ?? 1;

    if (empty($tarea_id)) {
        echo json_encode([
            'success' => false,
            'message' => 'El parámetro tarea_id es obligatorio.'
        ]);
        exit;
    }

    $tarea_id = (int)$tarea_id;
    $estatus  = (int)$estatus;

    $query = "
        SELECT 
            c.id,
            c.tarea_id,
            c.usuario_id,
            c.comentario,
            c.estatus,
            c.created_at,
            c.updated_at,
            u.user_name,
            u.second_name,
            u.last_name
        FROM mobility_solutions.tmx_tarea_comentario c
        LEFT JOIN mobility_solutions.tmx_usuario u
            ON c.usuario_id = u.id
        WHERE c.tarea_id = $tarea_id
          AND c.estatus = $estatus
        ORDER BY c.created_at ASC
    ";

    $result = mysqli_query($con, $query);

    if (!$result) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al consultar comentarios: ' . mysqli_error($con)
        ]);
        exit;
    }

    $comentarios = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $nombre_completo = trim(
            ($row['user_name'] ?? '') . ' ' .
            ($row['second_name'] ?? '') . ' ' .
            ($row['last_name'] ?? '')
        );

        $comentarios[] = [
            'id'             => (int)$row['id'],
            'tarea_id'       => (int)$row['tarea_id'],
            'usuario_id'     => (int)$row['usuario_id'],
            'comentario'     => $row['comentario'],
            'estatus'        => (int)$row['estatus'],
            'created_at'     => $row['created_at'],
            'updated_at'     => $row['updated_at'],
            'nombre_usuario' => $nombre_completo
        ];
    }

    echo json_encode([
        'success'     => true,
        'tarea_id'    => $tarea_id,
        'total'       => count($comentarios),
        'comentarios' => $comentarios
    ]);

    mysqli_close($con);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}
