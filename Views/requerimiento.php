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
    <link rel="stylesheet" href="../CSS/Req.css">

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
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/requerimiento.php">Requerimientos</a>
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
header('Content-Type: application/json'); // Asegura que la respuesta es JSON

$selected = isset($_GET['req']) ? $_GET['req'] : '1';
$inc = include "../db/Conexion.php"; 
$vehiculo = null;
$mensaje = "";

if (isset($_POST['verificar'])) {
    $cod = $_POST['id_vehiculo'];

    // Validación básica del ID
    if (empty($cod)) {
        echo json_encode(["error" => "ID de vehículo no proporcionado"]);
        exit;
    }

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
              WHERE auto.id = '$cod'";

    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $vehiculo = mysqli_fetch_assoc($result);
        echo json_encode($vehiculo);  // Respuesta en formato JSON
    } else {
        echo json_encode(["error" => "ID no encontrado"]);  // Respuesta JSON con error
    }
    exit;
}
?>



<div class="menu">
    <a href="?req=1" class="menu-item"><span>📄</span> Reservar</a>
    <a href="?req=2" class="menu-item"><span>⚙️</span> Req 2</a>
    <a href="?req=3" class="menu-item"><span>📊</span> Req 3</a>
    <a href="?req=4" class="menu-item"><span>🔍</span> Req 4</a>
</div>

<div class="content">
<!-- requerimiento numero 1 -->
<?php if ($selected == '1'): ?>
    <!-- Formulario de Consulta -->
    <form id="consultaForm" method="POST">
        <h2>Reserva de vehículo</h2>
        <div class="input-group">
            <label>ID: <input type="text" name="id_vehiculo" id="id_vehiculo" required></label>
            <button type="button" id="consultarBtn">Consultar</button>
        </div>
        <p class="error-msg"><?php echo $mensaje; ?></p>
    </form>

    <!-- Formulario de Reserva (Se llena dinámicamente) -->
    <form id="reservaForm" method="POST">
        <div id="vehiculoInfo" style="display: none;">
            <div class="vehiculo-card">
                <img id="vehiculoImg" src="" alt="Vehículo" class="vehiculo-img">
                <div class="vehiculo-info">
                    <h3 id="vehiculoNombre"></h3>
                    <p><strong>Marca:</strong> <span id="vehiculoMarca"></span></p>
                    <p><strong>Costo:</strong> $<span id="vehiculoCosto"></span></p>
                    <p><strong>Mensualidad:</strong> $<span id="vehiculoMensualidad"></span></p>
                    <p><strong>Sucursal:</strong> <span id="vehiculoSucursal"></span></p>
                    <p><strong>Color:</strong> <span id="vehiculoColor"></span></p>
                    <p><strong>Transmisión:</strong> <span id="vehiculoTransmision"></span></p>
                    <p><strong>Kilometraje:</strong> <span id="vehiculoKilometraje"></span> km</p>
                    <p><strong>Combustible:</strong> <span id="vehiculoCombustible"></span></p>
                </div>
            </div>
            <input type="hidden" name="id_vehiculo" id="hiddenIdVehiculo">
            <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['user_id']; ?>">
            <button class="btn btn-success" type="submit">Solicitar reserva</button>
        </div>
    </form>
<!-- requerimiento numero 2 -->
<?php elseif ($selected == '2'): ?>
    <form>
        <h2>Formulario de Requerimiento 2</h2>
        <label>Descripción: <textarea name="descripcion"></textarea></label>
        <button type="submit">Enviar</button>
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

<script>
    document.getElementById("consultarBtn").addEventListener("click", function() {
        var idVehiculo = document.getElementById("id_vehiculo").value;

        if (idVehiculo.trim() === "") {
            alert("Por favor, ingresa un ID de vehículo.");
            return;
        }

        var formData = new FormData();
        formData.append("id_vehiculo", idVehiculo);
        formData.append("verificar", "1");

        fetch("requerimiento.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())  // Cambiar a .json() directamente
        .then(data => {
            console.log("Respuesta del servidor:", data);  // Ver la respuesta en consola

            if (data.error) {
                alert(data.error);
                document.getElementById("vehiculoInfo").style.display = "none"; // Ocultamos el formulario si no se encuentra el vehículo
            } else {
                // Mostramos el formulario con los datos del vehículo
                document.getElementById("vehiculoInfo").style.display = "block";

                // Asignar los valores a los campos del formulario
                document.getElementById("vehiculoImg").src = '../Imagenes/Catalogo/Auto/' + data.id + '/Img01.jpg';
                document.getElementById("vehiculoNombre").textContent = `${data.nombre} - ${data.modelo}`;
                document.getElementById("vehiculoMarca").textContent = data.marca;
                document.getElementById("vehiculoCosto").textContent = data.costo;
                document.getElementById("vehiculoMensualidad").textContent = data.mensualidad;
                document.getElementById("vehiculoSucursal").textContent = data.sucursal;
                document.getElementById("vehiculoColor").textContent = data.color;
                document.getElementById("vehiculoTransmision").textContent = data.transmision;
                document.getElementById("vehiculoKilometraje").textContent = data.kilometraje;
                document.getElementById("vehiculoCombustible").textContent = data.combustible;
                document.getElementById("hiddenIdVehiculo").value = data.id;
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Ocurrió un error al consultar el vehículo.");
        });
    });
</script>


<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>
