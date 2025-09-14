<?php
// Datos de conexión (dummy)
$host = "mobilitysolutions-server.mysql.database.azure.com";
$user = "btdonyajwn@mobilitysolutions-server"; // << importante el @server
$pass = "Llaverito_4855797'?";
$db   = "mobility_solutions";
$port = 3306;

// Ruta al certificado CA (ajústala si cambió el archivo)
$caPath = "/home/site/wwwroot/db/DigiCertGlobalRootC2.crt.pem";

$con = mysqli_init();

// (opcional pero recomendado) exigir verificación de certificado
if (!mysqli_options($con, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true)) {
    die("Error: no se pudo establecer la opción de verificación SSL: " . mysqli_error($con));
}

// Cargar CA para validar al servidor
if (!mysqli_ssl_set($con, NULL, NULL, $caPath, NULL, NULL)) {
    die("Error: mysqli_ssl_set falló: " . mysqli_error($con));
}

// Conectar: el 7º parámetro es socket (NULL) y el 8º son los flags
$ok = mysqli_real_connect($con, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL);

if (!$ok) {
    die("Error de conexión (" . mysqli_connect_errno() . "): " . mysqli_connect_error());
}

// Prueba rápida y muestra del cifrado usado
$res = $con->query("SELECT VERSION() AS version, @@ssl_cipher AS cipher, NOW() AS ts");
$row = $res ? $res->fetch_assoc() : null;

echo "✅ Conexión OK\n";
if ($row) {
    echo "MySQL: " . $row['version'] . "\n";
    echo "SSL  : " . $row['cipher']  . "\n";
    echo "Hora : " . $row['ts']      . "\n";
}

mysqli_close($con);
