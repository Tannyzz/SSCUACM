<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SSC UACM Login</title>
        <meta content="text/html;" http-equiv="content-type" charset="utf-8">
        <meta name="author" content="AlexPlaknava"/>

        <link rel="icon" type="image/png" href="iconssc.png" />
        <link rel="stylesheet" type="text/css" href="style.css">

        <script src="bower_components/platform/platform.js"></script>

        <link rel="import" href="bower_components/core-toolbar/core-toolbar.html">
        <link rel="import" href="bower_components/paper-fab/paper-fab.html">
        <link rel="import" href="bower_components/core-icons/core-icons.html">

        <link href='http://fonts.googleapis.com/css?family=Stoke:300,400' rel='stylesheet' type='text/css'>

    </head>
    <body>
    <div style="background-image: url('fondoSSC<?php echo rand(1,16) ?>.JPG');" class="full_screen">
     <core-toolbar>
            <span flex class="stroke">Laboratorio de Matemáticas UACM Cuautepec<br>SSCUACM v2.0alpha</span>
            <a href="registro.php"><paper-fab icon="add"></paper-fab></a>
            <div class="second_paper_fab">SSCUACM 2015-ISOF. Laboratorio de Matemáticas<br>UACM Campus Cuautepec</div>
        </core-toolbar>     
        
        <div class="log">
            <center>
                <h1 class="stroke">Social Service Counter UACM</h1>
                <form action="login.php" method="post">
                    <input class="input_log" type="text" autocomplete="off" required="required" placeholder="Usuario" name="user" id="user"><br>
                    <input class="input_log" type="password" required="required" placeholder="Contraseña" name="pass" id="passLog"><br>
                    <input class="button" type="submit" value="Iniciar sesión" name="log">
                </form>
                <?php
                function verificar_loggeo($user, $pass, &$recuperado){
                    $conexion = mysqli_connect("localhost","root","QUORRAlegacy","sscuacm");
                    $sql = "SELECT * FROM usuarios WHERE usuario='$user' AND contrasenia='$pass'";
                    $recuperado = mysqli_query($conexion,$sql);
                    $count = 0;
                    while($row = mysqli_fetch_object($recuperado)){
                        $count++;
                        $recuperado = $row;
                    }
                    if($count == 1){
                        return 1;
                    }
                    else{
                        return 0;
                    }
                }
                if(!isset($_SESSION['idusuario'])){
                    if(isset($_POST['log'])){
                        if(verificar_loggeo($_POST['user'],$_POST['pass'],$recuperado) == 1){
                            $_SESSION['idusuario'] = $recuperado->usuario;
                            header("Location: home.php");
                        }
                         else{ ?>
                                <span class="stroke_inver">USUARIO O CONTRASEÑA INCORRECTOS,<br>INTENTALO NUEVAMENTE.</span>
                       <?php }
                    }
                }                
                           ?>
            </center>            
        </div>
    </div>            
    </body>    
</html>