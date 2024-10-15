<?php
$cod=$_REQUEST['id'];

?>

<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="stylesheet" href="CSS/editar_cat.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">


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

<div class="container-items">
        <div class="menu_izq">
            <h3>Registros Catálogo</h3>
            <br>
            <a href="insert_reg.php"  class="btn btn-primary mt-5">Agregar automóvil a catálogo</a>
            <a href="insert_reg_auto.php"  class="btn btn-secondary mt-5">Agregar auto a marca</a>
            <a href="insert_reg_mod.php"  class="btn btn-secondary mt-5">Agregar modelo a auto</a>
        </div>

        <div class="menu_der">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="mytable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>marca</th>
                        <th>nombre</th>
                        <th>modelo</th>
                        <th>mensualidad</th>
                        <th>costo</th>
                        <th>sucursal</th>
                        <th>color</th>
                        <th>transmision</th>
                        <th>interior</th>
                        <th>kilometraje</th>
                        <th>combustible</th>
                        <th>cilindros</th>
                        <th>eje</th>
                        <th>estatus</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $inc = include "db/Conexion.php";    
                    if ($inc){
                        $query = 'select 
                                    auto.id,
                                    m_auto.auto as nombre, 
                                    modelo.nombre as modelo, 
                                    marca.nombre as marca, 
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
                                    DATE_SUB(auto.created_at, INTERVAL 6 HOUR) as created_at, 
                                    auto.updated_at 
                                FROM mobility_solutions.tmx_auto as auto
                                left join mobility_solutions.tmx_sucursal as sucursal on auto.sucursal = sucursal.id 
                                left join mobility_solutions.tmx_estatus as estatus on auto.estatus = estatus.id
                                left join mobility_solutions.tmx_modelo as modelo on auto.modelo = modelo.id 
                                left join mobility_solutions.tmx_marca as marca on auto.marca = marca.id
                                left join mobility_solutions.tmx_marca_auto as m_auto on auto.nombre = m_auto.id;';
                        $result = mysqli_query($con,$query);  
                        if ($result){         
                            while($row = mysqli_fetch_assoc($result)){
                                $id = $row['id'];
                                $nombre = $row['nombre'];
                                $modelo = $row['modelo'];
                                $marca = $row['marca'];
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
                ?> 
                    <tr>
                        <th class=""><?php echo $id;?></th>
                        <td><?php echo $marca;?></td>
                        <td><?php echo $nombre;?></td>
                        <td><?php echo $modelo;?></td>
                        <td><?php echo "$" . number_format($mensualidad);?></td>
                        <td><?php echo "$" . number_format($costo);?></td>
                        <td><?php echo $sucursal;?></td>
                        <td><?php echo $color;?></td>
                        <td><?php echo $transmision;?></td>
                        <td><?php echo $interior;?></td>
                        <td><?php echo number_format($kilometraje) . " km";?></td>
                        <td><?php echo $combustible;?></td>
                        <td><?php echo $cilindros;?></td>
                        <td><?php echo $eje;?></td>
                        <td><?php echo $estatus;?></td>
                        <td><?php echo $created_at;?></td>
                        <td><?php echo $updated_at;?></td>
                        <td><a href="javascript:detalle(<?php echo $id;?>)" class="btn btn-primary">Ver</a></td>
                        <td><a href="update_reg.php?id=<?php echo $id;?>&sucursal=<?php echo $id_sucursal;?>" class="btn btn-warning">Editar</a></td>
                        <td><button class="btn btn-danger">Eliminar</button> </td>
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
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"></script>
<script src="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.css"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.1.7/datatables.min.js">
    new DataTable('mytable');
</script>
<script>        
        function detalle (cod){
            location.href="detalles.php?cod="+cod;
        }
</script>

</body>
</html>