<?php
$Marca=$_POST['Marca'];
    
    $cadena = " <label for='InputNombre' class='form-label'>Vehiculo</label>
                <select id='InputNombre' class='form-select' aria-label='Default select example' name='InputNombre'>
                    <option value='0'>Menu recuperado</option>
                    <option value='1'>Opcion 1</option>
                </select>";

$inc = include "db/Conexion.php"; 
    $query = "select 
                    id,
                    marca,
                    nombre
                FROM mobility_solutions.tmx_marca_auto
                where marca = 4;";
    
    $result = mysqli_query($con,$query); 
            if ($result){ 
                while($row = mysqli_fetch_assoc($result)){
                                    $id = $row['id'];
                                    $nombre = $row['nombre'];

                    $cadena = $cadena . '<opcion value'. $id .'>'. $nombre .'</option>';
                }
            }
            else{
                echo "Falla en conexión";
            }
            $cadena = $cadena . "</select>"; 
            echo $cadena;
?>
