<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

// Leer los datos del POST en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validar campos obligatorios
$required_fields = ['tipo_meta', 'asignado', 'anio', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre', 'creado_por'];
foreach ($required_fields as $field) {
    if (!isset($data[$field])) {
        echo json_encode([
            "success" => false,
            "message" => "Falta el campo requerido: $field"
        ]);
        exit;
    }
}

// Extraer variables
$tipo_meta = (int)$data['tipo_meta'];
$asignado = (int)$data['asignado'];
$anio = (int)$data['anio'];
$creado_por = (int)$data['creado_por'];

$meses = [
    'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
    'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
];

// Validar valores numéricos de los meses
$valores = [];
foreach ($meses as $mes) {
    $valores[$mes] = is_numeric($data[$mes]) ? (int)$data[$mes] : 0;
}

// Revisar si ya existe la meta
$check_sql = "SELECT id FROM mobility_solutions.tmx_metas WHERE tipo_meta = ? AND asignado = ? AND anio = ?";
$stmt = $con->prepare($check_sql);
$stmt->bind_param("iii", $tipo_meta, $asignado, $anio);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // 🛠 ACTUALIZAR
    $update_sql = "
        UPDATE mobility_solutions.tmx_metas SET
            enero=?, febrero=?, marzo=?, abril=?, mayo=?, junio=?, julio=?, agosto=?, 
            septiembre=?, octubre=?, noviembre=?, diciembre=?, updated_at = NOW()
        WHERE tipo_meta = ? AND asignado = ? AND anio = ?
    ";
    $stmt = $con->prepare($update_sql);
    $stmt->bind_param(
        "iiiiiiiiiiiiiii",
        $valores['enero'], $valores['febrero'], $valores['marzo'], $valores['abril'], $valores['mayo'], $valores['junio'],
        $valores['julio'], $valores['agosto'], $valores['septiembre'], $valores['octubre'], $valores['noviembre'], $valores['diciembre'],
        $tipo_meta, $asignado, $anio
    );

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Meta actualizada correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar meta: " . $stmt->error]);
    }
} else {
    // INSERTAR
    $insert_sql = "
        INSERT INTO mobility_solutions.tmx_metas (
            tipo_meta, asignado, anio,
            enero, febrero, marzo, abril, mayo, junio,
            julio, agosto, septiembre, octubre, noviembre, diciembre,
            creado_por, created_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ";
    $stmt = $con->prepare($insert_sql);
    $stmt->bind_param(
        "iiiiiiiiiiiiiiii",
        $tipo_meta, $asignado, $anio,
        $valores['enero'], $valores['febrero'], $valores['marzo'], $valores['abril'], $valores['mayo'], $valores['junio'],
        $valores['julio'], $valores['agosto'], $valores['septiembre'], $valores['octubre'], $valores['noviembre'], $valores['diciembre'],
        $creado_por
    );

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Meta registrada correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al guardar meta: " . $stmt->error]);
    }
}

$stmt->close();
$con->close();
?>
