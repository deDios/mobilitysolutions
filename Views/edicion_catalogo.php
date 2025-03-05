<?php
    session_start();

    if (!isset ($_SESSION['username'])){
        echo ' 
            <script>
                alert("Es necesario hacer login, por favor ingrese sus credenciales") ;
                window.location = "../views/login.php";
            </script> ';
            session_destroy();
            die();
    }

    $inc = include "../db/Conexion.php";

    $query ='select 
                acc.user_id, 
                acc.user_name, 
                acc.user_password, 
                acc.user_type, 
                acc.r_ejecutivo, 
                acc.r_editor, 
                acc.r_autorizador, 
                acc.r_analista, 
                us.user_name as nombre, 
                us.second_name as s_nombre, 
                us.last_name, 
                us.email, 
                us.cumpleaños, 
                us.telefono
            from mobility_solutions.tmx_acceso_usuario  as acc
            left join mobility_solutions.tmx_usuario as us
                on acc.user_id = us.id
            where acc.user_name = '.$_SESSION['username'].';';

    $result = mysqli_query($con,$query); 

    if ($result){ 
        while($row = mysqli_fetch_assoc($result)){
                            $user_id = $row['user_id'];
                            $user_name = $row['user_name'];
                            $user_password = $row['user_password'];
                            $user_type = $row['user_type'];
                            $r_ejecutivo = $row['r_ejecutivo'];
                            $r_editor = $row['r_editor'];
                            $r_autorizador = $row['r_autorizador'];
                            $r_analista = $row['r_analista'];
                            $nombre = $row['nombre'];
                            $s_nombre = $row['s_nombre'];
                            $last_name = $row['last_name'];
                            $email = $row['email'];
                            $cumpleaños = $row['cumpleaños'];
                            $telefono = $row['telefono'];
                           
        }
    }
    else{
        echo 'Falla en conexión.';
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="shortcut icon" href="../Imagenes/movility.ico" />
    <link rel="stylesheet" href="../CSS/edicion.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTable JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
 
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
   
</head>

<body>
<div class="fixed-top">
  <header class="topbar">
      <div class="container">
        <div class="row">
          <!-- social icon-->
          <div class="col-sm-12">
            <ul class="social-network">
              <li><a class="waves-effect waves-dark" href="https://www.facebook.com/profile.php?id=61563909313215&mibextid=kFxxJD"><i class="fa fa-facebook"></i></a></li>
              
              <li><a class="waves-effect waves-dark" href="" data-toggle="modal" data-target="#exampleModal2"><i class="fa fa-map-marker"></i></a></li>       

              <li><a class="waves-effect waves-dark" href="https://mobilitysolutionscorp.com/db_consultas/cerrar_sesion.php"><i class="fa fa-sign-out"></i></a></li>
            </ul>
          </div>

        </div>
      </div>
  </header>

  <nav class="navbar navbar-expand-lg navbar-dark mx-background-top-linear">
    <div class="container">
      <a class="navbar-brand" rel="nofollow" target="_blank" href="#"> Edición de catálogo</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">

        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/Home.php">Inicio
              <span class="sr-only">(current)</span>
            </a>
          </li>

          <li class="nav-item active">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/edicion_catalogo.php">Catálogo</a>
          </li>

         <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/requerimiento.php">Requerimientos</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/Autoriza.php">Aprobaciones</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#">Tareas</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#">Tableros</a>
          </li>

        </ul>
      </div>
    </div>
  </nav>
</div>

<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Sucursales</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                <!-- Formulario ------------------------------------------------------------->                   
                    <div class="div_sucursales">
                        <div class="sucursal_list">
                        <ol class="list-group">
                        <a href="https://www.google.com/maps/d/u/0/viewer?mid=1tICZQyAbkrtIbcuZ5U8Vf4UiSR8&femb=1&ll=20.11709728888821%2C-100.85436015&z=6">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                <div class="fw-bold">Matriz CDMX</div>
                                Av. P. de la Reforma 505 Piso 37, Cuauhtémoc, 06500.
                                </div>
                                <span class="badge bg-dark rounded-pill">Activa</span>
                            </li>
                        </a>
                        <a href="https://www.google.com/maps/d/u/0/viewer?mid=1tICZQyAbkrtIbcuZ5U8Vf4UiSR8&femb=1&ll=20.11709728888821%2C-100.85436015&z=6">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                <div class="fw-bold">Sucursal GDL</div>
                                Av Rafael Sanzio 150, Camichines Vallarta, 45020.
                                </div>
                                <span class="badge bg-dark rounded-pill">Activa</span>
                            </li>
                        </a>
                        <a href="https://www.google.com/maps/d/u/0/viewer?mid=1tICZQyAbkrtIbcuZ5U8Vf4UiSR8&femb=1&ll=20.11709728888821%2C-100.85436015&z=6">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                <div class="fw-bold">Sucursal León</div>
                                Blvd. Juan Alonso de Torres Pte. 2002, Valle del Campestre, 37150.
                                </div>
                                <span class="badge bg-dark rounded-pill">Activa</span>
                            </li>
                        </a>
                        <a href="https://www.google.com/maps/d/u/0/viewer?mid=1tICZQyAbkrtIbcuZ5U8Vf4UiSR8&femb=1&ll=20.11709728888821%2C-100.85436015&z=6">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                <div class="fw-bold">Sucursal Morelia</div>
                                C. Vicente Sta. María 1516, Félix Ireta, 58070.
                                </div>
                                <span class="badge bg-dark rounded-pill">Activa</span>
                            </li>
                        </a>
                        <a href="https://www.google.com/maps/d/u/0/viewer?mid=1tICZQyAbkrtIbcuZ5U8Vf4UiSR8&femb=1&ll=20.11709728888821%2C-100.85436015&z=6">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                <div class="fw-bold">Sucursal Puebla</div>
                                Calle Ignacio Allende 512, Santiago Momoxpan, Alvaro Obregón, 72774.
                                </div>
                                <span class="badge bg-dark rounded-pill">Activa</span>
                            </li>
                        </a>
                        </ol>
                        </div>
                        <div class="sucursal_map">
                            <iframe src="https://www.google.com/maps/d/embed?mid=1tICZQyAbkrtIbcuZ5U8Vf4UiSR8&ehbc=2E312F" width="500" height="660"></iframe>
                        </div>
                    </div>                  
                <!-- Fin de formulario ------------------------------------------------------------->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
                </div>

<!--------------------------------------- Termina Menu ----------------------------------------------->
<div class="apartado_tabla2">

<div class="">

</div>
<div class="barra_totalizadores">
                <?php 
                $inc = include "../db/Conexion.php";    
                    if ($inc){
                        $query = 'select 
                                    count(*) as catalogo
                                FROM mobility_solutions.tmx_auto;';
                        $result = mysqli_query($con,$query);  
                        if ($result){         
                            while($row = mysqli_fetch_assoc($result)){
                                $total_catalogo = $row['catalogo'];
                ?>
                <div class="totalizador">
                        <div class="fig"><img src="../Imagenes/Catalogo/cat.png" alt="logo 1"></div>
                        <div class="fig2"><div class="Total_info">
                            <h6>Catálogo</h6>
                            <h4><small class="text-muted"><?php echo $total_catalogo;?></small>
                            </h4>
                        </div> 
                        </div> 
                </div>
                <?php
                            }
                        } else{
                            echo "Hubo un error en la consulta";
                        }
                        mysqli_free_result($result);                  
                    }
                ?>

                <?php 
                $inc = include "../db/Conexion.php";    
                    if ($inc){
                        $query = 'select 
                                    count(*) as activos
                                FROM mobility_solutions.tmx_auto where estatus = 1;';
                        $result = mysqli_query($con,$query);  
                        if ($result){         
                            while($row = mysqli_fetch_assoc($result)){
                                $total_activos = $row['activos'];
                ?>
                <div class="totalizador">
                        <div class="fig"><img src="../Imagenes/ver.jpg" alt="logo 1"></div>
                        <div class="fig2"><div class="Total_info">
                            <h6>Activo</h6>
                            <h4><small class="text-muted"><?php echo $total_activos;?></small>
                            </h4>
                        </div> 
                        </div> 
                </div>
                <?php
                            }
                        } else{
                            echo "Hubo un error en la consulta";
                        }
                        mysqli_free_result($result);                  
                    }
                ?>

                <?php 
                $inc = include "../db/Conexion.php";    
                    if ($inc){
                        $query = 'select 
                                    count(*) as por_activar
                                FROM mobility_solutions.tmx_auto where estatus = 2;';
                        $result = mysqli_query($con,$query);  
                        if ($result){         
                            while($row = mysqli_fetch_assoc($result)){
                                $total_no_activos = $row['por_activar'];
                ?>
                <div class="totalizador">
                        <div class="fig"><img src="../Imagenes/Catalogo/check.png" alt="logo 1"></div>
                        <div class="fig2"><div class="Total_info">
                            <h6>Por activar</h6>
                            <h4><small class="text-muted"><?php echo $total_no_activos;?></small>
                            </h4>
                        </div> 
                        </div> 
                </div>
                <?php
                            }
                        } else{
                            echo "Hubo un error en la consulta";
                        }
                        mysqli_free_result($result);                  
                    }
                ?>

                <?php 
                $inc = include "../db/Conexion.php";    
                    if ($inc){
                        $query = 'select 
                                    count(*) as reservados
                                FROM mobility_solutions.tmx_auto where estatus = 3;';
                        $result = mysqli_query($con,$query);  
                        if ($result){         
                            while($row = mysqli_fetch_assoc($result)){
                                $total_reservados = $row['reservados'];
                ?>
                <div class="totalizador">
                        <div class="fig"><img src="../Imagenes/Catalogo/reserve.png" alt="logo 1"></div>
                        <div class="fig2"><div class="Total_info">
                            <h6>Reservado</h6>
                            <h4><small class="text-muted"><?php echo $total_reservados;?></small>
                            </h4>
                        </div> 
                        </div> 
                </div>
                <?php
                            }
                        } else{
                            echo "Hubo un error en la consulta";
                        }
                        mysqli_free_result($result);                  
                    }
                ?>
        
    </div>
<div class="">

</div>
</div>
<hr class="mt-2 mb-3"/> 

<div class="apartado_tabla">
<div class="apartado_izq">

</div>
<div>
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
  +
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar automóvil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
 <!-- Formulario ------------------------------------------------------------->                   
    <form action="../db_consultas/insert_sp.php" method="POST" enctype="multipart/form-data">
                    
    <input id="Inputuser" type="text" class="form-control" name="Inputuser" value="<?php echo $user_id;?>" required>

                    <div class="col-12 mt-2">
                        <label for="InputSucursal" class="form-label">Sucursal</label>
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
            
                    <div class="col-12 mt-2">
                        <label for="InputMarca" class="form-label">Marca</label>
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
                    <!-- Input Auto ------------------------------------------------------------------->
                        <div id="div_auto" class="col-12 mt-3">
                            <label for='InputNombre' class='form-label'>Vehiculo</label>
                            <a rel="nofollow" target="_blank" href="https://mobilitysolutionscorp.com/insert_reg_auto.php" class="btn btn-primary btn-sm justify-content-md-end">+</a> 
                            <select id="InputNombre" class="form-select" aria-label="Default select example" name="InputNombre">
                                <option value="0">Selecciona un Vehiculo</option> 
                            </select>
                        </div>

                    <!-- Input Modelo ------------------------------------------------------------------->
                        <div id="div_modelo" class="col-12 mt-3">
                            <label for='InputModelo' class='form-label'>Modelo</label>
                            <a rel="nofollow" target="_blank" href="https://mobilitysolutionscorp.com/insert_reg_mod.php" class="btn btn-primary btn-sm justify-content-md-end">+</a> 
                            <select id="InputModelo" class="form-select" aria-label="Default select example" name="InputModelo">
                                <option value="0">Selecciona un Modelo</option> 
                            </select>
                        </div>
                    
                    
                    <!-- Tipo auto ------------------------------------------------------------------->
                    <div class="col-12 mt-5">
                        <label for="InputType" class="form-label">Tipo de automovil</label>
                        <select id="InputType" class="form-select" aria-label="Default select example" name="InputType">
                            <option value="Hatchback">Hatchback</option>  
                            <option value="Sedan">Sedan</option>  
                            <option value="SUV">SUV</option>
                            <option value="Pickup">Pickup</option>  
                        </select>
                    </div>

                    <hr class="mt-5 mb-3"/> 

                    <!-- Input Mensualidad ------------------------------------------------------------------->
                    <div class="input-group mb-3 col-12 mt-5">
                        <span class="input-group-text">$</span>
                            <input id="InputMensualidad" type="text" class="form-control" name="InputMensualidad" aria-label="Amount (to the nearest dollar)" required>
                        <span class="input-group-text">MX/mensuales</span>
                    </div>
                    <div class="invalid-feedback">
                        Porfavor llenar campo de mensualidad
                    </div>

                    <!-- Input Costo ------------------------------------------------------------------->
                    <div class="input-group mb-3 col-12 mt-2">
                        <span class="input-group-text">$</span>
                            <input id="InputCosto" type="text" class="form-control" name="InputCosto" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-text">MX/Contado</span>
                    </div>

                    <!-- Input Color ------------------------------------------------------------------->
                    <div class="col-12 mt-2">
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
                            <option value="Guinda">Guinda</option>
                            <option value="Plata">Plata</option>
                            <option value="Naranja">Naranja</option>  
                        </select>
                    </div>

                    <!-- Input Transmision ------------------------------------------------------------------->
                    <div class="col-12 mt-2">
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
                    <div class="col-12 mt-2">
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
                    <div class="col-12 mt-2">
                        <label for='InputKilometraje' class='form-label'>Kilometraje</label>
                        <div class="input-group mb-3 ">
                                <input id="InputKilometraje" type="text" class="form-control" name="InputKilometraje"  aria-label="Amount (to the nearest dollar)">
                            <span class="input-group-text">km</span>
                        </div>
                    </div>

                    <!-- Input Combustible ------------------------------------------------------------------->
                    <div class="col-12 mt-2">
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
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible" value="Disel">
                                <label class="form-check-label" for="InputCombustible">Disel</label>
                            </div>
                        </div>
                    </div>

                    <!-- Input Cilindros ------------------------------------------------------------------->
                    <div class="col-12 mt-2">
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
                    <div class="col-12 mt-2">
                        <label for="InputEje" class="form-label">Eje</label>
                        <select id="InputEje" class="form-select" aria-label="Default select example" name="InputEje">
                            <option value="Delantera">Delantera</option>  
                            <option value="Trasera">Trasera</option>  
                            <option value="4X4">4X4</option>  
                        </select>
                    </div>

                    <!-- Input pasajeros ------------------------------------------------------------------->
                    <div class="col-12 mt-2">
                        <label for='InputPasajeros' class='form-label'>Capacidad de pasajeros</label>
                        <div class="input-group mb-3 ">
                                <input id="InputPasajeros" type="text" class="form-control" name="InputPasajeros" aria-label="Amount (to the nearest dollar)">
                            <span class="input-group-text">Pasajeros</span>
                        </div>
                    </div>

                    <!-- Input Propietarios ------------------------------------------------------------------->
                    <div class="col-12 mt-2">
                        <label for="InputPropietarios" class="form-label">Propietarios</label>
                        <select id="InputPropietarios" class="form-select" aria-label="Default select example" name="InputPropietarios">
                            <option value="1">1</option>  
                            <option value="2">2</option>  
                        </select>
                    </div>

                    <!-- Input Img ------------------------------------------------------------------->
                    <div class="col-12 mt-5">
                        <div class="mb-3">
                            <label for="" class="form-label">Carga de imagenes</label>
                            <input class="form-control form-control-sm" type="file" name="archivo[]" multiple="multiple">
                        </div>
                    </div>


                    <button type="submit" class="btn btn-success mt-5">Guardar registro</button>
            </form>
                    
 <!-- Fin de formulario ------------------------------------------------------------->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<table id="example" class="table table-striped nowrap mt-2" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Marca</th>
            <th>Auto / Modelo</th>
            <th>Color</th>
            <th>Transmisión</th>
            <th>Interior</th>
            <th>Tipo</th>
            <th>$ Mensual</th>
            <th>$ Contado</th>
            <th>Estatus</th>
            <th>DT Registro</th>
            <th>DT Update</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        
        
        <?php 
                $inc = include "../db/Conexion.php";    
                    if ($inc){
                        $query = 'select 
                                    auto.id,
                                    m_auto.auto as nombre, 
                                    auto.nombre as id_vehiculo,
                                    modelo.nombre as modelo, 
                                    auto.modelo as id_modelo,
                                    marca.nombre as marca, 
                                    auto.marca as id_marca,
                                    auto.mensualidad, 
                                    auto.costo, 
                                    sucursal.nombre as sucursal, 
                                    auto.sucursal as id_sucursal,
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
                                    estatus.nombre as estatus, 
                                    auto.pasajeros, 
                                    auto.propietarios,
                                    auto.c_type,
                                    DATE_SUB(auto.created_at, INTERVAL 6 HOUR) as created_at, 
                                    DATE_SUB(auto.updated_at, INTERVAL 6 HOUR) as updated_at
                                FROM mobility_solutions.tmx_auto as auto
                                left join mobility_solutions.tmx_sucursal as sucursal on auto.sucursal = sucursal.id 
                                left join mobility_solutions.tmx_estatus as estatus on auto.estatus = estatus.id
                                left join mobility_solutions.tmx_modelo as modelo on auto.modelo = modelo.id 
                                left join mobility_solutions.tmx_marca as marca on auto.marca = marca.id
                                left join mobility_solutions.tmx_marca_auto as m_auto on auto.nombre = m_auto.id
                                order by auto.id desc;';
                        $result = mysqli_query($con,$query);  
                        if ($result){         
                            while($row = mysqli_fetch_assoc($result)){
                                $id = $row['id'];
                                $nombre = $row['nombre'];
                                $id_vehiculo = $row['id_vehiculo'];
                                $modelo = $row['modelo'];
                                $id_modelo = $row['id_modelo'];
                                $marca = $row['marca'];
                                $id_marca = $row['id_marca'];
                                $mensualidad = $row['mensualidad'];
                                $costo = $row['costo'];
                                $sucursal = $row['sucursal'];
                                $id_sucursal = $row['id_sucursal'];
                                $color = $row['color'];
                                $interior = $row['interior'];
                                $combustible = $row['combustible'];
                                $cilindros = $row['cilindros'];
                                $transmision = $row['transmision'];
                                $kilometraje = $row['kilometraje'];
                                $eje = $row['eje'];
                                $estatus = $row['estatus'];
                                $created_at = $row['created_at'];
                                $updated_at = $row['updated_at'];
                                $c_type = $row['c_type']
                ?> 
                    <tr>
                        <th class=""><?php echo $id;?></th>
                        <td><?php echo $marca;?></td>
                        <td><?php echo $nombre . ' / ' . $modelo;?></td>
                        <td><?php echo $color;?></td>
                        <td><?php echo $transmision;?></td>
                        <td><?php echo $interior;?></td>
                        <td><?php echo $c_type;?></td>
                        <td><?php echo "$" . number_format($mensualidad);?></td>
                        <td><?php echo "$" . number_format($costo);?></td>
                        <td><?php echo $estatus;?></td>
                        <td><?php echo $created_at;?></td>
                        <td><?php echo $updated_at;?></td>
                        <td>
                            <a href="javascript:detalle(<?php echo $id;?>)">
                                <i class="fa fa-eye" style="font-size:20px; color:black;"></i>
                            </a>
                            <?php 
                                if ($estatus !== 3){
                            ?>
                                <a href="../Views/up_reg.php?i=<?php echo $id;?>&s=<?php echo $id_sucursal;?>&m=<?php echo $id_marca;?>&v=<?php echo $id_vehiculo;?>&mm=<?php echo $id_modelo;?>">
                                    <i class="fa fa-edit" style="font-size:20px; color:black; padding-left: 5px;"></i>
                                </a>
                            <?php
                                } else {
                            ?>
                            <?php
                              }
                            ?>
                            <a href="#">
                                <i class="fa fa-trash" style="font-size:20px; color:red; padding-left: 5px;"></i>
                            </a>  
                        </td>
                    </tr>
                <?php
                            }
                        } else{
                            echo "Hubo un error en la consulta";
                        }
                        mysqli_free_result($result);                  
                    }
                ?>
    </tbody>
</table>
</div>
<div class="apartado_der">  
</div>

</div>

<script>
    new DataTable('#example', {
        responsive: true,
        order: [[ 0, "desc" ]]
    });
</script>
<script>        
        function detalle (cod){
            location.href="../detalles.php?cod="+cod;
        }
</script>


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

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>