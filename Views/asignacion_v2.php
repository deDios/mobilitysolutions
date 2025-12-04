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

/**
 * NUEVO:
 * Flag para controlar la visibilidad de Quejas e Inasistencias
 * Solo los user_id 1, 3 y 4 los verán en el menú.
 */
$mostrar_quejas_inasistencias = false;

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
            where acc.user_name = '.$_SESSION['username'].';';

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

        // Nombre completo
        $nombre_usuario = trim($nombre . " " . $s_nombre . " " . $last_name);

        // Título profesional según user_type
        $roles_activos = [];
        if ($r_ejecutivo == 1) $roles_activos[] = "Ejecutivo";
        if ($r_editor == 1)    $roles_activos[] = "Editor";
        if ($r_autorizador == 1) $roles_activos[] = "Autorizador";
        if ($r_analista == 1)  $roles_activos[] = "Analista";

        switch ((int)$user_type) {
            case 1:
                $titulo_profesional = "Asesor(a)";
                break;
            case 2:
                $titulo_profesional = "Supervisor(a)";
                break;
            case 3:
                $titulo_profesional = "Analista";
                break;
            case 4:
                $titulo_profesional = "Manager";
                break;
            case 5:
                $titulo_profesional = "CTO - Líder técnico";
                break;
            case 6:
                $titulo_profesional = "CEO - Mobility Solutions";
                break;
            default:
                $titulo_profesional = "Sin rol";
        }
    }

    /**
     * NUEVO:
     * Solo estos user_id ven los módulos de Quejas e Inasistencias
     * (IDs permitidos: 1, 3 y 4)
     */
    $mostrar_quejas_inasistencias = in_array((int)$user_id, [1, 3, 4], true);

    // Restricción de acceso (solo user_type >= 2)
    if ((int)$user_type < 2) {
        echo '
        <script>
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignaciones</title>
    <link rel="shortcut icon" href="../Imagenes/movility.ico" />

    <!-- CSS de la vista -->
    <link rel="stylesheet" href="../CSS/asignacion.css?v=1.1">

    <!-- Bootstrap 5 + Font Awesome + DataTables (opcional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <!-- jQuery + DataTables + Bootstrap JS -->
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

  <nav class="navbar navbar-expand-lg navbar-dark mx-background-top-linear">
    <div class="container">
      <a class="navbar-brand" rel="nofollow" target="_blank" href="https://mobilitysolutionscorp.com/">
        Mobility Solutions: Asignaciones
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
              aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <?php $self = basename($_SERVER['PHP_SELF']); ?>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">

          <li class="nav-item">
            <a class="nav-link <?= $self==='Home.php' ? 'active' : '' ?>"
               href="https://mobilitysolutionscorp.com/Views/Home.php">Inicio</a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= $self==='edicion_catalogo.php' ? 'active' : '' ?>"
               href="https://mobilitysolutionscorp.com/Views/edicion_catalogo.php">Catálogo</a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= $self==='requerimientos.php' ? 'active' : '' ?>"
               href="https://mobilitysolutionscorp.com/Views/requerimientos.php">Requerimientos</a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= $self==='tareas.php' ? 'active' : '' ?>"
               href="https://mobilitysolutionscorp.com/Views/tareas.php">Tareas</a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= $self==='Autoriza.php' ? 'active' : '' ?>"
               href="https://mobilitysolutionscorp.com/Views/Autoriza.php">Aprobaciones</a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= $self==='asignacion.php' ? 'active' : '' ?>"
               href="https://mobilitysolutionscorp.com/Views/asignacion.php">Asignaciones</a> 
          </li>

        </ul>
      </div>
    </div>
  </nav>
</div>

<!-- ========== NUEVO LAYOUT tipo Requerimientos / Settings ========== -->
<div class="container ms-settings-wrap">

  <!-- Encabezado compacto con usuario -->
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
      <div class="flex-grow-1 text-start">
        <div class="h5 mb-0">
          <?= htmlspecialchars($nombre_usuario ?? (($nombre ?? 'Usuario').' '.($last_name ?? 'Demo'))) ?>
        </div>
        <small class="text-muted">
          <?= htmlspecialchars($titulo_profesional ?? 'Colaborador') ?>
          · <?= htmlspecialchars($user_name ?? 'usuario') ?>
        </small>
      </div>
      <a class="btn btn-outline-dark btn-sm"
         href="https://mobilitysolutionscorp.com/db_consultas/cerrar_sesion.php">
        <i class="fa fa-sign-out me-1"></i>Salir
      </a>
    </div>
  </div>

  <div class="row g-3">
    <!-- Sidebar -->
    <aside class="col-12 col-lg-3">
      <nav class="list-group ms-side sticky-lg-top">
        <button type="button"
                class="list-group-item list-group-item-action asignacion-menu-item active"
                onclick="seleccionarMenu(this); mostrarTareas();">
          <i class="fa fa-tasks me-2"></i> Tareas
        </button>
        <button type="button"
                class="list-group-item list-group-item-action asignacion-menu-item"
                onclick="seleccionarMenu(this); mostrarMetas();">
          <i class="fa fa-bullseye me-2"></i> Metas
        </button>
        <button type="button"
                class="list-group-item list-group-item-action asignacion-menu-item"
                onclick="seleccionarMenu(this); mostrarReconocimientos();">
          <i class="fa fa-star me-2"></i> Reconocimientos
        </button>

        <!-- NUEVO: Quejas e Inasistencias solo visibles si user_id es 1, 3 o 4 -->
        <?php if ($mostrar_quejas_inasistencias): ?>
        <button type="button"
                class="list-group-item list-group-item-action asignacion-menu-item"
                onclick="seleccionarMenu(this); mostrarQuejas();">
          <i class="fa fa-exclamation-triangle me-2"></i> Quejas
        </button>
        <button type="button"
                class="list-group-item list-group-item-action asignacion-menu-item"
                onclick="seleccionarMenu(this); mostrarInasistencias();">
          <i class="fa fa-clock-o me-2"></i> Inasistencias
        </button>
        <?php endif; ?>
      </nav>
    </aside>

    <!-- Contenido dinámico -->
    <section class="col-12 col-lg-9">
      <div class="items" style="padding-top:0;">
        <div class="card ms-card shadow-sm">
          <div class="card-body">
            <p class="mb-1"><strong>Asignaciones</strong></p>
            <p class="text-muted mb-0">
              Selecciona una opción del menú lateral para registrar tareas, metas,
              reconocimientos, quejas o inasistencias para tu equipo.
            </p>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<!-- ========== /NUEVO LAYOUT ========== -->

<script>
  // Variables globales disponibles en todos los formularios
  const usuarioActual = <?php echo json_encode($_SESSION['user_id']); ?>;
  const tipoUsuarioActual = <?php echo json_encode($user_type); ?>;

  // Manejo visual del menú lateral
  function seleccionarMenu(el){
    document.querySelectorAll('.asignacion-menu-item').forEach(btn => {
      btn.classList.remove('active');
    });
    el.classList.add('active');
  }

  // Si quieres que al entrar cargue Tareas automáticamente, descomenta:
  // document.addEventListener('DOMContentLoaded', () => { mostrarTareas(); });
</script>

<!-- ================== FUNCIONES JS ================== -->

<script>
  function mostrarReconocimientos() {
    const itemsDiv = document.querySelector(".items");
    const currentYear = new Date().getFullYear();
    const previousYear = currentYear - 1;

    itemsDiv.innerHTML = `
      <div class="form-container">
        <h2>Otorgar Reconocimiento</h2>

        <form id="formReconocimiento">
          <label for="tipo">Tipo de reconocimiento:</label>
          <select id="tipo" name="tipo" required>
            <option value="">Selecciona un tipo</option>
            <option value="1">Desempeño</option>
            <option value="2">Seguimiento</option>
            <option value="3">Innovación</option>
          </select>

          <label for="reconocimiento">Reconocimiento:</label>
          <select id="reconocimiento" name="reconocimiento" required>
            <option value="">Selecciona un reconocimiento</option>
          </select>

          <label for="recurso">Recurso a reconocer:</label>
          <select id="recurso" name="recurso" required>
            <option value="">Cargando recursos...</option>
          </select>

          <label for="mes_reconocimiento">Fecha del reconocimiento:</label>
          <div class="row">
            <div class="col-md-6">
              <select id="mes_reconocimiento" name="mes_reconocimiento" required class="form-control">
                <option value="">Mes</option>
                ${[
                  "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                  "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                ].map((mes, i) => `<option value="${i + 1}">${mes}</option>`).join("")}
              </select>
            </div>
            <div class="col-md-6">
              <select id="anio_reconocimiento" name="anio_reconocimiento" required class="form-control">
                <option value="">Año</option>
                <option value="${currentYear}">${currentYear}</option>
                <option value="${previousYear}">${previousYear}</option>
              </select>
            </div>
          </div>

          <label for="descripcion" class="mt-3">Descripción:</label>
          <textarea id="descripcion" name="descripcion" rows="4"
                    placeholder="Describe el motivo del reconocimiento" required></textarea>

          <div class="form-buttons mt-3">
            <button type="button" onclick="cancelarFormulario()">Cancelar</button>
            <button type="submit">Otorgar</button>
          </div>
        </form>
      </div>
    `;

    // Reconocimientos según tipo
    const reconocimientosPorTipo = {
      1: ['Puntualidad', 'Mejor vendedor', 'Objetivo Alcanzado', 'Mejor Vendedor', 'Trabajo en equipo'],
      2: ['Cobranza Alcanzada', 'Atención al cliente'],
      3: ['Estrella de Cine', 'Colaborador', 'Extraordinario']
    };

    // Llenar combo reconocimiento según tipo
    document.getElementById("tipo").addEventListener("change", function () {
      const tipoSeleccionado = this.value;
      const combo = document.getElementById("reconocimiento");
      combo.innerHTML = '<option value="">Selecciona un reconocimiento</option>';
      (reconocimientosPorTipo[tipoSeleccionado] || []).forEach(nombre => {
        const option = document.createElement("option");
        option.value = nombre;
        option.textContent = nombre;
        combo.appendChild(option);
      });
    });

    // Llenar combo de recursos (jerarquía)
    fetch("https://mobilitysolutionscorp.com/web/MS_get_usuarios.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        user_id: usuarioActual,
        user_type: tipoUsuarioActual
      })
    })
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById("recurso");  
      select.innerHTML = '<option value="">Selecciona un recurso</option>';

      if (data.success && Array.isArray(data.usuarios)) {
        data.usuarios.forEach(usuario => {
          const option = document.createElement("option");
          option.value = usuario.id;
          option.textContent = usuario.nombre;
          select.appendChild(option);
        });
      } else {
        select.innerHTML = '<option value="">No hay usuarios disponibles</option>';
      }
    })
    .catch(error => {
      console.error("Error al cargar usuarios:", error);
      const select = document.getElementById("recurso");
      select.innerHTML = '<option value="">Error al cargar recursos</option>';
    });

    // Submit del formulario
    document.getElementById("formReconocimiento").addEventListener("submit", function(e) {
      e.preventDefault();

      const tipo = parseInt(document.getElementById("tipo").value);
      const reconocimiento = document.getElementById("reconocimiento").value;
      const asignado = parseInt(document.getElementById("recurso").value);
      const mes = parseInt(document.getElementById("mes_reconocimiento").value);
      const anio = parseInt(document.getElementById("anio_reconocimiento").value);
      const descripcion = document.getElementById("descripcion").value.trim();

      if (!tipo || !reconocimiento || !asignado || !mes || !anio || !descripcion) {
        alert("Todos los campos son obligatorios.");
        return;
      }

      const payload = {
        tipo,
        reconocimiento,
        asignado,
        mes,
        anio,
        descripcion,
        creado_por: usuarioActual
      };

      fetch("https://mobilitysolutionscorp.com/web/MS_save_reconocimiento.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        if (data.success) this.reset();
      })
      .catch(err => {
        console.error("Error al guardar reconocimiento:", err);
        alert("Error al guardar el reconocimiento.");
      });
    });
  }
</script>

<script>
  function mostrarTareas() {
    const itemsDiv = document.querySelector(".items");

    itemsDiv.innerHTML = `
      <div class="form-container">
        <h2>Registrar Tarea</h2>
        <form id="formTarea">
          <label for="nombre_tarea">Nombre de la tarea:</label>
          <input type="text" id="nombre_tarea" name="nombre_tarea" required>

          <label for="responsable_tarea">Asignar a:</label>
          <select id="responsable_tarea" name="responsable_tarea" required>
            <option value="">Cargando opciones...</option>
          </select>

          <label for="descripcion_tarea">Descripción:</label>
          <textarea id="descripcion_tarea" name="descripcion_tarea" rows="4" required></textarea>

          <div class="form-buttons">
            <button type="button" onclick="cancelarFormulario()">Cancelar</button>
            <button type="submit">Guardar</button>
          </div>
        </form>
      </div>
    `;

    // Cargar opciones de responsable con jerarquía
    fetch("https://mobilitysolutionscorp.com/web/MS_get_usuarios.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        user_id: usuarioActual,
        user_type: tipoUsuarioActual
      })
    })
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById("responsable_tarea"); 
      select.innerHTML = '<option value="">Selecciona un recurso</option>';

      if (data.success && Array.isArray(data.usuarios)) {
        data.usuarios.forEach(usuario => {
          const option = document.createElement("option");
          option.value = usuario.id;
          option.textContent = usuario.nombre;
          select.appendChild(option);
        });
      } else {
        select.innerHTML = '<option value="">No hay usuarios disponibles</option>';
      }
    })
    .catch(error => {
      console.error("Error al cargar usuarios:", error);
      const select = document.getElementById("responsable_tarea");
      select.innerHTML = '<option value="">Error al cargar recursos</option>';
    });

    // Envío del formulario
    document.getElementById("formTarea").addEventListener("submit", function(e) {
      e.preventDefault();

      const nombre = document.getElementById("nombre_tarea").value.trim();
      const asignado = document.getElementById("responsable_tarea").value;
      const descripcion = document.getElementById("descripcion_tarea").value.trim();

      if (!nombre || !asignado || !descripcion) {
        alert("Por favor completa todos los campos.");
        return;
      }

      fetch("https://mobilitysolutionscorp.com/web/MS_insert_tarea.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          nombre: nombre,
          asignado: parseInt(asignado),
          descripcion: descripcion,
          creado_por: usuarioActual 
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert(data.message);
          document.getElementById("formTarea").reset();
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch(error => {
        console.error("Error al guardar tarea:", error);
        alert("Ocurrió un error al guardar la tarea.");
      });
    });
  }
</script> 

<script>
  function mostrarMetas() {
    const itemsDiv = document.querySelector(".items");
    const currentYear = new Date().getFullYear();
    const lastYear = currentYear - 1;

    itemsDiv.innerHTML = `
      <div class="form-container">
        <h2>Definir Meta</h2>
        <form id="formMeta">
          <label for="tipo_meta">Tipo de meta:</label>
          <select id="tipo_meta" name="tipo_meta" required>
            <option value="">Selecciona un tipo</option>
            <option value="1">Carga de autos</option>
            <option value="2">Reservas</option>
            <option value="3">Entregas</option>
          </select>

          <label for="responsable_meta">Asignar a:</label>
          <select id="responsable_meta" name="responsable_meta" required>
            <option value="">Cargando opciones...</option>
          </select>

          <label for="anio_meta">Año:</label>
          <select id="anio_meta" name="anio_meta" required>
            <option value="">Selecciona un año</option>
            <option value="${currentYear}">${currentYear}</option>
            <option value="${lastYear}">${lastYear}</option>
          </select>

          <div class="row">
            ${['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
              .map((mes, i) => `
                <div class="col-md-4">
                  <label for="${mes.toLowerCase()}">${mes}:</label>
                  <input type="number" class="input-mes" id="${mes.toLowerCase()}" name="${mes.toLowerCase()}" value="0" min="0" required>
                </div>
              `).join('')
            }
          </div>

          <div class="form-buttons mt-3">
            <button type="button" onclick="cancelarFormulario()">Cancelar</button>
            <button type="submit">Guardar</button>
          </div>
        </form>
      </div>
    `;

    // Cargar usuarios subordinados (jerarquía)
    fetch("https://mobilitysolutionscorp.com/web/MS_get_usuarios.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        user_id: usuarioActual,
        user_type: tipoUsuarioActual
      })
    })
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById("responsable_meta");
      select.innerHTML = '<option value="">Selecciona un recurso</option>';

      if (data.success && Array.isArray(data.usuarios)) {
        data.usuarios.forEach(usuario => {
          const option = document.createElement("option");
          option.value = usuario.id;
          option.textContent = usuario.nombre;
          select.appendChild(option);
        });
      } else {
        select.innerHTML = '<option value="">No hay usuarios disponibles</option>';
      }
    })
    .catch(error => {
      console.error("Error al cargar usuarios:", error);
      const select = document.getElementById("responsable_meta");
      select.innerHTML = '<option value="">Error al cargar recursos</option>';
    });

    // Listener para cargar metas al cambiar selección
    ["tipo_meta", "responsable_meta", "anio_meta"].forEach(id => {
      document.getElementById(id).addEventListener("change", intentarCargarMetas);
    });

    function limpiarInputsMeses() {
      const meses = [
        "enero", "febrero", "marzo", "abril", "mayo", "junio",
        "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"
      ];
      meses.forEach(mes => {
        document.getElementById(mes).value = 0;
      });
    }

    function intentarCargarMetas() {
      const tipo_meta = parseInt(document.getElementById("tipo_meta").value);
      const asignado = parseInt(document.getElementById("responsable_meta").value);
      const anio = parseInt(document.getElementById("anio_meta").value);

      if (!tipo_meta || !asignado || !anio) return;

      limpiarInputsMeses(); // Limpia antes de cargar

      fetch(`https://mobilitysolutionscorp.com/web/MS_get_metas.php?tipo_meta=${tipo_meta}&asignado=${asignado}&anio=${anio}`)
        .then(res => res.json())
        .then(data => {
          if (data.success && data.metas) {
            const meses = [
              "enero", "febrero", "marzo", "abril", "mayo", "junio",
              "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"
            ];
            meses.forEach(mes => {
              document.getElementById(mes).value = data.metas[mes] ?? 0;
            });
          }
        })
        .catch(err => {
          console.error("Error al recuperar metas:", err);
        });
    }

    // Guardar metas
    document.getElementById("formMeta").addEventListener("submit", function(e) {
      e.preventDefault();

      const tipo_meta = parseInt(document.getElementById("tipo_meta").value);
      const asignado = parseInt(document.getElementById("responsable_meta").value);
      const anio = parseInt(document.getElementById("anio_meta").value);

      if (!tipo_meta || !asignado || !anio) {
        alert("Completa todos los campos obligatorios.");
        return;
      }

      const meses = [
        "enero", "febrero", "marzo", "abril", "mayo", "junio",
        "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"
      ];

      const metasPorMes = {};
      for (const mes of meses) {
        metasPorMes[mes] = parseInt(document.getElementById(mes).value) || 0;
      }

      const payload = {
        tipo_meta,
        asignado,
        anio,
        ...metasPorMes,
        creado_por: parseInt(usuarioActual)
      };

      fetch("https://mobilitysolutionscorp.com/web/MS_save_meta.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(payload)
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        if (data.success) document.getElementById("formMeta").reset();
      })
      .catch(err => {
        console.error("Error al guardar meta:", err);
        alert("Error al guardar la meta.");
      });
    });
  }
</script>

<script>
  function mostrarQuejas() {
    const itemsDiv = document.querySelector(".items");

    itemsDiv.innerHTML = `
      <div class="form-container">
        <h2>Registrar Queja</h2>
        <form id="formQueja">
          
          <label for="empleado_queja">Empleado:</label>
          <select id="empleado_queja" name="empleado_queja" required>
            <option value="">Cargando...</option>
          </select>

          <label for="cliente_queja">Cliente:</label>
          <input type="text" id="cliente_queja" name="cliente_queja" required>

          <label for="comentario_queja">Comentario:</label>
          <textarea id="comentario_queja" name="comentario_queja" rows="4" required></textarea>

          <div class="form-buttons mt-3">
            <button type="button" onclick="cancelarFormulario()">Cancelar</button>
            <button type="submit">Guardar</button>
          </div>
        </form>
      </div>
    `;

    // Cargar usuarios subordinados
    fetch("https://mobilitysolutionscorp.com/web/MS_get_usuarios.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        user_id: usuarioActual,
        user_type: tipoUsuarioActual
      })
    })
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById("empleado_queja");
      select.innerHTML = '<option value="">Seleccione empleado</option>';
      if (data.success && Array.isArray(data.usuarios)) {
        data.usuarios.forEach(usuario => {
          select.innerHTML += `<option value="${usuario.id}">${usuario.nombre}</option>`;
        });
      }
    });

    // Guardar Queja
    document.getElementById("formQueja").addEventListener("submit", function(e) {
      e.preventDefault();

      const payload = {
        id_empleado: parseInt(document.getElementById("empleado_queja").value),
        reportado_por: usuarioActual,
        cliente: document.getElementById("cliente_queja").value.trim(),
        comentario: document.getElementById("comentario_queja").value.trim(),
        created_by: usuarioActual
      };

      fetch("https://mobilitysolutionscorp.com/web/MS_queja_insert.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        if (data.success) this.reset();
      });
    });
  }
</script>

<script>
  function mostrarInasistencias() {
    const itemsDiv = document.querySelector(".items");

    itemsDiv.innerHTML = `
      <div class="form-container">
        <h2>Registrar Inasistencia</h2>
        <form id="formInasistencia">
          
          <label for="empleado_inasistencia">Empleado:</label>
          <select id="empleado_inasistencia" name="empleado_inasistencia" required>
            <option value="">Cargando...</option>
          </select>

          <label for="hora_inasistencia">Hora / Registro:</label>
          <input type="time" id="hora_inasistencia" required>

          <label for="comentario_inasistencia">Comentario:</label>
          <textarea id="comentario_inasistencia" name="comentario_inasistencia" rows="4" required></textarea>

          <div class="form-buttons mt-3">
            <button type="button" onclick="cancelarFormulario()">Cancelar</button>
            <button type="submit">Guardar</button>
          </div>
        </form>
      </div>
    `;

    // Cargar usuarios subordinados
    fetch("https://mobilitysolutionscorp.com/web/MS_get_usuarios.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        user_id: usuarioActual,
        user_type: tipoUsuarioActual
      })
    })
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById("empleado_inasistencia");
      select.innerHTML = '<option value="">Seleccione empleado</option>';
      if (data.success && Array.isArray(data.usuarios)) {
        data.usuarios.forEach(usuario => {
          select.innerHTML += `<option value="${usuario.id}">${usuario.nombre}</option>`;
        });
      }
    });

    // Guardar Inasistencia
    document.getElementById("formInasistencia").addEventListener("submit", function(e) {
      e.preventDefault();

      const hora = document.getElementById("hora_inasistencia").value;
      if (!hora) {
        alert("Debe seleccionar una hora");
        return;
      }

      const payload = {
        id_empleado: parseInt(document.getElementById("empleado_inasistencia").value),
        reportado_por: usuarioActual,
        hr_registro: hora,
        comentario: document.getElementById("comentario_inasistencia").value.trim(),
        created_by: usuarioActual
      };

      fetch("https://mobilitysolutionscorp.com/web/MS_inasistencia_insert.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        if (data.success) this.reset();
      });
    });
  }
</script>

<script>
  function cancelarFormulario() {
    if (confirm("¿Estás seguro de que deseas cancelar? Se perderán los datos ingresados.")) {
      document.querySelector(".items").innerHTML = `
        <div class="card ms-card shadow-sm">
          <div class="card-body">
            <p class="mb-1"><strong>Asignaciones</strong></p>
            <p class="text-muted mb-0">
              Selecciona una opción del menú lateral para registrar tareas, metas,
              reconocimientos, quejas o inasistencias para tu equipo.
            </p>
          </div>
        </div>
      `;
    }
  }
</script>

</body>
</html>
