<?php
header('Content-Type: application/json');

// Incluir conexión
$inc = include "../db/Conexion.php";

// Obtener parámetros
$id_company = isset($_REQUEST['id_company']) ? (int)$_REQUEST['id_company'] : 0;
$id_producto = isset($_REQUEST['id_producto']) ? (int)$_REQUEST['id_producto'] : 0;
$nombre = isset($_REQUEST['nombre']) ? $_REQUEST['nombre'] : '';
$descripcion = isset($_REQUEST['descripcion']) ? $_REQUEST['descripcion'] : '';
$precio = isset($_REQUEST['precio']) ? $_REQUEST['precio'] : '';
$imagen_producto = isset($_REQUEST['imagen_producto']) ? $_REQUEST['imagen_producto'] : '';
$status = isset($_REQUEST['status']) ? (int)$_REQUEST['status'] : 0;
$atrr_1 = isset($_REQUEST['atrr_1']) ? $_REQUEST['atrr_1'] : '';
$atrr_2 = isset($_REQUEST['atrr_2']) ? $_REQUEST['atrr_2'] : '';
$atrr_3 = isset($_REQUEST['atrr_3']) ? $_REQUEST['atrr_3'] : '';
$categoria = isset($_REQUEST['categoria']) ? (int)$_REQUEST['categoria'] : 0;  // Agregar la categoría como parámetro

// Validar que los parámetros sean válidos
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
