<?php
$host = "mobilitysolutions-server.mysql.database.azure.com";
$user = "btdonyajwn";                     // sin @server
$pass = "TuPassFuerte!2025";             // actualízalo
$db   = "mobility_solutions";
$port = 3306;
$caPath = "/home/site/wwwroot/db/DigiCertGlobalRootG2.crt.pem";

$con = mysqli_init();
mysqli_options($con, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
mysqli_ssl_set($con, NULL, NULL, $caPath, NULL, NULL);
mysqli_real_connect($con, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL);

if (mysqli_connect_errno()){
    die('Error: Falla en la conexión de MySQL: ' . mysqli_connect_error());
}
?>
