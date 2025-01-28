<?php
// Incluir la configuración de conexión con la base de datos
include('../db/Conexion_p.php'); 

// Archivo del certificado de la autoridad certificadora (CA)
$ssl_ca = '../db/db/DigiCertGlobalRootCA.crt.pem';  // Asegúrate de que esta ruta sea correcta

// Conexión SSL
$con = mysqli_init();
mysqli_ssl_set($con, NULL, NULL, $ssl_ca, NULL, NULL);  // Aquí solo se pasa el CA
mysqli_real_connect($con, "mobilitysolutions-server.mysql.database.azure.com", "btdonyajwn", "Llaverito_4855797'?", "mobility_solutions", 3306, MYSQLI_CLIENT_SSL);

// Comprobar la conexión
if (mysqli_connect_errno()) {
    die(json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos: ' . mysqli_connect_error()]));
}

// Recibir los datos de la solicitud POST
$data = json_decode(file_get_contents('php://input'), true);

// Verificar que los datos requeridos estén presentes
if (isset($data['id_cliente'], $data['nombre_cliente'], $data['productos']) && is_array($data['productos'])) {
    
    $id_cliente = (int)$data['id_cliente'];  // ID del cliente
    $nombre_cliente = $data['nombre_cliente'];  // Nombre del cliente
    $productos = $data['productos'];  // Productos de la orden

    // Iniciar transacción
    mysqli_begin_transaction($con);

    // Insertar la orden en la tabla moon_ventas
    $query_insert = "INSERT INTO moon_ventas (id_cliente, nombre_cliente) VALUES (?, ?)";
    if ($stmt = mysqli_prepare($con, $query_insert)) {
        mysqli_stmt_bind_param($stmt, "is", $id_cliente, $nombre_cliente);
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar la orden']);
            mysqli_rollback($con);  // Hacer rollback de la transacción en caso de error
            exit;
        }

        // Obtener el ID de la orden recién insertada
        $orden_id = mysqli_insert_id($con);  
        mysqli_stmt_close($stmt);  // Cerrar la sentencia
    }

    // Insertar los productos en la tabla moon_ventas
    $query_producto = "INSERT INTO moon_ventas (folio, id_cliente, nombre_cliente, id_producto, producto, cantidad, precio_unitario, sub_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    foreach ($productos as $producto) {
        // Validar que todos los datos del producto estén presentes
        if (isset($producto['folio'], $producto['producto'], $producto['id_producto'], $producto['cantidad'], $producto['precio_unitario'], $producto['total'])) {
            
            if ($stmt = mysqli_prepare($con, $query_producto)) {
                // Insertar producto en la base de datos
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
                
                mysqli_stmt_close($stmt);  // Cerrar la sentencia
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Producto con datos incompletos']);
            mysqli_rollback($con);  // Rollback en caso de datos incompletos
            exit;
        }
    }

    // Confirmar la transacción
    if (!mysqli_commit($con)) {
        echo json_encode(['status' => 'error', 'message' => 'Error al confirmar la transacción']);
        exit;
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($con);

    // Respuesta exitosa
    echo json_encode(['status' => 'success', 'message' => 'Orden registrada correctamente']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
}
?>
