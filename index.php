<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobility Solutions Corporation</title>
    <link rel="stylesheet" href="CSS/estilos.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!------ Include the above in your HEAD tag ---------->
</head>

<body>
<!-- Navigation -->
<div class="fixed-top">
  <header class="topbar">
      <div class="container">
        <div class="row">
          <!-- social icon-->
          <div class="col-sm-12">
            <ul class="social-network">
              <li><a class="waves-effect waves-dark" href="https://www.facebook.com/profile.php?id=61563909313215&mibextid=kFxxJD"><i class="fa fa-facebook"></i></a></li>
              <li><a class="waves-effect waves-dark" href="https://maps.app.goo.gl/G2WDrF97WDnzrQGr6"><i class="fa fa-map-marker"></i></a></li>
              <li><a class="waves-effect waves-dark" href="#"><i class="fa fa-user"></i></a></li>
            </ul>
          </div>

        </div>
      </div>
  </header>
  <nav class="navbar navbar-expand-lg navbar-dark mx-background-top-linear">
    <div class="container">
      <a class="navbar-brand" rel="nofollow" target="_blank" href="https://mobilitysolutionscorp.com"> Mobility Solutions Corporation</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">

        <ul class="navbar-nav ml-auto">

          <li class="nav-item active">
            <a class="nav-link" href="https://mobilitysolutionscorp.com">Inicio
              <span class="sr-only">(current)</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/catalogo.php">Catálogo</a>
          </li>

         <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/about_us.php">Nosotros</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/contact.php">Contacto</a>
          </li>

        </ul>

      </div>
    </div>
  </nav>
</div>

<!-- Carousel -->
<div class="div_carrusel">
<div id="demo" class="py-5 carousel slide" data-bs-ride="carousel" py-36>

    <!-- Indicators/dots -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
    </div>
    <!-- The slideshow/carousel -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="Imagenes/Carrusel/carrusel 1.jpg" alt="Los Angeles" class="d-block w-100">
                </div>
                <div class="carousel-item">
                <img src="Imagenes/Carrusel/carrusel 2.jpg" alt="Chicago" class="d-block w-100">
                </div>
                <div class="carousel-item">
                <img src="Imagenes/Carrusel/carrusel 3.jpg" alt="New York" class="d-block w-100">
                </div>
            </div>
    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>
</div>

<main>
  <div class="div_about">
    <section class="py-5 text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="fw-light">🚘 Nuestro balance comercial en números. </h1>
          <p class="lead text-muted">
            Accelerate your dreams ✨️
          </p>
          <p>
          </p>
        </div>
      </div>
    </section>
  </div>

  <div class="album_con">

  <div class="album py-5 bg-warning bg-opacity-25">
    <div class="container">

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        
        <div class="col">

          <div class="count-up-wrapper top">
            <span id="count-up-container-top">0</span>
            <span class="additional-info">Contratos Firmados</span>
          </div>

          <script type="module">
            import { CountUp } from '/js/countup.js/dist/countUP.min.js';
              const options = {
                duration: 100,
                prefix: '+',
              };
              let demo = new CountUp('count-up-container-top', 1356, options);
              if (!demo.error) {
                demo.start();
              } else {
                console.error(demo.error);
              };
          </script>
        </div>

        <div class="col">
          <div class="count-up-wrapper top">
            <span id="count-up-container-top2">0</span>
            <span class="additional-info">MDP Financiado</span>
          </div>

          <script type="module">
            import { CountUp } from '/js/countup.js/dist/countUP.min.js';
              const options2 = {
                duration: 100,
                prefix: '+',
              };
              let demo2 = new CountUp('count-up-container-top2', 356, options2);
              if (!demo2.error) {
                demo2.start();
              } else {
                console.error(demo2.error);
              }
          </script>
        </div>

        <div class="col">
          <div class="count-up-wrapper top">
            <span id="count-up-container-top3">0</span>
            <span class="additional-info">Años de experiencia</span>
          </div>
          
          <script type="module">
            import { CountUp } from '/js/countup.js/dist/countUP.min.js';
              const options3 = {
                duration: 20,
                prefix: '+',
              };
              let demo3 = new CountUp('count-up-container-top3', 10, options3);
              if (!demo3.error) {
                demo3.start();
              } else {
                console.error(demo3.error);
              }
          </script>

        </div>

      </div>
    </div>
  </div>

</div>
</main>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>