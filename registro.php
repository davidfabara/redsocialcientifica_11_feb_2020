<?php

require('funciones.php');
require('clases/clases.php');

if(isset($_SESSION['mensaje'])){
}else{
	$_SESSION['mensaje']='';
}

$error = "";
if(isset($_POST['registrar']))
{
	$pass = hash('sha512', $_POST['pass']); /* La función hash sirve para encriptar un valor pasado como argumento en este caso la contraseña pass , el primer parámetro es el algoritmo sha512, convierte el argumento pasado en un string de 128 caracteres*/
	$captcha=$_POST['captcha'];
	$respCaptcha=comprobar_captcha($captcha);
	$datos= array( //se inicializa la variable datos como un array de los datos de entrada del formulario
			$_POST['nombre'],
			$_POST['usuario'],
			$pass, // recordar que pass se cifró con hash
			$_POST['pais'],
			$_POST['profe'],
			$_POST['discapacidad']
		);
	
	if(datos_vacios($datos) == false)
	{
	
		if(!strpos($datos[1], " ")) /*strpos, permite saber si un carácter como argumento esta presente dentro de algun string dado , $datos[1] implica a el usuario  y queremos controlar que no tenga espacios en blanco  con el argumento " " por ello !strpos */
		{
			if(empty(usuarios::verificar($datos[1]))) /* Se envía $_POST['usuario'] a la función verificar de la clase usuarios para verificar si existe o no el ususario*/
			{
				if(comprobar_captcha($captcha)===false){
					/* 					echo "<audio id='mensaje_desde_registro' overflow:hidden src='img/registro_exito.mp3' visibility:hidden autoplay></audio>";
					sleep(3); */

					$_SESSION['mensaje'] = 'Debe responder a la clave proporcionada para el captcha';


					
				}else{
					if(comprobar_captcha($captcha)===true){
						usuarios::registrar($datos); /*llamamos a la función registrar que esta dentro de la clase usuarios */
						$_SESSION['mensaje'] = 'Registro exitoso, se redirigirá al login de forma automática';

					}
					sleep(1);
					header('location: login.php');

				}
				
			}
			else{
				$error .= "usuario existente";
				$_SESSION['mensaje'] = 'El campo usuario ya existe, trate de cambiarlo por otro';
			}
		}
		else
		{
			$error .= "usuario con caracteres con espacios";
			$_SESSION['mensaje'] = 'El campo usuario no debe tener espacios en blanco ni carácteres especiales, por favor cambiarlos por otro';
		}

	}else{
		$error .= "Hay campos vacios, debe llenarlos";
		$_SESSION['mensaje'] = 'Debe llenar todos los datos del formulario de registro.';
	}
}

 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Registro</title>
	<link rel="stylesheet" href="css/login.css">
	<?php /*Notar que usamos los mismos estilos en login.php asi lo queremos*/ ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.0/annyang.min.js"></script>
	<script src="javascript/librerias/artyom.js"></script>

	<script src="https://code.responsivevoice.org/responsivevoice.js?key=7RpgTxHY"></script>
	<script type="text/javascript" src="javascript/accesibilidad_reproducir_contenido.js"></script>
	<script src="javascript/accesibilidad_registro.js"></script>
</head>
<div class="botones_lector_reproduccion">
		<h1>Lector</h1>
		<button id="boton_pausar" class="boton_lector" onclick="pausar_lector()">Pausar</button>
		<button id="boton_reanudar" class="boton_lector" onclick="reanudar_lector()">Reanudar</button>
		<button id="boton_cancelar" class="boton_lector" onclick="cancelar_lector()">Cancelar</button>	
</div>
<body>
	<div class="contenedor-form">
	<button id="registro-sms-oculto" class="icono_reproducible" onclick="ejecutar_ayuda_registro()">Ayuda</button>

	<input type="hidden" id="mensaje_registro" value="<?php echo $_SESSION['mensaje'];$_SESSION['mensaje']=''; ?>">
	
		<h1>Registro</h1>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<label  for="discapacidad-registro"><strong>Discapacidad Visual:</strong></label>

			<select name="discapacidad" id="discapacidad-registro" class="input-control">
				<option  class="opcion" id="opcion1">Sin discapacidad</option>
				<option  class="opcion" id="opcion2">Discapacidad moderada</option>
				<option  class="opcion" id="opcion3">Discapacidad grave o ciega</option>
				<option  class="opcion" id="opcion4">Protección de la vista</option>
			</select><br>
			<label for="nombre-registro"><strong>Nombre: </strong></label>
			<input type="text" name="nombre" id="nombre-registro" class="input-control" placeholder="Nombre">
			<label for="usuario-registro"><strong>Usuario :</strong></label>
			<input type="text" name="usuario" id="usuario-registro" class="input-control" placeholder="Usuario">
			<label for="registro-password"><strong>Password:</strong></label>
			<input type="password" id="registro-password"  name="pass" class="input-control" placeholder="Password">
			<label for="registro-pais"><strong>País u origen</strong></label>
			<input type="text" id="registro-pais" class="input-control" name="pais" placeholder="País">
			<label for="registro-profesion"><strong>Profesión:</strong></label>
			<input type="text" class="input-control" name="profe" id="registro-profesion" placeholder="Profesión">
			<p id="captcha-sms-oculto" class="enlace-boton" onclick="comprobar_captcha()">Reproducir clave</p>
			<label for="captcha-registro"><strong>Captcha: </strong></label>
			
			<input type="text" name="captcha" id="captcha-registro" class="input-control" placeholder="Poner la clave audible">

			<input type="submit" value="Registrar" name="registrar" class="log-btn" id="registro-submit" >
		</form>
		<?php if(!empty($error)): ?>
			<p class="error"><?php echo $error ?></p>
		<?php endif;?> 
		<?php
			/*
			La class=error permite invocar los estilos en el archivo login.css para color rojo en :  .contenedor-form .error{, recordar que .contenedor-form implica a todo el formulario de registro y también si el $error no está vacío(porque el usuario cometió un error en el registro), entonces si no ha cometido tal error, no se cargará ese parrafo en código html sobre la interfaz en pantalla
			*/ 
		?>
		<div class="registrar">

			<a id="tengoCuenta" href="login.php" class="enlace-boton">Ir a login</a>

		</div>
	</div>
</body>
</html>