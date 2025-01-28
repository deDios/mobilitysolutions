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

        var_dump($id_producto); 

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
