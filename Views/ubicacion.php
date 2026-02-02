<?php
session_start();

    echo '<script>
            window.location = "../index.php";
          </script>';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sucursales</title>
    <link rel="shortcut icon" href="../Imagenes/movility.ico" />
    <!-- Tu CSS previo (si lo usas en otras vistas); aquí no es necesario modificarlo -->
    <link rel="stylesheet" href="../CSS/contact.css">

    <!-- Bootstrap & fuentes (igual a tu plantilla original) -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- CSS NUEVO AISLADO PARA ESTA VISTA -->
    <link rel="stylesheet" href="../CSS/locations.css">

    <!-- Meta Pixel Code (original, sin cambios) -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1571195254265630');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1571195254265630&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->

    <!-- Google tag (gtag.js) (original, sin cambios) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-C7J5YGXNDS"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-C7J5YGXNDS');
    </script>
</head>
<body>
    
<!-- ================== NAV (ORIGINAL SIN CAMBIOS) ================== -->
<div class="fixed-top">
  <header class="topbar">
      <div class="container">
        <div class="row">
          <!-- social icon-->
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
      <a class="navbar-brand" rel="nofollow" target="_blank" href="https://mobilitysolutionscorp.com"> Mobility Solutions</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">

        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com">Inicio
              <span class="sr-only">(current)</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/catalogo.php?buscar=&InputMarca=Todos&InputAnio=Todos&InputColor=Todos&InputTransmision=Todos&InputInterior=Todos&InputTipo=Todos&InputPasajeros=Todos&InputMensualidad_Mayor=&InputMensualidad_Menor=&enviar=">Catálogo</a>
          </li>

         <li class="nav-item">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/about_us.php">Nosotros</a>
          </li>

          <li class="nav-item active">
            <a class="nav-link" href="https://mobilitysolutionscorp.com/contact.php">Contacto</a>
          </li>

        </ul>

      </div>
    </div>
  </nav>
</div>
<!-- ================== /NAV ================== -->

<!-- ================== CONTENIDO (REMAKE) ================== -->
<main class="loc-main">

  <!-- Hero -->
  <section class="loc-hero text-center">
    <div class="container">
      <p class="loc-eyebrow mb-2">Encuentra tu sucursal</p>
      <h1 class="loc-title">Nuestras Sucursales</h1>
      <p class="loc-subtitle mx-auto">Localiza la agencia más cercana y agenda tu visita.</p>

      <div class="loc-quick mt-3">
        <div class="input-group input-group-sm loc-search">
          <span class="input-group-text bg-white"><i class="fa fa-search"></i></span>
          <input id="locFilter" type="text" class="form-control" placeholder="Filtrar por ciudad o dirección...">
        </div>
        <div class="loc-chipbar">
          <button class="btn btn-outline-dark btn-sm loc-chip" data-city="CDMX">CDMX</button>
          <button class="btn btn-outline-dark btn-sm loc-chip" data-city="Guadalajara">Guadalajara</button>
          <button class="btn btn-outline-dark btn-sm loc-chip" data-city="León">León</button>
          <button class="btn btn-outline-dark btn-sm loc-chip" data-city="Morelia">Morelia</button>
          <button class="btn btn-outline-dark btn-sm loc-chip" data-city="Puebla">Puebla</button>
          <button class="btn btn-link btn-sm text-decoration-none" id="locClear">Limpiar</button>
        </div>
      </div>
    </div>
  </section>

  <!-- Mapa + listado -->
  <section class="container loc-content">
    <div class="row g-4">
      <div class="col-12 col-lg-7">
        <div class="loc-map card shadow-sm">
          <div class="card-header d-flex align-items-center justify-content-between">
            <span class="fw-semibold"><i class="fa fa-map-marker me-2"></i> Mapa de sucursales</span>
            <!-- Botón "Abrir en Google Maps" REMOVIDO -->
          </div>
          <div class="card-body p-0">
            <div class="ratio ratio-4x3 loc-mapframe">
              <iframe
                id="locMyMap"
                src="https://www.google.com/maps/d/embed?mid=1tICZQyAbkrtIbcuZ5U8Vf4UiSR8&ehbc=2E312F"
                title="Mapa de sucursales MSC"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
              ></iframe>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-5">
        <div class="loc-list">
          <!-- Tarjetas de sucursales -->
          <div class="loc-card card shadow-sm" data-city="CDMX">
            <div class="card-body d-flex gap-3">
              <img class="loc-thumb" src="../Imagenes/ubicaciones/cdmx.jpg" alt="Sucursal CDMX"
                   onerror="this.src='https://via.placeholder.com/160x120?text=CDMX'">
              <div class="flex-grow-1">
                <div class="d-flex align-items-start justify-content-between">
                  <h5 class="loc-name">CDMX</h5>
                  <span class="badge text-bg-dark">Centro</span>
                </div>
                <p class="loc-addr mb-0">Av. P. de la Reforma #505 Piso 37, Cuauhtémoc, 06500</p>
              </div>
            </div>
          </div>

          <div class="loc-card card shadow-sm" data-city="Guadalajara">
            <div class="card-body d-flex gap-3">
              <img class="loc-thumb" src="../Imagenes/ubicaciones/gdl.jpg" alt="Sucursal Guadalajara"
                   onerror="this.src='https://via.placeholder.com/160x120?text=GDL'">
              <div class="flex-grow-1">
                <div class="d-flex align-items-start justify-content-between">
                  <h5 class="loc-name">Guadalajara</h5>
                  <span class="badge text-bg-dark">Occidente</span>
                </div>
                <p class="loc-addr mb-0">Av Rafael Sanzio #150, Camichines Vallarta, 45020</p>
              </div>
            </div>
          </div>

          <div class="loc-card card shadow-sm" data-city="León">
            <div class="card-body d-flex gap-3">
              <img class="loc-thumb" src="../Imagenes/ubicaciones/leon.jpg" alt="Sucursal León"
                   onerror="this.src='https://via.placeholder.com/160x120?text=Le%C3%B3n'">
              <div class="flex-grow-1">
                <div class="d-flex align-items-start justify-content-between">
                  <h5 class="loc-name">León</h5>
                  <span class="badge text-bg-dark">Bajío</span>
                </div>
                <p class="loc-addr mb-0">Blvd. Juan Alonso de Torres Pte. #2002, Valle del Campestre, 37150</p>
              </div>
            </div>
          </div>

          <div class="loc-card card shadow-sm" data-city="Morelia">
            <div class="card-body d-flex gap-3">
              <img class="loc-thumb" src="../Imagenes/ubicaciones/morelia.jpg" alt="Sucursal Morelia"
                   onerror="this.src='https://via.placeholder.com/160x120?text=Morelia'">
              <div class="flex-grow-1">
                <div class="d-flex align-items-start justify-content-between">
                  <h5 class="loc-name">Morelia</h5>
                  <span class="badge text-bg-dark">Centro</span>
                </div>
                <p class="loc-addr mb-0">C. Vicente Sta. María #1516, Félix Ireta, 58070</p>
              </div>
            </div>
          </div>

          <div class="loc-card card shadow-sm" data-city="Puebla">
            <div class="card-body d-flex gap-3">
              <img class="loc-thumb" src="../Imagenes/ubicaciones/puebla.jpg" alt="Sucursal Puebla"
                   onerror="this.src='https://via.placeholder.com/160x120?text=Puebla'">
              <div class="flex-grow-1">
                <div class="d-flex align-items-start justify-content-between">
                  <h5 class="loc-name">Puebla</h5>
                  <span class="badge text-bg-dark">Centro</span>
                </div>
                <p class="loc-addr mb-0">C. Ignacio Allende #512, Santiago Momoxpan, 72774</p>
              </div>
            </div>
          </div>

          <!-- Mensaje vacío por filtro -->
          <div id="locEmpty" class="alert alert-warning d-none">No hay sucursales con ese filtro.</div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA inferior -->
  <section class="loc-cta text-center">
    <div class="container">
      <h3 class="mb-2">¿No encuentras una cerca?</h3>
      <p class="text-muted mb-3">Escríbenos y te atendemos por el canal que prefieras.</p>
      <a class="btn btn-dark btn-sm" href="https://mobilitysolutionscorp.com/contact.php">
        <i class="fa fa-envelope me-1"></i> Contacto
      </a>
    </div>
  </section>
</main>
<!-- ================== /CONTENIDO ================== -->

<hr class="mb-5"/> 

<!-- ================== FOOTER (ORIGINAL SIN CAMBIOS) ================== -->
<footer class="foo mt-5">  
  <div class="container">    
    <div class="row">      
      <div class="col-lg-3">        
        <h6>Conoce más</h6>  
        <hr class="hr1 mt-2 mb-3" style="height:5px;border-width:0;color:#FFC00A;background-color:#FFC00A">    
        <ul class="text-secondary list-unstyled">
        <li>
            <a class="text-secondary" href="https://mobilitysolutionscorp.com/about_us.php">¿Quiénes Somos?</a>
          </li>
          <li>
            <a class="text-secondary" href="https://mobilitysolutionscorp.com/Views/vende.php">Vende tu auto</a>
          </li>
          <li>
            <a class="text-secondary" href="https://mobilitysolutionscorp.com/views/ubicacion.php">Sucursales</a>
          </li>
          
        </ul>     
      </div>      
      <div class="col-lg-3">        
        <h6>Legales</h6>    
        <hr class="hr2 mt-2 mb-3" style="height:5px;border-width:0;color:gainsboro;background-color:gainsboro">     
        <ul class="text-secondary list-unstyled">
          <li>
            <a class="text-secondary" href="/Views/privacy.php">Aviso de privacidad</a>
          </li>
        </ul>       
      </div>      
      <div class="col-lg-3">        
        <h6>Ayuda</h6>    
        <hr class="hr3 mt-2 mb-3" style="height:5px;border-width:0;color:black;background-color:black">    
        <ul class="text-secondary list-unstyled">
          <li>
            <a class="text-secondary" href="https://mobilitysolutionscorp.com/contact.php">Contacto</a>
          </li>
          <li>
            <a class="text-secondary" href="https://mobilitysolutionscorp.com/about_us.php">Preguntas frecuentes</a>
          </li>
        </ul>     
      </div>  
      <div class="col-lg-3">     
        <p class="float-end mb-1">
          <a href="#">Regresa al inicio</a>
        </p>
      </div>    
    </div>  
  </div>
</footer>
<!-- ================== /FOOTER ================== -->

<!-- Scripts originales -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" crossorigin="anonymous"></script>

<!-- JS de filtro y chips (sin interacciones con el mapa) -->
<script>
  const $filter = document.getElementById('locFilter');
  const $cards = Array.from(document.querySelectorAll('.loc-card'));
  const $empty = document.getElementById('locEmpty');

  function applyFilter(text){
    const q = (text || '').toLowerCase().trim();
    let visibles = 0;
    $cards.forEach(c=>{
      const city = (c.dataset.city||'').toLowerCase();
      const addr = (c.querySelector('.loc-addr')?.textContent||'').toLowerCase();
      const name = (c.querySelector('.loc-name')?.textContent||'').toLowerCase();
      const match = !q || city.includes(q) || addr.includes(q) || name.includes(q);
      c.classList.toggle('d-none', !match);
      if(match) visibles++;
    });
    $empty.classList.toggle('d-none', visibles>0);
  }

  if($filter){
    $filter.addEventListener('input', e=> applyFilter(e.target.value));
  }

  // Chips
  document.querySelectorAll('.loc-chip').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      const city = btn.getAttribute('data-city');
      $filter.value = city;
      applyFilter(city);
      // realce visual en la primera coincidencia (sin scroll al mapa)
      const first = $cards.find(c=> (c.dataset.city||'').toLowerCase() === city.toLowerCase());
      if(first){
        first.classList.add('loc-highlight');
        setTimeout(()=> first.classList.remove('loc-highlight'), 1200);
      }
    });
  });

  document.getElementById('locClear')?.addEventListener('click', ()=>{
    $filter.value='';
    applyFilter('');
  });

  // Eliminado: click en tarjeta -> scroll al mapa
</script>
</body>
</html>
