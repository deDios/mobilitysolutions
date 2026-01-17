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

$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    echo json_encode([
        "success" => false,
        "message" => "Cuerpo JSON inválido"
    ]);
    exit;
}

$id          = isset($input["id"]) ? (int)$input["id"] : 0;  // 0 = nuevo
$nombre      = trim($input["user_name"]    ?? "");
$secondName  = trim($input["second_name"]  ?? "");
$lastName    = trim($input["last_name"]    ?? "");
$email       = trim($input["email"]        ?? "");
$cumpleanos  = trim($input["cumpleanos"]   ?? ($input["cumpleaños"] ?? ""));
$telefono    = trim($input["telefono"]     ?? "");

$login       = trim($input["login"]        ?? ($input["user_login"] ?? ""));
$userType    = isset($input["user_type"]) ? (int)$input["user_type"] : 0;
$reportaA    = isset($input["reporta_a"]) && $input["reporta_a"] !== ""
             ? (int)$input["reporta_a"]
             : null;

$r_ejecutivo   = !empty($input["r_ejecutivo"])   ? 1 : 0;
$r_editor      = !empty($input["r_editor"])      ? 1 : 0;
$r_autorizador = !empty($input["r_autorizador"]) ? 1 : 0;
$r_analista    = !empty($input["r_analista"])    ? 1 : 0;

$estatus = isset($input["estatus"]) ? (int)$input["estatus"] : 1;

// Solo para creación:
$password = isset($input["password"]) ? trim($input["password"]) : "";

// Validaciones básicas
$errores = [];
if ($nombre === "")      $errores[] = "El nombre es requerido";
if ($lastName === "")    $errores[] = "El apellido es requerido";
if ($email === "")       $errores[] = "El email es requerido";
if ($cumpleanos === "")  $errores[] = "La fecha de cumpleaños es requerida";
if ($telefono === "")    $errores[] = "El teléfono es requerido";
if ($login === "")       $errores[] = "El login de acceso es requerido";
if ($userType <= 0)      $errores[] = "El tipo de usuario es requerido";

if ($id === 0 && $password === "") {
    $errores[] = "La contraseña es obligatoria para un nuevo usuario";
}

if (!empty($errores)) {
    echo json_encode([
        "success" => false,
        "message" => "Errores de validación",
        "errors"  => $errores
    ]);
    exit;
}

$con->begin_transaction();

try {
    // Validar email único
    if ($id === 0) {
        $stmt = $con->prepare("
            SELECT id FROM mobility_solutions.tmx_usuario
            WHERE email = ?
            LIMIT 1
        ");
        $stmt->bind_param("s", $email);
    } else {
        $stmt = $con->prepare("
            SELECT id FROM mobility_solutions.tmx_usuario
            WHERE email = ? AND id <> ?
            LIMIT 1
        ");
        $stmt->bind_param("si", $email, $id);
    }
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        throw new Exception("El email ya está registrado en otro usuario.");
    }
    $stmt->close();

    // Validar login único
    if ($id === 0) {
        $stmt = $con->prepare("
            SELECT id FROM mobility_solutions.tmx_acceso_usuario
            WHERE user_name = ?
            LIMIT 1
        ");
        $stmt->bind_param("s", $login);
    } else {
        $stmt = $con->prepare("
            SELECT id FROM mobility_solutions.tmx_acceso_usuario
            WHERE user_name = ? AND user_id <> ?
            LIMIT 1
        ");
        $stmt->bind_param("si", $login, $id);
    }
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        throw new Exception("El login de acceso ya está asignado a otro usuario.");
    }
    $stmt->close();

    if ($id === 0) {
        // ----------- CREAR NUEVO USUARIO -----------

        // 1) Insert tmx_usuario
        $stmt = $con->prepare("
            INSERT INTO mobility_solutions.tmx_usuario
                (user_name, second_name, last_name, email, cumpleaños, telefono)
            VALUES (?,?,?,?,?,?)
        ");
        $stmt->bind_param(
            "ssssss",
            $nombre,
            $secondName,
            $lastName,
            $email,
            $cumpleanos,
            $telefono
        );
        $stmt->execute();
        $nuevoId = $con->insert_id;
        $stmt->close();

        // 2) Insert tmx_acceso_usuario
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $con->prepare("
            INSERT INTO mobility_solutions.tmx_acceso_usuario
                (user_id, user_name, user_password, user_type, reporta_a,
                 r_ejecutivo, r_editor, r_autorizador, r_analista, estatus)
            VALUES (?,?,?,?,?,?,?,?,?,?)
        ");
        $stmt->bind_param(
            "issiiiiiii",
            $nuevoId,
            $login,
            $passwordHash,
            $userType,
            $reportaA,
            $r_ejecutivo,
            $r_editor,
            $r_autorizador,
            $r_analista,
            $estatus
        );
        $stmt->execute();
        $stmt->close();

        $idUsuarioFinal = $nuevoId;
        $accion         = "creado";

    } else {
        // ----------- ACTUALIZAR USUARIO EXISTENTE -----------

        // 1) Update tmx_usuario
        $stmt = $con->prepare("
            UPDATE mobility_solutions.tmx_usuario
               SET user_name  = ?,
                   second_name= ?,
                   last_name  = ?,
                   email      = ?,
                   cumpleaños = ?,
                   telefono   = ?,
                   updated_at = NOW()
             WHERE id = ?
        ");
        $stmt->bind_param(
            "ssssssi",
            $nombre,
            $secondName,
            $lastName,
            $email,
            $cumpleanos,
            $telefono,
            $id
        );
        $stmt->execute();
        $stmt->close();

        // 2) Update tmx_acceso_usuario (sin tocar password)
        $stmt = $con->prepare("
            UPDATE mobility_solutions.tmx_acceso_usuario
               SET user_name    = ?,
                   user_type    = ?,
                   reporta_a    = ?,
                   r_ejecutivo  = ?,
                   r_editor     = ?,
                   r_autorizador= ?,
                   r_analista   = ?,
                   estatus      = ?,
                   updated_at   = NOW()
             WHERE user_id = ?
        ");
        $stmt->bind_param(
            "siiiiiiii",
            $login,
            $userType,
            $reportaA,
            $r_ejecutivo,
            $r_editor,
            $r_autorizador,
            $r_analista,
            $estatus,
            $id
        );
        $stmt->execute();
        $stmt->close();

        $idUsuarioFinal = $id;
        $accion         = "actualizado";
    }

    $con->commit();

    echo json_encode([
        "success" => true,
        "message" => "Usuario {$accion} correctamente",
        "id"      => $idUsuarioFinal
    ]);

} catch (Exception $e) {
    $con->rollback();
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$con->close();
