<?php
    session_start();

    if (isset ($_SESSION['username'])){
        header("Location: https://mobilitysolutionscorp.com/Views/Home.php", TRUE, 301);
        exit();
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="../Imagenes/movility.ico" />
    <link rel="stylesheet" href="../CSS/login.css">

</head>
<body>
    <div class="login-container">
        <form class="login-form" action="../db_consultas/login_user.php" method="POST" enctype="multipart/form-data"> 
            <img src="../Imagenes/logo_MSC.png" alt="Logo de la Empresa" class="logo">
            <h2>Acceso</h2>
            <div class="input-group">
                <label for="username">Usuario/Email</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Entrar</button>
            <p class="forgot-password"><a href="#">¿Olvidaste tu contraseña?</a></p>
        </form>
    </div>
</body>
</html>