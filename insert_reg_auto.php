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
        <h1>Registro autos en marcas</h1>
        <div class="row mt-5">
            <form action="db_consultas/insert_sp.php" method="POST" enctype="multipart/form-data">
                    
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
                    
                    <!-- Input Auto ------------------------------------------------------------------->
                    <div class="input-group mb-3 col-6 mt-5">
                        <input id="InputAuto" type="text" class="form-control" name="InputAuto" aria-label="Default select example" required>
                    </div>
                    <div class="invalid-feedback">
                        Porfavor llenar campo de auto
                    </div>

                    <button type="submit" class="btn btn-success mt-5">Insertar registro</button>
            </form>
        </div>
    </div>
                    <script >
                        $(document).ready(function(){
                            $('#InputMarca').val(0);
                            $('#InputMarca').change(function(){
                                get_marca();
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
                    </script>
</body>
</html>