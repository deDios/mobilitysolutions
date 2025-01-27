<?php
$cod = $_REQUEST['cod'];
header('Content-Type: application/json');

$inc = include "../db/Conexion.php";

// Consulta a la base de datos
$query = 'select 
                id, 
                Nombre, 
                Correo, 
                Telefono, 
                Edad, 
                Fecha_cumpleaños, 
                Genero, 
                Imagen_cliente, 
                Status, 
                En_Luna 
            from mobility_solutions.moon_cliente
            WHERE id = ' . $cod . ';';

$result = mysqli_query($con, $query);

if ($result->num_rows > 0) {
    $data = array();
    
    while ($row = $result->fetch_assoc()) {
        // Aseguramos que 'id', 'Categoria', y 'Status' sean enteros.
        $row['id'] = (int)$row['id']; // Convierte 'id' a entero
        $row['Edad'] = (int)$row['Edad']; // Convierte 'Categoria' a entero
        $row['Status'] = (int)$row['Status']; // Convierte 'Status' a entero
        $row['En_Luna'] = (int)$row['En_Luna']; // Convierte 'Status' a entero
               
        $data[] = $row;
    }

    // Enviar los datos como JSON
    echo json_encode($data);
} else {
    echo json_encode(["mensaje" => "No se encontraron datos"]);
}

$conn->close();

?>
