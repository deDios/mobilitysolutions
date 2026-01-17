<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://mobilitysolutionscorp.com');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

include "../db/Conexion.php";

$input   = json_decode(file_get_contents("php://input"), true);
$search  = isset($input['search'])  ? trim($input['search'])  : '';
$estatus = isset($input['estatus']) && $input['estatus'] !== '' 
         ? (int)$input['estatus'] 
         : null;

$sql = "
    SELECT 
        u.id,
        u.user_name,
        u.second_name,
        u.last_name,
        u.email,
        u.cumpleaños,
        u.telefono,
        u.created_at  AS usuario_created_at,
        u.updated_at  AS usuario_updated_at,
        a.user_name   AS login,
        a.user_type,
        a.reporta_a,
        a.r_ejecutivo,
        a.r_editor,
        a.r_autorizador,
        a.r_analista,
        a.estatus,
        a.created_at  AS acceso_created_at,
        a.updated_at  AS acceso_updated_at
    FROM mobility_solutions.tmx_usuario u
    INNER JOIN mobility_solutions.tmx_acceso_usuario a
        ON u.id = a.user_id
    WHERE 1 = 1
";

$params = [];
$types  = "";

// Filtro por estatus (0/1) si viene
if ($estatus !== null) {
    $sql    .= " AND a.estatus = ? ";
    $types  .= "i";
    $params[] = $estatus;
}

// Filtro búsqueda general
if ($search !== '') {
    $sql .= "
        AND (
            u.user_name   LIKE ?
            OR u.second_name LIKE ?
            OR u.last_name LIKE ?
            OR a.user_name LIKE ?
            OR u.email LIKE ?
        )
    ";
    $types   .= "sssss";
    $like     = "%".$search."%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
}

$sql .= " ORDER BY u.user_name, u.second_name, u.last_name";

$stmt = $con->prepare($sql);
if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Error al preparar la consulta",
        "error"   => $con->error
    ]);
    exit;
}

if ($types !== "") {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$usuarios = [];
while ($row = $result->fetch_assoc()) {
    $usuarios[] = [
        "id"               => (int)$row["id"],
        "user_name"        => $row["user_name"],
        "second_name"      => $row["second_name"],
        "last_name"        => $row["last_name"],
        "nombre_completo"  => trim($row["user_name"]." ".$row["second_name"]." ".$row["last_name"]),
        "email"            => $row["email"],
        "cumpleanos"       => $row["cumpleaños"],
        "telefono"         => $row["telefono"],
        "login"            => $row["login"],
        "user_type"        => (int)$row["user_type"],
        "reporta_a"        => $row["reporta_a"] !== null ? (int)$row["reporta_a"] : null,
        "r_ejecutivo"      => (int)$row["r_ejecutivo"],
        "r_editor"         => (int)$row["r_editor"],
        "r_autorizador"    => (int)$row["r_autorizador"],
        "r_analista"       => (int)$row["r_analista"],
        "estatus"          => (int)$row["estatus"],
        "usuario_created_at" => $row["usuario_created_at"],
        "usuario_updated_at" => $row["usuario_updated_at"],
        "acceso_created_at"  => $row["acceso_created_at"],
        "acceso_updated_at"  => $row["acceso_updated_at"]
    ];
}

echo json_encode([
    "success"  => true,
    "usuarios" => $usuarios
]);

$stmt->close();
$con->close();
