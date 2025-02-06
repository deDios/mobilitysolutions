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
      <a class="navbar-brand" rel="nofollow" target="_blank" href="#"> Edición de catálogo</a>
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
          FROM mobility_solutions.tmx_auto AS auto
          LEFT JOIN mobility_solutions.tmx_sucursal AS sucursal ON auto.sucursal = sucursal.id 
          LEFT JOIN mobility_solutions.tmx_modelo AS modelo ON auto.modelo = modelo.id 
          LEFT JOIN mobility_solutions.tmx_marca AS marca ON auto.marca = marca.id
          LEFT JOIN mobility_solutions.tmx_marca_auto AS m_auto ON auto.nombre = m_auto.id
          WHERE auto.estatus = 2';

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
            "nombre" => $row['nombre'],
            "titulo" => $row['nombre'] . ' (' . $row['modelo'] . ' - ' . $row['marca'] . ')',
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
                    data-titulo="<?php echo "{$req['id']} - {$req['nombre']} / (Req. de catálogo)"; ?>"
                    data-imagenes='<?php echo json_encode($req['imagenes']); ?>'>
                    <?php echo "{$req['id']} - {$req['nombre']} / (Req. de catálogo)"; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Detalle del requerimiento (a la izquierda) -->
    <div class="detalle-requerimiento">
        <div class="detalle-texto">
            <h4 id="detalleTitulo">Seleccione un requerimiento</h4>

            <!-- Botones de acción (aquí abajo del título) -->
            <div id="botonesAccion" class="botones-accion">
                <button class="btn btn-danger me-2" id="rechazarBtn">Rechazar</button>
                <button class="btn btn-success" id="aprobarBtn">Aprobar</button>
            </div>

            <p id="detalleTexto" class="mt-4">El contenido aparecerá aquí.</p>
        </div>
        
        <!-- Carrusel (a la derecha de los detalles) -->
        <div id="carrusel" class="carrusel" style="display:none;">
            <h5>Imágenes del vehículo</h5>
            <div class="flecha izquierda" id="flechaIzquierda">&#9664;</div>
            <div class="imagen-grande">
                <img src="" id="imagenGrande" alt="Imagen seleccionada">
            </div>
            <div class="flecha derecha" id="flechaDerecha">&#9654;</div>

            <div class="miniaturas">
                <!-- Las miniaturas se agregarán dinámicamente con JavaScript -->
            </div>
        </div>
    </div>
</div>


<script>
    // Manejar clics en los elementos de la lista
    document.querySelectorAll('.requerimiento-item').forEach(item => {
        item.addEventListener('click', function () {
            const detalle = this.getAttribute('data-detalle');
            const titulo = this.getAttribute('data-titulo');
            const idRequerimiento = this.getAttribute('data-id');
            const imagenes = JSON.parse(this.getAttribute('data-imagenes'));

            // Actualiza el título y el contenido del detalle
            document.getElementById('detalleTitulo').textContent = titulo;
            document.getElementById('detalleTexto').innerHTML = detalle;

            // Mostrar botones de acción
            document.getElementById('botonesAccion').style.display = 'block';

            // Mostrar el carrusel
            document.getElementById('carrusel').style.display = 'block';

            // Inicializa el carrusel
            let indiceActual = 0;
            const imagenGrande = document.getElementById('imagenGrande');
            const miniaturasContainer = document.querySelector('.miniaturas');
            imagenGrande.src = imagenes[indiceActual];

            // Agregar miniaturas al carrusel
            miniaturasContainer.innerHTML = '';
            imagenes.forEach((imagen, index) => {
                const img = document.createElement('img');
                img.src = imagen;
                img.alt = 'Miniatura ' + (index + 1);
                img.classList.add('miniatura');
                img.dataset.index = index;
                miniaturasContainer.appendChild(img);
            });

            // Función para mostrar la imagen grande
            const mostrarImagen = (indice) => {
                imagenGrande.src = imagenes[indice];
            };

            // Manejar clic en miniaturas
            miniaturasContainer.querySelectorAll('.miniatura').forEach(miniatura => {
                miniatura.addEventListener('click', () => {
                    indiceActual = parseInt(miniatura.getAttribute('data-index'));
                    mostrarImagen(indiceActual);
                });
            });

            // Manejar clic en las flechas
            document.getElementById('flechaIzquierda').addEventListener('click', () => {
                indiceActual = (indiceActual > 0) ? indiceActual - 1 : imagenes.length - 1;
                mostrarImagen(indiceActual);
            });

            document.getElementById('flechaDerecha').addEventListener('click', () => {
                indiceActual = (indiceActual < imagenes.length - 1) ? indiceActual + 1 : 0;
                mostrarImagen(indiceActual);
            });

            // Manejar clic en el botón "Aprobar"
            document.getElementById('aprobarBtn').addEventListener('click', function () {
                // Enviar solicitud AJAX para actualizar el estatus
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '../db_consultas/actualizar_estatus.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert(response.message); // Mostrar éxito
                        } else {
                            alert(response.message); // Mostrar error
                        }
                    }
                };
                xhr.send('id=' + idRequerimiento);
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>