<?php
// =================== INICIO PHP (arriba del <!DOCTYPE>) ===================
$inc = include "db/Conexion.php";
if (!$inc) { die("Sin conexión a la base"); }

function esc($s){ 
  global $con; 
  return mysqli_real_escape_string($con, trim((string)$s)); 
}

// --------- Lee GET con defaults ----------
$buscar       = isset($_GET['buscar']) ? esc($_GET['buscar']) : '';
$marca        = $_GET['InputMarca']        ?? 'Todos';
$anio         = $_GET['InputAnio']         ?? 'Todos';
$color        = $_GET['InputColor']        ?? 'Todos';
$transmision  = $_GET['InputTransmision']  ?? 'Todos';
$interior     = $_GET['InputInterior']     ?? 'Todos';
$tipo         = $_GET['InputTipo']         ?? 'Todos';
$pasajeros    = $_GET['InputPasajeros']    ?? 'Todos';
$mn_mayor     = esc($_GET['InputMensualidad_Mayor'] ?? '');
$mn_menor     = esc($_GET['InputMensualidad_Menor'] ?? '');

// --------- WHERE dinámico reutilizable ----------
function buildWhere(array $exclude = []){
  global $buscar,$marca,$anio,$color,$transmision,$interior,$tipo,$pasajeros,$mn_mayor,$mn_menor;
  $w = ["1=1"];
  if ($buscar !== '')                                   $w[] = "search_key LIKE '%$buscar%'";
  if ($marca !== 'Todos'       && !in_array('marca',$exclude))         $w[] = "marca = '".esc($marca)."'";
  if ($color !== 'Todos'       && !in_array('color',$exclude))         $w[] = "color = '".esc($color)."'";
  if ($transmision !== 'Todos' && !in_array('transmision',$exclude))   $w[] = "transmision = '".esc($transmision)."'";
  if ($interior !== 'Todos'    && !in_array('interior',$exclude))      $w[] = "interior = '".esc($interior)."'";
  if ($tipo !== 'Todos'        && !in_array('tipo',$exclude))          $w[] = "c_type = '".esc($tipo)."'";
  if ($anio !== 'Todos'        && !in_array('anio',$exclude))          $w[] = "nombre LIKE '%".esc($anio)."%'";
  if ($mn_mayor !== ''         && !in_array('mn_mayor',$exclude))       $w[] = "mensualidad >= '".esc($mn_mayor)."'";
  if ($mn_menor !== ''         && !in_array('mn_menor',$exclude))       $w[] = "mensualidad <= '".esc($mn_menor)."'";
  if ($pasajeros !== 'Todos'   && !in_array('pasajeros',$exclude))      $w[] = ($pasajeros==='6' ? "pasajeros > 6" : "pasajeros = '".esc($pasajeros)."'");
  return implode(' AND ', $w);
}

// --------- Helper de facetas ----------
function facet($col, array $exclude = []){
  global $con;
  $w = buildWhere($exclude);
  $sql = "SELECT $col AS val, COUNT(*) c
          FROM mobility_solutions.v_catalogo_active
          WHERE $w
          GROUP BY 1
          HAVING c>0
          ORDER BY 1";
  return mysqli_query($con,$sql);
}

// Facetas (para poblar selects dinámicos si los necesitas)
$facMarca    = facet('marca', ['marca']);
$facColor    = facet('color', ['color']);
$facTrans    = facet('transmision', ['transmision']);
$facInterior = facet('interior', ['interior']);
$facTipo     = facet('c_type', ['tipo']);
$facPax      = facet('CASE WHEN pasajeros>6 THEN "7+" ELSE CAST(pasajeros AS CHAR) END', ['pasajeros']);

// Faceta de años (si el año está dentro de "nombre")
$years = range(2016, 2025);
$facYears = [];
foreach ($years as $y){
  $w = buildWhere(['anio']);
  $sqlY = "SELECT COUNT(*) c FROM mobility_solutions.v_catalogo_active
           WHERE $w AND nombre LIKE '%$y%'";
  $resY = mysqli_query($con,$sqlY);
  $rowY = $resY ? mysqli_fetch_assoc($resY) : ['c'=>0];
  if (($rowY['c'] ?? 0) > 0) $facYears[] = ['val'=>$y, 'c'=>(int)$rowY['c']];
  if ($resY) mysqli_free_result($resY);
}

// --------- Paginación (9 por página) ----------
$perPage = 9;
$page    = max(1, (int)($_GET['p'] ?? 1));
$offset  = ($page-1) * $perPage;

$WHERE = buildWhere();

// Total de filas
$sqlCount = "SELECT COUNT(*) AS total
             FROM mobility_solutions.v_catalogo_active
             WHERE $WHERE";
$resCount = mysqli_query($con,$sqlCount);
$rowCount = $resCount ? mysqli_fetch_assoc($resCount) : ['total'=>0];
if ($resCount) mysqli_free_result($resCount);

$tot   = (int)($rowCount['total'] ?? 0);
$pages = max(1, (int)ceil($tot / $perPage));
if ($page > $pages){ $page = $pages; $offset = ($page-1)*$perPage; }

// Datos de la página actual
$sqlData = "SELECT id,nombre,modelo,marca,mensualidad,costo,sucursal,estatus,updated_at
            FROM mobility_solutions.v_catalogo_active
            WHERE $WHERE
            ORDER BY estatus ASC, updated_at DESC, id DESC
            LIMIT $perPage OFFSET $offset";
$data = mysqli_query($con,$sqlData);

// Para mantener filtros en los links (base sin 'p')
$qs = $_GET; 
unset($qs['p']);
$baseQS = '?'.http_build_query($qs);

// Helper para construir URL conservando filtros
function url_with($key, $val){
  $params = $_GET;
  $params[$key] = $val;
  return '?' . http_build_query($params);
}
// =================== FIN PHP INICIAL ===================
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catálogo</title>
  <link rel="shortcut icon" href="/Imagenes/movility.ico" />
  <link rel="stylesheet" href="CSS/catalogo.css">

  <!-- Solo Bootstrap 5 (unificado) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- jQuery (opcional si lo usas en otros lados) -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
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
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com">Inicio</a></li>
          <li class="nav-item active"><a class="nav-link" href="#">Catálogo</a></li>
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com/about_us.php">Nosotros</a></li>
          <li class="nav-item"><a class="nav-link" href="https://mobilitysolutionscorp.com/contact.php">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>
</div>

<div class="container-items">
  <!-- Lateral filtros -->
  <div class="menu_item py-3">
    <div class="menu_fix position-fixed">
      <form class="form-search" method="get">
        <div class="input-group">
          <input class="form-control form-text ps-3" maxlength="128" placeholder="Busca por marca, modelo, tipo..." type="text" name="buscar" value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>"/>
        </div>

        <div class="div_icon pt-2">
          <a class="btn btn-secondary btn-lg" data-bs-toggle="collapse" href="#collapseFiltros" role="button" aria-expanded="true" aria-controls="collapseFiltros">
            <i class="fa fa-filter"></i>
          </a>
          <figcaption class="blockquote-footer pt-2">
            <?= htmlspecialchars(($buscar ?? '')) ?>
            <?= $marca!=='Todos' ? ' / '.$marca : '' ?>
            <?= $anio!=='Todos' ? ' / '.$anio : '' ?>
            <?= $color!=='Todos' ? ' / '.$color : '' ?>
            <?= $transmision!=='Todos' ? ' / '.$transmision : '' ?>
            <?= $interior!=='Todos' ? ' / '.$interior : '' ?>
            <?= $tipo!=='Todos' ? ' / '.$tipo : '' ?>
            <?= $pasajeros!=='Todos' ? ' / '.$pasajeros : '' ?>
            <?= $mn_mayor!=='' ? ' / Mayor a $'.$mn_mayor : '' ?>
            <?= $mn_menor!=='' ? ' / Menor a $'.$mn_menor : '' ?>
          </figcaption>
        </div>

        <div class="collapse show py-2" id="collapseFiltros">
          <div class="lay_ser">
            <h5 class="fw-light py-2">Filtros</h5>
            <hr class="mt-2 mb-3"/>

            <div class="accordion" id="accordionFiltros">
              <!-- Marca -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="fMarcaH">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fMarca" aria-controls="fMarca">Marca</button>
                </h2>
                <div id="fMarca" class="accordion-collapse collapse" aria-labelledby="fMarcaH">
                  <div class="accordion-body">
                    <select id="InputMarca" class="form-select" name="InputMarca" onchange="this.form.submit()">
                      <option value="Todos">Selecciona una Marca</option>
                      <?php while($facMarca && $row=mysqli_fetch_assoc($facMarca)): ?>
                        <option value="<?= htmlspecialchars($row['val']) ?>" <?= $marca===$row['val']?'selected':'' ?>>
                          <?= htmlspecialchars($row['val']) ?> (<?= (int)$row['c'] ?>)
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Características -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="fCarH">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fCar" aria-controls="fCar">Características</button>
                </h2>
                <div id="fCar" class="accordion-collapse collapse" aria-labelledby="fCarH">
                  <div class="accordion-body">
                    <!-- Año (dinámico por existencia) -->
                    <div class="pt-1">
                      <select id="InputAnio" class="form-select" name="InputAnio" onchange="this.form.submit()">
                        <option value="Todos">Selecciona año</option>
                        <?php foreach($facYears as $y): ?>
                          <option value="<?= (int)$y['val'] ?>" <?= $anio==$y['val']?'selected':'' ?>>
                            <?= (int)$y['val'] ?> (<?= (int)$y['c'] ?>)
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <!-- Color -->
                    <div class="pt-1">
                      <select id="InputColor" class="form-select" name="InputColor" onchange="this.form.submit()">
                        <option value="Todos">Selecciona color</option>
                        <?php while($facColor && $row=mysqli_fetch_assoc($facColor)): ?>
                          <option value="<?= htmlspecialchars($row['val']) ?>" <?= $color===$row['val']?'selected':'' ?>>
                            <?= htmlspecialchars($row['val']) ?> (<?= (int)$row['c'] ?>)
                          </option>
                        <?php endwhile; ?>
                      </select>
                    </div>

                    <!-- Transmisión -->
                    <div class="pt-1">
                      <select id="InputTransmision" class="form-select" name="InputTransmision" onchange="this.form.submit()">
                        <option value="Todos">Selecciona transmisión</option>
                        <?php while($facTrans && $row=mysqli_fetch_assoc($facTrans)): ?>
                          <option value="<?= htmlspecialchars($row['val']) ?>" <?= $transmision===$row['val']?'selected':'' ?>>
                            <?= htmlspecialchars($row['val']) ?> (<?= (int)$row['c'] ?>)
                          </option>
                        <?php endwhile; ?>
                      </select>
                    </div>

                    <!-- Interior -->
                    <div class="pt-1">
                      <select id="InputInterior" class="form-select" name="InputInterior" onchange="this.form.submit()">
                        <option value="Todos">Selecciona interior</option>
                        <?php while($facInterior && $row=mysqli_fetch_assoc($facInterior)): ?>
                          <option value="<?= htmlspecialchars($row['val']) ?>" <?= $interior===$row['val']?'selected':'' ?>>
                            <?= htmlspecialchars($row['val']) ?> (<?= (int)$row['c'] ?>)
                          </option>
                        <?php endwhile; ?>
                      </select>
                    </div>

                    <!-- Tipo -->
                    <div class="pt-1">
                      <select id="InputTipo" class="form-select" name="InputTipo" onchange="this.form.submit()">
                        <option value="Todos">Selecciona tipo</option>
                        <?php while($facTipo && $row=mysqli_fetch_assoc($facTipo)): ?>
                          <option value="<?= htmlspecialchars($row['val']) ?>" <?= $tipo===$row['val']?'selected':'' ?>>
                            <?= htmlspecialchars($row['val']) ?> (<?= (int)$row['c'] ?>)
                          </option>
                        <?php endwhile; ?>
                      </select>
                    </div>

                    <!-- Pasajeros (mapeando 7+) -->
                    <div class="pt-1">
                      <select id="InputPasajeros" class="form-select" name="InputPasajeros" onchange="this.form.submit()">
                        <option value="Todos">Selecciona pasajeros</option>
                        <?php while($facPax && $row=mysqli_fetch_assoc($facPax)): ?>
                          <?php $val = $row['val']==='7+' ? '6' : $row['val']; ?>
                          <option value="<?= htmlspecialchars($val) ?>" <?= $pasajeros===$val?'selected':'' ?>>
                            <?= htmlspecialchars($row['val']) ?> (<?= (int)$row['c'] ?>)
                          </option>
                        <?php endwhile; ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Precio -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="fPrecioH">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fPrecio" aria-controls="fPrecio">Precio</button>
                </h2>
                <div id="fPrecio" class="accordion-collapse collapse" aria-labelledby="fPrecioH">
                  <div class="accordion-body">
                    <div class="pt-1">
                      <span class="input-group-text">$ Mayor a: MX/mensuales</span>
                      <input id="InputMensualidad_Mayor" type="text" pattern="[0-9]+" class="form-control" name="InputMensualidad_Mayor" value="<?= htmlspecialchars($_GET['InputMensualidad_Mayor'] ?? '') ?>">
                    </div>
                    <div class="pt-3">
                      <span class="input-group-text">$ Menor a: MX/mensuales</span>
                      <input id="InputMensualidad_Menor" type="text" pattern="[0-9]+" class="form-control" name="InputMensualidad_Menor" value="<?= htmlspecialchars($_GET['InputMensualidad_Menor'] ?? '') ?>">
                    </div>
                    <div class="text-end pt-3">
                      <button class="btn btn-link" type="submit" name="enviar">Aplicar filtros</button>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- /accordion -->
          </div><!-- /lay_ser -->
        </div><!-- /collapse -->
      </form>

      <div class="anuncios">
        <p class="titulo_r py-5"><small></small></p>
        <p><small>Anuncios</small></p>
        <hr class="mt-2 mb-3"/>
      </div>
    </div>
  </div>

  <!-- Grid de autos -->
  <div class="lista_item">
    <?php if ($tot===0): ?>
      <div class="alert alert-warning mt-5">No hay resultados con los filtros actuales.</div>
    <?php endif; ?>

    <?php while($data && $row=mysqli_fetch_assoc($data)): 
      $id = $row['id'];
      $nombre = $row['nombre'];
      $modelo = $row['modelo'];
      $marcaR = $row['marca'];
      $mensualidad = $row['mensualidad'];
      $costo = $row['costo'];
      $sucursal = $row['sucursal'];
      $estatus = $row['estatus'];
    ?>
      <a href="javascript:detalle(<?= (int)$id ?>)">
        <div class="item">
          <figure>
            <img src="Imagenes/Catalogo/Auto <?= (int)$id ?>/Img01.jpg" alt="Auto <?= (int)$id ?>">
          </figure>
          <div class="info-producto">
            <div class="titulo_marca">
              <div class="titulo_carro"><?= htmlspecialchars($marcaR.' '.$nombre) ?></div>
              <img src="Imagenes/Marcas/logo_<?= htmlspecialchars($marcaR) ?>.jpg" alt="logo">
            </div>
            <div class="version_unidad"><?= 'N°25000A/'.$id.' - '.$modelo ?></div>
            <div class="titulo_desde">Mensualidad DESDE</div>
            <div class="mensualidades"><?= '$'.number_format($mensualidad).'/mes' ?></div>
            <div class="Precio"><?= '$'.number_format($costo) ?></div>
            <div class="Localidad">
              <div><i class="bi bi-geo-alt-fill"></i> <?= ' '.$sucursal ?></div>
              <?php if ((int)$estatus === 3): ?>
                <img src="Imagenes/Sellos/reservado.jpg" class="imagen-sello" alt="sello">
              <?php endif; ?>
            </div>
          </div>
        </div>
      </a>
    <?php endwhile; ?>

    <!-- Paginador -->
    <?php if ($pages > 1): ?>
    <?php
        // ventana de 5 botones
        $window = 5;
        $half   = (int)floor($window/2);
        $start  = max(1, $page - $half);
        $end    = min($pages, $start + $window - 1);
        // si estamos al final, corre la ventana para mantener 5
        $start  = max(1, min($start, $pages - $window + 1));
    ?>
    <nav class="mt-3 d-flex justify-content-center" aria-label="Paginación">
        <ul class="pagination pagination-sm justify-content-center flex-wrap">
        <!-- Primera / Anterior -->
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= url_with('p', 1) ?>" aria-label="Primera">«</a>
        </li>
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= url_with('p', max(1, $page-1)) ?>" aria-label="Anterior">‹</a>
        </li>

        <!-- Elipsis izquierda -->
        <?php if ($start > 1): ?>
            <li class="page-item disabled"><span class="page-link">…</span></li>
        <?php endif; ?>

        <!-- Números visibles -->
        <?php for ($i = $start; $i <= $end; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a class="page-link" href="<?= url_with('p', $i) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <!-- Elipsis derecha -->
        <?php if ($end < $pages): ?>
            <li class="page-item disabled"><span class="page-link">…</span></li>
        <?php endif; ?>

        <!-- Siguiente / Última -->
        <li class="page-item <?= $page >= $pages ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= url_with('p', min($pages, $page+1)) ?>" aria-label="Siguiente">›</a>
        </li>
        <li class="page-item <?= $page >= $pages ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= url_with('p', $pages) ?>" aria-label="Última">»</a>
        </li>
        </ul>
    </nav>
    <?php endif; ?>

  </div><!-- /lista_item -->

</div><!-- /container-items -->

<script>
  function detalle (cod){ location.href="detalles.php?cod="+cod; }
</script>

<hr class="mt-5 mb-3"/>

<footer class="foo mt-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <h6>Conoce más</h6>
        <hr class="hr1 mt-2 mb-3" style="height:5px;border-width:0;color:#FFC00A;background-color:#FFC00A">
        <ul class="text-secondary list-unstyled">
          <li><a class="text-secondary" href="https://mobilitysolutionscorp.com/about_us.php">¿Quiénes Somos?</a></li>
          <li><a class="text-secondary" href="https://mobilitysolutionscorp.com/Views/vende.php">Vende tu auto</a></li>
          <li><a class="text-secondary" href="https://mobilitysolutionscorp.com/views/ubicacion.php">Sucursales</a></li>
        </ul>
      </div>
      <div class="col-lg-3">
        <h6>Legales</h6>
        <hr class="hr2 mt-2 mb-3" style="height:5px;border-width:0;color:gainsboro;background-color:gainsboro">
        <ul class="text-secondary list-unstyled">
          <li><a class="text-secondary" href="/Views/privacy.php">Aviso de privacidad</a></li>
        </ul>
      </div>
      <div class="col-lg-3">
        <h6>Ayuda</h6>
        <hr class="hr3 mt-2 mb-3" style="height:5px;border-width:0;color:black;background-color:black">
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
</body>
</html>
