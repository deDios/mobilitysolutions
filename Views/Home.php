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
                    <?php if ($r_ejecutivo) { echo "<li>Ejecutivo</li>"; } ?>
                    <?php if ($r_editor) { echo "<li>Editor</li>"; } ?>
                    <?php if ($r_autorizador) { echo "<li>Manager</li>"; } ?>
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
                <span>Reserva</span>
                <strong>0</strong>
            </div>
            <div class="hex" id="hex-entrega">
                <span>Entrega</span>
                <strong>0</strong>
            </div>
        </div>

        <div class="chart-wrapper">
            <canvas id="lineChart"></canvas>
        </div>

        <!-- Sección de Reconocimientos / Skills -->
        <div class="skills-section">
            <h2>Reconocimientos / Skills</h2>
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
      contenedorSkills.innerHTML = "<h2>Reconocimientos / Skills</h2>";

      if (data.success && Array.isArray(data.reconocimientos) && data.reconocimientos.length > 0) {
        const grid = document.createElement("div");
        grid.className = "reconocimientos-wrapper";

        data.reconocimientos.forEach(item => {
          const tipo = parseInt(item.tipo);
          let claseTipo = "";

          switch (tipo) {
            case 1:
              claseTipo = "recono-desempeno";
              break;
            case 2:
              claseTipo = "recono-liderazgo";
              break;
            case 3:
              claseTipo = "recono-innovacion";
              break;
            default:
              claseTipo = "recono-desempeno"; // fallback
          }

          const div = document.createElement("div");
          div.className = `reconocimiento-item ${claseTipo}`;  // <-- importante
          div.innerHTML = `
            <div class="titulo">${item.reconocimiento}</div>
            <div class="fecha">${item.mes}/${item.anio}</div>
          `;
          grid.appendChild(div);
        });

        contenedorSkills.appendChild(grid);
      } else {
        const mensaje = document.createElement("p");
        mensaje.className = "placeholder";
        mensaje.textContent = "No hay reconocimientos asignados.";
        contenedorSkills.appendChild(mensaje);
      }
    })
    .catch(error => {
      console.error("Error al cargar reconocimientos:", error);
    });
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
      'Reserva': 'Reservas por mes',
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
          actualizarGrafica('New');
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