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
<div class="dashboard-container">
    <div class="header">
      <div class="hex-box">
        <h2 id="dealsTotal">0</h2>
        <p>New Deals</p>
      </div>
      <div class="hex-box">
        <h2 id="reservasTotal">0</h2>
        <p>Reservations</p>
      </div>
      <div class="hex-box">
        <h2 id="entregasTotal">0</h2>
        <p>Deliveries</p>
      </div>
      <div class="chart-container">
        <canvas id="graficaMetas" height="120"></canvas>
      </div>
    </div>

    <div class="metrics-section">
      <h3>User Metrics</h3>
      <div id="userMetrics" class="metrics-grid"></div>
    </div>

    <div class="recognitions-section">
      <h3>Recognitions</h3>
      <div class="recognitions-placeholder">
        <!-- Espacio reservado para reconocimientos -->
      </div>
    </div>
  </div>
</div>
  <script>
    const globalUserId = 9999;

    async function getData(userId) {
    const metasRes = await fetch(`https://mobilitysolutionscorp.com/web/MS_get_metas_usuario.php?asignado=${userId}`);
    const hexRes = await fetch(`https://mobilitysolutionscorp.com/db_consultas/hex_status.php?user_id=${userId}`);

    const metasData = await metasRes.json();
    const hexData = await hexRes.json();

    return { metas: metasData?.metas || [], hex: hexData || [] };
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

    function renderGrafica(data) {
    const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    const acumulado = new Array(12).fill(0);
    const target = new Array(12).fill(30); // puedes ajustar esto

    data.hex.forEach(row => {
        const mesIndex = meses.indexOf(row.Mes);
        if (mesIndex >= 0) {
        acumulado[mesIndex] += (row.New + row.Reserva + row.Entrega);
        }
    });

    new Chart(document.getElementById("graficaMetas"), {
        type: 'line',
        data: {
        labels: meses,
        datasets: [
            { label: 'New Users', data: acumulado, borderColor: '#3498db', fill: false },
            { label: 'Targets', data: target, borderColor: '#bdc3c7', fill: false }
        ]
        }
    });
    }

    function renderUserCards() {
    const contenedor = document.getElementById("userMetrics");
    contenedor.innerHTML = `
        <div class="user-metric">
        <h4>Total General</h4>
        <div class="user-role">Todos los empleados</div>
        <div class="user-indicators">
            <span id="hexNew">0</span>
            <span id="hexReserva">0</span>
            <span id="hexEntrega">0</span>
        </div>
        </div>
    `;
    }

    async function init() {
    const data = await getData(globalUserId);

    generarTotales(data);
    renderGrafica(data);
    renderUserCards();

    // Actualiza valores en hexágonos de resumen
    let totalNew = 0, totalReserva = 0, totalEntrega = 0;
    data.hex.forEach(row => {
        totalNew += row.New;
        totalReserva += row.Reserva;
        totalEntrega += row.Entrega;
    });

    document.getElementById("hexNew").innerText = totalNew;
    document.getElementById("hexReserva").innerText = totalReserva;
    document.getElementById("hexEntrega").innerText = totalEntrega;
    }

    init();

  </script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>