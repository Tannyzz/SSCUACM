 <?php
     $nombre = $_REQUEST['nombre'];                          
      $apellidop = $_REQUEST['apeP'];
      $apellidom = $_REQUEST['apeM'];
      $matricula = $_REQUEST['matri'];
      $correo = $_REQUEST['corInst'];
      $nacimiento = $_REQUEST['fechNac'];
      $user = explode('@',$correo);
      $contraseña = $_REQUEST['contraseña'];
                            
            if($_REQUEST['carrera'] == 'other'){
                $carrera = $_REQUEST['otraCarrera'];
            }elseif($_REQUEST['carrera'] == 'isof'){
                $carrera = "Ingenieria de software";
            }elseif($_REQUEST['carrera'] == 'iset'){
                $carrera = "Ingenieria en sistemas electronicos y de telecomunicaciones";
            }elseif($_REQUEST['carrera'] == 'isei'){
                $carrera = "Ingenieria en sistemas electronicos industriales";
            }elseif($_REQUEST['carrera'] == 'istu'){
                $carrera = "Ingenieria en sistemas de tranporte urbano";
            }                   
                                
            $con = mysqli_connect("localhost","root","QUORRAlegacy","sscuacm");
                                        
            if (mysqli_connect_errno()) {
                  echo "Falló la conexion a la DB" . mysqli_connect_error();
            }else{                      
                mysqli_query($con,"INSERT INTO datos_usuario (nombre, apellidoP, apellidoM, matricula, correo, carrera, fechaNacimiento, usuario, contraseña)
                                   VALUES ('$nombre','$apellidop','$apellidom','$matricula','$correo','$carrera','$nacimiento','$user[0]','$contraseña')");
                mysqli_close($con);
            }
?>