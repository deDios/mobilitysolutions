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
    <header>
        <a href="#" class="logo">
            <img src="logo_MSC.png" alt="Logo de la compañia">
            <h2 class="Nombre de la empresa">
                Mobility Solutions Corporation
            </h2>
        </a>
        <nav>
            <a href="index.php" class="nav-link" title="Home">Inicio</a>
            <a href="catalogo.php" class="nav-link" title="Home">Catálogo</a>
            <a href="" class="nav-link">Sobre nosotros</a>
            <a href="" class="nav-link">Contacto</a>
        </nav>
    </header>
    <div class="slider-box">
        <ul>
            <li>
                <img src="Imagenes/Carrusel/carrusel 2.jpg" alt="">
                <img src="Imagenes/Carrusel/carrusel 1.jpg" alt="">
                <div class="Texto_carrusel">
                    <h2>Imagen 1</h2>
                    <p>
                        Descripción de primer imagen
                    </p>
                </div>
            </li>
            <li>
                <img src="Imagenes/Carrusel/carrusel 1.jpg" alt="">
                <img src="Imagenes/Carrusel/carrusel 2.jpg" alt="">
                <div class="Texto_carrusel">
                    <h2>Imagen 2</h2>
                    <p>
                        Descripción de segunda imagen
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