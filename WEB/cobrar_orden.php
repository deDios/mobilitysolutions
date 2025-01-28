<?php

// Conectar a la base de datos con tu conexión configurada
function getDBConnection() {
    $con = mysqli_init();
    mysqli_ssl_set($con, NULL, NULL, "/home/site/wwwroot/db/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
    mysqli_real_connect($con, "mobilitysolutions-server.mysql.database.azure.com", "btdonyajwn", "Llaverito_4855797'?", "mobility_solutions", 3306, MYSQLI_CLIENT_SSL);

    if (mysqli_connect_errno()) {
        die('Error: Falla en la conexión de MySQL. ' . mysqli_connect_error());
    }
    return $con;
}

// Obtener los parámetros enviados en el cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"), true);

// Verificar si los parámetros necesarios están presentes
if (isset($data['id_cliente'], $data['nombre_cliente'], $data['total_cuenta'], $data['productos'])) {
    $id_cliente = $data['id_cliente'];
    $nombre_cliente = $data['nombre_cliente'];
    $total_cuenta = $data['total_cuenta'];
    $productos = $data['productos'];

    // Conectar a la base de datos
    $conn = getDBConnection();

    // Generar un folio único para la orden
    $folio = strtoupper(uniqid('ORD-'));

    // Preparar la consulta para insertar la orden
    $stmt = $conn->prepare("insert into mobility_solutions.moon_ventas (folio, id_cliente, nombre_cliente, producto, cantidad, precio_unitario, sub_total) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Variable para almacenar el éxito de la inserción
    $orden_insertada = false;

    foreach ($productos as $producto) {
        // Obtenemos los datos del producto
        $producto_nombre = $producto['producto'];
        $cantidad = $producto['cantidad'];
        $precio_unitario = $producto['precio_unitario'];
        $sub_total = $producto['total'];  // sub_total es igual a cantidad * precio_unitario

        // Buscar el id_producto correspondiente en moon_product
        $producto_id_stmt = $conn->prepare("select id from mobility_solutions.moon_product WHERE Nombre = ?");
        $producto_id_stmt->bind_param("s", $producto_nombre);
        $producto_id_stmt->execute();
        $producto_id_stmt->store_result();
        $producto_id_stmt->bind_result($id_producto);

        if ($producto_id_stmt->num_rows > 0) {
            // Si existe el producto, obtenemos el id
            $producto_id_stmt->fetch();

            // Ahora, aseguramos que la consulta tenga la cantidad correcta de parámetros
            $stmt->bind_param("sissidd", $folio, $id_cliente, $nombre_cliente, $producto_nombre, $cantidad, $precio_unitario, $sub_total);

            if ($stmt->execute()) {
                // Si la venta se inserta correctamente, marcamos como exitosa
                $orden_insertada = true;
            } else {
                echo json_encode(["status" => "error", "message" => "Error al insertar el producto: " . $stmt->error]);
                exit;
            }
        } else {
            // Si no se encuentra el producto en la tabla moon_product
            echo json_encode(["status" => "error", "message" => "Producto no encontrado en la base de datos: $producto_nombre"]);
            exit;
        }

        // Cerrar la consulta del producto
        $producto_id_stmt->close();
    }

    // Verificar si la inserción fue exitosa
    if ($orden_insertada) {
        echo json_encode(["status" => "success", "message" => "Orden registrada con éxito."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al registrar la orden."]);
    }

    // Cerrar la sentencia
    $stmt->close();

    // Cerrar la conexión
    $conn->close();

} else {
    echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
}

?>
