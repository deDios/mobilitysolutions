<?php
// Incluyendo el archivo de conexión con la base de datos (ajustar la ruta según corresponda)
include('/home/site/wwwroot/db/Conexion.php');  // Cambia esta ruta si no es correcta

// Obtener los datos JSON de la solicitud
$data = json_decode(file_get_contents('php://input'), true);  // Esta es la forma correcta de obtener el cuerpo de la solicitud

if (isset($data['id_cliente'], $data['nombre_cliente'], $data['productos']) && is_array($data['productos'])) {
    
    // Variables recibidas del JSON
    $id_cliente = (int)$data['id_cliente'];  // Asegurarse de que id_cliente es un número entero
    $nombre_cliente = $data['nombre_cliente'];
    $productos = $data['productos'];

    // Iniciar una transacción en la base de datos
    mysqli_begin_transaction($con);

    // Insertar la orden en la tabla moon_ventas
    $query_insert = "insert into moon_ventas (id_cliente, nombre_cliente) VALUES (?, ?)";
    if ($stmt = mysqli_prepare($con, $query_insert)) {
        mysqli_stmt_bind_param($stmt, "is", $id_cliente, $nombre_cliente);
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar la orden']);
            mysqli_rollback($con);
            exit;
        }

        // Obtener el ID de la orden insertada
        $orden_id = mysqli_insert_id($con);
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta de orden']);
        exit;
    }

    // Insertar los productos en la tabla moon_ventas
    $query_producto = "insert into moon_ventas (folio, id_cliente, nombre_cliente, id_producto, producto, cantidad, precio_unitario, sub_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    foreach ($productos as $producto) {
        if (isset($producto['producto'], $producto['id_producto'], $producto['cantidad'], $producto['precio_unitario'], $producto['total'])) {
            
            // Si el folio no se envió, generar un folio único
            if (empty($producto['folio'])) {
                $producto['folio'] = uniqid('FOLIO_');  // Genera un folio único si no se proporciona
            }

            // Preparar la consulta para insertar el producto
            if ($stmt = mysqli_prepare($con, $query_producto)) {
                // Vincular parámetros
                mysqli_stmt_bind_param(
                    $stmt,
                    "sisdiidd",
                    $producto['folio'],  // Folio del producto
                    $id_cliente,
                    $nombre_cliente,
                    $producto['id_producto'],  // ID del producto en la tabla de productos
                    $producto['producto'],     // Nombre del producto
                    $producto['cantidad'],     // Cantidad
                    $producto['precio_unitario'],  // Precio unitario
                    $producto['total']  // Subtotal
                );

                // Ejecutar la consulta
                $result = mysqli_stmt_execute($stmt);
                if (!$result) {
                    echo json_encode(['status' => 'error', 'message' => 'Error al insertar el producto']);
                    mysqli_rollback($con);
                    exit;
                }

                // Cerrar la declaración
                mysqli_stmt_close($stmt);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta de inserción de producto']);
                mysqli_rollback($con);
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Producto con datos incompletos']);
            mysqli_rollback($con);
            exit;
        }
    }

    // Confirmar la transacción
    if (!mysqli_commit($con)) {
        echo json_encode(['status' => 'error', 'message' => 'Error al confirmar la transacción']);
        exit;
    }

    // Cerrar la conexión
    mysqli_close($con);

    // Responder con éxito
    echo json_encode(['status' => 'success', 'message' => 'Orden registrada correctamente']);
} else {
    // Si los datos recibidos son incorrectos
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
}
?>
