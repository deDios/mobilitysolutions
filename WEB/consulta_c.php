<?php
$cod = $_REQUEST['cod'];
header('Content-Type: application/json');

$inc = include "../db/Conexion.php";

// Consulta a la base de datos
$query = 'select 
                id, 
                id as Id_Cliente,
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
        // Aseguramos que los valores sean del tipo adecuado
        $row['id'] = (int)$row['id']; // Convierte 'id' a entero
        $row['Id_Cliente'] = (string)$row['Id_Cliente']; // Convierte 'Id_Cliente' a string
        $row['Edad'] = (int)$row['Edad']; // Convierte 'Edad' a entero
        $row['Status'] = (int)$row['Status']; // Convierte 'Status' a entero
        $row['En_Luna'] = (int)$row['En_Luna']; // Convierte 'En_Luna' a entero
               
        $data[] = $row;
    }

    // Enviar los datos como JSON
    echo json_encode($data);
} else {
    // Si no se encuentra el cliente, enviar un objeto con valores predeterminados
    $clienteNoRegistrado = array(
        "Id_Cliente" => "99999",  // O el valor que indique no encontrado
        "Nombre" => "No registrado",
        "Correo" => "N/A",
        "Telefono" => "N/A",
        "Edad" => 0,
        "Fecha_cumpleaños" => "N/A",
        "Genero" => "N/A",
        "Imagen_cliente" => "N/A",
        "Status" => 0,
        "En_Luna" => 0
    );

    // Enviar el cliente no registrado como JSON
    echo json_encode([$clienteNoRegistrado]);
}

$conn->close();
?>

