<html>
<head>
   <title>Validar Password</title>
</head>

<body>
<?php

function validar_clave($clave,&$error_clave){
   if(strlen($clave) < 6){
      $error_clave = "La clave debe tener al menos 6 caracteres";
      return false;
   }
   if(strlen($clave) > 16){
      $error_clave = "La clave no puede tener más de 16 caracteres";
      return false;
   }
   if (!preg_match('`[a-z]`',$clave)){
      $error_clave = "La clave debe tener al menos una letra minúscula";
      return false;
   }
   if (!preg_match('`[A-Z]`',$clave)){
      $error_clave = "La clave debe tener al menos una letra mayúscula";
      return false;
   }
   if (!preg_match('`[0-9]`',$clave)){
      $error_clave = "La clave debe tener al menos un caracter numérico";
      return false;
   }
   $error_clave = "";
   return true;
} 

if ($_POST){
   $error_encontrado="";
   if (validar_clave($_POST["clave"], $error_encontrado)){
      echo "PASSWORD VÁLIDO";
   }else{
      echo "PASSWORD NO VÁLIDO: " . $error_encontrado;
   }
}

?>
<P>
<form action="validar-password.php" method="post">
Escribe una clave:
<input type=password name="clave">
<input type="submit" value="Enviar">
</form>

</body>
</html>