<?php
$marca = $_POST['InputMarca'];
$auto = $_POST['InputAuto'];

$auto_valor = '"' . $auto . '"';

$inc = include "../db/Conexion.php"; 
$query = 'insert into tmx_marca_auto (marca, auto, updated_at) values 
('.$auto.','.$auto_valor.',NULL);';
        
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