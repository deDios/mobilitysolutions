<?php
header('Content-Type: application/json');

include 'conexion.php'; // tu conexión a la base de datos

$telefono = $_GET['telefono'] ?? '';

if (!$telefono) {
    echo json_encode(['error' => 'Teléfono no proporcionado']);
    exit;
}

$query = "SELECT COUNT(*) as total FROM clientes WHERE telefono = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $telefono);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$existe = $result['total'] > 0;

echo json_encode(['existe' => $existe]);
?>
