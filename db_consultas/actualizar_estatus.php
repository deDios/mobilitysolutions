<?php
include "../db/Conexion.php";

// Verifica si se ha recibido un ID de requerimiento válido
if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // Asegurarse de que el ID sea un número entero
    $nuevo_estatus = 1; // Establecer el nuevo estatus (por ejemplo, 1 para aprobado)

    // Consulta SQL para actualizar el estatus
    $query = "update mobility_solutions.tmx_auto SET estatus = ? WHERE id = ?";
    
    // Preparar y ejecutar la consulta
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param('ii', $nuevo_estatus, $id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Requerimiento aprobado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el estatus.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error en la consulta.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID no válido.']);
}
?>
