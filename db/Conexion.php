<?php
$con = mysqli_init();
mysqli_ssl_set($con,NULL,NULL, "/home/Catalogo/db/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($con, "mobilitysolutions-server.mysql.database.azure.com", "btdonyajwn", "h5n9NG>3ktmqph", "mobility_solutions", 3306, MYSQLI_CLIENT_SSL)
or die ('Error: '. mysqli_error($con));


?>