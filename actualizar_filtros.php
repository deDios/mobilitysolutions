<?php
// Conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$base_de_datos = "carros_db"; // Cambia este nombre por tu base de datos real

$conexion = new mysqli($servidor, $usuario, $contraseña, $base_de_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibimos los parámetros de la solicitud AJAX
$marca = isset($_GET['marca']) ? $_GET['marca'] : '';
$modelo = isset($_GET['modelo']) ? $_GET['modelo'] : '';
$color = isset($_GET['color']) ? $_GET['color'] : '';
$anio = isset($_GET['anio']) ? $_GET['anio'] : '';
$transmision = isset($_GET['transmision']) ? $_GET['transmision'] : '';
$interior = isset($_GET['interior']) ? $_GET['interior'] : '';

// Inicializamos las respuestas
$response = [
    'modelos' => [],
    'colores' => [],
    'anios' => ['2020', '2021', '2022', '2023'],
    'transmisiones' => ['Automática', 'Manual'],
    'interiores' => ['Piel', 'Tela']
];

// Filtrar modelos, colores, etc., según los filtros
$query = "SELECT DISTINCT modelo, color FROM carros WHERE 1";

if ($marca) {
    $query .= " AND marca = '$marca'";
}
if ($modelo) {
    $query .= " AND modelo = '$modelo'";
}
if ($color) {
    $query .= " AND color = '$color'";
}
if ($anio) {
    $query .= " AND anio = '$anio'";
}
if ($transmision) {
    $query .= " AND transmision = '$transmision'";
}
if ($interior) {
    $query .= " AND interior = '$interior'";
}

$resultado = $conexion->query($query);

while ($row = $resultado->fetch_assoc()) {
    // Aquí agregamos los modelos y colores a las respuestas
    if (!in_array($row['modelo'], $response['modelos'])) {
        $response['modelos'][] = $row['modelo'];
    }
    if (!in_array($row['color'], $response['colores'])) {
        $response['colores'][] = $row['color'];
    }
}

// Devolvemos la respuesta como un JSON
echo json_encode($response);

$conexion->close();
?>
