<?php
header('Content-Type: application/json');

// Incluir conexión a la base de datos
include "../db/Conexion.php";

// Obtener los datos del cuerpo de la solicitud en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validar que los datos existen
if (isset($data['folio']) && isset($data['id_promo']) && isset($data['id_cliente']) && isset($data['sub_total']) && isset($data['id_company']) && isset($data['promo_id'])) {
    $folio = $data['folio'];
    $id_promo = $data['id_promo']; // Este es el ID del descuento
    $id_cliente = $data['id_cliente'];
    $sub_total = $data['sub_total'];
    $id_company = $data['id_company'];
    $promo_id = $data['promo_id']; // Este es el ID de la promoción en moon_lista_promo

    // Validación de tipos de datos
    if (!is_numeric($id_promo) || !is_numeric($id_cliente) || !is_numeric($sub_total) || !is_numeric($id_company) || !is_numeric($promo_id)) {
        echo json_encode(["error" => "Los valores deben ser numéricos donde corresponde"]);
        exit;
    }

    // Iniciar transacción
    $con->begin_transaction();

    try {
        // Insertar el descuento en moon_descuentos
        $query = "INSERT INTO mobility_solutions.moon_descuentos (folio, id_promo, id_cliente, sub_total, id_company) 
                  VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $con->prepare($query)) {
            $stmt->bind_param("siidi", $folio, $id_promo, $id_cliente, $sub_total, $id_company);
            if (!$stmt->execute()) {
                throw new Exception("Error al insertar el descuento");
            }
            $stmt->close();
        } else {
            throw new Exception("Error en la consulta preparada");
        }

        // Restar 1 a la cantidad en moon_lista_promo usando promo.id
        $updateQuery = "UPDATE mobility_solutions.moon_lista_promo SET cantidad = cantidad - 1 WHERE id = ?";
        if ($stmt = $con->prepare($updateQuery)) {
            $stmt->bind_param("i", $promo_id);
            if (!$stmt->execute()) {
                throw new Exception("Error al actualizar la cantidad de la promoción");
            }
            $stmt->close();
        } else {
            throw new Exception("Error en la consulta de actualización");
        }

        // Confirmar la transacción
        $con->commit();
        echo json_encode(["status" => "success", "message" => "Descuento registrado y cantidad actualizada"]);
    } catch (Exception $e) {
        // Revertir en caso de error
        $con->rollback();
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Faltan parámetros en la solicitud"]);
}

$con->close();
?>
