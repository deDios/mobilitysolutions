<?php
$user_id = $_GET['user_id']; 

header('Content-Type: application/json');

if (!is_numeric($user_id)) {
    echo json_encode(["error" => "user_id no válido"]);
    exit();
}

include "../db/Conexion.php";

$anioActual = date("Y");
$condicionUsuario = ($user_id == 9999) ? "" : "AND r.created_by = $user_id";

$query = "SELECT
            m.Mes,
            COALESCE(SUM(CASE WHEN r.tipo_req = 'Nuevo en catálogo' THEN 1 ELSE 0 END), 0) AS New,
            COALESCE(SUM(CASE WHEN r.tipo_req = 'Reserva de vehículo' THEN 1 ELSE 0 END), 0) AS Reserva,
            COALESCE(SUM(CASE WHEN r.tipo_req = 'Entrega de vehículo' THEN 1 ELSE 0 END), 0) AS Entrega
          FROM (
            SELECT 1 AS num, 'Enero' AS Mes UNION ALL
            SELECT 2, 'Febrero' UNION ALL
            SELECT 3, 'Marzo' UNION ALL
            SELECT 4, 'Abril' UNION ALL
            SELECT 5, 'Mayo' UNION ALL
            SELECT 6, 'Junio' UNION ALL
            SELECT 7, 'Julio' UNION ALL
            SELECT 8, 'Agosto' UNION ALL
            SELECT 9, 'Septiembre' UNION ALL
            SELECT 10, 'Octubre' UNION ALL
            SELECT 11, 'Noviembre' UNION ALL
            SELECT 12, 'Diciembre'
          ) AS m
          LEFT JOIN mobility_solutions.tmx_requerimiento r
          ON MONTH(r.req_created_at) = m.num
          AND YEAR(r.req_created_at) = $anioActual
          AND r.status_req = 2
          $condicionUsuario
          GROUP BY m.num, m.Mes
          ORDER BY m.num";

$result = mysqli_query($con, $query);

if ($result) {
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['New'] = (int)$row['New'];
        $row['Reserva'] = (int)$row['Reserva'];
        $row['Entrega'] = (int)$row['Entrega'];
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(["error" => "No se encontraron resultados o hubo un error en la consulta"]);
}

mysqli_close($con);
?>
