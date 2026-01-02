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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="shortcut icon" href="../Imagenes/movility.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS específico de Home -->
    <link rel="stylesheet" href="../CSS/home.css">

    <!-- Bootstrap / jQuery / Chart.js -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>


    <!-- Font Awesome -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
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

        <ul class="navbar-nav ms-auto">

          <li class="nav-item active">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/Home.php">Inicio</a>
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

<!-- CONTENIDO PRINCIPAL -->
<main class="home-wrapper">

    <!-- ENCABEZADO TIPO REQUERIMIENTOS -->
    <section class="home-header">
        <div class="home-header-left">
            <h1 class="home-title">
                Hola, <?php echo $nombre . ' ' . $s_nombre . ' ' . $last_name; ?>
            </h1>
            <p class="home-subtitle">
                Panel general con: tareas, requerimientos, reconocimientos y métricas.
            </p>
        </div>

        <div class="home-header-right">
            <div class="user-pill">
                <div class="user-pill-main">
                    <span class="user-pill-name">
                        <?php echo $user_name_db ? $user_name_db : $user_name; ?>
                    </span>
                    <span class="user-pill-city">
                        Morelia, Michoacán · <?php echo $hora_actual; ?>
                    </span>
                </div>
                <div class="user-pill-roles">
                    <?php
                        $roles = [];
                        if ($r_ejecutivo)   $roles[] = "Asesor(a)";
                        if ($r_editor)      $roles[] = "Maestro catálogo";
                        if ($r_autorizador) $roles[] = "Supervisor(a)";
                        if ($r_analista)    $roles[] = "Analista";
                        echo implode(" · ", $roles);
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- LAYOUT 2 COLUMNAS (similar requerimientos: sidebar + contenido) -->
    <section class="home-layout">

        <!-- SIDEBAR IZQUIERDA -->
        <aside class="home-sidebar">

            <!-- PERFIL -->
            <article class="home-card card-profile">

                <div class="profile-block">
                    <form id="uploadForm" action="../db_consultas/upload_photo.php" method="POST" enctype="multipart/form-data">
                        <label for="profilePicInput" class="profile-image-wrapper">
                            <img src="../Imagenes/Usuarios/<?php echo $user_id; ?>.jpg?<?php echo time(); ?>"
                                 alt="Foto de perfil" class="profile-image">
                            <div class="edit-icon-overlay">✎</div>
                        </label>
                        <input type="file" id="profilePicInput" name="profilePic" style="display:none;"
                               onchange="document.getElementById('uploadForm').submit();">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    </form>

                    <div class="profile-meta">
                        <div class="profile-name">
                            <?php echo $nombre . ' ' . $s_nombre; ?>
                        </div>
                        <div class="profile-role-line">
                            <?php echo implode(" · ", $roles); ?>
                        </div>
                    </div>
                </div>

                <div class="edit-profile-wrapper">
                    <a href="#" class="edit-button" onclick="openModal()">Editar perfil</a>
                </div>
            </article>

            <!-- TAREAS & CUMPLEAÑOS -->
            <article class="home-card card-activity">
                <div class="card-header-row">
                    <h2 class="card-title">Menú de actividades</h2>
                </div>

                <div class="activity-row">
                    <div class="activity-item">
                        <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/tareas.php">
                            <div class="circulo-tareas">
                                <span id="cantidad-tareas">0</span>
                            </div>
                        </a>
                        <div class="texto-tareas">Tareas en curso</div>
                    </div>

                    <div class="activity-item cumple-click" id="cumpleTrigger" title="Cumpleaños este mes">
                        <div class="cake-icon">
                            <img src="../Imagenes/cupcake.png" alt="Cumpleaños" class="cake-img">
                            <span id="cumple-count" class="cake-count-badge">0</span>
                        </div>
                        <div class="texto-tareas">Cumpleaños del equipo</div> 
                    </div>

                </div>
            </article>

            <!-- RESUMEN MENSUAL POR ASESOR (MOVIDO AQUÍ) -->
            <article class="home-card mes-actividad-card">
                <div class="mes-actividad-head">
                    <div class="mes-actividad-title">Seguimiento del mes por asesor</div>
                    <div class="mes-actividad-controls">
                        <button id="mesPrev" type="button" class="mes-ctrl-btn" aria-label="Mes anterior">‹</button>
                        <span id="mesLabel" class="mes-actividad-label">—</span>
                        <button id="mesNext" type="button" class="mes-ctrl-btn" aria-label="Mes siguiente">›</button>
                    </div>
                </div>
                <div class="mes-actividad-subtle">
                    Totales del mes seleccionado (Con su jerarquía).
                </div>

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
                        <tbody></tbody>
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
            </article>


        </aside>

        <!-- COLUMNA DERECHA (contenido principal estilo requerimientos) -->
        <section class="home-main">

            <!-- MÉTRICAS PRINCIPALES -->
            <article class="home-card card-metrics">
                <div class="card-header-row">
                    <p class="card-subtitle">
                        Totales del año actual · clic en cada hexágono para ver el detalle.
                    </p>
                </div>

                <div class="metrics-top">
                    <div class="hex-container">
                        <div class="hex" id="hex-nuevo">
                            <span>Nuevos</span>
                            <strong>0</strong>
                        </div>
                        <div class="hex" id="hex-reserva">
                            <span>Ventas</span>
                            <strong>0</strong>
                        </div>
                        <div class="hex" id="hex-entrega">
                            <span>Entregas</span>
                            <strong>0</strong>
                        </div>
                    </div>

                    <div class="hex-honey">
                        <a class="mini-hex quejas" href="https://mobilitysolutionscorp.com/Views/asignacion.php">
                            <span>Quejas</span>
                            <strong id="hc-quejas">0</strong>
                        </a>
                        <a class="mini-hex inasistencias" href="https://mobilitysolutionscorp.com/Views/asignacion.php">
                            <span>Faltas</span>
                            <strong id="hc-inasistencias">0</strong>
                        </a>
                    </div>
                </div>
            </article>

            <!-- GRÁFICAS -->
            <article class="home-card card-chart">
                <div class="chart-wrapper">
                    <canvas id="lineChart"></canvas>
                    <canvas id="gaugeChart"></canvas>
                </div>
            </article>

            <!-- RECONOCIMIENTOS (se rellena por JS) -->
            <section class="home-card skills-section">
                <h2>Reconocimientos</h2>
                <div id="reconocimientosWrapper" class="reconocimientos-wrapper">
                    <p class="placeholder">Aquí aparecerán los reconocimientos otorgados al usuario.</p>
                </div>
            </section>
        </section>
    </section>
</main>

<!-- MODAL EDICIÓN PERFIL -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Editar información</h2>
        <form id="editForm">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $email; ?>" required>

            <label>Fecha de Cumpleaños:</label>
            <input type="date" name="cumpleanos" value="<?php echo $cumpleanos; ?>" required>

            <label>Teléfono:</label>
            <input type="text" name="telefono" value="<?php echo $telefono; ?>" required>

            <button type="submit">Guardar cambios</button>
        </form>
    </div>
</div>

<!-- MODAL CUMPLEAÑOS -->
<div id="cumpleModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeCumpleModal()">&times;</span>
        <h2 id="cumpleTituloMes">Cumpleaños</h2>
        <ul id="cumpleLista" class="cumple-lista"></ul>
    </div>
</div>

<!-- ========================== -->
<!-- JS: RECOMPENSAS / PUNTOS   -->
<!-- ========================== -->
<script>
window.rew = {
  quejas: 0,
  inasistencias: 0,
  entregas: 0,
  reservas: 0,
  reconocimientos: 0,
  metas: [20, 40, 80, 100],
  max: 100
};

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

window.renderRewards = function () {
  const pts = window.computeRewardPoints();
  const maxPts = window.rew.max;

  const fill    = document.getElementById("rewards-fill");
  const ptsEl   = document.getElementById("pts-actuales");
  const nextEl  = document.getElementById("rewards-next");
  const markersWrap = document.getElementById("rewards-markers");

  if (ptsEl) ptsEl.textContent = pts;
  if (fill)  fill.style.width = (pts / maxPts * 100) + "%";

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

<!-- ========================== -->
<!-- JS: TAREAS EN CURSO       -->
<!-- ========================== -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const userId = <?php echo $user_id; ?>;

  fetch(`https://mobilitysolutionscorp.com/web/MS_get_tareas.php?user_id=${userId}`)
    .then(res => res.json())
    .then(data => {
      if (data.success && Array.isArray(data.tareas)) {
        const tareasEnCurso = data.tareas.filter(t => t.status != 4);
        const spanT = document.getElementById("cantidad-tareas");
        if (spanT) spanT.textContent = tareasEnCurso.length;
      }
    })
    .catch(error => {
      console.error("Error al cargar tareas en curso:", error);
    });
});
</script>

<!-- ========================== -->
<!-- JS: MODAL PERFIL / CUMPLE -->
<!-- ========================== -->
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

window.onclick = function(event) {
    const modal       = document.getElementById("editModal");
    const cumpleModal = document.getElementById("cumpleModal");
    if (event.target === modal)       modal.style.display = "none";
    if (event.target === cumpleModal) cumpleModal.style.display = "none";
};
</script>

<!-- ========================== -->
<!-- JS: RECONOCIMIENTOS       -->
<!-- ========================== -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const userId = <?php echo $user_id; ?>;

  fetch(`https://mobilitysolutionscorp.com/web/MS_get_reconocimientos.php?asignado=${userId}`)
    .then(response => response.json())
    .then(data => {
      const contenedorSkills = document.querySelector(".skills-section");
      contenedorSkills.innerHTML = "<h2>Reconocimientos</h2>";

      const puntosPorTipo = {1: 2, 2: 2, 3: 2};
      const lista = (data && Array.isArray(data.reconocimientos)) ? data.reconocimientos : [];
      const totalPuntos = lista.reduce((acc, item) => {
        const tipo = parseInt(item.tipo, 10);
        return acc + (puntosPorTipo[tipo] || 0);
      }, 0);

      window.rew.reconocimientos = totalPuntos;

      const metas = [
        { pts: 50, nombre: "Tarjeta Amazon" },
        { pts: 80, nombre: "Premio esp." },
        { pts: 100, nombre: "Viaje Playa" }
      ];
      const maxPts = 100;
      window.rew.max = maxPts;
      window.rew.metas = metas.map(m => m.pts);

      const siguiente = metas.find(m => totalPuntos < m.pts);
      const textoSiguiente = siguiente
        ? `Siguiente: Premio ${metas.indexOf(siguiente) + 2} a ${siguiente.pts} pts`
        : `¡Todos los premios conseguidos!`;

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
          <div class="rewards-fill" id="rewards-fill"></div>
          <div class="rewards-markers" id="rewards-markers"></div>
        </div>

        <div class="rewards-legend">
          <span>
            2 (Desempeño) · 2 (Seguimiento) <br> 
            2 (Innovación) · 1 (Ventas) <br> 
            4 (Entregas) <br> 
            <span class="neg">-2 (Faltas)</span> · <span class="neg">-3 (Quejas)</span>
          </span>
          <span class="next" id="rewards-next">${textoSiguiente}</span>
        </div>
      `;
      contenedorSkills.appendChild(rewardsWrapper);

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

      window.renderRewards();

      const NOMBRES_TIPO = { 1: "Desempeño", 2: "Seguimiento", 3: "Innovación" };
      const CLASE_TIPO   = { 1: "recono-desempeno", 2: "recono-liderazgo", 3: "recono-innovacion" };

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
        const totalPtsGrupo = items.length * (puntosPorTipo[tipo] || 0);

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
            if (item.descripcion) tile.setAttribute("title", item.descripcion);
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

<!-- ========================== -->
<!-- JS: QUEJAS / INASISTENCIAS -->
<!-- ========================== -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const userId = <?php echo $user_id; ?>;

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

  fetch("https://mobilitysolutionscorp.com/web/MS_queja_get.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ usuario: userId })
  })
  .then(r => r.json())
  .then(data => {
    const count = extraerConteo(data, "quejas");
    actualizarContadores(["#hc-quejas"], count);
    window.rew.quejas = count;
    window.renderRewards();
  })
  .catch(() => actualizarContadores(["#hc-quejas"], 0));

  fetch("https://mobilitysolutionscorp.com/web/MS_inasistencia_get.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ usuario: userId })
  })
  .then(r => r.json())
  .then(data => {
    const count = extraerConteo(data, "inasistencias");
    actualizarContadores(["#hc-inasistencias"], count);
    window.rew.inasistencias = count;
    window.renderRewards();
  })
  .catch(() => actualizarContadores(["#hc-inasistencias"], 0));
});
</script>

<!-- ========================== -->
<!-- JS: CUMPLEAÑEROS          -->
<!-- ========================== -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const pastelBtn = document.getElementById("cumpleTrigger");
  if (pastelBtn) pastelBtn.addEventListener("click", openCumpleModal);

  fetch("https://mobilitysolutionscorp.com/web/MS_get_cumples_mes.php")
    .then(res => res.json())
    .then(data => {
      const lista = (data && Array.isArray(data.cumpleaneros)) ? data.cumpleaneros : [];
      const conteo = data.count || lista.length || 0;

      const countEl = document.getElementById("cumple-count");
      if (countEl) countEl.textContent = conteo;

      const tituloMes = document.getElementById("cumpleTituloMes");
      if (tituloMes && data.mes) {
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

<!-- ========================== -->
<!-- JS: HEX / GRÁFICA / METAS -->
<!-- ========================== -->
<script>
function toInt(v){ const n = Number(v); return Number.isFinite(n) ? n : 0; }

const userId   = <?php echo $user_id; ?>;
const userType = <?php echo $user_type; ?>;

let datosPorMes = [];
let metasPorTipo = {
  1: Array(12).fill(0), // Nuevos
  2: Array(12).fill(0), // Ventas
  3: Array(12).fill(0), // Entregas
};

let totalNuevo = 0, totalReserva = 0, totalEntrega = 0;
let lineChart = null;   // sigue llamándose lineChart, pero ahora es BAR chart

/* --------- CHART: ahora de BARRAS --------- */
function initLineChart() {
  const canvas = document.getElementById('lineChart');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');

  // Registrar plugin de datalabels si está disponible
  if (window.ChartDataLabels) {
    try { Chart.register(window.ChartDataLabels); } catch (e) {}
  }

  lineChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
      datasets: [
        {
          label: 'Acumulado',
          data: Array(12).fill(0),
          backgroundColor: '#EAB308',              // amarillo principal
          borderRadius: 6,
          maxBarThickness: 26,
        },
        {
          label: 'Meta',
          data: Array(12).fill(0),
          backgroundColor: 'rgba(31,41,55,0.35)', // gris oscuro suave
          borderRadius: 6,
          maxBarThickness: 26,
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: {
        mode: 'index',
        intersect: false
      },
      plugins: {
        legend: {
          display: true,
          position: 'top',
          labels: {
            font: { size: 11 }
          }
        },
        tooltip: {
          enabled: true,
          mode: 'index',
          intersect: false
        },
        // AQUÍ configuramos que se vean los valores
        datalabels: {
          anchor: 'end',        // en la punta de la barra
          align: 'top',         // un poco arriba
          offset: 2,
          color: '#111827',     // texto gris oscuro (combina con el NAV)
          font: {
            weight: '700',
            size: 10
          },
          formatter: function(value) {
            const v = Number(value);
            return Number.isFinite(v) ? v : '';
          }
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: { font: { size: 11 } }
        },
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 5,
            font: { size: 11 }
          },
          grid: {
            color: 'rgba(15,23,42,0.06)'
          }
        }
      }
    }
  });
}

/* Actualiza datos de la gráfica (ahora barras Acumulado vs Meta) */
function actualizarGrafica(tipo) {
  if (!lineChart) return;

  const valores = datosPorMes.map(mes => toInt(mes[tipo]));
  const tipoMeta = { 'New': 1, 'Reserva': 2, 'Entrega': 3 }[tipo];
  const metas    = (metasPorTipo[tipoMeta] || Array(12).fill(0)).map(toInt);

  const labelActual = {
    'New': 'Nuevos por mes',
    'Reserva': 'Ventas por mes',
    'Entrega': 'Entregas por mes'
  }[tipo];

  // Dataset 0 = Acumulado
  lineChart.data.datasets[0].data  = valores;
  lineChart.data.datasets[0].label = labelActual;

  // Dataset 1 = Meta
  lineChart.data.datasets[1].data  = metas;
  // label "Meta" se mantiene

  lineChart.update();

  // Marcar hexágono activo
  document.querySelectorAll('.hex').forEach(h => h.classList.remove('active'));
  const hexMap = { 'New': '#hex-nuevo', 'Reserva': '#hex-reserva', 'Entrega': '#hex-entrega' };
  const hexSel = hexMap[tipo];
  if (hexSel) {
    const el = document.querySelector(hexSel);
    if (el) el.classList.add('active');
  }
}

/* Gauge/KPI de Entregas (se queda igual, solo usa los totales) */
function renderGaugeEntrega() {
  const wrap       = document.querySelector('.chart-wrapper');
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

/* Mostrar barras (antes showLine) */
function showLine(tipo) {
  const kpi = document.getElementById('entregaKPI');
  if (kpi) kpi.style.display = 'none';

  const gaugeCanvas = document.getElementById('gaugeChart');
  const barCanvas   = document.getElementById('lineChart');
  if (gaugeCanvas) gaugeCanvas.style.display = 'none';
  if (barCanvas)   barCanvas.style.display   = 'block';

  if (!lineChart) initLineChart();
  actualizarGrafica(tipo);
}

/* Carga de datos, metas y wiring de hexágonos */
document.addEventListener("DOMContentLoaded", () => {
  initLineChart();

  fetch('https://mobilitysolutionscorp.com/db_consultas/hex_status.php?user_id=' + userId)
    .then(r => r.json())
    .then(data => {
      datosPorMes = Array.isArray(data) ? data : [];

      totalNuevo = 0; 
      totalReserva = 0; 
      totalEntrega = 0;

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

      // Vista inicial: Ventas por mes (barras)
      showLine('Reserva');

      return fetch('https://mobilitysolutionscorp.com/web/MS_get_metas_usuario.php?asignado=' + userId);
    })
    .then(r => r.json())
    .then(data => {
      if (data && data.success && Array.isArray(data.metas)) {
        data.metas.forEach(meta => {
          const t = toInt(meta.tipo_meta);
          metasPorTipo[t] = [
            toInt(meta.enero),      toInt(meta.febrero),   toInt(meta.marzo),
            toInt(meta.abril),      toInt(meta.mayo),      toInt(meta.junio),
            toInt(meta.julio),      toInt(meta.agosto),    toInt(meta.septiembre),
            toInt(meta.octubre),    toInt(meta.noviembre), toInt(meta.diciembre)
          ];
        });
      }

      const gauge = document.getElementById('gaugeChart');
      const visible = gauge && getComputedStyle(gauge).display !== 'none';
      if (visible) {
        renderGaugeEntrega();
      } else {
        showLine('Reserva');
      }
    })
    .catch(err => console.error('Error al obtener datos/metas:', err));

  const hexN = document.getElementById('hex-nuevo');
  const hexR = document.getElementById('hex-reserva');
  const hexE = document.getElementById('hex-entrega');

  if (hexN) hexN.addEventListener('click', () => showLine('New'));      // barras Nuevos vs Meta
  if (hexR) hexR.addEventListener('click', () => showLine('Reserva'));  // barras Ventas vs Meta
  if (hexE) hexE.addEventListener('click', () => renderGaugeEntrega()); // KPI Entregas
});
</script>

<!-- ========================== -->
<!-- JS: RESUMEN MES ASESOR    -->
<!-- ========================== -->
<script>
(function(){
  const userId   = <?php echo $user_id; ?>;
  const userType = <?php echo $user_type; ?>;

  const lbl      = () => document.getElementById('mesLabel');
  const tbody    = () => document.querySelector('#tablaMes tbody');
  const tNuevo   = () => document.getElementById('tNuevo');
  const tVenta   = () => document.getElementById('tVenta');
  const tEntrega = () => document.getElementById('tEntrega');
  const tRecon   = () => document.getElementById('tRecon');
  const tQuejas  = () => document.getElementById('tQuejas');
  const tFaltas  = () => document.getElementById('tFaltas');
  const tTotal   = () => document.getElementById('tTotal');

  const start = new Date();
  let curYear  = start.getFullYear();
  let curMonth = start.getMonth();         // 0 = Enero

  const MES_NOMBRES = [
    'Enero','Febrero','Marzo','Abril','Mayo','Junio',
    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
  ];

  let currentRows = [];
  let sortCol  = 'total';
  let sortDir  = 'desc';
  const colKeys = [
    'nombre',
    'nuevo',
    'venta',
    'entrega',
    'reconocimientos',  // la columna Recon. ahora mostrará puntos
    'quejas',
    'faltas',
    'total'
  ];
  let headerIndicators = [];

  // Cache: año -> { userId: puntosAnuales }
  const reconYearCache = {};

  // Pesos del sistema de recompensas
  const PTS_RECON   = 2;   // por cada reconocimiento
  const PTS_VENTA   = 1;
  const PTS_ENTREGA = 4;
  const PTS_FALTA   = -2;
  const PTS_QUEJA   = -3;

  function pad2(n){ return String(n).padStart(2,'0'); }
  function yyyymm(y,m){ return `${y}-${pad2(m+1)}`; }

  function pintarMesLabel(){
    const el = lbl();
    if (el) el.textContent = `${MES_NOMBRES[curMonth]} ${curYear}`;
  }

  // Calcula los puntos del mes para una fila (mismo criterio que la barra de recompensas)
  function computePuntosMes(row){
    const v   = Number(row.venta)           || 0;
    const e   = Number(row.entrega)         || 0;
    const reC = Number(row.reconocimientos) || 0; // cantidad de reconocimientos, no puntos
    const q   = Number(row.quejas)          || 0;
    const f   = Number(row.faltas)          || 0;

    const rePts = reC * PTS_RECON;
    const pts = (e * PTS_ENTREGA) + (v * PTS_VENTA) + rePts
              + (f * PTS_FALTA) + (q * PTS_QUEJA);
    return pts;
  }

  function getPuntosAnuales(uid){
    const yearKey = String(curYear);
    const mapa = reconYearCache[yearKey] || {};
    const val = mapa[uid];
    return typeof val === 'number' ? val : 0;
  }

  function getCellValue(row, key){
    if (key === 'nombre'){
      return (row.nombre || '').toString().toLowerCase();
    }
    if (key === 'total'){
      const totalApi = Number(row.total);
      if (Number.isFinite(totalApi)) return totalApi;
      const n = Number(row.nuevo)  || 0;
      const v = Number(row.venta)  || 0;
      const e = Number(row.entrega)|| 0;
      return n + v + e;
    }
    if (key === 'reconocimientos'){
      // Ordenamos por puntos del mes
      return computePuntosMes(row);
    }
    return Number(row[key]) || 0;
  }

  function applySortAndRender(){
    if (!Array.isArray(currentRows)) {
      renderTabla([]);
      return;
    }

    currentRows.sort((a,b)=>{
      const key = sortCol;
      let va = getCellValue(a,key);
      let vb = getCellValue(b,key);

      if (key === 'nombre'){
        return sortDir === 'asc'
          ? String(va).localeCompare(String(vb),'es',{sensitivity:'base'})
          : String(vb).localeCompare(String(va),'es',{sensitivity:'base'});
      } else {
        va = Number(va) || 0;
        vb = Number(vb) || 0;
        return sortDir === 'asc' ? (va - vb) : (vb - va);
      }
    });

    renderTabla(currentRows);
    updateSortIndicators();
  }

  function updateSortIndicators(){
    const ths = document.querySelectorAll('#tablaMes thead th');
    ths.forEach((th, idx)=>{
      const span = headerIndicators[idx];
      const key  = colKeys[idx];
      if (!span || !key) return;

      if (key === sortCol){
        span.textContent = (sortDir === 'asc') ? '▲' : '▼';
      } else {
        span.textContent = '';
      }
    });
  }

  function renderTabla(rows){
    const tb = tbody(); 
    if (!tb) return;
    tb.innerHTML = '';

    let sNuevo=0, sVenta=0, sEntrega=0, sPtsMes=0, sQuejas=0, sFaltas=0, sTotal=0;

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
        const uid    = Number(r.id || r.user_id || 0);

        const n   = Number(r.nuevo)           || 0;
        const v   = Number(r.venta)           || 0;
        const e   = Number(r.entrega)         || 0;
        const q   = Number(r.quejas)          || 0;
        const f   = Number(r.faltas)          || 0;

        const ptsMes  = computePuntosMes(r);      // puntos del mes
        const ptsAnio = getPuntosAnuales(uid);    // puntos acumulados del año

        const t   = Number(r.total) || (n+v+e);

        sNuevo   += n;
        sVenta   += v;
        sEntrega += e;
        sPtsMes  += ptsMes;
        sQuejas  += q;
        sFaltas  += f;
        sTotal   += t;

        const reconTexto = `${ptsMes}/${ptsAnio}`;

        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${nombre}${rol ? `<span class="badge-rol">${rol}</span>`:''}</td>
          <td class="num"><span class="badge-mini">${n}</span></td>
          <td class="num"><span class="badge-mini">${v}</span></td>
          <td class="num"><span class="badge-mini badge-verde">${e}</span></td>
          <td class="num"><span class="badge-mini">${reconTexto}</span></td>
          <td class="num"><span class="badge-mini badge-rojo">${q}</span></td>
          <td class="num"><span class="badge-mini badge-ambar">${f}</span></td>
          <td class="num"><strong>${t}</strong></td>
        `;
        tb.appendChild(tr);
      });
    }

    // Pie de totales: Recon. = suma de puntos del mes
    if (tNuevo())   tNuevo().textContent   = sNuevo;
    if (tVenta())   tVenta().textContent   = sVenta;
    if (tEntrega()) tEntrega().textContent = sEntrega;
    if (tRecon())   tRecon().textContent   = sPtsMes;
    if (tQuejas())  tQuejas().textContent  = sQuejas;
    if (tFaltas())  tFaltas().textContent  = sFaltas;
    if (tTotal())   tTotal().textContent   = sTotal;
  }

  // Llamada al endpoint para un mes
  async function fetchResumen(yyyy_mm){
    try{
      const url = `https://mobilitysolutionscorp.com/web/MS_get_resumen_mes_asesores.php`;
      const payload = {
        user_id:      userId,
        user_type:    userType,
        yyyymm:       yyyy_mm,
        solo_usuario: 0,
        include_jefe: 0
      };

      const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type':'application/json' },
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

  // Construye el total ANUAL de puntos por usuario (enero–diciembre)
  // usando el MISMO endpoint mes a mes (sin modificar backend).
  async function buildReconAnual(year){
    const yearKey = String(year);
    if (reconYearCache[yearKey]) return reconYearCache[yearKey];

    const acumulado = {};

    for (let m = 0; m < 12; m++){
      const ym = yyyymm(year, m);
      const rowsMes = await fetchResumen(ym);

      rowsMes.forEach(r => {
        const uid = Number(r.id || r.user_id || 0);
        if (!uid) return;

        const ptsMes = computePuntosMes(r);

        if (!Object.prototype.hasOwnProperty.call(acumulado, uid)){
          acumulado[uid] = 0;
        }
        acumulado[uid] += ptsMes;
      });
    }

    reconYearCache[yearKey] = acumulado;
    return acumulado;
  }

  async function cargarMes(){
    const ym = yyyymm(curYear, curMonth);
    pintarMesLabel();

    // Primero aseguramos que ya tengamos los puntos anuales de ese año
    await buildReconAnual(curYear);

    // Luego cargamos el mes a mostrar
    const rows = await fetchResumen(ym);
    currentRows = Array.isArray(rows) ? rows.slice() : [];
    applySortAndRender();
  }

  function goPrev(){
    curMonth--;
    if (curMonth < 0){
      curMonth = 11;
      curYear--;
    }
    cargarMes();
  }

  function goNext(){
    curMonth++;
    if (curMonth > 11){
      curMonth = 0;
      curYear++;
    }
    cargarMes();
  }

  document.addEventListener('DOMContentLoaded', ()=>{
    const prev = document.getElementById('mesPrev');
    const next = document.getElementById('mesNext');
    if (prev) prev.addEventListener('click', goPrev);
    if (next) next.addEventListener('click', goNext);

    const ths = document.querySelectorAll('#tablaMes thead th');
    headerIndicators = [];

    ths.forEach((th, idx)=>{
      const key = colKeys[idx];
      if (!key) return;

      th.classList.add('sortable');
      const span = document.createElement('span');
      span.className = 'sort-indicator';
      th.appendChild(span);
      headerIndicators[idx] = span;

      th.addEventListener('click', ()=>{
        if (sortCol === key){
          sortDir = (sortDir === 'asc') ? 'desc' : 'asc';
        } else {
          sortCol = key;
          sortDir = (key === 'nombre') ? 'asc' : 'desc';
        }
        applySortAndRender();
      });
    });

    // Carga inicial
    cargarMes();
  });
})();
</script>


</body>
</html>
