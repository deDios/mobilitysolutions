<?php
include('../db/Conexion_p.php'); 
$ssl_ca = '../db/db/DigiCertGlobalRootCA.crt.pem';  // El certificado de la autoridad certificadora (CA)

$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, $ssl_ca, NULL, NULL);  // Solo proporcionamos el CA

mysqli_real_connect($conn, $hostname, $username, $password, $database);

if (mysqli_connect_errno()) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión: ' . mysqli_connect_error()]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);  // Asumiendo que los datos se envían como JSON

if (isset($data['id_cliente'], $data['nombre_cliente'], $data['productos']) && is_array($data['productos'])) {
    
    $id_cliente = (int)$data['id_cliente'];  // Asegurarse de que id_cliente es un número entero
    $nombre_cliente = $data['nombre_cliente'];
    
    $productos = $data['productos'];

    mysqli_begin_transaction($conn);

    $query_insert = "insert into moon_ventas (id_cliente, nombre_cliente) VALUES (?, ?)";
    if ($stmt = mysqli_prepare($conn, $query_insert)) {
        mysqli_stmt_bind_param($stmt, "is", $id_cliente, $nombre_cliente);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar la orden']);
            mysqli_rollback($conn);
            exit;
        }
        $orden_id = mysqli_insert_id($conn);  
        mysqli_stmt_close($stmt);
    }

    // Insertar los productos en la base de datos
    $query_producto = "insert into moon_ventas (folio, id_cliente, nombre_cliente, id_producto, producto, cantidad, precio_unitario, sub_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    foreach ($productos as $producto) {
        if (isset($producto['folio'], $producto['producto'], $producto['id_producto'], $producto['cantidad'], $producto['precio_unitario'], $producto['total'])) {
            if ($stmt = mysqli_prepare($conn, $query_producto)) {
                mysqli_stmt_bind_param(
                    $stmt,
                    "sisdiidd",
                    $producto['folio'], // Folio del producto
                    $id_cliente,
                    $nombre_cliente,
                    $producto['id_producto'], // ID del producto en la tabla de productos
                    $producto['producto'], // Nombre del producto
                    $producto['cantidad'], // Cantidad
                    $producto['precio_unitario'], // Precio unitario
                    $producto['total'] // Subtotal
                );
                $result = mysqli_stmt_execute($stmt);
                if (!$result) {
                    echo json_encode(['status' => 'error', 'message' => 'Error al insertar el producto']);
                    mysqli_rollback($conn);
                    exit;
                }
                mysqli_stmt_close($stmt);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Producto con datos incompletos']);
            mysqli_rollback($conn);
            exit;
        }
    }

    // Confirmar la transacción
    if (!mysqli_commit($conn)) {
        echo json_encode(['status' => 'error', 'message' => 'Error al confirmar la transacción']);
        exit;
    }

    // Cerrar la conexión
    mysqli_close($conn);

    // Responder con éxito
    echo json_encode(['status' => 'success', 'message' => 'Orden registrada correctamente']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
}
?>
