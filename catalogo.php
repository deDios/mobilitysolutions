<?php
    
    $inc = include "db/Conexion.php";    

        if ($inc){
            $query = 'select id, nombre, modelo, marca, mensualidad, costo, sucursal, img1, img2, img3, img4, img5, img6, estatus, created_at, updated_at FROM tmx_auto';
            $result = mysqli_query($con,$query);  
            if ($result){
            
                $row = mysqli_fetch_row($result);
               echo $row[0];
               echo $row[1];
               echo $row[2];
               echo $row[3];
               echo $row[4];
               echo $row[5];
               echo $row[6];
            
              /*
                while($row = mysqli_fetch_row($result));
                    $id = $row['id'];
                    $nombre = $row['nombre'];
                    $modelo = $row['modelo'];
                    $marca = $row['marca'];
            */
            } else{
                echo "Hubo un error en la consulta";
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
                            <div class="titulo_carro">  <?php echo $nombre; ?>  </div>
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
