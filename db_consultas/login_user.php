<?php
    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $username_valor = '"' . $username . '"';
    $password_valor = '"' . $password . '"';


    $inc = include "../db/Conexion.php";

    $query ='select 
                acc.user_id, 
                acc.user_name, 
                acc.user_password, 
                acc.user_type, 
                acc.r_ejecutivo, 
                acc.r_editor, 
                acc.r_autorizador, 
                acc.r_analista, 
                us.user_name, 
                us.second_name, 
                us.last_name, 
                us.email, 
                us.cumpleaños, 
                us.telefono
            from mobility_solutions.tmx_acceso_usuario  as acc
            left join mobility_solutions.tmx_usuario as us
                on acc.user_id = us.id
            where (acc.user_name = '.$username_valor.'
                or us.email = '.$username_valor.')
                and acc.user_password = '.$password_valor.';';

    $result = mysqli_query($con,$query); 

    if (mysqli_num_rows($result) > 0 ){
        $_SESSION['username'] = $username_valor;
        header("Location: https://mobilitysolutionscorp.com/views/Home.php", TRUE, 301);
        exit();
    } else{
        echo ' 
            <script>
                alert("Usuario o contraseña invalido, por favor verifique sus datos") ;
                window.location = "../views/login.php";
            </script> ';
            exit();
        
    }


?>