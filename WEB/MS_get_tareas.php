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
    SELECT id, nombre, asignado, descripcion, status, comentario, creado_por, created_at, updated_at
    FROM mobility_solutions.tmx_tareas
    WHERE asignado = ? OR creado_por = ?
    ORDER BY status ASC, created_at DESC
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
