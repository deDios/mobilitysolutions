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
    $query_insert = "insert into mobility_solutions.moon_ventas (id_cliente, nombre_cliente) VALUES (?, ?)";
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
    $query_producto = "insert into mobility_solutions.moon_ventas (folio, id_cliente, nombre_cliente, id_producto, producto, cantidad, precio_unitario, sub_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    foreach ($productos as $producto) {
        // Depuración: Mostrar los valores que estamos intentando insertar
        var_dump($producto['folio'], $producto['id_producto'], $producto['producto'], $producto['cantidad'], $producto['precio_unitario'], $producto['total']);
        
        // Verificar que el producto contiene los datos necesarios
        if (isset($producto['id_producto'], $producto['producto'], $producto['cantidad'], $producto['precio_unitario'], $producto['total'])) {
            
            // Comprobamos si el id_producto es válido y mayor que 0
            $id_producto = (int)$producto['id_producto'];
            if ($id_producto <= 0) {
                echo json_encode(['status' => 'error', 'message' => 'El id_producto no es válido o es menor que 1']);
                mysqli_rollback($con);
                exit;
            }

            // Verificamos que el producto y la cantidad sean correctos
            $producto_nombre = $producto['producto'];
            $cantidad = (int)$producto['cantidad'];
            $precio_unitario = (float)$producto['precio_unitario'];
            $sub_total = (float)$producto['total'];

            // Verificación de precios y subtotales
            if ($precio_unitario <= 0) {
                echo json_encode(['status' => 'error', 'message' => 'El precio unitario debe ser mayor que 0']);
                mysqli_rollback($con);
                exit;
            }

            if ($sub_total <= 0) {
                echo json_encode(['status' => 'error', 'message' => 'El subtotal debe ser mayor que 0']);
                mysqli_rollback($con);
                exit;
            }

            // Ejecutar la consulta de inserción de producto
            if ($stmt = mysqli_prepare($con, $query_producto)) {
                mysqli_stmt_bind_param(
                    $stmt,
                    "sisisidd", // Tipos de datos para los parámetros
                    $producto['folio'],
                    $id_cliente,
                    $nombre_cliente,
                    $id_producto,
                    $producto_nombre,
                    $cantidad,
                    $precio_unitario,
                    $sub_total
                );

                // Ejecutar la consulta
                $result = mysqli_stmt_execute($stmt);
                if (!$result) {
                    echo json_encode(['status' => 'error', 'message' => 'Error al insertar el producto: ' . mysqli_error($con)]);
                    mysqli_rollback($con);
                    exit;
                }

                mysqli_stmt_close($stmt);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta']);
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
