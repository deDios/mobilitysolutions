<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

// Verificamos si se proporcionó el parámetro
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

if (!$user_id) {
    echo json_encode([
        "success" => false,
        "message" => "Parámetro 'user_id' es requerido."
    ]);
    exit;
}

// Consulta para obtener tareas asignadas al usuario o creadas por él
$query = "
    SELECT 
        t.id,
        t.nombre,
        t.asignado,
        CONCAT(u_asig.user_name, ' ', u_asig.last_name) AS asignado_nombre,
        t.descripcion,
        t.status,
        t.comentario,
        t.creado_por,
        CONCAT(u_rep.user_name, ' ', u_rep.last_name) AS creado_por_nombre,
        t.created_at,
        t.updated_at
    FROM mobility_solutions.tmx_tareas t
    LEFT JOIN mobility_solutions.tmx_usuario u_asig ON t.asignado = u_asig.id
    LEFT JOIN mobility_solutions.tmx_usuario u_rep ON t.creado_por = u_rep.id
    WHERE t.asignado = ? OR t.creado_por = ?
    ORDER BY t.created_at DESC;
";

$stmt = $con->prepare($query);
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$tareas = [];
while ($row = $result->fetch_assoc()) {
    $tareas[] = $row;
}

echo json_encode([
    "success" => true,
    "tareas" => $tareas
]);

$stmt->close();
$con->close();
?>
