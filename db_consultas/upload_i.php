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

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resultado de carga</title>
    <link rel="stylesheet" href="CSS/detalles.css">

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