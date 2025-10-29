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
  <section class="contact-section">
    <div class="container">
      <div class="contact-card shadow-lg">

        <div class="row g-0">

          <!-- FORMULARIO -->
          <div class="col-lg-7 p-4 p-md-5 contact-form-col order-lg-1">
            <div class="form-header mb-4">
              <h2 class="form-title">Hablemos 🚗</h2>
              <p class="form-subtitle">
                Cuéntanos qué necesitas (financiamiento, inventario, proceso, dudas de seguridad, etc.)
                y un asesor oficial de Mobility Solutions te responde.
              </p>
            </div>

            <form class="contact-form needs-validation" novalidate>
              <div class="row">

                <div class="col-sm-6 mb-3">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Wendy" required>
                    <label for="firstName">Nombre *</label>
                    <div class="invalid-feedback">Por favor ingresa tu nombre.</div>
                  </div>
                </div>

                <div class="col-sm-6 mb-3">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Ramírez" required>
                    <label for="lastName">Apellidos *</label>
                    <div class="invalid-feedback">Por favor ingresa tus apellidos.</div>
                  </div>
                </div>

                <div class="col-sm-6 mb-3">
                  <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="wendy.apple@gmail.com" required>
                    <label for="email">Email *</label>
                    <div class="invalid-feedback">Necesitamos un correo válido.</div>
                  </div>
                </div>

                <div class="col-sm-6 mb-3">
                  <div class="form-floating">
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="(044)-352272-13" required>
                    <label for="phone">Número telefónico *</label>
                    <div class="invalid-feedback">Ingresa tu número telefónico.</div>
                  </div>
                </div>

                <div class="col-sm-12 mb-3">
                  <div class="form-floating">
                    <textarea class="form-control textarea-auto" id="message" name="message" placeholder="Hola, me gustaría saber..." style="height:120px" required></textarea>
                    <label for="message">¿Cómo podemos ayudarte? *</label>
                    <div class="invalid-feedback">Por favor escribe tu mensaje.</div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <button type="submit" name="submit" class="btn btn-brand w-100 w-md-auto">
                    Enviar mensaje
                  </button>
                </div>

              </div>
            </form>

            <!-- validación bootstrap -->
            <script>
              (function () {
                'use strict';
                var forms = document.querySelectorAll('.needs-validation');
                Array.prototype.slice.call(forms).forEach(function (form) {
                  form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                      event.preventDefault();
                      event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                  }, false);
                });
              })();
            </script>
          </div>

          <!-- PANEL DE CONTACTO / INFO -->
          <div class="col-lg-5 contact-aside order-lg-2">
            <div class="aside-inner">
              <div class="aside-head">
                <h3 class="aside-title">Contacto directo</h3>
                <p class="aside-desc">Solo personal autorizado de Mobility Solutions te contactará.</p>
              </div>

              <ul class="aside-list">
                <li class="info-item">
                  <div class="info-icon">
                    <i class="fa fa-envelope"></i>
                  </div>
                  <div class="info-text">
                    <div class="info-label">Correo</div>
                    <div class="info-value">Atencioncte@mobilitysolutionscorp.com</div>
                  </div>
                </li>

                <li class="info-item">
                  <div class="info-icon">
                    <i class="fa fa-phone"></i>
                  </div>
                  <div class="info-text">
                    <div class="info-label">Teléfono</div>
                    <div class="info-value">(443)-522-7213</div>
                  </div>
                </li>

                <li class="info-item">
                  <div class="info-icon">
                    <i class="fa fa-whatsapp"></i>
                  </div>
                  <div class="info-text">
                    <div class="info-label">WhatsApp</div>
                    <div class="info-value">(551)-095-4444</div>
                    <div class="info-hint">Respuestas más rápidas 📲</div>
                  </div>
                </li>

                <li class="info-item">
                  <div class="info-icon">
                    <i class="fa fa-map-marker"></i>
                  </div>
                  <div class="info-text">
                    <div class="info-label">Oficinas</div>
                    <div class="info-value">
                      Av. P. de la Reforma #505<br>
                      Piso 37, Cuauhtémoc<br>
                      C.P. 06500 CDMX
                    </div>
                  </div>
                </li>
              </ul>

              <div class="trust-box">
                <div class="trust-title">Seguridad y servicio</div>
                <ul class="trust-list">
                  <li>✔ Nunca pedimos depósitos en cuentas personales.</li>
                  <li>✔ Te confirmamos por SMS cuando recibimos tu solicitud.</li>
                  <li>✔ Atendemos de L a S, 9am – 7pm.</li>
                </ul>
              </div>
            </div>

            <!-- fondo decorativo -->
            <div class="aside-blob"></div>
          </div>

        </div><!-- row -->
      </div><!-- contact-card -->
    </div><!-- container -->
  </section>

  <hr class="mt-5 mb-3"/>
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

<script>
  // Mostrar/Ocultar preguntas extra
  (function(){
    const btn = document.getElementById("toggleFaqBtn");
    if (!btn) return;
    btn.addEventListener("click", () => {
      const extras = document.querySelectorAll(".extra-faq");
      if (!extras.length) return;

      const ocultas = extras[0].classList.contains("d-none");

      extras.forEach(el => {
        el.classList.toggle("d-none");
      });

      btn.textContent = ocultas ? "Ver menos" : "Ver más preguntas";
    });
  })();
</script>


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
