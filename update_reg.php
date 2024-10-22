<?php

$inc = include "db/Conexion.php"; 
    $id_update = $_GET['i'];
    $sucursal_update = $_GET['s'];
    $marca_update = $_GET['m'];
    $vehiculo_update = $_GET['v'];
    $modelo_update = $_GET['mm'];
    
        $query = 'select 
        auto.id,
        m_auto.auto as nombre, 
        modelo.nombre as modelo, 
        marca.nombre as marca, 
        auto.mensualidad, 
        auto.costo, 
        sucursal.nombre as sucursal, 
        auto.img1, 
        auto.img2, 
        auto.img3, 
        auto.img4, 
        auto.img5, 
        auto.img6, 
        auto.color, 
        auto.transmision, 
        auto.interior, 
        auto.kilometraje, 
        auto.combustible, 
        auto.cilindros, 
        auto.eje, 
        auto.estatus, 
        auto.pasajeros, 
        auto.propietarios,
        auto.created_at, 
        auto.updated_at 
    FROM mobility_solutions.tmx_auto as auto
    left join mobility_solutions.tmx_sucursal as sucursal on auto.sucursal = sucursal.id 
    left join mobility_solutions.tmx_estatus as estatus on auto.estatus = estatus.id
    left join mobility_solutions.tmx_modelo as modelo on auto.modelo = modelo.id 
    left join mobility_solutions.tmx_marca as marca on auto.marca = marca.id
    left join mobility_solutions.tmx_marca_auto as m_auto on auto.nombre = m_auto.id
    where auto.id = '. $id_update .';';

    $result = mysqli_query($con,$query); 
    if ($result){ 
    while($row = mysqli_fetch_assoc($result)){
                        $id_get = $row['id'];
                        $nombre_get = $row['nombre'];
                        $modelo_get = $row['modelo'];
                        $marca_get = $row['marca'];
                        $mensualidad_get = $row['mensualidad'];
                        $costo_get = $row['costo'];
                        $color_get = $row['color'];
                        $interior_get = $row['interior'];
                        $combustible_get = $row['combustible'];
                        $cilindros_get = $row['cilindros'];
                        $transmision_get = $row['transmision'];
                        $kilometraje_get = $row['kilometraje'];
                        $eje_get = $row['eje'];
                        $pasajeros_get = $row['pasajeros'];
                        $propietarios_get = $row['propietarios'];
    }
    }
    else{
    echo "Falla en conexión";
    }

    echo("<script>console.log('PHP: " . $costo_get . "');</script>");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.datatables.net/v/dt/dt-2.1.7/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.css" rel="stylesheet"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <title>Insertar cat</title>
    <link rel="stylesheet" href="CSS/insert_reg.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    

</head>
<body>

    <div class="container">
        <h1>Actualizar auto</h1>
        <div class="row mt-5">
            <form action="db_consultas/update_sp.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="col-2 mt-5">
                        <label for="InputSucursal" class="form-label">Sucursal</label>
                        <select id="InputSucursal" class="form-select" aria-label="Default select example" name="InputSucursal">
                            <option value="0">Selecciona una sucursal</option>                      
                            <?php 
                            $inc = include "db/Conexion.php";    
                                if ($inc){
                                    $query = 'select 
                                                id,
                                                nombre
                                            FROM mobility_solutions.tmx_sucursal;';
                                    $result = mysqli_query($con,$query);  
                                    if ($result){         
                                        while($row = mysqli_fetch_assoc($result)){
                                            $id = $row['id'];
                                            $nombre = $row['nombre'];
                            ?> 
                                        <option value="<?php echo $id;?>"><?php echo $nombre;?></option>
                            <?php
                                        }
                                    } else{
                                            echo "Hubo un error en la consulta";
                                    }
                                        mysqli_free_result($result);                  
                                }
                            ?>
                        </select>
                    </div>
            
                    <div class="col-3 mt-5">
                        <label for="InputMarca" class="form-label">Marca</label>
                        <select id="InputMarca" class="form-select" aria-label="Default select example" name="InputMarca">
                            <option value="0">Selecciona una Marca</option>                      
                            <?php 
                            $inc = include "db/Conexion.php";    
                                if ($inc){
                                    $query = 'select 
                                                id,
                                                nombre
                                            FROM mobility_solutions.tmx_marca;';
                                    $result = mysqli_query($con,$query);  
                                    if ($result){         
                                        while($row = mysqli_fetch_assoc($result)){
                                            $id = $row['id'];
                                            $nombre = $row['nombre'];
                            ?> 
                                        <option value="<?php echo $id;?>"><?php echo $nombre;?></option>
                            <?php
                                        }
                                    } else{
                                            echo "Hubo un error en la consulta";
                                    }
                                        mysqli_free_result($result);                  
                                }
                            ?>
                        </select>
                    </div>
                    <div class="row mt-3">
                    <!-- Input Auto ------------------------------------------------------------------->
                        <div id="div_auto" class="col-3">
                            <label for='InputNombre' class='form-label'>Vehiculo</label>
                            <select id="InputNombre" class="form-select" aria-label="Default select example" name="InputNombre">
                                <option value="0">Selecciona un Vehiculo</option> 
                            </select>
                        </div>

                    <!-- Input Modelo ------------------------------------------------------------------->
                        <div id="div_modelo" class="col-3">
                            <label for='InputModelo' class='form-label'>Modelo</label>
                            <select id="InputModelo" class="form-select" aria-label="Default select example" name="InputModelo">
                                <option value="0">Selecciona un Modelo</option> 
                            </select>
                        </div>
                    </div>
                    
                    <!-- Input Mensualidad ------------------------------------------------------------------->
                    <div class="input-group mb-3 col-6 mt-5">
                        <span class="input-group-text">$</span>
                            <input id="InputMensualidad" type="text" class="form-control" name="InputMensualidad" aria-label="Amount (to the nearest dollar)" value="<?php echo $mensualidad_get;?>" required>
                        <span class="input-group-text">MX/mensuales</span>
                    </div>
                    <div class="invalid-feedback">
                        Porfavor llenar campo de mensualidad
                    </div>

                    <!-- Input Costo ------------------------------------------------------------------->
                    <div class="input-group mb-3 col-6 mt-2">
                        <span class="input-group-text">$</span>
                            <input id="InputCosto" type="text" class="form-control" name="InputCosto" aria-label="Amount (to the nearest dollar)" value="<?php echo $costo_get;?>">
                        <span class="input-group-text">MX/Contado</span>
                    </div>

                    <!-- Input Color ------------------------------------------------------------------->
                    <div class="col-2 mt-5">
                        <label for="InputColor" class="form-label">Color</label>
                        <select id="InputColor" class="form-select" aria-label="Default select example" name="InputColor">
                            <option value="Negro">Negro</option>  
                            <option value="Rojo">Rojo</option>  
                            <option value="Azul">Azul</option>  
                            <option value="Blanco">Blanco</option>  
                            <option value="Verde">Verde</option>
                            <option value="Gris">Gris</option>
                            <option value="Amarillo">Amarillo</option>
                            <option value="Arena">Arena</option>  
                        </select>
                    </div>

                    <!-- Input Transmision ------------------------------------------------------------------->
                    <div class="col-2 mt-2">
                        <label for='InputTransmision' class='form-label'>Tipo de transmision</label>
                        <div class="col mb-3 form-check"> 
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputTransmision" id="InputTransmision" value="Manual" checked="">
                                <label class="form-check-label" for="InputTransmision">TM (Manual)</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputTransmision" id="InputTransmision" value="Automatico">
                                <label class="form-check-label" for="InputTransmision">TA (Automatico)</label>
                            </div>
                        </div>
                    </div>

                    <!-- Input Interior ------------------------------------------------------------------->
                    <div class="col-2 mt-2">
                        <label for='InputInterior' class='form-label'>Interior</label>
                        <div class="col mb-3 form-check"> 
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputInterior" id="InputInterior" value="Tela" checked="">
                                <label class="form-check-label" for="InputInterior">Tela</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputInterior" id="InputInterior" value="Piel">
                                <label class="form-check-label" for="InputInterior">Piel</label>
                            </div>
                        </div>
                    </div>

                    <!-- Input kilometraje ------------------------------------------------------------------->
                    <div class="col-2 mt-2">
                        <label for='InputKilometraje' class='form-label'>Kilometraje</label>
                        <div class="input-group mb-3 ">
                                <input id="InputKilometraje" type="text" class="form-control" name="InputKilometraje"  aria-label="Amount (to the nearest dollar)" value="<?php echo $kilometraje_get;?>">
                            <span class="input-group-text">km</span>
                        </div>
                    </div>

                    <!-- Input Combustible ------------------------------------------------------------------->
                    <div class="col-3 mt-2">
                        <label for='InputCombustible' class='form-label'>Combustible</label>
                        <div class="col mb-3 form-check"> 
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible" value="Gasolina" checked="">
                                <label class="form-check-label" for="InputCombustible">Gasolina</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible" value="Electrico">
                                <label class="form-check-label" for="InputCombustible">Electrico</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible" value="Hibrido">
                                <label class="form-check-label" for="InputCombustible">Hibrido</label>
                            </div>
                        </div>
                    </div>

                    <!-- Input Cilindros ------------------------------------------------------------------->
                    <div class="col-6 mt-2">
                    <label for='InputCilindros' class='form-label'>Cilindros</label>
                        <div class="p-3 m-0 border-0 bd-example m-0 border-0">
                            <input type="radio" class="btn-check" name="InputCilindros" value="4" id="InputCilindros1" autocomplete="off" checked="">
                            <label class="btn" for="InputCilindros1">V4</label>
                            
                            <input type="radio" class="btn-check" name="InputCilindros" value="6" id="InputCilindros2" autocomplete="off">
                            <label class="btn" for="InputCilindros2">V6</label>
                            
                            <input type="radio" class="btn-check" name="InputCilindros" value="8" id="InputCilindros3" autocomplete="off">
                            <label class="btn" for="InputCilindros3">V8</label>
                            
                            <input type="radio" class="btn-check" name="InputCilindros" value="10" id="InputCilindros4" autocomplete="off">
                            <label class="btn" for="InputCilindros4">V10</label>

                            <input type="radio" class="btn-check" name="InputCilindros" value="12" id="InputCilindros5" autocomplete="off">
                            <label class="btn" for="InputCilindros5">V12</label>
                        </div>
                    </div>

                    <!-- Input eje ------------------------------------------------------------------->
                    <div class="col-2 mt-2">
                        <label for="InputEje" class="form-label">Eje</label>
                        <select id="InputEje" class="form-select" aria-label="Default select example" name="InputEje">
                            <option value="Delantera">Delantera</option>  
                            <option value="Trasera">Trasera</option>  
                            <option value="4X4">4X4</option>  
                        </select>
                    </div>

                    <!-- Input pasajeros ------------------------------------------------------------------->
                    <div class="col-2 mt-2">
                        <label for='InputPasajeros' class='form-label'>Capacidad de pasajeros</label>
                        <div class="input-group mb-3 ">
                                <input id="InputPasajeros" type="text" class="form-control" name="InputPasajeros" aria-label="Amount (to the nearest dollar)" value="<?php echo $pasajeros_get;?>">
                            <span class="input-group-text">Pasajeros</span>
                        </div>
                    </div>

                    <!-- Input Propietarios ------------------------------------------------------------------->
                    <div class="col-2 mt-2">
                        <label for="InputPropietarios" class="form-label">Propietarios</label>
                        <select id="InputPropietarios" class="form-select" aria-label="Default select example" name="InputPropietarios">
                            <option value="1">1</option>  
                            <option value="2">2</option>  
                        </select>
                    </div>

                    <!-- Input Img ------------------------------------------------------------------->
                    <div class="col-2 mt-5">
                        <div class="mb-3">
                            <label for="" class="form-label">Carga de imagenes</label>
                            <input class="form-control form-control-sm" type="file" name="archivo[]" multiple="multiple">
                        </div>
                    </div>


                    <button type="submit" class="btn btn-success mt-5">Actualizar</button>
            </form>
        </div>
    </div>
                    <script >
                        $(document).ready(function(){
                            $('#InputSucursal').val(<?php echo $sucursal_update;?>);
                            $('#InputMarca').val(<?php echo $marca_update;?>);
                            
                            get_marca();
                            get_modelo();
                            $('#InputNombre').val(<?php echo $vehiculo_update;?>);
                            $('#InputModelo').val(<?php echo $modelo_update;?>);

                            let element = document.getElementById(InputColor);
                            element.value = <?php echo $color_get;?>;

                            $('#InputMarca').change(function(){
                                get_marca();
                                get_modelo();
                            }); 
                            $('#div_auto').change(function(){
                                get_modelo();
                            });                       
                        });
                    </script>                        
                    <script>
                        function get_marca(){
                            $.ajax({
                                type:   "POST" ,
                                url:    "get_marca.php",
                                data:   "Marca=" + $('#InputMarca').val(),
                                success: function(r){
                                    $('#div_auto').html(r);
                                }
                            });
                        }
                        function get_modelo(){
                            $.ajax({
                                type:   "POST" ,
                                url:    "get_modelo.php",
                                data:   "Auto=" + $('#InputNombre').val(),
                                success: function(a){
                                    $('#div_modelo').html(a);
                                }
                            });
                        }
                    </script>
</body>
</html>