<?php
// Incluir el archivo de conexión a la base de datos
$inc = include "../db/Conexion.php";

// Verificar que la conexión se haya realizado correctamente
if (!$inc) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'No se pudo conectar a la base de datos']);
    exit;
}

// Obtener los datos recibidos en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

// Depurar los datos recibidos (esto ayudará a identificar problemas con los datos)
error_log(print_r($data, true));

// Verificar que los datos no sean nulos y estén completos
if (!isset($data['productos']) || !is_array($data['productos']) || count($data['productos']) == 0 || 
    !isset($data['total_cuenta']) || !isset($data['id_cliente']) || !isset($data['nombre_cliente'])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos o malformados']);
    exit;
}

// Preparar la sentencia SQL para insertar en la tabla `moon_ventas`
$query = "insert into moon_ventas (folio, id_cliente, nombre_cliente, id_producto, producto, cantidad, precio_unitario, total, fecha) 
          values (:folio, :id_cliente, :nombre_cliente, :id_producto, :producto, :cantidad, :precio_unitario, :total, :fecha)";

// Iniciar una transacción para asegurar la consistencia de los datos
try {
    $inc->beginTransaction();
    
    // Insertar cada producto de la venta
    foreach ($data['productos'] as $producto) {
        // Verificar que el producto tenga todos los campos necesarios
        if (!isset($producto['folio'], $producto['id_cliente'], $producto['producto'], $producto['cantidad'], 
                  $producto['precio_unitario'], $producto['total'], $producto['fecha'])) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Producto con datos incompletos']);
            exit;
        }

        // Validar si id_producto existe en la base de datos (esto asumiendo que la tabla moon_product tiene los productos)
        $checkProductQuery = "SELECT id FROM moon_product WHERE id = :id_producto";
        $stmt = $inc->prepare($checkProductQuery);
        $stmt->bindParam(':id_producto', $producto['id_producto']);
        $stmt->execute();
        
        if ($stmt->rowCount() == 0) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'El producto con ID ' . $producto['id_producto'] . ' no existe']);
            exit;
        }

        // Asignar los parámetros a la sentencia
        $stmt = $inc->prepare($query);
        $stmt->bindParam(':folio', $producto['folio']);
        $stmt->bindParam(':id_cliente', $data['id_cliente']);
        $stmt->bindParam(':nombre_cliente', $data['nombre_cliente']);
        $stmt->bindParam(':id_producto', $producto['id_producto']);
        $stmt->bindParam(':producto', $producto['producto']);
        $stmt->bindParam(':cantidad', $producto['cantidad']);
        $stmt->bindParam(':precio_unitario', $producto['precio_unitario']);
        $stmt->bindParam(':total', $producto['total']);
        $stmt->bindParam(':fecha', date('Y-m-d H:i:s', strtotime($producto['fecha']))); // Fecha actual
        
        // Ejecutar la sentencia
        if (!$stmt->execute()) {
            $inc->rollBack();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar los productos']);
            exit;
        }
    }

    // Confirmar la transacción si todo ha ido bien
    $inc->commit();

    // Responder con éxito
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Orden insertada correctamente']);
} catch (PDOException $e) {
    // Si ocurre un error en la transacción, revertir cambios
    $inc->rollBack();
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Error en la transacción: ' . $e->getMessage()]);
}
?>
