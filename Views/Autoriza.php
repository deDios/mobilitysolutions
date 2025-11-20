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
            $user_id      = $row['user_id'];
            $user_name    = $row['user_name'];
            $user_password= $row['user_password'];
            $user_type    = $row['user_type'];
            $r_ejecutivo  = $row['r_ejecutivo'];
            $r_editor     = $row['r_editor'];
            $r_autorizador= $row['r_autorizador'];
            $r_analista   = $row['r_analista'];
            $nombre       = $row['nombre'];
            $s_nombre     = $row['s_nombre'];
            $last_name    = $row['last_name'];
            $email        = $row['email'];
            $cumpleaños   = $row['cumpleaños'];
            $telefono     = $row['telefono'];
        }
    }
    else{
        echo 'Falla en conexión.'; 
    }

    // Validar si el usuario es un Asesor(a)
    if ($user_type == 1) {
        echo ' 
        <script>
            alert("No tiene acceso para entrar al apartado de aprobaciones, favor de solicitarlo al departamento de sistemas");
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
    <link rel="stylesheet" href="../CSS/autoriza_uat.css">

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
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/requerimientos.php">Requerimientos</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/tareas.php">Tareas</a>
          </li>

          <li class="nav-item active">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/Autoriza.php">Aprobaciones</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/asignacion.php">Asignaciones</a> 
          </li>

        </ul>
      </div>
    </div>
  </nav>
</div>

<?php
// ================== CARGA DE REQUERIMIENTOS ==================
$inc = include "../db/Conexion.php";

if ($user_type == 5 || $user_type == 6) {
    // CTO y CEO ven todos
    $query = "
    SELECT 
        auto.id,
        auto.id_auto,
        auto.tipo_req,
        auto.comentarios,
        DATE_SUB(auto.req_created_at, INTERVAL 6 HOUR) as req_created_at, 
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
        auto.updated_at,
        creador.user_name AS creador_nombre,
        creador.last_name AS creador_last_name
    FROM mobility_solutions.tmx_requerimiento AS auto
    LEFT JOIN mobility_solutions.tmx_sucursal AS sucursal ON auto.sucursal = sucursal.id 
    LEFT JOIN mobility_solutions.tmx_modelo AS modelo ON auto.modelo = modelo.id 
    LEFT JOIN mobility_solutions.tmx_marca AS marca ON auto.marca = marca.id
    LEFT JOIN mobility_solutions.tmx_marca_auto AS m_auto ON auto.nombre = m_auto.id
    LEFT JOIN mobility_solutions.tmx_usuario AS creador ON auto.created_by = creador.id
    WHERE auto.status_req = 1;";
} else {
    $query = "
        WITH RECURSIVE jerarquia AS (
            SELECT user_id
            FROM mobility_solutions.tmx_acceso_usuario
            WHERE reporta_a = $user_id

            UNION ALL

            SELECT h.user_id
            FROM mobility_solutions.tmx_acceso_usuario h
            INNER JOIN jerarquia j ON h.reporta_a = j.user_id
        )

    SELECT 
        auto.id,
        auto.id_auto,
        auto.tipo_req,
        auto.comentarios,
        DATE_SUB(auto.req_created_at, INTERVAL 6 HOUR) as req_created_at, 
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
        auto.updated_at,
        creador.user_name AS creador_nombre,
        creador.last_name AS creador_last_name
    FROM mobility_solutions.tmx_requerimiento AS auto
    LEFT JOIN mobility_solutions.tmx_sucursal AS sucursal ON auto.sucursal = sucursal.id 
    LEFT JOIN mobility_solutions.tmx_modelo AS modelo ON auto.modelo = modelo.id 
    LEFT JOIN mobility_solutions.tmx_marca AS marca ON auto.marca = marca.id
    LEFT JOIN mobility_solutions.tmx_marca_auto AS m_auto ON auto.nombre = m_auto.id
    LEFT JOIN mobility_solutions.tmx_usuario AS creador ON auto.created_by = creador.id
    WHERE auto.status_req = 1
      AND auto.created_by IN (SELECT user_id FROM jerarquia);";
}

$result = mysqli_query($con, $query);
$requerimientos = [];

if ($result) {
    $tz = new DateTimeZone('America/Mexico_City');
    $hoy = new DateTime('now', $tz);

    while ($row = mysqli_fetch_assoc($result)) {

        // Imágenes del auto
        $imagenes = [
            '../Imagenes/Catalogo/Auto '.$row['id_auto'].'/Img01.jpg',
            '../Imagenes/Catalogo/Auto '.$row['id_auto'].'/Img02.jpg',
            '../Imagenes/Catalogo/Auto '.$row['id_auto'].'/Img03.jpg',
            '../Imagenes/Catalogo/Auto '.$row['id_auto'].'/Img04.jpg',
            '../Imagenes/Catalogo/Auto '.$row['id_auto'].'/Img05.jpg',
            '../Imagenes/Catalogo/Auto '.$row['id_auto'].'/Img06.jpg',
            '../Imagenes/Catalogo/Auto '.$row['id_auto'].'/Img07.jpg',
            '../Imagenes/Catalogo/Auto '.$row['id_auto'].'/Img08.jpg',
        ];

        // Nombre de quien levanta el requerimiento
        $creadorNombre = trim(
            ($row['creador_nombre'] ?? '') . ' ' . ($row['creador_last_name'] ?? '')
        );
        if ($creadorNombre === '') {
            $creadorNombre = 'Usuario ' . $row['created_by'];
        }

        // Días transcurridos desde que se creó el requerimiento
        $dias = 0;
        $dias_label = 'Sin fecha';
        if (!empty($row['req_created_at'])) {
            $creado = new DateTime($row['req_created_at'], $tz);
            $diff = $hoy->diff($creado);
            $dias = (int)$diff->days;

            if ($dias === 0) {
                $dias_label = 'Hoy';
            } elseif ($dias === 1) {
                $dias_label = 'Hace 1 día';
            } else {
                $dias_label = 'Hace ' . $dias . ' días';
            }
        }

        $requerimientos[] = [
            "id"             => $row['id'],
            "id_auto"        => $row['id_auto'],
            "tipo_req"       => $row['tipo_req'],
            "comentarios"    => $row['comentarios'],
            "req_created_at" => $row['req_created_at'],
            "c_type"         => $row['c_type'],
            "created_by"     => $row['created_by'],
            "creador_nombre" => $creadorNombre,
            "nombre"         => $row['nombre'],
            "modelo"         => $row['modelo'],
            "marca"          => $row['marca'],
            "mensualidad"    => $row['mensualidad'],
            "costo"          => $row['costo'],
            "sucursal"       => $row['sucursal'],
            "color"          => $row['color'],
            "transmision"    => $row['transmision'],
            "interior"       => $row['interior'],
            "kilometraje"    => $row['kilometraje'],
            "combustible"    => $row['combustible'],
            "cilindros"      => $row['cilindros'],
            "eje"            => $row['eje'],
            "pasajeros"      => $row['pasajeros'],
            "propietarios"   => $row['propietarios'],
            "created_at"     => $row['created_at'],
            "updated_at"     => $row['updated_at'],
            "dias"           => $dias,
            "dias_label"     => $dias_label,
            "titulo"         => $row['id'] . ' (' . $row['tipo_req'] . ')',
            "detalle" => 
                "<strong>ID auto:</strong> " . $row['id_auto'] . "<br>" .
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
            "imagenes" => $imagenes
        ];
    }
} else {
    echo "Falla en conexión";
}

// para filtros por tipo
$tiposUnicos = [];
foreach ($requerimientos as $r) {
    if (!empty($r['tipo_req']) && !in_array($r['tipo_req'], $tiposUnicos, true)) {
        $tiposUnicos[] = $r['tipo_req'];
    }
}
$totalRequerimientos = count($requerimientos);

// helper PHP para clase de badge por tipo
function tipoReqBadgeClass($tipo) {
    $t = mb_strtolower(trim($tipo), 'UTF-8');
    if ($t === 'nuevo en catálogo' || $t === 'nuevo en catalogo') {
        return 'badge-tipo-nuevo';
    }
    if ($t === 'reserva de vehículo' || $t === 'reserva de vehiculo') {
        return 'badge-tipo-reserva';
    }
    if ($t === 'entrega de vehículo' || $t === 'entrega de vehiculo') {
        return 'badge-tipo-entrega';
    }
    return 'badge-tipo-otro';
}
?>

<!-- ================== LAYOUT CON CABECERA + LISTA + DETALLE ================== -->

<div class="container ms-settings-wrap">

  <!-- Cabecera compacta con usuario (igual estilo que catálogo) -->
  <div class="ms-head card shadow-sm mb-3">
    <div class="card-body d-flex align-items-center gap-3 flex-wrap">
      <div class="ms-avatar">
        <?php
          $iniNombre = trim(($nombre ?? 'Usuario') . ' ' . ($last_name ?? 'Demo'));
          $parts = preg_split('/\s+/', $iniNombre);
          $iniciales = mb_substr($parts[0] ?? 'U', 0, 1) . mb_substr($parts[1] ?? '', 0, 1);
          echo htmlspecialchars(strtoupper($iniciales));
        ?>
      </div>
      <div class="flex-grow-1">
        <div class="h5 mb-0">
          <?= htmlspecialchars(($nombre ?? 'Usuario') . ' ' . ($last_name ?? 'Demo')) ?>
        </div>
        <small class="text-muted">
          <?= htmlspecialchars($user_name ?? 'usuario') ?> · <?= htmlspecialchars($user_type ?? 'Rol') ?>
        </small>
      </div>
      <a class="btn btn-outline-dark btn-sm" href="https://mobilitysolutionscorp.com/db_consultas/cerrar_sesion.php">
        <i class="fa fa-sign-out me-1"></i>Salir
      </a>
    </div>
  </div>

  <div class="row g-3">

    <!-- ======= LISTA IZQUIERDA ======= -->
    <aside class="col-12 col-lg-4">
      <div class="card ms-card shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between">
          <span class="fw-semibold">
            <i class="fa fa-inbox me-2"></i>Aprobaciones pendientes
          </span>
          <span class="badge bg-dark text-white"><?= $totalRequerimientos ?></span>
        </div>
        <div class="card-body">
          <!-- filtros por tipo de requerimiento -->
          <div class="mb-2 d-flex flex-wrap req-filters">
            <button type="button" class="btn btn-outline-secondary btn-sm req-filter-btn active" data-tipo="todos">
              Todos
            </button>
            <?php foreach ($tiposUnicos as $tipo): ?>
              <button type="button"
                      class="btn btn-outline-secondary btn-sm req-filter-btn"
                      data-tipo="<?= htmlspecialchars($tipo) ?>">
                <?= htmlspecialchars($tipo) ?>
              </button>
            <?php endforeach; ?>
          </div>

          <div class="lista-requerimientos bg-light rounded-3">
            <ul class="list-group list-group-flush p-2">
              <?php if (!$requerimientos): ?>
                <li class="list-group-item small text-muted">No hay requerimientos pendientes.</li>
              <?php else: ?>
                <?php foreach ($requerimientos as $req) : ?>
                  <li class="list-group-item requerimiento-item"
                      data-id="<?php echo $req['id']; ?>"
                      data-id_auto="<?php echo $req['id_auto']; ?>"
                      data-detalle="<?php echo htmlspecialchars($req['detalle']); ?>" 
                      data-titulo="<?php echo "{$req['id']} / (Req: {$req['tipo_req']} )"; ?>"
                      data-imagenes='<?php echo json_encode($req['imagenes']); ?>'
                      data-img-user="<?php echo $req['created_by']; ?>"
                      data-tipo="<?php echo htmlspecialchars($req['tipo_req']); ?>"
                      data-creador="<?php echo htmlspecialchars($req['creador_nombre']); ?>"
                  >
                    <div class="d-flex justify-content-between align-items-start">
                      <div>
                        <div class="fw-semibold mb-1">
                          #<?php echo $req['id']; ?> · <?php echo htmlspecialchars($req['nombre']); ?>
                        </div>
                        <div class="small text-muted mb-1">
                          Creado: <?php echo htmlspecialchars($req['req_created_at']); ?>
                        </div>
                        <div class="small text-muted mb-1">
                          Por: <?php echo htmlspecialchars($req['creador_nombre']); ?>
                        </div>
                        <div class="small">
                          <span class="badge rounded-pill <?php echo tipoReqBadgeClass($req['tipo_req']); ?>">
                            <?php echo htmlspecialchars($req['tipo_req']); ?>
                          </span>
                          <span class="badge rounded-pill ms-badge-age">
                            <?php echo htmlspecialchars($req['dias_label']); ?>
                          </span>
                        </div>
                      </div>
                      <div class="text-end">
                        <span class="badge bg-light text-muted">ID <?php echo $req['id_auto']; ?></span>
                      </div>
                    </div>
                  </li>
                <?php endforeach; ?>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </aside>

    <!-- ======= DETALLE DERECHA ======= -->
    <section class="col-12 col-lg-8">
      <div class="card ms-card shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between">
          <span class="fw-semibold">
            <i class="fa fa-file-text-o me-2"></i>Detalle de requerimiento
          </span>
        </div>
        <div class="card-body">
          <div class="detalle-requerimiento">
            <div class="detalle-texto">

              <!-- Foto + título + nombre de quien levanta -->
              <div class="img_detalle">
                <div class="detalle-imagen text-center">
                  <img id="imagenDetalle" src="../Imagenes/Usuarios/ver.jpg" alt="Imagen de requerimiento"
                       style="border-radius: 50px; width: 100px; height: 100px;">
                  <div id="detalleAutor" class="small text-muted mt-2"></div>
                </div>
                <div class="ms-detalle-head">
                  <h6 id="detalleTitulo" class="mb-1">Seleccione un requerimiento</h6>
                </div>
              </div>

              <!-- Botones Aprobar / Rechazar -->
              <div id="botonesAccion" class="botones-accion" style="display: none;">
                <button class="btn btn-danger me-2" id="rechazarBtn">Rechazar</button>
                <button class="btn btn-success" id="aprobarBtn">Aprobar</button>
              </div>

              <hr class="mt-3 mb-3"/>

              <!-- Detalle y carrusel -->
              <div class="datalle_carrusel">
                <p id="detalleTexto">El contenido aparecerá aquí.</p>

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
      </div>
    </section>

  </div>
</div>

<!-- ================== JS ================== -->

<script>
// ========= Filtro por tipo de requerimiento (botones superiores) =========
(function(){
    const filterButtons = document.querySelectorAll('.req-filter-btn');
    const items = document.querySelectorAll('.requerimiento-item');

    if (!filterButtons.length || !items.length) return;

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function(){
            const tipo = this.getAttribute('data-tipo');
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            items.forEach(li => {
                const liTipo = li.getAttribute('data-tipo');
                if (!tipo || tipo === 'todos' || liTipo === tipo) {
                    li.style.display = '';
                } else {
                    li.style.display = 'none';
                }
            });
        });
    });
})();
</script>

<script>
// ========= Click en cada requerimiento de la lista =========
document.querySelectorAll('.requerimiento-item').forEach(item => {
    item.addEventListener('click', function () {
        const detalle   = this.getAttribute('data-detalle');
        const titulo    = this.getAttribute('data-titulo');
        const imgUser   = this.getAttribute('data-img-user'); 
        const imagenes  = JSON.parse(this.getAttribute('data-imagenes') || '[]');
        const creador   = this.getAttribute('data-creador') || '';

        // Actualizar título y detalle
        document.getElementById('detalleTitulo').textContent = titulo;
        document.getElementById('detalleTexto').innerHTML = detalle;

        // Actualizar la imagen del usuario
        document.getElementById('imagenDetalle').src = `../Imagenes/Usuarios/${imgUser}.jpg`;

        // Nombre de quien levanta el req
        const autorLabel = document.getElementById('detalleAutor');
        if (autorLabel) {
            autorLabel.textContent = creador ? `${creador}` : '';
        }

        // Marcar el requerimiento como seleccionado
        document.querySelectorAll('.requerimiento-item').forEach(i => i.classList.remove('active'));
        this.classList.add('active');

        // Mostrar botones de acción
        document.getElementById('botonesAccion').style.display = 'flex';

        // Mostrar el carrusel si hay imágenes
        const carrusel = document.getElementById('carrusel');
        const imagenGrande = document.getElementById('imagenGrande');
        const miniaturasContainer = document.querySelector('.miniaturas');

        if (imagenes.length) {
            carrusel.style.display = 'block';
        } else {
            carrusel.style.display = 'none';
        }

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

        // Función para mostrar imagen grande
        const mostrarImagen = (indice) => {
            imagenGrande.src = imagenes[indice] || '';
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
            if (!imagenes.length) return;
            indiceActual = (indiceActual > 0) ? indiceActual - 1 : imagenes.length - 1;
            mostrarImagen(indiceActual);
        };

        document.getElementById('flechaDerecha').onclick = () => {
            if (!imagenes.length) return;
            indiceActual = (indiceActual < imagenes.length - 1) ? indiceActual + 1 : 0;
            mostrarImagen(indiceActual);
        };
    });
});

// ========= Botón "Aprobar" =========
document.getElementById('aprobarBtn').addEventListener('click', function () {
    const seleccionado = document.querySelector('.requerimiento-item.active');

    if (!seleccionado) {
        alert("Por favor, seleccione un requerimiento antes de aprobar.");
        return;
    }

    const idRequerimiento = seleccionado.getAttribute('data-id');
    const idAuto = seleccionado.getAttribute('data-id_auto');
    const tipoReq = seleccionado.getAttribute('data-titulo').split("(Req: ")[1].split(" )")[0]; // Extraer el tipo_req

    // Determinar la API según el tipo de requerimiento
    let apiUrl = '';
    if (tipoReq === "Nuevo en catálogo") {
        apiUrl = '../db_consultas/actualizar_estatus.php';
    } else if (tipoReq === "Reserva de vehículo") {
        apiUrl = '../db_consultas/actualizar_reserva.php';
    } else if (tipoReq === "Entrega de vehículo") {
        apiUrl = '../db_consultas/actualizar_venta.php';
    } else {
        alert("Error: Tipo de requerimiento desconocido.");
        return;
    }

    fetch(apiUrl, { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${idRequerimiento}&id_auto=${idAuto}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            seleccionado.classList.add('aprobado'); 
            window.location.href = "https://mobilitysolutionscorp.com/Views/Autoriza.php";
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error en la solicitud:", error));
});

// ========= Botón "Rechazar" =========
document.getElementById('rechazarBtn').addEventListener('click', function () {
    const seleccionado = document.querySelector('.requerimiento-item.active');

    if (!seleccionado) {
        alert("Por favor, seleccione un requerimiento antes de rechazar.");
        return;
    }

    const idRequerimiento = seleccionado.getAttribute('data-id');
    const idAuto = seleccionado.getAttribute('data-id_auto');
    const tipoReq = seleccionado.getAttribute('data-titulo').split("(Req: ")[1].split(" )")[0];

    const rechazoComentario = prompt("Ingrese la razón del rechazo:");

    if (rechazoComentario === null || rechazoComentario.trim() === "") {
        alert("Debe ingresar una razón para el rechazo.");
        return;
    }

    let apiUrl = '';
    if (tipoReq === "Nuevo en catálogo") {
        apiUrl = '../db_consultas/rechazar_reserva.php';
    } else if (tipoReq === "Reserva de vehículo") {
        apiUrl = '../db_consultas/rechazar_reserva.php';
    } else if (tipoReq === "Entrega de vehículo") {
        apiUrl = '../db_consultas/rechazar_reserva.php';
    } else {
        alert("Error: Tipo de requerimiento desconocido.");
        return;
    }

    fetch(apiUrl, { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${idRequerimiento}&id_auto=${idAuto}&rechazo_coment=${encodeURIComponent(rechazoComentario)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            seleccionado.classList.add('rechazado'); 
            window.location.href = "https://mobilitysolutionscorp.com/Views/Autoriza.php";
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error en la solicitud:", error));
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>
