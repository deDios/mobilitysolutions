<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$inc = include "../db/Conexion.php";

// Escapamos para evitar SQL Injection
$username_esc = mysqli_real_escape_string($con, $username);
$password_esc = mysqli_real_escape_string($con, $password);

$query = "SELECT 
            acc.user_id, 
            acc.user_name, 
            acc.user_password, 
            acc.user_type, 
            acc.r_ejecutivo, 
            acc.r_editor, 
            acc.r_autorizador, 
            acc.r_analista, 
            us.user_name AS nombre_real, 
            us.second_name, 
            us.last_name, 
            us.email, 
            us.cumpleaños, 
            us.telefono
        FROM mobility_solutions.tmx_acceso_usuario acc
        LEFT JOIN mobility_solutions.tmx_usuario us
            ON acc.user_id = us.id
        WHERE 
            (acc.user_name = '$username_esc' OR us.email = '$username_esc')
            AND acc.user_password = '$password_esc'";

$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['username'] = $username;
    header("Location: https://mobilitysolutionscorp.com/views/Home.php", TRUE, 301);
    exit();
} else {
    echo '<script>
        alert("Usuario o contraseña incorrectos. Verifique sus datos.");
        window.location = "../views/login.php";
    </script>';
    exit();
}
?>
