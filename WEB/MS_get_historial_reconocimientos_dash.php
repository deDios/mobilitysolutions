<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido; usa POST"
    ]);
    exit;
}

include "../db/Conexion.php";

$raw   = file_get_contents("php://input");
$input = json_decode($raw, true) ?: [];

$asignado = isset($input['asignado']) ? (int)$input['asignado'] : 0;
$year     = isset($input['year']) ? (int)$input['year'] : (int)date('Y');
$month    = isset($input['month']) ? (int)$input['month'] : 0; // 0 = todos

if ($asignado <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Parámetro 'asignado' es requerido."
    ]);
    exit;
}

$condiciones = [
    "asignado = ?",
    "anio = ?"
];
$params = [$asignado, $year];
$types  = "ii";

if ($month >= 1 && $month <= 12) {
    $condiciones[] = "mes = ?";
    $params[] = $month;
    $types   .= "i";
}

$sql = "
    SELECT 
        tipo,
        reconocimiento,
        mes,
        anio,
        descripcion
    FROM mobility_solutions.tmx_reconocimientos
    WHERE " . implode(" AND ", $condiciones) . "
    ORDER BY anio DESC, mes DESC
";

$stmt = $con->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();

$rows = [];
while ($r = $res->fetch_assoc()) {
    $rows[] = [
        "tipo"           => $r['tipo'] ?? "",
        "reconocimiento" => $r['reconocimiento'] ?? "",
        "descripcion"    => $r['descripcion'] ?? "",
        "mes"            => (int)($r['mes'] ?? 0),
        "anio"           => (int)($r['anio'] ?? 0),
        // campo de conveniencia para la tabla
        "fecha"          => ($r['mes'] && $r['anio']) 
                            ? sprintf('%02d/%04d', $r['mes'], $r['anio']) 
                            : null
    ];
}

echo json_encode([
    "success" => true,
    "year"    => $year,
    "month"   => $month,
    "rows"    => $rows
], JSON_UNESCAPED_UNICODE);

$stmt->close();
$con->close();
