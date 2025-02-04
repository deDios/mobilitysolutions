<?php
header('Content-Type: application/json');

// Verifica si el parámetro 'cod' fue enviado
$cod = isset($_REQUEST['cod']) ? $_REQUEST['cod'] : '';

if (empty($cod)) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

// Incluye la conexión a la base de datos
include "../db/Conexion.php";

// Consulta para obtener los registros de gasto
$query = 'select 
            b.nombre AS proveedor,
            a.objeto AS articulo,
            a.costo
          FROM mobility_solutions.moon_gasto AS a
          LEFT JOIN mobility_solutions.moon_proveedores AS b
          ON a.id_proveedor = b.id
          WHERE b.tipo_proveedor = ?
          and  DATE(a.created_at) = CURDATE()
          order by a.id DESC;';

$stmt = $con->prepare($query);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Error en la consulta']);
    exit;
}

// Vincula el parámetro para evitar inyección SQL
$stmt->bind_param('s', $cod);  // 's' indica que el parámetro es una cadena

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = array();

    while ($row = $result->fetch_assoc()) {
        // Añadir los datos de cada registro de gasto al array
        $row['costo'] = (float)$row['costo']; // Convierte el costo a tipo flotante
        $row['created_at'] = $row['created_at']; // Fecha del registro
        $data[] = $row;
    }

    // Devuelve los datos en formato JSON
    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'No se encontraron registros']);
}

// Cierra la conexión
$stmt->close();
$con->close();
?>
