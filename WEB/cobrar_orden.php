<?php
// Evitar cualquier salida antes de enviar encabezados
ob_start();  // Inicia el buffer de salida, para evitar problemas con los encabezados

include('../db/Conexion_p.php');  // Asegúrate de que la ruta al archivo de conexión sea correcta

// Certificado SSL de la autoridad certificadora (CA)
$ssl_ca = '/home/site/wwwroot/db/DigiCertGlobalRootCA.crt.pem';  // Ruta al certificado SSL

// Conectar a la base de datos usando SSL
$con = mysqli_init();
mysqli_ssl_set($con, NULL, NULL, $ssl_ca, NULL, NULL);  // Establecer SSL para la conexión

// Intentar la conexión con la base de datos
if (!mysqli_real_connect($con, "mobilitysolutions-server.mysql.database.azure.com", "btdonyajwn", "Llaverito_4855797'?", "mobility_solutions", 3306, MYSQLI_CLIENT_SSL)) {
    die('Error: Falla en la conexión a MySQL. ' . mysqli_connect_error());
}

// Leer los datos JSON enviados en el cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Verificar que los datos recibidos son correctos
if (isset($data['id_cliente'], $data['nombre_cliente'], $data['productos']) && is_array($data['productos'])) {

    // Asignar los valores de los datos
    $id_cliente = (int)$data['id_cliente'];  // Asegurarse de que id_cliente es un número entero
    $nombre_cliente = $data['nombre_cliente'];
    
    // Obtener los productos
    $productos = $data['productos'];

    // Iniciar transacción para asegurar la integridad de los datos
    mysqli_begin_transaction($con);

    // Insertar una nueva orden en la tabla moon_ventas (sin la columna de total de cuenta)
    $query_insert = "INSERT INTO moon_ventas (id_cliente, nombre_cliente) VALUES (?, ?)";
    if ($stmt = mysqli_prepare($con, $query_insert)) {
        if (!mysqli_stmt_bind_param($stmt, "is", $id_cliente, $nombre_cliente)) {
            echo json_encode(['status' => 'error', 'message' => 'Error en los parámetros de la consulta']);
            exit;
        }

        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar la orden: ' . mysqli_error($con)]);
            mysqli_rollback($con);
            exit;
        }

        $orden_id = mysqli_insert_id($con);  // Obtener el ID de la orden insertada
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta de inserción de orden']);
        exit;
    }

    // Insertar los productos asociados con la orden
    $query_producto = "INSERT INTO moon_ventas (folio, id_cliente, nombre_cliente, id_producto, producto, cantidad, precio_unitario, sub_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    foreach ($productos as $producto) {
        if (isset($producto['folio'], $producto['producto'], $producto['id_producto'], $producto['cantidad'], $producto['precio_unitario'], $producto['total'])) {
            if ($stmt = mysqli_prepare($con, $query_producto)) {
                if (!mysqli_stmt_bind_param(
                    $stmt,
                    "sisdiidd",  // Parámetros: folio, id_cliente, nombre_cliente, id_producto, producto, cantidad, precio_unitario, sub_total
                    $producto['folio'],
                    $id_cliente,
                    $nombre_cliente,
                    $producto['id_producto'],
                    $producto['producto'],
                    $producto['cantidad'],
                    $producto['precio_unitario'],
                    $producto['total']
                )) {
                    echo json_encode(['status' => 'error', 'message' => 'Error al bindear los parámetros']);
                    exit;
                }
            
                $result = mysqli_stmt_execute($stmt);
                if (!$result) {
                    echo json_encode(['status' => 'error', 'message' => 'Error al ejecutar la consulta: ' . mysqli_error($con)]);
                    mysqli_rollback($con);
                    exit;
                }
            
                mysqli_stmt_close($stmt);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta']);
                exit;
            }            
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Producto con datos incompletos']);
            mysqli_rollback($con);
            exit;
        }
    }

    // Confirmar la transacción si todo ha ido bien
    if (!mysqli_commit($con)) {
        echo json_encode(['status' => 'error', 'message' => 'Error al confirmar la transacción']);
        exit;
    }

    // Cerrar la conexión con la base de datos
    mysqli_close($con);

    // Responder con éxito
    echo json_encode(['status' => 'success', 'message' => 'Orden registrada correctamente']);

} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
}

// Detener el buffer de salida y enviar los encabezados
ob_end_flush();
?>
