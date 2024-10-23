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

$color_valor = '"' . $color . '"';
$transmision_valor = '"' . $transmision . '"';
$interior_valor = '"' . $interior . '"';
$combustible_valor = '"' . $combustible . '"';
$eje_valor = '"' . $eje . '"';

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
propietarios = '.$propietarios.' where id = '.$id.';';
        
$result = mysqli_query($con,$query); 
if ($result){ 
    echo "El auto se actualizo correctamente con ID: ".$id;
}
else{
    echo "Falla en conexión";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resultado de edicion</title>
    <link rel="stylesheet" href="../CSS/detalles.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    
<br>
<a href="../editar_cat.php"  class="btn btn-primary mt-5">Regresar a Inicio</a>


</body>
</html>

