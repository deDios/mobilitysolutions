<?php
header('Content-Type: application/json'); // Asegurar que la respuesta sea JSON
include "../db/Conexion.php";

session_start();
if (!isset($_SESSION['username'])) {
    echo json_encode(["success" => false, "message" => "Es necesario hacer login, por favor ingrese sus credenciales"]);
    exit;
}

if (!$con) {
    echo json_encode(["success" => false, "message" => "Falla en la conexión a la base de datos"]);
    exit;
}

$query_user = 'SELECT user_id FROM mobility_solutions.tmx_acceso_usuario WHERE user_name = ?';
$stmt_user = mysqli_prepare($con, $query_user);

mysqli_stmt_bind_param($stmt_user, "s", $_SESSION['username']);
mysqli_stmt_execute($stmt_user);
$result_user = mysqli_stmt_get_result($stmt_user);

if ($result_user && $row = mysqli_fetch_assoc($result_user)) {
    $user_id = $row['user_id'];
} else {
    echo json_encode(["success" => false, "message" => "No se encontró el ID del usuario"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $id_auto = isset($_POST['id_auto']) ? $_POST['id_auto'] : null;

    if (!$id || !$id_auto) {
        echo json_encode(["success" => false, "message" => "Faltan parámetros id o id_auto"]);
        exit;
    }

    // Agregar el ID del usuario logueado en la columna approved_by
    $query1 = "UPDATE mobility_solutions.tmx_auto SET estatus = 3 WHERE id = ?";
    $query2 = "UPDATE mobility_solutions.tmx_requerimiento SET status_req = 2, approved_by = ? WHERE id = ?";

    // Actualizar la tabla tmx_auto
    $stmt1 = mysqli_prepare($con, $query1);
    mysqli_stmt_bind_param($stmt1, "i", $id_auto);
    $success1 = mysqli_stmt_execute($stmt1);

    // Actualizar la tabla tmx_requerimiento con el user_id del aprobador
    $stmt2 = mysqli_prepare($con, $query2);
    mysqli_stmt_bind_param($stmt2, "ii", $user_id, $id);
    $success2 = mysqli_stmt_execute($stmt2);

    if ($success1 && $success2) {
        echo json_encode(["success" => true, "message" => "Requerimiento aprobado correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar los registros.", "error" => mysqli_error($con)]);
    }

    mysqli_stmt_close($stmt1);
    mysqli_stmt_close($stmt2);
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}

header("Location: https://mobilitysolutionscorp.com/views/Autoriza.php", TRUE, 301);
exit();
?>


