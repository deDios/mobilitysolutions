
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="stylesheet" href="CSS/catalogo.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Enlaza Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
        <h1>Catálogo A</h1>
    </div>

    <div class="Titulo-boton">
        <input type="text" placeholder="Buscar...">
    </div>

    <div class="container-items">
        <div class="menu_item">

        </div>
        <div class="lista_item">
            <?php
                $inc = include "db/Conexion.php";    
                    if ($inc){
                        $query = '  select 
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
            ?>
                                    <a href="javascript:abrir_detalle()">
                                        <div class="item">
                                            <figure>
                                                <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img01.jpg" alt="Auto 1">
                                            </figure>
                                            <div class="info-producto">
                                                <div class="titulo_marca">
                                                    <div class="titulo_carro">  <?php echo $marca . " " . $nombre; ?>  </div>
                                                    <img src="Imagenes/Marcas/logo_<?php echo $marca; ?>.jpg" alt="logo 1">
                                                </div>
                                                <div class="version_unidad"><?php echo "N° " .  $id . " - " . $modelo; ?></div>
                                                <div class="titulo_desde">Mensualidades, DESDE</div>
                                                <div class="mensualidades"> <?php echo "$" . number_format($mensualidad) . " MXN/mes*"; ?> </div>
                                                <div class="Precio"><?php echo "$" . number_format($costo) . " MXN de contado"; ?> </div>
                                                <div class="Localidad"> <i class="fas fa-location-arrow" ></i> <?php echo " " . $sucursal;?>  </div>
                                            </div>
                                        </div>
                                    </a>

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
                                          /*  document.getElementById("detalles").style.display="block";*/
                                        }
                                        function cerrar_detalle(){
                                            document.getElementById("detalles").style.display="none";
                                        }
                                    </script>
            <?php
                            }
                        } else{
                            echo "Hubo un error en la consulta";
                        }
                        mysqli_free_result($result);                  
                    }
            ?>
        </div>
    </div>

    <footer>
        <div class="pie_pag">
            <p>DERECHOS DE AUTOR &COPY; 2024 - MOBILITY SOLUTIONTS CORPORATIONS</p>
            <p>Contactanos: contacto@mobilitysolutionscorp.com</p>
        </div>
    </footer>

   

 </body>
 </html>
