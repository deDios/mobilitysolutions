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

$user_id      = isset($input['user_id']) ? (int)$input['user_id'] : 0;
$user_type    = isset($input['user_type']) ? (int)$input['user_type'] : 0;
$solo_usuario = !empty($input['solo_usuario']);
$anio         = isset($input['year']) ? (int)$input['year'] : (int)date('Y');

if ($user_id <= 0 || $user_type <= 0) {
    echo json_encode(["success" => false, "message" => "Faltan parámetros (user_id, user_type)"]);
    exit;
}

// 🔁 Función recursiva para obtener todos los subordinados
function obtenerSubordinadosHexDash($con, $userId, &$subordinados) {
    $stmt = $con->prepare("
        SELECT user_id 
        FROM mobility_solutions.tmx_acceso_usuario 
        WHERE reporta_a = ?
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $subId = (int)$row['user_id'];
        if (!in_array($subId, $subordinados, true)) {
            $subordinados[] = $subId;
            obtenerSubordinadosHexDash($con, $subId, $subordinados); // recursivo
        }
    }

    $stmt->close();
}

// 📦 Construir lista de IDs
$ids = [];

if ($solo_usuario) {
    $ids = [$user_id];
} elseif (in_array($user_type, [5, 6], true)) {
    // CEO / CTO: todos
    $res = $con->query("SELECT user_id FROM mobility_solutions.tmx_acceso_usuario");
    while ($row = $res->fetch_assoc()) {
        $ids[] = (int)$row['user_id'];
    }
} else {
    // Usuario normal: él + subordinados
    $ids = [$user_id];
    obtenerSubordinadosHexDash($con, $user_id, $ids);
}

$ids = array_values(array_unique(array_map('intval', $ids)));

if (empty($ids)) {
    echo json_encode([
        "success" => true,
        "anio"    => $anio,
        "rows"    => []
    ]);
    exit;
}

$id_list = implode(',', $ids);

// 📊 Consulta de requerimientos por mes / tipo
$sql = "
    SELECT
        m.Mes,
        COALESCE(SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%nuevo%'   THEN 1 ELSE 0 END), 0) AS New,
        COALESCE(SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%reserva%' THEN 1 ELSE 0 END), 0) AS Reserva,
        COALESCE(SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%entrega%' THEN 1 ELSE 0 END), 0) AS Entrega
    FROM (
        SELECT 1 AS num, 'enero' AS Mes UNION ALL
        SELECT 2 AS num, 'febrero' UNION ALL
        SELECT 3, 'marzo' UNION ALL
        SELECT 4, 'abril' UNION ALL
        SELECT 5, 'mayo' UNION ALL
        SELECT 6, 'junio' UNION ALL
        SELECT 7, 'julio' UNION ALL
        SELECT 8, 'agosto' UNION ALL
        SELECT 9, 'septiembre' UNION ALL
        SELECT 10, 'octubre' UNION ALL
        SELECT 11, 'noviembre' UNION ALL
        SELECT 12, 'diciembre'
    ) AS m
    LEFT JOIN mobility_solutions.tmx_requerimiento r
        ON MONTH(COALESCE(r.req_created_at, r.created_at)) = m.num
        AND YEAR(COALESCE(r.req_created_at, r.created_at)) = $anio
        AND r.status_req = 2
        AND r.created_by IN ($id_list)
    GROUP BY m.num, m.Mes
    ORDER BY m.num
";

$result = $con->query($sql);

$rows = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $row['New']     = (int)$row['New'];
        $row['Reserva'] = (int)$row['Reserva'];
        $row['Entrega'] = (int)$row['Entrega'];
        $rows[] = $row;
    }
}

echo json_encode([
    "success" => true,
    "anio"    => $anio,
    "rows"    => $rows
], JSON_UNESCAPED_UNICODE);

$con->close();
