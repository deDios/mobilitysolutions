<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;
$user_type = isset($_GET['user_type']) ? intval($_GET['user_type']) : null;

if (!$user_id || !$user_type) {
    echo json_encode(["error" => "Faltan parámetros"]);
    exit;
}

// 🔁 Función recursiva para obtener todos los subordinados
function obtenerSubordinados($con, $userId, &$subordinados) {
    $stmt = $con->prepare("SELECT user_id FROM mobility_solutions.tmx_acceso_usuario WHERE reporta_a = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $subId = $row['user_id'];
        if (!in_array($subId, $subordinados)) {
            $subordinados[] = $subId;
            obtenerSubordinados($con, $subId, $subordinados); // recursivo
        }
    }

    $stmt->close();
}

// 📦 Obtener lista de IDs según el tipo de usuario
if (in_array($user_type, [5, 6])) {
    // CEO o CTO: incluir a todos
    $query = "SELECT user_id FROM mobility_solutions.tmx_acceso_usuario";
    $res = mysqli_query($con, $query);
    $ids = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $ids[] = $row['user_id'];
    }
} else {
    // Otros usuarios: incluir a sí mismo + subordinados
    $ids = [$user_id];
    obtenerSubordinados($con, $user_id, $ids);
}

$id_list = implode(',', $ids);
$anioActual = date("Y");

// 📊 Consulta de requerimientos
$query = "SELECT
            m.Mes,
            COALESCE(SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%nuevo%' THEN 1 ELSE 0 END), 0) AS New,
            COALESCE(SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%reserva%' THEN 1 ELSE 0 END), 0) AS Reserva,
            COALESCE(SUM(CASE WHEN LOWER(TRIM(r.tipo_req)) LIKE '%entrega%' THEN 1 ELSE 0 END), 0) AS Entrega
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
            AND r.created_by IN ($id_list)
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
    echo json_encode(["error" => "Error en la consulta"]);
}

mysqli_close($con);
?>
