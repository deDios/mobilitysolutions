<?php
header('Content-Type: application/json'); // Asegurar que la respuesta sea JSON
include "../db/Conexion.php";

session_start();
$query ='select 
                acc.user_id, 
                acc.user_name, 
                acc.user_password, 
                acc.user_type, 
                acc.r_ejecutivo, 
                acc.r_editor, 
                acc.r_autorizador, 
                acc.r_analista, 
                us.user_name as nombre, 
                us.second_name as s_nombre, 
                us.last_name, 
                us.email, 
                us.cumpleaños, 
                us.telefono
            from mobility_solutions.tmx_acceso_usuario  as acc
            left join mobility_solutions.tmx_usuario as us
                on acc.user_id = us.id
            where acc.user_name = '.$_SESSION['username'].';';

    $result = mysqli_query($con,$query); 

    if ($result){ 
        while($row = mysqli_fetch_assoc($result)){
                            $user_id = $row['user_id'];
                            $user_name = $row['user_name'];
                            $user_password = $row['user_password'];
                            $user_type = $row['user_type'];
                            $r_ejecutivo = $row['r_ejecutivo'];
                            $r_editor = $row['r_editor'];
                            $r_autorizador = $row['r_autorizador'];
                            $r_analista = $row['r_analista'];
                            $nombre = $row['nombre'];
                            $s_nombre = $row['s_nombre'];
                            $last_name = $row['last_name'];
                            $email = $row['email'];
                            $cumpleaños = $row['cumpleaños'];
                            $telefono = $row['telefono'];
                           
        }
    }
    else{
        echo 'Falla en conexión.';
    }

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $id_auto = isset($_POST['id_auto']) ? $_POST['id_auto'] : null;

    if (!$id || !$id_auto) {
        echo json_encode(["success" => false, "message" => "Faltan parámetros id o id_auto"]);
        exit;
    }

    // Agregar el ID del usuario logueado en la columna approved_by
    $query2 = "UPDATE mobility_solutions.tmx_requerimiento SET status_req = 3, rechazo_by = ? WHERE id = ?";

    // Actualizar la tabla tmx_requerimiento con el user_id del aprobador
    $stmt2 = mysqli_prepare($con, $query2);
    mysqli_stmt_bind_param($stmt2, "ii", $user_id, $id);
    $success2 = mysqli_stmt_execute($stmt2);

    if ($success2) {
        echo json_encode(["success" => true, "message" => "Requerimiento rechazado correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar los registros.", "error" => mysqli_error($con)]);
    }

    mysqli_stmt_close($stmt2);
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}

header("Location: https://mobilitysolutionscorp.com/views/Autoriza.php", TRUE, 301);
exit();
?>


