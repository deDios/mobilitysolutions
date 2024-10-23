<?php
$id_get = $_GET['i'];

$carpeta = '/home/site/wwwroot/Imagenes/Catalogo';
$carpeta_id = '/home/site/wwwroot/Imagenes/Catalogo/Auto '.$id_get.'';
            
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


?>