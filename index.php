<?php
include "Conexion.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Pablo de Dios">
    <title>Mobility Solutions Corporation</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/headers/">
    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>  
    <!-- Custom styles for this template -->
    <link href="CSS/headers.css" rel="stylesheet">
</head>
<body>

<header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><img src="logo_MSC.png" alt="Logo de la compañia"></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="index.php" class="nav-link px-2 text-secondary">Home</a></li>
          <li><a href="catalogo.php" class="nav-link px-2 text-white">Catalogo</a></li>
          <li><a href="#" class="nav-link px-2 text-white">Sobre nosotros</a></li>
          <li><a href="#" class="nav-link px-2 text-white">Contacto</a></li>
        </ul>
      </div>
    </div>
  </header>

<div class="slider-box">
        <ul>
            <li>
                <img src="Imagenes/Carrusel/carrusel 1.jpg" alt="">
                <div class="Texto_carrusel">
                    <h2></h2>
                    <p>
                        
                    </p>
                </div>
            </li>
            <li>
                <img src="Imagenes/Carrusel/carrusel 2.jpg" alt="">
                <div class="Texto_carrusel">
                    <h2></h2>
                    <p>
                        
                    </p>
                </div>
            </li>
            <li>
                <img src="Imagenes/Carrusel/carrusel 3.jpg" alt="">
                <div class="Texto_carrusel">
                    <h2>Imagen 3</h2>
                    <p>
                        Descripción de tercer imagen
                    </p>
                </div>
            </li>
        </ul>
</div>

</body>
</html>