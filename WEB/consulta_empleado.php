<?php
header('Content-Type: application/json');

$inc = include "../db/Conexion.php";
if (!$inc) {
    echo json_encode(["error" => "Error al conectar a la base de datos"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $cod = isset($_GET['cod']) ? intval($_GET['cod']) : 0;

    $query = 'select 
                a.id, 
                a.Nombre,
                b.cargo,
                b.localidad
            from mobility_solutions.moon_cliente as a
            left join mobility_solutions.moon_empleado as b
            on a.id = b.id_empleado
            where b.status = ?
            and b.id_empleado = 4
            ;';

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
        echo json_encode(["mensaje" => "No se encontraron proveedores"]);
    }

    $stmt->close();
}

// Cerrar la conexión
$con->close();
?>