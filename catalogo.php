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
            <a href="" class="nav-link">Cotizador</a>
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
        <div class="menu_item">

        </div>
        <div class="item">
            <figure>
                <img src="Imagenes/Catalogo/Auto 1/Img01.jpg" alt="Auto 1">
            </figure>
            <div class="info-producto">
                <h2>Versa Nissans 2025</h2>
                Plaza Andares, Jal. CP 44940 | 40,000KM
                <p class="Precio">$150,000</p>
                <button>Detalle</button>
            </div>
        </div>
        <div class="item">
            <figure>
                <img src="Imagenes/Catalogo/Auto 1/Img01.jpg" alt="Auto 1">
            </figure>
            <div class="info-producto">
                <h2>Versa Nissans 2025</h2>
                Plaza Andares, Jal. CP 44940 | 40,000KM
                <p class="Precio">$150,000</p>
                <button>Detalle</button>
            </div>
        </div>
        <div class="item">
            <figure>
                <img src="Imagenes/Catalogo/Auto 1/Img01.jpg" alt="Auto 1">
            </figure>
            <div class="info-producto">
                <h2>Versa Nissans 2025</h2>
                Plaza Andares, Jal. CP 44940 | 40,000KM
                <p class="Precio">$150,000</p>
                <button>Detalle</button>
            </div>
        </div>
        <div class="item">
            <figure>
                <img src="Imagenes/Catalogo/Auto 1/Img01.jpg" alt="Auto 1">
            </figure>
            <div class="info-producto">
                <h2>Versa Nissans 2025</h2>
                Plaza Andares, Jal. CP 44940 | 40,000KM
                <p class="Precio">$150,000</p>
                <button>Detalle</button>
            </div>
        </div>
        
    </div>
 </body>
 </html>
