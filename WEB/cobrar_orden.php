<?php
include('/home/site/wwwroot/db/Conexion.php');  
$data = json_decode(file_get_contents('php://input'), true);  

if (isset($data['id_cliente'], $data['nombre_cliente'], $data['productos']) && is_array($data['productos'])) {
    
    $id_cliente = (int)$data['id_cliente'];  // Asegurarse de que id_cliente es un número entero
    $nombre_cliente = $data['nombre_cliente'];
    $productos = $data['productos'];

    mysqli_begin_transaction($con);

    $query_insert = "insert into moon_ventas (id_cliente, nombre_cliente) VALUES (?, ?)";
    if ($stmt = mysqli_prepare($con, $query_insert)) {
        mysqli_stmt_bind_param($stmt, "is", $id_cliente, $nombre_cliente);
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar la orden']);
            mysqli_rollback($con);
            exit;
        }

        $orden_id = mysqli_insert_id($con);
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta de orden']);
        exit;
    }

    $query_producto = "insert into moon_ventas (folio, id_cliente, nombre_cliente, id_producto, producto, cantidad, precio_unitario, sub_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    foreach ($productos as $producto) {
        if (isset($producto['id_producto'], $producto['producto'], $producto['cantidad'], $producto['precio_unitario'], $producto['total'])) {
            
            if (empty($producto['folio'])) {
                $producto['folio'] = uniqid('FOLIO_');
            }

            if ($stmt = mysqli_prepare($con, $query_producto)) {
                mysqli_stmt_bind_param(
                    $stmt,
                    "sisdiidd",
                    $producto['folio'],  // Folio del producto
                    $id_cliente,
                    $nombre_cliente,
                    $producto['id_producto'], // ID del producto
                    $producto['producto'], // Nombre del producto
                    $producto['cantidad'], // Cantidad
                    $producto['precio_unitario'], // Precio unitario
                    $producto['total'] // Subtotal
                );
                $result = mysqli_stmt_execute($stmt);
                if (!$result) {
                    echo json_encode(['status' => 'error', 'message' => 'Error al insertar el producto']);
                    mysqli_rollback($con);
                    exit;
                }
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
    if (!mysqli_commit($con)) {
        echo json_encode(['status' => 'error', 'message' => 'Error al confirmar la transacción']);
        exit;
    }
    mysqli_close($con);

    echo json_encode(['status' => 'success', 'message' => 'Orden registrada correctamente']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
}
?>
