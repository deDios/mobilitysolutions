<?php
header('Content-Type: application/json');

// Incluir conexión
$inc = include "../db/Conexion.php";

// Leer JSON crudo desde el body
$input = json_decode(file_get_contents("php://input"), true);

// Obtener parámetros desde el JSON
$id_company = isset($input['id_company']) ? (int)$input['id_company'] : 0;
$id_producto = isset($input['id_producto']) ? (int)$input['id_producto'] : 0;
$nombre = isset($input['nombre']) ? $input['nombre'] : '';
$descripcion = isset($input['descripcion']) ? $input['descripcion'] : '';
$precio = isset($input['precio']) ? $input['precio'] : '';
$imagen_producto = isset($input['imagen_producto']) ? $input['imagen_producto'] : '';
$status = isset($input['status']) ? (int)$input['status'] : 0;
$atrr_1 = isset($input['atrr_1']) ? $input['atrr_1'] : '';
$atrr_2 = isset($input['atrr_2']) ? $input['atrr_2'] : '';
$atrr_3 = isset($input['atrr_3']) ? $input['atrr_3'] : '';
$categoria = isset($input['categoria']) ? (int)$input['categoria'] : 0;

// Validar parámetros requeridos
if ($id_company === 0 || $id_producto === 0 || empty($nombre) || empty($descripcion) || empty($precio) || empty($imagen_producto) || $categoria === 0) {
    echo json_encode(["mensaje" => "Parámetros inválidos"]);
    exit;
}

// Construir query de actualización
$query = "
    UPDATE moon_product
    SET 
        Categoria = $categoria,
        Nombre = '$nombre',
        Precio = '$precio',
        Descripcion = '$descripcion',
        Imagen_Producto = '$imagen_producto',
        Status = $status,
        atrr_1 = '$atrr_1',
        atrr_2 = '$atrr_2',
        atrr_3 = '$atrr_3'
    WHERE id = $id_producto
";

// Ejecutar la query
if (mysqli_query($con, $query)) {
    echo json_encode(["mensaje" => "Producto actualizado correctamente"]);
} else {
    echo json_encode(["mensaje" => "Error al actualizar el producto: " . mysqli_error($con)]);
}

$con->close();
?>
