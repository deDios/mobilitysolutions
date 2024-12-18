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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTable JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
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
              <li><a class="waves-effect waves-dark" href="#"><i class="fa fa-map-marker"></i></a></li>
              <li><a class="waves-effect waves-dark" href="#"><i class="fa fa-user"></i></a></li>
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
            <a class="nav-link" href="#">Inicio
              <span class="sr-only">(current)</span>
            </a>
          </li>

          <li class="nav-item active">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/editar_cat.php">Catálogo</a>
          </li>

         <li class="nav-item">
            <a class="nav-link" href="#">Requerimientos</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#">Aprobaciones</a>
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
                            <h6>Activos</h6>
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
                            <h6>Reservados</h6>
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
<a href="../insert_reg.php"  class="btn btn-success mt-2">+</a>

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
        <tr>
            <td>Tiger Nixon</td>
            <td>System Architect</td>
            <td>Edinburgh</td>
            <td>61</td>
            <td>2011/04/25</td>
            <td>$320,800</td>
            <td>$320,800</td>
            <td>$320,800</td>
            <td>$320,800</td>
            <td>$320,800</td>
            <td>$320,800</td>
            <td>$320,800</td>
            <td>$320,800</td>
        </tr>
        
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
                                    auto.estatus, 
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
        responsive: true
    });
</script>
<script>        
        function detalle (cod){
            location.href="../detalles.php?cod="+cod;
        }
</script>

                                                
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>