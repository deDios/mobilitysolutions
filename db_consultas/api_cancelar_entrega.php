<?php
header("Content-Type: application/json; charset=utf-8");

$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data) || !isset($data['vehiculo']['id']) || !isset($data['usuario']['id'])) {
  echo json_encode(["success" => false, "message" => "Datos inválidos"]);
  exit;
}

require "../db/Conexion.php";
mysqli_set_charset($con, "utf8mb4");

$id_auto    = (int)$data['vehiculo']['id'];
$id_usuario = (int)$data['usuario']['id'];

if ($id_auto <= 0 || $id_usuario <= 0) {
  echo json_encode(["success" => false, "message" => "IDs inválidos"]);
  exit;
}

/* 1) Verificar que el auto existe (y opcionalmente su estatus) */
$sqlSel = "SELECT id, estatus FROM mobility_solutions.tmx_auto WHERE id = ?";
$stmtS  = $con->prepare($sqlSel);
if (!$stmtS) {
  echo json_encode(["success" => false, "message" => "Error preparando SELECT"]);
  exit;
}
$stmtS->bind_param("i", $id_auto);
$stmtS->execute();
$res = $stmtS->get_result();
if ($res->num_rows === 0) {
  $stmtS->close();
  echo json_encode(["success" => false, "message" => "Vehículo no encontrado"]);
  exit;
}
$auto = $res->fetch_assoc();
$stmtS->close();

/* Si quieres forzar que solo cancele si está reservado (3), descomenta: */
// if ((int)$auto['estatus'] !== 3) {
//   echo json_encode(["success" => false, "message" => "El vehículo no está en estatus 'reservado' (3)"]);
//   exit;
// }

/* 2) Actualizar estatus a 1 (disponible) */
$sqlUpd = "UPDATE mobility_solutions.tmx_auto SET estatus = 1, updated_at = NOW() WHERE id = ?";
$stmtU  = $con->prepare($sqlUpd);
if (!$stmtU) {
  echo json_encode(["success" => false, "message" => "Error preparando UPDATE"]);
  exit;
}
$stmtU->bind_param("i", $id_auto);

if (!$stmtU->execute()) {
  $msg = $stmtU->error ?: "Error al ejecutar UPDATE";
  $stmtU->close();
  echo json_encode(["success" => false, "message" => $msg]);
  exit;
}

$affected = $stmtU->affected_rows;
$stmtU->close();
$con->close();

echo json_encode([
  "success" => true,
  "message" => $affected > 0
      ? "Entrega cancelada. Estatus establecido a 1."
      : "Sin cambios (estatus ya era 1)."
]);
