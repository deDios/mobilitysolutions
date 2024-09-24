
<?php
include "Conexion.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Mobility solutions</title>
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>
<div id = "body_detalle"> esta es mi texto </div>
<script src="js/jquery-3.2.1.min.js">
        var div_detalle = document.getElementById("body_detalle");
        function abrir_detalle(){
                var xmlhttp; 
                if(window.XMLHttpRequest){
                    xmlhttp = new XMLHttpRequest();
                }
                else{
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onload = function (){
                    if (xmlhttp.status==200){
                        div_detalle.innerHTML = xmlhttp.responseText;
                    }
                    else{
                        div_detalle.innerHTML = "Cargando....";
                    }       
            }
            xmlhttp.open("GET","detalle.php?cod=2",true);
            xmlhttp.send();   
        }
    </script>

</body>
</html>