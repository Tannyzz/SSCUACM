<!DOCTYPE html>
<html>
<head>
    <title>SSCUACM Registro</title>
    <meta content="text/html;" http-equiv="content-type" charset="utf-8">
    <meta name="author" content="AlexPlaknava"/>
    <!--Componentes Polymer-->
    <script src="bower_components/platform/platform.js"></script>
        <link rel="import" href="bower_components/paper-input/paper-input.html">
        <link rel="import" href="bower_components/paper-button/paper-button.html">
        <link rel="import" href="bower_components/core-toolbar/core-toolbar.html">
        <link rel="import" href="bower_components/paper-fab/paper-fab.html">
	<link rel="stylesheet" type="text/css" href="inputs.css"> 

</head>
<body>
		<!--Barra superior-->
        <core-toolbar>
            <span flex style="font-family: Stoke; font-size: 22px">Social Service Counter UACM<br><span style="font-size: 15px">SSCUACM v.1.0-alpha</span></span>
            <a href="login.php"><paper-fab icon="arrow-forward"></paper-fab></a>
        </core-toolbar>
      	<!--Componentes del formulario-->
    <div class="center">
            	<h3 style="color:white; font-family: Stoke;">REGISTRO</h3>
                  <form action="registro.php" method="post">			
                        <input type="text" required="required" placeholder="Nombre(s)" name="nombre" id="n"><br>
                        <input type="text" required="required" placeholder="Apellido Paterno" name="apeP" id="ap">
                        <input type="text" required="required" placeholder="Apellido Materno" name="apeM" id="am"><br>
                        <input type="text" required="required" placeholder="Matrícula(Formato con guiones)" name="matri" id="mat">
                        <input type="email" required="required" value="@estudiate.uacm.edu.mx" name="corrInst" id="coIns"><br>
                  			    <select class="boton_select" name="carrera">
                  			        <option value="other">--- Elegir carrera ---</option>
                  			        <option value="isof">Ingeniería de software (ISOF)</option>
                  			        <option value="iset">Ingeniería en sistemas electrónicos y de telecomunicaciones (ISET)</option>
                  			        <option value="isei">Ingeniería de sistemas electrónicos industriales (ISEI)</option>
                  			        <option value="istu">Ingeniería en sistemas de transporte urbano (ISTU)</option>
          			             </select>                               
                  			<input type="text" placeholder="Otra" name="otraCarrera"><br>
                  			<input type="date" required="required" placeholder="Fecha de Nacimieto dd/mm/aaaa" name="fechNac" id="fn"><br>
                  			<input type="password" required="required" placeholder="Contraseña" name="contraseña" id="pass">
                  			<input type="password" required="required" placeholder="Repite contraseña" name="rcontraseña" id="rpass"><br>
                  			<input class="boton_registro" type="submit" value="Regístrate" style="margin-left: 160px" >                         
                  </form>
	   </div>	    
        <?php
        		//Lógica de formulario & conexion DB
                function validar_contraseña($clave,&$error_clave, $rclave){
                   if(strlen($clave) < 6){
                      $error_clave = "La clave debe tener al menos 6 caracteres.";
                      return false;
                   }
                   if(strlen($clave) > 16){
                      $error_clave = "La clave no puede tener más de 16 caracteres.";
                      return false;
                   }
                   if (!preg_match('`[a-z]`',$clave)){
                      $error_clave = "La clave debe tener al menos una letra minúscula.";
                      return false;
                   }
                   if (!preg_match('`[A-Z]`',$clave)){
                      $error_clave = "La clave debe tener al menos una letra mayúscula.";
                      return false;
                   }
                   if (!preg_match('`[0-9]`',$clave)){
                      $error_clave = "La clave debe tener al menos un caracter numérico.";
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
                                
                        $nombre = ucwords($_POST['nombre']);                          
                        $apellidop = ucwords($_POST['apeP']);
                        $apellidom = ucwords($_POST['apeM']);
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
                                
                        $conexion = mysqli_connect("localhost","root","QUORRAlegacy","ssscuacm");
                                                    
                        if (mysqli_connect_errno()) {
                              echo "<p style=\"color:#b40000\"><strong>Falló la conexion a la Base de Datos.</strong></p>";
                              
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
                                        `total_horas_globales` TIME NOT NULL,
                                        PRIMARY KEY(idcontrolUsuario)
                                        );";
                            mysqli_query($conexion,$tabla);                
                            echo "<strong>Haz sido registrado satisfactoriamente<br></strong>";
                            echo "<strong>Tu usuario es: " . "<span style=\"color:#b40000\">$user[0]</span></strong><br>";
                            mysqli_close($conexion);
                            header('Refresh:5; url=login.php');                             
                        }                            
                   }else{
                      echo "<p style=\"color:#b40000\"><strong>PASSWORD NO VÁLIDO:</strong></p> " . "$error_encontrado";
                   }
                }
        ?>
</body>
</html>