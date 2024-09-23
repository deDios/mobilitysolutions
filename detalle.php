
<?php
$cod=$_REQUEST['cod'];

$inc = include "db/Conexion.php"; 
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
                    left join mobility_solutions.tmx_marca_auto as m_auto on auto.nombre = m_auto.id;
                    where auto.id = $cod';
        $result = mysqli_query($con,$query); 
        if ($result){ 
            foreach ($result as $row){
                $lista[] = $row;
            }
        }

        $nombre = $lista['nombre'];

echo $cod;
echo $nombre;

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Mobility solutions</title>
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>
    <?php
    ?>
</body>
</html>