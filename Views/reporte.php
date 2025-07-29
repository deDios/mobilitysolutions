<?php
session_start();

if (!isset ($_SESSION['username'])){
    echo '<script>
            alert("Es necesario hacer login, por favor ingrese sus credenciales") ;
            window.location = "../views/login.php";
          </script>';
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
                            $_SESSION['user_id'] = $user_id;
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
                           
        // Concatenar nombre completo
        $nombre_usuario = trim($nombre . " " . $s_nombre . " " . $last_name);

        // Determinar título profesional
        $roles_activos = [];

        if ($r_ejecutivo == 1) $roles_activos[] = "Ejecutivo";
        if ($r_editor == 1) $roles_activos[] = "Editor";
        if ($r_autorizador == 1) $roles_activos[] = "Autorizador";
        if ($r_analista == 1) $roles_activos[] = "Analista";

        if ($user_id == 4) {
            $titulo_profesional = "CEO - Mobility Solutions";
        }
        elseif ($user_id == 1) {
          $titulo_profesional = "CTO - Líder técnico";
        } 
        elseif ($user_id == 18) {
          $titulo_profesional = "CTO - Líder técnico";
        } 
        elseif ($user_id == 17) {
          $titulo_profesional = "CTO - Líder técnico";
        } 
        else {
            $titulo_profesional = implode(" | ", $roles_activos);
        }    
    }

    if ($user_id != 1 && $user_id != 4 && $user_id != 17 && $user_id != 18) {
        echo ' 
        <script>
            alert("No tiene acceso para entrar al apartado de asignaciones, favor de solicitarlo al departamento de sistemas");
            window.location = "../views/Home.php";
        </script>';
        exit();
    }

  } 
  else {
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
   
    <link rel="stylesheet" href="../CSS/reporte.css?v=1.1">


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
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
      <h3 class="titulo_d">Dashboard general</h3>
    </div>
  
  <div class="dashboard-container">
    <!-- PRIMERA SECCIÓN: TOTALIZADORES + CÍRCULOS + GRÁFICA -->
    <div class="upper-section">
      <!-- Contenedor para hexágonos + círculos -->
      <div class="upper-content">
        <div class="hex-totalizadores-container">
          <div class="hex-totalizadores">
            <div class="hex-box" id="dealsBox">
              <h2 id="dealsTotal">0</h2>
              <p>Nuevos</p>
            </div>
            <div class="hex-box" id="reservasBox">
              <h2 id="reservasTotal">0</h2>
              <p>Contratos</p>
            </div>
            <div class="hex-box" id="entregasBox">
              <h2 id="entregasTotal">0</h2>
              <p>Entregas</p>
            </div>
          </div>

          <div class="circulos">
            <div id="avanceMensual" class="month-circles-container">
              <!-- Los círculos mensuales se insertarán dinámicamente aquí -->
            </div>
          </div>
        </div>
        <!-- Contenedor para la gráfica -->
        <div class="chart-container">
          <canvas id="graficaMetas"></canvas>
        </div>
      </div> 
    </div>


    <!-- SEGUNDA SECCIÓN: ÁRBOL DE USUARIOS -->
    <div class="lower-section">
      <h3>Equipo Mobility</h3>
      <div id="userTree" class="hierarchy-tree-container">
        <div id="userMetrics"></div>
      </div>
    </div>


  </div>

</div>

<script>
  const usuarioActual = <?php echo json_encode($_SESSION['user_id']); ?>;
  const tipoUsuarioActual = <?php echo json_encode($user_type); ?>;
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const globalUserId = 9999;
  let currentChart = null;

  async function getDataUsuario(userId) {
    const metasRes = await fetch(`https://mobilitysolutionscorp.com/web/MS_get_metas_usuario.php?asignado=${userId}`);
    const hexRes = await fetch(`https://mobilitysolutionscorp.com/db_consultas/hex_status.php?user_id=${userId}`);
    const metasData = await metasRes.json();
    const hexData = await hexRes.json();
    return { metas: metasData?.metas || [], hex: hexData || [] };
  }

  async function getUsuarios() {
    const res = await fetch("https://mobilitysolutionscorp.com/web/MS_get_usuario.php");
    const data = await res.json();
    return data.usuarios || [];
  }

  function generarTotales(data) {
    let totalDeals = 0, totalReservas = 0, totalEntregas = 0;

    data.hex.forEach(row => {
      totalDeals += row.New;
      totalReservas += row.Reserva;
      totalEntregas += row.Entrega;
    });

    document.getElementById("dealsTotal").innerText = totalDeals;
    document.getElementById("reservasTotal").innerText = totalReservas;
    document.getElementById("entregasTotal").innerText = totalEntregas;
  }

  function renderAvanceMensual(tipo, avance, metas) {
    const container = document.getElementById("avanceMensual");
    container.innerHTML = "";
    const meses = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];

    if (tipo === "Entrega") {
      const totalAvance = avance.reduce((acc, val) => acc + val, 0);
      const totalMeta = metas.reduce((acc, val) => acc + val, 0);
      const pct = totalMeta ? (totalAvance / totalMeta) * 100 : 0;
      const color = pct < 90 ? 'gray' : pct < 96 ? 'yellow' : 'green';
      const circle = `<div class="month-circle ${color}"><div>${Math.round(pct)}%</div></div>`;
      container.innerHTML = circle;
    } else {
      meses.forEach((mes, i) => {
        const pct = metas[i] ? (avance[i] / metas[i]) * 100 : 0;
        const color = pct < 90 ? 'gray' : pct < 96 ? 'yellow' : 'green';
        const circle = `<div class="month-circle ${color}"><div>${mes}<br>${Math.round(pct)}%</div></div>`;
        container.innerHTML += circle;
      });
    }
  }

  function renderGraficaPorTipo(tipo) {
    getDataUsuario(globalUserId).then(data => {
      const tipoMeta = { New: 1, Reserva: 2, Entrega: 3 }[tipo];
      const meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];

      const avanceMensual = new Array(12).fill(0);
      data.hex.forEach(row => {
        const index = meses.findIndex(m => m.toLowerCase() === row.Mes.toLowerCase());
        if (index >= 0) avanceMensual[index] += row[tipo] || 0;
      });

      const metasFiltradas = data.metas.filter(m => m.tipo_meta == tipoMeta);
      const metasMensuales = meses.map(mes =>
        metasFiltradas.reduce((sum, meta) => sum + (parseInt(meta[mes]) || 0), 0)
      );

      renderAvanceMensual(tipo, avanceMensual, metasMensuales);

      if (currentChart) currentChart.destroy();
      const ctx = document.getElementById("graficaMetas").getContext("2d");
      currentChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: meses.map(m => m.charAt(0).toUpperCase() + m.slice(1)),
          datasets: [
            { label: `Avance mensual - ${tipo}`, data: avanceMensual, backgroundColor: '#3498db' },
            { label: 'Meta', data: metasMensuales, backgroundColor: '#95a5a6' }
          ]
        },
        options: { responsive: true, maintainAspectRatio: false }
      });
    });
  }

  function renderGauge(tipo) {
    getDataUsuario(globalUserId).then(data => {
      const tipoMeta = { New: 1, Reserva: 2, Entrega: 3 }[tipo];
      const meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];

      const totalAvance = data.hex.reduce((acc, row) => acc + (row[tipo] || 0), 0);
      const metasFiltradas = data.metas.filter(m => m.tipo_meta == tipoMeta);
      const metaAnual = meses.reduce((sum, mes) =>
        sum + metasFiltradas.reduce((subtotal, meta) => subtotal + (parseInt(meta[mes]) || 0), 0), 0
      );

      renderAvanceMensual(tipo, [totalAvance], [metaAnual]);

      if (currentChart) currentChart.destroy();
      const ctx = document.getElementById("graficaMetas").getContext("2d");
      currentChart = new Chart(ctx, {
        type: 'polarArea',
        data: {
          labels: ['Avance', 'Pendiente'],
          datasets: [{
            data: [totalAvance, Math.max(0, metaAnual - totalAvance)],
            backgroundColor: ['#2980b9', '#dcdde1']
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: true, position: 'bottom' },
            tooltip: {
              enabled: true,
              callbacks: {
                label: context => `${context.label || ''}: ${context.raw || 0}`
              }
            }
          }
        }
      });
    });
  }

  async function getUsuariosJerarquia() {
  const res = await fetch("https://mobilitysolutionscorp.com/web/MS_get_usuarios_reporte.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      user_id: usuarioActual,
      user_type: tipoUsuarioActual
    })
  });

  const data = await res.json();
  return data.usuarios || [];
}

async function renderUserCards() {
  const usuarios = await getUsuariosJerarquia();
  const contenedor = document.getElementById("userMetrics");
  contenedor.innerHTML = "";

  for (const usuario of usuarios) {
    const datos = await getDataUsuario(usuario.id);
    let totalNew = 0, totalReserva = 0, totalEntrega = 0;

    datos.hex.forEach(row => {
      totalNew += row.New;
      totalReserva += row.Reserva;
      totalEntrega += row.Entrega;
    });

    // 💡 Agrega los totales al objeto para usarlos en el árbol jerárquico
    usuario.totalNew = totalNew;
    usuario.totalReserva = totalReserva;
    usuario.totalEntrega = totalEntrega;

    // 🔁 Crea la tarjeta de usuario
    const div = document.createElement("div");
    div.className = "user-metric";
    div.innerHTML = `
      <div class="user-header">
        <img src="${usuario.foto}" alt="${usuario.nombre}" class="user-avatar">
        <div class="user-info">
          <h4>${usuario.nombre}</h4>
          <div class="user-role">${usuario.rol}</div>
        </div>
      </div>
      <div class="user-indicators">
        <span title="Nuevo en catálogo">${totalNew}</span>
        <span title="Reserva de vehículo">${totalReserva}</span>
        <span title="Entrega de vehículo">${totalEntrega}</span>
      </div>
    `;
    contenedor.appendChild(div);
  }

  // Retorna los usuarios ya enriquecidos para usarlos en el árbol
  return usuarios;
}

function renderUserTree(usuarios) {
  const treeContainer = document.getElementById("userTree");
  if (!treeContainer) return;

  // Mapear por ID
  const userMap = {};
  usuarios.forEach(u => {
    userMap[u.id] = { ...u, children: [] };
  });

  // Armar jerarquía
  const rootNodes = [];
  usuarios.forEach(u => {
    if (u.reporta_a && userMap[u.reporta_a]) {
      userMap[u.reporta_a].children.push(userMap[u.id]);
    } else {
      rootNodes.push(userMap[u.id]);
    }
  });

  // Crear árbol visual
  const ul = document.createElement("ul");
  ul.classList.add("tree");

  rootNodes.forEach(root => {
    ul.appendChild(createTreeNode(root));
  });

  treeContainer.innerHTML = ""; // Limpiar
  treeContainer.appendChild(ul);
}

function createTreeNode(usuario) {
  const li = document.createElement("li");
  li.className = "tree-node";

  const card = document.createElement("div");
  card.className = "user-metric";
  card.innerHTML = `
    <div class="user-header">
      <img src="${usuario.foto}" alt="${usuario.nombre}" class="user-avatar">
      <div class="user-info">
        <h4>${usuario.nombre}</h4>
        <div class="user-role">${usuario.rol}</div>
      </div>
    </div>
    <div class="user-indicators">
      <span title="Nuevo en catálogo">${usuario.totalNew}</span>
      <span title="Reserva de vehículo">${usuario.totalReserva}</span>
      <span title="Entrega de vehículo">${usuario.totalEntrega}</span>
    </div>
  `;
  li.appendChild(card);

  if (usuario.children && usuario.children.length > 0) {
    const ul = document.createElement("ul");
    ul.className = "tree-children";  // 👈 ¡Este es el cambio clave!

    usuario.children.forEach(child => {
      ul.appendChild(createTreeNode(child));
    });

    li.appendChild(ul);
  }

  return li;
}


  function activarHexagono(hexId) {
    document.querySelectorAll(".hex-box").forEach(box => box.classList.remove("active"));
    const box = document.getElementById(hexId);
    if (box) box.classList.add("active");
  }

async function init() {
  const data = await getDataUsuario(globalUserId);
  generarTotales(data);
  renderGraficaPorTipo("New");
  activarHexagono("dealsBox");

  const usuarios = await renderUserCards(); 
  renderUserTree(usuarios); 

  document.getElementById("dealsBox").addEventListener("click", () => {
    activarHexagono("dealsBox");
    renderGraficaPorTipo("New");
  });

  document.getElementById("reservasBox").addEventListener("click", () => {
    activarHexagono("reservasBox");
    renderGraficaPorTipo("Reserva");
  });

  document.getElementById("entregasBox").addEventListener("click", () => {
    activarHexagono("entregasBox");
    renderGauge("Entrega");
  });
}


  async function llenarFiltroUsuarios() {
    const select = document.getElementById("filtroUsuarios");
    if (!select) return;

    const usuarios = await getUsuarios();

    usuarios.forEach(usuario => {
      const option = document.createElement("option");
      option.value = usuario.id;
      option.textContent = usuario.nombre;
      select.appendChild(option);
    });
  }

  llenarFiltroUsuarios();

  init();
</script>
 
<!-- CSS y JS de Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>