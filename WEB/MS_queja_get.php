<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

try {
    $data = json_decode(file_get_contents("php://input"), true) ?: [];
    $usuario = isset($data['usuario']) ? (int)$data['usuario']
              : (isset($data['user_id']) ? (int)$data['user_id'] : 0);

    if ($usuario <= 0) {
        echo json_encode(["success" => false, "message" => "Parámetro 'usuario' es requerido."]); exit;
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
        $sql .= " ORDER BY q.created_at DESC";
        $stmt = $con->prepare($sql);
    } else {
        // Solo del usuario indicado:
        $sql .= " WHERE q.id_empleado = ? ";
        // 👉 Si quieres incluir también las quejas reportadas por él/ella:
        // $sql .= " WHERE (q.id_empleado = ? OR q.reportado_por = ?) ";

        $sql .= " ORDER BY q.created_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $usuario);
        // Para la versión OR, usa: $stmt->bind_param("ii", $usuario, $usuario);
    }

    $stmt->execute();
    $res = $stmt->get_result();

    $items = [];
    while ($row = $res->fetch_assoc()) {
        $items[] = $row;
    }

    echo json_encode([
        "success" => true,
        "count"   => count($items),
        "items"   => $items
    ]);

    $stmt->close();
    $con->close();
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: ".$e->getMessage()]);
}
