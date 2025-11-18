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
            $user_id      = $row['user_id'];
            $user_name    = $row['user_name'];
            $user_password= $row['user_password'];
            $user_type    = $row['user_type'];
            $r_ejecutivo  = $row['r_ejecutivo'];
            $r_editor     = $row['r_editor'];
            $r_autorizador= $row['r_autorizador'];
            $r_analista   = $row['r_analista'];
            $nombre       = $row['nombre'];
            $s_nombre     = $row['s_nombre'];
            $last_name    = $row['last_name'];
            $email        = $row['email'];
            $cumpleaños   = $row['cumpleaños'];
            $telefono     = $row['telefono'];
        }
    }
    else{
        echo 'Falla en conexión.';
    }

    if ($r_editor == 0){
        echo ' 
        <script>
            alert("No tiene acceso para entrar al apartado de catalogo, favor de solicitarlo al departamento de sistemas") ;
            window.location = "../views/Home.php";
        </script> ';
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="shortcut icon" href="../Imagenes/movility.ico" />
    <link rel="stylesheet" href="../CSS/edicion_uat.css">

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
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/requerimientos.php">Requerimientos</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/tareas.php">Tareas</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/Autoriza.php">Aprobaciones</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/asignacion.php">Asignaciones</a> 
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

<?php
// ================== Totales del catálogo (un solo query) ==================
$tot_catalogo    = 0;
$tot_activos     = 0;
$tot_por_activar = 0;
$tot_reservados  = 0;

if (isset($con)) {
    $sqlTotals = "
        SELECT 
            COUNT(*)                                           AS total_catalogo,
            SUM(CASE WHEN estatus = 1 THEN 1 ELSE 0 END)       AS total_activos,
            SUM(CASE WHEN estatus = 2 THEN 1 ELSE 0 END)       AS total_por_activar,
            SUM(CASE WHEN estatus = 3 THEN 1 ELSE 0 END)       AS total_reservados
        FROM mobility_solutions.tmx_auto
    ";
    if ($resTotals = mysqli_query($con, $sqlTotals)) {
        if ($rowT = mysqli_fetch_assoc($resTotals)) {
            $tot_catalogo    = (int)$rowT['total_catalogo'];
            $tot_activos     = (int)$rowT['total_activos'];
            $tot_por_activar = (int)$rowT['total_por_activar'];
            $tot_reservados  = (int)$rowT['total_reservados'];
        }
        mysqli_free_result($resTotals);
    }
}

// Iniciales para el avatar
$ini       = trim(($nombre ?? 'Usuario') . ' ' . ($last_name ?? 'Demo'));
$parts     = preg_split('/\s+/', $ini);
$iniciales = mb_substr($parts[0] ?? 'U', 0, 1) . mb_substr($parts[1] ?? '', 0, 1);
?>

<!-- ===== MAIN · ESTILO NUEVO ===== -->
<div class="container ms-settings-wrap">

  <!-- Encabezado con usuario -->
  <div class="ms-head card shadow-sm mb-3">
    <div class="card-body d-flex align-items-center gap-3 flex-wrap">
      <div class="ms-avatar">
        <?= htmlspecialchars(strtoupper($iniciales)) ?>
      </div>
      <div class="flex-grow-1">
        <div class="h5 mb-0">
          <?= htmlspecialchars(($nombre ?? 'Usuario') . ' ' . ($last_name ?? 'Demo')) ?>
        </div>
        <small class="text-muted">
          <?= htmlspecialchars($user_name ?? 'usuario') ?> · Editor de catálogo
        </small>
      </div>
      <a class="btn btn-outline-dark btn-sm" href="https://mobilitysolutionscorp.com/db_consultas/cerrar_sesion.php">
        <i class="fa fa-sign-out me-1"></i>Salir
      </a>
    </div>
  </div>

  <div class="row g-3">
    <!-- Sidebar lateral -->
    <aside class="col-12 col-lg-3">
      <nav class="list-group ms-side sticky-lg-top">
        <a href="#resumen" class="list-group-item list-group-item-action active">
          <i class="fa fa-bar-chart me-2"></i> Resumen catálogo
        </a>
        <a href="#tabla" class="list-group-item list-group-item-action">
          <i class="fa fa-table me-2"></i> Listado de autos
        </a>
      </nav>
    </aside>

    <!-- Contenido principal -->
    <section class="col-12 col-lg-9">

      <!-- ========== CARD RESUMEN (Totales) ========== -->
      <div id="resumen" class="card ms-card shadow-sm mb-3">
        <div class="card-header d-flex align-items-center justify-content-between">
          <span class="fw-semibold">
            <i class="fa fa-bar-chart me-2"></i> Resumen del catálogo
          </span>
          <button type="button" class="btn btn-outline-dark btn-sm" onclick="location.reload()">
            <i class="fa fa-refresh me-1"></i> Actualizar
          </button>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <!-- Catálogo total -->
            <div class="col-6 col-md-3">
              <div class="ms-stat card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                  <div class="ms-stat-icon">
                    <img src="../Imagenes/Catalogo/cat.png" alt="Catálogo">
                  </div>
                  <div>
                    <div class="ms-stat-label">Catálogo</div>
                    <div class="ms-stat-value">
                      <?= number_format($tot_catalogo) ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Activos -->
            <div class="col-6 col-md-3">
              <div class="ms-stat card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                  <div class="ms-stat-icon">
                    <img src="../Imagenes/ver.jpg" alt="Activos">
                  </div>
                  <div>
                    <div class="ms-stat-label">Activo</div>
                    <div class="ms-stat-value">
                      <?= number_format($tot_activos) ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Por activar -->
            <div class="col-6 col-md-3">
              <div class="ms-stat card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                  <div class="ms-stat-icon">
                    <img src="../Imagenes/Catalogo/check.png" alt="Por activar">
                  </div>
                  <div>
                    <div class="ms-stat-label">Por activar</div>
                    <div class="ms-stat-value">
                      <?= number_format($tot_por_activar) ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Reservado -->
            <div class="col-6 col-md-3">
              <div class="ms-stat card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                  <div class="ms-stat-icon">
                    <img src="../Imagenes/Catalogo/reserve.png" alt="Reservado">
                  </div>
                  <div>
                    <div class="ms-stat-label">Reservado</div>
                    <div class="ms-stat-value">
                      <?= number_format($tot_reservados) ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div> <!-- /row -->
        </div>
      </div>
      <!-- ========== /CARD RESUMEN ========== -->


      <!-- ========== CARD TABLA CATÁLOGO ========== -->
      <div id="tabla" class="card ms-card shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between">
          <span class="fw-semibold">
            <i class="fa fa-car me-2"></i> Catálogo de autos
          </span>
          <!-- Botón que abre el modal de alta -->
          <button type="button" class="btn btn-sm btn-brand" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-plus me-1"></i> Nuevo auto
          </button>
        </div>
        <div class="card-body">

          <!-- Modal AGREGAR AUTOMÓVIL -->
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
                                            $id_suc = $row['id'];
                                            $nombre_suc = $row['nombre'];
                            ?> 
                                        <option value="<?php echo $id_suc;?>"><?php echo $nombre_suc;?></option>
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
                                            $id_mar = $row['id'];
                                            $nombre_mar = $row['nombre'];
                            ?> 
                                        <option value="<?php echo $id_mar;?>"><?php echo $nombre_mar;?></option>
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
                                <input class="form-check-input" type="radio" name="InputTransmision" id="InputTransmision2" value="Automatico">
                                <label class="form-check-label" for="InputTransmision2">TA (Automatico)</label>
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
                                <input class="form-check-input" type="radio" name="InputInterior" id="InputInterior2" value="Piel">
                                <label class="form-check-label" for="InputInterior2">Piel</label>
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
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible2" value="Electrico">
                                <label class="form-check-label" for="InputCombustible2">Electrico</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible3" value="Hibrido">
                                <label class="form-check-label" for="InputCombustible3">Hibrido</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="InputCombustible" id="InputCombustible4" value="Disel">
                                <label class="form-check-label" for="InputCombustible4">Disel</label>
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
                  <!-- Fin formulario -->
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          <!-- /Modal AGREGAR AUTOMÓVIL -->

          <!-- Tabla de catálogo -->
          <div class="table-responsive mt-3">
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
                                        $id          = $row['id'];
                                        $nombre_auto = $row['nombre'];
                                        $id_vehiculo = $row['id_vehiculo'];
                                        $modelo      = $row['modelo'];
                                        $id_modelo   = $row['id_modelo'];
                                        $marca       = $row['marca'];
                                        $id_marca    = $row['id_marca'];
                                        $mensualidad = $row['mensualidad'];
                                        $costo       = $row['costo'];
                                        $sucursal    = $row['sucursal'];
                                        $id_sucursal = $row['id_sucursal'];
                                        $color       = $row['color'];
                                        $interior    = $row['interior'];
                                        $combustible = $row['combustible'];
                                        $cilindros   = $row['cilindros'];
                                        $transmision = $row['transmision'];
                                        $kilometraje = $row['kilometraje'];
                                        $eje         = $row['eje'];
                                        $estatus     = $row['estatus'];
                                        $created_at  = $row['created_at'];
                                        $updated_at  = $row['updated_at'];
                                        $c_type      = $row['c_type'];
                    ?> 
                        <tr>
                            <th class="text-muted"><?php echo $id;?></th>
                            <td><?php echo $marca;?></td>
                            <td><?php echo $nombre_auto . ' / ' . $modelo;?></td>
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
                                    echo "<tr><td colspan='13'>Hubo un error en la consulta</td></tr>";
                                }
                                mysqli_free_result($result);                  
                            }
                    ?>
                </tbody>
            </table>
          </div> <!-- /table-responsive -->

        </div>
      </div>
      <!-- ========== /CARD TABLA CATÁLOGO ========== -->

    </section>
  </div>
</div>
<!-- ===== /MAIN · ESTILO NUEVO ===== -->


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
