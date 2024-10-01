
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
              <li><a class="waves-effect waves-dark" href="#"><i class="fa fa-map-marker"></i></a></li>
              <li><a class="waves-effect waves-dark" href="#"><i class="fa fa-user"></i></a></li>
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
                    <div class="texto2"> <?php echo "DESDE $" . number_format($mensualidad) ."/mes | " . "$" . number_format($costo) ;?> </div>
                </div>
            </div>
<!-------------------------------- Carrusel auto seleccionado -------------------------------------->
          
            <div class="carrusel_carr_auto">
                <div class="div_carrusel">
                <div id="demo" class="py-1 carousel slide" data-bs-ride="carousel" py-1>
                    <!-- Indicators/dots -->
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="4"></button>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="5"></button>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="6"></button>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="7"></button>
                    </div>
                    <!-- The slideshow/carousel -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img01.jpg" alt="Los Angeles" class="d-block w-100">
                                </div>
                                <div class="carousel-item">
                                <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img02.jpg" class="d-block w-100">
                                </div>
                                <div class="carousel-item">
                                <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img03.jpg" class="d-block w-100">
                                </div>
                                <div class="carousel-item">
                                <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img04.jpg" class="d-block w-100">
                                </div>
                                <div class="carousel-item">
                                <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img05.jpg" class="d-block w-100">
                                </div>
                                <div class="carousel-item">
                                <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img06.jpg" class="d-block w-100">
                                </div>
                                <div class="carousel-item">
                                <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img07.jpg" class="d-block w-100">
                                </div>
                                <div class="carousel-item">
                                <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img08.jpg" class="d-block w-100">
                                </div>
                            </div>
                    <!-- Left and right controls/icons -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
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


<footer class="text-muted py-5">
  <div class="container">
    <p class="float-end mb-1">
      <a href="#">Regresa al inicio</a>
    </p>
    <p class="mb-1">DERECHOS DE AUTOR &COPY; 2024 - MOBILITY SOLUTIONTS CORPORATIONS</p>
    <p class="mb-0">Contactanos: contacto@mobilitysolutionscorp.com</p>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>