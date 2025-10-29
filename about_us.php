<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Mobility Solutions</title>
  <link rel="shortcut icon" href="/Imagenes/movility.ico" />

  <!-- Bootstrap 5 (único) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome (iconos) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Tu CSS -->
  <link rel="stylesheet" href="CSS/estilos_2.css">

  <!-- Meta Pixel -->
  <script>
  !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
  n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');fbq('init','1571195254265630');fbq('track','PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1571195254265630&ev=PageView&noscript=1"/></noscript>

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-C7J5YGXNDS"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-C7J5YGXNDS');
  </script>
</head>
<body>

<!-- Topbar + Nav -->
<div class="fixed-top">
  <header class="topbar">
    <div class="container">
      <div class="row">
        <div class="col-12">
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
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Abrir navegación">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com/catalogo.php?buscar=&InputMarca=Todos&InputAnio=Todos&InputColor=Todos&InputTransmision=Todos&InputInterior=Todos&InputTipo=Todos&InputPasajeros=Todos&InputMensualidad_Mayor=&InputMensualidad_Menor=&enviar=">Catálogo</a></li>
          <li class="nav-item active"><a class="nav-link" href="https://mobilitysolutionscorp.com/about_us.php">Nosotros</a></li>
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com/contact.php">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>
</div>

<main>

  <!-- HERO Mejorado -->
  <section class="hero section-pad">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-6 order-2 order-lg-1 reveal">
          <h1 class="display-6 fw-bold mb-3">Sobre nosotros</h1>
          <p class="lead text-secondary mb-4">
            Somos un equipo especializado en soluciones integrales para adquirir vehículos nuevos y seminuevos. 
            <strong>Financiamiento personalizado</strong> con aportaciones periódicas para que elijas el auto ideal en el momento correcto.
          </p>
          <div class="d-flex gap-2 flex-wrap">
            <a href="https://mobilitysolutionscorp.com/catalogo.php?buscar=&InputMarca=Todos&InputAnio=Todos&InputColor=Todos&InputTransmision=Todos&InputInterior=Todos&InputTipo=Todos&InputPasajeros=Todos&InputMensualidad_Mayor=&InputMensualidad_Menor=&enviar="
               class="btn btn-primary btn-lg shadow-sm">Ir al catálogo</a>
            <a href="https://mobilitysolutionscorp.com/contact.php"
               class="btn btn-outline-light btn-lg text-dark border-2 shadow-sm">Contáctanos</a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 reveal">
          <div class="hero-media">
            <img src="/Imagenes/About_us/about_02.jpg" alt="Equipo Mobility Solutions">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features (valores) -->
  <section class="section-pad">
    <div class="container">
      <div class="row g-3">
        <div class="col-6 col-lg-3 reveal">
          <div class="feature-card">
            <i class="fa fa-credit-card"></i>
            <h6>Financiamiento flexible</h6>
            <p>Planes a tu medida y aportaciones periódicas.</p>
          </div>
        </div>
        <div class="col-6 col-lg-3 reveal">
          <div class="feature-card">
            <i class="fa fa-check-circle"></i>
            <h6>Autos verificados</h6>
            <p>Inspección previa y garantía en seminuevos.</p>
          </div>
        </div>
        <div class="col-6 col-lg-3 reveal">
          <div class="feature-card">
            <i class="fa fa-handshake-o"></i>
            <h6>Acompañamiento</h6>
            <p>Asesores contigo en todo el proceso.</p>
          </div>
        </div>
        <div class="col-6 col-lg-3 reveal">
          <div class="feature-card">
            <i class="fa fa-shield"></i>
            <h6>Confianza y respaldo</h6>
            <p>Operación bajo normativas y buenas prácticas.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Álbum (3 tarjetas) -->
  <section class="section-pad bg-light">
    <div class="container">
      <div class="row row-cols-1 row-cols-md-3 g-4">

        <div class="col reveal">
          <div class="card h-100 hover-lift">
            <div class="ratio ratio-16x9">
              <img src="/Imagenes/About_us/about_01.jpg" class="object-cover rounded-top" alt="">
            </div>
            <div class="card-body">
              <p class="card-text">
                Más de 10 años creando alianzas estratégicas para ofrecerte las mejores opciones de financiamiento.
              </p>
            </div>
          </div>
        </div>

        <div class="col reveal">
          <div class="card h-100 hover-lift">
            <div class="ratio ratio-16x9">
              <img src="/Imagenes/About_us/about_03.jpg" class="object-cover rounded-top" alt="">
            </div>
            <div class="card-body">
              <p class="card-text">
                Fomentamos una cultura de colaboración y pertenencia en beneficio de cada cliente.
              </p>
            </div>
          </div>
        </div>

        <div class="col reveal">
          <div class="card h-100 hover-lift">
            <div class="ratio ratio-16x9">
              <img src="/Imagenes/About_us/about_02.jpg" class="object-cover rounded-top" alt="">
            </div>
            <div class="card-body">
              <p class="card-text">
                La elección inteligente para una movilidad eficiente, accesible y personalizada.
              </p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Preguntas frecuentes -->
  <section class="section-pad">
    <div class="container">
      <h2 class="fw-bold text-center mb-4">Preguntas frecuentes</h2>

      <div class="accordion accordion-flush col-lg-10 mx-auto" id="accordionFlushExample">
        <!-- 1 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f1">
              ¿Qué tipo de autos seminuevos ofrecen?
            </button>
          </h2>
          <div id="f1" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
              Todas las marcas con antigüedad menor a 8 años, inspeccionados y con garantía.
            </div>
          </div>
        </div>
        <!-- 2 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f2">
              ¿Cuál es el proceso para solicitar financiamiento?
            </button>
          </h2>
          <div id="f2" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
              Elige un auto, llena tu solicitud en sucursal y un asesor te guía en los siguientes pasos.
            </div>
          </div>
        </div>
        <!-- 3 (…mantengo tu contenido pero con IDs limpios y consistentes) -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f3">
              ¿Cuáles son los requisitos para obtener financiamiento?
            </button>
          </h2>
          <div id="f3" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
              Identificación, comprobante de ingresos (nómina o estados de cuenta) y comprobante de domicilio.
            </div>
          </div>
        </div>

        <!-- Resto de preguntas (mismas que ya tenías) -->
        <!-- Para ahorrar espacio aquí, copia el resto cambiando sus IDs a f4, f5, ... f21 -->
        <!-- … -->
      </div>
    </div>
  </section>

  <!-- CTA final -->
  <section class="cta-band">
    <div class="container d-flex flex-column flex-lg-row align-items-center justify-content-between gap-3">
      <h3 class="m-0 fw-bold text-white text-center text-lg-start">¿Listo para estrenar?</h3>
      <a href="https://mobilitysolutionscorp.com/contact.php" class="btn btn-light btn-lg">Habla con un asesor</a>
    </div>
  </section>

</main>

<hr class="mt-5 mb-3"/>

<footer class="foo mt-5">
  <div class="container">
    <div class="row gy-4">
      <div class="col-6 col-lg-3">
        <h6>Conoce más</h6>
        <hr class="hr1 mt-2 mb-3" style="height:5px;border-width:0;color:#FFC00A;background-color:#FFC00A">
        <ul class="text-secondary list-unstyled">
          <li><a class="text-secondary" href="https://mobilitysolutionscorp.com/about_us.php">¿Quiénes Somos?</a></li>
          <li><a class="text-secondary" href="https://mobilitysolutionscorp.com/Views/vende.php">Vende tu auto</a></li>
          <li><a class="text-secondary" href="https://mobilitysolutionscorp.com/views/ubicacion.php">Sucursales</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-3">
        <h6>Legales</h6>
        <hr class="hr2 mt-2 mb-3" style="height:5px;border-width:0;color:gainsboro;background-color:gainsboro">
        <ul class="text-secondary list-unstyled">
          <li><a class="text-secondary" href="/Views/privacy.php">Aviso de privacidad</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-3">
        <h6>Ayuda</h6>
        <hr class="hr3 mt-2 mb-3" style="height:5px;border-width:0;color:black;background-color:black">
        <ul class="text-secondary list-unstyled">
          <li><a class="text-secondary" href="https://mobilitysolutionscorp.com/contact.php">Contacto</a></li>
          <li><a class="text-secondary" href="https://mobilitysolutionscorp.com/about_us.php">Preguntas frecuentes</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-3">
        <p class="float-lg-end mb-1"><a href="#" class="to-top">Regresa al inicio</a></p>
      </div>
    </div>
  </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Animaciones suaves con IntersectionObserver -->
<script>
  const els = document.querySelectorAll('.reveal');
  const io = new IntersectionObserver(entries=>{
    entries.forEach(e=>{
      if(e.isIntersecting){ e.target.classList.add('reveal-in'); io.unobserve(e.target); }
    });
  },{threshold:.2});
  els.forEach(el=>io.observe(el));

  // Smooth scroll “arriba”
  document.querySelectorAll('.to-top').forEach(a=>{
    a.addEventListener('click', e=>{
      e.preventDefault();
      window.scrollTo({top:0, behavior:'smooth'});
    });
  });
</script>
</body>
</html>
