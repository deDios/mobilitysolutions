<?php
header('Content-Type: application/json');

// Incluir conexión a la base de datos
include "../db/Conexion.php";

// Obtener los datos del cuerpo de la solicitud en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validar que los datos existen
if (isset($data['folio']) && isset($data['id_promo']) && isset($data['id_cliente']) && isset($data['sub_total']) && isset($data['id_company'])) {
    $folio = $data['folio'];
    $id_promo = $data['id_promo'];
    $id_cliente = $data['id_cliente'];
    $sub_total = $data['sub_total'];
    $id_company = $data['id_company'];

    // Validación de tipos de datos
    if (!is_numeric($id_promo) || !is_numeric($id_cliente) || !is_numeric($sub_total) || !is_numeric($id_company)) {
        echo json_encode(["error" => "Los valores deben ser numéricos donde corresponde"]);
        exit;
    }

    // Preparar la consulta SQL para el INSERT
    $query = "INSERT INTO mobility_solutions.moon_descuentos (folio, id_promo, id_cliente, sub_total, id_company) 
              VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("siidd", $folio, $id_promo, $id_cliente, $sub_total, $id_company);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Descuento insertado exitosamente"]);
        } else {
            echo json_encode(["error" => "Error al insertar el descuento"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["error" => "Error en la consulta preparada"]);
    }
} else {
    echo json_encode(["error" => "Faltan parámetros en la solicitud"]);
}

$con->close();
?>
