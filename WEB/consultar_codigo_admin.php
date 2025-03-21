<?php
header('Content-Type: application/json');

// Lee el cuerpo JSON de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Verifica si los parámetros fueron enviados
$codigo_admin = isset($data['codigo_admin']) ? intval($data['codigo_admin']) : 0;
$company_id = isset($data['company_id']) ? intval($data['company_id']) : 0;

// Depuración: Muestra los parámetros recibidos
error_log("Codigo Admin: " . $codigo_admin);
error_log("Company ID: " . $company_id);

// Verifica que los datos no estén vacíos
if ($codigo_admin === 0 || $company_id === 0) {
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
$stmt->bind_param('ii', $codigo_admin, $company_id); // 'ii' porque ambos son enteros

$stmt->execute();
$result = $stmt->get_result();

// Verifica si se encontró un resultado
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
