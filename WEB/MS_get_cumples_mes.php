<?php
header('Content-Type: application/json');
include "../db/Conexion.php";

// --- zona horaria MX para que el mes sea consistente con lo que muestras en UI ---
date_default_timezone_set('America/Mexico_City');

$mesActualNum = date('m');      // "10"
$anioActual   = date('Y');      // "2025"
$mesTexto     = date('F');      // "October" en inglés
// Opcional: traducir a español rápido:
$mesesES = [
    'January' => 'Enero',
    'February' => 'Febrero',
    'March' => 'Marzo',
    'April' => 'Abril',
    'May' => 'Mayo',
    'June' => 'Junio',
    'July' => 'Julio',
    'August' => 'Agosto',
    'September' => 'Septiembre',
    'October' => 'Octubre',
    'November' => 'Noviembre',
    'December' => 'Diciembre'
];
$mesTextoES = $mesesES[$mesTexto] ?? $mesTexto;

// Si quisieras permitir override por querystring (ej: ?mes=10&anio=2025):
$mesParam  = $_GET['mes']  ?? $mesActualNum;
$anioParam = $_GET['anio'] ?? $anioActual;

// Validación básica (mes 1-12 numérico)
if (!preg_match('/^(0?[1-9]|1[0-2])$/', $mesParam)) {
    echo json_encode([
        'success' => false,
        'message' => 'Mes inválido.'
    ]);
    exit;
}

// Query: todos los usuarios con cumpleaños en ese mes
// Nota: usamos MONTH(cumpleaños)=?  y opcional activo=1 si aplica.
$query = "
    SELECT 
        user_name,
        second_name,
        last_name,
        cumpleaños
    FROM mobility_solutions.tmx_usuario
    WHERE MONTH(cumpleaños) = ?
      AND cumpleaños IS NOT NULL
      /* AND activo = 1 */ 
    ORDER BY DAY(cumpleaños) ASC
";

$stmt = $con->prepare($query);
if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Error en la preparación del query.'
    ]);
    exit;
}

$mesInt = intval($mesParam);
$stmt->bind_param("i", $mesInt);
$stmt->execute();
$result = $stmt->get_result();

$cumpleaneros = [];
while ($row = $result->fetch_assoc()) {

    // Armamos nombre completo bonito
    $nombreCompleto = trim(
        ($row['user_name'] ?? '') . ' ' .
        ($row['second_name'] ?? '') . ' ' .
        ($row['last_name'] ?? '')
    );

    // Día en 2 dígitos
    $dia = '';
    if (!empty($row['cumpleaños'])) {
        $dia = date('d', strtotime($row['cumpleaños']));
    }

    $cumpleaneros[] = [
        "nombre" => $nombreCompleto,
        "dia"    => $dia
    ];
}

$count = count($cumpleaneros);

// armamos respuesta final
echo json_encode([
    'success' => true,
    'mes' => $mesTextoES,
    'anio' => $anioParam,
    'count' => $count,
    'cumpleaneros' => $cumpleaneros
]);

$stmt->close();
$con->close();
?>
