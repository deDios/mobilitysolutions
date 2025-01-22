<?php

    session_start();
    session_destroy();
    header("Location: https://mobilitysolutionscorp.com/views/login.php", TRUE, 301);
    die();

?>