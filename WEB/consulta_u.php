
<?php
$user = $_REQUEST['cod'];
$pass = $_REQUEST['pas'];

header('Content-Type: application/json');

$inc = include "../db/Conexion.php";

// Consulta a la base de datos
$query = 'select 
                id, 
                Nombre, 
                user_name, 
                password_name, 
                Status
            from mobility_solutions.moon_cliente
            WHERE user_name = "' . $user . '"
            and password_name = "' . $pass . '"
            and status = 1;';

$result = mysqli_query($con, $query);

if ($result->num_rows > 0) {
    $data = array();
    
    while ($row = $result->fetch_assoc()) {
        // Aseguramos que los valores sean del tipo adecuado
        $row['Status'] = (int)$row['Status']; // Convierte 'id' a entero
        $data[] = $row;
    }

    // Respuesta de éxito
    echo json_encode(["success" => true, "data" => $data]);
} else {
    // Respuesta de error
    echo json_encode(["success" => false, "message" => "Credenciales incorrectas"]);
}

$conn->close();
?>
