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
        <form class="login-form" action="../db_consultas/login_usuario_be.php" method="POST" enctype="multipart/form-data"> 
            <img src="../Imagenes/logo_MSC.png" alt="Logo de la Empresa" class="logo">
            <h2>Acceso</h2>
            <div class="input-group">
                <label for="user_name">Usuario/Email</label>
                <input type="text" id="user_name" name="user_name" required>
            </div>
            <div class="input-group">
                <label for="pass">Contraseña</label>
                <input type="pass" id="pass" name="pass" required>
            </div>
            <button type="submit">Entrar</button>
            <p class="forgot-password"><a href="#">¿Olvidaste tu contraseña?</a></p>
        </form>
    </div>
</body>
</html>