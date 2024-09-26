<?php
$Marca=$_POST['Marca'];
    
    $cadena = "<label for='InputNombre' class='form-label'>Vehiculo</label>
                <select id='InputNombre' class='form-select' aria-label='Default select example' name='InputNombre'>
                    <option value='0'>Menu recuperado</option>";

$inc = include "db/Conexion.php"; 
    $query = "select 
                    id,
                    marca,
                    auto
                FROM mobility_solutions.tmx_marca_auto
                where marca = 4;";
    
    $result = mysqli_query($con,$query); 
            if ($result){ 
                while($row = mysqli_fetch_assoc($result)){
                                    $id = $row['id'];
                                    $auto = $row['auto'];

                    $cadena = $cadena . '<opcion value'. $id .'>'. $auto .'</option>';
                }
            }
            else{
                echo "Falla en conexión";
            }
            echo $cadena . "</select>";
?>
