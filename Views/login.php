<!DOCTYPE html>
<html lang="en-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/loging.css">
    <title>Login Validate</title>
</head>
<body>
    <div class="login-container">
        <form class="login-form">
            <h1>Iniciar Sesión</h1>
            <div class="input-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" required>
            </div>
            <button type="submit">Entrar</button>
            <p class="forgot-password"><a href="#">¿Olvidaste tu contraseña?</a></p>
        </form>
    </div>
</body>
</html>