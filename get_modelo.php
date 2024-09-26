<?php
$Auto=$_POST['Auto'];
 
    $cadena = "<label for='InputModelo' class='form-label'>Modelo</label>
                <select id='InputModelo' class='form-select' aria-label='Default select example' name='InputModelo'>
                    <option value='0'> $cadena </option>
                </select>";

echo $cadena;

$inc = include "db/Conexion.php"; 
    $query = "select 
                    id,
                    automovil,
                    nombre
                FROM mobility_solutions.tmx_modelo
                where automovil = '$Auto';";
    $result = mysqli_query($con,$query); 
            if ($result){ 
                while($row = mysqli_fetch_assoc($result)){
                        $id = $row['id'];
                        $nombre = $row['nombre'];
                    $id_valor = '"' . $id . '"';
                    $cadena = $cadena . "<option value=$id_valor> $nombre </option>";         
                }
            }
            else{
                echo "Falla en conexión";
            }
            echo $cadena . "</select>";
?>