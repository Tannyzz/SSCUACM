function killerSession(){                
                setTimeout(function(){

                    alert("ESTA SESION HA CADUCADO, DEBES INICIAR SESION NUEVAMENTE.");
                    window.close('home.php');
                    open('logout.php'); }, 10000);
            }
}