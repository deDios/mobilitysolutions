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

$img1 = '"' . 'img01' . '"';
$img2 = '"' . 'img02' . '"';
$img3 = '"' . 'img03' . '"';
$img4 = '"' . 'img04' . '"';
$img5 = '"' . 'img05' . '"';
$img6 = '"' . 'img06' . '"';

$inc = include "../db/Conexion.php"; 
$query = 'insert into mobility_solutions.tmx_auto (nombre, modelo, marca, mensualidad, costo, sucursal, img1, img2, img3, img4, img5, img6, color, transmision, interior, kilometraje, combustible, cilindros, eje, estatus, updated_at, pasajeros, propietarios) values
('.$auto.','.$modelo.','.$marca.','.$mensualidad.','.$costo.','.$sucursal.','.$img1.', '.$img2.', '.$img3.', '.$img4.', '.$img5.', '.$img6.','.$color_valor.', '.$transmision_valor.','.$interior_valor.','.$kilometraje.','.$combustible_valor.','.$cilindros.','.$eje_valor.',2,NULL,'.$pasajeros.','.$propietarios.');';
        
$result = mysqli_query($con,$query); 
if ($result){ 
    echo "El auto se inserto correctamente con ID: ".$con->insert_id;
}
else{
    echo "Falla en conexión";
}

$carpeta = '/home/site/wwwroot/Imagenes/Catalogo';
$carpeta_id = '/home/site/wwwroot/Imagenes/Catalogo/Auto '.$con->insert_id.'';
            
    if (file_exists($carpeta_id)){
        echo "Ya existe la carpeta";
    }
    else{
        echo "La carpeta no existe y se creara" . $carpeta_id;
    }
            if (isset($_FILES["archivo"])){
                //if (isset($_FILES["archivo"]) && $_FILES["archivo"]["name"][0]){
                    for ($i=0;$i<count($_FILES["archivo"]["name"]);$i++) {
                        if ($_FILES["archivo"]["type"][$i] == "image/jpg" || $_FILES["archivo"]["type"][$i] == "image/jpeg" ){
                            if (file_exists($carpeta_id)||mkdir($carpeta_id,0777,true)) {
                                $origen_archivo = $_FILES["archivo"]["tmp_name"][$i];
                                $destino_archivo = $carpeta_id.'/'.$_FILES["archivo"]["name"][$i];
                                if(@move_uploaded_file($origen_archivo,$destino_archivo)){
                                    echo "<br>".$_FILES["archivo"]["name"][$i]." - La img fue insertada";
                                }else{
                                    echo "<br>".$_FILES["archivo"]["name"][$i]."La img no pudo ser insertada";
                                }
                            }else{
                                echo "La carpeta no existe";
                            }
                        }else{
                            echo "<br>".$_FILES["archivo"]["name"][$i]." no corresponde a un archivo jpg";
                        }
                    }
                //}
                //else{
                  //  echo "<br> No se ha cargado ningun archivo.";
                //}
            }else{
                echo "<br> No se ha cargado ningun archivo.";
            }

            header("Location: https://mobilitysolutionscorp.com/editar_cat.php",true,301);
            die();
?>

<br>
<a href="editar_cat.php"  class="btn btn-primary mt-5">Regresar a Inicio</a>

</body>
</html>