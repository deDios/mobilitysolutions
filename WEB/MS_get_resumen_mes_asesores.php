<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

include "../db/Conexion.php";

/**
 * Resumen mensual POR ASESOR (totales) bajo jerarquía.
 */

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

/* === Unificar entrada: GET/POST + JSON body === */
$raw  = file_get_contents('php://input');
$body = json_decode($raw, true);
$in   = array_merge($_GET ?? [], $_POST ?? [], is_array($body) ? $body : []);

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

list($Y,$M) = array_map('intval', explode('-', $yyyymm));
$daysInMonth = (int)cal_days_in_month(CAL_GREGORIAN, $M, $Y);
$start = sprintf('%04d-%02d-01 00:00:00',$Y,$M);
$end   = sprintf('%04d-%02d-%02d 23:59:59',$Y,$M,$daysInMonth);

/* === Helpers jerarquía === */
function obtenerSubordinados($con, $id, &$acc){
  $stmt = $con->prepare("SELECT user_id FROM mobility_solutions.tmx_acceso_usuario WHERE reporta_a = ?");
  $stmt->bind_param("i",$id);
  $stmt->execute();
  $res = $stmt->get_result();
  while($r = $res->fetch_assoc()){
    $sid = (int)$r['user_id'];
    if (!in_array($sid,$acc)){
      $acc[] = $sid;
      obtenerSubordinados($con, $sid, $acc);
    }
  }
  $stmt->close();
}

/* === Armar lista de IDs bajo jerarquía === */
$ids = [];
if ($solo_usuario){
  $ids = [$user_id];
} elseif (in_array($user_type,[5,6])) {
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
  echo json_encode(["success"=>true,"yyyymm"=>$yyyymm,"rows"=>[]]);
  exit;
}
$id_list = implode(',', $ids);

/* === Queries === */
$sqlNre = "
  SELECT
    r.created_by AS uid,
    SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%nuevo%'   THEN 1 ELSE 0 END) AS nuevo,
    SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%reserva%' THEN 1 ELSE 0 END) AS venta,
    SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%entrega%' THEN 1 ELSE 0 END) AS entrega
  FROM mobility_solutions.tmx_requerimiento r
  WHERE r.status_req = 2
    AND r.created_by IN ($id_list)
    AND r.req_created_at BETWEEN ? AND ?
  GROUP BY r.created_by
";

$sqlRec = "
  SELECT
    asignado AS uid,
    COUNT(*) AS reconocimientos
  FROM mobility_solutions.tmx_reconocimientos
  WHERE asignado IN ($id_list)
    AND (
      (created_at IS NOT NULL AND created_at BETWEEN ? AND ?)
      OR (created_at IS NULL AND anio = ? AND mes = ?)
    )
  GROUP BY asignado
";

$sqlQ = "
  SELECT usuario AS uid, COUNT(*) AS quejas
  FROM mobility_solutions.tmx_queja
  WHERE usuario IN ($id_list)
    AND created_at BETWEEN ? AND ?
  GROUP BY usuario
";

$sqlF = "
  SELECT usuario AS uid, COUNT(*) AS faltas
  FROM mobility_solutions.tmx_inasistencia
  WHERE usuario IN ($id_list)
    AND created_at BETWEEN ? AND ?
  GROUP BY usuario
";

/* === Inicializar mapa === */
$map = [];
$infoSql = "
  SELECT 
    acc.user_id, acc.user_type,
    CONCAT(COALESCE(us.user_name,''),' ',COALESCE(us.second_name,''),' ',COALESCE(us.last_name,'')) AS nombre
  FROM mobility_solutions.tmx_acceso_usuario acc
  LEFT JOIN mobility_solutions.tmx_usuario us ON acc.user_id = us.id
  WHERE acc.user_id IN ($id_list)
";
if ($rs = $con->query($infoSql)){
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
}

/* === Helper de ejecución === */
function run_stmt($con, $sql, $bindTypes, $bindValues, $apply){
  $stmt = $con->prepare($sql);
  if ($bindTypes){
    $stmt->bind_param($bindTypes, ...$bindValues);
  }
  $stmt->execute();
  $res = $stmt->get_result();
  while($row = $res->fetch_assoc()){
    $apply($row);
  }
  $stmt->close();
}

/* 1) N/R/E */
run_stmt(
  $con, $sqlNre, "ss", [$start,$end],
  function($row) use (&$map){
    $u = (int)$row['uid'];
    if (!isset($map[$u])) return;
    $map[$u]['nuevo']   = (int)$row['nuevo'];
    $map[$u]['venta']   = (int)$row['venta'];
    $map[$u]['entrega'] = (int)$row['entrega'];
  }
);

/* 2) Reconocimientos — usa $Y y $M (no $GLOBALS) */
run_stmt(
  $con, $sqlRec, "ssii", [$start,$end,$Y,$M],
  function($row) use (&$map){
    $u = (int)$row['uid'];
    if (!isset($map[$u])) return;
    $map[$u]['reconocimientos'] = (int)$row['reconocimientos'];
  }
);

/* 3) Quejas */
run_stmt(
  $con, $sqlQ, "ss", [$start,$end],
  function($row) use (&$map){
    $u = (int)$row['uid'];
    if (!isset($map[$u])) return;
    $map[$u]['quejas'] = (int)$row['quejas'];
  }
);

/* 4) Faltas */
run_stmt(
  $con, $sqlF, "ss", [$start,$end],
  function($row) use (&$map){
    $u = (int)$row['uid'];
    if (!isset($map[$u])) return;
    $map[$u]['faltas'] = (int)$row['faltas'];
  }
);

/* Totales y orden */
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
