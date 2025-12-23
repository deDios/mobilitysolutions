<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

try {
    $data = json_decode(file_get_contents("php://input"), true) ?: [];

    $usuario = isset($data['usuario']) ? (int)$data['usuario']
              : (isset($data['user_id']) ? (int)$data['user_id'] : 0);

    // Año: si no lo mandas en el JSON, toma el año actual
    $anio = isset($data['anio']) ? (int)$data['anio'] : (int)date('Y');

    if ($usuario <= 0) {
        echo json_encode([
            "success" => false,
            "message" => "Parámetro 'usuario' es requerido."
        ]);
        exit;
    }

    $sql = "
        SELECT 
            q.id,
            q.id_empleado,
            emp.user_name   AS empleado_nombre,
            q.reportado_por,
            rep.user_name   AS reportado_por_nombre,
            q.cliente,
            q.comentario,
            q.created_at,
            q.updated_at
        FROM mobility_solutions.tmx_queja AS q
        LEFT JOIN mobility_solutions.tmx_usuario AS emp ON emp.id = q.id_empleado
        LEFT JOIN mobility_solutions.tmx_usuario AS rep ON rep.id = q.reportado_por
    ";

    if ($usuario === 9999) {
        // Admin: todas las quejas del año actual
        $sql .= " WHERE YEAR(q.created_at) = ? ORDER BY q.created_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $anio);
    } else {
        // Solo del usuario indicado, en el año actual
        $sql .= " WHERE q.id_empleado = ? AND YEAR(q.created_at) = ? 
                  ORDER BY q.created_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $usuario, $anio);

        // Si quisieras incluir también las que él reportó:
        // $sql .= " WHERE (q.id_empleado = ? OR q.reportado_por = ?) AND YEAR(q.created_at) = ? ORDER BY q.created_at DESC";
        // $stmt = $con->prepare($sql);
        // $stmt->bind_param("iii", $usuario, $usuario, $anio);
    }

    $stmt->execute();
    $res = $stmt->get_result();

    $items = [];
    while ($row = $res->fetch_assoc()) {
        $items[] = $row;
    }

    echo json_encode([
        "success" => true,
        "anio"    => $anio,
        "count"   => count($items),
        "items"   => $items
    ]);

    $stmt->close();
    $con->close();
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: ".$e->getMessage()]);
}
?>
