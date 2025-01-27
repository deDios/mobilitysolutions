<?php

// Incluir el archivo de conexión a la base de datos
$inc = include "../db/Conexion.php";

// Verificar que la conexión se haya realizado correctamente
if (!$inc) {
    echo json_encode(['status' => 'error', 'message' => 'No se pudo conectar a la base de datos']);
    exit;
}

// Obtener los datos recibidos en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

// Verificar que los datos recibidos no sean nulos y que tengan los campos esenciales
if (!isset($data['nombre_cliente']) || !isset($data['total_cuenta']) || !isset($data['id_cliente']) || 
    !isset($data['productos']) || !is_array($data['productos']) || count($data['productos']) == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos o malformados']);
    exit;
}

// Validar que cada producto tenga los campos necesarios
foreach ($data['productos'] as $producto) {
    if (!isset($producto['producto']) || !isset($producto['folio']) || !isset($producto['precio_unitario']) || 
        !isset($producto['cantidad']) || !isset($producto['total']) || !isset($producto['fecha'])) {
        echo json_encode(['status' => 'error', 'message' => 'Producto incompleto']);
        exit;
    }
}

// Preparar la sentencia SQL para insertar en la tabla `moon_ventas`
$query = "insert into moon_ventas (folio, id_cliente, nombre_cliente, id_producto, producto, cantidad, precio_unitario, total, fecha) 
          values (:folio, :id_cliente, :nombre_cliente, :id_producto, :producto, :cantidad, :precio_unitario, :total, :fecha)";

// Iniciar una transacción para asegurar la consistencia de los datos
try {
    $inc->beginTransaction();
    
    // Insertar cada producto de la venta
    foreach ($data['productos'] as $producto) {
        // Verificar que el ID del producto exista (esto depende de tu modelo de datos, asegúrate de que se esté pasando un ID válido)
        $id_producto = obtenerIdProducto($producto['producto']); // Esta función debe buscar el ID del producto en tu base de datos

        // Si no se encuentra el producto, terminamos la transacción y damos un error
        if (!$id_producto) {
            $inc->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Producto no encontrado']);
            exit;
        }

        // Asignar los parámetros a la sentencia
        $stmt = $inc->prepare($query);
        $stmt->bindParam(':folio', $producto['folio']);
        $stmt->bindParam(':id_cliente', $data['id_cliente']);
        $stmt->bindParam(':nombre_cliente', $data['nombre_cliente']);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':producto', $producto['producto']);
        $stmt->bindParam(':cantidad', $producto['cantidad']);
        $stmt->bindParam(':precio_unitario', $producto['precio_unitario']);
        $stmt->bindParam(':total', $producto['total']);
        $stmt->bindParam(':fecha', date('Y-m-d H:i:s', strtotime($producto['fecha']))); // Convertir la fecha al formato adecuado

        // Ejecutar la sentencia
        if (!$stmt->execute()) {
            // Si hay un error en la ejecución, se hace un rollback
            $inc->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar los productos']);
            exit;
        }
    }

    // Si todos los productos fueron insertados correctamente, se confirma la transacción
    $inc->commit();

    // Respuesta de éxito
    echo json_encode(['status' => 'success', 'message' => 'Orden insertada correctamente']);
} catch (PDOException $e) {
    // Si ocurre un error en la transacción, se hace un rollback y se captura el error
    $inc->rollBack();
    echo json_encode(['status' => 'error', 'message' => 'Error en la transacción: ' . $e->getMessage()]);
}

// Función para obtener el ID del producto a partir del nombre
function obtenerIdProducto($nombre_producto) {
    global $inc;
    
    // Suponiendo que tienes una tabla 'productos' donde se almacenan los productos
    $stmt = $inc->prepare("SELECT id FROM productos WHERE nombre = :nombre_producto");
    $stmt->bindParam(':nombre_producto', $nombre_producto);
    
    if ($stmt->execute()) {
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['id'] : null; // Retorna el ID del producto o null si no se encuentra
    }
    return null;
}

?>
