<?php

// Inicializar conexión con MySQL usando mysqli
$con = mysqli_init();

// Configuración de SSL para la conexión
mysqli_ssl_set($con, NULL, NULL, "/home/site/wwwroot/db/DigiCertGlobalRootCA.crt.pem", NULL, NULL);

// Establecer la conexión con la base de datos
mysqli_real_connect($con, "mobilitysolutions-server.mysql.database.azure.com", "btdonyajwn", "Llaverito_4855797'?", "mobility_solutions", 3306, MYSQLI_CLIENT_SSL);

// Verificar si hubo un error en la conexión
if (mysqli_connect_errno()) {
    die('Error: Falla en la conexión de MySQL. ' . mysqli_connect_error());
}

// Si la conexión es exitosa, retornar el objeto de conexión
return $con;
?>
