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
                            <option value="0">Open this select menu</option>                      
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
                    <div class="row mt-5">

                        <div id="div_auto" class="col-3">
                            <label for='InputNombre' class='form-label'>Vehiculo</label>
                            <select id="InputNombre" class="form-select" aria-label="Default select example" name="InputNombre">
                                <option value="0">Open this select menu</option> 
                            </select>
                        </div>

                        <div id="div_modelo" class="col-3">
                            <label for='InputModelo' class='form-label'>Modelo</label>
                            <select id="InputModelo" class="form-select" aria-label="Default select example" name="InputModelo">
                                <option value="0">Open this select menu</option> 
                            </select>
                        </div>

                    </div>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text">$</span>
                            <input id="InputMensualidad" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-text">MX/mensuales</span>
                    </div>
                    <div class="col mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Costo de contado</label>
                    </div>
                    <div class="col mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Color</label>
                    </div>
                    <div class="col mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Transmision</label>
                    </div>
                    <div class="col mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Tipo de interior</label>
                    </div>
                    <div class="col mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">kilometraje</label>
                    </div>
                    <div class="col mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Tipo de Combustible</label>
                    </div>
                    <div class="col mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Numero de cilindros</label>
                    </div>
                    <div class="col mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">eje</label>
                    </div>
                    <div class="col mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Capacidad de pasajeros</label>
                    </div>
                    <div class="col mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Numero de propietarios</label>
                    </div>
                    <div class="col mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Estatus</label>
                    </div>

                    <button type="button" class="btn btn-success">Guardar</button>
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