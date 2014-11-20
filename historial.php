<?php
session_start();
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta content="text/html;" http-equiv="content-type" charset="utf-8">
            <meta name="author" content="AlexPlaknava"/>

            <link rel="icon" type="image/png" href="iconssc.png" />

            <script type="text/javascript" src="inactivity.js"></script>
            <script src="bower_components/platform/platform.js"></script>

            <link rel="import" href="bower_components/core-toolbar/core-toolbar.html">
            <link rel="import" href="bower_components/paper-fab/paper-fab.html">
            <link rel="import" href="bower_components/core-icons/core-icons.html">

        <link href='http://fonts.googleapis.com/css?family=Stoke:300,400' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="styleHis.css">

            <title><?php echo $_SESSION['idusuario']?></title>
            
            <style>
                table, th, td {
                    border: 1px solid black;
                    border-collapse: collapse;
                    height: 30px;
                }
            </style>
        </head>
        <body style="background-color:black;" class="stroke">
        <a name="inicio"></a>
        <div class="full_screen">
            <core-toolbar>
                <span flex>Laboratorio de Matemáticas UACM Cuautepec<br>SSCUACM v2.0alpha</span>
                <span class="stroke" id="fourth_paper-fab"><?php echo $_SESSION['idusuario']?></span>
                <a href="logout.php"><paper-fab icon="clear"></paper-fab></a>
                <a href="home.php"><paper-fab class="back_paper-fab" icon="reply"></paper-fab></a>
            </core-toolbar>
        
                <?php
                $user = $_SESSION['idusuario'];
                $conexion = mysqli_connect("localhost","root","QUORRAlegacy","sscuacm");
                                
                                if (mysqli_connect_errno()) {
                                  echo "Falló la conexión con la Base de Datos MySQL: " . mysqli_connect_error();
                                }else{                                
                                $result = mysqli_query($conexion,"SELECT * FROM datos_usuario WHERE usuario='$user'");
                
                                        while($row = mysqli_fetch_array($result)){ ?>
                                            
                                            <div class="center_datas">
                                                <div><strong><span>Nombre: </span></strong> <?php echo $row['nombre'] . " " . $row['apellidoP'] . " " . $row['apellidoM']?></div><br>
                                                <div><strong><span>Carrera: </span></strong><?php echo $row['carrera']?></div><br>
                                                <div><strong><span>Matrícula: </span></strong><?php echo $row['matricula']?> </div><br>
                                                <div><strong><span>Correo Institucional: </span></strong><?php echo $row['correo']?></div><br>
                                                <div><strong><span>Horas totales realizadas: </span></strong> <?php 
                                                                $result = mysqli_query($conexion,"SELECT MAX(total_horas_globales) FROM `$user`");
                                                                $row = mysqli_fetch_row($result);
                                                                if($row[0] == "POR CALCULAR"){
                                                                     echo "<span style=\"color:#FA5858;\">$row[0]</span>";
                                                                }else if($row[0] <= "00:59:59"){
                                                                    echo "<span style=\"color: #00FFFF;\">$row[0] Minutos</span>";
                                                                }else if($row[0] > "00:59:59" and $row[0] <= "240:00:00"){
                                                                    echo "<span style=\"color: #00FFFF;\">$row[0] Horas</span>";
                                                                }else if($row[0] > "240:00:00" and $row[0] < "460:00:00"){
                                                                    echo "<span style=\"color: #FFFF00;\">$row[0] Horas</span>";
                                                                }else if($row[0] >= "460:00:00" and $row[0] < "480:00:00"){
                                                                    echo "<span style=\"color: #00FF00;\">$row[0] Horas - POR FINALIZAR SERVICIO</span>";
                                                                }else if($row[0] >= "480:00:00"){
                                                                    echo "<span style=\"color: #00FF00;\">$row[0] Horas <span style=\"color:4FFF03; font-size:18px;\"><strong>SERVICIO SOCIAL COMPLETADO</strong></span></span>";
                                                                }
                                                                ?> </div><br>
                                            </div>
                            
                                  <?php }
                                }?>        
                    <center>
                        <h2> Social Service Counter UACM - SSCUACM</h2>
                        <h3>Historial global de usuario: <?php echo "<strong><span style=\"color:#00FF00\">$user</span></strong>"?></h3>
                        <a href="#final"><h4>Ir al final de la tabla</h4></a>
                    <table style="width:100%;">
                        <tr class="head_table">
                            <th>Fecha de control de sistema</th>
                            <th>Hora inicial de servicio diario</th>
                            <th>Hora final de servicio diario</th>
                            <th>Horas totales por jornada</th>
                            <th>Horas globales realizadas</th>
                        </tr>
                        <tr>
                            <?php
                                $con=mysqli_connect("localhost","root","QUORRAlegacy","sscuacm");                        
                                if (mysqli_connect_errno()) {
                                  echo "Falló la conexión con la Base de Datos MySQL: " . mysqli_connect_error();
                                }                        
                                $result = mysqli_query($con,"SELECT * FROM `$user`");
                
                                while($row = mysqli_fetch_array($result)) {
                            ?>
                            <td><center><?php echo $row['hora_control_sistema'] ?></center></td>
                            <td><center><?php echo $row['hora_control_entrada'] ?></center></td>
                            <td><center><?php echo $row['hora_control_salida'] ?></center></td>
                            <td><center><?php echo $row['total_horas_dia'] ?></center></td>
                            <td><center><?php echo $row['total_horas_globales'] ?></center></td>
                        </tr>
                        <?php } ?>
                    </table>      
                    <a href="#inicio" name="final"><h4>Ir al inicio de la tabla</h4></a>      
                    </center> 
        </div> 
           
        </body>
    </html>