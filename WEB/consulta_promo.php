<?php
header('Content-Type: application/json');

// Incluir conexión a la base de datos
include "../db/Conexion.php";

// Obtener parámetros de la solicitud
$id_company = 1;  // Siempre será 1 según lo que mencionaste
$id_cliente = isset($_GET['id_cliente']) ? intval($_GET['id_cliente']) : 0;

// Validar que el ID del cliente sea válido
if ($id_cliente <= 0) {
    echo json_encode(["error" => "Parámetro id_cliente inválido"]);
    exit;
}

// Preparar la consulta SQL
$query = "SELECT 
            lp.id, 
            lp.id_cliente, 
            lp.id_producto, 
            lp.id_compuesto, 
            lp.id_promo, 
            p.nombre,
            p.porcentaje, 
            p.cantidad AS efectivo, 
            p.promo_type AS promo_type_id,
            tp.nombre AS tipo_promo_name,
            lp.cantidad, 
            lp.start_date, 
            lp.end_date
          FROM mobility_solutions.moon_lista_promo AS lp
          LEFT JOIN mobility_solutions.moon_promo AS p ON lp.id_promo = p.id
          LEFT JOIN mobility_solutions.moon_tipo_promo AS tp ON p.promo_type = tp.id
          WHERE lp.id_company = ? AND lp.id_cliente = ? AND p.status = 1";

// Preparar y ejecutar la consulta con parámetros seguros
if ($stmt = $con->prepare($query)) {
    $stmt->bind_param("ii", $id_company, $id_cliente);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "id" => (int)$row["id"],
            "id_cliente" => (int)$row["id_cliente"],
            "id_producto" => (int)$row["id_producto"],
            "id_compuesto" => (int)$row["id_compuesto"],
            "id_promo" => (int)$row["id_promo"],
            "nombre" => $row["nombre"],
            "porcentaje" => (float)$row["porcentaje"],
            "efectivo" => (float)$row["efectivo"],
            "promo_type_id" => (int)$row["promo_type_id"],
            "tipo_promo_name" => $row["tipo_promo_name"],
            "cantidad" => (int)$row["cantidad"],
            "start_date" => $row["start_date"],
            "end_date" => $row["end_date"]
        ];
    }

    echo json_encode($data);
    $stmt->close();
} else {
    echo json_encode(["error" => "Error en la consulta"]);
}

$con->close();
?>
