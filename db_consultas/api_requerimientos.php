<?php
header('Content-Type: application/json');

$created_by = isset($_REQUEST['cod']) ? (int)$_REQUEST['cod'] : 0;

if ($created_by === 0) {
    echo json_encode(["error" => "Parámetro 'cod' no válido"]);
    exit;
}

// Incluir conexión a la base de datos
$inc = include "../db/Conexion.php";

$query = "SELECT 
                id, 
                tipo_req, 
                status_req, 
                comentarios
          FROM mobility_solutions.tmx_requerimiento
          WHERE created_by = $created_by;";

$result = mysqli_query($con, $query);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        // Mapeo de status_req
        $status_map = [1 => "curso", 2 => "aprobado", 3 => "declinado"];
        $row['status_req'] = $status_map[$row['status_req']] ?? "desconocido";
        $data[] = $row;
    }

    echo json_encode($data);
} else {
    echo json_encode([]);
}

$con->close();
?>
