<?php

$con = mysqli_init();
mysqli_ssl_set($con,NULL,NULL, "/site/wwwroot/db/DigiCertGlobalRootC2.crt.pem", NULL, NULL);
mysqli_real_connect($con, "mobilitysolutions-server.mysql.database.azure.com", "btdonyajwn", "Llaverito_4855797'?", "mobility_solutions", 3306, MYSQLI_CLIENT_SSL);
if (mysqli_connect_errno()){
    die('Error: Falla en la conexion de MySQL'. mysqli_connect_errno());
}


?>