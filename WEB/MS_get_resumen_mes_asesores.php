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
$step = $body['step'] ?? 1;                    // Paso por defecto = 1
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

// A partir del paso 2 sí necesitamos DB
include "../db/Conexion.php";   // Debe definir $con = new mysqli(...)

if (!isset($con) || !($con instanceof mysqli)){
  respond(["success"=>false,"step"=>$step,"error"=>"Conexión DB no inicializada en Conexion.php"], 200);
}
if ($con->connect_errno){
  respond(["success"=>false,"step"=>$step,"error"=>"Error de conexión DB: ".$con->connect_error], 200);
}

// Nombre de esquema fijo según tus DDL
$SCHEMA = "mobility_solutions";

// ===== Paso 2: Ping de DB y tablas claves =====
if ($step == 2){
  $checks = [];
  foreach (["tmx_acceso_usuario","tmx_usuario","tmx_requerimiento","tmx_reconocimientos","tmx_queja","tmx_inasistencia"] as $t){
    $q = $con->query("SELECT 1 FROM {$SCHEMA}.{$t} LIMIT 1");
    $checks[$t] = $q ? "ok" : "fail";
    if ($q) $q->close();
  }
  respond(["success"=>true,"step"=>2,"db_host"=>$con->host_info,"tables"=>$checks,"hint"=>"Si todo ok, avanza con step=3"], 200);
}

// ===== Utilidades comunes para siguientes pasos =====
if (!valid_yyyymm($yyyymm)) $yyyymm = date('Y-m');
list($Y,$M) = array_map('intval', explode('-', $yyyymm));
$daysInMonth = (int)cal_days_in_month(CAL_GREGORIAN, $M, $Y);
$start = sprintf('%04d-%02d-01 00:00:00',$Y,$M);
$end   = sprintf('%04d-%02d-%02d 23:59:59',$Y,$M,$daysInMonth);

// Recursivo de jerarquía
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

// ===== Paso 3: Construcción de IDs (alcance jerárquico) =====
if ($step == 3){
  if (!$user_id || !$user_type) respond(["success"=>false,"step"=>3,"error"=>"Faltan user_id/user_type"],200);

  $ids = [];
  if ($solo_usuario){
    $ids = [$user_id];
  } elseif (in_array($user_type,[5,6], true)) {
    $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario");
    while($r = $rs && $r->fetch_assoc()){ $ids[] = (int)$r['user_id']; }
    if ($rs) $rs->close();
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

// ===== Paso 4: Info de usuarios (join acceso_usuario + usuario) =====
if ($step == 4){
  $ids = $body['ids'] ?? null; // permite pasar ids del paso 3 (o volver a generarlos)
  if (!is_array($ids)){
    // Recalcular rápido si no vienen
    $tmp = ["step"=>3,"user_id"=>$user_id,"user_type"=>$user_type,"solo_usuario"=>$solo_usuario,"include_jefe"=>$include_jefe,"yyyymm"=>$yyyymm];
    $_POST = []; // no usado aquí
    // Reutiliza la lógica de 3 (para brevedad vuelvo a consultarlo):
    $ids = [];
    if ($solo_usuario){ $ids = [$user_id]; }
    elseif (in_array($user_type,[5,6], true)) {
      $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario");
      while($r = $rs && $r->fetch_assoc()){ $ids[] = (int)$r['user_id']; }
      if ($rs) $rs->close();
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
  }
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

// ===== Paso 5: N/R/E (tmx_requerimiento) =====
if ($step == 5){
  // Recalcular IDs rápido:
  $ids = [];
  if ($solo_usuario){ $ids = [$user_id]; }
  elseif (in_array($user_type,[5,6], true)) { $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario"); while($r = $rs && $r->fetch_assoc()){ $ids[]=(int)$r['user_id']; } if ($rs) $rs->close(); }
  else { $ids[]=$user_id; if ($include_jefe){ $stmt=$con->prepare("SELECT reporta_a FROM {$SCHEMA}.tmx_acceso_usuario WHERE user_id=?"); if($stmt){ $stmt->bind_param("i",$user_id); if($stmt->execute()){ $stmt->bind_result($boss); if($stmt->fetch()&&$boss)$ids[]=(int)$boss; } $stmt->close(); } } obtenerSubordinados($con,$SCHEMA,$user_id,$ids); }
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
  while($r = $res->fetch_assoc()){ $rows[] = array_map('intval',$r); }
  $stmt->close();

  respond(["success"=>true,"step"=>5,"rows"=>$rows,"hint"=>"Si ok, step=6"],200);
}

// ===== Paso 6: Reconocimientos =====
if ($step == 6){
  // IDs:
  $ids = [];
  if ($solo_usuario){ $ids = [$user_id]; }
  elseif (in_array($user_type,[5,6], true)) { $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario"); while($r = $rs && $r->fetch_assoc()){ $ids[]=(int)$r['user_id']; } if ($rs) $rs->close(); }
  else { $ids[]=$user_id; if ($include_jefe){ $stmt=$con->prepare("SELECT reporta_a FROM {$SCHEMA}.tmx_acceso_usuario WHERE user_id=?"); if($stmt){ $stmt->bind_param("i",$user_id); if($stmt->execute()){ $stmt->bind_result($boss); if($stmt->fetch()&&$boss)$ids[]=(int)$boss; } $stmt->close(); } } obtenerSubordinados($con,$SCHEMA,$user_id,$ids); }
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
  elseif (in_array($user_type,[5,6], true)) { $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario"); while($r = $rs && $r->fetch_assoc()){ $ids[]=(int)$r['user_id']; } if ($rs) $rs->close(); }
  else { $ids[]=$user_id; if ($include_jefe){ $stmt=$con->prepare("SELECT reporta_a FROM {$SCHEMA}.tmx_acceso_usuario WHERE user_id=?"); if($stmt){ $stmt->bind_param("i",$user_id); if($stmt->execute()){ $stmt->bind_result($boss); if($stmt->fetch()&&$boss)$ids[]=(int)$boss; } $stmt->close(); } } obtenerSubordinados($con,$SCHEMA,$user_id,$ids); }
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
  elseif (in_array($user_type,[5,6], true)) { $rs = $con->query("SELECT user_id FROM {$SCHEMA}.tmx_acceso_usuario"); while($r = $rs && $r->fetch_assoc()){ $ids[]=(int)$r['user_id']; } if ($rs) $rs->close(); }
  else { $ids[]=$user_id; if ($include_jefe){ $stmt=$con->prepare("SELECT reporta_a FROM {$SCHEMA}.tmx_acceso_usuario WHERE user_id=?"); if($stmt){ $stmt->bind_param("i",$user_id); if($stmt->execute()){ $stmt->bind_result($boss); if($stmt->fetch()&&$boss)$ids[]=(int)$boss; } $stmt->close(); } } obtenerSubordinados($con,$SCHEMA,$user_id,$ids); }
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

  respond(["success"=>true,"step"=>8,"rows"=>$rows,"hint"=>"Si ok, cerramos integrando todo (step=9)"],200);
}

// ===== Paso 9: (opcional) devolver OK si llegaste aquí por error de step =====
respond(["success"=>false,"step"=>$step,"error"=>"Paso no reconocido. Usa step 1..8"],200);
