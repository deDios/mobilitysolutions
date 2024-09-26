<?php
$sucursal = $_POST['InputSucursal'];
$marca = $_POST['InputMarca'];
$auto = $_POST['InputNombre'];
$modelo = $_POST['InputModelo'];
$mensualidad = $_POST['InputMensualidad'];
$costo = $_POST['InputCosto'];
$color = $_POST['InputColor'];
$transmision = $_POST['InputTransmision'];
$interior = $_POST['InputInterior'];
$kilometraje = $_POST['InputKilometraje'];
$combustible = $_POST['InputCombustible'];
$cilindros = $_POST['InputCilindros'];
$eje = $_POST['InputEje'];
$pasajeros = $_POST['InputPasajeros'];
$propietarios = $_POST['InputPropietarios'];

$inc = include "db/Conexion.php"; 
$query = "insert into tmx_auto (nombre, modelo, marca, mensualidad, costo, sucursal, img1, img2, img3, img4, img5, img6, color, transmision, interior, kilometraje, combustible, cilindros, eje, estatus, created_at, pasajeros, propietarios) values
($auto,$modelo,$marca,$mensualidad,$costo,$sucursal,'img1', 'img2', 'img3', 'img4', 'img5', 'img6', '$color', '$transmision','$interior',$kilometraje,'$combustible',$cilindros,'$eje',2,NULL,$pasajeros,$propietarios);";
        $result = mysqli_query($con,$query); 

echo "sucursal" . $sucursal;
echo "marca" . $marca;
echo "auto" . $auto;
echo "modelo" . $modelo;
echo "mensualidad" . $mensualidad;
echo "costo" . $costo;
echo "color" . $color;
echo "transmision" . $transmision;
echo "interior" . $interior;
echo "kilometraje" . $kilometraje;
echo "combustible" . $combustible;
echo "cilindros" . $cilindros;
echo "eje" . $eje;
echo "pasajeros" . $pasajeros;
echo "propietarios" . $propietarios;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>insert</title>
</head>
<body>
    
</body>
</html>