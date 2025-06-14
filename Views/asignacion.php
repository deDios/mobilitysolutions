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
            <a class="nav-link" href="https://mobilitysolutionscorp.com/Views/Autoriza.php">Aprobaciones</a>
          </li>

          <li class="nav-item active">
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
          <li><i class="icon">&#128221;</i> Tareas</li>         <!-- Bloc de notas o tarea -->
          <li><i class="icon">&#127942;</i> Metas</li>          <!-- Medalla como símbolo de logro/meta -->
          <li onclick="mostrarReconocimientos()" style="cursor: pointer;">
            <i class="icon">&#127775;</i> Reconocimientos
          </li> <!-- Estrella como reconocimiento -->
        </ul>
      </div>

      <!-- Botón descubrir más -->
      <div class="discover-more">
        <button onclick="mostrarMas()">Más opciones</button>
        <div id="masOpciones" class="hidden">
          <ul>
            <li>Dashboard ventas</li>
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
  function mostrarReconocimientos() {
    const itemsDiv = document.querySelector(".items");
    itemsDiv.innerHTML = `
      <div class="form-container">
        <h2>Otorgar Reconocimiento</h2>

        <form id="formReconocimiento">
          <label for="tipo">Tipo de reconocimiento:</label>
          <select id="tipo" name="tipo" required>
            <option value="">Selecciona un tipo</option>
            <option value="Desempeño">Desempeño</option>
            <option value="Liderazgo">Liderazgo</option>
            <option value="Innovación">Innovación</option>
          </select>

          <label for="reconocimiento">Reconocimiento:</label>
          <select id="reconocimiento" name="reconocimiento" required>
            <option value="">Selecciona un reconocimiento</option>
            <option value="Estrella del mes">Estrella del mes</option>
            <option value="Campeón de ideas">Campeón de ideas</option>
            <option value="Líder positivo">Líder positivo</option>
          </select>

          <label for="recurso">Recurso a reconocer:</label>
          <select id="recurso" name="recurso" required>
            <option value="">Selecciona un recurso</option>
            <option value="1">Pablo de Dios</option>
            <option value="2">Fiona la Grande</option>
            <option value="3">Barry Allen</option>
            <!-- Puedes llenar esto dinámicamente desde PHP si lo deseas -->
          </select>

          <label for="descripcion">Descripción:</label>
          <textarea id="descripcion" name="descripcion" rows="4" placeholder="Describe el motivo del reconocimiento" required></textarea>

          <div class="form-buttons">
            <button type="button" onclick="cancelarFormulario()">Cancelar</button>
            <button type="submit">Otorgar</button>
          </div>
        </form>
      </div>
    `;

    // Añadir evento submit
    document.getElementById("formReconocimiento").addEventListener("submit", function(e) {
      e.preventDefault();
      alert("Reconocimiento otorgado con éxito.");
      this.reset(); // Limpia el formulario si deseas
    });
  }

  function cancelarFormulario() {
    if (confirm("¿Estás seguro de que deseas cancelar? Se perderán los datos ingresados.")) {
      document.getElementById("formReconocimiento").reset();
      document.querySelector(".items").innerHTML = ""; // Limpia el div
    }
  }
  </script>



<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>