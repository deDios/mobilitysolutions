<?php
header('Content-Type: application/json');

// Incluir la conexión a la base de datos
$inc = include "../db/Conexion.php";

if (!$inc) {
    echo json_encode(["error" => "Error al conectar a la base de datos"]);
    exit;
}

// Manejar solicitudes GET para obtener proveedores
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $cod = isset($_GET['cod']) ? intval($_GET['cod']) : 0;

    $query = 'select id, Nombre, tipo_proveedor, Status 
              FROM mobility_solutions.moon_proveedores
              WHERE tipo_proveedor = ? AND Status = 1
              ORDER BY Nombre ASC';

    $stmt = $con->prepare($query);

    if (!$stmt) {
        echo json_encode(["error" => "Error en la preparación de la consulta: " . $con->error]);
        exit;
    }

    $stmt->bind_param("i", $cod);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        echo json_encode(["error" => "Error en la consulta: " . $con->error]);
        exit;
    }

    if ($result->num_rows > 0) {
        $data = array();
        
        while ($row = $result->fetch_assoc()) {
            $row['id'] = (int)$row['id'];
            $row['tipo_proveedor'] = (int)$row['tipo_proveedor'];
            $row['Status'] = (int)$row['Status'];
            
            $data[] = $row;
        }

        echo json_encode($data);
    } else {
        echo json_encode(["mensaje" => "No se encontraron proveedores"]);
    }

    $stmt->close();
}

// Manejar solicitudes POST para guardar gastos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del cuerpo de la solicitud
    $input = json_decode(file_get_contents('php://input'), true);

    // Validar los datos recibidos
    if (!isset($input['id_proveedor']) || !isset($input['objeto']) || !isset($input['costo'])) {
        echo json_encode(["error" => "Datos incompletos"]);
        exit;
    }

    $id_proveedor = intval($input['id_proveedor']);
    $objeto = trim($input['objeto']);
    $costo = floatval($input['costo']);

    if ($id_proveedor <= 0 || empty($objeto) || $costo <= 0) {
        echo json_encode(["error" => "Datos inválidos"]);
        exit;
    }

    // Insertar el gasto en la tabla moon_gasto
    $query = 'insert INTO mobility_solutions.moon_gasto (id_proveedor, objeto, costo) 
              VALUES (?, ?, ?)';

    $stmt = $con->prepare($query);

    if (!$stmt) {
        echo json_encode(["error" => "Error en la preparación de la consulta: " . $con->error]);
        exit;
    }

    $stmt->bind_param("isd", $id_proveedor, $objeto, $costo); // "isd" = int, string, double
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["mensaje" => "Gasto guardado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al guardar el gasto: " . $stmt->error]);
    }

    $stmt->close();
}

// Cerrar la conexión
$con->close();
?>