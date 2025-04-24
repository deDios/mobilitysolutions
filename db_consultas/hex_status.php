<?php
$user_id = $_GET['user_id']; // Cambié 'cod' por 'user_id'
header('Content-Type: application/json');

// Asegúrate de que el valor user_id sea un número entero
if (!is_numeric($user_id)) {
    echo json_encode(["error" => "user_id no válido"]);
    exit();
}

$inc = include "../db/Conexion.php";

// Consulta a la base de datos
$query = 'SELECT 
                COUNT(CASE WHEN tipo = "Nuevo" THEN 1 END) as nuevo,
                COUNT(CASE WHEN tipo = "Reserva" THEN 1 END) as reserva,
                COUNT(CASE WHEN tipo = "Entrega" THEN 1 END) as entrega
            FROM tmx_servicio
            WHERE estatus = 2 AND (created_by = ' . $user_id . ' OR some_other_column = ' . $user_id . ')'; // Aquí ajusté la consulta

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



