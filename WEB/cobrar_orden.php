<?php

function getDBConnection() {
    $host   = "mobilitysolutions-server.mysql.database.azure.com";
    $user   = "btdonyajwn";                 // (Flexible Server) sin @server
    $pass   = "Llaverito_4855797'?";
    $db     = "mobility_solutions";
    $port   = 3306;
    $caPath = "/home/site/wwwroot/db/DigiCertGlobalRootG2.crt.pem"; // <-- nombre correcto (G2)

    $con = mysqli_init();

    // Verificar certificado del servidor (recomendado)
    mysqli_options($con, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);

    // Cargar la CA
    if (!mysqli_ssl_set($con, NULL, NULL, $caPath, NULL, NULL)) {
        die('Error: No se pudo cargar la CA: ' . mysqli_error($con));
    }

    // ¡OJO! el 7º parámetro es el socket (NULL), el 8º son los flags
    if (!mysqli_real_connect($con, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL)) {
        die('Error: Falla en la conexión de MySQL. ' . mysqli_connect_error());
    }

    return $con;
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id_cliente'], $data['nombre_cliente'], $data['total_cuenta'], $data['folio'], $data['productos'])) {
    $id_cliente = $data['id_cliente'];
    $nombre_cliente = $data['nombre_cliente'];
    $total_cuenta = $data['total_cuenta'];
    $folio = $data['folio'];  // Asegúrate de que el folio sea pasado
    $productos = $data['productos'];

    $conn = getDBConnection();
    $stmt = $conn->prepare("insert into mobility_solutions.moon_ventas (folio, id_cliente, nombre_cliente, producto, cantidad, precio_unitario, sub_total, id_producto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $orden_insertada = false;

    foreach ($productos as $producto) {
        $producto_nombre = $producto['producto'];
        $cantidad = $producto['cantidad'];
        $precio_unitario = $producto['precio_unitario'];
        $sub_total = $producto['total'];  // sub_total es igual a cantidad * precio_unitario

        $producto_id_stmt = $conn->prepare("select id from mobility_solutions.moon_product WHERE Nombre = ?");
        $producto_id_stmt->bind_param("s", $producto_nombre);
        $producto_id_stmt->execute();
        $producto_id_stmt->store_result();
        $producto_id_stmt->bind_result($id_producto);

        // Eliminar el var_dump() que imprimía valores no deseados en la respuesta
        if ($producto_id_stmt->num_rows > 0) {
            $producto_id_stmt->fetch();
        } else {
            $id_producto = NULL;
        }

        $stmt->bind_param("sissiddi", $folio, $id_cliente, $nombre_cliente, $producto_nombre, $cantidad, $precio_unitario, $sub_total, $id_producto);

        if ($stmt->execute()) {
            $orden_insertada = true;
        } else {
            echo json_encode(["status" => "error", "message" => "Error al insertar el producto: " . $stmt->error]);
            exit;
        }   
        $producto_id_stmt->close();
    }

    // Ahora solo enviamos el status y message según el resultado
    if ($orden_insertada) {
        echo json_encode(["status" => "success", "message" => "Orden registrada con éxito."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al registrar la orden."]);
    }

    $stmt->close();
    $conn->close();

} else {
    echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
}

?>
