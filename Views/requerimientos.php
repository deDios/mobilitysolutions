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
    <link rel="stylesheet" href="../CSS/reque.css">

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
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/Autoriza.php">Aprobaciones</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#">Tareas</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#">Tableros</a>
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

    <div class="menu">
        <a href="?req=1" class="menu-item"><span>📄</span> Reservar</a>
        <a href="?req=2" class="menu-item"><span>⚙️</span> Venta de auto</a>
        <a href="?req=3" class="menu-item"><span>📊</span> Req 3</a>
        <a href="?req=4" class="menu-item"><span>🔍</span> Req 4</a>
    </div>

<div class="container_req">
    <div class="requerimientos">
        <div class="botones">
            <button onclick="filtrarLista('curso')">Pendientes</button>
            <button onclick="filtrarLista('aprobado')">Aprobados</button>
            <button onclick="filtrarLista('declinado')">Declinados</button>
        </div>
        <ul id="listaRequerimientos">
        </ul>
    </div>
    <div class="content">
        <?php if ($selected == '1'): ?>
            <form method="POST">
                <h2>Reserva de vehículo</h2>
                <div class="input-group">
                    <label>ID: <input type="text" name="id_vehiculo"></label>
                    <button type="submit" name="verificar" class="btn-icon">
                    Consultar 
                    </button>
                </div>
                <p class="error-msg"><?php echo $mensaje; ?></p>
                <?php if (!empty($vehiculo['marca'])): ?>
                <!-- Muestra el div solo si hay datos del vehículo -->
                <div class="vehiculo-card">
                    <img src="../Imagenes/Catalogo/Auto <?php echo $vehiculo['id'];?>/Img01.jpg" alt="Vehículo" class="vehiculo-img">
                    <div class="vehiculo-info">
                        <h3><?php echo $vehiculo['nombre']; ?> - <?php echo $vehiculo['modelo']; ?></h3>
                        <p><strong>Marca:</strong> <?php echo $vehiculo['marca']; ?></p>
                        <p><strong>Costo:</strong> $<?php echo number_format($vehiculo['costo']); ?></p>
                        <p><strong>Mensualidad:</strong> $<?php echo number_format($vehiculo['mensualidad']); ?></p>
                        <p><strong>Sucursal:</strong> <?php echo $vehiculo['sucursal']; ?></p>
                        <p><strong>Color:</strong> <?php echo $vehiculo['color']; ?></p>
                        <p><strong>Transmisión:</strong> <?php echo $vehiculo['transmision']; ?></p>
                        <p><strong>Kilometraje:</strong> <?php echo number_format($vehiculo['kilometraje']); ?> km</p>
                        <p><strong>Combustible:</strong> <?php echo $vehiculo['combustible']; ?></p>
                    </div>
                </div>
                <?php endif; ?>
                <div class="boton_reserva py-3">
                    <button class="btn btn-success" type="button" id="boton_reserva" 
                        data-marca="<?php echo isset($vehiculo['marca']) ? $vehiculo['marca'] : ''; ?>"
                        data-vehiculo='<?php echo json_encode($vehiculo); ?>'
                        data-usuario='<?php echo json_encode($user_id); ?>'
                        <?php echo isset($vehiculo['marca']) ? '' : 'disabled'; ?>>
                        Solicitar reserva
                    </button>
                </div>
            </form>
        <?php elseif ($selected == '2'): ?>
            <form>
                <h2 style="text-align: center;">Vehículos en reserva</h2> <br> 
                <div id="listaAutos"></div>
            </form>
        <?php elseif ($selected == '3'): ?>
            <form>
                <h2>Formulario de Requerimiento 3</h2>
                <label>Archivo: <input type="file" name="archivo"></label>
                <button type="submit">Subir</button>
            </form>
        <?php else: ?>
            <form>
                <h2>Formulario de Requerimiento 4</h2>
                <label>Fecha: <input type="date" name="fecha"></label>
                <button type="submit">Confirmar</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<script>
    async function cargarAutos() {
        try {
            const respuesta = await fetch(`https://mobilitysolutionscorp.com/db_consultas/api_reservados.php`);
            const autos = await respuesta.json();
            
            let html = "";
            autos.forEach(auto => {
                html += `
                    <div class="car-card">
                        <p>${auto.id} - ${auto.marca} / ${auto.modelo} (${auto.nombre})</p>
                        <button data-id_auto="${auto.id}" onclick="cambiarEstado(event, this)">Confirmar entrega</button>
                    </div>
                `;
            });

            document.getElementById("listaAutos").innerHTML = html;
        } catch (error) {
            console.error("Error al cargar los autos:", error);
        }
    }

    async function cambiarEstado(event, boton) {

        const id_auto = boton.getAttribute("data-id_auto");
        const id_usuario = <?php echo $user_id; ?>; // Obtenemos el usuario desde PHP

        const data = {
            vehiculo: { id: parseInt(id_auto) },
            usuario: { id: parseInt(id_usuario) }
        };

        try {
            const respuesta = await fetch(`https://mobilitysolutionscorp.com/db_consultas/insert_sp_req_venta.php`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            });

            const resultado = await respuesta.json();

            if (resultado.success) {
                alert("El estado del auto ha sido cambiado con éxito.");
                cargarAutos(); // Recargar la lista
            } else {
                alert(resultado.message || "Ocurrió un error al cambiar el estado.");
            }
        } catch (error) {
            console.error("Error en la solicitud:", error);
            alert("Ocurrió un error inesperado.");
        }
    }

    document.addEventListener("DOMContentLoaded", cargarAutos);
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