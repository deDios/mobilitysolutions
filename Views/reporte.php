<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>
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
        $user_id      = $row['user_id'];
        $_SESSION['user_id'] = $user_id;
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

        // Nombre completo
        $nombre_usuario = trim($nombre . " " . $s_nombre . " " . $last_name);

        // Título profesional
        $roles_activos = [];
        if ($r_ejecutivo == 1)   $roles_activos[] = "Ejecutivo";
        if ($r_editor == 1)      $roles_activos[] = "Editor";
        if ($r_autorizador == 1) $roles_activos[] = "Autorizador";
        if ($r_analista == 1)    $roles_activos[] = "Analista";

        if ($user_id == 4) {
            $titulo_profesional = "CEO - Mobility Solutions";
        } elseif ($user_id == 1 || $user_id == 18 || $user_id == 17) {
            $titulo_profesional = "CTO - Líder técnico";
        } else {
            $titulo_profesional = implode(" | ", $roles_activos);
        }
    }

    if ((int)$user_type < 2) {
        echo '<script>
                alert("No tiene acceso para entrar al apartado de asignaciones, favor de solicitarlo al departamento de sistemas");
                window.location = "../views/Home.php";
              </script>';
        exit();
    }
} else {
    echo 'Falla en conexión.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="../Imagenes/movility.ico" />

    <!-- Bootstrap / jQuery -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">

    <!-- CSS del dashboard -->
    <link rel="stylesheet" href="../CSS/reporte.css?v=2.0">
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
      <a class="navbar-brand" rel="nofollow" target="_blank" href="#"> Dashboard </a>
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

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/Autoriza.php">Aprobaciones</a>
          </li>

          <li class="nav-item active">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/asignacion.php">Asignaciones</a> 
          </li>

        </ul>
      </div>
    </div>
  </nav>
</div>

<div class="ds">
  <div class="dashboard-container">

    <!-- COLUMNA IZQUIERDA: FILTROS + GRÁFICA + HISTORIALES -->
    <section class="dash-left">

      <!-- Filtros superiores -->
      <header class="filters-bar">
        <div class="filter-group">
          <label for="filtroUsuario">Filtro usuario</label>
          <select id="filtroUsuario"></select>
        </div>
        <div class="filter-group">
          <label for="filtroAnio">Año</label>
          <select id="filtroAnio"></select>
        </div>
        <div class="filter-group">
          <label for="filtroMes">Mes</label>
          <select id="filtroMes"></select>
        </div>
      </header>

      <!-- Gráfica principal -->
      <section class="main-card">
        <h3 class="card-title" id="tituloGrafica">
          Resumen anual de requerimientos
        </h3>
        <div class="chart-wrapper">
          <canvas id="graficaMetas"></canvas>
        </div>
      </section>

      <!-- Historiales inferiores -->
      <section class="bottom-row">
        <!-- Historial de requerimientos -->
        <article class="history-card">
          <header class="history-header">
            <h4>Historial de requerimientos</h4>
          </header>
          <div class="history-body">
            <table class="history-table" id="tablaHistReq">
              <thead>
                <tr>
                  <th>Detalle</th>
                  <th>Fecha</th>
                  <th>Tipo de requerimiento</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="3" class="empty">
                    Selecciona un usuario para ver su historial.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </article>

        <!-- Historial de reconocimientos -->
        <article class="history-card">
          <header class="history-header">
            <h4>Historial de reconocimientos</h4>
          </header>
          <div class="history-body">
            <table class="history-table" id="tablaHistRec">
              <thead>
                <tr>
                  <th>Reconocimiento</th>
                  <th>Fecha</th>
                  <th>Descripción</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="3" class="empty">
                    Selecciona un usuario para ver su historial.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </article>
      </section>
    </section>

    <!-- COLUMNA DERECHA: LISTA DE USUARIOS -->
    <aside class="dash-right">
      <h3 class="right-title">Equipo</h3>
      <div id="userList" class="user-list">
        <!-- Se llena por JS -->
      </div>
    </aside>

  </div>
</div>

<!-- Estado global -->
<script>
  const usuarioOriginal           = <?php echo json_encode($_SESSION['user_id']); ?>;
  let   usuarioActual             = usuarioOriginal;
  const tipoUsuarioActual         = <?php echo json_encode($user_type); ?>;
  let   soloUsuarioSeleccionado   = false;
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  let currentChart = null;

  const MESES_DB     = ["enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"];
  const MESES_CORTOS = ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];

  const esCtoOCeo = (Number(tipoUsuarioActual) === 5 || Number(tipoUsuarioActual) === 6);

  function getJefeDirectoId(usuarios) {
    const yo = usuarios.find(u => Number(u.id) === Number(usuarioOriginal));
    if (!yo || yo.reporta_a === null || yo.reporta_a === undefined) return null;
    const jefeId = Number(yo.reporta_a);
    return isNaN(jefeId) ? null : jefeId;
  }

  // ============================
  //  APIs PRINCIPALES (versiones _dash, vía POST)
  // ============================
  async function getDataUsuario(userId, year, soloUsuario = false) {
    const metasPayload = {
      asignado: userId,
      user_type: tipoUsuarioActual,
      solo_usuario: soloUsuario,
      year: year
    };

    const hexPayload = {
      user_id: userId,
      user_type: tipoUsuarioActual,
      solo_usuario: soloUsuario,
      year: year
    };

    const [metasRes, hexRes] = await Promise.all([
      fetch("https://mobilitysolutionscorp.com/web/MS_get_metas_usuario_jerarquia_dash.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(metasPayload)
      }),
      fetch("https://mobilitysolutionscorp.com/web/MS_get_hex_usuario_jerarquia_dash.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(hexPayload)
      })
    ]);

    const metasData = await metasRes.json().catch(() => ({}));
    const hexData   = await hexRes.json().catch(() => ({}));

    return {
      metas: metasData && Array.isArray(metasData.metas) ? metasData.metas : [],
      hex:   Array.isArray(hexData) ? hexData : (Array.isArray(hexData.rows) ? hexData.rows : [])
    };
  }

  async function getUsuariosJerarquia() {
    const res  = await fetch("https://mobilitysolutionscorp.com/web/MS_get_usuarios_reporte.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        user_id:  usuarioOriginal,
        user_type: tipoUsuarioActual
      })
    });
    const data = await res.json().catch(() => ({}));
    return Array.isArray(data.usuarios) ? data.usuarios : [];
  }

  // ============================
  //  SERIE PARA LA GRÁFICA
  // ============================
  function buildSeries(hexRows) {
    const serie = {
      labels: MESES_CORTOS.slice(),
      nuevo:   new Array(12).fill(0),
      reserva: new Array(12).fill(0),
      entrega: new Array(12).fill(0)
    };

    hexRows.forEach(row => {
      const mesNombre = (row.Mes || row.mes || "").toString().toLowerCase();
      const idx = MESES_DB.indexOf(mesNombre);
      if (idx === -1) return;

      serie.nuevo[idx]   += Number(row.New      ?? row.nuevo   ?? 0) || 0;
      serie.reserva[idx] += Number(row.Reserva  ?? row.reserva ?? 0) || 0;
      serie.entrega[idx] += Number(row.Entrega  ?? row.entrega ?? 0) || 0;
    });

    return serie;
  }

  // === Meta mensual de reservas (tipo_meta = 2) ===
  function buildMetaReservaSeries(metas) {
    const meta = new Array(12).fill(0);
    if (!Array.isArray(metas)) return meta;

    const metasReserva = metas.filter(m => {
      const tm = m.tipo_meta;
      return tm === 2 || tm === "2" || tm === "Reserva" || tm === "reserva";
    });

    metasReserva.forEach(m => {
      MESES_DB.forEach((mesName, idx) => {
        const raw = m[mesName];
        const val = parseInt(raw ?? 0, 10);
        if (!isNaN(val)) {
          meta[idx] += val;
        }
      });
    });

    return meta;
  }

  // Gráfica: meta de reservas + reservas + entregas
  function renderChartFromHex(hexRows, metas, year) {
    const { labels, nuevo, reserva, entrega } = buildSeries(hexRows);
    const metaReserva = buildMetaReservaSeries(metas);

    const canvas = document.getElementById("graficaMetas");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");
    if (currentChart) currentChart.destroy();

    currentChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels,
        datasets: [
          {
            label: "Meta de reservas",
            data: metaReserva,
            backgroundColor: "#9ca3af"
          },
          {
            label: "Reservas realizadas",
            data: reserva,
            backgroundColor: "#2563eb"
          },
          {
            label: "Entregas realizadas",
            data: entrega,
            backgroundColor: "#eab308"
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
          mode: "index",
          intersect: false
        },
        plugins: {
          legend: {
            position: "bottom"
          },
          tooltip: {
            mode: "index",
            intersect: false
          }
        },
        scales: {
          x: {
            grid: { display: false }
          },
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1
            }
          }
        }
      }
    });
  }

  // ============================
  //  HISTORIALES (versiones _dash)
  // ============================
  async function loadHistorialRequerimientos(userId, year, month) {
    const tbody = document.querySelector("#tablaHistReq tbody");
    if (!tbody) return;

    tbody.innerHTML = `
      <tr><td colspan="3" class="empty">Cargando requerimientos...</td></tr>
    `;

    try {
      const res = await fetch("https://mobilitysolutionscorp.com/web/MS_get_historial_requerimientos_dash.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          user_id: userId,
          year: year,
          month: month
        })
      });

      const data = await res.json().catch(() => ({}));
      const rows = Array.isArray(data.rows) ? data.rows : [];

      if (!rows.length) {
        tbody.innerHTML = `
          <tr><td colspan="3" class="empty">
            Sin requerimientos para los filtros seleccionados.
          </td></tr>`;
        return;
      }

      tbody.innerHTML = "";
      rows.forEach(r => {
        const tr = document.createElement("tr");
        tr.className = "history-row";
        tr.innerHTML = `
          <td>
            <div class="hist-item">
              ${r.imagen_url ? `<img src="${r.imagen_url}" class="hist-thumb" alt="">` : ""}
              <div class="hist-main">
                <div class="hist-title">
                  ${r.titulo || r.auto || ("Req #" + (r.id ?? ""))}
                </div>
                <div class="hist-sub">
                  ${r.subtitulo || r.detalle || ""}
                </div>
              </div>
            </div>
          </td>
          <td>${r.fecha || ""}</td>
          <td>${r.tipo || r.tipo_requerimiento || ""}</td>
        `;
        tbody.appendChild(tr);
      });

    } catch (err) {
      console.error("Error historial requerimientos:", err);
      tbody.innerHTML = `
        <tr><td colspan="3" class="empty">
          Error al consultar el historial de requerimientos.
        </td></tr>`;
    }
  }

  async function loadHistorialReconocimientos(userId, year, month) {
    const tbody = document.querySelector("#tablaHistRec tbody");
    if (!tbody) return;

    tbody.innerHTML = `
      <tr><td colspan="3" class="empty">Cargando reconocimientos...</td></tr>
    `;

    try {
      const res = await fetch("https://mobilitysolutionscorp.com/web/MS_get_historial_reconocimientos_dash.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          asignado: userId,
          year: year,
          month: month
        })
      });

      const data = await res.json().catch(() => ({}));
      const rows = Array.isArray(data.rows) ? data.rows : [];

      if (!rows.length) {
        tbody.innerHTML = `
          <tr><td colspan="3" class="empty">
            Sin reconocimientos para los filtros seleccionados.
          </td></tr>`;
        return;
      }

      tbody.innerHTML = "";
      rows.forEach(r => {
        const tr = document.createElement("tr");
        tr.className = "history-row";
        tr.innerHTML = `
          <td>${r.reconocimiento || r.titulo || "Reconocimiento"}</td>
          <td>${r.fecha || (r.mes && r.anio ? `${r.mes}/${r.anio}` : "")}</td>
          <td>${r.descripcion || ""}</td>
        `;
        tbody.appendChild(tr);
      });

    } catch (err) {
      console.error("Error historial reconocimientos:", err);
      tbody.innerHTML = `
        <tr><td colspan="3" class="empty">
          Error al consultar el historial de reconocimientos.
        </td></tr>`;
    }
  }

  // ============================
  //  LISTA DE USUARIOS / FILTROS
  // ============================
  function setupFiltros(usuarios) {
    const selUsuario = document.getElementById("filtroUsuario");
    const selAnio    = document.getElementById("filtroAnio");
    const selMes     = document.getElementById("filtroMes");

    if (!selUsuario || !selAnio || !selMes) return;

    const jefeDirectoId = getJefeDirectoId(usuarios);

    // Filtrar jefe directo para no CTO/CEO
    let usuariosParaFiltros = usuarios;
    if (!esCtoOCeo && jefeDirectoId) {
      usuariosParaFiltros = usuarios.filter(u => Number(u.id) !== jefeDirectoId);
    }

    selUsuario.innerHTML = "";

    // Opción "Todos" (siempre)
    const optTodos = document.createElement("option");
    optTodos.value = "0";
    optTodos.textContent = "Todos";
    selUsuario.appendChild(optTodos);

    // Usuarios individuales (sin jefe directo para no CTO/CEO)
    usuariosParaFiltros.forEach(u => {
      const opt = document.createElement("option");
      opt.value = String(u.id);
      opt.textContent = u.nombre;
      selUsuario.appendChild(opt);
    });

    // Valor inicial: "Todos" => usuarioActual = usuarioOriginal
    selUsuario.value = "0";
    usuarioActual = usuarioOriginal;
    soloUsuarioSeleccionado = false;

    const now = new Date();
    const yearNow = now.getFullYear();
    [yearNow - 1, yearNow, yearNow + 1].forEach(y => {
      const opt = document.createElement("option");
      opt.value = String(y);
      opt.textContent = String(y);
      selAnio.appendChild(opt);
    });
    selAnio.value = String(yearNow);

    const mesesCombo = ["Todos","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    mesesCombo.forEach((m, idx) => {
      const opt = document.createElement("option");
      opt.value = String(idx); // 0 = todos
      opt.textContent = m;
      selMes.appendChild(opt);
    });
    selMes.value = "0";

    selUsuario.addEventListener("change", () => {
      const val = parseInt(selUsuario.value, 10);

      if (val === 0) {
        // Todos: vista general (mi jerarquía)
        usuarioActual = usuarioOriginal;
        soloUsuarioSeleccionado = false;

        document.querySelectorAll(".user-list-item").forEach(el => {
          el.classList.remove("active");
        });
      } else {
        usuarioActual = val;
        soloUsuarioSeleccionado = (val !== usuarioOriginal);

        document.querySelectorAll(".user-list-item").forEach(el => {
          const id = parseInt(el.dataset.id, 10);
          el.classList.toggle("active", soloUsuarioSeleccionado && id === val);
        });
      }

      refreshDashboard();
    });

    selAnio.addEventListener("change", refreshDashboard);
    selMes.addEventListener("change", refreshDashboard);
  }

  function renderUserList(usuarios) {
    const list = document.getElementById("userList");
    if (!list) return;

    list.innerHTML = "";

    const jefeDirectoId = getJefeDirectoId(usuarios);

    // Filtrar jefe directo para no CTO/CEO
    const usuariosParaLista = (!esCtoOCeo && jefeDirectoId)
      ? usuarios.filter(u => Number(u.id) !== jefeDirectoId)
      : usuarios;

    usuariosParaLista.forEach(u => {
      const item = document.createElement("div");
      item.className = "user-list-item";
      item.dataset.id = String(u.id);

      item.innerHTML = `
        <img src="${u.foto}" alt="${u.nombre}" class="user-list-avatar">
        <div class="user-list-text">
          <div class="user-list-name">${u.nombre}</div>
          <div class="user-list-meta">
            ${u.rol || ""}${u.ultima_actividad ? " · " + u.ultima_actividad : ""}
          </div>
        </div>
        <span class="status-dot ${u.activo ? "online" : ""}"></span>
      `;

      item.addEventListener("click", () => {
        const yaActivo = item.classList.contains("active");

        document.querySelectorAll(".user-list-item").forEach(el => el.classList.remove("active"));

        if (yaActivo) {
          // Volver a "Todos"
          usuarioActual = usuarioOriginal;
          soloUsuarioSeleccionado = false;
          const selUsuario = document.getElementById("filtroUsuario");
          if (selUsuario) selUsuario.value = "0";
        } else {
          usuarioActual = u.id;
          soloUsuarioSeleccionado = true;
          item.classList.add("active");
          const selUsuario = document.getElementById("filtroUsuario");
          if (selUsuario) selUsuario.value = String(u.id);
        }

        refreshDashboard();
      });

      list.appendChild(item);
    });
  }

  // ============================
  //  REFRESH GENERAL
  // ============================
  async function refreshDashboard() {
    const selAnio = document.getElementById("filtroAnio");
    const selMes  = document.getElementById("filtroMes");
    const selUsu  = document.getElementById("filtroUsuario");

    const year = selAnio ? parseInt(selAnio.value, 10) || (new Date()).getFullYear() : (new Date()).getFullYear();
    const mesCombo = selMes ? parseInt(selMes.value, 10) || 0 : 0; // 0=todos
    const mesParam = mesCombo === 0 ? null : mesCombo;             // 1-12 si se eligió

    const data = await getDataUsuario(usuarioActual, year, soloUsuarioSeleccionado);
    renderChartFromHex(data.hex || [], data.metas || [], year);

    const titulo = document.getElementById("tituloGrafica");
    if (titulo && selUsu) {
      const textUsu = selUsu.options[selUsu.selectedIndex]?.textContent || "Todos";
      titulo.textContent = `Resumen anual de requerimientos - ${textUsu} (${year})`;
    }

    await loadHistorialRequerimientos(usuarioActual, year, mesParam);
    await loadHistorialReconocimientos(usuarioActual, year, mesParam);
  }

  // ============================
  //  INIT
  // ============================
  document.addEventListener("DOMContentLoaded", async () => {
    const usuarios = await getUsuariosJerarquia();
    setupFiltros(usuarios);
    renderUserList(usuarios);
    refreshDashboard();
  });
</script>

<!-- Scripts extra -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1YfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>
