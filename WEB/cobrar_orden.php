<?php
// Incluir el archivo de conexión a la base de datos
$inc = include "../db/Conexion.php";

// Verificar que la conexión se haya realizado correctamente
if (!$inc) {
    // Responder con un error JSON si la conexión a la base de datos falla
    echo json_encode(['status' => 'error', 'message' => 'No se pudo conectar a la base de datos']);
    exit;
}

// Obtener los datos recibidos en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

// Verificar que los datos recibidos no sean nulos o incompletos
if (!isset($data['productos']) || !is_array($data['productos']) || count($data['productos']) == 0 ||
    !isset($data['id_cliente']) || !isset($data['nombre_cliente']) || !isset($data['total_cuenta'])) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos o malformados']);
    exit;
}

// Preparar la sentencia SQL para insertar en la tabla `moon_ventas`
$query = "INSERT INTO moon_ventas (folio, id_cliente, nombre_cliente, id_producto, producto, cantidad, precio_unitario, total, fecha) 
          VALUES (:folio, :id_cliente, :nombre_cliente, :id_producto, :producto, :cantidad, :precio_unitario, :total, :fecha)";

try {
    // Iniciar una transacción para asegurar la consistencia de los datos
    $inc->beginTransaction();

    // Iterar a través de los productos recibidos
    foreach ($data['productos'] as $producto) {
        // Validar si los parámetros necesarios están presentes en cada producto
        if (!isset($producto['folio']) || !isset($producto['id_cliente']) || !isset($producto['producto']) || 
            !isset($producto['cantidad']) || !isset($producto['precio_unitario']) || !isset($producto['total']) || 
            !isset($producto['fecha'])) {
            echo json_encode(['status' => 'error', 'message' => 'Datos del producto incompletos']);
            exit;
        }

        // Preparar la sentencia con los valores del producto actual
        $stmt = $inc->prepare($query);
        $stmt->bindParam(':folio', $producto['folio']);
        $stmt->bindParam(':id_cliente', $producto['id_cliente']);
        $stmt->bindParam(':nombre_cliente', $data['nombre_cliente']);  // Usar nombre_cliente de los datos principales
        $stmt->bindParam(':id_producto', $producto['id_producto']);
        $stmt->bindParam(':producto', $producto['producto']);
        $stmt->bindParam(':cantidad', $producto['cantidad']);
        $stmt->bindParam(':precio_unitario', $producto['precio_unitario']);
        $stmt->bindParam(':total', $producto['total']);
        $stmt->bindParam(':fecha', $producto['fecha']);  // Fecha específica del producto

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
?>
