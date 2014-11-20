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
        <link rel="stylesheet" type="text/css" href="styleHom.css">

        <title><?php echo $_SESSION['idusuario']?></title>
    </head>
    <body onload="killerSession()" class="stroke">
    <div style="background-image: url('fondoSSC<?php echo rand(1,16) ?>.JPG');" class="full_screen">
        <core-toolbar>
            <span flex class="stroke">Laboratorio de Matemáticas UACM Cuautepec<br>SSCUACM v2.0alpha</span>
            <span class="stroke" id="fourth_paper-fab"><?php echo $_SESSION['idusuario']?></span>
            <a href="logout.php"><paper-fab icon="clear"></paper-fab></a>
            <a href="historial.php"><paper-fab class="third_paper-fab" icon="menu"></paper-fab></a>
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
                                                                }else if($row[0] < "00:59:59"){
                                                                    echo "<span style=\"color: #00FFFF;\">$row[0] Minutos</span>";
                                                                }else if($row[0] <= "240:00:00"){
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
        <div class="center_datas">
            <center><h2>Panel de control</h2></center>
            
            <form action="" method="post">
                    <div class="divInit"><span>Registrar hora de entrada: </span><br><button  class="button_panel"  name="inicio" type="submit"<?php 
                        $inicio = "Iniciar";
                        $color = "#4285f4";
                        $conexion = mysqli_connect("localhost","root","QUORRAlegacy","sscuacm");
                        $sql = "SELECT `total_horas_globales` FROM `$user` WHERE total_horas_globales='POR CALCULAR'";
                        $resultado = mysqli_query($conexion,$sql);
                        $row = mysqli_fetch_row($resultado);
                        if($row[0] == "POR CALCULAR"){ $inicio = "Contador en ejecución"; $color="#FF8000"?> disabled style="background-color: <?php echo $color;?>;"  > <?php  echo $inicio; }
                                        else{ ?>
                                            style="background-color: <?php echo $color;?>;"  > <?php  echo $inicio; ?>
                                           <?php } ?></button></div>

                    <div class="divInit"> <span>Registrar hora de salida:</span><br><button style="background-color: #EF1726;" class="button_panel" type="submit" name="terminar">Terminar</button></div>
                    <div class="information">AVISOS DEL SISTEMA
                            <br>*<span style="color:#4285f4;">"Horas totales realizadas"</span> ira cambiando de color conforme al avance en horas y avisará cuando el contador este en ejecución.
                            <br>*Si <span style="color:#EF1726;">olvidas</span> terminar tu contador, el sistema <span style="color:#EF1726;">restará 8HRS</span> de las ya realizadas.</div>

            </form>
            <?php
                function diferencialHoras($inicio, $fin){
                    $dif=date("H:i:s", strtotime("00:00:00") + strtotime($fin) - strtotime($inicio));
                    return $dif;
                }
                function inicio($user,$horaDeEntrada,$horaDeControl){
                    $dias = array("Sábado","Domingo","Lunes","Martes","Miercoles","Jueves","Viernes");
                    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                    $conexion = mysqli_connect("localhost","root","QUORRAlegacy","sscuacm");
                                
                    if (mysqli_connect_errno()) {
                        echo "Falló la conexión con la Base de Datos MySQL: " . mysqli_connect_error();
                    }else{
                            $horaDeControl = $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ." ". date('H:i:s A',strtotime("-6 Hours"));
                            $horaDeEntrada = date('H:i:s',(strtotime("-6 Hours")));                            
                                $sql = "INSERT INTO `$user` (hora_control_sistema,hora_control_entrada, total_horas_globales)
                                VALUES ('$horaDeControl','$horaDeEntrada','POR CALCULAR')";
                                $resultado = mysqli_query($conexion,$sql);
                                    //echo " Se ha registrado correctamente la hora de entrada: '$horaDeEntrada'<br>";
                        mysqli_close($conexion);
                    }
                }
                function terminar($user){
                    $conexion = mysqli_connect("localhost","root","QUORRAlegacy","sscuacm");
                                
                    if (mysqli_connect_errno()) {
                        echo "Falló la conexión con la Base de Datos MySQL: " . mysqli_connect_error();
                    }else{
                            $horaDeSalida = date('H:i:s',(strtotime("-6 Hours")));
                                $sql = "UPDATE `$user` SET hora_control_salida='$horaDeSalida' WHERE hora_control_salida='00:00:00';";
                                $resultado = mysqli_query($conexion,$sql);
                                echo " Se ha registrado correctamente la hora de salida: $horaDeSalida.<br>";
                                
                                $recuperacionHDE = "SELECT hora_control_entrada FROM `$user` WHERE total_horas_dia='00:00:00'";
                                $resultado = mysqli_query($conexion,$recuperacionHDE);
                                $row = mysqli_fetch_array($resultado);
                                
                                $horasRealizadasDia = diferencialHoras($row['hora_control_entrada'],$horaDeSalida);
                                $sql = "UPDATE `$user` SET total_horas_dia='$horasRealizadasDia' WHERE total_horas_globales='POR CALCULAR';";
                                $resultado = mysqli_query($conexion,$sql);
                                
                                $recuperacionHG = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_horas_dia))) FROM `$user`";
                                $resultado = mysqli_query($conexion,$recuperacionHG);
                                $row = mysqli_fetch_row($resultado);
                                
                                $totalHorasGlobales = $row[0];//totalHorasGlobales($horasRealizadasDia,$row['total_horas_globales']);
                                $sql = "UPDATE `$user` SET total_horas_globales='$totalHorasGlobales' WHERE total_horas_globales='POR CALCULAR';";
                                $resultado = mysqli_query($conexion,$sql);
                                
                                //echo "El dia de hoy realizaste: " . $horasRealizadasDia . " horas.<br>";
                                //echo "Tu total de horas son: " . $totalHorasGlobales . "<br>";                       
                        mysqli_close($conexion);
                    }
                }
                if(isset($_POST['inicio'])){                    
                    inicio($user);
                    header("Location: historial.php");                    
                }
                if(isset($_POST['terminar'])){                    
                    terminar($user);
                    header("Location: historial.php");
                }
            ?>
        </div>  
        </div>
    </body>
</html>