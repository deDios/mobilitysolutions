
<?php
    session_start();
    
    include "db_consultas/Consultas.php";
    $op = $_REQUEST['op'];

    switch ($op){
        case 1:
            unset($_SESSION['carros']);
            $obj_metodo = include "db_consultas/Consultas.php";
            $lista_carros = $obj_metodo->listar_carros();
            $_SESSION['carros'] = $lista_carros;
            header("Location: catalogo.php");
        break;
        case 2:
        break;
    }
?>