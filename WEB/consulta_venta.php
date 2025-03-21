<?php
header('Content-Type: application/json');

// Lee el cuerpo JSON de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Verifica si el company_id fue enviado
$company_id = isset($data['company_id']) ? intval($data['company_id']) : 0;

if ($company_id === 0) {
    echo json_encode(['success' => false, 'message' => 'Company ID requerido']);
    exit;
}

// Incluye la conexión a la base de datos
include "../db/Conexion.php";

// Consulta SQL sin filtrar por mes
$query = "
SELECT 
    DATE(DATE_SUB(v.created_at, INTERVAL 6 HOUR)) AS FechaVenta, 
    SUM(v.sub_total) AS TotalVenta,
    ROUND(COALESCE(AVG(g.TotalGasto), 0),2) AS Gasto,
    ROUND(COALESCE(AVG(gas.Totaldescuentos), 0),2) AS Descuentos
FROM 
    mobility_solutions.moon_ventas AS v
LEFT JOIN 
    (SELECT 
        DATE(DATE_SUB(created_at, INTERVAL 6 HOUR)) AS FechaGasto, 
        SUM(costo) AS TotalGasto
     FROM 
        mobility_solutions.moon_gasto
     GROUP BY 
        FechaGasto
    ) AS g 
ON DATE(DATE_SUB(v.created_at, INTERVAL 6 HOUR)) = g.FechaGasto
LEFT JOIN 
    (SELECT 
        DATE(DATE_SUB(created_at, INTERVAL 6 HOUR)) AS Fechades, 
        SUM(sub_total) AS Totaldescuentos
     FROM 
        mobility_solutions.moon_descuentos
     GROUP BY 
        Fechades
    ) AS gas 
ON DATE(DATE_SUB(v.created_at, INTERVAL 6 HOUR)) = gas.Fechades
GROUP BY 
    FechaVenta
ORDER BY FechaVenta DESC
";

$stmt = $con->prepare($query);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Error en la consulta']);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();

$ventasData = [];
while ($row = $result->fetch_assoc()) {
    $ventasData[] = $row;
}

// Devuelve los resultados en formato JSON
echo json_encode(['success' => true, 'data' => $ventasData]);

$stmt->close();
$con->close();
?>
