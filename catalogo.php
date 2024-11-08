
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="stylesheet" href="CSS/catalogo.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


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
              <li><a class="waves-effect waves-dark" href="https://maps.app.goo.gl/G2WDrF97WDnzrQGr6"><i class="fa fa-map-marker"></i></a></li>
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
            <a class="nav-link" href="https://mobilitysolutionscorp.com/catalogo.php?buscar=&InputMarca=Todos&InputAnio=Todos&InputColor=Todos&InputTransmision=Todos&InputInterior=Todos&InputTipo=Todos&InputMensualidad_Mayor=&InputMensualidad_Menor=&enviar=">Catálogo</a>
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

<div class="container-items">
    
<!--------------------------------------- Menu lateral ----------------------------------------------->
<div class="menu_item py-3">
  <div class="menu_fix position-fixed">
            <form class="form-search" action="" method="get">
              <div class="input-group input-group-lg">
                    <input class="form-control form-text pl-3" maxlength="128" placeholder="Buscar" type="text" name="buscar" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg"/>
              </div>
              <div class="div_icon pt-2">
                <a class="btn btn-secondary btn-lg" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                  <i class="fa fa-filter"></i>
                </a>
              </div>
            
              <div class="collapse py-2" id="collapseExample">

              <div class="lay_ser"> 
                <h5 class="fw-light py-2">Filtros </h5>
                  <hr class="mt-2 mb-3"/>

                  <div class="accordion" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                          Marca
                        </button>
                      </h2>
                      <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body">
                          <select id="InputMarca" class="form-select" aria-label="Default select example" name="InputMarca">
                              <option value="Todos">Selecciona una Marca</option>                      
                              <?php 
                              $inc = include "db/Conexion.php";    
                                  if ($inc){
                                      $query = 'select 
                                                  a.id,
                                                  a.nombre
                                                FROM mobility_solutions.tmx_marca as a
                                                right join  mobility_solutions.v_catalogo_active as b
                                                on a.nombre = b.marca
                                                group by 1,2
                                                order by nombre asc;';
                                      $result = mysqli_query($con,$query);  
                                      if ($result){         
                                          while($row = mysqli_fetch_assoc($result)){
                                              $id = $row['id'];
                                              $nombre = $row['nombre'];
                              ?> 
                                          <option value="<?php echo $nombre;?>"><?php echo $nombre;?></option>
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
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                          Caracteristicas
                        </button>
                      </h2>
                      <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                        <div class="accordion-body">

                          <div class="pt-1">
                            <select id="InputAnio" class="form-select" aria-label="Default select example" name="InputAnio">
                                <option value="Todos">Selecciona año</option> 
                                <option value="2013">2013</option> 
                                <option value="2014">2014</option> 
                                <option value="2015">2015</option> 
                                <option value="2016">2016</option> 
                                <option value="2017">2017</option> 
                                <option value="2018">2018</option> 
                                <option value="2019">2019</option> 
                                <option value="2020">2020</option> 
                                <option value="2021">2021</option> 
                                <option value="2022">2022</option> 
                                <option value="2023">2023</option> 
                                <option value="2024">2024</option> 
                                <option value="2025">2025</option> 
                            </select>
                          </div>
                          <div class="pt-1">
                            <select id="InputColor" class="form-select" aria-label="Default select example" name="InputColor">
                                <option value="Todos">Selecciona color</option> 
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
                          <div class="pt-1">
                            <select id="InputTransmision" class="form-select" aria-label="Default select example" name="InputTransmision">
                                <option value="Todos">Selecciona transmisión</option> 
                                <option value="Manual">TM (Manual)</option>  
                                <option value="Automatico">TA (Automatico)</option>
                            </select>
                          </div>
                          <div class="pt-1">
                            <select id="InputInterior" class="form-select" aria-label="Default select example" name="InputInterior">
                                <option value="Todos">Selecciona interior</option> 
                                <option value="Tela">Tela</option>  
                                <option value="Piel">Piel</option>
                            </select>
                          </div>
                          <div class="pt-1">
                            <select id="InputTipo" class="form-select" aria-label="Default select example" name="InputTipo">
                                <option value="Todos">Selecciona tipo</option> 
                                <option value="HB">HB</option>
                                <option value="Sedan">Sedan</option>
                                <option value="SUV">SUV</option>  
                                <option value="Pickup">Pickup</option>
                            </select>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                          Precio
                        </button>
                      </h2>
                      <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                        <div class="accordion-body">

                        <div class="pt-1">
                          <span class="input-group-text">$ Mayor a: MX/mensuales</span>
                              <input id="InputMensualidad_Mayor" type="text" class="form-control" name="InputMensualidad_Mayor" aria-label="Amount (to the nearest dollar)">
                        </div>
                        <div class="pt-3">
                          <span class="input-group-text">$ Menor a: MX/mensuales</span>
                              <input id="InputMensualidad_Menor" type="text" class="form-control" name="InputMensualidad_Menor" aria-label="Amount (to the nearest dollar)">
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="text-end">
                    <button class="btn btn-link" type="submit" name="enviar">Aplicar filtros</button>
                  </div>
                  </form>
              </div>
              </div>

              <div class="anuncios">
              <p class="titulo_r py-5"><small></small></p>
              <p><small>Anuncios</small></p> <hr class="mt-2 mb-3"/>
              </div>
  </div>
</div>
<!--------------------------------------- Termina menu lateral ----------------------------------------------->

<!--------------------------------------- Menu izquierda ----------------------------------------------->

        <div class="lista_item">
            <?php 
                $inc = include "db/Conexion.php";    
                if(isset($_GET['enviar'])) {
                  $busqueda = $_GET['buscar'];
                  $busqueda = trim($busqueda);
                    if ($inc){
                        $query = "select 
                                    id, 
                                    nombre, 
                                    modelo, 
                                    marca, 
                                    mensualidad, 
                                    costo, 
                                    sucursal, 
                                    img1, 
                                    img2, 
                                    img3, 
                                    img4, 
                                    img5, 
                                    img6, 
                                    color, 
                                    transmision, 
                                    interior, 
                                    kilometraje, 
                                    combustible, 
                                    cilindros, 
                                    eje, 
                                    estatus, 
                                    pasajeros, 
                                    propietarios, 
                                    created_at, 
                                    updated_at, 
                                    search_key
                                  from mobility_solutions.v_catalogo_active 
                                  where 1=1
                                  ";
                        if ($_GET['InputColor'] != '' ){
                          $query .=" AND search_key like '%".$busqueda."%' ";
                        }
                        if ($_GET['InputMarca'] != 'Todos' ){
                          $query .=" AND marca = '".$_GET['InputMarca']."' ";
                        }
                        if ($_GET['InputColor'] != 'Todos' ){
                          $query .=" AND color = '".$_GET['InputColor']."' ";
                        }
                        if ($_GET['InputTransmision'] != 'Todos' ){
                          $query .=" AND transmision = '".$_GET['InputTransmision']."' ";
                        }
                        if ($_GET['InputInterior'] != 'Todos' ){
                          $query .=" AND interior = '".$_GET['InputInterior']."' ";
                        }
                        if ($_GET['InputAnio'] != 'Todos' ){
                          $query .=" AND nombre like '%".$_GET['InputAnio']."%' ";
                        }
                        if ($_GET['InputMensualidad_Mayor'] != '' ){
                          $query .=" AND mensualidad >= '".$_GET['InputMensualidad_Mayor']."' ";
                        }
                        if ($_GET['InputMensualidad_Menor'] != '' ){
                          $query .=" AND mensualidad <= '".$_GET['InputMensualidad_Menor']."' ";
                        }
                        if ($_GET['InputTipo'] != 'Todos' ){
                          $query .=" AND modelo like '%".$_GET['InputTipo']."%' ";
                        }
                        $query .=" order by RAND()";
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
                                $estatus = $row['estatus'];
            ?> 
                                    <a href="javascript:detalle(<?php echo $id;?>)">
                                        <div class="item">
                                            <figure>
                                                <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img01.jpg" alt="Auto 1">
                                            </figure>
                                            <div class="info-producto">
                                                <div class="titulo_marca">
                                                    <div class="titulo_carro">  <?php echo $marca . " " . $nombre; ?>  </div>
                                                    <img src="Imagenes/Marcas/logo_<?php echo $marca; ?>.jpg" alt="logo 1">
                                                </div>
                                                <div class="version_unidad"><?php echo "N°25000A/" .  $id . " - " . $modelo; ?></div>
                                                <div class="titulo_desde">Mensualidad DESDE</div>
                                                <div class="mensualidades"> <?php echo "$" . number_format($mensualidad) . "/mes"; ?> </div>
                                                <div class="Precio"><?php echo "$" . number_format($costo); ?> </div>
                                                <div class="Localidad"> 
                                                <div> <i class="bi bi-geo-alt-fill"></i> 
                                                  <?php echo " " . $sucursal;?> 
                                                </div>
                                                <?php if ($estatus == 3){?>
                                                  <img src="Imagenes/Sellos/reservado.jpg" class="imagen-sello" alt="sello">
                                                <?php
                                                  } else {
                                                ?> <?php } ?>
                                              </div>
                                            </div>
                                        </div>            
                                    </a>                             
            <?php
                            }
                        } else{
                            echo "Hubo un error en la consulta";
                        }
                        mysqli_free_result($result);                  
                    }
                }
                else{
                  if ($inc){
                    $query = "select 
                                id, 
                                nombre, 
                                modelo, 
                                marca, 
                                mensualidad, 
                                costo, 
                                sucursal, 
                                img1, 
                                img2, 
                                img3, 
                                img4, 
                                img5, 
                                img6, 
                                color, 
                                transmision, 
                                interior, 
                                kilometraje, 
                                combustible, 
                                cilindros, 
                                eje, 
                                estatus, 
                                pasajeros, 
                                propietarios, 
                                created_at, 
                                updated_at, 
                                search_key
                              from mobility_solutions.v_catalogo_active
                              where 1=1";
                    if ($_GET['InputColor'] != 'Todos' ){
                      $query .=" AND color = '".$_GET['InputColor']."' ";
                    }
                    if ($_GET['InputMarca'] != 'Todos' ){
                      $query .=" AND marca = '".$_GET['InputMarca']."' ";
                    }
                    if ($_GET['InputTransmision'] != 'Todos' ){
                      $query .=" AND transmision = '".$_GET['InputTransmision']."' ";
                    }
                    if ($_GET['InputInterior'] != 'Todos' ){
                      $query .=" AND interior = '".$_GET['InputInterior']."' ";
                    }
                    if ($_GET['InputAnio'] != 'Todos' ){
                      $query .=" AND nombre like '%".$_GET['InputAnio']."%' ";
                    }
                    if ($_GET['InputMensualidad_Mayor'] != '' ){
                      $query .=" AND mensualidad >= '".$_GET['InputMensualidad_Mayor']."' ";
                    }
                    if ($_GET['InputMensualidad_Menor'] != '' ){
                      $query .=" AND mensualidad <= '".$_GET['InputMensualidad_Menor']."' ";
                    }
                    if ($_GET['InputTipo'] != 'Todos' ){
                      $query .=" AND modelo like '%".$_GET['InputTipo']."%' ";
                    }
                    $query .=" order by RAND()";
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
                            $estatus = $row['estatus'];
        ?> 
                                <a href="javascript:detalle(<?php echo $id;?>)">
                                    <div class="item">
                                        <figure>
                                            <img src="Imagenes/Catalogo/Auto <?php echo $id;?>/Img01.jpg" alt="Auto 1">
                                        </figure>
                                        <div class="info-producto">
                                            <div class="titulo_marca">
                                                <div class="titulo_carro">  <?php echo $marca . " " . $nombre; ?>  </div>
                                                <img src="Imagenes/Marcas/logo_<?php echo $marca; ?>.jpg" alt="logo 1">
                                            </div>
                                            <div class="version_unidad"><?php echo "N°25000A/" .  $id . " - " . $modelo; ?></div>
                                            <div class="titulo_desde">Mensualidad DESDE</div>
                                            <div class="mensualidades"> <?php echo "$" . number_format($mensualidad) . "/mes"; ?> </div>
                                            <div class="Precio"><?php echo "$" . number_format($costo); ?> </div>
                                            <div class="Localidad"> 
                                              <div>
                                                <i class="bi bi-geo-alt-fill"></i>  <?php echo " " . $sucursal;?>  
                                              </div>
                                              <?php 
                                                if ($estatus == 3){
                                              ?>
                                                <img src="Imagenes/Sellos/reservado.jpg" alt="sello">
                                              <?php
                                                } else {
                                              ?>
                                               <?php
                                                }
                                              ?>
                                            </div>
                                        </div>
                                    </div>            
                                </a>                             
        <?php
                        }
                    } else{
                        echo "Hubo un error en la consulta";
                    }
                    mysqli_free_result($result);                  
                }
                }
            ?>
        </div>
    </div>

</div>
    <script>        
        function detalle (cod){
            location.href="detalles.php?cod="+cod;
        }
    </script>

  <footer class="text-muted py-5">
    <div class="container">
      <p class="float-end mb-1">
        <a href="#">Regresa al inicio</a>
      </p>
      <p class="mb-1">DERECHOS DE AUTOR &COPY; 2014 - 2024 MOBILITY SOLUTIONTS CORPORATIONS</p>
      <a title="Descargar Archivo" rel="nofollow" href="/Views/privacy.php" style="color: blue; font-size:18px;"> Consulta nuestro aviso de privacidad 
      <span class="glyphicon glyphicon-download-alt" aria-hidden="true">
      </span> 
      </a>
      <p class="mb-0">Contactanos: contacto@mobilitysolutionscorp.com</p>
    </div>
  </footer>



<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


 </body>
 </html>
