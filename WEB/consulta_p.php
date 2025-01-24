<?php
$cod=$_REQUEST['cod'];
header('Content-Type: application/json');

$inc = include "../db/Conexion.php";

// Consulta a la base de datos
$query ='select 
                id,
                Categoria, 
                Nombre, 
                Precio, 
                Descripcion, 
                Imagen_Producto, 
                Status, 
                atrr_1, 
                atrr_2, 
                atrr_3
            from mobility_solutions.moon_product
            where Categoria = '. $cod .';';

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
