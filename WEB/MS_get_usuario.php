<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

$query = "
    SELECT 
        acc.user_id, 
        acc.user_name, 
        acc.user_password, 
        acc.user_type, 
        acc.r_ejecutivo, 
        acc.r_editor, 
        acc.r_autorizador, 
        acc.r_analista, 
        us.user_name AS nombre, 
        us.second_name AS s_nombre, 
        us.last_name, 
        us.email, 
        us.cumpleaños, 
        us.telefono
    FROM mobility_solutions.tmx_acceso_usuario AS acc
    LEFT JOIN mobility_solutions.tmx_usuario AS us
        ON acc.user_id = us.id
";

$result = $con->query($query);
$usuarios = [];

while ($row = $result->fetch_assoc()) {
    // Lógica para calcular el rol
    $rol = "Sin rol";

    if (
        $row["r_ejecutivo"] == 1 &&
        empty($row["r_editor"]) &&
        empty($row["r_autorizador"]) &&
        empty($row["r_analista"])
    ) {
        $rol = "Ejecutivo";
    } elseif (
        $row["r_editor"] == 1 &&
        $row["r_autorizador"] == 0 &&
        $row["r_analista"] == 0
    ) {
        $rol = "Maestro de catálogo";
    } elseif (
        $row["r_autorizador"] == 1 ||
        $row["r_analista"] == 1
    ) {
        $rol = "Manager";
    }

    $usuarios[] = [
        "id" => $row["user_id"],
        "username" => $row["user_name"],
        "rol" => $rol,
        "nombre" => trim("{$row['nombre']} {$row['s_nombre']} {$row['last_name']}"),
        "email" => $row["email"],
        "telefono" => $row["telefono"],
        "cumpleaños" => $row["cumpleaños"],
        "foto" => "https://mobilitysolutionscorp.com/Imagenes/Usuarios/{$row['user_id']}.jpg"
    ];
}

echo json_encode([
    "success" => true,
    "usuarios" => $usuarios
]);

$con->close();
?>
