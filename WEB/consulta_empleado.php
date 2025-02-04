<?php
header('Content-Type: application/json');

$inc = include "../db/Conexion.php";
if (!$inc) {
    echo json_encode(["error" => "Error al conectar a la base de datos"]);
    exit;
}

// Verificar si es una solicitud GET (para consultar el empleado)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $cod = isset($_GET['cod']) ? intval($_GET['cod']) : 0;

    $query = 'select 
                a.id, 
                a.Nombre,
                b.cargo,
                b.localidad
              FROM mobility_solutions.moon_cliente AS a
              LEFT JOIN mobility_solutions.moon_empleado AS b
              ON a.id = b.id_empleado
              WHERE b.status = 1
              AND b.id_empleado = ?';

    $stmt = $con->prepare($query);

    if (!$stmt) {
        echo json_encode(["error" => "Error en la preparación de la consulta: " . $con->error]);
        exit;
    }

    $stmt->bind_param("i", $cod);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        echo json_encode(["error" => "Error en la consulta: " . $con->error]);
        exit;
    }

    if ($result->num_rows > 0) {
        $data = array();
        
        while ($row = $result->fetch_assoc()) {
            $row['id'] = (int)$row['id'];
            $data[] = $row;
        }

        echo json_encode($data);
    } else {
        echo json_encode(["mensaje" => "No se encontraron empleados"]);
    }

    $stmt->close();
}

// Verificar si es una solicitud POST (para registrar la asistencia)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibimos los parámetros del POST
    $id_empleado = isset($_POST['id_empleado']) ? intval($_POST['id_empleado']) : 0;

    // Validar que el ID del empleado esté presente
    if ($id_empleado == 0) {
        echo json_encode(["error" => "ID de empleado no proporcionado"]);
        exit;
    }

    // Insertar un registro en la tabla moon_empleado_asistencia
    $query = "insert INTO mobility_solutions.moon_empleado_asistencia (id_empleado) VALUES (?)";

    $stmt = $con->prepare($query);
    if (!$stmt) {
        echo json_encode(["error" => "Error en la preparación de la consulta: " . $con->error]);
        exit;
    }

    $stmt->bind_param("i", $id_empleado);
    $resultado = $stmt->execute();

    if ($resultado) {
        echo json_encode(["mensaje" => "Asistencia registrada correctamente"]);
    } else {
        echo json_encode(["error" => "Error al registrar la asistencia"]);
    }

    $stmt->close();
}

// Cerrar la conexión
$con->close();
?>
