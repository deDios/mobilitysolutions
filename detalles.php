
<?php
$cod=$_REQUEST['cod'];

$inc = include "db/Conexion.php"; 
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
            where auto.id = '. $cod .';';

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
                                $color = $row['color'];
                                $interior = $row['interior'];
                                $combustible = $row['combustible'];
                                $cilindros = $row['cilindros'];
                                $transmision = $row['transmision'];
                                $kilometraje = $row['kilometraje'];
                                $eje = $row['eje'];
                                $pasajeros = $row['pasajeros'];
                                $propietarios = $row['propietarios'];
            }
        }
        else{
            echo "Falla en conexión";
        }
?>

<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalle del auto</title>
    <link rel="stylesheet" href="CSS/detalles.css">

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
              <li><a class="waves-effect waves-dark" href="#"><i class="fa fa-twitter"></i></a></li>
              <li><a class="waves-effect waves-dark" href="#"><i class="fa fa-instagram"></i></a></li>
            </ul>
          </div>

        </div>
      </div>
  </header>
  <nav class="navbar navbar-expand-lg navbar-dark mx-background-top-linear">
    <div class="container">
      <a class="navbar-brand" rel="nofollow" target="_blank" href="https://mobilitysolutionscorp.com"> Mobility Solutions Corporation</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">

        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com">Inicio
              <span class="sr-only">(current)</span>
            </a>
          </li>

          <li class="nav-item active">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/catalogo.php">Catálogo</a>
          </li>

         <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/about_us.php">Nosotros</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/contact.php">Contacto</a>
          </li>

        </ul>
      </div>
    </div>
  </nav>
</div>

<!--------------------------------------- Termina Menu ----------------------------------------------->
    

    <div class="contenedor">
        <div class="contenedor_carr">

            <!-- Titulo de carrusel -->
            <div class="titulo_carr">
                <img src="Imagenes/Marcas/logo_<?php echo $marca; ?>.jpg" alt="logo 1">
                <div class="Descripcion">
                    <div class="texto">  <?php echo $marca . " " . $nombre . " " . $modelo;?> </div>
                    <div class="texto2"> <?php echo "$" . number_format($mensualidad) ."MXN/mes* | " . "$" . number_format($costo) . "MXN/contado" ;?> </div>
                </div>
            </div>
<!-------------------------------- Carrusel auto seleccionado -------------------------------------->
          
            <div class="carrusel_carr_auto">
                <div id="theCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicadores -->
                    <ol class="carousel-indicators">
                        <li data-target="#theCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#theCarousel" data-slide-to="1"></li>
                        <li data-target="#theCarousel" data-slide-to="2"></li>
                        <li data-target="#theCarousel" data-slide-to="3"></li> 
                        <li data-target="#theCarousel" data-slide-to="4"></li> 
                        <li data-target="#theCarousel" data-slide-to="5"></li> 
                        <li data-target="#theCarousel" data-slide-to="6"></li> 
                        <li data-target="#theCarousel" data-slide-to="7"></li>    
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img01.jpg" alt="Ilustracion">
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>
                        <div class="item">
                            <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img02.jpg" alt="fotografia" width="600" height="300"> 
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>
                        <div class="item">
                            <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img03.jpg" alt="fotografia" width="600" height="300"> 
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>
                        <div class="item">
                            <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img04.jpg" alt="fotografia" width="600" height="300"> 
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>
                        <div class="item">
                            <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img05.jpg" alt="fotografia" width="600" height="300"> 
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>
                        <div class="item">
                            <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img06.jpg" alt="fotografia" width="600" height="300"> 
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>
                        <div class="item">
                            <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img07.jpg" alt="fotografia" width="600" height="300"> 
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>
                        <div class="item">
                            <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img08.jpg" alt="fotografia" width="600" height="300"> 
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>

                        <a class="left carousel-control" href="#theCarousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">anterior</span>
                        </a>
                        <a class="right carousel-control" href="#theCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">siguiente</span>
                        </a>

                    </div>
                </div>
            </div>

<!-------------------------------------- Div detalle de auto ----------------------------------------------------------->
            <div class="detalle_carr">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Interior de vehiculo.
                        <span class="badge bg-primary rounded-pill"><?php echo $interior;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Color de vehiculo.
                        <span class="badge bg-primary rounded-pill"><?php echo $color;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Transmision
                        <span class="badge bg-primary rounded-pill"><?php echo $transmision;?></span>
                    </li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        kilometraje
                        <span class="badge bg-primary rounded-pill"><?php echo number_format($kilometraje) . "km";?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Tipo de combustible
                        <span class="badge bg-primary rounded-pill"><?php echo $combustible;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cilindros
                        <span class="badge bg-primary rounded-pill"><?php echo $cilindros;?></span>
                    </li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pasajeros
                        <span class="badge bg-primary rounded-pill"><?php echo $pasajeros;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Sucursal
                        <span class="badge bg-primary rounded-pill"><?php echo $sucursal;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        N° de propietarios
                        <span class="badge bg-primary rounded-pill"><?php echo $propietarios;?></span>
                    </li>
                </ul>
            </div>

        </div>
        <div class="cotizador">

        </div>
    </div>

</body>
</html>