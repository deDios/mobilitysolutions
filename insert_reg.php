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
        <h1>Registro autos</h1>
        <div class="row mt-5">
            <form action="db_consultas/insert_sp.php" method="POST">
                    
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
                            <input id="InputMensualidad" type="text" class="form-control" name="InputMensualidad" aria-label="Amount (to the nearest dollar)" required>
                        <span class="input-group-text">MX/mensuales</span>
                    </div>
                    <div class="invalid-feedback">
                        Porfavor llenar campo de mensualidad
                    </div>

                    <!-- Input Costo ------------------------------------------------------------------->
                    <div class="input-group mb-3 col-6 mt-2">
                        <span class="input-group-text">$</span>
                            <input id="InputCosto" type="text" class="form-control" name="InputCosto" aria-label="Amount (to the nearest dollar)">
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
                                <input id="InputKilometraje" type="text" class="form-control" name="InputKilometraje"  aria-label="Amount (to the nearest dollar)">
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
                            <input type="radio" class="btn-check" name="InputCilindros" value="V4" id="InputCilindros1" autocomplete="off" checked="">
                            <label class="btn" for="InputCilindros1">V4</label>
                            
                            <input type="radio" class="btn-check" name="InputCilindros" value="V6" id="InputCilindros2" autocomplete="off">
                            <label class="btn" for="InputCilindros2">V6</label>
                            
                            <input type="radio" class="btn-check" name="InputCilindros" value="V8" id="InputCilindros3" autocomplete="off">
                            <label class="btn" for="InputCilindros3">V8</label>
                            
                            <input type="radio" class="btn-check" name="InputCilindros" value="V10" id="InputCilindros4" autocomplete="off">
                            <label class="btn" for="InputCilindros4">V10</label>

                            <input type="radio" class="btn-check" name="InputCilindros" value="V12" id="InputCilindros5" autocomplete="off">
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
                                <input id="InputPasajeros" type="text" class="form-control" name="InputPasajeros" aria-label="Amount (to the nearest dollar)">
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

                    <!-- Input Imagenes ------------------------------------------------------------------->
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg1" class="form-label">Img de portada</label>
                            <input class="form-control form-control-sm" id="FileImg1" type="file">
                        </div>
                    </div>
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg2" class="form-label">Img de perfil</label>
                            <input class="form-control form-control-sm" id="FileImg2" type="file">
                        </div>
                    </div>
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg3" class="form-label">Img de llanta</label>
                            <input class="form-control form-control-sm" id="FileImg3" type="file">
                        </div>
                    </div>
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg4" class="form-label">Img de asientos traseros</label>
                            <input class="form-control form-control-sm" id="FileImg4" type="file">
                        </div>
                    </div>
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg5" class="form-label">Img de asientos delanteros</label>
                            <input class="form-control form-control-sm" id="FileImg5" type="file">
                        </div>
                    </div>
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg6" class="form-label">Img de motor</label>
                            <input class="form-control form-control-sm" id="FileImg6" type="file">
                        </div>
                    </div>
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg7" class="form-label">Img de tablero</label>
                            <input class="form-control form-control-sm" id="FileImg7" type="file">
                        </div>
                    </div>
                    <div class="col-2 mt-2">
                        <div class="mb-3">
                            <label for="FileImg8" class="form-label">Img de cajuela</label>
                            <input class="form-control form-control-sm" id="FileImg8" type="file">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success mt-5">Guardar registro</button>
            </form>
        </div>
    </div>
                    <script >
                        $(document).ready(function(){
                            $('#InputMarca').val(0);
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