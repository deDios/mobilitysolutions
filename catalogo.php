<?php
include "Conexion.php";
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="stylesheet" href="CSS/catalogo.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 </head>
 <body>
    <header>
        <a href="index.php" class="logo" title="Home">
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
    
    <div class="Menu-lateral">
        <h1>Catálogo</h1>
    </div>

    <div class="Titulo-boton">
        <input type="text" placeholder="Buscar...">
    </div>
    <div class="container-items">
        <div class="item">
            <figure>
                <img src="Imagenes/Catalogo/Auto 1/Img01.jpg" alt="Auto 1">
            </figure>
            <div class="info-producto">
                <h2>Versa Nissan 2025</h2>
                Plaza Andares, Jal. CP 44940 | 40,000KM
                <p class="Precio">$150,000</p>
                <button>Detalle</button>
            </div>
        </div>
        <div class="item">
            <figure>
                <img src="Imagenes/Catalogo/Auto 2/Img01.jpg" alt="Auto 2">
            </figure>
            <div class="info-producto">
                <h2>Focus Ford 2023</h2>
                Plaza Galerias, Mich. CP 44940 | 65,000KM
                <p class="Precio">$185,000</p>
                <button>Detalle</button>
            </div>
        </div>
        <div class="item">
            <figure>
                <img src="Imagenes/Catalogo/Auto 3/Img01.jpg" alt="Auto 3">
            </figure>
            <div class="info-producto">
                <h2>Mazda 2 Mazda 2024</h2>
                Plaza Andares, Jal. CP 44940 | 4,000KM
                <p class="Precio">$210,000</p>
                <button>Detalle</button>
            </div>
        </div>
        <div class="item">
            <figure>
                <img src="Imagenes/Catalogo/Auto 4/Img01.jpg" alt="Auto 4">
            </figure>
            <div class="info-producto">
                <h2>Figo Ford 2019</h2>
                Plaza Chapalita, Jal. CP 44940 | 115,000KM
                <p class="Precio">$65,000</p>
                <button>Detalle</button>
            </div>
        </div>
    </div>
 </body>
 </html>
