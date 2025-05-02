<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$inc = include "../db/Conexion.php"; 

$id_cliente = isset($_GET['id_cliente']) ? intval($_GET['id_cliente']) : 0;

if ($id_cliente <= 0) {
    echo json_encode(["success" => false, "message" => "ID de cliente no válido"]);
    exit;
}

try {
    $query = "
        SELECT 
            lp.id, 
            lp.id_cliente, 
            lp.id_producto, 
            lp.id_compuesto, 
            lp.id_promo, 
            p.nombre,
            p.porcentaje, 
            p.cantidad AS efectivo, 
            p.promo_type,
            tp.nombre AS tipo_promo_name,
            lp.cantidad, 
            lp.start_date, 
            lp.end_date
        FROM mobility_solutions.moon_lista_promo AS lp
        LEFT JOIN mobility_solutions.moon_promo AS p ON lp.id_promo = p.id
        LEFT JOIN mobility_solutions.moon_tipo_promo AS tp ON p.promo_type = tp.id
        WHERE lp.id_company = 1 AND lp.id_cliente = :id_cliente
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["success" => true, "data" => $result]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
