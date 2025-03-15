<?php
header('Content-Type: application/json');

// Incluir conexión a la base de datos
include "../db/Conexion.php";

// Obtener parámetros de la solicitud
$folio = isset($_POST['folio']) ? $_POST['folio'] : '';
$id_promo = isset($_POST['id_promo']) ? intval($_POST['id_promo']) : 0;
$id_cliente = isset($_POST['id_cliente']) ? intval($_POST['id_cliente']) : 0;
$sub_total = isset($_POST['sub_total']) ? floatval($_POST['sub_total']) : 0.0;
$id_company = 1;  // Según lo que mencionaste siempre será 1

// Validar que los parámetros sean válidos
if (empty($folio) || $id_promo <= 0 || $id_cliente <= 0 || $sub_total <= 0) {
    echo json_encode(["error" => "Parámetros inválidos"]);
    exit;
}

// Preparar la consulta SQL
$query = "INSERT INTO mobility_solutions.moon_descuentos (folio, id_promo, id_cliente, sub_total, id_company) 
          VALUES (?, ?, ?, ?, ?)";

// Preparar y ejecutar la consulta con parámetros seguros
if ($stmt = $con->prepare($query)) {
    $stmt->bind_param("siidi", $folio, $id_promo, $id_cliente, $sub_total, $id_company);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Descuento insertado exitosamente"]);
    } else {
        echo json_encode(["error" => "Error al insertar descuento"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Error en la preparación de la consulta"]);
}

$con->close();
?>
