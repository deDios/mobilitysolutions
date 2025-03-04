<?php
header("Content-Type: application/json");

// Obtener datos de la solicitud
$data = json_decode(file_get_contents("php://input"), true);

// Si no hay datos válidos, enviar error
if (!$data || !isset($data['vehiculo']) || !isset($data['usuario'])) {
    echo json_encode(["success" => false, "message" => "Datos inválidos."]);
    exit;
}

// Imprimir los datos recibidos para pruebas
echo json_encode([
    "success" => true,
    "datos_recibidos" => $data
]);

// *** SE COMENTÓ LA PARTE DE LA BASE DE DATOS ***
// require "../db/Conexion.php";
// $vehiculo = $data['vehiculo'];
// $usuario = $data['usuario'];

// $query = "INSERT INTO reservas (id_usuario, id_vehiculo, fecha_reserva) VALUES (?, ?, NOW())";
// $stmt = $con->prepare($query);
// $stmt->bind_param("ii", $usuario['id'], $vehiculo['id']);

// if ($stmt->execute()) {
//     echo json_encode(["success" => true]);
// } else {
//     echo json_encode(["success" => false, "message" => "Error en la base de datos."]);
// }

// $stmt->close();
// $con->close();
?>
