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
    
        $cadena = " <label for='InputNombre' class='form-label'>Vehiculo</label>
                    <select id='InputNombre' class='form-select' aria-label='Default select example' name='InputNombre'>";

        while ($ver=mysqli_fetch_row($result)){
            $cadena=$cadena. '<opcion value'.$ver['id'].'>'.$ver['nombre'].'</option>';
        }
        echo $cadena."</select>";
    }
?>