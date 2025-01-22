<?php 

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $inc = include "../db/Conexion.php";

    $query ='Select * from mobility_solutions.tmx_acceso_usuario 
    where user_name = '.$username.'
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