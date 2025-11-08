<?php
    session_start();

    if (!isset($_SESSION['username'])){
        echo ' 
            <script>
                alert("Es necesario hacer login, por favor ingrese sus credenciales") ;
                window.location = "../views/login.php";
            </script> ';
        session_destroy();
        die();
    }

    $inc = include "../db/Conexion.php";

    // ===== AJUSTE 1: consulta segura con prepare =====
    $query = 'SELECT 
                acc.user_id, 
                acc.user_name, 
                acc.user_password, 
                acc.user_type, 
                acc.r_ejecutivo, 
                acc.r_editor, 
                acc.r_autorizador, 
                acc.r_analista, 
                us.user_name   AS nombre, 
                us.second_name AS s_nombre, 
                us.last_name, 
                us.email, 
                us.cumpleaños, 
                us.telefono
              FROM mobility_solutions.tmx_acceso_usuario AS acc
              LEFT JOIN mobility_solutions.tmx_usuario AS us
                ON acc.user_id = us.id
              WHERE acc.user_name = ?';

    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && ($row = $result->fetch_assoc())) {
        $user_id       = $row['user_id'];
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
    } else {
        echo 'Falla en conexión.';
    }
    $stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="shortcut icon" href="../Imagenes/movility.ico" />
    <link rel="stylesheet" href="../CSS/home.css">

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
// === Recompensas basadas en indicadores (global) ===
window.rew = {
  quejas: 0,
  inasistencias: 0,
  entregas: 0,
  reservas: 0,
  reconocimientos: 0,
  metas: [25, 50, 75, 100],
  max: 100
};

// Calcula puntos aplicando fórmula y clamp 0..max (forzando a número)
window.computeRewardPoints = function () {
  const entregas        = Number(window.rew.entregas)        || 0;
  const reservas        = Number(window.rew.reservas)        || 0;
  const reconocimientos = Number(window.rew.reconocimientos) || 0;
  const inasistencias   = Number(window.rew.inasistencias)   || 0;
  const quejas          = Number(window.rew.quejas)          || 0;
  const maxPts          = Number(window.rew.max)             || 100;

  const raw = (entregas * 4) + (reservas * 1) + reconocimientos - (inasistencias * 2) - (quejas * 3);
  return Math.max(0, Math.min(maxPts, raw));
};

// Actualiza UI del termómetro (número, barra, markers y “Siguiente:”)
window.renderRewards = function () {
  const pts = window.computeRewardPoints();
  const maxPts = window.rew.max;

  const fill = document.getElementById("rewards-fill");
  const ptsEl = document.getElementById("pts-actuales");
  const nextEl = document.getElementById("rewards-next");
  const markersWrap = document.getElementById("rewards-markers");

  if (ptsEl) ptsEl.textContent = pts;
  if (fill)   fill.style.width = (pts / maxPts * 100) + "%";

  if (markersWrap && window.rew.metas) {
    const markers = markersWrap.children;
    window.rew.metas.forEach((m, i) => {
      const mk = markers[i];
      if (!mk) return;
      if (pts >= m) mk.classList.add("achieved");
      else          mk.classList.remove("achieved");
    });
  }

  if (nextEl) {
    const next = window.rew.metas.find(m => pts < m);
    nextEl.textContent = next
      ? `Siguiente: Premio ${window.rew.metas.indexOf(next) + 1} a ${next} pts`
      : `¡Todos los premios conseguidos!`;
  }
};
</script>

    <style>
  /* --- Recompensas: barra horizontal y marcadores sobre la barra --- */
  .rewards-wrapper{
    background:#fff; border:1px solid #e9ecef; border-radius:12px; padding:14px 16px; 
    margin-bottom:16px; box-shadow:0 2px 10px rgba(0,0,0,.04);
    
  }
  .rewards-head{display:flex; align-items:baseline; justify-content:space-between; gap:12px; margin-bottom:10px;}
  .rewards-title{font-size:16px; font-weight:700; color:#1f2937;}
  .rewards-stats{font-size:14px; color:#374151;}
  .rewards-stats strong{font-weight:800;}

  .rewards-bar{
    position: relative !important;      /* <- ancla para absolutos */
    width: 100%;
    height: 14px;
    border-radius: 999px;
    background: linear-gradient(90deg,#f3f4f6 0%, #eef2ff 100%);
    overflow: visible !important;        /* <- deja ver etiquetas */
    box-shadow: inset 0 0 0 1px rgba(0,0,0,.08);
    margin: 40px 0 90px !important;       /* <- espacio para etiquetas abajo */
  }
  .rewards-fill{
    position:absolute; inset:0 auto 0 0; width:0%;
    border-radius:999px; background:linear-gradient(90deg,#60a5fa,#4f46e5);
    transition: width .8s ease-in-out;
  }

  /* contenedor de marcadores flotando SOBRE la barra */
  .rewards-markers{
    position: absolute !important;
    left: 0; right: 0; top: 0;
    height: 0; pointer-events:none;
  }

  /* cada marcador */
  .rewards-marker{
    position: absolute !important;
    transform: translateX(-50%);
    top: -12px;                          /* un poco por arriba de la barra */
    width: 2px; height: 34px;
    background: #cfd8ff;
  }
  .rewards-marker .dot{
    position:absolute; top:-6px; left:50%; transform:translate(-50%,-50%);
    width:12px; height:12px; border-radius:999px; background:#93c5fd;
    border:2px solid #fff; box-shadow:0 0 0 2px #cfd8ff;
  }
  /* etiqueta BAJO la barra */
  .rewards-marker .label{
    position:absolute; top:58px; left:50%; transform:translateX(-50%);
    white-space:nowrap; font-size:12px; font-weight:700; color:#374151;
    background:#fff; padding:2px 8px; border-radius:999px;
    box-shadow:0 1px 4px rgba(0,0,0,.05); border:1px solid #e5e7eb;
  }

  /* estados ganados */
  .rewards-marker.achieved{ background:#60a5fa; }
  .rewards-marker.achieved .dot{ background:#10b981; box-shadow:0 0 0 2px #bbf7d0; }
  .rewards-marker.achieved .label{ color:#065f46; border-color:#bbf7d0; background:#ecfdf5; }

  .rewards-legend{display:flex; justify-content:space-between; margin-top:10px; font-size:12px; color:#6b7280;}
  .rewards-legend .next{font-weight:700; color:#111827;}

  /* === Acordeón de Reconocimientos por tipo === */
.rec-groups { margin-top: 8px; display: grid; gap: 10px; }

.rec-group {
  background:#fff; border:1px solid #e5e7eb; border-radius:10px;
  box-shadow:0 2px 6px rgba(0,0,0,.04); overflow: hidden;
}

.rec-group__header {
  display:flex; align-items:center; justify-content:space-between;
  padding:12px 14px; cursor:pointer; user-select:none;
  background:#f9fafb;
}
.rec-group__left { display:flex; gap:10px; align-items:center; }
.rec-group__title {
  font-weight:700; color:#111827; font-size:14px;
}
.rec-group__badge {
  font-size:12px; background:#eef2ff; color:#3730a3; border-radius:999px;
  padding:2px 8px; font-weight:700;
}
.rec-group__points { font-size:12px; color:#374151; }

.rec-group__chev {
  transition: transform .2s ease;
}
.rec-group.open .rec-group__chev { transform: rotate(90deg); }

.rec-group__body {
  display:none;
  padding:12px;
  background:#fff;
}
.rec-group.open .rec-group__body { display:block; }

/* grid interno reutiliza tus tiles existentes */
.rec-grid {
  display:flex; flex-wrap:wrap; gap:16px; justify-content:flex-start;
}

.rec-empty{
  padding: 10px 4px;
  font-size: 13px;
  color: #6b7280;
  font-style: italic;
}

.hex.active {
  transform: scale(1.3);
  background-color:rgb(0, 71, 122) !important; /* Verde o el color que prefieras */
  box-shadow: 0 0 10px rgba(0,0,0,0.3);
}

/* === Panal de mini-hex debajo de los hex grandes === */
.hex-honey{
  display:flex;
  justify-content:center;
  align-items:center;
  gap: 120px;
  margin-top: -28px;
  margin-bottom: 12px;
}

.mini-hex{
  width: 90px;
  height: 78px;
  clip-path: polygon(50% 0%,93% 25%,93% 75%,50% 100%,7% 75%,7% 25%);
  display:flex;
  flex-direction:column;
  justify-content:center;
  align-items:center;
  color:#fff;
  font-weight:700;
  text-align:center;
  text-decoration:none;
  box-shadow: 0 4px 8px rgba(0,0,0,.12);
  transition: transform .15s ease, filter .15s ease;
  user-select:none;
}
.rewards-legend .neg { color:#ef4444; font-weight:600; }

#lineChart{
  display: block;
  width: 100% !important;
  height: 260px !important;
}

.chart-wrapper{ position: relative; }

#gaugeChart{
  display: none;
  width: 100%;
  height: 300px;
  aspect-ratio: 1 / 1;
  transform: none !important;
  -webkit-clip-path: none !important;
  clip-path: none !important;
}

/* ===== KPI Entregas (versión compacta) ===== */
.entrega-kpi{
  position: relative;
  display: flex; align-items: center; justify-content: center;
  gap: 12px; padding: 0; margin: 0 auto;
  max-width: 620px;
}

.entrega-kpi .left{
  display: flex; flex-direction: column; align-items: flex-end;
  gap: 6px; min-width: 200px;
}

.entrega-kpi .num{
  font: 700 clamp(22px,3.2vw,38px)/1 system-ui,-apple-system,Segoe UI,Roboto;
  color: #111; text-shadow: 0 2px 5px rgba(0,0,0,.15);
}

.entrega-kpi .label{
  font: 600 clamp(11px,1.3vw,15px)/1.1 system-ui,-apple-system,Segoe UI,Roboto;
  color: #111;
}

.entrega-kpi .meta-wrap{
  display: flex; flex-direction: column; align-items: flex-end;
  gap: 6px;
}

.entrega-kpi .hline{
  height: 4px;
  width: clamp(110px, 14vw, 170px);
  background: #0b7285;
  border-radius: 4px;
  box-shadow: 0 1px 2px rgba(0,0,0,.2);
}

.entrega-kpi .divider{
  width: 6px; min-height: 120px;
  background: #0b7285; border-radius: 6px;
  box-shadow: inset 0 0 0 2px rgba(0,0,0,.12);
}

.entrega-kpi .right{ display: flex; align-items: center; gap: 6px; color:#111; }
.entrega-kpi .right .symbol{ font: 900 clamp(26px,4.2vw,48px)/1 system-ui; }
.entrega-kpi .right .pct{    font: 900 clamp(32px,5.8vw,72px)/1 system-ui; text-shadow:0 2px 6px rgba(0,0,0,.18); }

@media (max-width: 768px){
  .entrega-kpi{ gap: 10px; max-width: 92%; }
  .entrega-kpi .divider{ min-height: 110px; }
}

.mini-hex span{font-size:12px; line-height:1; opacity:.95; margin-bottom:2px;}
.mini-hex strong{font-size:16px; line-height:1;}

.mini-hex:hover{ transform: scale(1.05); filter: brightness(1.02); }

.mini-hex.quejas{ background:#ff6b6b; }
.mini-hex.inasistencias{ background:#ff6b6b; }

@media (max-width: 768px){
  .hex-honey{
    gap: 40px;
    margin-top: 6px;
  }
  .mini-hex{ width:82px; height:70px; }
}

/* ===== Override modales personalizados ===== */
#editModal.modal,
#cumpleModal.modal {
  display: none;
  position: fixed;
  inset: 0;
  z-index: 9999;
  background-color: rgba(0,0,0,0.55);
  padding: 40px 16px;
  overflow-y: auto;
}

#editModal .modal-content,
#cumpleModal .modal-content {
  background-color: #fff;
  margin: 0 auto;
  width: 100%;
  max-width: 400px;
  border-radius: 10px;
  border: 1px solid #888;
  box-shadow: 0 20px 40px rgba(0,0,0,0.2);
  padding: 24px 24px 20px;
  position: relative;
}

#cumpleModal .modal-content h2,
#editModal .modal-content h2 {
  margin-top: 0;
  text-align: center;
  font-size: 20px;
  font-weight: 600;
  color: #111;
}

#editModal .close,
#cumpleModal .close {
  position: absolute;
  right: 12px;
  top: 10px;
  font-size: 20px;
  font-weight: 600;
  line-height: 1;
  cursor: pointer;
  color: #333;
}

#cumpleModal #cumpleLista {
  list-style: none;
  padding-left: 0;
  margin-top: 16px;
  max-height: 220px;
  overflow-y: auto;
  font-size: 14px;
  line-height: 1.4;
}

#cumpleModal #cumpleLista li { margin-bottom: 8px; }
</style>
</head>

<body>
<div class="fixed-top">
  <header class="topbar">
      <div class="container">
        <div class="row">
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
      <a class="navbar-brand" rel="nofollow" target="_blank" href="#"> Mobility Solutions: Home</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/Home.php">Inicio
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com/Views/edicion_catalogo.php">Catálogo</a></li>
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com/Views/requerimientos.php">Requerimientos</a></li>
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com/Views/tareas.php">Tareas</a></li>
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com/Views/Autoriza.php">Aprobaciones</a></li>
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com/Views/asignacion.php">Asignaciones</a></li>
        </ul>
      </div>
    </div>
  </nav>
</div>

<div class="flex-container">
    <!-- Perfil izquierdo -->
    <div class="container_1">
        <h1><?php echo $nombre . ' ' . $s_nombre . ' ' . $last_name; ?></h1>

        <div class="profile-header">
            <!-- Imagen de perfil con formulario -->
            <form id="uploadForm" action="../db_consultas/upload_photo.php" method="POST" enctype="multipart/form-data">
                <label for="profilePicInput" class="profile-image-wrapper">
                    <img src="../Imagenes/Usuarios/<?php echo $user_id; ?>.jpg?<?php echo time(); ?>" alt="Foto de perfil" class="profile-image" title="Haz clic para cambiar tu foto">
                    <div class="edit-icon-overlay">✎</div>
                </label>
                <input type="file" id="profilePicInput" name="profilePic" style="display: none;" onchange="document.getElementById('uploadForm').submit();">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            </form>

            <!-- Información del rol -->
            <div class="roles">
                <p><strong>Roles Activos:</strong></p>
                <ul>
                    <?php if ($r_ejecutivo) { echo "<li>Asesor(a)</li>"; } ?>
                    <?php if ($r_editor) { echo "<li>Maestro de catálogo</li>"; } ?>
                    <?php if ($r_autorizador) { echo "<li>Supervisor(a)</li>"; } ?>
                    <?php if ($r_analista) { echo "<li>Analista</li>"; } ?>
                </ul>
                <?php
                    date_default_timezone_set('America/Mexico_City');
                    $hora_actual = date('h:i A');
                ?>
                <p>Morelia Michoacán | <?php echo $hora_actual; ?>.</p>
            </div>
        </div>

        <div id="tareas-resumen" class="tareas-circulo">
          <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/tareas.php">
            <div class="circulo-tareas">
              <span id="cantidad-tareas">0</span>
            </div>
          </a>
          <div class="texto-tareas">Tareas en curso</div>

          <!-- pastel de cumpleaños -->
          <div class="cumple-cake-wrapper" id="cumpleTrigger" title="Cumpleaños este mes">
            <div class="cake-icon">
              <div class="cake-candle"><div class="candle-flame"></div></div>
              <div class="cake-layer"><span id="cumple-count">0</span></div>
            </div>
          </div>
        </div>

        <!-- Información de contacto -->
        <div class="profile-info">
            <p><small>Datos de contacto</small></p> <hr class="mt-2 mb-3"/>
            <p><strong>Username:</strong> <?php echo $user_name; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Fecha de Cumpleaños:</strong> <?php echo $cumpleaños; ?></p>
            <p><strong>Teléfono:</strong> <?php echo $telefono; ?></p>
            <p><strong>Tipo de Usuario:</strong> <?php echo $user_type; ?></p>
        </div>

        <a href="#" class="edit-button" onclick="openModal()">Editar Perfil</a>

        <!-- ====== Actividad del mes (por asesor) ====== -->
        <div id="mesActividad" class="mes-actividad-card">
          <div class="mes-actividad-head">
            <div class="mes-actividad-title">Actividad del mes (por asesor)</div>
            <div class="mes-actividad-controls">
              <button id="mesPrev" type="button" class="mes-ctrl-btn" aria-label="Mes anterior">‹</button>
              <span id="mesLabel" class="mes-actividad-label">—</span>
              <button id="mesNext" type="button" class="mes-ctrl-btn" aria-label="Mes siguiente">›</button>
            </div>
          </div>

          <div class="mes-actividad-subtle">Totales del mes seleccionado (con jerarquía)</div>

          <div class="tabla-mes-wrap">
            <table id="tablaMes" class="tabla-mes">
              <thead>
                <tr>
                  <th>Asesor</th>
                  <th>Nuevo</th>
                  <th>Venta</th>
                  <th>Entrega</th>
                  <th>Recon.</th>
                  <th>Quejas</th>
                  <th>Faltas</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <!-- Se llena por JS -->
              </tbody>
              <tfoot>
                <tr>
                  <th>Total</th>
                  <th id="tNuevo">0</th>
                  <th id="tVenta">0</th>
                  <th id="tEntrega">0</th>
                  <th id="tRecon">0</th>
                  <th id="tQuejas">0</th>
                  <th id="tFaltas">0</th>
                  <th id="tTotal">0</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <!-- ====== /Actividad del mes ====== -->
    </div>

    <!-- Panel derecho con hexágonos -->
    <div class="container_2">
        <div class="hex-container">
            <div class="hex" id="hex-nuevo"><span>Nuevo</span><strong>0</strong></div>
            <div class="hex" id="hex-reserva"><span>Venta</span><strong>0</strong></div>
            <div class="hex" id="hex-entrega"><span>Entrega</span><strong>0</strong></div>
        </div>

        <div class="hex-honey">
          <a class="mini-hex quejas" href="https://mobilitysolutionscorp.com/Views/asignacion.php" title="Ver quejas">
            <span>Quejas</span>
            <strong id="hc-quejas">0</strong>
          </a>
          <a class="mini-hex inasistencias" href="https://mobilitysolutionscorp.com/Views/asignacion.php" title="Ver inasistencias">
            <span>Faltas</span>
            <strong id="hc-inasistencias">0</strong>
          </a>
        </div>

        <div class="chart-wrapper">
          <canvas id="lineChart"></canvas>
          <canvas id="gaugeChart" style="display:none;"></canvas>
        </div>

        <div class="skills-section">
            <h2>Reconocimientos</h2>
            <div id="reconocimientosWrapper" class="reconocimientos-wrapper">
                <p class="placeholder">Aquí aparecerán los reconocimientos otorgados al usuario.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal de edición -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Editar Información</h2>
        <form id="editForm">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $email; ?>" required>
            <label>Fecha de Cumpleaños:</label>
            <input type="date" name="cumpleanos" value="<?php echo $cumpleaños; ?>" required>
            <label>Teléfono:</label>
            <input type="text" name="telefono" value="<?php echo $telefono; ?>" required>
            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</div>

<!-- Modal de Cumpleaños -->
<div id="cumpleModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeCumpleModal()">&times;</span>
    <h2 id="cumpleTituloMes">Cumpleaños</h2>
    <ul id="cumpleLista" style="list-style:none; padding-left:0; max-height:250px; overflow-y:auto; margin-top:15px; font-size:14px; line-height:1.4;"></ul>
  </div>
</div>

<script>
// Texto en el centro de una doughnut
const centerTextPlugin = {
  id: 'centerText',
  afterDraw(chart, args, opts) {
    const {ctx, chartArea} = chart;
    if (!chartArea) return;
    const x = (chartArea.left + chartArea.right) / 2;
    const y = (chartArea.top + chartArea.bottom) / 2;

    ctx.save();
    ctx.font = '700 32px system-ui, -apple-system, Segoe UI, Roboto';
    ctx.fillStyle = '#0f172a';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(String(opts.text || ''), x, y);

    if (opts.subtext) {
      ctx.font = '600 12px system-ui, -apple-system, Segoe UI, Roboto';
      ctx.fillStyle = '#64748b';
      ctx.fillText(String(opts.subtext), x, y + 22);
    }
    ctx.restore();
  }
};
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const userId = <?php echo intval($user_id); ?>;

  // ====== TAREAS EN CURSO ======
  fetch(`https://mobilitysolutionscorp.com/web/MS_get_tareas.php?user_id=${userId}`)
    .then(res => res.json())
    .then(data => {
      if (data.success && Array.isArray(data.tareas)) {
        const tareasEnCurso = data.tareas.filter(t => t.status != 4);
        document.getElementById("cantidad-tareas").textContent = tareasEnCurso.length;
      }
    })
    .catch(error => {
      console.error("Error al cargar tareas en curso:", error);
    });

  // ====== CUMPLEAÑEROS DEL MES ======
  fetch("https://mobilitysolutionscorp.com/web/MS_get_cumples_mes.php")
    .then(res => res.json())
    .then(data => {
      const lista = (data && Array.isArray(data.cumpleaneros)) ? data.cumpleaneros : [];
      const conteo = lista.length;

      const numEl = document.getElementById("cumple-count");
      if (numEl) numEl.textContent = conteo;

      const tituloMes = document.getElementById("cumpleTituloMes");
      if (tituloMes && data && data.mes) {
        tituloMes.textContent = "Cumpleaños de " + data.mes;
      }

      const ul = document.getElementById("cumpleLista");
      if (ul) {
        ul.innerHTML = "";
        if (lista.length === 0) {
          const li = document.createElement("li");
          li.className = "cumple-empty";
          li.textContent = "Sin cumpleaños este mes.";
          ul.appendChild(li);
        } else {
          lista.forEach(p => {
            const li = document.createElement("li");
            const nombre = p.nombre || p.user_name || "";
            const dia = p.dia || p.day || "";
            li.textContent = nombre + " — " + dia;
            ul.appendChild(li);
          });
        }
      }
    })
    .catch(err => {
      console.error("Error al cargar cumpleañeros:", err);
    });
});
</script>

<!-- JavaScript para abrir/cerrar modal y enviar JSON -->
<script>
function openModal() {
  document.getElementById("editModal").style.display = "block";
}
function closeModal() {
  document.getElementById("editModal").style.display = "none";
}
function openCumpleModal() {
  document.getElementById("cumpleModal").style.display = "block";
}
function closeCumpleModal() {
  document.getElementById("cumpleModal").style.display = "none";
}
window.onclick = function(event) {
  const modal = document.getElementById("editModal");
  if (event.target == modal) {
      modal.style.display = "none";
  }
}
window.addEventListener("click", function(e){
  const cmodal = document.getElementById("cumpleModal");
  if (e.target === cmodal) {
      cmodal.style.display = "none";
  }
});

// Enviar datos como JSON
document.getElementById("editForm").addEventListener("submit", function(e) {
  e.preventDefault();
  const form = e.target;
  const data = {
      user_id: form.user_id.value,
      email: form.email.value,
      cumpleanos: form.cumpleanos.value,
      telefono: form.telefono.value
  };
  fetch("https://mobilitysolutionscorp.com/db_consultas/update_profile.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data)
  })
  .then(response => response.text())
  .then(result => {
      alert(result);
      closeModal();
      location.reload();
  })
  .catch(error => {
      console.error("Error:", error);
      alert("Error al actualizar perfil");
  });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const userId = <?php echo intval($user_id); ?>;

  function actualizarContadores(selectores, count){
    (Array.isArray(selectores) ? selectores : [selectores]).forEach(sel=>{
      const el = document.querySelector(sel);
      if (el) el.textContent = count;
    });
  }

  function extraerConteo(respuesta, nombreArrayPosible) {
    if (respuesta && typeof respuesta.count === 'number') return respuesta.count;
    if (respuesta && Array.isArray(respuesta.rows)) return respuesta.rows.length;
    if (respuesta && Array.isArray(respuesta[nombreArrayPosible])) return respuesta[nombreArrayPosible].length;
    return 0;
  }

  // Quejas
  fetch("https://mobilitysolutionscorp.com/web/MS_queja_get.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ usuario: userId })
  })
  .then(r => r.json())
  .then(data => {
    const count = extraerConteo(data, "quejas");
    actualizarContadores(["#cantidad-quejas", "#hc-quejas"], count);
    window.rew.quejas = count;
    window.renderRewards();
  })
  .catch(() => actualizarContadores(["#cantidad-quejas", "#hc-quejas"], 0));

  // Inasistencias
  fetch("https://mobilitysolutionscorp.com/web/MS_inasistencia_get.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ usuario: userId })
  })
  .then(r => r.json())
  .then(data => {
    const count = extraerConteo(data, "inasistencias");
    actualizarContadores(["#cantidad-inasistencias", "#hc-inasistencias"], count);
    window.rew.inasistencias = count;
    window.renderRewards();
  })
  .catch(() => actualizarContadores(["#cantidad-inasistencias", "#hc-inasistencias"], 0));
});
</script>

<script>
  // ——— Utils ———
  function toInt(v){ const n = Number(v); return Number.isFinite(n) ? n : 0; }

  // PHP -> JS
  const userId = <?php echo intval($user_id); ?>;

  // Datos globales para línea y gauge
  let datosPorMes = [];
  let metasPorTipo = {
    1: Array(12).fill(0), // tipo_meta 1 = Nuevos
    2: Array(12).fill(0), // tipo_meta 2 = Reservas
    3: Array(12).fill(0), // tipo_meta 3 = Entregas
  };

  let totalNuevo = 0, totalReserva = 0, totalEntrega = 0;
  let lineChart = null;
  let gaugeChart = null;

  // ——— Plugin para la aguja del velocímetro ———
  const gaugeNeedlePlugin = {
    id: 'gaugeNeedle',
    afterDatasetDraw(chart, args, pluginOptions) {
      if (args.index !== 0) return;
      const { ctx } = chart;
      const meta = chart.getDatasetMeta(0);
      const arc  = meta.data[0];
      if (!arc) return;

      const cx = arc.x;
      const cy = arc.y;
      const r  = arc.outerRadius;

      const value  = Math.max(0, toInt(pluginOptions.value));
      const target = Math.max(1, toInt(pluginOptions.target));
      const capped = Math.min(value, target);

      const angle = chart.options.rotation + (capped / target) * chart.options.circumference;

      ctx.save();
      ctx.translate(cx, cy);
      ctx.rotate(angle);
      ctx.beginPath();
      ctx.moveTo(0, 0);
      ctx.lineTo(r, 0);
      ctx.lineWidth = 3;
      ctx.strokeStyle = '#111827';
      ctx.stroke();
      ctx.beginPath();
      ctx.arc(0, 0, 5, 0, Math.PI * 2);
      ctx.fillStyle = '#111827';
      ctx.fill();
      ctx.restore();

      ctx.save();
      ctx.font = '600 16px system-ui, -apple-system, Segoe UI, Roboto';
      ctx.fillStyle = '#111827';
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      ctx.fillText(value + ' / ' + target, cx, cy);
      ctx.restore();
    }
  };

  // ——— Línea (Chart.js) ———
  function initLineChart() {
    const ctx = document.getElementById('lineChart').getContext('2d');
    lineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
        datasets: [
          {
            label: 'Datos',
            data: Array(12).fill(0),
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.2)',
            borderWidth: 2,
            fill: true,
            tension: 0.3,
            pointRadius: 4,
            pointBackgroundColor: '#007bff',
          },
          {
            label: 'Meta',
            data: Array(12).fill(0),
            borderColor: '#ff9900',
            borderWidth: 2,
            fill: false,
            tension: 0.3,
            borderDash: [5, 5],
            pointRadius: 3,
            pointBackgroundColor: '#ff9900',
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true, ticks: { stepSize: 5 } } },
        plugins: {
          legend: { display: true, position: 'top' },
          tooltip: { mode: 'index', intersect: false }
        }
      }
    });
  }

  function actualizarGrafica(tipo) {
    if (!lineChart) return;

    const valores = datosPorMes.map(mes => toInt(mes[tipo]));
    const tipoMeta = { 'New': 1, 'Reserva': 2, 'Entrega': 3 }[tipo];
    const metas = (metasPorTipo[tipoMeta] || Array(12).fill(0)).map(toInt);
    const label = { 'New': 'Nuevos por mes', 'Reserva': 'Ventas por mes', 'Entrega': 'Entregas por mes' }[tipo];

    lineChart.data.datasets[0].data  = valores;
    lineChart.data.datasets[0].label = label;
    lineChart.data.datasets[1].data  = metas;
    lineChart.data.datasets[1].label = 'Meta';
    lineChart.update();

    document.querySelectorAll('.hex').forEach(h => h.classList.remove('active'));
    const hexMap = { 'New': '#hex-nuevo', 'Reserva': '#hex-reserva', 'Entrega': '#hex-entrega' };
    const hexSel = hexMap[tipo];
    if (hexSel) { const el = document.querySelector(hexSel); if (el) el.classList.add('active'); }
  }

  function renderGaugeEntrega() {
    const wrap = document.querySelector('.chart-wrapper');
    const lineCanvas = document.getElementById('lineChart');

    if (lineCanvas) lineCanvas.style.display = 'none';

    let kpi = document.getElementById('entregaKPI');
    if (!kpi) {
      kpi = document.createElement('div');
      kpi.id = 'entregaKPI';
      kpi.className = 'entrega-kpi';
      wrap.appendChild(kpi);
    }

    if (!kpi.querySelector('.meta-wrap')) {
      kpi.innerHTML = `
        <div class="left">
          <div class="num" id="kpiMetaNum">0</div>
          <div class="meta-wrap">
            <div class="label">Meta</div>
            <div class="hline"></div>
          </div>
          <div class="num" id="kpiEntregasNum">0</div>
          <div class="label">Entregas</div>
        </div>

        <div class="divider"></div>

        <div class="right">
          <span class="symbol">%</span>
          <span class="pct" id="kpiPct">0</span>
        </div>
      `;
    } else {
      kpi.style.display = 'flex';
    }

    let meta = (metasPorTipo[3] || []).reduce((a,b)=>a + toInt(b), 0);
    if (!meta) meta = Math.max(toInt(totalEntrega), 1);

    const valor = toInt(totalEntrega);
    const pct   = Math.round((valor / meta) * 1000) / 10;

    document.getElementById('kpiMetaNum').textContent     = meta;
    document.getElementById('kpiEntregasNum').textContent = valor;
    document.getElementById('kpiPct').textContent         = pct;

    document.querySelectorAll('.hex').forEach(h => h.classList.remove('active'));
    const hexEntrega = document.getElementById('hex-entrega');
    if (hexEntrega) hexEntrega.classList.add('active');
  }

  function showLine(tipo) {
    const kpi = document.getElementById('entregaKPI');
    if (kpi) kpi.style.display = 'none';

    const gaugeCanvas = document.getElementById('gaugeChart');
    const lineCanvas  = document.getElementById('lineChart');
    if (gaugeCanvas) gaugeCanvas.style.display = 'none';
    if (lineCanvas)  lineCanvas.style.display  = 'block';
    if (!lineChart) initLineChart();
    actualizarGrafica(tipo);
  }

  // === FLUJO: inicializa y carga datos + metas ===
  initLineChart();

  // 1) Datos por mes (totales) -> sin cambios en hex de la derecha
  fetch('https://mobilitysolutionscorp.com/db_consultas/hex_status.php?user_id=' + userId)
    .then(r => r.json())
    .then(data => {
      datosPorMes = Array.isArray(data) ? data : [];
      totalNuevo = 0; totalReserva = 0; totalEntrega = 0;
      datosPorMes.forEach(mes => {
        totalNuevo   += toInt(mes.New);
        totalReserva += toInt(mes.Reserva);
        totalEntrega += toInt(mes.Entrega);
      });

      document.querySelector('#hex-nuevo strong').textContent   = totalNuevo;
      document.querySelector('#hex-reserva strong').textContent = totalReserva;
      document.querySelector('#hex-entrega strong').textContent = totalEntrega;

      if (window.rew) {
        window.rew.entregas = totalEntrega;
        window.rew.reservas = totalReserva;
        if (typeof window.renderRewards === 'function') window.renderRewards();
      }

      showLine('Reserva');

      return fetch('https://mobilitysolutionscorp.com/web/MS_get_metas_usuario.php?asignado=' + userId);
    })
    .then(r => r.json())
    .then(data => {
      if (data && data.success && Array.isArray(data.metas)) {
        data.metas.forEach(meta => {
          const t = toInt(meta.tipo_meta);
          metasPorTipo[t] = [
            toInt(meta.enero), toInt(meta.febrero), toInt(meta.marzo),
            toInt(meta.abril), toInt(meta.mayo), toInt(meta.junio),
            toInt(meta.julio), toInt(meta.agosto), toInt(meta.septiembre),
            toInt(meta.octubre), toInt(meta.noviembre), toInt(meta.diciembre)
          ];
        });
      }
      const gauge = document.getElementById('gaugeChart');
      const visible = gauge && getComputedStyle(gauge).display !== 'none';
      if (visible) renderGaugeEntrega(); else showLine('Reserva');
    })
    .catch(err => console.error('Error al obtener datos/metas:', err));
</script>

<script>
// Abrir / cerrar modal de cumpleaños
function openCumpleModal() { document.getElementById("cumpleModal").style.display = "block"; }
function closeCumpleModal() { document.getElementById("cumpleModal").style.display = "none"; }
document.addEventListener("DOMContentLoaded", () => {
  const pastelBtn = document.getElementById("cumpleTrigger");
  if (pastelBtn) pastelBtn.addEventListener("click", openCumpleModal);
});
window.onclick = function(event) {
  const modal = document.getElementById("editModal");
  const cumpleModal = document.getElementById("cumpleModal");
  if (event.target == modal) modal.style.display = "none";
  if (event.target == cumpleModal) cumpleModal.style.display = "none";
};

// Fetch de cumpleañeros del mes
document.addEventListener("DOMContentLoaded", () => {
  fetch("https://mobilitysolutionscorp.com/web/MS_get_cumples_mes.php")
    .then(res => res.json())
    .then(data => {
      const lista = (data && Array.isArray(data.cumpleaneros)) ? data.cumpleaneros : [];
      const conteo = data.count || lista.length || 0;

      const countEl = document.getElementById("cumple-count");
      if (countEl) countEl.textContent = conteo;

      const tituloMes = document.getElementById("cumpleTituloMes");
      if (tituloMes && data.mes) tituloMes.textContent = "Cumpleaños de " + data.mes;

      const ul = document.getElementById("cumpleLista");
      if (ul) {
        ul.innerHTML = "";
        if (lista.length === 0) {
          const li = document.createElement("li");
          li.textContent = "Sin cumpleaños este mes.";
          ul.appendChild(li);
        } else {
          lista.forEach(p => {
            const li = document.createElement("li");
            li.style.marginBottom = "8px";
            li.textContent = (p.nombre ? p.nombre : "Sin nombre") + " — Día " + (p.dia ? p.dia : "--");
            ul.appendChild(li);
          });
        }
      }
    })
    .catch(err => { console.error("Error cumpleaños:", err); });
});
</script>

<script>
(function(){
  const userId   = <?php echo intval($user_id); ?>;
  const userType = <?php echo intval($user_type); ?>;

  const lbl      = () => document.getElementById('mesLabel');
  const tbody    = () => document.querySelector('#tablaMes tbody');
  const tNuevo   = () => document.getElementById('tNuevo');
  const tVenta   = () => document.getElementById('tVenta');
  const tEntrega = () => document.getElementById('tEntrega');
  const tRecon   = () => document.getElementById('tRecon');
  const tQuejas  = () => document.getElementById('tQuejas');
  const tFaltas  = () => document.getElementById('tFaltas');
  const tTotal   = () => document.getElementById('tTotal');

  const start = new Date(); // mes actual
  let curYear  = start.getFullYear();
  let curMonth = start.getMonth(); // 0..11

  const MES_NOMBRES = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

  function pad2(n){ return String(n).padStart(2,'0'); }
  function yyyymm(y,m){ return `${y}-${pad2(m+1)}`; }

  function pintarMesLabel(){
    const el = lbl();
    if (el) el.textContent = `${MES_NOMBRES[curMonth]} ${curYear}`;
  }

  function renderTabla(rows){
    const tb = tbody(); if (!tb) return;
    tb.innerHTML = '';

    let sNuevo=0, sVenta=0, sEntrega=0, sRecon=0, sQuejas=0, sFaltas=0, sTotal=0;

    if (!Array.isArray(rows) || rows.length === 0){
      const tr = document.createElement('tr');
      const td = document.createElement('td');
      td.colSpan = 8;
      td.textContent = 'Sin datos para este mes.';
      td.style.color = '#6b7280';
      td.style.fontStyle = 'italic';
      tr.appendChild(td);
      tb.appendChild(tr);
    } else {
      rows.forEach(r=>{
        const nombre = r.nombre || ('Usuario ' + (r.id ?? ''));
        const rol    = r.rol || '';
        const n  = Number(r.nuevo) || 0;
        const v  = Number(r.venta) || 0;
        const e  = Number(r.entrega) || 0;
        const re = Number(r.reconocimientos) || 0;
        const q  = Number(r.quejas) || 0;
        const f  = Number(r.faltas) || 0;
        const t  = Number(r.total) || (n+v+e);

        sNuevo+=n; sVenta+=v; sEntrega+=e; sRecon+=re; sQuejas+=q; sFaltas+=f; sTotal+=t;

        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${nombre}${rol ? `<span class="badge-rol">${rol}</span>`:''}</td>
          <td class="num"><span class="badge-mini">${n}</span></td>
          <td class="num"><span class="badge-mini">${v}</span></td>
          <td class="num"><span class="badge-mini badge-verde">${e}</span></td>
          <td class="num"><span class="badge-mini">${re}</span></td>
          <td class="num"><span class="badge-mini badge-rojo">${q}</span></td>
          <td class="num"><span class="badge-mini badge-ambar">${f}</span></td>
          <td class="num"><strong>${t}</strong></td>
        `;
        tb.appendChild(tr);
      });
    }

    if (tNuevo())   tNuevo().textContent   = sNuevo;
    if (tVenta())   tVenta().textContent   = sVenta;
    if (tEntrega()) tEntrega().textContent = sEntrega;
    if (tRecon())   tRecon().textContent   = sRecon;
    if (tQuejas())  tQuejas().textContent  = sQuejas;
    if (tFaltas())  tFaltas().textContent  = sFaltas;
    if (tTotal())   tTotal().textContent   = sTotal;
  }

  // ===== AJUSTE 2: POST JSON a MS_get_resumen_mes_asesores.php =====
  async function fetchResumen(yyyy_mm){
    try{
      const url = `https://mobilitysolutionscorp.com/web/MS_get_resumen_mes_asesores.php`;
      const payload = {
        user_id:   userId,
        user_type: userType,
        yyyymm:    yyyy_mm,
        solo_usuario: 0,
        include_jefe: 0
      };

      const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });

      const data = await res.json();
      if (data && data.success && Array.isArray(data.rows)) return data.rows;
      return [];
    } catch(e){
      console.error('Error al cargar resumen asesores:', e);
      return [];
    }
  }

  async function cargarMes(){
    const ym = yyyymm(curYear, curMonth);
    pintarMesLabel();
    const rows = await fetchResumen(ym);
    renderTabla(rows);
  }

  function goPrev(){ curMonth--; if (curMonth < 0){ curMonth = 11; curYear--; } cargarMes(); }
  function goNext(){ curMonth++; if (curMonth > 11){ curMonth = 0; curYear++; } cargarMes(); }

  document.addEventListener('DOMContentLoaded', ()=>{
    const prev = document.getElementById('mesPrev');
    const next = document.getElementById('mesNext');
    if (prev) prev.addEventListener('click', goPrev);
    if (next) next.addEventListener('click', goNext);
    cargarMes();
  });
})();
</script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3Z9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>
