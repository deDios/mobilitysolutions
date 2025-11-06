<?php
// Configuración básica de la página
$title = "Aviso de Privacidad";
$pdf_file = "/DOCS/AP.pdf";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $title; ?></title>
  <link rel="shortcut icon" href="../Imagenes/movility.ico" />

  <!-- Tus hojas existentes -->
  <link rel="stylesheet" href="../CSS/estilos.css">

  <!-- Bootstrap (deja tus cargas tal cual) -->
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- NUEVO estilo aislado para esta vista -->
  <link rel="stylesheet" href="../CSS/privacy.css">

  <!-- Meta Pixel / gtag: dejas igual -->
  <script>
  !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
  n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
  fbq('init','1571195254265630');fbq('track','PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1571195254265630&ev=PageView&noscript=1"/></noscript>

  <script async src="https://www.googletagmanager.com/gtag/js?id=G-C7J5YGXNDS"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date()); gtag('config', 'G-C7J5YGXNDS');
  </script>
</head>
<body>

<!-- ======= NAV (NO TOCAR) ======= -->
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
      <a class="navbar-brand" rel="nofollow" target="_blank" href="https://mobilitysolutionscorp.com">Mobility Solutions</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
              aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active"><a class="nav-link" href="https://mobilitysolutionscorp.com">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com/catalogo.php?buscar=&InputMarca=Todos&InputAnio=Todos&InputColor=Todos&InputTransmision=Todos&InputInterior=Todos&InputTipo=Todos&InputPasajeros=Todos&InputMensualidad_Mayor=&InputMensualidad_Menor=&enviar=">Catálogo</a></li>
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com/about_us.php">Nosotros</a></li>
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com/contact.php">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>
</div>
<!-- ======= /NAV ======= -->

<!-- ======= CONTENIDO REMAKE ======= -->
<main class="privacy-main">
  <!-- HERO -->
  <section class="privacy-hero text-center">
    <div class="container">
      <p class="privacy-eyebrow mb-2">Documento legal</p>
      <h1 class="privacy-title">Aviso de Privacidad</h1>
      <p class="privacy-subtitle mx-auto">
        Conoce cómo recabamos, utilizamos y protegemos tus datos personales en Mobility Solutions Corp.
      </p>
      <div class="d-flex gap-2 justify-content-center flex-wrap mt-3">
        <a href="<?php echo htmlspecialchars($pdf_file); ?>" class="btn btn-dark btn-sm" target="_blank" rel="noopener">
          <i class="fa fa-file-pdf-o me-1"></i> Descargar PDF
        </a>
        <a href="#toc" class="btn btn-outline-dark btn-sm">
          <i class="fa fa-list-ul me-1"></i> Ver índice
        </a>
      </div>
    </div>
  </section>

  <!-- CONTENT -->
  <section class="privacy-content container">
    <div class="row g-4">
      <!-- TOC -->
      <aside class="col-12 col-lg-4 col-xl-3">
        <div id="toc" class="privacy-toc card shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h6 class="mb-0">Contenido</h6>
              <a href="<?php echo htmlspecialchars($pdf_file); ?>" class="small" target="_blank" rel="noopener">PDF</a>
            </div>
            <nav class="nav flex-column privacy-toc-list">
              <a class="nav-link" href="#sec1">I. Finalidades y datos recabados</a>
              <a class="nav-link" href="#sec2">II. Transferencias y remisiones</a>
              <a class="nav-link" href="#sec3">III. Seguridad de los datos</a>
              <a class="nav-link" href="#sec4">IV. Ejercicio de derechos ARCO</a>
              <a class="nav-link" href="#sec5">V. Uso de cookies</a>
              <a class="nav-link" href="#sec6">VI. Cambios al aviso</a>
              <a class="nav-link" href="#sec7">VII. Contacto y DPO</a>
              <a class="nav-link" href="#visor">Visor del Aviso (PDF)</a>
            </nav>
          </div>
        </div>
      </aside>

      <!-- BODY -->
      <div class="col-12 col-lg-8 col-xl-9">
        <div class="privacy-card card shadow-sm">
          <div class="card-body">

            <!-- I -->
            <article id="sec1" class="privacy-section">
              <h5 class="privacy-h">I. Finalidad del tratamiento y datos recabados</h5>
              <p class="privacy-p">
                MSC únicamente solicita los datos personales necesarios para las finalidades descritas. Los datos que podemos solicitar u obtener incluyen:
              </p>
              <ul class="privacy-ul">
                <li>Datos de identificación y contacto</li>
                <li>Datos laborales y financieros</li>
                <li>Datos sensibles (biométricos)</li>
                <li>Datos electrónicos y de geolocalización</li>
              </ul>
              <p class="privacy-p">Vías de obtención:</p>
              <ul class="privacy-ul">
                <li>A) Directamente del cliente/prospecto o por terceros que actúan a nombre de MSC.</li>
                <li>B) Red de agencias (Proveedor de los Vehículos). Son independientes de MSC.</li>
                <li>C) Fabricantes de vehículos. Son independientes de MSC.</li>
              </ul>
              <p class="privacy-p">
                Para funciones como cotizaciones/servicios, puede requerirse registro con datos de identificación, contacto y patrimoniales.
              </p>
              <p class="privacy-p mb-1"><strong>Finalidades primarias (clientes):</strong></p>
              <ol class="privacy-ol">
                <li>Verificar identidad y autenticación conforme a la ley.</li>
                <li>Validación de identificación oficial (INE, biométricos).</li>
                <li>Evaluaciones crediticias (con autorización).</li>
                <li>Contratación (crédito prendario/compra de vehículos).</li>
                <li>Gestión de cobranza y acciones preventivas/reactivas.</li>
                <li>Cumplimiento de obligaciones y requerimientos de autoridad.</li>
                <li>Actualización de datos con red de proveedores.</li>
                <li>Archivo y registro legal relacionado con la relación jurídica.</li>
              </ol>
              <p class="privacy-p mb-1"><strong>Finalidades secundarias (clientes):</strong></p>
              <ul class="privacy-ul">
                <li>Comunicaciones promocionales y prospección</li>
                <li>Ofertas de productos/aliados</li>
                <li>Análisis estadísticos y de mercado</li>
              </ul>
              <div class="privacy-alert">
                Si no deseas finalidades secundarias, puedes oponerte vía derechos ARCO (ver sección IV).
              </div>
              <p class="privacy-p mb-1"><strong>Prospectos:</strong></p>
              <ul class="privacy-ul">
                <li>Atención de solicitudes y cotizaciones</li>
                <li>Comunicación de productos/servicios</li>
              </ul>
            </article>

            <!-- II -->
            <article id="sec2" class="privacy-section">
              <h5 class="privacy-h">II. Transferencia y remisión de datos personales</h5>
              <p class="privacy-p">
                Podemos transferir/remitir datos a terceros con relación jurídica (proveedores, aseguradoras, procesadores de pago, auditores, despachos de cobranza, proveedores/fabricantes de vehículos), para cumplir finalidades del aviso o la relación jurídica.
              </p>
              <p class="privacy-p">
                Para transferencias que requieran consentimiento, a través de este aviso nos lo otorgas; puedes oponerte escribiendo a <b>atcliente@mobilitysolutionscorp.com</b>.
              </p>
              <p class="privacy-p">
                Con fundamento en el art. 37 fracc. III, IV y VII LFPDPPP, se podrán transferir datos a:
              </p>
              <ul class="privacy-ul">
                <li>Red de agencias/distribuidores</li>
                <li>Empresas de seguros</li>
              </ul>
            </article>

            <!-- III -->
            <article id="sec3" class="privacy-section">
              <h5 class="privacy-h">III. Seguridad de los datos personales</h5>
              <p class="privacy-p">
                Implementamos medidas físicas, administrativas y tecnológicas para proteger tus datos contra daño, pérdida, alteración o uso no autorizado. Exigimos a terceros el respeto de nuestras políticas de seguridad.
              </p>
            </article>

            <!-- IV -->
            <article id="sec4" class="privacy-section">
              <h5 class="privacy-h">IV. Ejercicio de derechos ARCO</h5>
              <p class="privacy-p">
                Puedes ejercer acceso, rectificación, cancelación y oposición enviando solicitud a <b>atcliente@mobilitysolutionscorp.com</b>. Incluye:
              </p>
              <ul class="privacy-ul">
                <li>Nombre completo y medio de contacto para respuesta</li>
                <li>Documentos de identidad/representación legal</li>
                <li>Descripción clara de los datos y el derecho que ejerces</li>
                <li>Información adicional que ayude a localizarlos</li>
              </ul>
              <p class="privacy-p small text-muted">
                Plazos orientativos conforme LFPDPPP: 5 días para pedir info adicional; 10 días para responder a ese requerimiento; 20 días para comunicar determinación; 15 días para hacerla efectiva (posible ampliación una sola vez).
              </p>
            </article>

            <!-- V -->
            <article id="sec5" class="privacy-section">
              <h5 class="privacy-h">V. Uso de cookies</h5>
              <p class="privacy-p">
                Utilizamos cookies para mejorar la experiencia (fecha/hora de acceso, tiempo de navegación, secciones visitadas, preferencias, páginas previas). Puedes deshabilitarlas en tu navegador (Chrome, Firefox, IE, Safari).
              </p>
            </article>

            <!-- VI -->
            <article id="sec6" class="privacy-section">
              <h5 class="privacy-h">VI. Cambios al aviso de privacidad</h5>
              <p class="privacy-p">
                Podemos actualizar este aviso para atender cambios legislativos o de operación. Publicaremos la versión vigente en nuestro sitio web.
              </p>
            </article>

            <!-- VII -->
            <article id="sec7" class="privacy-section">
              <h5 class="privacy-h">VII. Departamento de Protección de Datos</h5>
              <p class="privacy-p">
                Para solicitudes ARCO, aclaraciones o comentarios, escribe a <b>atcliente@mobilitysolutionscorp.com</b>.
              </p>
              <p class="privacy-p text-muted mb-0">
                Última actualización: Ciudad de México, 17 de mayo de 2019.
              </p>
            </article>

            <!-- Visor PDF -->
            <article id="visor" class="privacy-section">
              <h5 class="privacy-h">Visor del Aviso (PDF)</h5>
              <div class="ratio ratio-4x3 privacy-pdf">
                <iframe src="<?php echo htmlspecialchars($pdf_file); ?>" title="Aviso de Privacidad PDF" loading="lazy"></iframe>
              </div>
              <div class="text-end mt-2">
                <a class="btn btn-outline-dark btn-sm" href="<?php echo htmlspecialchars($pdf_file); ?>" target="_blank" rel="noopener">
                  <i class="fa fa-download me-1"></i> Descargar
                </a>
              </div>
            </article>

          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Back to top -->
  <a href="#" class="privacy-to-top" aria-label="Volver arriba"><i class="fa fa-arrow-up"></i></a>
</main>

<!-- ======= FOOTER (NO TOCAR) ======= -->
<footer>
  <p>&copy; <?php echo date("Y"); ?> Mobility Solutions. Todos los derechos reservados.</p>
</footer>

<!-- Tus scripts existentes -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" crossorigin="anonymous"></script>

<!-- JS pequeño para TOC activo + scroll suave -->
<script>
  // Scroll suave
  document.querySelectorAll('.privacy-toc a[href^="#"]').forEach(a=>{
    a.addEventListener('click', (e)=>{
      e.preventDefault();
      const id = a.getAttribute('href').substring(1);
      const el = document.getElementById(id);
      if(!el) return;
      window.scrollTo({ top: el.offsetTop - 90, behavior: 'smooth' });
    });
  });

  // TOC activo al hacer scroll
  const sections = Array.from(document.querySelectorAll('.privacy-section'));
  const tocLinks = Array.from(document.querySelectorAll('.privacy-toc a'));
  window.addEventListener('scroll', ()=>{
    const pos = window.scrollY + 120;
    let current = sections[0]?.id;
    sections.forEach(sec=>{ if(sec.offsetTop <= pos) current = sec.id; });
    tocLinks.forEach(l=>{
      l.classList.toggle('active', l.getAttribute('href') === '#'+current);
    });
  });

  // Botón volver arriba
  const toTop = document.querySelector('.privacy-to-top');
  window.addEventListener('scroll', ()=>{
    toTop.classList.toggle('show', window.scrollY > 300);
  });
</script>

</body>
</html>
