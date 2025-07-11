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
        else {
            $titulo_profesional = implode(" | ", $roles_activos);
        }    
    }

    if ($user_id != 1 && $user_id != 4) {
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
    <title>Asignaciones</title>
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
   
    <link rel="stylesheet" href="../CSS/tareas.css?v=1.1">


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
      <a class="navbar-brand" rel="nofollow" target="_blank" href="#"> Asignaciones </a>
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

<div class="contenedor">

  <div class="menu_c">
    <div class="sidebar">
      <!-- Perfil del usuario -->
      <div class="user-card">
        <img src="../Imagenes/Usuarios/<?php echo $user_id; ?>.jpg?<?php echo time(); ?>" alt="Foto de perfil" class="profile-pic">
        <h3><?php echo $nombre_usuario; ?></h3>
        <p class="title"><?php echo $titulo_profesional; ?></p>
        <hr>
        <p class="connections">500+ conexiones</p>
        <a href="Home.php" class="view-profile">Ver perfil completo</a>
      </div>

      <!-- Accesos rápidos -->
      <div class="quick-access">
        <h4>Asignaciones</h4>
        <ul>
          <li onclick="mostrarTareas()" style="cursor: pointer;">
            <i class="icon">&#128221;</i> Tareas
          </li>
          <li onclick="mostrarMetas()" style="cursor: pointer;">
            <i class="icon">&#127942;</i> Metas
          </li>
          <li onclick="mostrarReconocimientos()" style="cursor: pointer;">
            <i class="icon">&#127775;</i> Reconocimientos
          </li>
        </ul>
      </div>

      <!-- Botón descubrir más -->
      <div class="discover-more">
        <button onclick="mostrarMas()">Más opciones</button>
        <div id="masOpciones" class="hidden">
          <ul>
            <li><a class="nav-link" href="https://mobilitysolutionscorp.com/Views/reporte.php"> Dashboar General </a></li>
            <li>Dashboard rendimientos</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="items">
  </div>

</div>

<script>
function mostrarMas() {
  const mas = document.getElementById("masOpciones");
  mas.classList.toggle("hidden");
}
</script>

<script>
  const usuarioActual = <?php echo json_encode($_SESSION['user_id']); ?>;

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
            <option value="2">Liderazgo</option>
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
          <textarea id="descripcion" name="descripcion" rows="4" placeholder="Describe el motivo del reconocimiento" required></textarea>

          <div class="form-buttons mt-3">
            <button type="button" onclick="cancelarFormulario()">Cancelar</button>
            <button type="submit">Otorgar</button>
          </div>
        </form>
      </div>
    `;

    // Reconocimientos según tipo
    const reconocimientosPorTipo = {
      1: ['Empleado del mes', 'Mejor vendedor', 'Objetivo logrado'],
      2: ['Líder'],
      3: ['Innovador']
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

    // Llenar combo de recursos
    fetch('https://mobilitysolutionscorp.com/web/MS_get_usuarios.php')
      .then(response => response.json())
      .then(data => {
        const select = document.getElementById("recurso");
        select.innerHTML = '<option value="">Selecciona un recurso</option>';
        data.forEach(usuario => {
          const option = document.createElement("option");
          option.value = usuario.id;
          option.textContent = usuario.nombre;
          select.appendChild(option);
        });
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

  function cancelarFormulario() {
    if (confirm("¿Estás seguro de que deseas cancelar? Se perderán los datos ingresados.")) {
      document.querySelector(".items").innerHTML = "";
    }
  }
</script>


<script>
  const usuarioActual = <?php echo json_encode($_SESSION['user_id']); ?>;
</script>

<script>
  function mostrarTareas() {
    const itemsDiv = document.querySelector(".items");

    // HTML del formulario
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

    // Cargar opciones del combo "responsable_tarea"
    fetch('https://mobilitysolutionscorp.com/web/MS_get_usuarios.php')
      .then(response => response.json())
      .then(data => {
        const select = document.getElementById("responsable_tarea");
        select.innerHTML = '<option value="">Selecciona un recurso</option>';
        data.forEach(usuario => {
          const option = document.createElement("option");
          option.value = usuario.id;
          option.textContent = usuario.nombre;
          select.appendChild(option);
        });
      })
      .catch(error => {
        console.error("Error al cargar usuarios:", error);
        const select = document.getElementById("responsable_tarea");
        select.innerHTML = '<option value="">Error al cargar usuarios</option>';
      });

    // Manejar envío del formulario
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

  function cancelarFormulario() {
    if (confirm("¿Estás seguro de que deseas cancelar? Se perderán los datos ingresados.")) {
      document.querySelector(".items").innerHTML = "";
    }
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

    // Cargar usuarios
    fetch('https://mobilitysolutionscorp.com/web/MS_get_usuarios.php')
      .then(response => response.json())
      .then(data => {
        const select = document.getElementById("responsable_meta");
        select.innerHTML = '<option value="">Selecciona un recurso</option>';
        data.forEach(usuario => {
          const option = document.createElement("option");
          option.value = usuario.id;
          option.textContent = usuario.nombre;
          select.appendChild(option);
        });
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

      limpiarInputsMeses(); // Siempre limpia antes de cargar

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



<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>