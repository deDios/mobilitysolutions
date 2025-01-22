<?php 

    $inc = include "../db/Conexion.php";

    $username = $_POST['username'];
    $password = $_POST['password'];

    $validar_login = mysqli_query($inc,"Select * from tmx_acceso_usuario 
    where user_name = '$username' 
    or email = '$username'
    and user_password = '$password';");

    if (mysqli_num_rows($validar_login)>0){
        header("Location: https://mobilitysolutionscorp.com/views/edicion_catalogo.php", TRUE, 301);
        exit();
    } else{
        echo '
            <script>
                alert("Usuario no existe, por favor verifique los datos introducidos") ;
                window.location = "login.php";
            </script> ';
            exit;
        
        
    }

?>