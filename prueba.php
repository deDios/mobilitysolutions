
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
<div id = "body_detalle"> Este es mi texto </div>

<script src="js/jquery-3.7.1.js">
        var div_detalle = document.getElementById('body_detalle');
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open('GET','detalle.php?cod=5',true);
                xmlhttp.onload = function (){
                    if (xmlhttp.status==200){
                        div_detalle.innerHTML = xmlhttp.responseText;
                    }
                    else{
                        div_detalle.innerHTML = 'Cargando....';
                    }       
            }
            xmlhttp.send();   
        
    </script>

</body>
</html>