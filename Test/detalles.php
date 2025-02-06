<?php
$cod=$_REQUEST['cod'];

$inc = include "../db/Conexion.php"; 
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
                                $estatus = $row['estatus'];
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
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
    

    <div class="contenedor">
        <div class="contenedor_carr">

            <!-- Titulo de carrusel -->
            <div class="titulo_carr">
                <img src="../Imagenes/Marcas/logo_<?php echo $marca; ?>.jpg" alt="logo 1">
                <div class="Descripcion">
                    <div class="texto">  <?php echo $marca . " " . $nombre . " " . $modelo;?> </div>
                    <div class="desc_costo"> 
                        <div class="texto2"> <?php echo "DESDE $" . number_format($mensualidad) ."/mes | " . "$" . number_format($costo);?> </div>
                        <div class="id_t"><?php echo " #".$id;?></div> 
                    </div>
                </div>
            </div>
<!-------------------------------- Carrusel auto seleccionado -------------------------------------->
<?php
$imagenes = [
    '../Imagenes/Catalogo/Auto '.$id.'/Img01.jpg',
    '../Imagenes/Catalogo/Auto '.$id.'/Img02.jpg',
    '../Imagenes/Catalogo/Auto '.$id.'/Img03.jpg',
    '../Imagenes/Catalogo/Auto '.$id.'/Img04.jpg',
    '../Imagenes/Catalogo/Auto '.$id.'/Img05.jpg',
    '../Imagenes/Catalogo/Auto '.$id.'/Img06.jpg',
    '../Imagenes/Catalogo/Auto '.$id.'/Img07.jpg',
    '../Imagenes/Catalogo/Auto '.$id.'/Img08.jpg',
];
?>          

<div class="carrusel">
    <!-- Botón izquierdo -->
    <div class="flecha izquierda" id="flechaIzquierda">&#9664;</div>

    <div class="imagen-grande">
        <img src="<?php echo $imagenes[0]; ?>" id="imagenGrande" alt="Imagen seleccionada">
    </div>

    <!-- Botón derecho -->
    <div class="flecha derecha" id="flechaDerecha">&#9654;</div>

    <div class="miniaturas">
        <?php foreach ($imagenes as $index => $imagen): ?>
            <img src="<?php echo $imagen; ?>" alt="Miniatura <?php echo $index + 1; ?>" 
                 class="miniatura" data-index="<?php echo $index; ?>" />
        <?php endforeach; ?>
    </div>
</div>

<script>
    const miniaturas = document.querySelectorAll('.miniatura');
    const imagenGrande = document.getElementById('imagenGrande');
    const flechaIzquierda = document.getElementById('flechaIzquierda');
    const flechaDerecha = document.getElementById('flechaDerecha');

    let indiceActual = 0;

    const imagenes = <?php echo json_encode($imagenes); ?>;

    const mostrarImagen = (indice) => {
        imagenGrande.src = imagenes[indice];
    };

    flechaIzquierda.addEventListener('click', () => {
        indiceActual = (indiceActual > 0) ? indiceActual - 1 : imagenes.length - 1;
        mostrarImagen(indiceActual);
    });

    flechaDerecha.addEventListener('click', () => {
        indiceActual = (indiceActual < imagenes.length - 1) ? indiceActual + 1 : 0;
        mostrarImagen(indiceActual);
    });

    miniaturas.forEach(miniatura => {
        miniatura.addEventListener('click', () => {
            indiceActual = parseInt(miniatura.getAttribute('data-index'));
            mostrarImagen(indiceActual);
        });
    });
</script>

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

          <div class="container mt-5">
          <h3>Cotizador</h3>

          <div class="row">
              <div class="col-md-4">
                  <label for="enganche" class="form-label">Porcentaje de Enganche</label>
                  <input type="range" class="form-range" id="enganche" min="5" max="100" step="1" value="20">
                  <p>Enganche seleccionado: <span id="engancheValor">20%</span></p>
                  <p>Total Enganche: <span id="engancheTotal">$0.00</span></p>
              </div>
              <div class="col-md-4">
                  <label for="plazo" class="form-label">Plazo (Meses)</label>
                  <input type="text" id="plazo" class="form-control" value="60" readonly>
              </div>
          </div>

          <div class="mt-4">
              <button class="btn btn-primary" id="calcular">Calcular</button>
          </div>

          <div class="mt-4">
              <h4>Tabla informativa</h4>
              <div style="max-height: 500px; overflow-y: auto;"> <!-- Aquí agregamos el scroll -->
                  <table class="table table-bordered">
                      <thead>
                          <tr>
                              <th>Mes</th>
                              <th>Pago Mensual</th>
                              <th>Saldo Restante</th>
                          </tr>
                      </thead>
                      <tbody id="tablaAmortizacion"></tbody>
                  </table>
              </div>
          </div>

          <div class="mt-3">
              <p class="" style="font-size: 0.8rem; font-style: italic; font-style: italic; color:red;">
                Cotización de carácter informativo los Precios/tarifas están sujetos a cambios sin previo aviso, la mensualidad puede variar. Consulte términos y condiciones.
              </p>
          </div>

          </div>

          <script>
          const costoAuto = <?php echo $costo; ?>;

          function formatCurrency(amount) {
              return '$' + amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
          }

          function actualizarEngancheTotal() {
              const enganchePorcentaje = parseFloat(document.getElementById('enganche').value);
              const engancheMonto = (enganchePorcentaje / 100) * costoAuto;
              document.getElementById('engancheTotal').textContent = formatCurrency(engancheMonto); // Formatear el total del enganche
          }

          function calcularPlazo(enganchePorcentaje) {
              if (enganchePorcentaje <= 19) {
                  return 72;
              } else if (enganchePorcentaje <= 50) {
                  return 60;
              } else if (enganchePorcentaje >= 51) {
                  return 48;
              } else {
                  return 60; // Default caso, si no se encuentra en los rangos específicos
              }
          }

          document.getElementById('enganche').addEventListener('input', function () {
              document.getElementById('engancheValor').textContent = this.value + '%';
              actualizarEngancheTotal();
              
              const plazo = calcularPlazo(parseFloat(this.value));
              document.getElementById('plazo').value = plazo; // Actualiza el plazo basado en el enganche
          });

          window.onload = function() {
              const enganchePorcentaje = document.getElementById('enganche').value;
              document.getElementById('engancheValor').textContent = enganchePorcentaje + '%'; // Actualiza el valor del porcentaje al cargar
              actualizarEngancheTotal();
              
              const plazo = calcularPlazo(parseFloat(enganchePorcentaje));
              document.getElementById('plazo').value = plazo; // Establece el valor del plazo basado en el enganche
          };

          document.getElementById('calcular').addEventListener('click', function () {
              const enganchePorcentaje = parseFloat(document.getElementById('enganche').value);
              const plazoMeses = parseInt(document.getElementById('plazo').value);

              const engancheMonto = (enganchePorcentaje / 100) * costoAuto;
              let montoProrratear, pagoMensual;

              if (plazoMeses === 72) {
                  montoProrratear = costoAuto * .018 * plazoMeses; // 1.8% del costo del auto para 72 meses
                  pagoMensual = montoProrratear / plazoMeses;
              } else if (plazoMeses === 60) {
                  montoProrratear = costoAuto * .016 * plazoMeses; // 1.6% del costo del auto para 60 meses
                  pagoMensual = montoProrratear / plazoMeses;
              } else if (plazoMeses === 48) {
                  montoProrratear = costoAuto * .013 * plazoMeses; // 1.3% del costo del auto para 48 meses
                  pagoMensual = montoProrratear / plazoMeses;
              }

              let saldoRestante = montoProrratear;
              const tabla = document.getElementById('tablaAmortizacion');
              tabla.innerHTML = '';

              for (let mes = 1; mes <= plazoMeses; mes++) {
                  saldoRestante -= pagoMensual;

                  const fila = `
                      <tr>
                          <td>${mes}</td>
                          <td>${formatCurrency(pagoMensual)}</td> <!-- Limita a 2 decimales y agrega el símbolo $ -->
                          <td>${formatCurrency(saldoRestante > 0 ? saldoRestante : 0)}</td> <!-- Limita a 2 decimales y agrega el símbolo $ -->
                      </tr>
                  `;
                  tabla.insertAdjacentHTML('beforeend', fila);
              }
          });
          </script>

          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

          </div>


    </div>


    <hr class="mt-5 mb-3"/> 

<footer class="mt-5">  
  <div class="container">    
    <div class="row">      
      <div class="col-lg-3">        
        <h6>Conoce más</h6>  
        <hr class="hr1 mt-2 mb-3"/>      
        <ul class="text-secondary list-unstyled">
          <li>
            <a class="text-secondary" href="https://mobilitysolutionscorp.com/about_us.php">¿Quiénes Somos?</a>
          </li>
        </ul>     
      </div>      
      <div class="col-lg-3">        
        <h6>Legales</h6>    
        <hr class="hr2 mt-2 mb-3"/>    
        <ul class="text-secondary list-unstyled">
          <li>
            <a class="text-secondary" href="/Views/privacy.php">Aviso de privacidad</a>
          </li>
        </ul>       
      </div>      
      <div class="col-lg-3">        
        <h6>Ayuda</h6>    
        <hr class="hr3 mt-2 mb-3"/>    
        <ul class="text-secondary list-unstyled">
          <li>
            <a class="text-secondary" href="https://mobilitysolutionscorp.com/contact.php">Contacto</a>
          </li>
          <li>
            <a class="text-secondary" href="https://mobilitysolutionscorp.com/about_us.php">Preguntas frecuentes</a>
          </li>
        </ul>     
      </div>  
      <div class="col-lg-3">     
        <p class="float-end mb-1">
          <a href="#">Regresa al inicio</a>
        </p>
      </div>    
    </div>  
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>