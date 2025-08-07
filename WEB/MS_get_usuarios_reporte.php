<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

// Validar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
    exit;
}

// Obtener parámetros POST
$input = json_decode(file_get_contents("php://input"), true);
$userId = isset($input['user_id']) ? (int)$input['user_id'] : 0;
$userType = isset($input['user_type']) ? (int)$input['user_type'] : 0;

if (!$userId || !$userType) {
    echo json_encode(["success" => false, "message" => "Faltan parámetros obligatorios."]);
    exit;
}

// Función para obtener subordinados recursivamente
function obtenerSubordinados($con, $id, &$resultados) {
    $stmt = $con->prepare("SELECT user_id FROM mobility_solutions.tmx_acceso_usuario WHERE reporta_a = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $subId = $row['user_id'];
        if (!in_array($subId, $resultados)) {
            $resultados[] = $subId;
            obtenerSubordinados($con, $subId, $resultados); // recursivo
        }
    }

    $stmt->close();
}

// Obtener lista final de IDs de usuarios a mostrar
$ids = [];

if (in_array($userType, [5, 6])) {
    // CTO o CEO, obtener todos
    $query = "SELECT user_id FROM mobility_solutions.tmx_acceso_usuario";
    $res = $con->query($query);
    while ($row = $res->fetch_assoc()) {
        $ids[] = $row['user_id'];
    }
} else {
    // Usuarios regulares: subordinados + self + jefe directo
    $ids[] = $userId;

    // Obtener jefe directo
    $stmt = $con->prepare("SELECT reporta_a FROM mobility_solutions.tmx_acceso_usuario WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($jefeId);
    if ($stmt->fetch() && $jefeId) {
        $ids[] = $jefeId;
    }
    $stmt->close();

    // Subordinados recursivos
    obtenerSubordinados($con, $userId, $ids);
}

// Eliminar duplicados
$ids = array_unique($ids);

// Preparar consulta de usuarios
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$tipos = str_repeat('i', count($ids));
$stmt = $con->prepare("
    SELECT 
        acc.user_id, 
        acc.user_name, 
        acc.user_type, 
        acc.reporta_a,
        acc.r_ejecutivo, 
        acc.r_editor, 
        acc.r_autorizador, 
        acc.r_analista, 
        us.user_name AS nombre, 
        us.second_name AS s_nombre, 
        us.last_name, 
        us.email, 
        us.cumpleaños, 
        us.telefono
    FROM mobility_solutions.tmx_acceso_usuario acc
    LEFT JOIN mobility_solutions.tmx_usuario us ON acc.user_id = us.id
    WHERE acc.user_id IN ($placeholders)
");

$stmt->bind_param($tipos, ...$ids);
$stmt->execute();
$result = $stmt->get_result();

$usuarios = [];

while ($row = $result->fetch_assoc()) {
    switch ((int)$row["user_type"]) {
        case 1:
            $rol = "Asesor(a)";
            break;
        case 2:
            $rol = "Supervisor(a)";
            break;
        case 3:
            $rol = "Analista";
            break;
        case 4:
            $rol = "Manager";
            break;
        case 5:
            $rol = "CTO";
            break;
        case 6:
            $rol = "CEO";
            break;
        default:
            $rol = "Sin rol";
    }

    $usuarios[] = [
        "id" => $row["user_id"],
        "username" => $row["user_name"],
        "rol" => $rol,
        "reporta_a" => $row["reporta_a"],
        "nombre" => trim("{$row['nombre']} {$row['s_nombre']} {$row['last_name']}"),
        "email" => $row["email"],
        "telefono" => $row["telefono"],
        "cumpleaños" => $row["cumpleaños"],
        "foto" => "https://mobilitysolutionscorp.com/Imagenes/Usuarios/{$row['user_id']}.jpg"
    ];
}

echo json_encode([
    "success" => true,
    "usuarios" => $usuarios
]);

$con->close();
?> 
