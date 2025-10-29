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
  /* se colocan debajo y "embonados" entre los 3 hex grandes */
  display:flex;
  justify-content:center;
  align-items:center;
  gap: 120px;              /* separación horizontal entre los dos mini-hex */
  margin-top: -28px;       /* los sube un poco para que embonen */
  margin-bottom: 12px;
}

.mini-hex{
  width: 90px;             /* más chico que los 120px de los grandes */
  height: 78px;            /* proporción del hex para que embone visualmente */
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
  height: 260px !important;     /* ajusta a gusto (240–360px) */
}

.chart-wrapper{ position: relative; }

#gaugeChart{
  display: none;
  width: 100%;
  height: 300px;              /* NO 100% */
  aspect-ratio: 1 / 1;       /* cuadrado */
  transform: none !important;
  -webkit-clip-path: none !important;
  clip-path: none !important;
}

/* ===== KPI Entregas (versión compacta) ===== */
.entrega-kpi{
  position: relative;
  display: flex; align-items: center; justify-content: center;
  gap: 12px; padding: 0; margin: 0 auto;
  max-width: 620px;          /* <— más chico */
}

.entrega-kpi .left{
  display: flex; flex-direction: column; align-items: flex-end;
  gap: 6px; min-width: 200px;  /* <— más chico */
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
  gap: 6px;                   /* “Meta” arriba de la línea */
}

.entrega-kpi .hline{
  height: 4px;
  width: clamp(110px, 14vw, 170px);  /* <— línea más corta */
  background: #0b7285;
  border-radius: 4px;
  box-shadow: 0 1px 2px rgba(0,0,0,.2);
}

.entrega-kpi .divider{
  width: 6px; min-height: 120px;     /* <— más delgado y bajo */
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

/* Colores por tipo (alineados con tus cápsulas anteriores) */
.mini-hex.quejas{ background:#ff6b6b; }
.mini-hex.inasistencias{ background:#ff6b6b; }

/* Responsivo: si la pantalla es angosta, que no se solapen */
@media (max-width: 768px){
  .hex-honey{
    gap: 40px;
    margin-top: 6px;     /* no los “metas” en pantallas chicas */
  }
  .mini-hex{ width:82px; height:70px; }
}

/* ===== Override modales personalizados (editar perfil y cumpleaños) ===== */

/* Fondo oscuro pantalla completa */
#editModal.modal,
#cumpleModal.modal {
  display: none;               /* se muestra con JS */
  position: fixed;
  inset: 0;                    /* top/right/bottom/left:0 */
  z-index: 9999;
  background-color: rgba(0,0,0,0.55);  /* overlay oscuro */
  padding: 40px 16px;          /* respeta espacio arriba/abajo */
  overflow-y: auto;
}

/* Tarjeta interna centrada */
#editModal .modal-content,
#cumpleModal .modal-content {
  background-color: #fff;
  margin: 0 auto;              /* centrar */
  width: 100%;
  max-width: 400px;            /* <-- ESTA ES LA MAGIA: modal pequeñito */
  border-radius: 10px;
  border: 1px solid #888;
  box-shadow: 0 20px 40px rgba(0,0,0,0.2);
  padding: 24px 24px 20px;
  position: relative;
}

/* Header del modal de cumple */
#cumpleModal .modal-content h2,
#editModal .modal-content h2 {
  margin-top: 0;
  text-align: center;
  font-size: 20px;
  font-weight: 600;
  color: #111;
}

/* Botón X */
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

/* Lista de cumpleañeros en el modal */
#cumpleModal #cumpleLista {
  list-style: none;
  padding-left: 0;
  margin-top: 16px;
  max-height: 220px;
  overflow-y: auto;
  font-size: 14px;
  line-height: 1.4;
}

#cumpleModal #cumpleLista li {
  margin-bottom: 8px;
}


</style>


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

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/edicion_catalogo.php">Catálogo</a>
          </li>

         <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/requerimientos.php">Requerimientos</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/tareas.php">Tareas</a>
          </li>

          <li class="nav-item">
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

<div class="flex-container">
    <!-- Perfil izquierdo -->
    <div class="container_1">
        <h1><?php echo $nombre . ' ' . $s_nombre . ' ' . $last_name; ?></h1>

        <div class="profile-header">
            <!-- Imagen de perfil con formulario -->
            <form id="uploadForm" action="../db_consultas/upload_photo.php" method="POST" enctype="multipart/form-data">
                <label for="profilePicInput" class="profile-image-wrapper">
                    <img src="../Imagenes/Usuarios/<?php echo $user_id; ?>.jpg?<?php echo time(); ?>" alt="Foto de perfil" class="profile-image" title="Haz clic para cambiar tu foto">
                    <div class="edit-icon-overlay">
                        ✎
                    </div>
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
  <!-- cápsula de tareas (igual que ya tenías) -->
          <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/tareas.php">
            <div class="circulo-tareas">
              <span id="cantidad-tareas">0</span>
            </div>
          </a>
          <div class="texto-tareas">Tareas en curso</div>

          <!-- pastel de cumpleaños -->
          <div class="cumple-cake-wrapper" id="cumpleTrigger" title="Cumpleaños este mes">
            <div class="cake-icon">
              <div class="cake-candle">
                <div class="candle-flame"></div>
              </div>
              <div class="cake-layer">
                <span id="cumple-count">0</span>
              </div>
            </div>
          </div>
        </div>


        <!-- 
        Indicadores de Reportes
        <div id="reportes-resumen" class="reportes-resumen">
          <a class="resumen-pill pill-quejas" href="https://mobilitysolutionscorp.com/Views/asignacion.php" title="Ver quejas">
            <div class="pill-circle">
              <span id="cantidad-quejas">0</span>
            </div>
            <div class="pill-text">Quejas</div>
          </a>
          
          <a class="resumen-pill pill-inasistencias" href="https://mobilitysolutionscorp.com/Views/asignacion.php" title="Ver inasistencias">
            <div class="pill-circle">
              <span id="cantidad-inasistencias">0</span>
            </div>
            <div class="pill-text">Inasistencias</div>
          </a>
        </div>
        -->

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
    </div>

    <!-- Panel derecho con hexágonos -->
    <div class="container_2">
        <div class="hex-container">
            <div class="hex" id="hex-nuevo">
                <span>Nuevo</span>
                <strong>0</strong>
            </div>
            <div class="hex" id="hex-reserva">
                <span>Venta</span>
                <strong>0</strong>
            </div>
            <div class="hex" id="hex-entrega">
                <span>Entrega</span>
                <strong>0</strong>
            </div>
        </div>

        <!-- MINI-HEXs en panal (quejas / inasistencias) -->
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

        <!-- Sección de Reconocimientos / Skills -->
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
    // número grande (entregas)
    ctx.font = '700 32px system-ui, -apple-system, Segoe UI, Roboto';
    ctx.fillStyle = '#0f172a';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(String(opts.text || ''), x, y);

    // subtítulo opcional (ej. "Entregas" o "%")
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
        const tareasEnCurso = data.tareas.filter(t => t.status != 4); // Excluye "Hecho"
        document.getElementById("cantidad-tareas").textContent = tareasEnCurso.length;
      }
    })
    .catch(error => {
      console.error("Error al cargar tareas en curso:", error);
    });

  // ====== CUMPLEAÑEROS DEL MES ======
  // Servicio requerido: /web/MS_get_cumples_mes.php
  // Esperado: { success:true, mes:"Octubre", cumpleaneros:[ {nombre:"Juan", dia:"05"}, ... ] }
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

    // Nuevo: abrir / cerrar modal de cumpleañeros
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

    // Cierre para modal de cumpleañeros sin tocar el anterior
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
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(response => response.text())
        .then(result => {
            alert(result); // puedes usar toast o modal también
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

  fetch(`https://mobilitysolutionscorp.com/web/MS_get_reconocimientos.php?asignado=${userId}`)
    .then(response => response.json())
    .then(data => {
      const contenedorSkills = document.querySelector(".skills-section");
      contenedorSkills.innerHTML = "<h2>Reconocimientos</h2>";

      // ====== Cálculo de puntos por tipo ======
      // tipo: 1 = Desempeño, 2 = Seguimiento, 3 = Innovación
      const puntosPorTipo = {1: 2, 2: 2, 3: 2};
      const lista = (data && Array.isArray(data.reconocimientos)) ? data.reconocimientos : [];
      const totalPuntos = lista.reduce((acc, item) => {
        const tipo = parseInt(item.tipo, 10);
        return acc + (puntosPorTipo[tipo] || 0);
      }, 0);

      window.rew.reconocimientos = totalPuntos;

      // ====== Configuración del termómetro ======
      const metas = [
        { pts: 35, nombre: "Tarjeta Amazon" },
        { pts: 55, nombre: "Bono especial" },
        { pts: 75, nombre: "Viaje anual" }
      ];
      const maxPts = 75;
      window.rew.max = maxPts;
      window.rew.metas = metas.map(m => m.pts);

      const siguiente = metas.find(m => totalPuntos < m.pts);
      const textoSiguiente = siguiente
        ? `Siguiente: Premio ${metas.indexOf(siguiente) + 2} a ${siguiente.pts} pts`
        : `¡Todos los premios conseguidos!`;

      // ====== Render del termómetro visual ======
      const rewardsWrapper = document.createElement("div");
      rewardsWrapper.className = "rewards-wrapper";
      rewardsWrapper.innerHTML = `
        <div class="rewards-head">
          <div class="rewards-title">Línea de recompensas</div>
          <div class="rewards-stats">
            Puntos: <strong id="pts-actuales">0</strong> / ${maxPts}
          </div>
        </div>

        <div class="rewards-bar">
          <div class="rewards-fill" id="rewards-fill" style="width:0%"></div>
          <div class="rewards-markers" id="rewards-markers"></div>
        </div>

        <div class="rewards-legend">
          <span>
            2 (Desempeño) · 2 (Seguimiento) · 2 (Innovación)<br>
            1 (Ventas) · 4 (Entregas) · <span class="neg">-2 (Faltas)</span> · <span class="neg">-3 (Quejas)</span>
          </span>
          <span class="next" id="rewards-next">${textoSiguiente}</span>
        </div>
      `;
      contenedorSkills.appendChild(rewardsWrapper);

      // Marcadores en la barra
      const markers = document.getElementById("rewards-markers");
      metas.forEach((m) => {
        const left = (m.pts / maxPts) * 100;
        const marker = document.createElement("div");
        marker.className = "rewards-marker";
        marker.style.left = `${left}%`;
        marker.innerHTML = `
          <div class="dot"></div>
          <div class="label">${m.nombre}<br>${m.pts} pts</div>
        `;
        markers.appendChild(marker);
      });

      // Llenar barra y texto de puntos usando tu helper global
      window.renderRewards();

      // ====== Agrupar reconocimientos por tipo (1,2,3) ======
      const NOMBRES_TIPO = { 1: "Desempeño", 2: "Seguimiento", 3: "Innovación" };
      const CLASE_TIPO   = { 1: "recono-desempeno", 2: "recono-liderazgo", 3: "recono-innovacion" };
      const PUNTOS_TIPO  = { 1: 2, 2: 2, 3: 2 };

      const tiposOrden = [1, 2, 3];
      const grupos = { 1: [], 2: [], 3: [] };

      lista.forEach(it => {
        const t = parseInt(it.tipo, 10);
        if (grupos[t]) grupos[t].push(it);
      });

      const groupsWrap = document.createElement("div");
      groupsWrap.className = "rec-groups";

      tiposOrden.forEach((tipo, idx) => {
        const items = grupos[tipo];
        const totalPtsGrupo = items.length * (PUNTOS_TIPO[tipo] || 0);

        const card = document.createElement("div");
        card.className = "rec-group" + (idx === 0 ? " open" : "");

        const header = document.createElement("div");
        header.className = "rec-group__header";
        header.innerHTML = `
          <div class="rec-group__left">
            <span class="rec-group__title">${NOMBRES_TIPO[tipo]}</span>
            <span class="rec-group__badge">${items.length}</span>
          </div>
          <div class="rec-group__right">
            <span class="rec-group__points">${totalPtsGrupo} pts</span>
            <span class="rec-group__chev">▶</span>
          </div>
        `;
        header.addEventListener("click", () => card.classList.toggle("open"));

        const body = document.createElement("div");
        body.className = "rec-group__body";

        if (items.length > 0) {
          const grid = document.createElement("div");
          grid.className = "rec-grid";

          items.forEach(item => {
            const tile = document.createElement("div");
            tile.className = `reconocimiento-item ${CLASE_TIPO[tipo]}`;

            // 👇 AQUI el tooltip con la descripción
            //    usamos title="" nativo del browser
            if (item.descripcion) {
              tile.setAttribute("title", item.descripcion);
            }

            tile.innerHTML = `
              <div class="titulo">${item.reconocimiento}</div>
              <div class="fecha">${item.mes}/${item.anio}</div>
            `;
            grid.appendChild(tile);
          });

          body.appendChild(grid);
        } else {
          const empty = document.createElement("div");
          empty.className = "rec-empty";
          empty.textContent = `No hay reconocimientos de ${NOMBRES_TIPO[tipo].toLowerCase()}.`;
          body.appendChild(empty);
        }

        card.appendChild(header);
        card.appendChild(body);
        groupsWrap.appendChild(card);
      });

      contenedorSkills.appendChild(groupsWrap);
    })
    .catch(error => {
      console.error("Error al cargar reconocimientos:", error);
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

    // Intenta leer count, rows.length o un arreglo con nombre conocido
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
      // Solo después del primer dataset
      if (args.index !== 0) return;

      const { ctx } = chart;
      const meta = chart.getDatasetMeta(0);
      const arc  = meta.data[0];
      if (!arc) return;

      const cx = arc.x;
      const cy = arc.y;
      const r  = arc.outerRadius;

      const value  = Math.max(0, toInt(pluginOptions.value));
      const target = Math.max(1, toInt(pluginOptions.target)); // evita división por 0
      const capped = Math.min(value, target);

      // Ángulo en rango semicircular: rotation .. rotation + circumference
      const angle = chart.options.rotation + (capped / target) * chart.options.circumference;

      // Aguja
      ctx.save();
      ctx.translate(cx, cy);
      ctx.rotate(angle);
      ctx.beginPath();
      ctx.moveTo(0, 0);
      ctx.lineTo(r, 0);
      ctx.lineWidth = 3;
      ctx.strokeStyle = '#111827';
      ctx.stroke();
      // pivote
      ctx.beginPath();
      ctx.arc(0, 0, 5, 0, Math.PI * 2);
      ctx.fillStyle = '#111827';
      ctx.fill();
      ctx.restore();

      // Texto al centro: "valor / target"
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

    // resalta hex correspondiente
    document.querySelectorAll('.hex').forEach(h => h.classList.remove('active'));
    const hexMap = { 'New': '#hex-nuevo', 'Reserva': '#hex-reserva', 'Entrega': '#hex-entrega' };
    const hexSel = hexMap[tipo];
    if (hexSel) { const el = document.querySelector(hexSel); if (el) el.classList.add('active'); }
  }

  
function renderGaugeEntrega() {
  const wrap = document.querySelector('.chart-wrapper');
  const lineCanvas = document.getElementById('lineChart');

  // Oculta la línea
  if (lineCanvas) lineCanvas.style.display = 'none';

  // Crea o normaliza el KPI
  let kpi = document.getElementById('entregaKPI');
  if (!kpi) {
    kpi = document.createElement('div');
    kpi.id = 'entregaKPI';
    kpi.className = 'entrega-kpi';
    wrap.appendChild(kpi);
  }

  // Si la estructura vieja existe, la reemplazamos
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

  // Cálculos
  let meta = (metasPorTipo[3] || []).reduce((a,b)=>a + toInt(b), 0);
  if (!meta) meta = Math.max(toInt(totalEntrega), 1);

  const valor = toInt(totalEntrega);
  const pct   = Math.round((valor / meta) * 1000) / 10; // 1 decimal

  // Pinta valores
  document.getElementById('kpiMetaNum').textContent     = meta;
  document.getElementById('kpiEntregasNum').textContent = valor;
  document.getElementById('kpiPct').textContent         = pct;

  // Resalta hex de “Entrega”
  document.querySelectorAll('.hex').forEach(h => h.classList.remove('active'));
  const hexEntrega = document.getElementById('hex-entrega');
  if (hexEntrega) hexEntrega.classList.add('active');
}

function showLine(tipo) {
  const kpi = document.getElementById('entregaKPI');
  if (kpi) kpi.style.display = 'none';   // <— ocultar KPI

  const gaugeCanvas = document.getElementById('gaugeChart'); // ya no se usa, pero por si quedó
  const lineCanvas  = document.getElementById('lineChart');
  if (gaugeCanvas) gaugeCanvas.style.display = 'none';
  if (lineCanvas)  lineCanvas.style.display  = 'block';
  if (!lineChart) initLineChart();
  actualizarGrafica(tipo);
}


  // === FLUJO: inicializa y carga datos + metas ===
  initLineChart();

  // 1) Datos por mes (totales)
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

      // Totales en hex
      document.querySelector('#hex-nuevo strong').textContent   = totalNuevo;
      document.querySelector('#hex-reserva strong').textContent = totalReserva;
      document.querySelector('#hex-entrega strong').textContent = totalEntrega;

      // Recompensas
      if (window.rew) {
        window.rew.entregas = totalEntrega;
        window.rew.reservas = totalReserva;
        if (typeof window.renderRewards === 'function') window.renderRewards();
      }

      // Vista por defecto
      showLine('Reserva');

      // 2) Metas
      return fetch('https://mobilitysolutionscorp.com/web/MS_get_metas_usuario.php?asignado=' + userId);
    })
    .then(r => r.json())
    .then(data => {
      if (data && data.success && Array.isArray(data.metas)) {
        data.metas.forEach(meta => {
          const t = toInt(meta.tipo_meta); // 1,2,3
          metasPorTipo[t] = [
            toInt(meta.enero), toInt(meta.febrero), toInt(meta.marzo),
            toInt(meta.abril), toInt(meta.mayo), toInt(meta.junio),
            toInt(meta.julio), toInt(meta.agosto), toInt(meta.septiembre),
            toInt(meta.octubre), toInt(meta.noviembre), toInt(meta.diciembre)
          ];
        });
      }

      // (3) Si la DONA está visible, redibujarla con el target correcto
      const gauge = document.getElementById('gaugeChart');
      const visible = gauge && getComputedStyle(gauge).display !== 'none';
      if (visible) renderGaugeEntrega(); else showLine('Reserva');
    })
    .catch(err => console.error('Error al obtener datos/metas:', err));

  // Listeners una sola vez
  (function wireClicks(){
    const hexN = document.getElementById('hex-nuevo');
    const hexR = document.getElementById('hex-reserva');
    const hexE = document.getElementById('hex-entrega');
    if (hexN) hexN.addEventListener('click', () => showLine('New'));
    if (hexR) hexR.addEventListener('click', () => showLine('Reserva'));
    if (hexE) hexE.addEventListener('click', () => renderGaugeEntrega());
  })();

</script>



<script>
// Abrir / cerrar modal de cumpleaños
function openCumpleModal() {
  document.getElementById("cumpleModal").style.display = "block";
}
function closeCumpleModal() {
  document.getElementById("cumpleModal").style.display = "none";
}

// Click en el pastel
document.addEventListener("DOMContentLoaded", () => {
  const pastelBtn = document.getElementById("cumpleTrigger");
  if (pastelBtn) {
    pastelBtn.addEventListener("click", openCumpleModal);
  }
});

// Cerrar modal si hacen click afuera (extendemos tu lógica actual)
window.onclick = function(event) {
    const modal = document.getElementById("editModal");
    const cumpleModal = document.getElementById("cumpleModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
    if (event.target == cumpleModal) {
        cumpleModal.style.display = "none";
    }
};

// Fetch de cumpleañeros del mes
document.addEventListener("DOMContentLoaded", () => {

  fetch("https://mobilitysolutionscorp.com/web/MS_get_cumples_mes.php")
    .then(res => res.json())
    .then(data => {
      const lista = (data && Array.isArray(data.cumpleaneros)) ? data.cumpleaneros : [];
      const conteo = data.count || lista.length || 0;

      // número dentro del pastel morado
      const countEl = document.getElementById("cumple-count");
      if (countEl) {
        countEl.textContent = conteo;
      }

      // título del modal con el mes
      const tituloMes = document.getElementById("cumpleTituloMes");
      if (tituloMes && data.mes) {
        tituloMes.textContent = "Cumpleaños de " + data.mes;
      }

      // lista en el modal
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
            // ejemplo visual: "Juan Pérez — Día 05"
            li.textContent =
              (p.nombre ? p.nombre : "Sin nombre") +
              " — Día " +
              (p.dia ? p.dia : "--");
            ul.appendChild(li);
          });
        }
      }
    })
    .catch(err => {
      console.error("Error cumpleaños:", err);
    });

});
</script>


<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3Z9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>
