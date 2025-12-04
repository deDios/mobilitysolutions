<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        echo '
            <script>
                alert("Es necesario hacer login, por favor ingrese sus credenciales");
                window.location = "../views/login.php";
            </script>';
        session_destroy();
        die();
    }

    $inc = include "../db/Conexion.php";

    $query = 'select 
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
            where acc.user_name = ' . $_SESSION['username'] . ';';

    $result = mysqli_query($con, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $user_id       = $row['user_id'];
            $_SESSION['user_id'] = $user_id;
            $user_name     = $row['user_name'];
            $user_password = $row['user_password'];
            $user_type     = $row['user_type'];
            $r_ejecutivo   = $row['r_ejecutivo'];
            $r_editor      = $row['r_editor'];
            $r_autorizador = $row['r_autorizador'];
            $r_analista    = $row['r_analista'];
            $nombre        = $row['nombre'];
            $s_nombre      = $row['s_nombre'];
            $last_name     = $row['last_name'];
            $email         = $row['email'];
            $cumpleaños    = $row['cumpleaños'];
            $telefono      = $row['telefono'];
        }
    } else {
        echo 'Falla en conexión.';
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas</title>
    <link rel="shortcut icon" href="../Imagenes/movility.ico" />
    <link rel="stylesheet" href="../CSS/tareas_v2.css">

    <!-- Bootstrap / fonts -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables (si lo usas en otros bloques) -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js"></script>

    <!-- Chart.js (para futuras métricas de tareas) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
<div class="fixed-top">
  <!-- TOPBAR -->
  <header class="topbar">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <ul class="social-network">
              <li>
                <a class="waves-effect waves-dark" href="https://www.facebook.com/profile.php?id=61563909313215&mibextid=kFxxJD">
                  <i class="fa fa-facebook"></i>
                </a>
              </li>
              <li>
                <a class="waves-effect waves-dark" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                  <i class="fa fa-map-marker"></i>
                </a>
              </li>
              <li>
                <a class="waves-effect waves-dark" href="https://mobilitysolutionscorp.com/db_consultas/cerrar_sesion.php">
                  <i class="fa fa-sign-out"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
  </header>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark mx-background-top-linear">
    <div class="container">
      <a class="navbar-brand" rel="nofollow" target="_blank" href="https://mobilitysolutionscorp.com/"> Mobility Solutions: Tareas </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <?php $self = basename($_SERVER['PHP_SELF']); ?>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link <?= $self==='Home.php' ? 'active' : '' ?>" href="https://mobilitysolutionscorp.com/Views/Home.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $self==='edicion_catalogo.php' ? 'active' : '' ?>" href="https://mobilitysolutionscorp.com/Views/edicion_catalogo.php">Catálogo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $self==='requerimientos.php' ? 'active' : '' ?>" href="https://mobilitysolutionscorp.com/Views/requerimientos.php">Requerimientos</a>
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

<!-- ================== WRAPPER GENERAL ESTILO REMAKE ================== -->
<div class="container ms-settings-wrap">

  <!-- Barra con avatar + usuario + salir -->
  <div class="ms-head card shadow-sm mb-3">
    <div class="card-body d-flex align-items-center gap-3 flex-wrap">
      <div class="ms-avatar">
        <?php
          $ini = trim(($nombre ?? 'Usuario').' '.($last_name ?? 'Demo'));
          $parts = preg_split('/\s+/', $ini);
          $iniciales = mb_substr($parts[0] ?? 'U',0,1) . mb_substr($parts[1] ?? '',0,1);
          echo htmlspecialchars(strtoupper($iniciales));
        ?>
      </div>
      <div class="flex-grow-1">
        <div class="h5 mb-0">
          <?= htmlspecialchars(($nombre ?? 'Usuario').' '.($last_name ?? 'Demo')) ?>
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

  <!-- ================== CONTENIDO PRINCIPAL: KANBAN + DETALLE ================== -->
  <div class="task-wrapper">
    <!-- === Columna izquierda: Kanban === -->
    <section class="kanban-section">
      <div class="kanban-head">
        <h2 class="kanban-title">Kanban de tareas</h2>
        <p class="kanban-subtitle">Arrastra las tarjetas entre columnas para actualizar el estado.</p>
      </div>

      <div class="kanban-board">
        <div class="kanban-column" data-status="1">
          <div class="kanban-column-head">
            <h3>Por hacer</h3>
            <span class="status-pill status-backlog">Backlog</span>
          </div>
          <hr>
          <div class="kanban-tasks" id="por-hacer"></div>
        </div>

        <div class="kanban-column" data-status="2">
          <div class="kanban-column-head">
            <h3>En proceso</h3>
            <span class="status-pill status-progress">En curso</span>
          </div>
          <hr>
          <div class="kanban-tasks" id="en-proceso"></div>
        </div>

        <div class="kanban-column" data-status="3">
          <div class="kanban-column-head">
            <h3>Por revisar</h3>
            <span class="status-pill status-review">Revisión</span>
          </div>
          <hr>
          <div class="kanban-tasks" id="por-revisar"></div>
        </div>

        <div class="kanban-column" data-status="4">
          <div class="kanban-column-head">
            <h3>Hecho</h3>
            <span class="status-pill status-done">Cerradas</span>
          </div>
          <hr>
          <div class="kanban-tasks" id="hecho"></div>
        </div>
      </div>
    </section>

    <!-- === Columna derecha: Detalle + Comentarios === -->
    <section class="detalle-section">
      <div class="detalle-card">
        <div class="detalle-header">
          <h2>Detalle de tarea</h2>
          <span class="detalle-placeholder" id="detalle-placeholder">
            Selecciona una tarjeta del kanban para ver el detalle.
          </span>
        </div>

        <div id="detalle-tarea" class="detalle-content is-empty">
          <p><strong>Nombre:</strong> <span id="detalle-nombre"></span></p>
          <p><strong>Descripción:</strong> <span id="detalle-descripcion"></span></p>
          <p><strong>Asignado a:</strong> <span id="detalle-asignado"></span></p>
          <p><strong>Reportado por:</strong> <span id="detalle-creador"></span></p>
          <p><strong>Comentario:</strong> <span id="detalle-comentario"></span></p>
          <p><strong>Creado el:</strong> <span id="detalle-creado"></span></p>
        </div>

        <!-- Sección de comentarios -->
        <div class="comentarios-wrapper">
          <div class="comentarios-header">
            <h3>Comentarios</h3>
            <small class="text-muted" id="comentarios-resumen"></small>
          </div>
          <div id="comentarios-lista" class="comentarios-lista">
            <div class="comentarios-empty">
              Selecciona una tarea para ver sus comentarios.
            </div>
          </div>
          <form id="comentario-form" class="comentario-form">
            <label for="comentario-texto" class="comentario-label">Agregar comentario</label>
            <textarea id="comentario-texto" rows="3" placeholder="Escribe un comentario sobre la tarea..."></textarea>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-sm btn-comentario">
                <i class="fa fa-commenting-o me-1"></i> Guardar comentario
              </button>
            </div>
          </form>
        </div>

      </div>
    </section>
  </div>
</div>

<!-- ================== JS: Carga, selección, comentarios y drag & drop ================== -->
<script>
  const userId = <?php echo isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0; ?>;
  let tareaSeleccionadaId = null;

  // 📌 Calcula días transcurridos desde created_at (YYYY-MM-DD HH:MM:SS)
  function calcularDiasDesde(fechaStr) {
    if (!fechaStr) return null;

    const partes = fechaStr.replace('T', ' ').split(' ');
    const fechaPart = partes[0] || '';
    const [y, m, d] = fechaPart.split('-').map(Number);

    if (!y || !m || !d) return null;

    const fecha = new Date(y, m - 1, d);
    if (isNaN(fecha.getTime())) return null;

    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0);
    fecha.setHours(0, 0, 0, 0);

    const diffMs = hoy - fecha;
    if (diffMs < 0) return 0;

    return Math.floor(diffMs / (1000 * 60 * 60 * 24));
  }

  // ===================== COMENTARIOS: RENDER Y CARGA =====================
  function renderComentarios(data){
    const cont = document.getElementById('comentarios-lista');
    const resumen = document.getElementById('comentarios-resumen');
    if (!cont) return;

    cont.innerHTML = '';

    if (!data || !data.success) {
      cont.innerHTML = '<div class="comentarios-empty">No se pudieron cargar los comentarios.</div>';
      if (resumen) resumen.textContent = '';
      return;
    }

    const comentarios = data.comentarios || [];

    if (resumen){
      resumen.textContent = comentarios.length
        ? `${comentarios.length} comentario${comentarios.length === 1 ? '' : 's'}`
        : 'Sin comentarios';
    }

    if (!comentarios.length){
      cont.innerHTML = '<div class="comentarios-empty">Sin comentarios todavía. Escribe el primero.</div>';
      return;
    }

    comentarios.forEach(c => {
      const item = document.createElement('div');
      item.className = 'comentario-item';

      const nombre = (c.nombre_usuario && c.nombre_usuario.trim())
        ? c.nombre_usuario
        : `Usuario ${c.usuario_id}`;

      const fecha = c.created_at ? c.created_at : '';

      item.innerHTML = `
        <div class="comentario-item-header">
          <span class="comentario-user">${nombre}</span>
          <span class="comentario-date">${fecha}</span>
        </div>
        <div class="comentario-body">${(c.comentario || '').replace(/\n/g,'<br>')}</div>
      `;
      cont.appendChild(item);
    });
  }

  function cargarComentarios(tareaId){
    const cont = document.getElementById('comentarios-lista');
    const resumen = document.getElementById('comentarios-resumen');
    if (!cont) return;

    if (!tareaId){
      cont.innerHTML = '<div class="comentarios-empty">Selecciona una tarea para ver sus comentarios.</div>';
      if (resumen) resumen.textContent = '';
      return;
    }

    cont.innerHTML = '<div class="comentarios-empty">Cargando comentarios...</div>';
    if (resumen) resumen.textContent = '';

    fetch(`https://mobilitysolutionscorp.com/web/MS_c_tarea_comentario.php?tarea_id=${tareaId}`)
      .then(res => res.json())
      .then(data => renderComentarios(data))
      .catch(err => {
        console.error('Error al cargar comentarios:', err);
        cont.innerHTML = '<div class="comentarios-empty">Error al cargar comentarios.</div>';
        if (resumen) resumen.textContent = '';
      });
  }

  document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('comentario-form');
    const textarea = document.getElementById('comentario-texto');

    if (form && textarea){
      form.addEventListener('submit', e => {
        e.preventDefault();
        const texto = textarea.value.trim();

        if (!tareaSeleccionadaId){
          alert('Selecciona una tarea antes de agregar un comentario.');
          return;
        }
        if (!texto){
          return;
        }

        fetch('https://mobilitysolutionscorp.com/web/MS_i_tarea_comentario.php', {
          method: 'POST',
          headers: { 'Content-Type':'application/json' },
          body: JSON.stringify({
            tarea_id: tareaSeleccionadaId,
            usuario_id: userId,
            comentario: texto
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success){
            textarea.value = '';
            cargarComentarios(tareaSeleccionadaId);
          } else {
            alert('No se pudo guardar el comentario: ' + (data.message || ''));
          }
        })
        .catch(err => {
          console.error('Error al guardar comentario:', err);
          alert('Error al guardar el comentario.');
        });
      });
    }

    // Estado inicial de comentarios
    cargarComentarios(null);
  });

  // ===================== KANBAN: CARGA Y DRAG & DROP =====================
  if (userId > 0) {
    fetch(`https://mobilitysolutionscorp.com/web/MS_get_tareas.php?user_id=${userId}`)
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          const estados = {
            1: document.getElementById('por-hacer'),
            2: document.getElementById('en-proceso'),
            3: document.getElementById('por-revisar'),
            4: document.getElementById('hecho'),
          };

          data.tareas.forEach(tarea => {
            const card = document.createElement("div");
            card.className = "task-card";
            card.setAttribute("draggable", "true");
            card.dataset.id = tarea.id;
            card.dataset.status = tarea.status;
            card.dataset.creado_por = tarea.creado_por;

            const dias = calcularDiasDesde(tarea.created_at);
            let diasHtml = '';

            // Solo mostrar contador si NO está en "Hecho" (status != 4) y tenemos fecha
            if (tarea.status != 4 && dias !== null) {
              const label = (dias === 0) ? 'Hoy' : `${dias} día${dias === 1 ? '' : 's'}`;
              diasHtml = `
                <div class="task-meta">
                  <span class="task-age">${label}</span>
                </div>
              `;
            }

            card.innerHTML = `
              <h4>${tarea.nombre}</h4>
              <p><strong>Asignado a:</strong> ${tarea.asignado_nombre}</p>
              <p><strong>Reportado por:</strong> ${tarea.creado_por_nombre}</p>
              ${diasHtml}
            `;

            // Mostrar detalle y comentarios al hacer clic + marcar activa
            card.addEventListener("click", () => {
              // Quitar selección previa y marcar esta
              document.querySelectorAll('.task-card').forEach(c => c.classList.remove('active'));
              card.classList.add('active');
              tareaSeleccionadaId = tarea.id;

              const detalleBox   = document.getElementById("detalle-tarea");
              const placeholder  = document.getElementById("detalle-placeholder");

              if (placeholder) placeholder.style.display = "none";
              if (detalleBox)   detalleBox.classList.remove("is-empty");

              document.getElementById("detalle-nombre").textContent       = tarea.nombre;
              document.getElementById("detalle-descripcion").textContent  = tarea.descripcion;
              document.getElementById("detalle-asignado").textContent     = tarea.asignado_nombre;
              document.getElementById("detalle-creador").textContent      = tarea.creado_por_nombre;
              document.getElementById("detalle-comentario").textContent   = tarea.comentario || 'N/A';
              document.getElementById("detalle-creado").textContent       = tarea.created_at;

              // Cargar comentarios de esta tarea
              cargarComentarios(tarea.id);
            });

            estados[tarea.status]?.appendChild(card);
          });

          // Habilitar columnas como zonas de drop
          document.querySelectorAll('.kanban-column').forEach(column => {
            column.addEventListener('dragover', e => e.preventDefault());

            column.addEventListener('drop', e => {
              e.preventDefault();
              const targetStatus = parseInt(column.dataset.status);
              const draggedCard  = document.querySelector('.dragging');
              if (!draggedCard) return;

              const tareaId = parseInt(draggedCard.dataset.id);
              const creador = parseInt(draggedCard.dataset.creado_por);

              // ✅ Regla original: solo el creador puede mover a "Hecho"
              if (targetStatus === 4 && userId !== creador) {
                alert("Solo la persona que creó la tarea puede marcarla como 'Hecho'.");
                return;
              }

              // Actualizar visualmente
              column.querySelector('.kanban-tasks').appendChild(draggedCard);

              // Llamar al API para actualizar el status
              fetch('https://mobilitysolutionscorp.com/web/MS_update_tarea_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: tareaId, status: targetStatus })
              })
              .then(res => res.json())
              .then(response => {
                if (!response.success) {
                  alert("Error al actualizar el estatus: " + (response.message || ''));
                }
              })
              .catch(err => console.error("Error al llamar API:", err));
            });
          });

          // Eventos de arrastrar tarjeta
          document.addEventListener('dragstart', e => {
            if (e.target.classList.contains('task-card')) {
              e.target.classList.add('dragging');
            }
          });

          document.addEventListener('dragend', e => {
            if (e.target.classList.contains('task-card')) {
              e.target.classList.remove('dragging');
            }
          });
        }
      })
      .catch(err => {
        console.error("Error de conexión:", err);
      });
  } else {
    console.warn("Usuario no válido.");
  }
</script>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3z9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>
