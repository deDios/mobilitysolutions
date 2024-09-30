<?php
$marca = $_POST['InputMarca'];
$auto_1 = $_POST['InputNombre'];
$auto = $_POST['InputAuto'];

$auto_valor = '"' . $auto . '"';

$inc = include "../db/Conexion.php"; 
$query = 'insert into mobility_solutions.tmx_marca_auto (marca, auto, updated_at) values 
('.$marca.','.$auto_valor.',NULL);';
        
$result = mysqli_query($con,$query); 
if ($result){ 
    echo "El auto se inserto correctamente con ID: ".$con->insert_id;
}
else{
    echo "Falla en conexión";
}

?>
</body>
</html>