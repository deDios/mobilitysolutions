<?php

$con = mysqli_connect("mobilitysolutions-server.mysql.database.azure.com", "btdonyajwn", "h5n9NG>3ktmqph", "mobility_solutions");


/*
$con = mysqli_init();
mysqli_ssl_set($con,NULL,NULL, "/home/site/wwwroot/Catalogo/db/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($con, "mobilitysolutions-server.mysql.database.azure.com", "btdonyajwn", "h5n9NG>3ktmqph", "mobility_solutions", 3306);
if (mysqli_connect_errno()){
        die('Error: Falla en la conexion de MySQL'. mysqli_connect_errno());
    }
*/

/*
$con = mysqli_init();
mysqli_ssl_set($con,NULL,NULL, "/home/site/wwwroot/Catalogo/db/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($con, "mobilitysolutions-server.mysql.database.azure.com", "btdonyajwn", "h5n9NG>3ktmqph", "mobility_solutions", 3306, MYSQLI_CLIENT_SSL);
*/
?>