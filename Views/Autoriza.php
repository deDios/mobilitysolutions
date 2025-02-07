<?php

    session_start();

    if (!isset ($_SESSION['username'])){
        echo ' 
            <script>
                alert("Es necesario hacer login, por favor ingrese sus credenciales") ;
                window.location = "../views/login.php";
            </script> ';
            session_destroy();
            die();
    }

    $inc = include "../db/Conexion.php";

    $query ='select 
                acc.user_id, 
                acc.user_name, 
                acc.user_password, 
                acc.user_type, 
                acc.r_ejecutivo, 
                acc.r_editor, 
                acc.r_autorizador, 
                acc.r_analista, 
                us.user_name as nombre, 
                us.second_name as s_nombre, 
                us.last_name, 
                us.email, 
                us.cumpleaños, 
                us.telefono
            from mobility_solutions.tmx_acceso_usuario  as acc
            left join mobility_solutions.tmx_usuario as us
                on acc.user_id = us.id
            where acc.user_name = '.$_SESSION['username'].';';

    $result = mysqli_query($con,$query); 

    if ($result){ 
        while($row = mysqli_fetch_assoc($result)){
                            $user_id = $row['user_id'];
                            $user_name = $row['user_name'];
                            $user_password = $row['user_password'];
                            $user_type = $row['user_type'];
                            $r_ejecutivo = $row['r_ejecutivo'];
                            $r_editor = $row['r_editor'];
                            $r_autorizador = $row['r_autorizador'];
                            $r_analista = $row['r_analista'];
                            $nombre = $row['nombre'];
                            $s_nombre = $row['s_nombre'];
                            $last_name = $row['last_name'];
                            $email = $row['email'];
                            $cumpleaños = $row['cumpleaños'];
                            $telefono = $row['telefono'];
                           
        }
    }
    else{
        echo 'Falla en conexión.';
    }

    if ($r_autorizador == 0){
        echo ' 
        <script>
            alert("No tiene acceso para entrar al apartado de aprobaciones, favor de solicitarlo al departamento de sistemas") ;
            window.location = "../views/Home.php";
        </script> ';
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprobaciones</title>
    <link rel="shortcut icon" href="../Imagenes/movility.ico" />
    <link rel="stylesheet" href="../CSS/autoriza.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTable JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
 
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
   
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
              
              <li><a class="waves-effect waves-dark" href="" data-toggle="modal" data-target="#exampleModal2"><i class="fa fa-map-marker"></i></a></li>       

              <li><a class="waves-effect waves-dark" href="https://mobilitysolutionscorp.com/db_consultas/cerrar_sesion.php"><i class="fa fa-sign-out"></i></a></li>
            </ul>
          </div>

        </div>
      </div>
  </header>

  <nav class="navbar navbar-expand-lg navbar-dark mx-background-top-linear">
    <div class="container">
      <a class="navbar-brand" rel="nofollow" target="_blank" href="#"> Aprobaciones </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">

        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/Home.php">Inicio
              <span class="sr-only">(current)</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/edicion_catalogo.php">Catálogo</a>
          </li>

         <li class="nav-item">
            <a class="nav-link" href="#">Requerimientos</a>
          </li>

          <li class="nav-item active">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/Autoriza.php">Aprobaciones</a>
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


<?php
$inc = include "../db/Conexion.php";
$query = 'select 
                auto.id,
                auto.id_auto,
                auto.tipo_req,
                auto.comentarios,
                auto.req_created_at,
                auto.c_type,
                auto.created_by,
                m_auto.auto AS nombre, 
                modelo.nombre AS modelo, 
                marca.nombre AS marca, 
                auto.mensualidad, 
                auto.costo, 
                sucursal.nombre AS sucursal, 
                auto.color, 
                auto.transmision, 
                auto.interior, 
                auto.kilometraje, 
                auto.combustible, 
                auto.cilindros, 
                auto.eje, 
                auto.pasajeros, 
                auto.propietarios,
                auto.created_at, 
                auto.updated_at 
          FROM mobility_solutions.tmx_requerimiento AS auto
          LEFT JOIN mobility_solutions.tmx_sucursal AS sucursal ON auto.sucursal = sucursal.id 
          LEFT JOIN mobility_solutions.tmx_modelo AS modelo ON auto.modelo = modelo.id 
          LEFT JOIN mobility_solutions.tmx_marca AS marca ON auto.marca = marca.id
          LEFT JOIN mobility_solutions.tmx_marca_auto AS m_auto ON auto.nombre = m_auto.id
          WHERE auto.status_req = 1;';

$result = mysqli_query($con, $query);
$requerimientos = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Definir el arreglo de imágenes
        $imagenes = [
            '../Imagenes/Catalogo/Auto ' . $row['id'] . '/Img01.jpg',
            '../Imagenes/Catalogo/Auto ' . $row['id'] . '/Img02.jpg',
            '../Imagenes/Catalogo/Auto ' . $row['id'] . '/Img03.jpg',
            '../Imagenes/Catalogo/Auto ' . $row['id'] . '/Img04.jpg',
            '../Imagenes/Catalogo/Auto ' . $row['id'] . '/Img05.jpg',
            '../Imagenes/Catalogo/Auto ' . $row['id'] . '/Img06.jpg',
            '../Imagenes/Catalogo/Auto ' . $row['id'] . '/Img07.jpg',
            '../Imagenes/Catalogo/Auto ' . $row['id'] . '/Img08.jpg',
        ];

        $requerimientos[] = [
            "id" => $row['id'],
            "id_auto" => $row['id_auto'],
            "tipo_req" => $row['tipo_req'],
            "comentarios" => $row['comentarios'],
            "req_created_at" => $row['req_created_at'],
            "c_type" => $row['c_type'],
            "created_by" => $row['created_by'],
            "nombre" => $row['nombre'],
            "titulo" => $row['id'] . ' (' . $row['tipo_req'] . ')',
            "detalle" => 
                "<strong>Nombre:</strong> " . $row['nombre'] . "<br>" .
                "<strong>Modelo:</strong> " . $row['modelo'] . "<br>" .
                "<strong>Marca:</strong> " . $row['marca'] . "<br>" .
                "<strong>Mensualidad:</strong> $" . number_format($row['mensualidad'], 2) . "<br>" .
                "<strong>Costo:</strong> $" . number_format($row['costo'], 2) . "<br>" .
                "<strong>Sucursal:</strong> " . $row['sucursal'] . "<br>" .
                "<strong>Color:</strong> " . $row['color'] . "<br>" .
                "<strong>Transmisión:</strong> " . $row['transmision'] . "<br>" .
                "<strong>Interior:</strong> " . $row['interior'] . "<br>" .
                "<strong>Kilometraje:</strong> " . number_format($row['kilometraje']) . " km<br>" .
                "<strong>Combustible:</strong> " . $row['combustible'] . "<br>" .
                "<strong>Cilindros:</strong> " . $row['cilindros'] . "<br>" .
                "<strong>Eje:</strong> " . $row['eje'] . "<br>" .
                "<strong>Pasajeros:</strong> " . $row['pasajeros'] . "<br>" .
                "<strong>Propietarios Previos:</strong> " . $row['propietarios'] . "<br>" .
                "<strong>Creado:</strong> " . $row['created_at'] . "<br>" .
                "<strong>Última Actualización:</strong> " . $row['updated_at'],
            "imagenes" => $imagenes // Añadir el arreglo de imágenes aquí
        ];
    }
} else {
    echo "Falla en conexión";
}
?>

<div class="contenedor">
    <!-- Lista de requerimientos (a la izquierda) -->
    <div class="lista-requerimientos bg-light">
        <ul class="list-group">
            <?php foreach ($requerimientos as $req) : ?>
                <li class="list-group-item requerimiento-item" 
                    data-id="<?php echo $req['id']; ?>"
                    data-detalle="<?php echo htmlspecialchars($req['detalle']); ?>" 
                    data-titulo="<?php echo "{$req['id']} / (Req: {$req['tipo_req']} )"; ?>"
                    data-imagenes='<?php echo json_encode($req['imagenes']); ?>'>
                    <?php echo "{$req['id']} - {$req['nombre']} / (Req. de catálogo)"; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Detalle del requerimiento -->
    <div class="detalle-requerimiento">
    <!-- Imagen y título alineados -->
    <div class="detalle-texto">
        <div class="detalle-imagen">
            <img id="imagenDetalle" src="../Imagenes/ver.jpg" alt="Imagen de requerimiento" style="border-radius: 50px; width: 100px; height: 100px;">
        </div>

        <h6 id="detalleTitulo" class="mt-3">Seleccione un requerimiento</h6>

        <!-- Botones alineados horizontalmente -->
        <div id="botonesAccion" class="botones-accion" style="display: none;">
            <button class="btn btn-danger me-2" id="rechazarBtn">Rechazar</button>
            <button class="btn btn-success" id="aprobarBtn">Aprobar</button>
        </div>

        <hr class="mt-5 mb-3"/>

        <div class="datalle_carrusel">
            <p id="detalleTexto">El contenido aparecerá aquí.</p>

            <!-- Carrusel debajo del contenido -->
            <div id="carrusel" class="carrusel" style="display: none;">
                <h5>Imágenes del vehículo</h5>
                <div class="flechas">
                    <div class="flecha izquierda" id="flechaIzquierda">&#9664;</div>
                    <div class="flecha derecha" id="flechaDerecha">&#9654;</div>
                </div>
                <div class="imagen-grande">
                    <img src="" id="imagenGrande" alt="Imagen seleccionada">
                </div>
                <div class="miniaturas"></div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    document.querySelectorAll('.requerimiento-item').forEach(item => {
        item.addEventListener('click', function () {
            const detalle = this.getAttribute('data-detalle');
            const titulo = this.getAttribute('data-titulo');
            const idRequerimiento = this.getAttribute('data-id');
            const imagenes = JSON.parse(this.getAttribute('data-imagenes'));

            // Mostrar título y detalle
            document.getElementById('detalleTitulo').textContent = titulo;
            document.getElementById('detalleTexto').innerHTML = detalle;

            // Mostrar botones de acción
            document.getElementById('botonesAccion').style.display = 'flex';

            // Mostrar el carrusel solo si hay imágenes
            const carrusel = document.getElementById('carrusel');
            carrusel.style.display = imagenes.length ? 'block' : 'none';

            const imagenGrande = document.getElementById('imagenGrande');
            const miniaturasContainer = document.querySelector('.miniaturas');
            let indiceActual = 0;
            imagenGrande.src = imagenes[indiceActual] || '';

            // Limpiar miniaturas
            miniaturasContainer.innerHTML = '';
            imagenes.forEach((imagen, index) => {
                const img = document.createElement('img');
                img.src = imagen;
                img.alt = `Miniatura ${index + 1}`;
                img.classList.add('miniatura');
                img.dataset.index = index;
                miniaturasContainer.appendChild(img);
            });

            // Mostrar imagen grande
            const mostrarImagen = (indice) => {
                imagenGrande.src = imagenes[indice];
            };

            // Manejar clics en miniaturas
            miniaturasContainer.querySelectorAll('.miniatura').forEach(miniatura => {
                miniatura.addEventListener('click', () => {
                    indiceActual = parseInt(miniatura.getAttribute('data-index'));
                    mostrarImagen(indiceActual);
                });
            });

            // Flechas del carrusel
            document.getElementById('flechaIzquierda').onclick = () => {
                indiceActual = (indiceActual > 0) ? indiceActual - 1 : imagenes.length - 1;
                mostrarImagen(indiceActual);
            };

            document.getElementById('flechaDerecha').onclick = () => {
                indiceActual = (indiceActual < imagenes.length - 1) ? indiceActual + 1 : 0;
                mostrarImagen(indiceActual);
            };
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>