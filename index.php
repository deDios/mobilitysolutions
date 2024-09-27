<?php
include "Conexion.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Mobility solutions</title>
    <link rel="stylesheet" href="CSS/estilos.css">
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