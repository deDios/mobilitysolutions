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
    <title>Tareas</title>
    <link rel="shortcut icon" href="../Imagenes/movility.ico" />
    <link rel="stylesheet" href="../CSS/task.css">

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
      <a class="navbar-brand" rel="nofollow" target="_blank" href="#"> Mobility Solutions: Tareas</a>
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

          <li class="nav-item active">
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

<div class="task-wrapper">
  <div class="kanban-section">
    <h2 class="kanban-title">Kanban de tareas</h2>
    <div class="kanban-board">
      <div class="kanban-column" data-status="1">
        <h3>Por hacer</h3>
        <hr>
        <div class="kanban-tasks" id="por-hacer"></div>
      </div>
      <div class="kanban-column" data-status="2">
        <h3>En proceso</h3>
        <hr>
        <div class="kanban-tasks" id="en-proceso"></div>
      </div>
      <div class="kanban-column" data-status="3">
        <h3>Por revisar</h3>
        <hr>
        <div class="kanban-tasks" id="por-revisar"></div>
      </div>
      <div class="kanban-column" data-status="4">
        <h3>Hecho</h3>
        <hr>
        <div class="kanban-tasks" id="hecho"></div>
      </div>
    </div>
  </div>

  <div class="detalle-section">
    <h2>Detalle de tarea</h2>
    <div id="detalle-tarea" class="detalle-content">
      <p><strong>Nombre:</strong> <span id="detalle-nombre"></span></p>
      <p><strong>Descripción:</strong> <span id="detalle-descripcion"></span></p>
      <p><strong>Asignado a:</strong> <span id="detalle-asignado"></span></p>
      <p><strong>Reportado por:</strong> <span id="detalle-creador"></span></p>
      <p><strong>Comentario:</strong> <span id="detalle-comentario"></span></p>
      <p><strong>Creado el:</strong> <span id="detalle-creado"></span></p>
    </div>
  </div>
</div>

<script>
  const userId = <?php echo isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0; ?>;

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
            card.innerHTML = `
              <h4>${tarea.nombre}</h4>
              <p><strong>Asignado a:</strong> ${tarea.asignado_nombre}</p>
              <p><strong>Reportado por:</strong> ${tarea.creado_por_nombre}</p>
            `;

            // Mostrar detalle al hacer clic
            card.addEventListener("click", () => {
              document.getElementById("detalle-nombre").textContent = tarea.nombre;
              document.getElementById("detalle-descripcion").textContent = tarea.descripcion;
              document.getElementById("detalle-asignado").textContent = tarea.asignado_nombre;
              document.getElementById("detalle-creador").textContent = tarea.creado_por_nombre;
              document.getElementById("detalle-comentario").textContent = tarea.comentario || 'N/A';
              document.getElementById("detalle-creado").textContent = tarea.created_at;
            });

            estados[tarea.status]?.appendChild(card);
          });

          // Habilitar columnas como zonas de drop
          document.querySelectorAll('.kanban-column').forEach(column => {
            column.addEventListener('dragover', e => e.preventDefault());

            column.addEventListener('drop', e => {
              e.preventDefault();
              const targetStatus = parseInt(column.dataset.status);
              const draggedCard = document.querySelector('.dragging');
              const tareaId = parseInt(draggedCard.dataset.id);
              const creador = parseInt(draggedCard.dataset.creado_por);

              // Restricción: solo el creador puede mover a "Hecho"
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
                  alert("Error al actualizar el estatus: " + response.message);
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



<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>