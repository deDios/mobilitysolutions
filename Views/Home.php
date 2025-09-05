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

.mini-hex span{font-size:12px; line-height:1; opacity:.95; margin-bottom:2px;}
.mini-hex strong{font-size:16px; line-height:1;}

.mini-hex:hover{ transform: scale(1.05); filter: brightness(1.02); }

/* Colores por tipo (alineados con tus cápsulas anteriores) */
.mini-hex.quejas{ background:#ff6b6b; }
.mini-hex.inasistencias{ background:#6c8cff; }

/* Responsivo: si la pantalla es angosta, que no se solapen */
@media (max-width: 768px){
  .hex-honey{
    gap: 40px;
    margin-top: 6px;     /* no los “metas” en pantallas chicas */
  }
  .mini-hex{ width:82px; height:70px; }
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
          <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/tareas.php">
            <div class="circulo-tareas">
              <span id="cantidad-tareas">0</span>
            </div>
          </a>
          <div class="texto-tareas">Tareas en curso</div>
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
            <span>Inasistencias</span>
            <strong id="hc-inasistencias">0</strong>
          </a>
        </div>


        <div class="chart-wrapper">
            <canvas id="lineChart"></canvas>
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
        <form id="editForm"> <!-- Quitamos action y method -->
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

<script>
document.addEventListener("DOMContentLoaded", () => {
  const userId = <?php echo intval($user_id); ?>;

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

    window.onclick = function(event) {
        const modal = document.getElementById("editModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

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
      // tipo: 1 = Desempeño (30), 2 = Liderazgo (20), 3 = Innovación (10)
      const puntosPorTipo = {1: 30, 2: 20, 3: 10};
      const lista = Array.isArray(data?.reconocimientos) ? data.reconocimientos : [];
      const totalPuntos = lista.reduce((acc, item) => {
        const tipo = parseInt(item.tipo, 10);
        return acc + (puntosPorTipo[tipo] || 0);
      }, 0);

      // ====== Configuración del termómetro ======
      const metas = [
        { pts: 100, nombre: "Premio 1" },
        { pts: 150, nombre: "Premio 2" },
        { pts: 200, nombre: "Premio 3" },
        { pts: 250, nombre: "Premio 4" }
      ];
      const maxPts = metas[metas.length - 1].pts; // 250
      const pct = Math.min(100, (totalPuntos / maxPts) * 100);

      // Calcular siguiente premio
      const siguiente = metas.find(m => totalPuntos < m.pts);
      const textoSiguiente = siguiente
        ? `Siguiente: ${siguiente.nombre} a ${siguiente.pts} pts`
        : `¡Todos los premios conseguidos!`;

      // ====== Render del termómetro ======
      const rewardsWrapper = document.createElement("div");
      rewardsWrapper.className = "rewards-wrapper";
      rewardsWrapper.innerHTML = `
        <div class="rewards-head">
          <div class="rewards-title">Línea de recompensas</div>
          <div class="rewards-stats">
            Puntos: <strong id="pts-actuales">${totalPuntos}</strong> / ${maxPts}
          </div>
        </div>

        <div class="rewards-bar">
          <div class="rewards-fill" id="rewards-fill" style="width:0%"></div>
          <div class="rewards-markers" id="rewards-markers"></div>
        </div>

        <div class="rewards-legend">
          <span>30 (Desempeño) · 20 (Liderazgo) · 10 (Innovación)</span>
          <span class="next" id="rewards-next">${textoSiguiente}</span>
        </div>
      `;
      contenedorSkills.appendChild(rewardsWrapper);

      // Colocar marcadores de premios
      const markers = document.getElementById("rewards-markers");
      metas.forEach((m, i) => {
        const left = (m.pts / maxPts) * 100;
        const marker = document.createElement("div");
        marker.className = "rewards-marker" + (totalPuntos >= m.pts ? " achieved" : "");
        marker.style.left = `${left}%`;
        marker.innerHTML = `
          <div class="dot"></div>
          <div class="label">${m.nombre}<br>${m.pts} pts</div>
        `;
        markers.appendChild(marker);
      });

      // Animar el “llenado”
      requestAnimationFrame(() => {
        const fill = document.getElementById("rewards-fill");
        fill.style.width = pct + "%";
      });

      // ====== Grid de reconocimientos (tu lógica actual) ======
      // ====== Agrupar por tipo y mostrar como acordeón (siempre 3 grupos) ======
      const NOMBRES_TIPO = { 1: "Desempeño", 2: "Liderazgo", 3: "Innovación" };
      const CLASE_TIPO   = { 1: "recono-desempeno", 2: "recono-liderazgo", 3: "recono-innovacion" };
      const PUNTOS_TIPO  = { 1: 30, 2: 20, 3: 10 };

      const tiposOrden = [1, 2, 3]; // orden fijo de grupos
      const grupos = { 1: [], 2: [], 3: [] }; // inicia vacío para garantizar presencia

      // llena con los datos que llegaron (si hay)
      lista.forEach(it => {
        const t = parseInt(it.tipo, 10);
        if (grupos[t]) grupos[t].push(it);
      });

      const groupsWrap = document.createElement("div");
      groupsWrap.className = "rec-groups";

      tiposOrden.forEach((tipo, idx) => {
        const items = grupos[tipo];                  // puede ser []
        const totalPtsGrupo = items.length * (PUNTOS_TIPO[tipo] || 0);

        const card = document.createElement("div");
        card.className = "rec-group" + (idx === 0 ? " open" : ""); // el 1º inicia abierto

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
            tile.innerHTML = `
              <div class="titulo">${item.reconocimiento}</div>
              <div class="fecha">${item.mes}/${item.anio}</div>
            `;
            grid.appendChild(tile);
          });
          body.appendChild(grid);
        } else {
          // Mensaje de vacío
          const empty = document.createElement("div");
          empty.className = "rec-empty";
          empty.textContent = `No hay reconocimientos de ${NOMBRES_TIPO[tipo].toLowerCase()}.`;
          body.appendChild(empty);
        }

        card.appendChild(header);
        card.appendChild(body);
        groupsWrap.appendChild(card);
      });

      // sustituye la sección de reconocimientos en el contenedor
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
    })
    .catch(() => actualizarContadores(["#cantidad-inasistencias", "#hc-inasistencias"], 0));
  });
</script>



<script>
  const userId = <?php echo intval($user_id); ?>;
  let datosPorMes = [];
  let metasPorTipo = {
    1: Array(12).fill(0), // tipo_meta 1 = Nuevos
    2: Array(12).fill(0), // tipo_meta 2 = Reservas
    3: Array(12).fill(0), // tipo_meta 3 = Entregas
  };
  let lineChart;

  function actualizarGrafica(tipo) {
    const valores = datosPorMes.map(mes => parseInt(mes[tipo]) || 0);
    const tipoMeta = {
      'New': 1,
      'Reserva': 2,
      'Entrega': 3
    }[tipo];

    const metas = metasPorTipo[tipoMeta] || Array(12).fill(0);
    const label = {
      'New': 'Nuevos por mes',
      'Reserva': 'Ventas por mes',
      'Entrega': 'Entregas por mes'
    }[tipo];

    lineChart.data.datasets[0].data = valores;
    lineChart.data.datasets[0].label = label;
    lineChart.data.datasets[1].data = metas;
    lineChart.data.datasets[1].label = 'Meta';

    lineChart.update();

    // (Opcional) resaltar el hexágono activo
    document.querySelectorAll('.hex').forEach(h => h.classList.remove('active'));
    const hexMap = {
      'New': '#hex-nuevo',
      'Reserva': '#hex-reserva',
      'Entrega': '#hex-entrega'
    };
    if (hexMap[tipo]) {
      document.querySelector(hexMap[tipo]).classList.add('active');
    }
  }

  // Cargar datos reales por mes
  fetch(`https://mobilitysolutionscorp.com/db_consultas/hex_status.php?user_id=${userId}`)
    .then(response => response.json())
    .then(data => {
      datosPorMes = data;

      // Calcular totales
      let totalNuevo = 0, totalReserva = 0, totalEntrega = 0;
      data.forEach(mes => {
        totalNuevo += parseInt(mes.New) || 0;
        totalReserva += parseInt(mes.Reserva) || 0;
        totalEntrega += parseInt(mes.Entrega) || 0;
      });

      // Mostrar en hexágonos
      document.querySelector('#hex-nuevo strong').textContent = totalNuevo;
      document.querySelector('#hex-reserva strong').textContent = totalReserva;
      document.querySelector('#hex-entrega strong').textContent = totalEntrega;

      // Inicializar la gráfica vacía
      const ctx = document.getElementById('lineChart').getContext('2d');
      lineChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
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
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 5
              }
            }
          },
          plugins: {
            legend: {
              display: true,
              position: 'top',
            },
            tooltip: {
              mode: 'index',
              intersect: false,
            }
          }
        }
      });

      // Después de inicializar la gráfica, cargar metas
      fetch(`https://mobilitysolutionscorp.com/web/MS_get_metas_usuario.php?asignado=${userId}`)
        .then(response => response.json()) 
        .then(data => {
          if (data.success && data.metas.length > 0) {
            data.metas.forEach(meta => {
              metasPorTipo[meta.tipo_meta] = [
                parseInt(meta.enero), parseInt(meta.febrero), parseInt(meta.marzo),
                parseInt(meta.abril), parseInt(meta.mayo), parseInt(meta.junio),
                parseInt(meta.julio), parseInt(meta.agosto), parseInt(meta.septiembre),
                parseInt(meta.octubre), parseInt(meta.noviembre), parseInt(meta.diciembre)
              ];
            });
          }

          // Mostrar la categoría por defecto
          actualizarGrafica('Reserva');
        });
    })
    .catch(error => {
      console.error('Error al obtener los datos:', error);
    });

  // Eventos de clic en los hexágonos
  document.getElementById('hex-nuevo').addEventListener('click', () => actualizarGrafica('New'));
  document.getElementById('hex-reserva').addEventListener('click', () => actualizarGrafica('Reserva'));
  document.getElementById('hex-entrega').addEventListener('click', () => actualizarGrafica('Entrega'));
</script>


<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>