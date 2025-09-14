<?php
header('Content-Type: text/plain');
ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "mobilitysolutions-server.mysql.database.azure.com";
$user = "btdonyajwn@mobilitysolutions-server";
$pass = "Llaverito_4855797'?";
$db   = "mobility_solutions";
$port = 3306;

$caPath = "/home/site/wwwroot/db/DigiCertGlobalRootG2.crt.pem"; // << aquí el bueno

echo "Existe CA? "; var_dump(file_exists($caPath), is_readable($caPath));

$con = mysqli_init();
mysqli_options($con, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
mysqli_ssl_set($con, NULL, NULL, $caPath, NULL, NULL);
mysqli_real_connect($con, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL);

$row = $con->query("SELECT VERSION() v, @@ssl_cipher c, NOW() ts")->fetch_assoc();
echo "\n✅ Conexión OK\nMySQL: {$row['v']}\nSSL: {$row['c']}\nHora: {$row['ts']}\n";
$con->close();
