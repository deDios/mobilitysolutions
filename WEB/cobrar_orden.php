<?php
include('../db/Conexion_p.php'); 
$ssl_ca = '../db/db/DigiCertGlobalRootCA.crt.pem';  // Asegúrate de que esta ruta sea correcta

// Conexión SSL
$con = mysqli_init();
mysqli_ssl_set($con, NULL, NULL, $ssl_ca, NULL, NULL);  // Aquí solo se pasa el CA
mysqli_real_connect($con, "mobilitysolutions-server.mysql.database.azure.com", "btdonyajwn", "Llaverito_4855797'?", "mobility_solutions", 3306, MYSQLI_CLIENT_SSL);

if (mysqli_connect_errno()) {
    die(json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos: ' . mysqli_connect_error()]));
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id_cliente'], $data['nombre_cliente'], $data['productos']) && is_array($data['productos'])) {
    
    $id_cliente = (int)$data['id_cliente'];  
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
    }

    $query_producto = "insert into moon_ventas (folio, id_cliente, nombre_cliente, id_producto, producto, cantidad, precio_unitario, sub_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    foreach ($productos as $producto) {
        if (isset($producto['folio'], $producto['producto'], $producto['id_producto'], $producto['cantidad'], $producto['precio_unitario'], $producto['total'])) {
            
            if ($stmt = mysqli_prepare($con, $query_producto)) {
                mysqli_stmt_bind_param(
                    $stmt,
                    "sisdiidd",
                    $producto['folio'], // Folio del producto
                    $id_cliente,
                    $nombre_cliente,
                    $producto['id_producto'], // ID del producto
                    $producto['producto'], // Nombre del producto
                    $producto['cantidad'], // Cantidad del producto
                    $producto['precio_unitario'], // Precio unitario
                    $producto['total'] // Subtotal
                );
                
                $result = mysqli_stmt_execute($stmt);
                
                if (!$result) {
                    echo json_encode(['status' => 'error', 'message' => 'Error al insertar el producto']);
                    mysqli_rollback($con);  // Rollback en caso de error
                    exit;
                }
                
                mysqli_stmt_close($stmt);  
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
    } 
    else {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
    }
?>
