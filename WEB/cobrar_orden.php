<?php
include('/home/site/wwwroot/db/Conexion.php');  // Cambia esta ruta si no es correcta

$data = json_decode(file_get_contents('php://input'), true);  // Decodificar los datos recibidos en formato JSON

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
        // Verifica que todos los campos necesarios estén presentes
        if (isset($producto['id_producto'], $producto['producto'], $producto['cantidad'], $producto['precio_unitario'], $producto['total'])) {
    
            // Verifica el valor de id_producto
            var_dump($producto['id_producto']);  // Debugging
    
            // Si el folio no se envió, generar un folio único
            if (empty($producto['folio'])) {
                $producto['folio'] = uniqid('FOLIO_');
            }
    
            // Asegurarse de que id_producto esté bien asignado
            $id_producto = (int)$producto['id_producto'];  // Convertir a entero por seguridad
            $producto_nombre = $producto['producto'];
            $cantidad = (int)$producto['cantidad'];
            $precio_unitario = (float)$producto['precio_unitario'];
            $sub_total = (float)$producto['total'];
    
            // Preparar la consulta de inserción de producto
            if ($stmt = mysqli_prepare($con, $query_producto)) {
                // Vincular parámetros
                mysqli_stmt_bind_param(
                    $stmt,
                    "sisdiidd",
                    $producto['folio'],  // Folio del producto
                    $id_cliente,
                    $nombre_cliente,
                    $id_producto, // ID del producto
                    $producto_nombre, // Nombre del producto
                    $cantidad, // Cantidad
                    $precio_unitario, // Precio unitario
                    $sub_total // Subtotal
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
