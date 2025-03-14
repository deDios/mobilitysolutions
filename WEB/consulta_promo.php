<?php
header('Content-Type: application/json');
include "../db/Conexion.php";  // Asegúrate de que la conexión a la BD es correcta

$company_id = 1;  // Valor fijo
$id_cliente = isset($_GET['id_cliente']) ? intval($_GET['id_cliente']) : 0;

if ($id_cliente <= 0) {
    echo json_encode(["error" => "Parámetro id_cliente inválido"]);
    exit;
}

$query = "SELECT 
            lp.id, 
            p.nombre AS promo_nombre, 
            p.porcentaje, 
            p.cantidad, 
            p.promo_type, 
            tp.nombre AS tipo_promo_name
          FROM mobility_solutions.moon_lista_promo AS lp
          LEFT JOIN mobility_solutions.moon_promo AS p ON lp.id_promo = p.id
          LEFT JOIN mobility_solutions.moon_tipo_promo AS tp ON p.promo_type = tp.id
          WHERE lp.id_company = ? AND lp.id_cliente = ? AND p.status = 1";

$stmt = $con->prepare($query);
$stmt->bind_param("ii", $company_id, $id_cliente);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        "id" => (int) $row["id"],
        "nombre" => $row["promo_nombre"],
        "porcentaje" => (int) $row["porcentaje"],
        "cantidad" => (int) $row["cantidad"],
        "tipo_promo" => $row["tipo_promo_name"]
    ];
}

echo json_encode($data);
$stmt->close();
$con->close();
?>
