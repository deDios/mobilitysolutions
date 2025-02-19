<?php
include "../db/Conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $id_auto = $_POST['id_auto'];

    if ($id && $id_auto) {
        $query1 = "UPDATE mobility_solutions.tmx_auto SET estatus = 1 WHERE id = ?";
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
            echo json_encode(["success" => false, "message" => "Error al actualizar los registros."]);
        }

        mysqli_stmt_close($stmt1);
        mysqli_stmt_close($stmt2);
    } else {
        echo json_encode(["success" => false, "message" => "Faltan parámetros."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
?>

