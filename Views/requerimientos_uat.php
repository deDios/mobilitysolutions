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
    <title>Requerimientos</title>
    <link rel="shortcut icon" href="../Imagenes/movility.ico" />
    <link rel="stylesheet" href="../CSS/reque_uat.css">

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
      <a class="navbar-brand" rel="nofollow" target="_blank" href="#"> Requerimientos </a>
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

         <li class="nav-item active">
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

<?php
$selected = isset($_GET['req']) ? $_GET['req'] : '1';
$inc = include "../db/Conexion.php"; 
$vehiculo = null;

if (isset($_POST['verificar'])) {
    $cod = $_POST['id_vehiculo'];
        $query = "select 
                    auto.id, 
                    m_auto.auto AS nombre, 
                    modelo.nombre AS modelo, 
                    marca.nombre AS marca, 
                    auto.mensualidad, 
                    auto.costo, 
                    sucursal.nombre AS sucursal, 
                    auto.img1, 
                    auto.img2, 
                    auto.img3, 
                    auto.img4, 
                    auto.img5, 
                    auto.img6, 
                    auto.color, 
                    auto.transmision, 
                    auto.interior, 
                    auto.kilometraje, 
                    auto.combustible, 
                    auto.cilindros, 
                    auto.eje, 
                    auto.estatus, 
                    auto.pasajeros, 
                    auto.propietarios, 
                    auto.created_at, 
                    auto.updated_at 
                FROM mobility_solutions.tmx_auto AS auto 
                LEFT JOIN mobility_solutions.tmx_sucursal AS sucursal 
                    ON auto.sucursal = sucursal.id 
                LEFT JOIN mobility_solutions.tmx_estatus AS estatus 
                    ON auto.estatus = estatus.id 
                LEFT JOIN mobility_solutions.tmx_modelo AS modelo 
                    ON auto.modelo = modelo.id 
                LEFT JOIN mobility_solutions.tmx_marca AS marca 
                    ON auto.marca = marca.id 
                LEFT JOIN mobility_solutions.tmx_marca_auto AS m_auto 
                    ON auto.nombre = m_auto.id 
                WHERE auto.estatus = 1
                AND auto.id = '$cod'";
}
    $result = mysqli_query($con,$query);
    if ($result->num_rows > 0) {
        $vehiculo = $result->fetch_assoc();
        $disabled = "";
    } else {
        $mensaje = "ID no encontrado";
    }
?>

<!-- ===== NUEVO LAYOUT · AJUSTES ===== -->
<div class="container ms-settings-wrap">

  <!-- Encabezado compacto con usuario -->
  <div class="ms-head card shadow-sm mb-3">
    <div class="card-body d-flex align-items-center gap-3 flex-wrap">
      <div class="ms-avatar">
        <?php
          $ini = ($nombre ?? 'Usuario').' '.($last_name ?? 'Demo');
          $parts = explode(' ', trim($ini));
          $iniciales = mb_substr($parts[0] ?? 'U',0,1).mb_substr($parts[1] ?? '',0,1);
          echo htmlspecialchars(strtoupper($iniciales));
        ?>
      </div>
      <div class="flex-grow-1">
        <div class="h5 mb-0"><?= htmlspecialchars(($nombre ?? 'Usuario').' '.($last_name ?? 'Demo')) ?></div>
        <small class="text-muted"><?= htmlspecialchars($user_name ?? 'usuario') ?> · <?= htmlspecialchars($user_type ?? 'Rol') ?></small>
      </div>
      <a class="btn btn-outline-dark btn-sm" href="https://mobilitysolutionscorp.com/db_consultas/cerrar_sesion.php">
        <i class="fa fa-sign-out me-1"></i>Salir
      </a>
    </div>
  </div>

  <div class="row g-3">
    <!-- Sidebar -->
    <aside class="col-12 col-lg-3">
      <nav class="list-group ms-side sticky-lg-top">
        <a href="?req=1" class="list-group-item list-group-item-action <?= ($selected=='1'?'active':'') ?>">
          <i class="fa fa-bookmark-o me-2"></i> Reservar
        </a>
        <a href="?req=2" class="list-group-item list-group-item-action <?= ($selected=='2'?'active':'') ?>">
          <i class="fa fa-truck me-2"></i> Entrega de vehículo
        </a>
        <div class="list-group-item disabled d-flex align-items-center" title="Próximamente">
          <i class="fa fa-bar-chart me-2"></i> Req 3
        </div>
        <div class="list-group-item disabled d-flex align-items-center" title="Próximamente">
          <i class="fa fa-search me-2"></i> Req 4
        </div>
      </nav>
    </aside>

    <!-- Contenido -->
    <section class="col-12 col-lg-9">
      <?php if ($selected == '1'): ?>
        <!-- ============ RESERVAR ============ -->
        <div class="card ms-card shadow-sm">
          <div class="card-header d-flex align-items-center justify-content-between">
            <span class="fw-semibold"><i class="fa fa-bookmark-o me-2"></i> Reserva de vehículo</span>
          </div>
          <div class="card-body">
            <form method="POST" onsubmit="/* deja tu submit */">
              <div class="row g-2 align-items-end">
                <div class="col-sm-8">
                  <label class="form-label small">ID del vehículo</label>
                  <input type="text" class="form-control" name="id_vehiculo" placeholder="Ej. 1234">
                </div>
                <div class="col-sm-4">
                  <button type="submit" name="verificar" class="btn btn-brand w-100">
                    <i class="fa fa-search me-1"></i> Consultar
                  </button>
                </div>
              </div>

              <p class="error-msg mt-2 mb-0"><?= $mensaje ?? '' ?></p>

              <?php if (!empty($vehiculo['marca'])): ?>
              <div class="ms-vehiculo card shadow-sm mt-3">
                <div class="card-body d-flex gap-3 flex-wrap">
                  <img class="ms-veh-img" src="../Imagenes/Catalogo/Auto <?= $vehiculo['id'];?>/Img01.jpg" alt="Vehículo">
                  <div class="flex-grow-1">
                    <div class="h6 mb-1"><?= htmlspecialchars($vehiculo['nombre']) ?> · <?= htmlspecialchars($vehiculo['modelo']) ?></div>
                    <div class="small text-muted mb-2"><?= htmlspecialchars($vehiculo['marca']) ?> — <?= htmlspecialchars($vehiculo['sucursal']) ?></div>
                    <div class="row g-2 small">
                      <div class="col-sm-6"><strong>Costo:</strong> $<?= number_format($vehiculo['costo']) ?></div>
                      <div class="col-sm-6"><strong>Mensualidad:</strong> $<?= number_format($vehiculo['mensualidad']) ?></div>
                      <div class="col-sm-6"><strong>Color:</strong> <?= htmlspecialchars($vehiculo['color']) ?></div>
                      <div class="col-sm-6"><strong>Transmisión:</strong> <?= htmlspecialchars($vehiculo['transmision']) ?></div>
                      <div class="col-sm-6"><strong>Kilometraje:</strong> <?= number_format($vehiculo['kilometraje']) ?> km</div>
                      <div class="col-sm-6"><strong>Combustible:</strong> <?= htmlspecialchars($vehiculo['combustible']) ?></div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="text-end mt-3">
                <button class="btn btn-success" type="button" id="boton_reserva" 
                  data-marca="<?= isset($vehiculo['marca']) ? $vehiculo['marca'] : '' ?>"
                  data-vehiculo='<?= json_encode($vehiculo) ?>'
                  data-usuario='<?= json_encode($user_id) ?>'
                  <?= isset($vehiculo['marca']) ? '' : 'disabled'; ?>>
                  <i class="fa fa-send-o me-1"></i> Solicitar reserva
                </button>
              </div>
              <?php endif; ?>
            </form>
          </div>
        </div>
      <?php elseif ($selected == '2'): ?>
        <!-- ============ VENTA DE AUTO ============ -->
        <div class="card ms-card shadow-sm">
          <div class="card-header d-flex align-items-center justify-content-between">
            <span class="fw-semibold"><i class="fa fa-truck me-2"></i> Autos reservados — Entrega</span>
            <button type="button" class="btn btn-outline-dark btn-sm" onclick="cargarAutos()">
              <i class="fa fa-refresh me-1"></i> Actualizar
            </button>
          </div>
          <div class="card-body">
            <div class="d-flex flex-wrap gap-2 justify-content-between mb-2">
                <div class="input-group input-group-sm ms-w-280">
                <span class="input-group-text bg-white"><i class="fa fa-search"></i></span>
                <input id="filtroAutos" type="text" class="form-control" placeholder="Filtrar por marca/modelo/sucursal...">
                </div>
                <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-secondary" onclick="cargarAutos()">
                    <i class="fa fa-refresh me-1"></i> Actualizar
                </button>
                </div>
            </div>
            <div id="listaAutos" class="ms-lista-autos"></div>
            </div>

        </div>
      <?php endif; ?>
    </section>
  </div>
</div>
<!-- ===== /NUEVO LAYOUT · AJUSTES ===== -->


<script>
  // Helpers de UI
  function msStatusBadgeCls(s){
    if(!s) return 'bg-warning-subtle text-dark';
    s = s.toLowerCase();
    if(s.includes('aprob')) return 'bg-success-subtle text-success';
    if(s.includes('declin') || s.includes('rechaz')) return 'bg-danger-subtle text-danger';
    return 'bg-warning-subtle text-dark';
  }

  function renderTablaReservas(autos){
    const wrap = document.getElementById('listaAutos');
    const q = (document.getElementById('filtroAutos')?.value || '').trim().toLowerCase();

    // Filtro simple en cliente
    const filtrados = autos.filter(a=>{
      if(!q) return true;
      const texto = [
        a.id, a.marca, a.modelo, a.nombre, a.sucursal, a.status_req
      ].filter(Boolean).join(' ').toLowerCase();
      return texto.includes(q);
    });

    if(!filtrados.length){
      wrap.innerHTML = '<div class="alert alert-warning mb-0">No hay vehículos en reserva con ese filtro.</div>';
      return;
    }

    const rows = filtrados.map(a => `
      <tr>
        <td class="text-muted">${a.id}</td>
        <td>
          <div class="d-flex align-items-center gap-2">
            <img class="ms-thumb" src="../Imagenes/Catalogo/Auto ${a.id}/Img01.jpg"
                 onerror="this.src='https://via.placeholder.com/96x64?text=Auto';" alt="">
            <div>
              <div class="fw-semibold">${a.marca ?? ''} ${a.modelo ?? ''}</div>
              <small class="text-muted">${a.nombre ?? ''}</small>
            </div>
          </div>
        </td>
        <td>${a.sucursal ?? '-'}</td>
        <td><span class="badge rounded-pill ${msStatusBadgeCls(a.status_req)}">${a.status_req ?? 'pendiente'}</span></td>
        <td class="text-end">
          <button class="btn btn-sm btn-success" data-id_auto="${a.id}">
            <i class="fa fa-check me-1"></i> Confirmar entrega
          </button>
        </td>
      </tr>
    `).join('');

    wrap.innerHTML = `
      <div class="table-responsive ms-table-wrap">
        <table class="table table-hover align-middle ms-table">
          <thead>
            <tr>
              <th style="width:80px">ID</th>
              <th>Vehículo</th>
              <th style="min-width:140px">Sucursal</th>
              <th style="min-width:120px">Estado</th>
              <th class="text-end" style="width:180px">Acciones</th>
            </tr>
          </thead>
          <tbody>${rows}</tbody>
        </table>
      </div>
    `;

    // Reasigna eventos de acción
    wrap.querySelectorAll('button[data-id_auto]').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const id_auto = btn.getAttribute('data-id_auto');
        const id_usuario = <?= (int)$user_id ?>;
        confirmarEntrega(id_auto, id_usuario);
      });
    });
  }

  // Sobrescribe tu cargarAutos para usar la tabla
  function cargarAutos() {
    const wrap = document.getElementById('listaAutos');
    wrap.innerHTML = '<div class="text-center text-muted py-3">Cargando...</div>';

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "https://mobilitysolutionscorp.com/db_consultas/api_reservados.php", true);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          try {
            const autos = JSON.parse(xhr.responseText) || [];
            renderTablaReservas(autos);

            // filtrar al tipear
            const filtro = document.getElementById('filtroAutos');
            if (filtro && !filtro.__wired) {
              filtro.__wired = true;
              filtro.addEventListener('input', ()=> renderTablaReservas(autos));
            }
          } catch (e) {
            console.error("Error JSON:", e);
            wrap.innerHTML = '<div class="alert alert-danger mb-0">Error al procesar la respuesta.</div>';
          }
        } else {
          wrap.innerHTML = '<div class="alert alert-danger mb-0">Error al cargar la información.</div>';
        }
      }
    };

    xhr.onerror = function(){
      wrap.innerHTML = '<div class="alert alert-danger mb-0">Error en la solicitud.</div>';
    };

    xhr.send();
  }

  // ya llamas cargarAutos() en DOMContentLoaded en tu código
</script>


<script>
    let todosLosRequerimientos = []; // Almacenará todos los requerimientos
    let userId = <?php echo $user_id; ?>;

    async function cargarLista(cod) {
        const lista = document.getElementById("listaRequerimientos");
        lista.innerHTML = "Cargando...";

        try {
            // Corrección en la interpolación de la URL
            const response = await fetch(`https://mobilitysolutionscorp.com/db_consultas/api_requerimientos.php?cod=${cod}`);
            
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const datos = await response.json();
            lista.innerHTML = "";

            if (datos.length === 0) {
                lista.innerHTML = "No hay requerimientos disponibles.";
                return;
            }

            // Guardamos todos los requerimientos
            todosLosRequerimientos = datos;

            // Mostramos todos los requerimientos inicialmente
            mostrarRequerimientos(todosLosRequerimientos);

        } catch (error) {
            lista.innerHTML = "Error al cargar los datos.";
            console.error("Error en la carga de requerimientos:", error);
        }
    }

    function mostrarRequerimientos(requerimientos) {
        const lista = document.getElementById("listaRequerimientos");
        lista.innerHTML = "";  // Limpiar lista antes de agregar nuevos elementos

        if (requerimientos.length === 0) {
            lista.innerHTML = "No hay requerimientos disponibles.";
            return;
        }

        requerimientos.forEach(req => {
            let li = document.createElement("li");
            li.innerHTML = `
                <strong>Requerimiento:</strong> ${req.id} <br>
                <strong>Auto:</strong> ${req.id_auto} <br>
                ${req.tipo_req} ${req.status_req ? `- (<strong>${req.status_req}</strong>)` : ""} <br><br>
                <strong>${req.rechazo_coment ? `- (<strong>${req.rechazo_coment}</strong>)` : ""}</strong>
            `;
            li.classList.add(req.status_req || ""); // Evita error si es null
            lista.appendChild(li);
        });
    }

    function filtrarLista(status) {
        // Filtramos los requerimientos por el estado seleccionado
        const requerimientosFiltrados = todosLosRequerimientos.filter(req => req.status_req === status);
        mostrarRequerimientos(requerimientosFiltrados);
    }

    // Llamada inicial con ID de prueba
    cargarLista(userId);

</script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const botonReserva = document.getElementById("boton_reserva");
        const marca = botonReserva.getAttribute("data-marca");

        // Deshabilita el botón si la marca está vacía
        if (!marca.trim()) {
            botonReserva.disabled = true;
        }

        botonReserva.addEventListener("click", function () {
            const vehiculoData = botonReserva.getAttribute("data-vehiculo");
            const usuarioData = botonReserva.getAttribute("data-usuario");

            if (!vehiculoData || !usuarioData) {
                alert("Faltan datos para la reserva.");
                return;
            }

            const vehiculo = JSON.parse(vehiculoData);
            const usuario = { id: usuarioData };  // Aquí agregamos la propiedad id

            fetch("../db_consultas/insert_sp_req.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ vehiculo, usuario })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Reserva realizada con éxito.");
                    window.location.href = window.location.pathname;
                } else {
                    alert("Error al realizar la reserva.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Ocurrió un error inesperado.");
            });
        });
    }); 
    </script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>