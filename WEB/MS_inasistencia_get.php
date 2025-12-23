<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

try {
    $data = json_decode(file_get_contents("php://input"), true) ?: [];
    $usuario = isset($data['usuario']) ? (int)$data['usuario']
              : (isset($data['user_id']) ? (int)$data['user_id'] : 0);

    // Año actual por default
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
            ina.id,
            ina.id_empleado,
            emp.user_name   AS empleado_nombre,
            ina.reportado_por,
            rep.user_name   AS reportado_por_nombre,
            ina.hr_registro,
            ina.comentario,
            ina.created_at,
            ina.updated_at
        FROM mobility_solutions.tmx_inasistencia AS ina
        LEFT JOIN mobility_solutions.tmx_usuario AS emp ON emp.id = ina.id_empleado
        LEFT JOIN mobility_solutions.tmx_usuario AS rep ON rep.id = ina.reportado_por
    ";

    if ($usuario === 9999) {
        // Admin: todas las inasistencias del año actual
        $sql .= " WHERE YEAR(ina.created_at) = ? ORDER BY ina.created_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $anio);
    } else {
        // Solo del usuario indicado, año actual
        $sql .= " WHERE ina.id_empleado = ? AND YEAR(ina.created_at) = ? 
                  ORDER BY ina.created_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $usuario, $anio);

        // Versión para incluir lo que él/ella reportó:
        // $sql .= " WHERE (ina.id_empleado = ? OR ina.reportado_por = ?) AND YEAR(ina.created_at) = ? ORDER BY ina.created_at DESC";
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
