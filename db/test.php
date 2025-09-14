<?php
header('Content-Type: text/plain');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Para que mysqli lance excepciones y podamos ver la causa real
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "mobilitysolutions-server.mysql.database.azure.com";
$user = "btdonyajwn@mobilitysolutions-server"; // OJO: user@server
$pass = "Llaverito_4855797'?";                 // Dummy
$db   = "mobility_solutions";
$port = 3306;
$caPath = "/home/site/wwwroot/db/DigiCertGlobalRootC2.crt.pem";

try {
    if (!file_exists($caPath) || !is_readable($caPath)) {
        echo "Aviso: CA no legible o no existe: $caPath\n";
    }

    $con = mysqli_init();

    // Si tu runtime no tiene esta constante, el diagnóstico de arriba lo mostrará.
    // Puedes comentar la línea siguiente si fuera "UNDEFINED".
    mysqli_options($con, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);

    // Cargar la CA (si no existe, igual probamos; el connect fallará con error SSL claro)
    mysqli_ssl_set($con, NULL, NULL, $caPath, NULL, NULL);

    // ¡OJO! socket = NULL (7º parámetro), flags = MYSQLI_CLIENT_SSL (8º)
    mysqli_real_connect($con, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL);

    // Prueba rápida
    $res = $con->query("SELECT VERSION() AS version, @@ssl_cipher AS cipher, NOW() AS ts");
    $row = $res->fetch_assoc();

    echo "✅ Conexión OK\n";
    echo "MySQL: " . $row['version'] . "\n";
    echo "SSL  : " . $row['cipher']  . "\n";
    echo "Hora : " . $row['ts']      . "\n";

    $con->close();

} catch (Throwable $e) {
    http_response_code(500);
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    // Mensajes comunes y cómo corregirlos rápidamente:
    // - "Access denied for user": verifica user con sufijo @mobilitysolutions-server y el password
    // - "SSL: CA certificate": confirma ruta/CA correcta; si cambiaron a DigiCert G2, usa ese .pem
    // - "Can't connect to MySQL server": revisa firewall/red del servidor MySQL (IP de salida del App Service)
}
