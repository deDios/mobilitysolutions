<?php
header('Content-Type: application/json; charset=UTF-8');

$inc = include "../db/Conexion.php";
if (!$inc) {
    echo json_encode(["error" => "No se pudo incluir Conexion.php"]);
    exit;
}

// Obtener conexión
$con = conectar();
if (!$con) {
    echo json_encode(["error" => "No se pudo conectar a la base de datos"]);
    exit;
}

// Capturar JSON crudo
$rawInput = file_get_contents("php://input");
$input = json_decode($rawInput, true);

// Si no viene JSON, intentar con $_POST
if (!is_array($input) || empty($input)) {
    $input = $_POST;
}

// Validar parámetros
$nombre_persona = isset($input['nombre_persona']) ? trim($input['nombre_persona']) : '';
$numero_tarjeta = isset($input['numero_tarjeta']) ? trim($input['numero_tarjeta']) : '';

if (empty($nombre_persona) || empty($numero_tarjeta)) {
    echo json_encode([
        "error" => "Faltan parámetros obligatorios: 'nombre_persona' y 'numero_tarjeta'",
        "rawInput" => $rawInput,
        "postData" => $_POST
    ]);
    exit;
}

// Escapar datos para seguridad
$nombre_persona = mysqli_real_escape_string($con, $nombre_persona);
$numero_tarjeta = mysqli_real_escape_string($con, $numero_tarjeta);

// Llave secreta para AES
$secret_key = "MiClaveUltraSecreta2025";

// Query para insertar
$query = "
    INSERT INTO cliente_tarjeta (nombre_persona, tarjeta_encriptada)
    VALUES ('$nombre_persona', AES_ENCRYPT('$numero_tarjeta', '$secret_key'))
";

// Ejecutar el insert
if (mysqli_query($con, $query)) {
    echo json_encode([
        "status" => "success",
        "message" => "Cliente insertado correctamente",
        "id_cliente" => mysqli_insert_id($con)
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Error al insertar: " . mysqli_error($con)
    ]);
}

mysqli_close($con);
?>
