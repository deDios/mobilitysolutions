<?php
header('Content-Type: application/json');

// Incluir conexión
$inc = include "../db/Conexion.php";

// Obtener parámetros desde POST (más seguro que REQUEST)
$id_company = isset($_POST['id_company']) ? (int)$_POST['id_company'] : 0;
$id_producto = isset($_POST['id_producto']) ? (int)$_POST['id_producto'] : 0;
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
$precio = isset($_POST['precio']) ? $_POST['precio'] : '';
$imagen_producto = isset($_POST['imagen_producto']) ? $_POST['imagen_producto'] : '';
$status = isset($_POST['status']) ? (int)$_POST['status'] : 0;
$atrr_1 = isset($_POST['atrr_1']) ? $_POST['atrr_1'] : '';
$atrr_2 = isset($_POST['atrr_2']) ? $_POST['atrr_2'] : '';
$atrr_3 = isset($_POST['atrr_3']) ? $_POST['atrr_3'] : '';
$categoria = isset($_POST['categoria']) ? (int)$_POST['categoria'] : 0;

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

