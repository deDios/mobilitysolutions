<?php
$cod = $_REQUEST['cod'];
header('Content-Type: application/json');

// Incluir conexión a la base de datos
$inc = include "../db/Conexion.php";

if ($cod == 10) {
    // Si cod=10, traer todos los clientes incluyendo el nuevo campo numero_cliente
    $query = 'SELECT 
                id,
                numero_cliente,
                Nombre,
                Correo,
                Telefono,
                Edad,
                Fecha_cumpleaños,
                Genero,
                Imagen_cliente,
                Status,
                En_Luna
            FROM mobility_solutions.moon_cliente
            ORDER BY Nombre ASC;';
} else {
    // Si cod != 10, puedes hacer lo mismo pero también incluir numero_cliente
    $query = 'SELECT 
                id,
                numero_cliente,
                Nombre,
                Correo,
                Telefono,
                Edad,
                Fecha_cumpleaños,
                Genero,
                Imagen_cliente,
                Status,
                En_Luna
            FROM mobility_solutions.moon_cliente
            WHERE Status = 1
            ORDER BY Nombre ASC;';
}

// Ejecutar la consulta
$result = mysqli_query($con, $query);

if ($result->num_rows > 0) {
    $data = array();

    while ($row = $result->fetch_assoc()) {
        // Conversión de tipos para asegurar consistencia en el JSON
        $row['id'] = (int)$row['id'];
        $row['Edad'] = (int)$row['Edad'];
        $row['Status'] = (int)$row['Status'];
        $row['En_Luna'] = (int)$row['En_Luna'];

        // Añadir el nuevo campo numero_cliente a la respuesta
        $row['numero_cliente'] = $row['numero_cliente'];

        $data[] = $row;
    }

    echo json_encode($data);
} else {
    echo json_encode(["mensaje" => "No se encontraron clientes"]);
}

// Cerrar conexión
$con->close();
?>
