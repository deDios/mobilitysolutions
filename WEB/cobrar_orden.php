<?php

// Incluir el archivo de conexión a la base de datos
$inc = include "../db/Conexion.php";

// Verificar que la conexión se haya realizado correctamente
if (!$inc) {
    echo json_encode(['status' => 'error', 'message' => 'No se pudo conectar a la base de datos']);
    exit;
}

// Establecer el encabezado de tipo de contenido a JSON
header('Content-Type: application/json');

// Obtener los datos recibidos en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

// Verificar que los datos recibidos no sean nulos o mal formados
if (!isset($data['total_cuenta']) || !isset($data['id_cliente']) || !isset($data['nombre_cliente']) || 
    !isset($data['productos']) || !is_array($data['productos']) || count($data['productos']) == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos o malformados']);
    exit;
}

// Preparar la sentencia SQL para insertar en la tabla `moon_ventas`
$query = "INSERT INTO moon_ventas (folio, id_cliente, nombre_cliente, id_producto, producto, cantidad, precio_unitario, total, fecha) 
          VALUES (:folio, :id_cliente, :nombre_cliente, :id_producto, :producto, :cantidad, :precio_unitario, :total, :fecha)";

// Iniciar una transacción para asegurar la consistencia de los datos
try {
    // Iniciar la transacción
    $inc->beginTransaction();

    // Iterar sobre los productos y registrar cada uno en la base de datos
    foreach ($data['productos'] as $producto) {
        
        // Verificar que todos los campos necesarios para el producto estén presentes
        if (!isset($producto['folio']) || !isset($producto['producto']) || !isset($producto['cantidad']) ||
            !isset($producto['precio_unitario']) || !isset($producto['total'])) {
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos del producto']);
            exit;
        }
        
        // Asignar los parámetros a la sentencia preparada
        $stmt = $inc->prepare($query);
        $stmt->bindParam(':folio', $producto['folio']);
        $stmt->bindParam(':id_cliente', $data['id_cliente']);
        $stmt->bindParam(':nombre_cliente', $data['nombre_cliente']);
        $stmt->bindParam(':id_producto', $producto['id_producto']);
        $stmt->bindParam(':producto', $producto['producto']);
        $stmt->bindParam(':cantidad', $producto['cantidad']);
        $stmt->bindParam(':precio_unitario', $producto['precio_unitario']);
        $stmt->bindParam(':total', $producto['total']);
        $stmt->bindParam(':fecha', date('Y-m-d H:i:s')); // Fecha actual

        // Ejecutar la sentencia
        if (!$stmt->execute()) {
            // Si hay un error en la ejecución, hacer un rollback
            $inc->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar el producto']);
            exit;
        }
    }

    // Si todos los productos fueron insertados correctamente, confirmar la transacción
    $inc->commit();

    // Respuesta de éxito
    echo json_encode(['status' => 'success', 'message' => 'Orden registrada correctamente']);
} catch (PDOException $e) {
    // Si ocurre un error en la transacción, hacer un rollback y capturar el error
    $inc->rollBack();
    echo json_encode(['status' => 'error', 'message' => 'Error en la transacción: ' . $e->getMessage()]);
}

?>
