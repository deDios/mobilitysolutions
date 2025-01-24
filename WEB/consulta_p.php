<?php

header('Content-Type: application/json');

$inc = include "../db/Conexion.php";

// Consulta a la base de datos
$query ='select 
                acc.user_id, 
                acc.user_name, 
                acc.user_password, 
                acc.user_type, 
                acc.r_ejecutivo, 
                acc.r_editor, 
                acc.r_autorizador, 
                acc.r_analista, 
                us.user_name, 
                us.second_name, 
                us.last_name, 
                us.email, 
                us.cumpleaños, 
                us.telefono
            from mobility_solutions.tmx_acceso_usuario  as acc
            left join mobility_solutions.tmx_usuario as us
                on acc.user_id = us.id;';

$result = mysqli_query($con,$query); 

if ($result->num_rows > 0) {
    $data = array();
    
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
} else {
    echo json_encode(["mensaje" => "No se encontraron datos"]);
}

$conn->close();
?>
