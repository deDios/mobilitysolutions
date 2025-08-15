<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

try {
  $data = json_decode(file_get_contents("php://input"), true);

  // Campos requeridos
  $required = ['id_empleado', 'reportado_por', 'hr_registro', 'comentario', 'created_by'];
  foreach ($required as $f) {
    if (!isset($data[$f])) {
      echo json_encode(["success" => false, "message" => "Falta el campo requerido: $f"]);
      exit;
    }
  }

  $sql = "
    INSERT INTO mobility_solutions.tmx_inasistencia
      (id_empleado, reportado_por, hr_registro, comentario, created_at, created_by, is_active)
    VALUES
      (?, ?, ?, ?, NOW(), ?, 1)
  ";

  $stmt = $con->prepare($sql);
  $stmt->bind_param(
    "iissi",
    $data['id_empleado'],
    $data['reportado_por'],
    $data['hr_registro'],
    $data['comentario'],
    $data['created_by']
  );

  if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Inasistencia registrada correctamente.", "id" => $stmt->insert_id]);
  } else {
    echo json_encode(["success" => false, "message" => "Error al registrar inasistencia: ".$stmt->error]);
  }

  $stmt->close();
  $con->close();
} catch (Exception $e) {
  echo json_encode(["success" => false, "message" => "Excepción: ".$e->getMessage()]);
}
