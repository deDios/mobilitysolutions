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
            <label for="" class="form-label">Se requiere cargar imagenes para el auto
                <br> Foto portada "Colocar nombre Img01.jpg"
                <br> Foto de perfil "Colocar nombre Img02.jpg"
                <br> Foto llanta "Colocar nombre Img03.jpg"
                <br> Foto asientos traseros "Colocar nombre Img04.jpg"
                <br> Foto asientos delanteros "Colocar nombre Img05.jpg"
                <br> Foto motor "Colocar nombre Img06.jpg"
                <br> Foto tablero "Colocar nombre Img07.jpg"
                <br> Foto cajuela "Colocar nombre Img08.jpg"
            </label>
            <form action="" method="post" enctype="multipart/form-data" name = "InputAuto">
            <!-- Input Imagenes ------------------------------------------------------------------->
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="" class="form-label">Carga de imagenes</label>
                            <input class="form-control form-control-sm" type="file" name="archivo[]" multiple="multiple">
                        </div>
                        <button type="submit" class="btn btn-success mt-5">Cargar imagenes</button>
                    </div>
            </form>
        </div>
</div> 

            <?php

                $carpeta = '/home/site/wwwroot/Imagenes/Catalogo';
                $carpeta_id = '/home/site/wwwroot/Imagenes/Catalogo/Auto '.$con->insert_id.'';

                if (isset($_FILES["archivo"]) && $_FILES["archivo"]["name"]) {
                    if ($_FILES['archivo']['error'] == 0) { //Valida si no hay errores
                        $tamanio = 2000; //Tamaño permitido en kb
                        $permitidos = array('jpg', 'jpeg'); //Archivos permitido
                        $ruta_carga = $carpeta_id . $_FILES['archivo']['name'];
                        //Obtenemos la extensión del archivo
                        $arregloArchivo = explode(".", $_FILES['archivo']['name']);
                        $extension = strtolower(end($arregloArchivo));
                        
                        if (in_array($extension, $permitidos)) { //Valida si la extensión es permitida
                            
                            if ($_FILES['archivo']['size'] < ($tamanio * 1024)) { //Valida el tamaño
                                
                                //Valida si no existe la carpeta y la crea
                                if (!file_exists($carpeta_id)) {
                                    mkdir($carpeta_id, 0777);
                                }
                                
                                if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_carga)) {
                                    echo "El archivo se cargó correctamente";
                                    } else {
                                    echo "Error al cargar archivo";
                                }
                                } else {
                                echo "Archivo excede el tamaño permitido";
                            }
                            } else {
                            echo "Archivo no permitido";
                        }
                    } else {
                        echo "No enviaste archivo";
                    }
                }else {
                    echo "No se ha cargado ningun archivo.";
                }
                
            ?>

</body>
</html>