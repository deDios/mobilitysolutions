<?php
// === CORS + JSON ===
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Idempotency-Key, Accept');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); echo json_encode(["ok"=>true]); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo json_encode(["success"=>false,"error"=>"Método no permitido; usa POST"]); exit; }

// ===== Util =====
function respond($arr, $code=200){ http_response_code($code); echo json_encode($arr, JSON_UNESCAPED_UNICODE); exit; }
function as_int($v, $def=0){ return (is_numeric($v)? (int)$v : (int)$def); }
function valid_yyyymm($s){ return is_string($s) && preg_match('/^\d{4}\-(0[1-9]|1[0-2])$/',$s); }
function rol_label($t){ switch((int)$t){case 1:return "Asesor(a)";case 2:return "Supervisor(a)";case 3:return "Analista";case 4:return "Manager";case 5:return "CTO";case 6:return "CEO";default:return "Sin rol";} }

// ===== Entrada =====
$raw  = file_get_contents('php://input');
$body = json_decode($raw, true);
if (!is_array($body)) $body = [];
$step = $body['step'] ?? 1;
$user_id      = as_int($body['user_id'] ?? null);
$user_type    = as_int($body['user_type'] ?? null);
$yyyymm       = $body['yyyymm'] ?? null;
$solo_usuario = as_int($body['solo_usuario'] ?? 0) === 1;
$include_jefe = as_int($body['include_jefe'] ?? 0) === 1;

// ===== Paso 1: Echo de inputs y periodo (sin DB) =====
if ($step == 1){
  if (!valid_yyyymm($yyyymm)) $yyyymm = date('Y-m');
  list($Y,$M) = array_map('intval', explode('-', $yyyymm));
  $daysInMonth = (int)cal_days_in_month(CAL_GREGORIAN, $M, $Y);
  $start = sprintf('%04d-%02d-01 00:00:00',$Y,$M);
  $end   = sprintf('%04d-%02d-%02d 23:59:59',$Y,$M,$daysInMonth);
  respond([
    "success"=>true,
    "step"=>1,
    "inputs"=>[
      "user_id"=>$user_id, "user_type"=>$user_type, "yyyymm"=>$yyyymm,
      "solo_usuario"=>$solo_usuario, "include_jefe"=>$include_jefe
    ],
    "period"=>["start"=>$start,"end"=>$end],
    "hint"=>"Si esto te regresa 200 con success=true, pasamos al step=2"
  ]);
}

include "../db/Conexion.php";
if (!isset($con) || !($con instanceof mysqli)) respond(["success"=>false,"step"=>$step,"error"=>"Conexión DB no inicializada en Conexion.php"], 200);
if ($con->connect_errno) respond(["success"=>false,"step"=>$step,"error"=>"Error de conexión DB: ".$con->connect_error], 200);
$SCHEMA = "mobility_solutions";

// ===== Paso 2: Ping de DB y tablas =====
if ($step == 2){
  $checks = [];
  foreach (["tmx_acceso_usuario","tmx_usuario","tmx_requerimiento","tmx_reconocimientos","tmx_queja","tmx_inasistencia"] as $t){
    $q = $con->query("SELECT 1 FROM {$SCHEMA}.{$t} LIMIT 1");
    $checks[$t] = $q ? "ok" : "fail";
    if ($q) $q->close();
  }
  respond(["success"=>true,"step"=>2,"db_host"=>$con->host_info,"tables"=>$checks,"hint"=>"Si todo ok, avanza con step=3"], 200);
}

// Comunes
if (!valid_yyyymm($yyyymm)) $yyyymm = date('Y-m');
list($Y,$M) = array_map('intval', explode('-', $yyyymm));
$daysInMonth = (int)cal_days_in_month(CAL_GREGORIAN, $M, $Y);
$start = sprintf('%04d-%02d-01 00:00:00',$Y,$M);
$end   = sprintf('%04d-%02d-%02d 23:59:59',$Y,$M,$daysInMonth);

// Recursivo
function obtenerSubordinados($con, $schema, $id, &$acc){
  $sql = "SELECT user_id FROM {$schema}.tmx_acceso_usuario WHERE reporta_a = ?";
  $stmt = $con->prepare($sql);
  if(!$stmt){ return; }
  $stmt->bind_param("i",$id);
  if($stmt->execute()){
    $res = $stmt->get_result();
    while($r = $res->fetch_assoc()){
      $sid = (int)$r['user_id'];
      if (!in_array($sid,$acc, true)){
        $acc[] = $sid;
        obtenerSubordinados($con, $schema, $sid, $acc);
      }
    }
  }
  $stmt->close();
}

// ===== Paso 3: IDs jerárquicos =====
if ($step == 3){
  if (!$user_id || !$user_type) respond(["success"=>false,"step"=>3,"error"=>"Faltan user_id/user_type"],200);

  $ids = [];
  if ($solo_usuario){
    $ids = [$user_id];
  } elseif (in_array($user_type,[5,6], true)) {
    $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario");
    if(!$rs) respond(["success"=>false,"step"=>3,"error"=>"Query all users falló"],200);
    while ($r = $rs->fetch_assoc()) { $ids[] = (int)$r['user_id']; }
    $rs->close();
  } else {
    $ids[] = $user_id;
    if ($include_jefe){
      $stmt = $con->prepare("SELECT reporta_a FROM {$SCHEMA}.tmx_acceso_usuario WHERE user_id=?");
      if($stmt){
        $stmt->bind_param("i",$user_id);
        if($stmt->execute()){
          $stmt->bind_result($boss);
          if ($stmt->fetch() && $boss) $ids[] = (int)$boss;
        }
        $stmt->close();
      }
    }
    obtenerSubordinados($con, $SCHEMA, $user_id, $ids);
  }

  $ids = array_values(array_unique(array_map('intval',$ids)));
  respond([
    "success"=>true,"step"=>3,
    "ids"=>$ids,"count"=>count($ids),
    "period"=>["start"=>$start,"end"=>$end],
    "hint"=>"Si ves IDs, avanza con step=4"
  ],200);
}

// ===== Paso 4: Info de usuarios =====
if ($step == 4){
  // recalcular IDs rápido
  $ids = [];
  if ($solo_usuario){
    $ids = [$user_id];
  } elseif (in_array($user_type,[5,6], true)) {
    $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario");
    if(!$rs) respond(["success"=>false,"step"=>4,"error"=>"Query all users falló"],200);
    while ($r = $rs->fetch_assoc()) { $ids[] = (int)$r['user_id']; }
    $rs->close();
  } else {
    $ids[] = $user_id;
    if ($include_jefe){
      $stmt = $con->prepare("SELECT reporta_a FROM {$SCHEMA}.tmx_acceso_usuario WHERE user_id=?");
      if($stmt){
        $stmt->bind_param("i",$user_id);
        if($stmt->execute()){
          $stmt->bind_result($boss);
          if ($stmt->fetch() && $boss) $ids[] = (int)$boss;
        }
        $stmt->close();
      }
    }
    obtenerSubordinados($con, $SCHEMA, $user_id, $ids);
  }
  $ids = array_values(array_unique(array_map('intval',$ids)));
  if (empty($ids)) respond(["success"=>false,"step"=>4,"error"=>"Sin IDs"],200);

  $ph = implode(',', array_fill(0, count($ids), '?'));
  $types_ids = str_repeat('i', count($ids));
  $sql = "
    SELECT acc.user_id, acc.user_type,
           CONCAT(COALESCE(us.user_name,''),' ',COALESCE(us.second_name,''),' ',COALESCE(us.last_name,'')) AS nombre
    FROM {$SCHEMA}.tmx_acceso_usuario acc
    LEFT JOIN {$SCHEMA}.tmx_usuario us ON acc.user_id = us.id
    WHERE acc.user_id IN ($ph)
  ";
  $stmt = $con->prepare($sql);
  if(!$stmt) respond(["success"=>false,"step"=>4,"error"=>"prepare falló"],200);
  $stmt->bind_param($types_ids, ...$ids);
  if(!$stmt->execute()) respond(["success"=>false,"step"=>4,"error"=>"execute falló"],200);
  $res = $stmt->get_result();
  $rows = [];
  while($r = $res->fetch_assoc()){ $rows[] = $r; }
  $stmt->close();

  respond(["success"=>true,"step"=>4,"rows"=>$rows,"count"=>count($rows),"hint"=>"Si ok, step=5"],200);
}

// ===== Paso 5: N/R/E =====
if ($step == 5){
  $ids = [];
  if ($solo_usuario){ $ids = [$user_id]; }
  elseif (in_array($user_type,[5,6], true)) {
    $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario");
    if(!$rs) respond(["success"=>false,"step"=>5,"error"=>"Query all users falló"],200);
    while ($r = $rs->fetch_assoc()) { $ids[] = (int)$r['user_id']; }
    $rs->close();
  } else {
    $ids[] = $user_id;
    if ($include_jefe){
      $stmt=$con->prepare("SELECT reporta_a FROM {$SCHEMA}.tmx_acceso_usuario WHERE user_id=?");
      if($stmt){ $stmt->bind_param("i",$user_id); if($stmt->execute()){ $stmt->bind_result($boss); if($stmt->fetch()&&$boss)$ids[]=(int)$boss; } $stmt->close(); }
    }
    obtenerSubordinados($con,$SCHEMA,$user_id,$ids);
  }
  $ids = array_values(array_unique(array_map('intval',$ids)));
  if (empty($ids)) respond(["success"=>false,"step"=>5,"error"=>"Sin IDs"],200);

  $ph = implode(',', array_fill(0, count($ids), '?'));
  $types_ids = str_repeat('i', count($ids));
  $sql = "
    SELECT r.created_by AS uid,
           SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%nuevo%'   THEN 1 ELSE 0 END) AS nuevo,
           SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%reserva%' THEN 1 ELSE 0 END) AS venta,
           SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%entrega%' THEN 1 ELSE 0 END) AS entrega
    FROM {$SCHEMA}.tmx_requerimiento r
    WHERE r.estatus = 2
      AND r.created_by IN ($ph)
      AND COALESCE(r.req_created_at, r.created_at) BETWEEN ? AND ?
    GROUP BY r.created_by
  ";
  $stmt = $con->prepare($sql);
  if(!$stmt) respond(["success"=>false,"step"=>5,"error"=>"prepare falló"],200);
  $types = $types_ids . "ss";
  $stmt->bind_param($types, ...array_merge($ids, [$start,$end]));
  if(!$stmt->execute()) respond(["success"=>false,"step"=>5,"error"=>"execute falló"],200);
  $res = $stmt->get_result();
  $rows = [];
  while($r = $res->fetch_assoc()){ $rows[] = ["uid"=>(int)$r["uid"], "nuevo"=>(int)$r["nuevo"], "venta"=>(int)$r["venta"], "entrega"=>(int)$r["entrega"]]; }
  $stmt->close();

  respond(["success"=>true,"step"=>5,"rows"=>$rows,"hint"=>"Si ok, step=6"],200);
}

// ===== Paso 6: Reconocimientos =====
if ($step == 6){
  $ids = [];
  if ($solo_usuario){ $ids = [$user_id]; }
  elseif (in_array($user_type,[5,6], true)) {
    $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario");
    if(!$rs) respond(["success"=>false,"step"=>6,"error"=>"Query all users falló"],200);
    while ($r = $rs->fetch_assoc()) { $ids[] = (int)$r['user_id']; }
    $rs->close();
  } else {
    $ids[] = $user_id;
    if ($include_jefe){
      $stmt=$con->prepare("SELECT reporta_a FROM {$SCHEMA}.tmx_acceso_usuario WHERE user_id=?");
      if($stmt){ $stmt->bind_param("i",$user_id); if($stmt->execute()){ $stmt->bind_result($boss); if($stmt->fetch()&&$boss)$ids[]=(int)$boss; } $stmt->close(); }
    }
    obtenerSubordinados($con,$SCHEMA,$user_id,$ids);
  }
  $ids = array_values(array_unique(array_map('intval',$ids)));
  if (empty($ids)) respond(["success"=>false,"step"=>6,"error"=>"Sin IDs"],200);

  $ph = implode(',', array_fill(0, count($ids), '?'));
  $types_ids = str_repeat('i', count($ids));
  $sql = "
    SELECT asignado AS uid, COUNT(*) AS reconocimientos
    FROM {$SCHEMA}.tmx_reconocimientos
    WHERE asignado IN ($ph)
      AND created_at BETWEEN ? AND ?
    GROUP BY asignado
  ";
  $stmt = $con->prepare($sql);
  if(!$stmt) respond(["success"=>false,"step"=>6,"error"=>"prepare falló"],200);
  $types = $types_ids . "ss";
  $stmt->bind_param($types, ...array_merge($ids, [$start,$end]));
  if(!$stmt->execute()) respond(["success"=>false,"step"=>6,"error"=>"execute falló"],200);
  $res = $stmt->get_result();
  $rows = [];
  while($r = $res->fetch_assoc()){ $rows[] = ["uid"=>(int)$r["uid"], "reconocimientos"=>(int)$r["reconocimientos"]]; }
  $stmt->close();

  respond(["success"=>true,"step"=>6,"rows"=>$rows,"hint"=>"Si ok, step=7"],200);
}

// ===== Paso 7: Quejas =====
if ($step == 7){
  $ids = [];
  if ($solo_usuario){ $ids = [$user_id]; }
  elseif (in_array($user_type,[5,6], true)) {
    $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario");
    if(!$rs) respond(["success"=>false,"step"=>7,"error"=>"Query all users falló"],200);
    while ($r = $rs->fetch_assoc()) { $ids[] = (int)$r['user_id']; }
    $rs->close();
  } else {
    $ids[] = $user_id;
    if ($include_jefe){
      $stmt=$con->prepare("SELECT reporta_a FROM {$SCHEMA}.tmx_acceso_usuario WHERE user_id=?");
      if($stmt){ $stmt->bind_param("i",$user_id); if($stmt->execute()){ $stmt->bind_result($boss); if($stmt->fetch()&&$boss)$ids[]=(int)$boss; } $stmt->close(); }
    }
    obtenerSubordinados($con,$SCHEMA,$user_id,$ids);
  }
  $ids = array_values(array_unique(array_map('intval',$ids)));
  if (empty($ids)) respond(["success"=>false,"step"=>7,"error"=>"Sin IDs"],200);

  $ph = implode(',', array_fill(0, count($ids), '?'));
  $types_ids = str_repeat('i', count($ids));
  $sql = "
    SELECT id_empleado AS uid, COUNT(*) AS quejas
    FROM {$SCHEMA}.tmx_queja
    WHERE id_empleado IN ($ph)
      AND is_active = 1
      AND created_at BETWEEN ? AND ?
    GROUP BY id_empleado
  ";
  $stmt = $con->prepare($sql);
  if(!$stmt) respond(["success"=>false,"step"=>7,"error"=>"prepare falló"],200);
  $types = $types_ids . "ss";
  $stmt->bind_param($types, ...array_merge($ids, [$start,$end]));
  if(!$stmt->execute()) respond(["success"=>false,"step"=>7,"error"=>"execute falló"],200);
  $res = $stmt->get_result();
  $rows = [];
  while($r = $res->fetch_assoc()){ $rows[] = ["uid"=>(int)$r["uid"], "quejas"=>(int)$r["quejas"]]; }
  $stmt->close();

  respond(["success"=>true,"step"=>7,"rows"=>$rows,"hint"=>"Si ok, step=8"],200);
}

// ===== Paso 8: Inasistencias =====
if ($step == 8){
  $ids = [];
  if ($solo_usuario){ $ids = [$user_id]; }
  elseif (in_array($user_type,[5,6], true)) {
    $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario");
    if(!$rs) respond(["success"=>false,"step"=>8,"error"=>"Query all users falló"],200);
    while ($r = $rs->fetch_assoc()) { $ids[] = (int)$r['user_id']; }
    $rs->close();
  } else {
    $ids[] = $user_id;
    if ($include_jefe){
      $stmt=$con->prepare("SELECT reporta_a FROM {$SCHEMA}.tmx_acceso_usuario WHERE user_id=?");
      if($stmt){ $stmt->bind_param("i",$user_id); if($stmt->execute()){ $stmt->bind_result($boss); if($stmt->fetch()&&$boss)$ids[]=(int)$boss; } $stmt->close(); }
    }
    obtenerSubordinados($con,$SCHEMA,$user_id,$ids);
  }
  $ids = array_values(array_unique(array_map('intval',$ids)));
  if (empty($ids)) respond(["success"=>false,"step"=>8,"error"=>"Sin IDs"],200);

  $ph = implode(',', array_fill(0, count($ids), '?'));
  $types_ids = str_repeat('i', count($ids));
  $sql = "
    SELECT id_empleado AS uid, COUNT(*) AS faltas
    FROM {$SCHEMA}.tmx_inasistencia
    WHERE id_empleado IN ($ph)
      AND created_at BETWEEN ? AND ?
    GROUP BY id_empleado
  ";
  $stmt = $con->prepare($sql);
  if(!$stmt) respond(["success"=>false,"step"=>8,"error"=>"prepare falló"],200);
  $types = $types_ids . "ss";
  $stmt->bind_param($types, ...array_merge($ids, [$start,$end]));
  if(!$stmt->execute()) respond(["success"=>false,"step"=>8,"error"=>"execute falló"],200);
  $res = $stmt->get_result();
  $rows = [];
  while($r = $res->fetch_assoc()){ $rows[] = ["uid"=>(int)$r["uid"], "faltas"=>(int)$r["faltas"]]; }
  $stmt->close();

  respond(["success"=>true,"step"=>8,"rows"=>$rows,"hint"=>"Si ok, cerramos integrando todo"],200);
}

// ===== Paso 7a: Quejas - Diagnóstico extendido =====
if ($step == '7a') {
  // Recalcular IDs
  $ids = [];
  if ($solo_usuario){ $ids = [$user_id]; }
  elseif (in_array($user_type,[5,6], true)) {
    $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario");
    while ($r = $rs->fetch_assoc()) { $ids[] = (int)$r['user_id']; }
    if ($rs) $rs->close();
  } else {
    $ids[] = $user_id;
    if ($include_jefe){
      $stmt=$con->prepare("SELECT reporta_a FROM {$SCHEMA}.tmx_acceso_usuario WHERE user_id=?");
      if($stmt){ $stmt->bind_param("i",$user_id); if($stmt->execute()){ $stmt->bind_result($boss); if($stmt->fetch()&&$boss)$ids[]=(int)$boss; } $stmt->close(); }
    }
    obtenerSubordinados($con,$SCHEMA,$user_id,$ids);
  }
  $ids = array_values(array_unique(array_map('intval',$ids)));
  if (empty($ids)) respond(["success"=>false,"step"=>"7a","error"=>"Sin IDs"],200);

  $ph = implode(',', array_fill(0, count($ids), '?'));
  $types_ids = str_repeat('i', count($ids));

  // 7a-1) Conteo con is_active=1
  $sql_active = "
    SELECT id_empleado AS uid, COUNT(*) AS c
    FROM {$SCHEMA}.tmx_queja
    WHERE id_empleado IN ($ph)
      AND is_active = 1
      AND created_at BETWEEN ? AND ?
    GROUP BY id_empleado
  ";

  // 7a-2) Conteo sin filtrar is_active
  $sql_any = "
    SELECT id_empleado AS uid, COUNT(*) AS c
    FROM {$SCHEMA}.tmx_queja
    WHERE id_empleado IN ($ph)
      AND created_at BETWEEN ? AND ?
    GROUP BY id_empleado
  ";

  // 7a-3) Rangos min/max por empleado (sin filtrar periodo)
  $sql_range = "
    SELECT id_empleado AS uid,
           MIN(created_at) AS min_created,
           MAX(created_at) AS max_created,
           SUM(CASE WHEN is_active=1 THEN 1 ELSE 0 END) AS activos
    FROM {$SCHEMA}.tmx_queja
    WHERE id_empleado IN ($ph)
    GROUP BY id_empleado
  ";

  // 7a-4) Muestra (últimos 20)
  $sql_sample = "
    SELECT id, id_empleado AS uid, is_active, created_at
    FROM {$SCHEMA}.tmx_queja
    WHERE id_empleado IN ($ph)
    ORDER BY created_at DESC
    LIMIT 20
  ";

  $runSelect = function($sql, $tailTypes = "", $tailValues = []) use ($con,$ph,$types_ids,$ids){
    $sql = sprintf($sql, $ph); $types = $types_ids . $tailTypes; $vals = array_merge($ids, $tailValues);
    $stmt = $con->prepare($sql); $stmt->bind_param($types, ...$vals); $stmt->execute();
    $res = $stmt->get_result(); $out=[]; while($r=$res->fetch_assoc()){ $out[]=$r; } $stmt->close(); return $out;
  };

  $counts_active = $runSelect($sql_active, "ss", [$start,$end]);
  $counts_any    = $runSelect($sql_any, "ss", [$start,$end]);
  $ranges        = $runSelect($sql_range);
  $sample        = $runSelect($sql_sample);

  respond([
    "success"=>true, "step"=>"7a",
    "counts_active"=>$counts_active,
    "counts_any"=>$counts_any,
    "ranges"=>$ranges,
    "sample"=>$sample,
    "period"=>["start"=>$start,"end"=>$end],
    "hint"=>"Si counts_any trae datos pero counts_active no, revisa is_active; si ranges trae datos fuera del mes, entonces el periodo no los incluye."
  ],200);
}

// ===== Paso 8a: Inasistencias - Diagnóstico extendido =====
if ($step == '8a') {
  // Recalcular IDs
  $ids = [];
  if ($solo_usuario){ $ids = [$user_id]; }
  elseif (in_array($user_type,[5,6], true)) {
    $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario");
    while ($r = $rs->fetch_assoc()) { $ids[] = (int)$r['user_id']; }
    if ($rs) $rs->close();
  } else {
    $ids[] = $user_id;
    if ($include_jefe){
      $stmt=$con->prepare("SELECT reporta_a FROM {$SCHEMA}.tmx_acceso_usuario WHERE user_id=?");
      if($stmt){ $stmt->bind_param("i",$user_id); if($stmt->execute()){ $stmt->bind_result($boss); if($stmt->fetch()&&$boss)$ids[]=(int)$boss; } $stmt->close(); }
    }
    obtenerSubordinados($con,$SCHEMA,$user_id,$ids);
  }
  $ids = array_values(array_unique(array_map('intval',$ids)));
  if (empty($ids)) respond(["success"=>false,"step"=>"8a","error"=>"Sin IDs"],200);

  $ph = implode(',', array_fill(0, count($ids), '?'));
  $types_ids = str_repeat('i', count($ids));

  // Conteo dentro del periodo
  $sql_count = "
    SELECT id_empleado AS uid, COUNT(*) AS c
    FROM {$SCHEMA}.tmx_inasistencia
    WHERE id_empleado IN ($ph)
      AND created_at BETWEEN ? AND ?
    GROUP BY id_empleado
  ";
  // Rangos globales
  $sql_range = "
    SELECT id_empleado AS uid,
           MIN(created_at) AS min_created,
           MAX(created_at) AS max_created
    FROM {$SCHEMA}.tmx_inasistencia
    WHERE id_empleado IN ($ph)
    GROUP BY id_empleado
  ";
  // Muestra
  $sql_sample = "
    SELECT id, id_empleado AS uid, created_at
    FROM {$SCHEMA}.tmx_inasistencia
    WHERE id_empleado IN ($ph)
    ORDER BY created_at DESC
    LIMIT 20
  ";

  $runSelect = function($sql, $tailTypes = "", $tailValues = []) use ($con,$ph,$types_ids,$ids){
    $sql = sprintf($sql, $ph); $types = $types_ids . $tailTypes; $vals = array_merge($ids, $tailValues);
    $stmt = $con->prepare($sql); $stmt->bind_param($types, ...$vals); $stmt->execute();
    $res = $stmt->get_result(); $out=[]; while($r=$res->fetch_assoc()){ $out[]=$r; } $stmt->close(); return $out;
  };

  $counts = $runSelect($sql_count, "ss", [$start,$end]);
  $ranges = $runSelect($sql_range);
  $sample = $runSelect($sql_sample);

  respond([
    "success"=>true, "step"=>"8a",
    "counts"=>$counts,
    "ranges"=>$ranges,
    "sample"=>$sample,
    "period"=>["start"=>$start,"end"=>$end]
  ],200);
}

// ===== Paso 9: Resultado final integrado (como producción) =====
if ($step == 9) {
  // Recalcular IDs
  $ids = [];
  if ($solo_usuario){ $ids = [$user_id]; }
  elseif (in_array($user_type, [5,6], true)) {
    $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario");
    while ($r = $rs->fetch_assoc()) { $ids[] = (int)$r['user_id']; }
    if ($rs) $rs->close();
  } else {
    $ids[] = $user_id;
    if ($include_jefe){
      $stmt = $con->prepare("SELECT reporta_a FROM {$SCHEMA}.tmx_acceso_usuario WHERE user_id=?");
      if($stmt){ $stmt->bind_param("i",$user_id); if($stmt->execute()){ $stmt->bind_result($boss); if($stmt->fetch() && $boss) $ids[]=(int)$boss; } $stmt->close(); }
    }
    obtenerSubordinados($con, $SCHEMA, $user_id, $ids);
  }
  $ids = array_values(array_unique(array_map('intval',$ids)));
  if (empty($ids)) respond(["success"=>true,"step"=>9,"rows"=>[]],200);

  $ph = implode(',', array_fill(0, count($ids), '?'));
  $types_ids = str_repeat('i', count($ids));

  // Mapa base
  $map = [];
  $sql_info = "
    SELECT acc.user_id, acc.user_type,
           CONCAT(COALESCE(us.user_name,''),' ',COALESCE(us.second_name,''),' ',COALESCE(us.last_name,'')) AS nombre
    FROM {$SCHEMA}.tmx_acceso_usuario acc
    LEFT JOIN {$SCHEMA}.tmx_usuario us ON acc.user_id = us.id
    WHERE acc.user_id IN ($ph)
  ";
  $stmt = $con->prepare($sql_info); $stmt->bind_param($types_ids, ...$ids); $stmt->execute();
  $res = $stmt->get_result();
  while ($r = $res->fetch_assoc()) {
    $uid = (int)$r['user_id'];
    $map[$uid] = ["id"=>$uid,"nombre"=>trim($r['nombre']??''),"rol"=>rol_label($r['user_type']??0),
                  "nuevo"=>0,"venta"=>0,"entrega"=>0,"reconocimientos"=>0,"quejas"=>0,"faltas"=>0,"total"=>0];
  }
  $stmt->close();

  $run = function($sqlBase, $tailTypes, $tailValues, $onRow) use ($con,$ph,$types_ids,$ids){
    $sql = sprintf($sqlBase, $ph);
    $types = $types_ids . $tailTypes;
    $vals  = array_merge($ids, $tailValues);
    $stmt = $con->prepare($sql); $stmt->bind_param($types, ...$vals); $stmt->execute();
    $res = $stmt->get_result(); while($row = $res->fetch_assoc()){ $onRow($row); } $stmt->close();
  };

  // N/R/E
  $run("
    SELECT r.created_by AS uid,
           SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%nuevo%'   THEN 1 ELSE 0 END) AS nuevo,
           SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%reserva%' THEN 1 ELSE 0 END) AS venta,
           SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%entrega%' THEN 1 ELSE 0 END) AS entrega
    FROM {$SCHEMA}.tmx_requerimiento r
    WHERE r.estatus = 2 AND r.created_by IN (%s)
      AND COALESCE(r.req_created_at, r.created_at) BETWEEN ? AND ?
    GROUP BY r.created_by
  ", "ss", [$start,$end], function($row) use (&$map){
    $u=(int)$row['uid']; if(isset($map[$u])){ $map[$u]['nuevo']=(int)$row['nuevo']; $map[$u]['venta']=(int)$row['venta']; $map[$u]['entrega']=(int)$row['entrega']; }
  });

  // Reconocimientos
  $run("
    SELECT asignado AS uid, COUNT(*) AS reconocimientos
    FROM {$SCHEMA}.tmx_reconocimientos
    WHERE asignado IN (%s) AND created_at BETWEEN ? AND ?
    GROUP BY asignado
  ", "ss", [$start,$end], function($row) use (&$map){
    $u=(int)$row['uid']; if(isset($map[$u])) $map[$u]['reconocimientos']=(int)$row['reconocimientos'];
  });

  // Quejas
  $run("
    SELECT id_empleado AS uid, COUNT(*) AS quejas
    FROM {$SCHEMA}.tmx_queja
    WHERE id_empleado IN (%s) AND is_active=1
      AND created_at BETWEEN ? AND ?
    GROUP BY id_empleado
  ", "ss", [$start,$end], function($row) use (&$map){
    $u=(int)$row['uid']; if(isset($map[$u])) $map[$u]['quejas']=(int)$row['quejas'];
  });

  // Inasistencias
  $run("
    SELECT id_empleado AS uid, COUNT(*) AS faltas
    FROM {$SCHEMA}.tmx_inasistencia
    WHERE id_empleado IN (%s)
      AND created_at BETWEEN ? AND ?
    GROUP BY id_empleado
  ", "ss", [$start,$end], function($row) use (&$map){
    $u=(int)$row['uid']; if(isset($map[$u])) $map[$u]['faltas']=(int)$row['faltas'];
  });

  foreach ($map as $k=>$v){ $map[$k]['total'] = (int)$v['nuevo'] + (int)$v['venta'] + (int)$v['entrega']; }
  usort($map, function($a,$b){ if($a['total']===$b['total']) return strcmp($a['nombre'],$b['nombre']); return $b['total']<=>$a['total']; });

  respond(["success"=>true,"step"=>9,"yyyymm"=>$yyyymm,"rows"=>array_values($map)],200);
}

// ===== Paso no reconocido =====
respond(["success"=>false,"step"=>$step,"error"=>"Paso no reconocido. Usa step 1..9 o '7a' y '8a'"],200);
