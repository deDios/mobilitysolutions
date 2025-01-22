<?php 

    $inc = include "../db/Conexion.php";

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query ='Select * from tmx_acceso_usuario 
    where user_name = '.$username.' 
    or email = '.$username.'
    and user_password = '.$password.';';

    $result = mysqli_query($con,$query); 
    if ($result){
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