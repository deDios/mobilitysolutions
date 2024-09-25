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

</head>
<body>

    <div class="container">
        <h1>Registro autos</h1>
        <div class="row mt-5">
            <div class="col">
                <form action="">
                    <label for="InputMarca" class="form-label">Marca</label>
                    <select class="form-select" aria-label="Default select example">
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
                    <div class="col-6">
                        <label for="InputNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="InputNombre">
                    </div>
                    <div class="col-6">
                        <label for="InputModelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="InputModelo">
                    </div>
                    <div class="col mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Sucursal</label>
                    </div>
                    <div class="col mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Mensualidad</label>
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

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>