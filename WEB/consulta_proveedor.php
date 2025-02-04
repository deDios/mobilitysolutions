<?php
$cod = $_REQUEST['cod'];
header('Content-Type: application/json');

$inc = include "../db/Conexion.php";


$query = 'select 
            id, 
            Nombre, 
            tipo_proveedor, 
            Status 
        from mobility_solutions.moon_proveedores
        WHERE tipo_proveedor = ' . $cod . ' 
        and Status = 1
        order by Nombre ASC ;';


$result = mysqli_query($con, $query);

if ($result->num_rows > 0) {
    $data = array();
    
    while ($row = $result->fetch_assoc()) {
        // Aseguramos que 'id', 'Categoria', y 'Status' sean enteros.
        $row['id'] = (int)$row['id']; // Convierte 'id' a entero
        $row['tipo_proveedor'] = (int)$row['tipo_proveedor']; // Convierte 'Categoria' a entero
        $row['Status'] = (int)$row['Status']; // Convierte 'Status' a entero
        
        $data[] = $row;
    }

    // Enviar los datos como JSON
    echo json_encode($data);
} else {
    echo json_encode(["mensaje" => "No se encontraron datos"]);
}

$conn->close();

?>
