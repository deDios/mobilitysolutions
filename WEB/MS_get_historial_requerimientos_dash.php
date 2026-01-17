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

$user_id = isset($input['user_id']) ? (int)$input['user_id'] : 0;
$year    = isset($input['year']) ? (int)$input['year'] : (int)date('Y');
$month   = isset($input['month']) ? (int)$input['month'] : 0; // 0 = todos

if ($user_id <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Parámetro 'user_id' es requerido."
    ]);
    exit;
}

// Base de fechas sobre COALESCE(req_created_at, created_at)
$condiciones = [
    "created_by = ?",
    "YEAR(COALESCE(req_created_at, created_at)) = ?"
];
$params = [$user_id, $year];
$types  = "ii";

if ($month >= 1 && $month <= 12) {
    $condiciones[] = "MONTH(COALESCE(req_created_at, created_at)) = ?";
    $params[] = $month;
    $types   .= "i";
}

$sql = "
    SELECT 
        id,
        tipo_req,
        status_req,
        comentarios,
        id_auto,
        created_by,
        COALESCE(req_created_at, created_at) AS fecha
    FROM mobility_solutions.tmx_requerimiento
    WHERE " . implode(" AND ", $condiciones) . "
    ORDER BY fecha DESC, id DESC
";

$stmt = $con->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();

$rows = [];
$status_map = [
    1 => "En curso",
    2 => "Aprobado",
    3 => "Declinado"
];

while ($r = $res->fetch_assoc()) {
    $status_texto = $status_map[(int)$r['status_req']] ?? "Desconocido";

    $rows[] = [
        "id"       => (int)$r['id'],
        "titulo"   => "Req #" . $r['id'],
        "subtitulo"=> trim(($r['tipo_req'] ?? "") . " · " . $status_texto),
        "tipo"     => $r['tipo_req'] ?? "",
        "detalle"  => $r['comentarios'] ?? "",
        "fecha"    => $r['fecha'] ? date('Y-m-d H:i', strtotime($r['fecha'])) : null,
        "imagen_url" => null, // aquí puedes ligar a imagen de auto si haces JOIN a tmx_auto
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
