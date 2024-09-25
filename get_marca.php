<?php
$Marca=$_POST['Marca'];
$inc = include "db/Conexion.php";    
    if ($inc){
        $query = 'select 
                    id,
                    marca,
                    nombre
                FROM mobility_solutions.tmx_marca_auto
                where='. $Marca .'
                ;';
        $result = mysqli_query($con,$query);  
    
        $cadena = "<label for='InputNombre' class='form-label'>Vehiculo</label>
                    <input type='text' class='form-control' id='InputNombre'>";

        while ($ver=mysqli_fetch_row($result)){
            $cadena=$cadena. '<opcion value'.$ver['id'].'>'.$ver[2].'</option>';
        }
        echo $cadena."</select>";
    }
?>