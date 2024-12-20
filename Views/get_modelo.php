<?php
$Auto=$_POST['Auto'];
 
    $cadena = "<label for='InputModelo' class='form-label'>Modelo</label>
                <a rel='nofollow' target='_blank' href='https://mobilitysolutionscorp.com/insert_reg_mod.php' class='btn btn-primary btn-sm'>+ Agregar modelo</a>
                <select id='InputModelo' class='form-select' aria-label='Default select example' name='InputModelo'>
                    <option value='0'> Selecciona un Modelo </option>
                    ";

$inc = include "../db/Conexion.php"; 
    $query = "select 
                    id,
                    automovil,
                    nombre as modelo
                FROM mobility_solutions.tmx_modelo
                where automovil = '$Auto' order by nombre asc;";
    $result = mysqli_query($con,$query); 
            if ($result){ 
                while($row = mysqli_fetch_assoc($result)){
                        $id = $row['id'];
                        $modelo = $row['modelo'];
                    $id_valor = '"' . $id . '"';
                    //$cadena = $cadena . "<option value=$id_valor> $nombre </option>";
                    $cadena = $cadena . "<option value=$id_valor> $modelo </option>";         
                }
            }
            else{
                echo "Falla en conexión";
            }
            echo $cadena . "</select>";

?>