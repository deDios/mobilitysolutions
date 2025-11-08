<?php
// === CORS + JSON ===
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Idempotency-Key, Accept');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(["success"=>false,"message"=>"Método no permitido; usa POST"]);
  exit;
}

include "../db/Conexion.php";

// En depuración, convierte errores mysqli a excepciones:
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// ===== Helpers =====
function as_int($v, $def=0){ return (is_numeric($v)? (int)$v : (int)$def); }
function valid_yyyymm($s){ return is_string($s) && preg_match('/^\d{4}\-(0[1-9]|1[0-2])$/',$s); }
function rol_label($t){
  switch((int)$t){
    case 1: return "Asesor(a)";
    case 2: return "Supervisor(a)";
    case 3: return "Analista";
    case 4: return "Manager";
    case 5: return "CTO";
    case 6: return "CEO";
    default: return "Sin rol";
  }
}

// ===== Entrada =====
$raw  = file_get_contents('php://input');
$in   = json_decode($raw, true); if(!is_array($in)) $in = [];

$debug        = as_int($in['debug'] ?? 0) === 1;
$user_id      = as_int($in['user_id'] ?? null);
$user_type    = as_int($in['user_type'] ?? null);
$yyyymm       = $in['yyyymm'] ?? null;
$solo_usuario = as_int($in['solo_usuario'] ?? 0) === 1;
$include_jefe = as_int($in['include_jefe'] ?? 0) === 1;

if (!$user_id || !$user_type) {
  echo json_encode(["success"=>false,"message"=>"Faltan parámetros requeridos (user_id, user_type)"]);
  exit;
}
if (!valid_yyyymm($yyyymm)) $yyyymm = date('Y-m');

// Periodo mensual
list($Y,$M) = array_map('intval', explode('-', $yyyymm));
$daysInMonth = (int)cal_days_in_month(CAL_GREGORIAN, $M, $Y);
$start = sprintf('%04d-%02d-01 00:00:00', $Y, $M);
$end   = sprintf('%04d-%02d-%02d 23:59:59', $Y, $M, $daysInMonth);

// Esquema (según tus DDL)
$SCHEMA = "mobility_solutions";

// ===== Recursivo jerarquía =====
function obtenerSubordinados($con, $schema, $id, &$acc){
  $sql = "SELECT user_id FROM {$schema}.tmx_acceso_usuario WHERE reporta_a = ?";
  $stmt = $con->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  while ($r = $res->fetch_assoc()) {
    $sid = (int)$r['user_id'];
    if (!in_array($sid, $acc, true)) {
      $acc[] = $sid;
      obtenerSubordinados($con, $schema, $sid, $acc);
    }
  }
  $stmt->close();
}

try {
  // ===== Construcción de IDs bajo alcance =====
  $ids = [];
  if ($solo_usuario){
    $ids = [$user_id];
  } elseif (in_array($user_type, [5,6], true)) {
    $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario");
    while ($r = $rs->fetch_assoc()) { $ids[] = (int)$r['user_id']; }
    $rs->close();
  } else {
    $ids[] = $user_id;
    if ($include_jefe){
      $stmt = $con->prepare("SELECT reporta_a FROM {$SCHEMA}.tmx_acceso_usuario WHERE user_id = ?");
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $stmt->bind_result($boss);
      if ($stmt->fetch() && $boss) $ids[] = (int)$boss;
      $stmt->close();
    }
    obtenerSubordinados($con, $SCHEMA, $user_id, $ids);
  }

  $ids = array_values(array_unique(array_map('intval',$ids)));
  if (empty($ids)){
    echo json_encode(["success"=>true,"yyyymm"=>$yyyymm,"rows"=>[]], JSON_UNESCAPED_UNICODE);
    exit;
  }

  // ===== Mapa de usuarios =====
  $ph = implode(',', array_fill(0, count($ids), '?'));
  $types_ids = str_repeat('i', count($ids));

  $map = [];
  $infoSql = "
    SELECT acc.user_id, acc.user_type,
           CONCAT(COALESCE(us.user_name,''),' ',COALESCE(us.second_name,''),' ',COALESCE(us.last_name,'')) AS nombre
    FROM {$SCHEMA}.tmx_acceso_usuario acc
    LEFT JOIN {$SCHEMA}.tmx_usuario us ON acc.user_id = us.id
    WHERE acc.user_id IN ($ph)
  ";
  $stmt = $con->prepare($infoSql);
  $stmt->bind_param($types_ids, ...$ids);
  $stmt->execute();
  $rs = $stmt->get_result();
  while($r = $rs->fetch_assoc()){
    $uid = (int)$r['user_id'];
    $map[$uid] = [
      "id" => $uid,
      "nombre" => trim($r['nombre'] ?? ''),
      "rol" => rol_label($r['user_type'] ?? 0),
      "nuevo" => 0, "venta" => 0, "entrega" => 0,
      "reconocimientos" => 0, "quejas" => 0, "faltas" => 0,
      "total" => 0
    ];
  }
  $stmt->close();

  if (empty($map)){
    echo json_encode(["success"=>true,"yyyymm"=>$yyyymm,"rows"=>[]], JSON_UNESCAPED_UNICODE);
    exit;
  }

  // Helper para ejecutar consultas con IN dinámico
  $run = function($sqlBase, $bindTailTypes, $bindTailValues, $onRow) use ($con, $ph, $types_ids, $ids){
    $sql = sprintf($sqlBase, $ph);
    $types = $types_ids . $bindTailTypes;
    $values = array_merge($ids, $bindTailValues);

    $stmt = $con->prepare($sql);
    $stmt->bind_param($types, ...$values);
    $stmt->execute();
    $res = $stmt->get_result();
    while($row = $res->fetch_assoc()){
      $onRow($row);
    }
    $stmt->close();
  };

  // ===== (1) Nuevo/Reserva/Entrega — tmx_requerimiento =====
  // Usamos tus campos: estatus=2 y fecha COALESCE(req_created_at, created_at)
  $sqlNre = "
    SELECT r.created_by AS uid,
           SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%nuevo%'   THEN 1 ELSE 0 END) AS nuevo,
           SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%reserva%' THEN 1 ELSE 0 END) AS venta,
           SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%entrega%' THEN 1 ELSE 0 END) AS entrega
    FROM {$SCHEMA}.tmx_requerimiento r
    WHERE r.estatus = 2
      AND r.created_by IN (%s)
      AND COALESCE(r.req_created_at, r.created_at) BETWEEN ? AND ?
    GROUP BY r.created_by
  ";
  $run($sqlNre, "ss", [$start,$end], function($row) use (&$map){
    $u = (int)$row['uid'];
    if (!isset($map[$u])) return;
    $map[$u]['nuevo']   = (int)$row['nuevo'];
    $map[$u]['venta']   = (int)$row['venta'];
    $map[$u]['entrega'] = (int)$row['entrega'];
  });

  // ===== (2) Reconocimientos — tmx_reconocimientos =====
  $sqlRec = "
    SELECT asignado AS uid, COUNT(*) AS reconocimientos
    FROM {$SCHEMA}.tmx_reconocimientos
    WHERE asignado IN (%s)
      AND created_at BETWEEN ? AND ?
    GROUP BY asignado
  ";
  $run($sqlRec, "ss", [$start,$end], function($row) use (&$map){
    $u = (int)$row['uid'];
    if (!isset($map[$u])) return;
    $map[$u]['reconocimientos'] = (int)$row['reconocimientos'];
  });

  // ===== (3) Quejas — tmx_queja (id_empleado) =====
  $sqlQ = "
    SELECT id_empleado AS uid, COUNT(*) AS quejas
    FROM {$SCHEMA}.tmx_queja
    WHERE id_empleado IN (%s)
      AND is_active = 1
      AND created_at BETWEEN ? AND ?
    GROUP BY id_empleado
  ";
  $run($sqlQ, "ss", [$start,$end], function($row) use (&$map){
    $u = (int)$row['uid'];
    if (!isset($map[$u])) return;
    $map[$u]['quejas'] = (int)$row['quejas'];
  });

  // ===== (4) Inasistencias — tmx_inasistencia (id_empleado) =====
  $sqlF = "
    SELECT id_empleado AS uid, COUNT(*) AS faltas
    FROM {$SCHEMA}.tmx_inasistencia
    WHERE id_empleado IN (%s)
      AND created_at BETWEEN ? AND ?
    GROUP BY id_empleado
  ";
  $run($sqlF, "ss", [$start,$end], function($row) use (&$map){
    $u = (int)$row['uid'];
    if (!isset($map[$u])) return;
    $map[$u]['faltas'] = (int)$row['faltas'];
  });

  // Totales + orden
  foreach ($map as $k => $v){
    $map[$k]['total'] = (int)$v['nuevo'] + (int)$v['venta'] + (int)$v['entrega'];
  }
  usort($map, function($a,$b){
    if ($a['total'] === $b['total']) return strcmp($a['nombre'],$b['nombre']);
    return $b['total'] <=> $a['total'];
  });

  echo json_encode([
    "success" => true,
    "yyyymm"  => $yyyymm,
    "rows"    => array_values($map)
  ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e){
  // En prod puedes ocultar el detalle; en debug=1 lo exponemos:
  http_response_code(500);
  echo json_encode([
    "success" => false,
    "message" => "Error interno al procesar la solicitud.",
    "error"   => $debug ? $e->getMessage() : null
  ]);
} finally {
  if (isset($con) && $con instanceof mysqli) { $con->close(); }
}

