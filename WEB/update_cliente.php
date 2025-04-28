<?php
header('Content-Type: application/json');

// Incluir conexión
$inc = include "../db/Conexion.php";

// Leer JSON crudo desde el body
$input = json_decode(file_get_contents("php://input"), true);

// Obtener parámetros desde el JSON
$id_company = isset($input['id_company']) ? (int)$input['id_company'] : 0;
$id = isset($input['id']) ? (int)$input['id'] : 0; // id de la tabla moon_cliente
$id_cliente = isset($input['id_cliente']) ? $input['id_cliente'] : ''; // número de cliente
$nombre = isset($input['nombre']) ? $input['nombre'] : '';
$correo = isset($input['correo']) ? $input['correo'] : '';
$telefono = isset($input['telefono']) ? $input['telefono'] : '';
$edad = isset($input['edad']) ? (int)$input['edad'] : 0;
$fecha_cumpleanos = isset($input['fecha_cumpleanos']) ? $input['fecha_cumpleanos'] : '';
$genero = isset($input['genero']) ? $input['genero'] : '';
$imagen_cliente = isset($input['imagen_cliente']) ? $input['imagen_cliente'] : '';
$status = isset($input['status']) ? (int)$input['status'] : 0;
$en_luna = isset($input['en_luna']) ? (int)$input['en_luna'] : 0;

// Validar parámetros requeridos
if ($id_company === 0 || $id === 0 || empty($id_cliente) || empty($nombre) || empty($telefono) || $edad === 0 || empty($fecha_cumpleanos) || empty($genero)) {
    echo json_encode(["mensaje" => "Parámetros inválidos"]);
    exit;
}

// Construir query de actualización
$query = "
    UPDATE moon_cliente
    SET 
        numero_cliente = '$id_cliente',
        Nombre = '$nombre',
        Correo = '$correo',
        Telefono = '$telefono',
        Edad = $edad,
        Fecha_cumpleaños = '$fecha_cumpleanos',
        Genero = '$genero',
        Imagen_cliente = '$imagen_cliente',
        Status = $status,
        En_Luna = $en_luna
    WHERE id = $id
";

// Ejecutar la query
if (mysqli_query($con, $query)) {
    echo json_encode(["mensaje" => "Cliente actualizado correctamente"]);
} else {
    echo json_encode(["mensaje" => "Error al actualizar el cliente: " . mysqli_error($con)]);
}

$con->close();
?>
