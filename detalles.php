
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
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

 </head>
 <body>
    <header>
        <a href="index.php" class="logo" title="Home">
            <img src="logo_MSC.png" alt="Logo de la compañia">
            <h2 class="Nombre de la empresa">
                Mobility Solutions Corporation
            </h2>
        </a>
        <nav>
            <a href="index.php" class="nav-link" title="Home">Inicio</a>
            <a href="catalogo.php" class="nav-link" title="Home">Catálogo</a>
            <a href="" class="nav-link">Cotizador</a>
            <a href="" class="nav-link">Sobre nosotros</a>
            <a href="" class="nav-link">Contacto</a>
        </nav>
    </header>

    <div class="contenedor">
        <div class="contenedor_carr">

            <!-- Titulo de carrusel -->
            <div class="titulo_carr">
                <img src="Imagenes/Marcas/logo_<?php echo $marca; ?>.jpg" alt="logo 1">
                <div class="Descripcion">
                    <div class="texto">  <?php echo $marca; ?> </div>
                    <div class="texto2"> <?php echo $modelo . " | " . $interior ." | " . $combustible . " | " . $cilindros ;?> </div>
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
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img01.jpg" alt="Ilustracion">
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>
                        <div class="item">
                            <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img01.jpg" alt="fotografia" width="600" height="300"> 
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>
                        <div class="item">
                            <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img01.jpg" alt="fotografia" width="600" height="300"> 
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>
                        <div class="item">
                            <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img01.jpg" alt="fotografia" width="600" height="300"> 
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>
                        <div class="item">
                            <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img01.jpg" alt="fotografia" width="600" height="300"> 
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>
                        <div class="item">
                            <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img01.jpg" alt="fotografia" width="600" height="300"> 
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
                        EJE
                        <span class="badge bg-primary rounded-pill"><?php echo $eje;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Sucursal
                        <span class="badge bg-primary rounded-pill"><?php echo $sucursal;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Numero de dueños
                        <span class="badge bg-primary rounded-pill"><?php echo $id;?></span>
                    </li>
                </ul>
            </div>

        </div>
        <div class="cotizador">

        </div>
    </div>

</body>
</html>