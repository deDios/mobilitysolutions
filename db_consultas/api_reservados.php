<?php
header('Content-Type: application/json');

// Incluir conexión a la base de datos
$inc = include "../db/Conexion.php";

$query = "SELECT 
            auto.id,
            m_auto.auto AS nombre, 
            modelo.nombre AS modelo, 
            marca.nombre AS marca 
          FROM mobility_solutions.tmx_auto AS auto
          LEFT JOIN mobility_solutions.tmx_modelo AS modelo ON auto.modelo = modelo.id 
          LEFT JOIN mobility_solutions.tmx_marca AS marca ON auto.marca = marca.id
          LEFT JOIN mobility_solutions.tmx_marca_auto AS m_auto ON auto.nombre = m_auto.id
          WHERE auto.estatus = 3
          ORDER BY auto.id DESC;";

$result = mysqli_query($con, $query);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode([]);
}

$con->close();
?>