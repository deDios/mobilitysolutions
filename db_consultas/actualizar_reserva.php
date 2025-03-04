<?php
header('Content-Type: application/json'); // Asegurar que la respuesta sea JSON
include "../db/Conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $id_auto = isset($_POST['id_auto']) ? $_POST['id_auto'] : null;

    if (!$id || !$id_auto) {
        echo json_encode(["success" => false, "message" => "Faltan parámetros id o id_auto"]);
        exit;
    }

    $query1 = "UPDATE mobility_solutions.tmx_auto SET estatus = 3 WHERE id = ?";
    $query2 = "UPDATE mobility_solutions.tmx_requerimiento SET status_req = 2 WHERE id = ?";

    $stmt1 = mysqli_prepare($con, $query1);
    mysqli_stmt_bind_param($stmt1, "i", $id_auto);
    $success1 = mysqli_stmt_execute($stmt1);

    $stmt2 = mysqli_prepare($con, $query2);
    mysqli_stmt_bind_param($stmt2, "i", $id);
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


