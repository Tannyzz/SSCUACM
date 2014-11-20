<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html;" http-equiv="content-type" charset="utf-8">
        <meta name="author" content="AlexPlaknava"/>
        <title><?php echo $_SESSION['idusuario']?></title>
    </head>
    <body>
        <div>
            <h1>Social Service Counter UACM</h1>
            <a href="logout.php">Cerrar sesión</a>
        </div><br>
        <div>
                <?php
                $user = $_SESSION['idusuario'];
                $conexion = mysqli_connect("localhost","root","QUORRAlegacy","sscuacm");
                                
                                if (mysqli_connect_errno()) {
                                  echo "Falló la conexión con la Base de Datos MySQL: " . mysqli_connect_error();
                                }else{                                
                                $result = mysqli_query($conexion,"SELECT * FROM datos_usuario WHERE usuario='$user'");
                
                                        while($row = mysqli_fetch_array($result)){ ?>
                                            
                                            <div><strong><span style="color: #b40000; font-size: 20px">Nombre: </span></strong> <?php echo $row['nombre'] . " " . $row['apellidoP'] . " " . $row['apellidoM']?></div><br>
                                            <div><strong><span style="color: #b40000; font-size: 20px">Carrera: </span></strong><?php echo $row['carrera']?></div><br>
                                            <div><strong><span style="color: #b40000; font-size: 20px">Matricula: </span></strong><?php echo $row['matricula']?> </div><br>
                                            <div><strong><span style="color: #b40000; font-size: 20px">Correo Institucional: </span></strong><?php echo $row['correo']?></div><br>
                            
                                  <?php }
                                }?>
          </div>
        <center>
            <div>
                <h2>Contador de horas diarias</h2>
                    <form action="contador.php" method="post">
                        Registrar hora de entrada: <button onclick="inicio()">Iniciar</button>
                        Registrar hora de salida: <button onclick="terminar()">Terminar</button>                       
                    </form>
            </div><br>
            <div>
                <?php
                        $horaDeControl = date('l jS \of F Y h:i:s A');
                        $sql = "INSERT INTO `$user` (horaControlSistema) VALUES ('$horaDeEntrada')";
                        $resultado = mysqli_query($conexion,$sql);
                        $idFila = $resultado->idcontrolUsuario;
                
                if(isset($_POST['hde'])){
                        $horaDeEntrada = date('h:i:s');
                            $sql = "INSERT INTO `$user` (hora_control_entrada) VALUES ('$horaDeEntrada') WHERE idcontrolUsuario='$idFila'";
                            mysqli_query($conexion,$sql);
                        }if(isset($_POST['hds'])){
                            $horaDeSalida = date('h:i:s');
                            $sql = "INSERT INTO `$user` (hora_control_salida) VALUES ('$horaDeSalida') WHERE idcontrolUsuario='$idFila'";
                            mysqli_query($conexion,$sql);
                        }
                            
                            ?>
                <table style="width:100%">
                	<tr>
	                	<th>Fecha de control</th>
	                	<th>Hora de entrada</th>
	                	<th>Hora de salida</th>
	                	<th>Diferencial de tiempo</th>
                	</tr>
                	<tr>
                		<td><center><span style="color:#b40000"><?php echo $horaDeControl?></span></center></td>
                		<td><center><span><?php echo $horaDeEntrada?></span></center></td>
                		<td><center><span><?php echo $horaDeSalida?></span></center></td>
                		<td></td>
                	</tr>
                </table>
            </div>     
        </center>
    </body>
</html>