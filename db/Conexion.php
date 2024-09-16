<?php
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL, "/Catalogo/db/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($conn, "mobilitysolutions-server.mysql.database.azure.com", "btdonyajwn", "h5n9NG>3ktmqph", "mobility_solutions", 3306, MYSQLI_CLIENT_SSL);
?>