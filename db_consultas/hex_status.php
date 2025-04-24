<?php
$user_id = $_GET['user_id']; 

header('Content-Type: application/json');

// Asegúrate de que el valor user_id sea un número entero
if (!is_numeric($user_id)) {
    echo json_encode(["error" => "user_id no válido"]);
    exit();
}

$inc = include "../db/Conexion.php";

// Consulta a la base de datos
$query = "SELECT
            MONTHNAME(req_created_at) AS Mes,
            SUM(CASE WHEN tipo_req = 'Nuevo en catálogo' THEN 1 ELSE 0 END) AS New,
            SUM(CASE WHEN tipo_req = 'Reserva de vehículo' THEN 1 ELSE 0 END) AS Reserva,
            SUM(CASE WHEN tipo_req = 'Entrega de vehículo' THEN 1 ELSE 0 END) AS Entrega
        FROM 
        mobility_solutions.tmx_requerimiento
        WHERE 
        YEAR(req_created_at) = YEAR(CURDATE()) AND status_req = 2 AND created_by = $user_id
        GROUP BY 
        MONTH(req_created_at),
        MONTHNAME(req_created_at)
        ORDER BY 
        MONTH(req_created_at)"; 

$result = mysqli_query($con, $query);

if ($result) {
    $data = mysqli_fetch_assoc($result);

    // Enviar los datos como JSON
    echo json_encode($data);
} else {
    echo json_encode(["error" => "No se encontraron resultados o hubo un error en la consulta"]);
}

$conn->close();
?>



