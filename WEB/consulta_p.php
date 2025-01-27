<?php
$cod = $_REQUEST['cod'];
header('Content-Type: application/json');

$inc = include "../db/Conexion.php";

// Consulta a la base de datos
$query = 'select 
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
            FROM mobility_solutions.moon_product
            WHERE Categoria = ' . $cod . ';';

$result = mysqli_query($con, $query);

if ($result->num_rows > 0) {
    $data = array();
    
    while ($row = $result->fetch_assoc()) {
        // Aseguramos que 'id', 'Categoria', y 'Status' sean enteros.
        $row['id'] = (int)$row['id']; // Convierte 'id' a entero
        $row['Categoria'] = (int)$row['Categoria']; // Convierte 'Categoria' a entero
        $row['Status'] = (int)$row['Status']; // Convierte 'Status' a entero
        
        // Aseguramos que 'Precio' se mantenga como cadena
        $row['Precio'] = (string)$row['Precio']; // Convierte 'Precio' a cadena de texto
        
        // Para depuración, veamos los valores de 'Precio' antes de la conversión
        var_dump($row['Precio']);  // Esto imprimirá el tipo y valor de 'Precio'
        
        $data[] = $row;
    }

    // Enviar los datos como JSON
    echo json_encode($data);
} else {
    echo json_encode(["mensaje" => "No se encontraron datos"]);
}

$conn->close();

?>
