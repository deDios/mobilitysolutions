<?php
include "../db/Conexion.php";

header('Content-Type: application/json');

// Asegúrate de que se recibe el user_id vía POST (recomendado)
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

if ($user_id > 0) {
    // Consulta SQL con filtrado por estatus = 2 y created_by
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
} else {
    echo json_encode(["error" => "user_id no válido"]);
}
?>
