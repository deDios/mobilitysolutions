<?php
header('Content-Type: application/json');

// Verifica si los parámetros fueron enviados
$codigo_admin = isset($_REQUEST['codigo_admin']) ? $_REQUEST['codigo_admin'] : '';
$company_id = isset($_REQUEST['company_id']) ? $_REQUEST['company_id'] : '';

if (empty($codigo_admin) || empty($company_id)) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

// Incluye la conexión a la base de datos
include "../db/Conexion.php";

// Consulta SQL
$query = 'SELECT id, Nombre, user_name 
          FROM mobility_solutions.moon_user 
          WHERE Status = 1 
          AND admin_code = ? 
          AND id_company = ?';

$stmt = $con->prepare($query);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Error en la consulta']);
    exit;
}

// Vincula los parámetros para evitar inyección SQL
$stmt->bind_param('si', $codigo_admin, $company_id); // 's' para string, 'i' para integer

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['success' => true, 'data' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => 'Código incorrecto']);
}

// Cierra la conexión
$stmt->close();
$con->close();
?>
