<?php 
                $inc = include "../db/Conexion.php";    
                    if ($inc){
                        $query = '
                                select 
                                    DATE(DATE_SUB(created_at, INTERVAL 6 HOUR)) as fecha, 
                                    count(*) as numero_cargas
                                from mobility_solutions.tmx_auto
                                where DATE(DATE_SUB(created_at, INTERVAL 6 HOUR)) > DATE(DATE_SUB(current_date(), INTERVAL 10 DAY))
                                group by DATE(DATE_SUB(created_at, INTERVAL 6 HOUR));';
                        $result = mysqli_query($con,$query);  
                        if ($result){    
                            $data_points = array();     
                            while($row = mysqli_fetch_assoc($result)){
                                $point = array("valorx" => $row['fecha'], "valory" => $row['numero_cargas']);
                                array_push($data_points, $point);
                            }
                            echo json_encode($data_points);
                        } else{
                            echo "Hubo un error en la consulta";
                        }
                        mysqli_free_result($result);                  
                    }
    ?>