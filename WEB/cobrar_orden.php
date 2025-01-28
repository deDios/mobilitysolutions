<?php
// Asegurarnos de que el archivo de conexión existe antes de incluirlo
if (file_exists('../db/Conexion_p.php')) {
    include '../db/Conexion_p.php';
} else {
    // Si el archivo no existe, muestra un error y termina la ejecución
    die('Error: No se pudo encontrar el archivo de conexión');
}

// Verificar que la conexión se haya realizado correctamente
if (!$con) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'No se pudo conectar a la base de datos']);
    exit;
}

// Obtener los datos recibidos en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

// Depurar los datos recibidos
error_log(print_r($data, true));

// Verificar que los datos no sean nulos y estén completos
if (!isset($data['productos']) || !is_array($data['productos']) || count($data['productos']) == 0 || 
    !isset($data['id_cliente']) || !isset($data['nombre_cliente'])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos o malformados']);
    exit;
}

// Preparar la sentencia SQL para insertar en la tabla `moon_ventas`
$query = "insert into mobility_solutions.moon_ventas (folio, id_cliente, nombre_cliente, id_producto, producto, cantidad, precio_unitario, total, fecha) 
          values (?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Iniciar una transacción para asegurar la consistencia de los datos
try {
    // Iniciar la transacción
    $con->begin_transaction();

    // Calcular el total de la cuenta sumando el total de cada producto
    $totalCuenta = 0;

    // Insertar cada producto de la venta
    foreach ($data['productos'] as $producto) {
        // Verificar que el producto tenga todos los campos necesarios
        if (!isset($producto['folio'], $producto['id_cliente'], $producto['producto'], $producto['cantidad'], 
                  $producto['precio_unitario'], $producto['total'], $producto['fecha'])) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Producto con datos incompletos']);
            exit;
        }

        // Validar si id_producto existe en la base de datos
        $checkProductQuery = "SELECT id FROM mobility_solutions.moon_product WHERE id = ?";
        $stmt = $con->prepare($checkProductQuery);
        $stmt->bind_param('i', $producto['id_producto']); // Usamos bind_param para el tipo 'i' (entero)
        $stmt->execute();
        
        if ($stmt->get_result()->num_rows == 0) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'El producto con ID ' . $producto['id_producto'] . ' no existe']);
            exit;
        }

        // Asignar los parámetros a la sentencia
        $stmt = $con->prepare($query);
        $stmt->bind_param(
            'sissdssss', 
            $producto['folio'], 
            $data['id_cliente'], 
            $data['nombre_cliente'], 
            $producto['id_producto'], 
            $producto['producto'], 
            $producto['cantidad'], 
            $producto['precio_unitario'], 
            $producto['total'], 
            date('Y-m-d H:i:s', strtotime($producto['fecha'])) // Fecha de la venta
        );

        // Ejecutar la sentencia
        if (!$stmt->execute()) {
            $con->rollback();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar los productos']);
            exit;
        }

        // Sumar el total de cada producto para obtener el total de la cuenta
        $totalCuenta += $producto['total'];
    }

    // Confirmar la transacción si todo ha ido bien
    $con->commit();

    // Responder con éxito, incluyendo el total de la cuenta calculado
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'message' => 'Orden insertada correctamente',
        'total_cuenta' => $totalCuenta // Devolver el total de la cuenta
    ]);
} catch (mysqli_sql_exception $e) {
    // Si ocurre un error en la transacción, revertir cambios
    $con->rollback();
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Error en la transacción: ' . $e->getMessage()]);
}
?>
