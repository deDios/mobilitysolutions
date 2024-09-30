<?php
$marca = $_POST['InputMarca'];
$auto = $_POST['InputNombre'];
$modelo = $_POST['InputModelo'];
$mod = $_POST['InputMod'];

$mod_valor = '"' . $mod . '"';

$inc = include "../db/Conexion.php"; 
$query = 'insert into mobility_solutions.tmx_modelo (marca, automovil, nombre, updated_at) values 
('.$marca.','.$auto.','.$mod_valor.',NULL);';
        
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