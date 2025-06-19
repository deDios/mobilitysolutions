<?php
header('Content-Type: application/json');
$inc = include "../db/Conexion.php";

$query = "SELECT id, CONCAT(user_name, ' ', second_name, ' ', last_name) AS nombre_completo 
          FROM mobility_solutions.tmx_usuario 
          ORDER BY nombre_completo ASC";

$result = mysqli_query($con, $query);

if ($result && $result->num_rows > 0) {
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            "id" => (int)$row["id"],
            "nombre" => $row["nombre_completo"]
        ];
    }

    echo json_encode($data);
} else {
    echo json_encode([]);
}

$con->close();
?>
