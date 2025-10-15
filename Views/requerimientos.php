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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requerimientos</title>
    <link rel="shortcut icon" href="../Imagenes/movility.ico" />
    <link rel="stylesheet" href="../CSS/reque_uat.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
              
              <!-- Ajustado a Bootstrap 5: data-bs-toggle -->
              <li><a class="waves-effect waves-dark" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="fa fa-map-marker"></i></a></li>       

              <li><a class="waves-effect waves-dark" href="https://mobilitysolutionscorp.com/db_consultas/cerrar_sesion.php"><i class="fa fa-sign-out"></i></a></li>
            </ul>
          </div>

        </div>
      </div>
  </header>

  <nav class="navbar navbar-expand-lg navbar-dark mx-background-top-linear">
    <div class="container">
      <a class="navbar-brand" rel="nofollow" target="_blank" href="https://mobilitysolutionscorp.com/"> Mobility Solutions: Requerimientos </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">

        <ul class="navbar-nav ms-auto">

            <?php
                $self = basename($_SERVER['PHP_SELF']); // p.ej. "requerimientos.php"
            ?>
            <li class="nav-item">
            <a class="nav-link <?= $self==='Home.php' ? 'active' : '' ?>" href="https://mobilitysolutionscorp.com/Views/Home.php">Inicio</a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?= $self==='edicion_catalogo.php' ? '' : '' ?>" href="https://mobilitysolutionscorp.com/Views/edicion_catalogo.php">Catálogo</a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?= $self==='requerimientos.php' ? 'active' : '' ?>" aria-current="<?= $self==='requerimientos.php' ? 'page' : '' ?>" href="https://mobilitysolutionscorp.com/Views/requerimientos.php">Requerimientos</a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?= $self==='tareas.php' ? 'active' : '' ?>" href="https://mobilitysolutionscorp.com/Views/tareas.php">Tareas</a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?= $self==='Autoriza.php' ? 'active' : '' ?>" href="https://mobilitysolutionscorp.com/Views/Autoriza.php">Aprobaciones</a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?= $self==='asignacion.php' ? 'active' : '' ?>" href="https://mobilitysolutionscorp.com/Views/asignacion.php">Asignaciones</a>
            </li>


        </ul>
      </div>
    </div>
  </nav>
</div>

<?php
// ===== Arranque en Req 3 como default (cámbialo a '1' si quieres iniciar en Reservar) =====
$selected = isset($_GET['req']) ? $_GET['req'] : '3';

$inc = include "../db/Conexion.php"; 
$vehiculo = null;
$mensaje  = $mensaje ?? '';

if (isset($_POST['verificar'])) {
    $cod = $_POST['id_vehiculo'];

    $query = "SELECT 
                auto.id, 
                m_auto.auto AS nombre, 
                modelo.nombre AS modelo, 
                marca.nombre AS marca, 
                auto.mensualidad, 
                auto.costo, 
                sucursal.nombre AS sucursal, 
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
            FROM mobility_solutions.tmx_auto AS auto 
            LEFT JOIN mobility_solutions.tmx_sucursal AS sucursal 
                ON auto.sucursal = sucursal.id 
            LEFT JOIN mobility_solutions.tmx_estatus AS estatus 
                ON auto.estatus = estatus.id 
            LEFT JOIN mobility_solutions.tmx_modelo AS modelo 
                ON auto.modelo = modelo.id 
            LEFT JOIN mobility_solutions.tmx_marca AS marca 
                ON auto.marca = marca.id 
            LEFT JOIN mobility_solutions.tmx_marca_auto AS m_auto 
                ON auto.nombre = m_auto.id 
            WHERE auto.estatus = 1
              AND auto.id = '".mysqli_real_escape_string($con, $cod)."'";

    $resultV = mysqli_query($con,$query);
    if ($resultV && $resultV->num_rows > 0) {
        $vehiculo  = $resultV->fetch_assoc();
        $disabled  = "";
    } else {
        $mensaje = "ID no encontrado";
    }
}
?>

<!-- ===== NUEVO LAYOUT · AJUSTES ===== -->
<div class="container ms-settings-wrap">

  <!-- Encabezado compacto con usuario -->
  <div class="ms-head card shadow-sm mb-3">
    <div class="card-body d-flex align-items-center gap-3 flex-wrap">
      <div class="ms-avatar">
        <?php
          $ini = trim(($nombre ?? 'Usuario').' '.($last_name ?? 'Demo'));
          $parts = preg_split('/\s+/', $ini);
          $iniciales = mb_substr($parts[0] ?? 'U',0,1).mb_substr($parts[1] ?? '',0,1);
          echo htmlspecialchars(strtoupper($iniciales));
        ?>
      </div>
      <div class="flex-grow-1">
        <div class="h5 mb-0"><?= htmlspecialchars(($nombre ?? 'Usuario').' '.($last_name ?? 'Demo')) ?></div>
        <small class="text-muted"><?= htmlspecialchars($user_name ?? 'usuario') ?> · <?= htmlspecialchars($user_type ?? 'Rol') ?></small>
      </div>
      <a class="btn btn-outline-dark btn-sm" href="https://mobilitysolutionscorp.com/db_consultas/cerrar_sesion.php">
        <i class="fa fa-sign-out me-1"></i>Salir
      </a>
    </div>
  </div>

  <div class="row g-3">
    <!-- Sidebar -->
    <aside class="col-12 col-lg-3">
      <nav class="list-group ms-side sticky-lg-top">
        <a href="?req=3" class="list-group-item list-group-item-action <?= ($selected=='3'?'active':'') ?>">
          <i class="fa fa-list-alt me-2"></i> Mis requerimientos
        </a>
        <a href="?req=1" class="list-group-item list-group-item-action <?= ($selected=='1'?'active':'') ?>">
          <i class="fa fa-bookmark-o me-2"></i> Reservar
        </a>
        <a href="?req=2" class="list-group-item list-group-item-action <?= ($selected=='2'?'active':'') ?>">
          <i class="fa fa-truck me-2"></i> Entrega de vehículo
        </a>
        <div class="list-group-item disabled d-flex align-items-center" title="Próximamente">
          <i class="fa fa-search me-2"></i> Req 4
        </div>
      </nav>
    </aside>

    <!-- Contenido -->
    <section class="col-12 col-lg-9">
      <?php if ($selected == '1'): ?>
        <!-- ============ RESERVAR ============ -->
        <div class="card ms-card shadow-sm">
          <div class="card-header d-flex align-items-center justify-content-between">
            <span class="fw-semibold"><i class="fa fa-bookmark-o me-2"></i> Reserva de vehículo</span>
          </div>
          <div class="card-body">
            <form method="POST">
              <div class="row g-2 align-items-end">
                <div class="col-sm-8">
                  <label class="form-label small">ID del vehículo</label>
                  <input type="text" class="form-control" name="id_vehiculo" placeholder="Ej. 1234">
                </div>
                <div class="col-sm-4">
                  <button type="submit" name="verificar" class="btn btn-brand w-100">
                    <i class="fa fa-search me-1"></i> Consultar
                  </button>
                </div>
              </div>

              <p class="error-msg mt-2 mb-0"><?= htmlspecialchars($mensaje) ?></p>

              <?php if (!empty($vehiculo['marca'])): ?>
              <div class="ms-vehiculo card shadow-sm mt-3">
                <div class="card-body d-flex gap-3 flex-wrap">
                  <img class="ms-veh-img" src="../Imagenes/Catalogo/Auto <?= (int)$vehiculo['id'];?>/Img01.jpg" alt="Vehículo"
                       onerror="this.src='https://via.placeholder.com/320x200?text=Auto';">
                  <div class="flex-grow-1">
                    <div class="h6 mb-1"><?= htmlspecialchars($vehiculo['nombre']) ?> · <?= htmlspecialchars($vehiculo['modelo']) ?></div>
                    <div class="small text-muted mb-2"><?= htmlspecialchars($vehiculo['marca']) ?> — <?= htmlspecialchars($vehiculo['sucursal']) ?></div>
                    <div class="row g-2 small">
                      <div class="col-sm-6"><strong>Costo:</strong> $<?= number_format((float)$vehiculo['costo']) ?></div>
                      <div class="col-sm-6"><strong>Mensualidad:</strong> $<?= number_format((float)$vehiculo['mensualidad']) ?></div>
                      <div class="col-sm-6"><strong>Color:</strong> <?= htmlspecialchars($vehiculo['color']) ?></div>
                      <div class="col-sm-6"><strong>Transmisión:</strong> <?= htmlspecialchars($vehiculo['transmision']) ?></div>
                      <div class="col-sm-6"><strong>Kilometraje:</strong> <?= number_format((float)$vehiculo['kilometraje']) ?> km</div>
                      <div class="col-sm-6"><strong>Combustible:</strong> <?= htmlspecialchars($vehiculo['combustible']) ?></div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="text-end mt-3">
                <button class="btn btn-success" type="button" id="boton_reserva" 
                  data-marca="<?= isset($vehiculo['marca']) ? htmlspecialchars($vehiculo['marca']) : '' ?>"
                  data-vehiculo='<?= json_encode($vehiculo) ?>'
                  data-usuario='<?= json_encode($user_id) ?>'
                  <?= isset($vehiculo['marca']) ? '' : 'disabled'; ?>>
                  <i class="fa fa-send-o me-1"></i> Solicitar reserva
                </button>
              </div>
              <?php endif; ?>
            </form>
          </div>
        </div>

      <?php elseif ($selected == '2'): ?>
        <!-- ============ ENTREGA DE VEHÍCULO (antes Venta) ============ -->
        <div class="card ms-card shadow-sm">
          <div class="card-header d-flex align-items-center justify-content-between">
            <span class="fw-semibold"><i class="fa fa-truck me-2"></i> Autos reservados — Entrega</span>
            <button type="button" class="btn btn-outline-dark btn-sm" onclick="cargarAutos()">
              <i class="fa fa-refresh me-1"></i> Actualizar
            </button>
          </div>
          <div class="card-body">
            <div class="d-flex flex-wrap gap-2 justify-content-between mb-2">
              <div class="input-group input-group-sm ms-w-280">
                <span class="input-group-text bg-white"><i class="fa fa-search"></i></span>
                <input id="filtroAutos" type="text" class="form-control" placeholder="Filtrar por marca/modelo/sucursal...">
              </div>
              <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-secondary" onclick="cargarAutos()">
                  <i class="fa fa-refresh me-1"></i> Actualizar
                </button>
              </div>
            </div>
            <div id="listaAutos" class="ms-lista-autos"></div>
          </div>
        </div>

      <?php elseif ($selected == '3'): ?>
        <!-- ============ REQ 3: MIS REQUERIMIENTOS ============ -->
        <div class="card ms-card shadow-sm">
          <div class="card-header d-flex align-items-center justify-content-between">
            <span class="fw-semibold"><i class="fa fa-list-alt me-2"></i> Mis requerimientos</span>
            <button type="button" class="btn btn-outline-dark btn-sm" onclick="cargarReq3()">
              <i class="fa fa-refresh me-1"></i> Actualizar
            </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="tablaReq3" class="table table-hover align-middle" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Auto</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Comentario</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tbody><!-- llenado por JS --></tbody>
              </table>
            </div>
          </div>
        </div>

      <?php else: ?>
        <!-- Puedes extender Req 4 aquí cuando esté listo -->
        <div class="card ms-card shadow-sm">
          <div class="card-body">
            <div class="text-muted">Sección en construcción.</div>
          </div>
        </div>
      <?php endif; ?>
    </section>
  </div>
</div>
<!-- ===== /NUEVO LAYOUT · AJUSTES ===== -->

<script>
  // Parámetros para la API de reservados
  const USER_ID = <?= (int)($user_id ?? 0) ?>;   // viene de PHP
  const ESTATUS_RESERVADO = 3;                   // tu estatus para “reservado”

  // Helper para armar la URL (evita caché con _=timestamp)
  function urlReservados(userId = USER_ID, estatus = ESTATUS_RESERVADO){
    const ts = Date.now();
    return `https://mobilitysolutionscorp.com/db_consultas/api_reservados.php?user_id=${encodeURIComponent(userId)}&estatus=${encodeURIComponent(estatus)}&_=${ts}`;
  }
</script>


<!-- ========== JS ========== -->
<script>
  // Helpers de UI para badges
  function msStatusBadgeCls(s){
    if(!s) return 'bg-warning-subtle text-dark';
    s = (s+'').toLowerCase();
    if(s.includes('aprob')) return 'bg-success-subtle text-success';
    if(s.includes('declin') || s.includes('rechaz')) return 'bg-danger-subtle text-danger';
    return 'bg-warning-subtle text-dark';
  }

  // Render de tabla bonita con miniatura + filtro (ENTREGA)
  function renderTablaReservas(autos){
    const wrap = document.getElementById('listaAutos');
    const q = (document.getElementById('filtroAutos')?.value || '').trim().toLowerCase();

    const filtrados = autos.filter(a=>{
      if(!q) return true;
      const texto = [
        a.id, a.marca, a.modelo, a.nombre, a.sucursal, a.status_req
      ].filter(Boolean).join(' ').toLowerCase();
      return texto.includes(q);
    });

    if(!filtrados.length){
      wrap.innerHTML = '<div class="alert alert-warning mb-0">No hay vehículos en reserva con ese filtro.</div>';
      return;
    }

    const rows = filtrados.map(a => `
      <tr>
        <td class="text-muted">${a.id}</td>
        <td>
          <div class="d-flex align-items-center gap-2">
            <img class="ms-thumb" src="../Imagenes/Catalogo/Auto ${a.id}/Img01.jpg"
                 onerror="this.src='https://via.placeholder.com/96x64?text=Auto';" alt="">
            <div>
              <div class="fw-semibold">${(a.marca ?? '')} ${(a.modelo ?? '')}</div>
              <small class="text-muted">${a.nombre ?? ''}</small>
            </div>
          </div>
        </td>
        <td>${a.sucursal ?? '-'}</td>
        <td><span class="badge rounded-pill ${msStatusBadgeCls(a.status_req)}">${a.status_req ?? 'pendiente'}</span></td>
        <td class="text-end">
          <button class="btn btn-sm btn-success" data-id_auto="${a.id}">
            <i class="fa fa-check me-1"></i> Confirmar entrega
          </button>
        </td>
      </tr>
    `).join('');

    wrap.innerHTML = `
      <div class="table-responsive ms-table-wrap">
        <table class="table table-hover align-middle ms-table">
          <thead>
            <tr>
              <th style="width:80px">ID</th>
              <th>Vehículo</th>
              <th style="min-width:140px">Sucursal</th>
              <th style="min-width:120px">Estado</th>
              <th class="text-end" style="width:180px">Acciones</th>
            </tr>
          </thead>
          <tbody>${rows}</tbody>
        </table>
      </div>
    `;

    // Eventos de Confirmar entrega
    wrap.querySelectorAll('button[data-id_auto]').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const id_auto = btn.getAttribute('data-id_auto');
        const id_usuario = <?= (int)($user_id ?? 0) ?>;
        confirmarEntrega(id_auto, id_usuario);
      });
    });
  }

  // Carga de autos (API) + conexión con tabla (ENTREGA)
  function cargarAutos() {
    const wrap = document.getElementById('listaAutos');
    if (!wrap) return;
    wrap.innerHTML = '<div class="text-center text-muted py-3">Cargando...</div>';

    const xhr = new XMLHttpRequest();
    xhr.open("GET", urlReservados(), true);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          try {
            const autos = JSON.parse(xhr.responseText) || [];
            renderTablaReservas(autos);

            // filtrar en vivo
            const filtro = document.getElementById('filtroAutos');
            if (filtro && !filtro.__wired) {
              filtro.__wired = true;
              filtro.addEventListener('input', ()=> renderTablaReservas(autos));
            }
          } catch (e) {
            console.error("Error JSON:", e);
            wrap.innerHTML = '<div class="alert alert-danger mb-0">Error al procesar la respuesta.</div>';
          }
        } else {
          wrap.innerHTML = '<div class="alert alert-danger mb-0">Error al cargar la información.</div>';
        }
      }
    };

    xhr.onerror = function(){
      wrap.innerHTML = '<div class="alert alert-danger mb-0">Error en la solicitud.</div>';
    };

    xhr.send();
  }

  // Confirmar entrega (flujo de venta)
  function confirmarEntrega(id_auto, id_usuario) {
    const confirmar = confirm(`¿Estás seguro de hacer el requerimiento de venta para el Auto ${id_auto} Usuario ${id_usuario}?`);

    if (confirmar) {
      cambiarEstado(id_auto, id_usuario);
    }
  }

  function cambiarEstado(id_auto, id_usuario) {
    const data = JSON.stringify({
      vehiculo: { id: parseInt(id_auto) },
      usuario: { id: parseInt(id_usuario) }
    });

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "https://mobilitysolutionscorp.com/db_consultas/insert_sp_req_venta.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        try {
          const resultado = JSON.parse(xhr.responseText);
          if (resultado.success) {
            alert("Venta registrada con éxito.");
            cargarAutos(); // Recargar la lista
          } else {
            alert("Error al registrar la venta: " + (resultado.message || "Error desconocido"));
          }
        } catch (error) {
          console.error("❌ Error al parsear JSON de la respuesta:", error);
          alert("Error en la respuesta del servidor.");
        }
      }
    };

    xhr.onerror = function () {
      console.error("❌ Error en la solicitud XMLHttpRequest.");
      alert("Error en la solicitud.");
    };

    xhr.send(data);
  }
</script>

<script>
    // ====== REQUERIMIENTOS (lista izquierda que ya tenías) ======
    let todosLosRequerimientos = []; // Almacenará todos los requerimientos
    let userId = <?= (int)($user_id ?? 0) ?>;

    async function cargarLista(cod) {
        const lista = document.getElementById("listaRequerimientos");
        if (!lista) return;
        lista.innerHTML = "Cargando...";

        try {
            const response = await fetch(`https://mobilitysolutionscorp.com/db_consultas/api_requerimientos.php?cod=${cod}`);
            if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

            const datos = await response.json();
            lista.innerHTML = "";

            if (!datos || datos.length === 0) {
                lista.innerHTML = "No hay requerimientos disponibles.";
                return;
            }

            todosLosRequerimientos = datos;
            mostrarRequerimientos(todosLosRequerimientos);

        } catch (error) {
            lista.innerHTML = "Error al cargar los datos.";
            console.error("Error en la carga de requerimientos:", error);
        }
    }

    function mostrarRequerimientos(requerimientos) {
        const lista = document.getElementById("listaRequerimientos");
        if (!lista) return;
        lista.innerHTML = "";

        if (!requerimientos.length) {
            lista.innerHTML = "No hay requerimientos disponibles.";
            return;
        }

        requerimientos.forEach(req => {
            let li = document.createElement("li");
            li.innerHTML = `
                <strong>Requerimiento:</strong> ${req.id} <br>
                <strong>Auto:</strong> ${req.id_auto} <br>
                ${req.tipo_req} ${req.status_req ? `- (<strong>${req.status_req}</strong>)` : ""} <br><br>
                <strong>${req.rechazo_coment ? `- (<strong>${req.rechazo_coment}</strong>)` : ""}</strong>
            `;
            li.classList.add(req.status_req || "");
            lista.appendChild(li);
        });
    }

    function filtrarLista(status) {
        const requerimientosFiltrados = todosLosRequerimientos.filter(req => req.status_req === status);
        mostrarRequerimientos(requerimientosFiltrados);
    }

    // Cargar lista de requerimientos al entrar (si esa lista existe en la vista)
    document.addEventListener('DOMContentLoaded', ()=> cargarLista(userId));
</script>

<!-- ===== Req 3: Mis requerimientos (tabla central) ===== -->
<script>
  let dtReq3 = null;

  function safe(val){ return (val===null || val===undefined) ? '' : val; }

  function cargarReq3(){
    const userId = <?= (int)($user_id ?? 0) ?>;
    const url = `https://mobilitysolutionscorp.com/db_consultas/api_requerimientos.php?cod=${userId}`;

    fetch(url)
      .then(r => {
        if(!r.ok) throw new Error('HTTP '+r.status);
        return r.json();
      })
      .then(datos => {
        const tbody = document.querySelector('#tablaReq3 tbody');
        if(!tbody) return;
        if(!Array.isArray(datos) || !datos.length){
          tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">No hay requerimientos.</td></tr>`;
        }else{
          const rows = datos.map(req => {
            const badge = `<span class="badge rounded-pill ${msStatusBadgeCls(req.status_req)}">${safe(req.status_req) || 'pendiente'}</span>`;
            const fecha = safe(req.created_at || req.fecha || '').toString().slice(0,19);
            return `
              <tr>
                <td class="text-muted">${safe(req.id)}</td>
                <td>${safe(req.id_auto)}</td>
                <td>${safe(req.tipo_req)}</td>
                <td>${badge}</td>
                <td>${safe(req.rechazo_coment)}</td>
                <td>${fecha}</td>
              </tr>`;
          }).join('');
          tbody.innerHTML = rows;
        }

        if (dtReq3){ dtReq3.destroy(); }
        dtReq3 = $('#tablaReq3').DataTable({
          pageLength: 10,
          order: [[0,'desc']],
          lengthChange: false,
          language: {
            emptyTable: "Sin datos",
            info: "Mostrando _START_ a _END_ de _TOTAL_",
            infoEmpty: "Mostrando 0 a 0 de 0",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "No hay coincidencias",
            paginate: { first: "Primero", last: "Último", next: "Siguiente", previous: "Anterior" }
          }
        });
      })
      .catch(err => {
        console.error('Req3 error:', err);
        const tbody = document.querySelector('#tablaReq3 tbody');
        if(tbody) tbody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Error al cargar la información.</td></tr>`;
      });
  }

  // Al entrar a la página, según la pestaña activa
  document.addEventListener('DOMContentLoaded', function(){
    const urlParams = new URLSearchParams(window.location.search);
    const req = urlParams.get('req') || '3';
    if (req === '3') cargarReq3();
    if (req === '2') cargarAutos();
  });
</script>

<script>
    // ====== Botón "Solicitar reserva" ======
    document.addEventListener("DOMContentLoaded", function () {
      const botonReserva = document.getElementById("boton_reserva");
      if(!botonReserva) return;

      const marca = (botonReserva.getAttribute("data-marca") || '').trim();
      if (!marca) {
          botonReserva.disabled = true;
      }

      botonReserva.addEventListener("click", function () {
          const vehiculoData = botonReserva.getAttribute("data-vehiculo");
          const usuarioData  = botonReserva.getAttribute("data-usuario");

          if (!vehiculoData || !usuarioData) {
              alert("Faltan datos para la reserva.");
              return;
          }

          const vehiculo = JSON.parse(vehiculoData);
          const usuario  = { id: usuarioData };

          fetch("../db_consultas/insert_sp_req.php", {
              method: "POST",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify({ vehiculo, usuario })
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert("Reserva realizada con éxito.");
                  // si quieres quedarte en Req 1, deja la línea siguiente como estaba:
                  window.location.href = window.location.pathname + '?req=3'; // te llevo a Mis requerimientos
              } else {
                  alert("Error al realizar la reserva.");
              }
          })
          .catch(error => {
              console.error("Error:", error);
              alert("Ocurrió un error inesperado.");
          });
      });
    }); 
</script>

<?php if ($selected == '2'): ?>
<!-- Lanza cargarAutos SOLO si estás en Entrega de vehículo -->
<script>
  document.addEventListener('DOMContentLoaded', function(){
    cargarAutos();
  });
</script>
<?php endif; ?>

</body>
</html>
