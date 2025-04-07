<?php
header('Content-Type: application/json');

// Incluir conexión
$inc = include "../db/Conexion.php";

// Obtener parámetros
$id_company = isset($_REQUEST['id_company']) ? (int)$_REQUEST['id_company'] : 0;
$tipo = isset($_REQUEST['tipo']) ? (int)$_REQUEST['tipo'] : 0;

if ($id_company === 0 || $tipo === 0) {
    echo json_encode(["mensaje" => "Parámetros inválidos"]);
    exit;
}

// Construir query
$query = "SELECT Nombre FROM mobility_solutions.moon_img_asset WHERE id_company = $id_company AND tipo = $tipo ORDER BY Nombre ASC";
$result = mysqli_query($con, $query);

// Verificar resultados
if ($result && $result->num_rows > 0) {
    $imagenes = [];

    while ($row = $result->fetch_assoc()) {
        $imagenes[] = $row['Nombre'];
    }

    echo json_encode($imagenes);
} else {
    echo json_encode(["mensaje" => "No se encontraron imágenes"]);
}

$con->close();
?>
