<?

    $username = $_POST['username'];
    $password = $_POST['password'];

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
            where acc.user_name = '.$username.'
                or us.email = '.$username.'
                and acc.user_password = '.$password.';';

    $result = mysqli_query($con,$query); 

echo 'Hola mundo '.$username.' y '.$password.''

?>