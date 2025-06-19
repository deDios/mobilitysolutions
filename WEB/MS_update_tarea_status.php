<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id']) || !isset($data['status'])) {
    echo json_encode([
        "success" => false,
        "message" => "Faltan parámetros requeridos: 'id' y 'status'."
    ]);
    exit;
}

$id = intval($data['id']);
$status = intval($data['status']);
$fecha = date('Y-m-d H:i:s');

$query = "UPDATE mobility_solutions.tmx_tareas 
          SET status = ?, updated_at = ? 
          WHERE id = ?";

$stmt = $con->prepare($query);
$stmt->bind_param("isi", $status, $fecha, $id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Estatus actualizado correctamente."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Error al actualizar el estatus."
    ]);
}

$stmt->close();
$con->close();
?>
