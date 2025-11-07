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
               class="btn btn-warning btn-lg shadow-sm">Ir al catálogo</a>
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
 <section class="section-pad" id="faqs">
  <div class="container reveal">
    <h2 class="fw-bold text-center mb-4">Preguntas frecuentes</h2>

    <div class="accordion accordion-flush col-lg-10 mx-auto" id="accordionFlushExample">

      <!-- 1 -->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f1" aria-expanded="false" aria-controls="f1">
            ¿Qué tipo de autos seminuevos ofrecen?
          </button>
        </h2>
        <div id="f1" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Ofrecemos todas las marcas de autos seminuevos en modelos no mayor de 8 años al año en curso, en excelente estado, previamente inspeccionados y con garantía.
          </div>
        </div>
      </div>

      <!-- 2 -->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f2" aria-expanded="false" aria-controls="f2">
            ¿Cuál es el proceso para solicitar financiamiento?
          </button>
        </h2>
        <div id="f2" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            El proceso es sencillo: elige el auto que te interesa, llena el formulario de solicitud en una visita en una de nuestras sucursales,
            y uno de nuestros asesores te contactará para guiarte en los siguientes pasos.
          </div>
        </div>
      </div>

      <!-- 3 -->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f3" aria-expanded="false" aria-controls="f3">
            ¿Cuáles son los requisitos para obtener financiamiento?
          </button>
        </h2>
        <div id="f3" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Los requisitos básicos incluyen identificación oficial, comprobante de ingresos (por ejemplo tus últimos recibos de nómina o estados de cuenta)
            y comprobante de domicilio. Para más detalles, consulta con uno de nuestros asesores.
          </div>
        </div>
      </div>

      <!-- 4 -->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f4" aria-expanded="false" aria-controls="f4">
            ¿Cuánto tiempo tarda en aprobarse mi solicitud?
          </button>
        </h2>
        <div id="f4" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Una vez presentada toda la documentación requerida y el llenado de tu solicitud, el proceso de aprobación puede tomar entre 24 y 72 horas.
          </div>
        </div>
      </div>

      <!-- 5 -->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f5" aria-expanded="false" aria-controls="f5">
            ¿Ofrecen planes de financiamiento personalizados?
          </button>
        </h2>
        <div id="f5" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Sí, adaptamos nuestros planes de financiamiento a tus necesidades.
          </div>
        </div>
      </div>

      <!-- 6 -->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f6" aria-expanded="false" aria-controls="f6">
            ¿Hay alguna penalización por pagos anticipados?
          </button>
        </h2>
        <div id="f6" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            No, puedes realizar pagos anticipados sin penalización, lo que te permite reducir el costo total del financiamiento.
          </div>
        </div>
      </div>

      <!-- A partir de aquí van ocultas inicialmente con la clase extra-faq -->
      <!-- 7 -->
      <div class="accordion-item extra-faq d-none">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f7" aria-expanded="false" aria-controls="f7">
            ¿Mobility Solutions ofrece garantía en los autos seminuevos?
          </button>
        </h2>
        <div id="f7" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Sí, todos nuestros autos seminuevos incluyen una garantía para brindarte tranquilidad en tu compra.
          </div>
        </div>
      </div>

      <!-- 8 -->
      <div class="accordion-item extra-faq d-none">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f8" aria-expanded="false" aria-controls="f8">
            ¿Qué opciones de seguros ofrecen para los autos financiados?
          </button>
        </h2>
        <div id="f8" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Trabajamos con varias aseguradoras para ofrecerte opciones de seguro que se adapten a tus necesidades,
            y puedes incluir el costo del seguro en tu plan de financiamiento.
          </div>
        </div>
      </div>

      <!-- 9 -->
      <div class="accordion-item extra-faq d-none">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f9" aria-expanded="false" aria-controls="f9">
            ¿Puedo solicitar financiamiento si tengo un historial crediticio negativo?
          </button>
        </h2>
        <div id="f9" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Evaluamos cada caso de manera individual, por lo que incluso si tienes un historial crediticio negativo,
            podrías ser elegible para financiamiento bajo ciertas condiciones.
          </div>
        </div>
      </div>

      <!-- 10 -->
      <div class="accordion-item extra-faq d-none">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f10" aria-expanded="false" aria-controls="f10">
            ¿Qué hago si no encuentro el auto que estoy buscando?
          </button>
        </h2>
        <div id="f10" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Si no encuentras el auto que deseas en nuestro inventario actual, puedes contactarnos,
            y nuestros asesores te ayudarán a buscar la mejor opción disponible.
          </div>
        </div>
      </div>

      <!-- 11 -->
      <div class="accordion-item extra-faq d-none">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f11" aria-expanded="false" aria-controls="f11">
            ¿Cómo sé que mi solicitud fue recibida correctamente?
          </button>
        </h2>
        <div id="f11" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Recibirás un mensaje SMS confirmando la recepción de tu solicitud dentro de las próximas 24 horas,
            lo que te asegurará que tu solicitud ha sido procesada.
          </div>
        </div>
      </div>

      <!-- 12 -->
      <div class="accordion-item extra-faq d-none">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f12" aria-expanded="false" aria-controls="f12">
            ¿Puedo obtener financiamiento sin importar a qué me dedique?
          </button>
        </h2>
        <div id="f12" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Sí, no importa a qué te dediques, en Mobility Solutions trabajamos para encontrar
            la mejor solución de financiamiento que se ajuste a tu situación particular.
          </div>
        </div>
      </div>

      <!-- 13 -->
      <div class="accordion-item extra-faq d-none">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f13" aria-expanded="false" aria-controls="f13">
            ¿Cómo sabré si mi solicitud fue autorizada?
          </button>
        </h2>
        <div id="f13" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Una vez que tu solicitud haya sido evaluada, uno de nuestros asesores se pondrá en contacto contigo en breve,
            después de que recibas el mensaje SMS de confirmación.
          </div>
        </div>
      </div>

      <!-- 14 -->
      <div class="accordion-item extra-faq d-none">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f14" aria-expanded="false" aria-controls="f14">
            ¿Cómo puedo realizar mi primer pago?
          </button>
        </h2>
        <div id="f14" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Puedes hacer tu primer pago en efectivo en cualquiera de nuestras sucursales,
            donde recibirás un recibo original que acredita la cantidad pagada.
          </div>
        </div>
      </div>

      <!-- 15 -->
      <div class="accordion-item extra-faq d-none">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f15" aria-expanded="false" aria-controls="f15">
            ¿Cómo se realizan los pagos de las mensualidades?
          </button>
        </h2>
        <div id="f15" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Las mensualidades se deben pagar únicamente a las cuentas oficiales,
            ya sea mediante depósito o domiciliación, nunca a cuentas particulares.
          </div>
        </div>
      </div>

      <!-- 16 -->
      <div class="accordion-item extra-faq d-none">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f16" aria-expanded="false" aria-controls="f16">
            ¿Cuándo puedo obtener la factura original del vehículo?
          </button>
        </h2>
        <div id="f16" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Puedes obtener la factura original una vez que hayas liquidado el financiamiento por completo.
          </div>
        </div>
      </div>

      <!-- 17 -->
      <div class="accordion-item extra-faq d-none">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f17" aria-expanded="false" aria-controls="f17">
            ¿Es Mobility Solutions una empresa confiable?
          </button>
        </h2>
        <div id="f17" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Sí, somos una empresa con todos nuestros registros actualizados y en orden,
            operamos bajo estrictas normativas legales y regulatorias. Nuestro objetivo es brindarte seguridad
            y confianza en cada paso de tu proceso de financiamiento y compra.
          </div>
        </div>
      </div>

      <!-- 18 -->
      <div class="accordion-item extra-faq d-none">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f18" aria-expanded="false" aria-controls="f18">
            ¿Cómo puedo protegerme de fraudes financieros como el phishing?
          </button>
        </h2>
        <div id="f18" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Para evitar ser víctima de phishing, nunca hagas clic en enlaces sospechosos recibidos por correo o mensaje.
            Mobility Solutions nunca te pedirá tu información confidencial como contraseñas o datos bancarios a través de
            correos electrónicos o mensajes no solicitados. Siempre verifica que la comunicación provenga de nuestras cuentas oficiales.
          </div>
        </div>
      </div>

      <!-- 19 -->
      <div class="accordion-item extra-faq d-none">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f19" aria-expanded="false" aria-controls="f19">
            ¿Cómo sé si un asesor es realmente parte de Mobility Solutions?
          </button>
        </h2>
        <div id="f19" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Nuestros asesores siempre se comunicarán desde correos electrónicos o teléfonos oficiales de Mobility Solutions.
            Si tienes dudas sobre la autenticidad de un asesor, puedes contactarnos directamente a nuestras líneas oficiales
            para verificar su identidad.
          </div>
        </div>
      </div>

      <!-- 20 -->
      <div class="accordion-item extra-faq d-none">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f20" aria-expanded="false" aria-controls="f20">
            ¿Qué hago si creo que estoy siendo víctima de fraude o si alguien se hace pasar por un asesor de Mobility Solutions?
          </button>
        </h2>
        <div id="f20" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Si sospechas que alguien se está haciendo pasar por un asesor, o si recibes una solicitud sospechosa,
            repórtalo inmediatamente a nuestras líneas de atención al cliente.
            Nunca compartas información personal ni realices depósitos sin confirmar que provienen de un canal oficial.
          </div>
        </div>
      </div>

      <!-- 21 -->
      <div class="accordion-item extra-faq d-none">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f21" aria-expanded="false" aria-controls="f21">
            ¿Cómo puedo contactarlos si tengo más preguntas?
          </button>
        </h2>
        <div id="f21" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Puedes llamarnos al (443)-522-7213, enviar un correo a Atencioncte@mobilitysolutionscorp.com,
            o llenar el formulario de contacto en nuestro sitio web.
          </div>
        </div>
      </div>

    </div><!-- /accordion -->

    <div class="text-center mt-4">
      <button class="btn btn-outline-secondary btn-sm" id="toggleFaqBtn">Ver más preguntas</button>
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
