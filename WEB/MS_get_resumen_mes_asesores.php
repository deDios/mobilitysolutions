<?php
// === Encabezados CORS + JSON ===
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Idempotency-Key, Accept');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(204);
  exit;
}

include "../db/Conexion.php";

// Mostrar errores de mysqli como excepciones (útil en dev)
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
function column_exists(mysqli $con, string $table, string $column): bool {
  // Nota: no se pueden parametrizar identificadores; el LIKE sí puede ir como parámetro.
  $sql = "SHOW COLUMNS FROM {$table} LIKE ?";
  $stmt = $con->prepare($sql);
  $stmt->bind_param("s", $column);
  $stmt->execute();
  $res = $stmt->get_result();
  $exists = ($res && $res->num_rows > 0);
  $stmt->close();
  return $exists;
}

// Solo POST (como tu API funcional)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(["success"=>false,"message"=>"Método no permitido; usa POST"]);
  exit;
}

// Unificar entrada: JSON body (prioritario) y luego POST plano
$raw  = file_get_contents('php://input');
$body = json_decode($raw, true);
$in   = array_merge($_POST ?? [], is_array($body) ? $body : []);

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

// Rango de mes
list($Y,$M) = array_map('intval', explode('-', $yyyymm));
$daysInMonth = (int)cal_days_in_month(CAL_GREGORIAN, $M, $Y);
$start = sprintf('%04d-%02d-01 00:00:00',$Y,$M);
$end   = sprintf('%04d-%02d-%02d 23:59:59',$Y,$M,$daysInMonth);

// ====== Detección de columnas en tmx_requerimiento ======
$tblReq = 'mobility_solutions.tmx_requerimiento';
$col_status  = null;
$col_created = null;

try {
  if (column_exists($con, $tblReq, 'estatus'))        $col_status = 'estatus';
  elseif (column_exists($con, $tblReq, 'status_req')) $col_status = 'status_req';

  if (column_exists($con, $tblReq, 'created_at'))          $col_created = 'created_at';
  elseif (column_exists($con, $tblReq, 'req_created_at'))  $col_created = 'req_created_at';

  if (!$col_status || !$col_created) {
    throw new RuntimeException("No se encontraron columnas esperadas en {$tblReq} (status: estatus/status_req, fecha: created_at/req_created_at).");
  }

  // ====== Jerarquía ======
  function obtenerSubordinados($con, $id, &$acc){
    $stmt = $con->prepare("SELECT user_id FROM mobility_solutions.tmx_acceso_usuario WHERE reporta_a = ?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $res = $stmt->get_result();
    while($r = $res->fetch_assoc()){
      $sid = (int)$r['user_id'];
      if (!in_array($sid,$acc, true)){
        $acc[] = $sid;
        obtenerSubordinados($con, $sid, $acc);
      }
    }
    $stmt->close();
  }

  // Construir lista de IDs
  $ids = [];
  if ($solo_usuario){
    $ids = [$user_id];
  } elseif (in_array($user_type,[5,6], true)) {
    $rs = $con->query("SELECT user_id FROM mobility_solutions.tmx_acceso_usuario");
    while($r = $rs->fetch_assoc()){ $ids[] = (int)$r['user_id']; }
  } else {
    $ids[] = $user_id;
    if ($include_jefe){
      $stmt = $con->prepare("SELECT reporta_a FROM mobility_solutions.tmx_acceso_usuario WHERE user_id=?");
      $stmt->bind_param("i",$user_id);
      $stmt->execute();
      $stmt->bind_result($boss);
      if ($stmt->fetch() && $boss) $ids[] = (int)$boss;
      $stmt->close();
    }
    obtenerSubordinados($con, $user_id, $ids);
  }

  $ids = array_values(array_unique(array_map('intval',$ids)));
  if (empty($ids)){
    echo json_encode(["success"=>true,"yyyymm"=>$yyyymm,"rows"=>[]], JSON_UNESCAPED_UNICODE);
    exit;
  }

  // Placeholders y tipos para IN (...)
  $ph = implode(',', array_fill(0, count($ids), '?'));
  $types_ids = str_repeat('i', count($ids));

  // ====== Inicializar mapa de usuarios ======
  $map = [];
  $infoSql = "
    SELECT 
      acc.user_id, acc.user_type,
      CONCAT(COALESCE(us.user_name,''),' ',COALESCE(us.second_name,''),' ',COALESCE(us.last_name,'')) AS nombre
    FROM mobility_solutions.tmx_acceso_usuario acc
    LEFT JOIN mobility_solutions.tmx_usuario us ON acc.user_id = us.id
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

  // ====== Helper para ejecutar SELECT con IN dinámico ======
  $run = function($sqlBase, $bindTailTypes, $bindTailValues, $onRow) use ($con, $ph, $types_ids, $ids){
    $sql = sprintf($sqlBase, $ph); // Inserta los placeholders del IN
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

  // ====== 1) Nuevo/Reserva/Entrega ======
  // Usa columnas detectadas dinámicamente
  $sqlNre = "
    SELECT
      r.created_by AS uid,
      SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%nuevo%'   THEN 1 ELSE 0 END) AS nuevo,
      SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%reserva%' THEN 1 ELSE 0 END) AS venta,
      SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%entrega%' THEN 1 ELSE 0 END) AS entrega
    FROM {$tblReq} r
    WHERE r.{$col_status} = 2
      AND r.created_by IN (%s)
      AND r.{$col_created} BETWEEN ? AND ?
    GROUP BY r.created_by
  ";
  $run($sqlNre, "ss", [$start,$end], function($row) use (&$map){
    $u = (int)$row['uid'];
    if (!isset($map[$u])) return;
    $map[$u]['nuevo']   = (int)$row['nuevo'];
    $map[$u]['venta']   = (int)$row['venta'];
    $map[$u]['entrega'] = (int)$row['entrega'];
  });

  // ====== 2) Reconocimientos ======
  $sqlRec = "
    SELECT
      asignado AS uid,
      COUNT(*) AS reconocimientos
    FROM mobility_solutions.tmx_reconocimientos
    WHERE asignado IN (%s)
      AND (
        (created_at IS NOT NULL AND created_at BETWEEN ? AND ?)
        OR (created_at IS NULL AND anio = ? AND mes = ?)
      )
    GROUP BY asignado
  ";
  $run($sqlRec, "ssii", [$start,$end,$Y,$M], function($row) use (&$map){
    $u = (int)$row['uid'];
    if (!isset($map[$u])) return;
    $map[$u]['reconocimientos'] = (int)$row['reconocimientos'];
  });

  // ====== 3) Quejas ======
  $sqlQ = "
    SELECT usuario AS uid, COUNT(*) AS quejas
    FROM mobility_solutions.tmx_queja
    WHERE usuario IN (%s)
      AND created_at BETWEEN ? AND ?
    GROUP BY usuario
  ";
  $run($sqlQ, "ss", [$start,$end], function($row) use (&$map){
    $u = (int)$row['uid'];
    if (!isset($map[$u])) return;
    $map[$u]['quejas'] = (int)$row['quejas'];
  });

  // ====== 4) Inasistencias ======
  $sqlF = "
    SELECT usuario AS uid, COUNT(*) AS faltas
    FROM mobility_solutions.tmx_inasistencia
    WHERE usuario IN (%s)
      AND created_at BETWEEN ? AND ?
    GROUP BY usuario
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
  http_response_code(500);
  echo json_encode([
    "success" => false,
    "message" => "Error interno al procesar la solicitud.",
    // En prod puedes ocultar esto; en debug=1 lo mostramos.
    "error"   => $debug ? $e->getMessage() : null
  ]);
} finally {
  if (isset($con) && $con instanceof mysqli) { $con->close(); }
}
