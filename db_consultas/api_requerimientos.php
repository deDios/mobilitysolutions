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
                comentarios, 
                id_auto, 
                created_by, 
                req_created_at, 
                req_closed_at, 
                approved_by, 
                rechazo_by, 
                rechazo_coment
          FROM mobility_solutions.tmx_requerimiento
          WHERE created_by = $created_by
          ORDER BY id DESC;";

$result = mysqli_query($con, $query);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        // Mapeo de status_req
        $status_map = [1 => "curso", 2 => "aprobado", 3 => "declinado"];
        $row['status_req'] = $status_map[$row['status_req']] ?? "desconocido";
        
        // Convertir fechas al formato ISO 8601
        $row['req_created_at'] = $row['req_created_at'] ? date("c", strtotime($row['req_created_at'])) : null;
        $row['req_closed_at'] = $row['req_closed_at'] ? date("c", strtotime($row['req_closed_at'])) : null;
        
        $data[] = $row;
    }

    echo json_encode($data);
} else {
    echo json_encode([]);
}

$con->close();
?>

