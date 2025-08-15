<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

try {
  $data = json_decode(file_get_contents("php://input"), true);

  // Requeridos: id + al menos un campo a actualizar
  if (!isset($data['id'])) {
    echo json_encode(["success" => false, "message" => "Falta el campo requerido: id"]);
    exit;
  }

  // Campos permitidos para actualizar
  $fields = [
    "id_empleado"   => "i",
    "reportado_por" => "i",
    "cliente"       => "s",
    "comentario"    => "s",
    "is_active"     => "i",
    "updated_by"    => "i"
  ];

  $setParts = [];
  $types = "";
  $values = [];

  foreach ($fields as $k => $t) {
    if (array_key_exists($k, $data)) {
      $setParts[] = "$k = ?";
      $types .= $t;
      $values[] = $data[$k];
    }
  }

  if (empty($setParts)) {
    echo json_encode(["success" => false, "message" => "No se enviaron campos para actualizar."]);
    exit;
  }

  // updated_at siempre
  $setParts[] = "updated_at = NOW()";
  $sql = "UPDATE mobility_solutions.tmx_queja SET ".implode(", ", $setParts)." WHERE id = ?";

  $stmt = $con->prepare($sql);

  // bind params dinámico
  $types .= "i";
  $values[] = intval($data['id']);
  $stmt->bind_param($types, ...$values);

  if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Queja actualizada correctamente."]);
  } else {
    echo json_encode(["success" => false, "message" => "Error al actualizar queja: ".$stmt->error]);
  }

  $stmt->close();
  $con->close();
} catch (Exception $e) {
  echo json_encode(["success" => false, "message" => "Excepción: ".$e->getMessage()]);
}
