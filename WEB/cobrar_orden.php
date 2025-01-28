<?php
// Configuración de conexión a la base de datos
include('../db/Conexion_p.php'); // Asegúrate de que la ruta de tu archivo de conexión sea la correcta

// Obtener los datos recibidos (puedes usar $_POST o el método que prefieras)
$data = json_decode(file_get_contents('php://input'), true);  // Asumiendo que los datos se envían como JSON

// Verifica si los datos son válidos
if (isset($data['id_cliente'], $data['nombre_cliente'], $data['total_cuenta'], $data['productos']) && is_array($data['productos'])) {
    
    // Asignación de variables
    $id_cliente = (int)$data['id_cliente'];  // Asegurarse de que id_cliente es un número entero
    $nombre_cliente = $data['nombre_cliente'];
    $total_cuenta = (float)$data['total_cuenta'];  // Asegurarse de que total_cuenta es un número decimal
    
    // Validación de los productos
    $productos = $data['productos'];

    foreach ($productos as &$producto) {
        // Asegurarse de que los campos sean válidos y convertirlos a los tipos correctos
        $producto['total'] = (float)$producto['total'];
        $producto['precio_unitario'] = (float)$producto['precio_unitario'];
        $producto['cantidad'] = (int)$producto['cantidad'];  // Asegurarse de que la cantidad es un número entero
        $producto['folio'] = trim($producto['folio']); // Limpiar posibles espacios en el folio

        // Validar que todos los campos necesarios estén presentes
        if (!isset($producto['producto'], $producto['total'], $producto['cantidad'], $producto['precio_unitario'], $producto['folio'], $producto['fecha'])) {
            echo json_encode(['status' => 'error', 'message' => 'Producto con datos incompletos']);
            exit;
        }

        // Limpiar la fecha y convertirla a formato válido (eliminando "a.m." o "p.m." si es necesario)
        $producto['fecha'] = preg_replace('/\s?[a|p]\.m\./i', '', $producto['fecha']); // Eliminar "a.m." o "p.m." y posibles espacios

        // Validar la fecha con el formato esperado: YYYY-MM-DD HH:MM:SS
        $fecha = DateTime::createFromFormat('Y-m-d', $producto['fecha']);
        if (!$fecha) {
            echo json_encode(['status' => 'error', 'message' => 'La fecha no tiene un formato válido']);
            exit;
        }
        
        // Si la fecha es válida, convertirla de nuevo al formato correcto
        $producto['fecha'] = $fecha->format('Y-m-d');
    }

    // Iniciar la conexión a la base de datos (ya debe estar incluida en Conexion_p.php)
    $conn = mysqli_connect($hostname, $username, $password, $database);  // Usar las variables de tu conexión

    if (!$conn) {
        echo json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos']);
        exit;
    }

    // Comenzamos la transacción (si es necesario)
    mysqli_begin_transaction($conn);

    // Insertar la orden en la base de datos
    $query_insert = "insert into ordenes (id_cliente, nombre_cliente, total_cuenta) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $query_insert)) {
        mysqli_stmt_bind_param($stmt, "isd", $id_cliente, $nombre_cliente, $total_cuenta);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar la orden']);
            mysqli_rollback($conn);
            exit;
        }
        $orden_id = mysqli_insert_id($conn);  // Obtener el ID de la orden insertada
        mysqli_stmt_close($stmt);
    }

    // Insertar los productos en la base de datos
    $query_producto = "insert into productos_orden (orden_id, producto, precio_unitario, cantidad, total, folio, fecha) VALUES (?, ?, ?, ?, ?, ?, ?)";
    foreach ($productos as $producto) {
        if ($stmt = mysqli_prepare($conn, $query_producto)) {
            mysqli_stmt_bind_param($stmt, "isdiiss", $orden_id, $producto['producto'], $producto['precio_unitario'], $producto['cantidad'], $producto['total'], $producto['folio'], $producto['fecha']);
            $result = mysqli_stmt_execute($stmt);
            if (!$result) {
                echo json_encode(['status' => 'error', 'message' => 'Error al insertar los productos']);
                mysqli_rollback($conn);
                exit;
            }
            mysqli_stmt_close($stmt);
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
