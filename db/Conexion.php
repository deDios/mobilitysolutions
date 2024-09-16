<?php
$con = mysqli_init();
mysqli_ssl_set($con,NULL,NULL, "/Catalogo/db/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($conn, "mobilitysolutions-server.mysql.database.azure.com", "btdonyajwn", "h5n9NG>3ktmq$ph", "mobility_solutions", 3306, MYSQLI_CLIENT_SSL);
?>