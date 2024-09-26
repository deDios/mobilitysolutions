<?php
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

$img1 = '"' . 'img1' . '"';
$img2 = '"' . 'img2' . '"';
$img3 = '"' . 'img3' . '"';
$img4 = '"' . 'img4' . '"';
$img5 = '"' . 'img5' . '"';
$img6 = '"' . 'img6' . '"';

$inc = include "../db/Conexion.php"; 
$query = 'insert into mobility_solutions.tmx_auto (nombre, modelo, marca, mensualidad, costo, sucursal, img1, img2, img3, img4, img5, img6, color, transmision, interior, kilometraje, combustible, cilindros, eje, estatus, created_at, pasajeros, propietarios) values
('.$auto.','.$modelo.','.$marca.','.$mensualidad.','.$costo.','.$sucursal.','.$img1.', '.$img2.', '.$img3.', '.$img4.', '.$img5.', '.$img6.','.$color_valor.', '.$transmision_valor.','.$interior_valor.','.$kilometraje.','.$combustible_valor.','.$cilindros.','.$eje_valor.',2,NULL,'.$pasajeros.','.$propietarios.');';
        
$result = mysqli_query($con,$query); 
if ($result){ 
}
else{
    echo "Falla en conexión";
}

$carpeta = '/home/site/wwwroot/Imagenes/Catalogo';
$carpeta_id = '/home/site/wwwroot/Imagenes/Catalogo/Auto '.$con->insert_id.'';
if (file_exists($carpeta)) {
    echo "Existe la carpeta 1";
    if (file_exists($carpeta_id)) {
        echo "Existe la carpeta 2";
    }else{
        mkdir($carpeta_id, 0777, true);
        echo 'Se creo carpeta para auto con Id: '.$con->insert_id.' ';
    }
    //file_put_contents('index.php', $contenido);
}else
echo "No existe la carpeta 1";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>insert</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
        <h1>Exito en el registro Id de auto: <?php echo $con->insert_id;?></h1>
        <div class="row mt-5">
            <label for="" class="form-label">Se requiere cargar imagenes para el auto</label>
            <form action="db_consultas/insert_sp.php" method="POST">
            <!-- Input Imagenes ------------------------------------------------------------------->
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg1" class="form-label">Img de portada</label>
                            <input class="form-control form-control-sm" id="FileImg1" type="file">
                        </div>
                    </div>
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg2" class="form-label">Img de perfil</label>
                            <input class="form-control form-control-sm" id="FileImg2" type="file">
                        </div>
                    </div>
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg3" class="form-label">Img de llanta</label>
                            <input class="form-control form-control-sm" id="FileImg3" type="file">
                        </div>
                    </div>
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg4" class="form-label">Img de asientos traseros</label>
                            <input class="form-control form-control-sm" id="FileImg4" type="file">
                        </div>
                    </div>
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg5" class="form-label">Img de asientos delanteros</label>
                            <input class="form-control form-control-sm" id="FileImg5" type="file">
                        </div>
                    </div>
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg6" class="form-label">Img de motor</label>
                            <input class="form-control form-control-sm" id="FileImg6" type="file">
                        </div>
                    </div>
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg7" class="form-label">Img de tablero</label>
                            <input class="form-control form-control-sm" id="FileImg7" type="file">
                        </div>
                    </div>
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg8" class="form-label">Img de cajuela</label>
                            <input class="form-control form-control-sm" id="FileImg8" type="file">
                        </div>
                    </div>
            </form>
        </div>
</div>
</body>
</html>