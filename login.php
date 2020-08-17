<?php
include_once 'modelo/modelo-login.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="css/login.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
	<script src="plugins/librerias/artyom.js"></script>
	<script src="plugins/librerias/jquery3.4.1_min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.0/annyang.min.js"></script>
	<script src="https://code.responsivevoice.org/responsivevoice.js?key=7RpgTxHY"></script>
	<script type="text/javascript" src="javascript/accesibilidad_reproducir_contenido.js"></script>
	<script src="javascript/accesibilidad_login.js"></script>
</head>
<body>
<header class="botones_lector_reproduccion">
		<h1>Lector</h1>
		<button id="boton_pausar" class="boton_lector" onclick="pausar_lector()">Pausar</button>
		<button id="boton_reanudar" class="boton_lector" onclick="reanudar_lector()">Reanudar</button>
		<button id="boton_cancelar" class="boton_lector" onclick="cancelar_lector()">Cancelar</button>	
</header>
	<div class="contenedor-form">
	<?php /*Notar que usamos los mismos estilos en login.php así lo queremos usando la misma clase referenciada tambien desde login.php así como registro.php*/ ?>
	<button id="login-sms-oculto" class="icono_reproducible" onclick="ejecutar_ayuda_login()">Ayuda</button>
	<input type="hidden" id="mensaje_login" value="<?php echo $_SESSION['mensaje'];?>">
		<h1>Login</h1>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<label for="login-usuario"><strong>Usuario:</strong></label>
			<input type="text" name="usuario" id="login-usuario" class="input-control" placeholder="<?php echo "usuario";/*Funciona exactamente que placeholder=usuario */ ?>"> 
			<label for="password-input"><strong>Password:</strong></label>
			<input type="password" name="pass" class="input-control" placeholder="Password" id="password-input">
			<input type="submit" value="Acceder" id='submit-input' name="acceder"  class="log-btn">
		</form>
		<div class="registrar">
		<?php /*Notar que usamos los mismos estilos en login.css para dar ese color verde obscuro al ícono de acceder*/ ?>
			<a id="link_a_registro" href="registro.php" class="enlace-boton">Ir a Registro</a>
		<?php /*Un link vinculable hacia registro.php en el caso de pese a estar en login, poder registrarse*/ ?>
		</div>
	</div>
</body>
</html>