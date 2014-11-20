<!DOCTYPE html>
<html>
<head>
    <title>SSCUACM Registro</title>
    <meta content="text/html;" http-equiv="content-type" charset="utf-8">
    <meta name="author" content="AlexPlaknava"/>
    
    <link rel="stylesheet" type="text/css" href="styleReg.css">
    <link rel="icon" type="image/png" href="iconssc.png" />

        <script src="bower_components/platform/platform.js"></script>

        <link rel="import" href="bower_components/core-toolbar/core-toolbar.html">
        <link rel="import" href="bower_components/paper-fab/paper-fab.html">
        <link rel="import" href="bower_components/core-icons/core-icons.html">

        <link href='http://fonts.googleapis.com/css?family=Stoke:300,400' rel='stylesheet' type='text/css'>


</head>
<body>
<div style="background-image: url('fondoSSC<?php echo rand(1,16) ?>.JPG');" class="full_screen">
   <core-toolbar>
            <span flex class="stroke" >Laboratorio de Matemáticas UACM Cuautepec<br>SSCUACM v2.0alpha</span>
            <a href="login.php"><paper-fab icon="arrow-forward"></paper-fab></a>
            <div class="second_paper_fab">SSCUACM 2015-ISOF. Laboratorio de<br>MatemáticasUACM Campus Cuautepec</div>
        </core-toolbar>
        <div class="reg">
              <center>
                <h2 class="stroke">Social Service Counter UACM<br>REGISTRO</h2>
                        <form action="registro.php" method="post">
                            <input type="text" required="required" placeholder="Nombre(s)" autocomplete="off" name="nombre" id="n"><br>
                            <input class="input_doble" type="text" required="required" placeholder="Apellido Paterno" autocomplete="off" name="apeP" id="ap">
                            <input class="input_doble" type="text" required="required" placeholder="Apellido Materno" autocomplete="off" name="apeM" id="am"><br>
                            <input class="input_doble" type="text" required="required" placeholder="Matrícula" autocomplete="off" name="matri" id="mat">
                            <input class="input_doble" type="email" required="required" value="@estudiate.uacm.edu.mx" name="corrInst" id="coIns"><br>
                                <select class="div_engineerings" name="carrera">
                                    <option value="other">--- Elegir carrera ---</option>
                                    <option value="isof">Ingeniería de software (ISOF)</option>
                                    <option value="iset">Ingeniería en sistemas electrónicos y de telecomunicaciones (ISET)</option>
                                    <option value="isei">Ingeniería de sistemas electrónicos industriales (ISEI)</option>
                                    <option value="istu">Ingeniería en sistemas de transporte urbano (ISTU)</option>
                                </select>
                            <input class="input_doble" type="text" placeholder="Otra" autocomplete="off" name="otraCarrera"><br>    
                            <input type="date" required="required" name="fechNac" id="fn"><br>
                            <input class="input_doble" type="password" required="required" placeholder="Contraseña" name="contraseña" id="pass">
                            <input class="input_doble" type="password" required="required" placeholder="Repite contraseña" name="rcontraseña" id="rpass"><br>            
                            <input class="button_reg"type="submit" value="Regístrate">                            
                                
                        </form>
              </center>
              <?php

                function validar_contraseña($clave,&$error_clave, $rclave){
                   if(strlen($clave) < 6){
                      $error_clave = "La clave debe tener al menos 6 caracteres.";
                      return false;
                   }
                   if(strlen($clave) > 16){
                      $error_clave = "La clave no puede tener más de 16 caracteres.";
                      return false;
                   }
                   if ($clave <> $rclave){
                      $error_clave = "La contraseña no coinciden, intentalo nuevamente.";
                      return false;
                   }
                   $error_clave = "";
                   return true;
                } 
                
                if ($_POST){
                   $error_encontrado="";
                      
                   if (validar_contraseña($_POST["contraseña"], $error_encontrado, $_POST["rcontraseña"])){                                      
                                
                        $nombre = $_POST['nombre'];                          
                        $apellidop = $_POST['apeP'];
                        $apellidom = $_POST['apeM'];
                        $matricula = $_POST['matri'];
                        $correo = $_POST['corrInst'];
                        $nacimiento = $_POST['fechNac'];
                        $user = explode('@',$correo);
                        $contraseña = $_POST['contraseña'];
                                              
                        if($_POST['carrera'] == 'other'){
                            $carrera = $_POST['otraCarrera'];
                        }elseif($_POST['carrera'] == 'isof'){
                            $carrera = "Ingenieria de software";
                        }elseif($_POST['carrera'] == 'iset'){
                            $carrera = "Ingenieria en sistemas electronicos y de telecomunicaciones";
                        }elseif($_POST['carrera'] == 'isei'){
                            $carrera = "Ingenieria en sistemas electronicos industriales";
                        }elseif($_POST['carrera'] == 'istu'){
                            $carrera = "Ingenieria en sistemas de tranporte urbano";
                        }         
                                
                        $conexion = mysqli_connect("localhost","root","QUORRAlegacy","sscuacm");
                                                    
                        if (mysqli_connect_errno()) {
                              echo "<center><p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p></center>";
                              
                        }else{
                            $sql = "INSERT INTO datos_usuario
                                    (nombre, apellidoP, apellidoM, matricula, correo, carrera, fechaNacimiento, usuario, contrasenia)
                                    VALUES ('$nombre','$apellidop','$apellidom','$matricula','$correo','$carrera','$nacimiento','$user[0]','$contraseña')";
                            
                            mysqli_query($conexion,$sql);
                            
                            $usuario = "INSERT INTO usuarios
                                    (usuario, contrasenia) VALUES ('$user[0]','$contraseña') ";
                            mysqli_query($conexion,$usuario);
                                    
                            $tabla = "CREATE TABLE `$user[0]` (
                                        `idcontrolUsuario` INT(10) NOT NULL AUTO_INCREMENT,
                                        `hora_control_sistema` VARCHAR(70) NOT NULL,
                                        `hora_control_entrada` TIME NOT NULL,
                                        `hora_control_salida` TIME NOT NULL,
                                        `total_horas_dia` TIME NOT NULL,
                                        `total_horas_globales` VARCHAR(15) NOT NULL,
                                        PRIMARY KEY(idcontrolUsuario)
                                        );";
                            mysqli_query($conexion,$tabla);                
                            mysqli_close($conexion); ?>
                              <script type="text/javascript">
                                  alert("Tu usuario para ingresar al sistema SSCUACM es: <?php echo $user[0] ?> ");
                                  location.href = "login.php";
                              </script>
                            <?php 
                        }
                            
                   }else{ ?>
                       <script languaje="javascript">
                            alert("Contraseña NO VALIDA = <?php echo $error_encontrado ?>");
                            location.href = "login.php";
                       </script>";
               <?php    }
                }
        ?>
        </div>
        </div>
</body>
</html>