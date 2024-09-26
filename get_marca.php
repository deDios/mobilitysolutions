<?php
$Marca=$_POST['Marca'];
    
    $cadena = "<label for='InputNombre' class='form-label'>Vehiculo</label>
                <select id='InputNombre' class='form-select' aria-label='Default select example' name='InputNombre'>";

$inc = include "db/Conexion.php"; 
    $query = "select 
                    id,
                    marca,
                    auto
                FROM mobility_solutions.tmx_marca_auto
                where marca = '$Marca';";
    $result = mysqli_query($con,$query); 
            if ($result){ 
                while($row = mysqli_fetch_assoc($result)){
                        $id = $row['id'];
                        $auto = $row['auto'];
                    $cadena = $cadena . "<option value='$row[0]'>Open this select menu</option> ";         
                }
            }
            else{
                echo "Falla en conexión";
            }
            echo $cadena . "</select>";
?>
