<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mobility Solutions</title>
  <link rel="shortcut icon" href="/Imagenes/movility.ico" />

  <!-- CSS propio -->
  <link rel="stylesheet" href="CSS/estilos_uat.css">

  <!-- Bootstrap 5.3 (única versión) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Font Awesome (si usas clases fa-*) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- jQuery (solo si lo necesitas para otras partes) -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- Meta Pixel Code -->
  <script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');fbq('init', '1571195254265630');fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1571195254265630&ev=PageView&noscript=1"/></noscript>
  <!-- End Meta Pixel Code -->

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-C7J5YGXNDS"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date()); gtag('config', 'G-C7J5YGXNDS');
  </script>
</head>

<body>
<!-- Navigation -->
<div class="fixed-top">
  <header class="topbar">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <ul class="social-network">
            <li><a class="waves-effect waves-dark" href="https://www.facebook.com/profile.php?id=61563909313215&mibextid=kFxxJD"><i class="fa fa-facebook"></i></a></li>
            <li><a class="waves-effect waves-dark" href="https://www.instagram.com/mobility__solutions?igsh=MTA5cWFocWhqNmlqYw=="><i class="fa fa-instagram"></i></a></li>
            <li><a class="waves-effect waves-dark" href="https://mobilitysolutionscorp.com/views/ubicacion.php"><i class="fa fa-map-marker"></i></a></li>
            <li><a class="waves-effect waves-dark" href="https://mobilitysolutionscorp.com/views/login.php"><i class="fa fa-user"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>

  <nav class="navbar navbar-expand-lg navbar-dark mx-background-top-linear">
    <div class="container">
      <a class="navbar-brand" href="https://mobilitysolutionscorp.com">Mobility Solutions</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
              aria-controls="navbarResponsive" aria-expanded="false" aria-label="Alternar navegación">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item active">
            <a class="nav-link" href="https://mobilitysolutionscorp.com">Inicio<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/catalogo.php?buscar=&InputMarca=Todos&InputAnio=Todos&InputColor=Todos&InputTransmision=Todos&InputInterior=Todos&InputTipo=Todos&InputPasajeros=Todos&InputMensualidad_Mayor=&InputMensualidad_Menor=&enviar=">Catálogo</a>
          </li>
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com/about_us.php">Nosotros</a></li>
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com/contact.php">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>
</div>

<!-- Carousel con padding horizontal y mayor altura -->
<div class="div_carrusel">
  <div class="carousel-shell"><!-- NUEVO wrapper para padding lateral -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
      <div class="carousel-inner rounded-3 shadow">
        <div class="carousel-item active">
          <a href="https://mobilitysolutionscorp.com/catalogo.php?buscar=&InputMarca=Todos&InputAnio=Todos&InputColor=Todos&InputTransmision=Todos&InputInterior=Todos&InputTipo=Todos&InputPasajeros=Todos&InputMensualidad_Mayor=&InputMensualidad_Menor=&enviar=">
            <img src="Imagenes/Carrusel/carrusel 1.jpg" class="d-block w-100" alt="Catálogo">
          </a>
        </div>
        <div class="carousel-item">
          <a href="https://mobilitysolutionscorp.com/Views/vende.php">
            <img src="Imagenes/Carrusel/carrusel 4.jpg" class="d-block w-100" alt="Vende tu auto">
          </a>
        </div>
        <div class="carousel-item">
          <img src="Imagenes/Carrusel/carrusel 2.jpg" class="d-block w-100" alt="Banner 2">
        </div>
        <div class="carousel-item">
          <img src="Imagenes/Carrusel/carrusel 3.jpg" class="d-block w-100" alt="Banner 3">
        </div>

        <!-- Controles -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
          <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
          <span class="visually-hidden">Siguiente</span>
        </button>
      </div>
    </div>
  </div>

  <!-- Thumbs circulares (con el mismo padding lateral del shell) -->
  <div class="carousel-thumbs mt-3">
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="thumb active" aria-label="Slide 1">
      <img src="Imagenes/Carrusel/carrusel 1.jpg" alt="Preview 1">
    </button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" class="thumb" aria-label="Slide 2">
      <img src="Imagenes/Carrusel/carrusel 4.jpg" alt="Preview 2">
    </button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" class="thumb" aria-label="Slide 3">
      <img src="Imagenes/Carrusel/carrusel 2.jpg" alt="Preview 3">
    </button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3" class="thumb" aria-label="Slide 4">
      <img src="Imagenes/Carrusel/carrusel 3.jpg" alt="Preview 4">
    </button>
  </div>
</div>

<main>
  <!-- Encabezado/claim -->
  <div class="div_about">
    <section class="py-3 text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="fw-bold">🚘 Nuestro balance comercial en números.</h1>
          <p class="lead text-muted">Power your progress ✨</p>
        </div>
      </div>
    </section>
  </div>

  <!-- KPIs -->
  <div class="album py-3 bg-warning bg-opacity-25">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

        <div class="col">
          <div class="count-up-wrapper top">
            <span id="count-up-container-top">0</span>
            <span class="additional-info">Entregas 📈</span>
          </div>
          <script type="module">
            import { CountUp } from '/js/countup.js/dist/countUP.min.js';
            const options = { duration: 2.2, prefix: '+' };
            const demo = new CountUp('count-up-container-top', 1356, options);
            if (!demo.error) demo.start(); else console.error(demo.error);
          </script>
        </div>

        <div class="col">
          <div class="count-up-wrapper top">
            <span id="count-up-container-top2">0</span>
            <span class="additional-info">MDP Financiado</span>
          </div>
          <script type="module">
            import { CountUp } from '/js/countup.js/dist/countUP.min.js';
            const options2 = { duration: 2.2, prefix: '+' };
            const demo2 = new CountUp('count-up-container-top2', 356, options2);
            if (!demo2.error) demo2.start(); else console.error(demo2.error);
          </script>
        </div>

        <div class="col">
          <div class="count-up-wrapper top">
            <span id="count-up-container-top3">0</span>
            <span class="additional-info">Años de experiencia</span>
          </div>
          <script type="module">
            import { CountUp } from '/js/countup.js/dist/countUP.min.js';
            const options3 = { duration: 2.2, prefix: '+' };
            const demo3 = new CountUp('count-up-container-top3', 10, options3);
            if (!demo3.error) demo3.start(); else console.error(demo3.error);
          </script>
        </div>

      </div>
    </div>
  </div>

  <!-- Reseña destacada (testimonial) -->
<section class="container my-5">
  <div class="row g-4 align-items-stretch">
    <!-- Columna IZQUIERDA: Frases -->
    <div class="col-12 col-lg-6">
      <div class="card motivation-card h-100 shadow-sm border-0">
        <div class="card-body p-4">
          <h3 class="fw-bold mb-3">¿Listo para tu seminuevo?</h3>
          <p class="text-muted mb-4">Un auto perfecto para tu momento. Inspírate:</p>

          <!-- Rotador de frases -->
          <div class="quote-rotator" aria-live="polite">
            <div class="quote active">“Estrena confianza: un seminuevo certificado rinde como nuevo.”</div>
            <div class="quote">“Paga menos, maneja más: rendimiento y estilo sin devaluación.”</div>
            <div class="quote">“Elige inteligente: historial claro, precio honesto, valor real.”</div>
            <div class="quote">“Tu próximo destino empieza con este volante.”</div>
            <div class="quote">“Seminuevo premium: tecnología, seguridad y ahorro en un solo paso.”</div>
            <div class="quote">“Manejo de alto nivel sin romper tu presupuesto.”</div>
            <div class="quote">“Cada kilómetro cuenta cuando pagas el precio correcto.”</div>
            <div class="quote">“Apuesta por el valor, no por la etiqueta de ‘nuevo’.”</div>
            <div class="quote">“Menos trámites, más momentos al volante.”</div>
            <div class="quote">“Hoy tomas la decisión, mañana disfrutas el camino.”</div>
          </div>

          <div class="d-flex gap-2 mt-3">
            <span class="qdot active"></span><span class="qdot"></span><span class="qdot"></span><span class="qdot"></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Columna DERECHA: Reseñas (tu carrusel existente) -->
    <div class="col-12 col-lg-6">
      <div id="reviewCarousel" class="carousel slide testimonial h-100" data-bs-ride="carousel" data-bs-interval="8000">
        <div class="carousel-inner h-100">
          <?php 
            $inc = include "db/Conexion.php";
            if ($inc){
              $query = "SELECT Id, Nombre, Dias, Descripcion 
                        FROM mobility_solutions.tmx_resenas 
                        ORDER BY RAND() LIMIT 6;";
              $result = mysqli_query($con,$query);
              $isFirst = true;
              if ($result){
                while($row = mysqli_fetch_assoc($result)){
                  $id = (int)$row['Id'];
                  $Nombre = $row['Nombre'];
                  $Dias = (int)$row['Dias'];
                  $Descripcion = $row['Descripcion'];
                  ?>
                  <div class="carousel-item <?= $isFirst ? 'active' : '' ?>">
                    <div class="card testimonial-card shadow-sm border-0 h-100">
                      <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                          <div class="position-relative reviewer-avatar">
                            <img src="Imagenes/Perfil_resena/Img<?= $id ?>.jpg" class="rounded-circle" alt="Foto <?= htmlspecialchars($Nombre) ?>">
                            <img src="Imagenes/logo_google.jpg" class="logo-mini" alt="Google">
                          </div>
                          <div class="flex-grow-1">
                            <h5 class="mb-0"><?= htmlspecialchars($Nombre) ?></h5>
                            <div class="stars" aria-label="5 estrellas">★★★★★</div>
                            <small class="text-muted"><?= $Dias ?> días atrás</small>
                          </div>
                        </div>
                        <p class="mb-3 text-secondary lh-base"><?= nl2br(htmlspecialchars($Descripcion)) ?></p>
                        <div class="testimonial-photo mt-3">
                          <img src="Imagenes/Entregas/entrega<?= ($id % 6) + 1 ?>.jpg" alt="Entrega Mobility" onerror="this.style.display='none'">
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                  $isFirst = false;
                }
              } else {
                echo '<div class="carousel-item active"><div class="alert alert-warning m-0">No pudimos cargar reseñas por ahora.</div></div>';
              }
              if ($result) { mysqli_free_result($result); }
            }
          ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span><span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span><span class="visually-hidden">Siguiente</span>
        </button>
      </div>
    </div>
  </div>
</section>


</main>

<hr class="mt-5 mb-3"/>

<footer class="foo mt-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <h6>Conoce más</h6>
        <hr class="hr1 mt-2 mb-3">
        <ul class="text-secondary list-unstyled">
          <li><a class="text-secondary" href="https://mobilitysolutionscorp.com/about_us.php">¿Quiénes Somos?</a></li>
          <li><a class="text-secondary" href="https://mobilitysolutionscorp.com/Views/vende.php">Vende tu auto</a></li>
          <li><a class="text-secondary" href="https://mobilitysolutionscorp.com/views/ubicacion.php">Sucursales</a></li>
        </ul>
      </div>
      <div class="col-lg-3">
        <h6>Legales</h6>
        <hr class="hr2 mt-2 mb-3">
        <ul class="text-secondary list-unstyled">
          <li><a class="text-secondary" href="/Views/privacy.php">Aviso de privacidad</a></li>
        </ul>
      </div>
      <div class="col-lg-3">
        <h6>Ayuda</h6>
        <hr class="hr3 mt-2 mb-3">
        <ul class="text-secondary list-unstyled">
          <li><a class="text-secondary" href="https://mobilitysolutionscorp.com/contact.php">Contacto</a></li>
          <li><a class="text-secondary" href="https://mobilitysolutionscorp.com/about_us.php">Preguntas frecuentes</a></li>
        </ul>
      </div>
      <div class="col-lg-3">
        <p class="float-end mb-1"><a href="#">Regresa al inicio</a></p>
      </div>
    </div>
  </div>
</footer>

<!-- JS: activar thumb activo al cambiar slide -->
<script>
  const hero = document.getElementById('heroCarousel');
  if (hero){
    hero.addEventListener('slid.bs.carousel', e => {
      const idx = e.to;
      document.querySelectorAll('.carousel-thumbs .thumb').forEach((b,i)=>{
        b.classList.toggle('active', i===idx);
      });
    });
  }
</script>

<script>
  (function(){
    const quotes = Array.from(document.querySelectorAll('.quote-rotator .quote'));
    const dots   = Array.from(document.querySelectorAll('.qdot'));
    if(!quotes.length) return;

    let idx = 0;
    function show(i){
      quotes.forEach((q,k)=> q.classList.toggle('active', k===i));
      dots.forEach  ((d,k)=> d.classList.toggle('active',  k===i%dots.length));
    }
    show(idx);

    setInterval(()=>{
      idx = (idx + 1) % quotes.length;
      show(idx);
    }, 6000);
  })();
</script>


</body>
</html>
