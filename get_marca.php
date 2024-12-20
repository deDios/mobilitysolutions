<?php
$Marca=$_POST['Marca'];
    
    $cadena = "<label for='InputNombre' class='form-label'>Vehiculo</label>
                <a rel='nofollow' target='_blank' href='https://mobilitysolutionscorp.com/insert_reg_auto.php' class='btn btn-primary btn-sm'>+ Agregar vehículo</a>
                <select id='InputNombre' class='form-select' aria-label='Default select example' name='InputNombre'>
                <option value='0'> Selecciona un Vehiculo </option>
                ";

$inc = include "db/Conexion.php"; 
    $query = "select 
                    id,
                    marca,
                    auto
                FROM mobility_solutions.tmx_marca_auto
                where marca = '$Marca' order by auto asc;";
    $result = mysqli_query($con,$query); 
            if ($result){ 
                while($row = mysqli_fetch_assoc($result)){
                        $id = $row['id'];
                        $auto = $row['auto'];
                    $id_valor = '"' . $id . '"';
                    $cadena = $cadena . "<option value=$id_valor> $auto </option>";         
                }
            }
            else{
                echo "Falla en conexión";
            }
            echo $cadena . "</select>";
?>
