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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"></script>
    <script src="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.css"></script>
    
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
    <div class="container">
        <div>
            <br>
            <h1>Registros Catálogo</h1>
            <br>
            <button class="btn btn-primary">Agregar</button>
        </div>
        <div class="container_tab">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="mytable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>marca</th>
                        <th>nombre</th>
                        <th>modelo</th>
                        <th>mensualidad</th>
                        <th>costo</th>
                        <th>sucursal</th>
                        <th>color</th>
                        <th>transmision</th>
                        <th>interior</th>
                        <th>kilometraje</th>
                        <th>combustible</th>
                        <th>cilindros</th>
                        <th>eje</th>
                        <th>estatus</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $inc = include "db/Conexion.php";    
                    if ($inc){
                        $query = '  select 
                                        auto.id,
                                        m_auto.auto as nombre, 
                                        modelo.nombre as modelo, 
                                        marca.nombre as marca, 
                                        auto.mensualidad, 
                                        auto.costo, 
                                        sucursal.nombre as sucursal, 
                                        auto.img1, 
                                        auto.img2, 
                                        auto.img3, 
                                        auto.img4, 
                                        auto.img5, 
                                        auto.img6, 
                                        auto.color, 
                                        auto.transmision, 
                                        auto.interior, 
                                        auto.kilometraje, 
                                        auto.combustible, 
                                        auto.cilindros, 
                                        auto.eje, 
                                        auto.estatus, 
                                        auto.created_at, 
                                        auto.updated_at 
                                    FROM mobility_solutions.tmx_auto as auto
                                    left join mobility_solutions.tmx_sucursal as sucursal on auto.sucursal = sucursal.id 
                                    left join mobility_solutions.tmx_estatus as estatus on auto.estatus = estatus.id
                                    left join mobility_solutions.tmx_modelo as modelo on auto.modelo = modelo.id 
                                    left join mobility_solutions.tmx_marca as marca on auto.marca = marca.id
                                    left join mobility_solutions.tmx_marca_auto as m_auto on auto.nombre = m_auto.id;';
                        $result = mysqli_query($con,$query);  
                        if ($result){         
                            while($row = mysqli_fetch_assoc($result)){
                                $id = $row['id'];
                                $nombre = $row['nombre'];
                                $modelo = $row['modelo'];
                                $marca = $row['marca'];
                                $mensualidad = $row['mensualidad'];
                                $costo = $row['costo'];
                                $sucursal = $row['sucursal'];
                                $color = $row['color'];
                                $interior = $row['interior'];
                                $combustible = $row['combustible'];
                                $cilindros = $row['cilindros'];
                                $transmision = $row['transmision'];
                                $kilometraje = $row['kilometraje'];
                                $eje = $row['eje'];
                                $estatus = $row['estatus'];
                                $created_at = $row['created_at'];
                                $updated_at = $row['updated_at'];
                ?> 
                    <tr>
                        <th class=""><?php echo $id;?></th>
                        <td><?php echo $marca;?></td>
                        <td><?php echo $nombre;?></td>
                        <td><?php echo $modelo;?></td>
                        <td><?php echo "$" . number_format($mensualidad);?></td>
                        <td><?php echo "$" . number_format($costo);?></td>
                        <td><?php echo $sucursal;?></td>
                        <td><?php echo $color;?></td>
                        <td><?php echo $transmision;?></td>
                        <td><?php echo $interior;?></td>
                        <td><?php echo number_format($kilometraje) . " km";?></td>
                        <td><?php echo $combustible;?></td>
                        <td><?php echo $cilindros;?></td>
                        <td><?php echo $eje;?></td>
                        <td><?php echo $estatus;?></td>
                        <td><?php echo $created_at;?></td>
                        <td><?php echo $updated_at;?></td>
                        <td><button class="btn btn-warning">Editar</button></td>
                        <td><button class="btn btn-danger">Eliminar</button> </td>
                    </tr>
                <?php
                            }
                        } else{
                            echo "Hubo un error en la consulta";
                        }
                        mysqli_free_result($result);                  
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>

<script>
    new DataTable('mytable');
</script>

</body>
</html>