<?php
$id = $_POST['InputId'];
$sucursal = $_POST['InputSucursal'];
$marca = $_POST['InputMarca'];
$auto = $_POST['InputNombre'];
$modelo = $_POST['InputModelo'];
$mensualidad = $_POST['InputMensualidad'];
$costo = $_POST['InputCosto'];
$color = $_POST['InputColor'];
$color_valor = '"' . $color . '"';
$transmision = $_POST['InputTransmision'];
$interior = $_POST['InputInterior'];
$kilometraje = $_POST['InputKilometraje'];
$combustible = $_POST['InputCombustible'];
$cilindros = $_POST['InputCilindros'];
$eje = $_POST['InputEje'];
$pasajeros = $_POST['InputPasajeros'];
$propietarios = $_POST['InputPropietarios'];
$c_type = $_POST['InputType'];

$color_valor = '"' . $color . '"';
$transmision_valor = '"' . $transmision . '"';
$interior_valor = '"' . $interior . '"';
$combustible_valor = '"' . $combustible . '"';
$eje_valor = '"' . $eje . '"';
$c_type_valor = '"' . $c_type . '"';

$inc = include "../db/Conexion.php"; 
$query = 'update mobility_solutions.tmx_auto SET 
nombre = '.$auto.', 
modelo = '.$modelo.', 
marca = '.$marca.', 
mensualidad = '.$mensualidad.', 
costo = '.$costo.', 
sucursal = '.$sucursal.',  
color = '.$color_valor.', 
transmision = '.$transmision_valor.', 
interior = '.$interior_valor.', 
kilometraje = '.$kilometraje.', 
combustible = '.$combustible_valor.', 
cilindros = '.$cilindros.', 
eje = '.$eje_valor.', 
updated_at = NOW(), 
pasajeros = '.$pasajeros.', 
propietarios = '.$propietarios.',
c_type = '.$c_type_valor.' where id = '.$id.';';
        
$result = mysqli_query($con,$query);  
if ($result){ 
   // echo "El auto se actualizo correctamente con ID: ".$id;
}
else{
   // echo "Falla en conexión";
}

            header("Location: https://mobilitysolutionscorp.com/views/edicion_catalogo.php", TRUE, 301);
            exit();

?>


