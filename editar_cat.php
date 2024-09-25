<?php
$cod=$_REQUEST['id'];

?>

<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar catálogo</title>
    <link rel="stylesheet" href="CSS/editar_cat.css">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
    <header>
        <a href="index.php" class="logo" title="Home">
            <img src="logo_MSC.png" alt="Logo de la compañia">
            <h2 class="Nombre de la empresa">
                Mobility Solutions Corporation
            </h2>
        </a>
        <nav>
            <a href="index.php" class="nav-link" title="Home">Inicio</a>
            <a href="catalogo.php" class="nav-link" title="Home">Catálogo</a>
            <a href="" class="nav-link">Cotizador</a>
            <a href="" class="nav-link">Sobre nosotros</a>
            <a href="" class="nav-link">Contacto</a>
        </nav>
    </header>

    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="mytable">
        <thead>
            <tr>
                <th>#</th>
                <th>Título</th>
                <th>Publicado</th>
                <th>Vencimiento</th>
                <th>Estado</th>
                <th>Visitas Únicas</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <td>
                <tr>1</tr>
                <tr>Título1</tr>
                <tr>2018-08-20</tr>
                <tr>2018-09-20</tr>
                <tr>Activa</tr>
                <tr>6</tr>
                <td><a href="htt://sitioweb.com/a"><button class="btn btn-info">Editar</button></a></td>
                <td><button class="btn btn-danger eliminar"  id="785">Eliminar</button> </td>
            </td>
            <td>
                <tr>2</tr>
                <tr>Título2</tr>
                <tr>2018-08-22</tr>
                <tr>2018-09-23</tr>
                <tr>Activa</tr>
                <tr>5</tr>
                <td><a href="htt://sitioweb.com/a"><button class="btn btn-info">Editar</button></a></td>
                <td><button class="btn btn-danger eliminar"  id="786">Eliminar</button> </td>
            </td>
        </tbody>
    </table>
</body>
</html>