<?php
$Marca=$_POST['Marca'];
$inc = include "db/Conexion.php";    
echo("<script>console.log('. $Marca .');</script>");
    if ($inc){
        $query = 'select 
                    id,
                    marca,
                    nombre
                FROM mobility_solutions.tmx_marca_auto
                where marca='. $Marca .';';
        $result = mysqli_query($con,$query);  
    
        $cadena = " <label for='InputNombre' class='form-label'>Vehiculo</label>
                    <select id='InputNombre' class='form-select' aria-label='Default select example' name='InputNombre'>";
        if ($result){ 
            while ($ver=mysqli_fetch_row($result)){
                $cadena=$cadena. '<opcion value'.$ver['id'].'>'.$ver['nombre'].'</option>';
            }
        }
        else{
            echo "Hubo un error en la consulta";
        }
        echo $cadena."</select>";
    }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>get_marca</title>
</head>
<body>
    
</body>
</html>