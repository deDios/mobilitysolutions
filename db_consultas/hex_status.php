<?php
include "../db/Conexion.php";

header('Content-Type: application/json');

// Validación estricta para user_id como entero
$user_id = filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT);

if ($user_id === false || $user_id === null) {
    echo json_encode(["error" => "user_id no válido"]);
    exit;
}

$sql = "SELECT 
            COUNT(CASE WHEN tipo = 'Nuevo' THEN 1 END) as nuevo,
            COUNT(CASE WHEN tipo = 'Reserva' THEN 1 END) as reserva,
            COUNT(CASE WHEN tipo = 'Entrega' THEN 1 END) as entrega
        FROM tmx_servicio
        WHERE estatus = 2 AND created_by = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$data = $result->fetch_assoc();
echo json_encode($data);
?>


