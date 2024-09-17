<?php
    
    $inc = include ("db/Conexion.php");    

        if ($inc){
            $consulta = "select * from mobility_solutions.tmx_auto";
            $resultado = mysqli_query($con,$consulta) or die ('Error: '. mysqli_error($con));  
            if ($resultado){
                while($row = $resultado->fetch_array());
                    $id = $row['id'];
                    $nombre = $row['nombre'];
                    $modelo = $row['modelo'];
                    $marca = $row['marca'];
                    $mensualidad = $row['mensualidad'];
            }    
        }
    
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="stylesheet" href="CSS/catalogo.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
    
    <div class="Menu-lateral">
        <h1>Catálogo</h1>
    </div>

    <div class="Titulo-boton">
        <input type="text" placeholder="Buscar...">
    </div>

    <div class="container-items">
        <div class="menu_item">

        </div>
        <div class="lista_item">
            
            <a href="javascript:abrir_detalle()">
                <div class="item">
                    <figure>
                        <img src="Imagenes/Catalogo/Auto 1/Img01.jpg" alt="Auto 1">
                    </figure>
                    <div class="info-producto">
                        <div class="titulo_marca">
                            <div class="titulo_carro">  <?php echo $name; ?>  </div>
                            <img src="Imagenes/Marcas/logo_nissan.jpg" alt="logo 1">
                        </div>
                        <div class="version_unidad">5 PTS ADVANCE 16L TA A/AC VE RA-16-2021</div>
                        <div class="titulo_desde">Mensualidades, DESDE</div>
                        <div class="mensualidades">$3,000 MXN/mes*</div>
                        <div class="Precio">$ 314,685 MXN de contado</div>
                        <div class="Localidad">Sucursal Andares, Jal. CP 44940</div>
                    </div>
                </div>
            </a>

        </div>
        
    </div>

    <div class="detalle" id="detalles">
        <div class="cerrar">
            <a href="javascript:cerrar_detalle()">
                <img src="logo_atras.png" alt="">
            </a>
        </div>
        Detalles
    </div>

<script>
    function abrir_detalle(){
        document.getElementById("detalles").style.display="block";
    }
    function cerrar_detalle(){
        document.getElementById("detalles").style.display="none";
    }
</script>

 </body>
 </html>
