<?php

$inc = include "../db/Conexion.php"; 
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
        auto.updated_at, 
        auto.c_type
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
                        $sucursal_get = $row['sucursal'];
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
                        $c_type = $row['c_type'];
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
    <link rel="stylesheet" href="../CSS/insert_reg.css">
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
            <form action="../db_consultas/update_sp.php" method="POST" enctype="multipart/form-data">
                    
            <input id="InputId" type="text" class="form-control" name="InputId" value="<?php echo $id_get;?>" required>

                    <div class="col-2 mt-5">
                        <label for="InputSucursal" class="form-label">Sucursal  <small> / Actual: <?php echo $sucursal_get;?></small></label>
                        <select id="InputSucursal" class="form-select" aria-label="Default select example" name="InputSucursal">
                            <option value="0">Selecciona una sucursal</option>                      
                            <?php 
                            $inc = include "../db/Conexion.php";    
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
                        <label for="InputMarca" class="form-label">Marca<small> / Actual: <?php echo $marca_get;?></small></label>
                        <select id="InputMarca" class="form-select" aria-label="Default select example" name="InputMarca">
                            <option value="0">Selecciona una Marca</option>                      
                            <?php 
                            $inc = include "../db/Conexion.php";    
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
                    <small class="col-12 mt-5">Vehiculo actual: <?php echo $nombre_get;?></small>
                        <div id="div_auto" class="col-3">
                            <label for='InputNombre' class='form-label'>Vehiculo </label>
                            <select id="InputNombre" class="form-select" aria-label="Default select example" name="InputNombre">
                                <option value="0">Selecciona un Vehiculo</option> 
                            </select>
                        </div>
                        

                    <!-- Input Modelo ------------------------------------------------------------------->
                    <small class="col-12 mt-5">Modelo actual: <?php echo $modelo_get;?></small>
                        <div id="div_modelo" class="col-3">
                            <label for='InputModelo' class='form-label'>Modelo</label>
                            <select id="InputModelo" class="form-select" aria-label="Default select example" name="InputModelo">
                                <option value="0">Selecciona un Modelo</option> 
                            </select>
                        </div>
                        
                    </div>

                    <!-- Input Type ------------------------------------------------------------------->
                    
                    <div class="col-2 mt-5">
                        <label for="InputType" class="form-label">Tipo de auto  <small> / Actual: <?php echo $c_type;?></small></label>
                        
                        <?php
                        switch ($c_type) {
                            case "Hatchback":
                                ?>
                                    <select id="InputType" class="form-select" aria-label="Default select example" name="InputType"> 
                                        <option value="Hatchback" selected>Hatchback</option>  
                                        <option value="Sedan">Sedan</option>  
                                        <option value="SUV">SUV</option>
                                        <option value="Pickup">Pickup</option>  
                                    </select>
                                <?php
                                break;
                            case "Sedan":
                                ?>
                                    <select id="InputType" class="form-select" aria-label="Default select example" name="InputType">
                                        <option value="Hatchback">Hatchback</option>  
                                        <option value="Sedan" selected>Sedan</option>  
                                        <option value="SUV">SUV</option>
                                        <option value="Pickup">Pickup</option> 
                                    </select>
                                <?php
                                break;
                            case "SUV":
                                ?>
                                    <select id="InputType" class="form-select" aria-label="Default select example" name="InputType">
                                        <option value="Hatchback">Hatchback</option>  
                                        <option value="Sedan">Sedan</option>  
                                        <option value="SUV" selected>SUV</option>
                                        <option value="Pickup">Pickup</option> 
                                    </select>
                                <?php
                                break;
                            case "Pickup":
                                ?>
                                    <select id="InputType" class="form-select" aria-label="Default select example" name="InputType">
                                        <option value="Hatchback">Hatchback</option>  
                                        <option value="Sedan">Sedan</option>  
                                        <option value="SUV">SUV</option>
                                        <option value="Pickup" selected>Pickup</option>  
                                    </select>
                                <?php
                                break;
                            case "Sin info":
                                ?>
                                    <select id="InputType" class="form-select" aria-label="Default select example" name="InputType">
                                        <option value="Hatchback">Hatchback</option>  
                                        <option value="Sedan">Sedan</option>  
                                        <option value="SUV">SUV</option>
                                        <option value="Pickup">Pickup</option> 
                                        <option value="Sin info" selected>Sin info</option>   
                                    </select>
                                <?php
                                break;
                        }
                        ?>
                    
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
                        <label for="InputColor" class="form-label">Color  <small> / Actual: <?php echo $color_get;?></small></label>
                        
                        <?php
                        switch ($color_get) {
                            case "Negro":
                                ?>
                                    <select id="InputColor" class="form-select" aria-label="Default select example" name="InputColor">
                                        <option value="Negro" selected>Negro</option>  
                                        <option value="Rojo">Rojo</option>  
                                        <option value="Azul">Azul</option>  
                                        <option value="Blanco">Blanco</option>  
                                        <option value="Verde">Verde</option>
                                        <option value="Gris">Gris</option>
                                        <option value="Amarillo">Amarillo</option>
                                        <option value="Arena">Arena</option>
                                        <option value="Guinda">Guinda</option>
                                        <option value="Plata">Plata</option>
                                        <option value="Naranja">Naranja</option>  
                                    </select>
                                <?php
                                break;
                            case "Rojo":
                                ?>
                                    <select id="InputColor" class="form-select" aria-label="Default select example" name="InputColor">
                                        <option value="Negro">Negro</option>  
                                        <option value="Rojo" selected>Rojo</option>  
                                        <option value="Azul">Azul</option>  
                                        <option value="Blanco">Blanco</option>  
                                        <option value="Verde">Verde</option>
                                        <option value="Gris">Gris</option>
                                        <option value="Amarillo">Amarillo</option>
                                        <option value="Arena">Arena</option>
                                        <option value="Guinda">Guinda</option>
                                        <option value="Plata">Plata</option>
                                        <option value="Naranja">Naranja</option>  
                                    </select>
                                <?php
                                break;
                            case "Azul":
                                ?>
                                    <select id="InputColor" class="form-select" aria-label="Default select example" name="InputColor">
                                        <option value="Negro">Negro</option>  
                                        <option value="Rojo">Rojo</option>  
                                        <option value="Azul" selected>Azul</option>  
                                        <option value="Blanco">Blanco</option>  
                                        <option value="Verde">Verde</option>
                                        <option value="Gris">Gris</option>
                                        <option value="Amarillo">Amarillo</option>
                                        <option value="Arena">Arena</option>
                                        <option value="Guinda">Guinda</option>
                                        <option value="Plata">Plata</option>
                                        <option value="Naranja">Naranja</option>  
                                    </select>
                                <?php
                                break;
                            case "Blanco":
                                ?>
                                    <select id="InputColor" class="form-select" aria-label="Default select example" name="InputColor">
                                        <option value="Negro">Negro</option>  
                                        <option value="Rojo">Rojo</option>  
                                        <option value="Azul">Azul</option>  
                                        <option value="Blanco" selected>Blanco</option>  
                                        <option value="Verde">Verde</option>
                                        <option value="Gris">Gris</option>
                                        <option value="Amarillo">Amarillo</option>
                                        <option value="Arena">Arena</option>
                                        <option value="Guinda">Guinda</option>
                                        <option value="Plata">Plata</option>
                                        <option value="Naranja">Naranja</option>  
                                    </select>
                                <?php
                                break;
                            case "Verde":
                                ?>
                                    <select id="InputColor" class="form-select" aria-label="Default select example" name="InputColor">
                                        <option value="Negro">Negro</option>  
                                        <option value="Rojo">Rojo</option>  
                                        <option value="Azul">Azul</option>  
                                        <option value="Blanco">Blanco</option>  
                                        <option value="Verde" selected>Verde</option>
                                        <option value="Gris">Gris</option>
                                        <option value="Amarillo">Amarillo</option>
                                        <option value="Arena">Arena</option>
                                        <option value="Guinda">Guinda</option>
                                        <option value="Plata">Plata</option>
                                        <option value="Naranja">Naranja</option>  
                                    </select>
                                <?php
                                break;
                            case "Gris":
                                ?>
                                    <select id="InputColor" class="form-select" aria-label="Default select example" name="InputColor">
                                        <option value="Negro">Negro</option>  
                                        <option value="Rojo">Rojo</option>  
                                        <option value="Azul">Azul</option>  
                                        <option value="Blanco">Blanco</option>  
                                        <option value="Verde">Verde</option>
                                        <option value="Gris" selected>Gris</option>
                                        <option value="Amarillo">Amarillo</option>
                                        <option value="Arena">Arena</option>
                                        <option value="Guinda">Guinda</option>
                                        <option value="Plata">Plata</option>
                                        <option value="Naranja">Naranja</option>  
                                    </select>
                                <?php
                                break;
                            case "Amarillo":
                                ?>
                                    <select id="InputColor" class="form-select" aria-label="Default select example" name="InputColor">
                                        <option value="Negro">Negro</option>  
                                        <option value="Rojo">Rojo</option>  
                                        <option value="Azul">Azul</option>  
                                        <option value="Blanco">Blanco</option>  
                                        <option value="Verde">Verde</option>
                                        <option value="Gris">Gris</option>
                                        <option value="Amarillo" selected>Amarillo</option>
                                        <option value="Arena">Arena</option>
                                        <option value="Guinda">Guinda</option>
                                        <option value="Plata">Plata</option>
                                        <option value="Naranja">Naranja</option>  
                                    </select>
                                <?php
                                break;
                            case "Arena":
                                ?>
                                    <select id="InputColor" class="form-select" aria-label="Default select example" name="InputColor">
                                        <option value="Negro">Negro</option>  
                                        <option value="Rojo" >Rojo</option>  
                                        <option value="Azul">Azul</option>  
                                        <option value="Blanco">Blanco</option>  
                                        <option value="Verde">Verde</option>
                                        <option value="Gris">Gris</option>
                                        <option value="Amarillo">Amarillo</option>
                                        <option value="Arena" selected>Arena</option>
                                        <option value="Guinda">Guinda</option>
                                        <option value="Plata">Plata</option>
                                        <option value="Naranja">Naranja</option>  
                                    </select>
                                <?php
                                break;
                            case "Guinda":
                                ?>
                                    <select id="InputColor" class="form-select" aria-label="Default select example" name="InputColor">
                                        <option value="Negro">Negro</option>  
                                        <option value="Rojo">Rojo</option>  
                                        <option value="Azul">Azul</option>  
                                        <option value="Blanco">Blanco</option>  
                                        <option value="Verde">Verde</option>
                                        <option value="Gris">Gris</option>
                                        <option value="Amarillo">Amarillo</option>
                                        <option value="Arena">Arena</option>
                                        <option value="Guinda" selected>Guinda</option>
                                        <option value="Plata">Plata</option>
                                        <option value="Naranja">Naranja</option>  
                                    </select>
                                <?php
                                break;
                            case "Plata":
                                ?>
                                    <select id="InputColor" class="form-select" aria-label="Default select example" name="InputColor">
                                        <option value="Negro">Negro</option>  
                                        <option value="Rojo">Rojo</option>  
                                        <option value="Azul">Azul</option>  
                                        <option value="Blanco">Blanco</option>  
                                        <option value="Verde">Verde</option>
                                        <option value="Gris">Gris</option>
                                        <option value="Amarillo">Amarillo</option>
                                        <option value="Arena">Arena</option>
                                        <option value="Guinda">Guinda</option>
                                        <option value="Plata" selected>Plata</option>
                                        <option value="Naranja">Naranja</option>  
                                    </select>
                                <?php
                                break;
                            case "Naranja":
                                ?>
                                    <select id="InputColor" class="form-select" aria-label="Default select example" name="InputColor">
                                        <option value="Negro">Negro</option>  
                                        <option value="Rojo">Rojo</option>  
                                        <option value="Azul">Azul</option>  
                                        <option value="Blanco">Blanco</option>  
                                        <option value="Verde">Verde</option>
                                        <option value="Gris">Gris</option>
                                        <option value="Amarillo">Amarillo</option>
                                        <option value="Arena">Arena</option>
                                        <option value="Guinda">Guinda</option>
                                        <option value="Plata">Plata</option>
                                        <option value="Naranja" selected>Naranja</option>  
                                    </select>
                                <?php
                                break;
                        }
                        ?>

                    </div>

                    <!-- Input Transmision ------------------------------------------------------------------->
                    <div class="col-2 mt-2">
                        <label for='InputTransmision' class='form-label'>Tipo de transmision <small> / Actual: <?php echo $transmision_get;?></small></label>
                        <div class="col mb-3 form-check"> 
                            <?php
                            switch ($transmision_get) {
                                case "Manual":
                                ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="InputTransmision" id="InputTransmision" value="Manual" checked="">
                                        <label class="form-check-label" for="InputTransmision">TM (Manual)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="InputTransmision" id="InputTransmision" value="Automatico">
                                        <label class="form-check-label" for="InputTransmision">TA (Automatico)</label>
                                    </div>
                                <?php
                                break;
                                case "Automatico":
                                ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="InputTransmision" id="InputTransmision" value="Manual">
                                        <label class="form-check-label" for="InputTransmision">TM (Manual)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="InputTransmision" id="InputTransmision" value="Automatico" checked="">
                                        <label class="form-check-label" for="InputTransmision">TA (Automatico)</label>
                                    </div>
                            <?php
                                break;
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Input Interior ------------------------------------------------------------------->
                    <div class="col-2 mt-2">
                        <label for='InputInterior' class='form-label'>Interior <small> / Actual: <?php echo $interior_get;?></small></label>
                        <div class="col mb-3 form-check"> 
                        <?php
                        switch ($interior_get) {
                            case "Tela":
                            ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="InputInterior" id="InputInterior" value="Tela" checked="">
                                    <label class="form-check-label" for="InputInterior">Tela</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="InputInterior" id="InputInterior" value="Piel">
                                    <label class="form-check-label" for="InputInterior">Piel</label>
                                </div>
                            <?php
                            break;
                            case "Piel":
                            ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="InputInterior" id="InputInterior" value="Tela">
                                    <label class="form-check-label" for="InputInterior">Tela</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="InputInterior" id="InputInterior" value="Piel" checked="">
                                    <label class="form-check-label" for="InputInterior">Piel</label>
                                </div>
                        <?php
                            break;
                        }
                        ?>
                        </div>
                    </div>

                    <!-- Input kilometraje ------------------------------------------------------------------->
                    <div class="col-2 mt-2">
                        <label for='InputKilometraje' class='form-label'>Kilometraje <small> / Actual: <?php echo $kilometraje_get;?></small></label>
                        <div class="input-group mb-3 ">
                                <input id="InputKilometraje" type="text" class="form-control" name="InputKilometraje"  aria-label="Amount (to the nearest dollar)" value="<?php echo $kilometraje_get;?>">
                            <span class="input-group-text">km</span>
                        </div>
                    </div>

                    <!-- Input Combustible ------------------------------------------------------------------->
                    <div class="col-3 mt-2">
                        <label for='InputCombustible' class='form-label'>Combustible <small> / Actual: <?php echo $combustible_get;?></small></label>
                        <div class="col mb-3 form-check"> 
                        <?php
                        switch ($combustible_get) {
                            case "Gasolina":
                            ?>
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
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible" value="Disel">
                                <label class="form-check-label" for="InputCombustible">Disel</label>
                            </div>
                            <?php
                            break;
                            case "Electrico":
                            ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible" value="Gasolina">
                                <label class="form-check-label" for="InputCombustible">Gasolina</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible" value="Electrico" checked="">
                                <label class="form-check-label" for="InputCombustible">Electrico</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible" value="Hibrido">
                                <label class="form-check-label" for="InputCombustible">Hibrido</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible" value="Disel">
                                <label class="form-check-label" for="InputCombustible">Disel</label>
                            </div>
                            <?php
                            break;
                            case "Hibrido":
                            ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible" value="Gasolina">
                                <label class="form-check-label" for="InputCombustible">Gasolina</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible" value="Electrico">
                                <label class="form-check-label" for="InputCombustible">Electrico</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible" value="Hibrido" checked="">
                                <label class="form-check-label" for="InputCombustible">Hibrido</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible" value="Disel">
                                <label class="form-check-label" for="InputCombustible">Disel</label>
                            </div>
                            <?php
                            break;
                            case "Disel":
                            ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible" value="Gasolina">
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
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible" value="Disel" checked="">
                                <label class="form-check-label" for="InputCombustible">Disel</label>
                            </div>
                        <?php
                            break;
                        }
                        ?>
                        </div>
                    </div>

                    <!-- Input Cilindros ------------------------------------------------------------------->
                    <div class="col-6 mt-2">
                    <label for='InputCilindros' class='form-label'>Cilindros <small> / Actual: <?php echo $cilindros_get;?></small></label>
                        <div class="p-3 m-0 border-0 bd-example m-0 border-0">
                        <?php
                        switch ($cilindros_get) {
                            case "4":
                            ?>
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
                            <?php
                            break;
                            case "6":
                            ?>
                            <input type="radio" class="btn-check" name="InputCilindros" value="4" id="InputCilindros1" autocomplete="off">
                            <label class="btn" for="InputCilindros1">V4</label>                       
                            <input type="radio" class="btn-check" name="InputCilindros" value="6" id="InputCilindros2" autocomplete="off" checked="">
                            <label class="btn" for="InputCilindros2">V6</label>
                            <input type="radio" class="btn-check" name="InputCilindros" value="8" id="InputCilindros3" autocomplete="off">
                            <label class="btn" for="InputCilindros3">V8</label>
                            <input type="radio" class="btn-check" name="InputCilindros" value="10" id="InputCilindros4" autocomplete="off">
                            <label class="btn" for="InputCilindros4">V10</label>
                            <input type="radio" class="btn-check" name="InputCilindros" value="12" id="InputCilindros5" autocomplete="off">
                            <label class="btn" for="InputCilindros5">V12</label>
                            <?php
                            break;
                            case "8":
                            ?>
                            <input type="radio" class="btn-check" name="InputCilindros" value="4" id="InputCilindros1" autocomplete="off">
                            <label class="btn" for="InputCilindros1">V4</label>                       
                            <input type="radio" class="btn-check" name="InputCilindros" value="6" id="InputCilindros2" autocomplete="off">
                            <label class="btn" for="InputCilindros2">V6</label>
                            <input type="radio" class="btn-check" name="InputCilindros" value="8" id="InputCilindros3" autocomplete="off" checked="">
                            <label class="btn" for="InputCilindros3">V8</label>
                            <input type="radio" class="btn-check" name="InputCilindros" value="10" id="InputCilindros4" autocomplete="off">
                            <label class="btn" for="InputCilindros4">V10</label>
                            <input type="radio" class="btn-check" name="InputCilindros" value="12" id="InputCilindros5" autocomplete="off">
                            <label class="btn" for="InputCilindros5">V12</label>
                            <?php
                            break;
                            case "10":
                            ?>
                            <input type="radio" class="btn-check" name="InputCilindros" value="4" id="InputCilindros1" autocomplete="off">
                            <label class="btn" for="InputCilindros1">V4</label>                       
                            <input type="radio" class="btn-check" name="InputCilindros" value="6" id="InputCilindros2" autocomplete="off">
                            <label class="btn" for="InputCilindros2">V6</label>
                            <input type="radio" class="btn-check" name="InputCilindros" value="8" id="InputCilindros3" autocomplete="off">
                            <label class="btn" for="InputCilindros3">V8</label>
                            <input type="radio" class="btn-check" name="InputCilindros" value="10" id="InputCilindros4" autocomplete="off" checked="">
                            <label class="btn" for="InputCilindros4">V10</label>
                            <input type="radio" class="btn-check" name="InputCilindros" value="12" id="InputCilindros5" autocomplete="off">
                            <label class="btn" for="InputCilindros5">V12</label>
                            <?php
                            break;
                            case "12":
                            ?>
                            <input type="radio" class="btn-check" name="InputCilindros" value="4" id="InputCilindros1" autocomplete="off">
                            <label class="btn" for="InputCilindros1">V4</label>                       
                            <input type="radio" class="btn-check" name="InputCilindros" value="6" id="InputCilindros2" autocomplete="off">
                            <label class="btn" for="InputCilindros2">V6</label>
                            <input type="radio" class="btn-check" name="InputCilindros" value="8" id="InputCilindros3" autocomplete="off">
                            <label class="btn" for="InputCilindros3">V8</label>
                            <input type="radio" class="btn-check" name="InputCilindros" value="10" id="InputCilindros4" autocomplete="off">
                            <label class="btn" for="InputCilindros4">V10</label>
                            <input type="radio" class="btn-check" name="InputCilindros" value="12" id="InputCilindros5" autocomplete="off" checked="">
                            <label class="btn" for="InputCilindros5">V12</label>
                        <?php
                            break;
                        }
                        ?>
                        </div>
                    </div>

                    <!-- Input eje ------------------------------------------------------------------->
                    <div class="col-2 mt-2">
                        <label for="InputEje" class="form-label">Eje <small> / Actual: <?php echo $eje_get;?></small></label>
                        <?php
                        switch ($eje_get) {
                            case "Delantera":
                            ?>
                                <select id="InputEje" class="form-select" aria-label="Default select example" name="InputEje">
                                    <option value="Delantera" selected>Delantera</option>  
                                    <option value="Trasera">Trasera</option>  
                                    <option value="4X4">4X4</option>  
                                </select>
                            <?php
                            break;
                            case "Trasera":
                            ?>
                                <select id="InputEje" class="form-select" aria-label="Default select example" name="InputEje">
                                    <option value="Delantera">Delantera</option>  
                                    <option value="Trasera" selected>Trasera</option>  
                                    <option value="4X4">4X4</option>  
                                </select>
                            <?php
                            break;
                            case "4X4":
                            ?>
                                <select id="InputEje" class="form-select" aria-label="Default select example" name="InputEje">
                                    <option value="Delantera">Delantera</option>  
                                    <option value="Trasera">Trasera</option>  
                                    <option value="4X4" selected>4X4</option>  
                                </select>
                        <?php
                            break;
                        }
                        ?>
                    </div>

                    <!-- Input pasajeros ------------------------------------------------------------------->
                    <div class="col-2 mt-2">
                        <label for='InputPasajeros' class='form-label'>Capacidad de pasajeros <small> / Actual: <?php echo $pasajeros_get;?></small></label>
                        <div class="input-group mb-3 ">
                                <input id="InputPasajeros" type="text" class="form-control" name="InputPasajeros" aria-label="Amount (to the nearest dollar)" value="<?php echo $pasajeros_get;?>">
                            <span class="input-group-text">Pasajeros</span>
                        </div>
                    </div>

                    <!-- Input Propietarios ------------------------------------------------------------------->
                    <div class="col-2 mt-2">
                        <label for="InputPropietarios" class="form-label">Propietarios <small> / Actual: <?php echo $propietarios_get;?></small></label>
                        <?php
                        switch ($propietarios_get) {
                            case "1":
                            ?>
                            <select id="InputPropietarios" class="form-select" aria-label="Default select example" name="InputPropietarios">
                                <option value="1" selected>1</option>  
                                <option value="2">2</option>  
                            </select>
                            <?php
                            break;
                            case "2":
                            ?>
                            <select id="InputPropietarios" class="form-select" aria-label="Default select example" name="InputPropietarios">
                                <option value="1">1</option>  
                                <option value="2" selected>2</option>  
                            </select>
                        <?php
                            break;
                        }
                        ?>
                    </div>

                    <button type="submit" class="btn btn-success mt-5">Actualizar</button>


            </form>

                    <div class="col-12 mt-5">
                        <h1>Actualizar Imagenes</h1>
                        <hr class="mt-2 mb-3"/>
                    </div>

                    <div class="col-3 mt-5">
                    <form action="../db_consultas/upload_i.php?i=<?php echo $id_get;?>" method="post" enctype="multipart/form-data">
                                <input class="form-control form-control-sm" type="file" name="archivo[]" multiple="multiple">
                                <button type="submit" class="btn btn-success mt-3">Actualizar</button>
                    </form>
                    </div>
                    <!-- Input Img ------------------------------------------------------------------->
                    <div class="row mt-3">
                        <div class="col-4 py-2">
                            <label for="" class="form-label">Imagen de portada</label>
                            <img src="../Imagenes/Catalogo/Auto <?php echo $id_get;?>/Img01.jpg" alt="Auto 1" id="Img01">
                            
                        </div>
                        <div class="col-4 py-2">
                            <label for="" class="form-label mt-2">Imagen de perfil</label>
                            <img src="../Imagenes/Catalogo/Auto <?php echo $id_get;?>/Img02.jpg" alt="Auto 1">
                        </div>
                        <div class="col-4 py-2">
                            <label for="" class="form-label mt-2">Imagen de llanta</label>
                            <img src="../Imagenes/Catalogo/Auto <?php echo $id_get;?>/Img03.jpg" alt="Auto 1">
                        </div>
                        <div class="col-4 py-2">
                            <label for="" class="form-label mt-2">Asientos traseros</label>
                            <img src="../Imagenes/Catalogo/Auto <?php echo $id_get;?>/Img04.jpg" alt="Auto 1">
                        </div>
                        <div class="col-4 py-2">
                            <label for="" class="form-label mt-2">Asientos delanteros</label>
                            <img src="../Imagenes/Catalogo/Auto <?php echo $id_get;?>/Img05.jpg" alt="Auto 1">
                        </div>
                        <div class="col-4 py-2">
                            <label for="" class="form-label mt-2">Imagen de motor</label>
                            <img src="../Imagenes/Catalogo/Auto <?php echo $id_get;?>/Img06.jpg" alt="Auto 1">
                        </div>
                        <div class="col-4 py-2">
                            <label for="" class="form-label mt-2">Imagen de tablero</label>
                            <img src="../Imagenes/Catalogo/Auto <?php echo $id_get;?>/Img07.jpg" alt="Auto 1">
                        </div>
                        <div class="col-4 py-2">
                            <label for="" class="form-label mt-2">Imagen de cajuela</label>
                            <img src="../Imagenes/Catalogo/Auto <?php echo $id_get;?>/Img08.jpg" alt="Auto 1">
                        </div>
                    </div>
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
                                url:    "../get_marca.php",
                                data:   "Marca=" + $('#InputMarca').val(),
                                success: function(r){
                                    $('#div_auto').html(r);
                                }
                            });
                        }
                        function get_modelo(){
                            $.ajax({
                                type:   "POST" ,
                                url:    "../get_modelo.php",
                                data:   "Auto=" + $('#InputNombre').val(),
                                success: function(a){
                                    $('#div_modelo').html(a);
                                }
                            });
                        }
                    </script>
</body>
</html>