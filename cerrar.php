<?php 
session_start();

if(isset($_SESSION['CodUsua']))
{
    /* Esto elimina todas las variables de una SESION :
      referencia de : https://www.w3schools.com/php/php_sessions.asp
      //session_unset();
    */
  session_unset();
	session_destroy(); /*TODO:Eliminará toda la SESION */
	header('location: login.php'); /* Para recargar la página y devolverle el control a login.php */
}


 ?>