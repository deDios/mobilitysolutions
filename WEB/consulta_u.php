<?php
header('Content-Type: application/json');

$user = isset($_REQUEST['cod']) ? $_REQUEST['cod'] : '';
$pass = isset($_REQUEST['pas']) ? $_REQUEST['pas'] : '';

if (empty($user) || empty($pass)) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

include "../db/Conexion.php";

$query = 'select 
            id,
            Nombre, 
            user_name, 
            password_name, 
            Status 
        FROM mobility_solutions.moon_user
        WHERE user_name = ? 
        AND password_name = ? 
        AND status = 1';

$stmt = $con->prepare($query);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Error en la consulta']);
    exit;
}

$stmt->bind_param('ss', $user, $pass); // 'ss' indica que ambos parámetros son cadenas

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $row['Status'] = (int)$row['Status']; // Convierte 'Status' a entero
        $data[] = $row;
    }

    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
}

// Cerrar la conexión
$stmt->close();
$con->close();
?>
