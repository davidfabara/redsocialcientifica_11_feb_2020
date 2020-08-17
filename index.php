<?php
include_once 'modelo/modelo-index.php'; 

 ?>
<?PHP 
	if(limpiar($_SESSION['discapacidad']) == limpiar('Discapacidad moderada') or limpiar($_SESSION['discapacidad']) == limpiar('Discapacidad grave o ceguera') or ($_SESSION['discapacidad'])== limpiar('Sin discapacidad')):
?>
<?php /* Solo si el usuario es una persona con discapacidad se cargara la hoja de estilo de style.css , pero al ser universal se puede compartir permisos */ 
?>
	 <link rel="stylesheet" href="css/style.css">
<?php endif;?>
<?PHP 
	if(limpiar($_SESSION['discapacidad']) == limpiar('Protección de la vista')):
?>
     <link rel="stylesheet" href="css/proteccion_vista.css">
<?php endif;?>
<?PHP 
	 if(limpiar($_SESSION['discapacidad']) == limpiar('Discapacidad moderada') or limpiar($_SESSION['discapacidad']) == limpiar('Discapacidad grave o ciega')):
?>
<?php endif;
?>
 <!DOCTYPE html>
 <html lang="es">
 <head>
 	<meta charset="UTF-8">
 	<title>Index</title>
	<script type="text/javascript" src="javascript/mostrar_contenido.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.0/annyang.min.js"></script>

	<script src="plugins/librerias/artyom.js"></script>
	<script type="text/javascript" src="javascript/accesibilidad_reproducir_contenido.js"></script>
 </head>
 <body>
</body>
</html>