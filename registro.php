<?php

require('funciones.php');
require('clases/clases.php');

$error = "";
if(isset($_POST['registrar']))
{
	$pass = hash('sha512', $_POST['pass']); /* La función hash sirve para encriptar un valor pasado como argumento en este caso la contraseña pass , el primer parámetro es el algoritmo sha512, convierte el argumento pasado en un string de 128 caracteres*/
	
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
	
		if(!strpos($datos[1], " ")) /*strpos, permite saber si un carácter como argumento esta presente dentro de algun String dado , $datos[1] implica a el usuario  y queremos controlar que NO tenga espacios en blanco  con el argumento " " por ello !strpos */
		{
			if(empty(usuarios::verificar($datos[1]))) /* Se envia $_POST['nombre'] a la función verificar de la clase usuarios para verificar si existe o no el ususario*/
			{
				usuarios::registrar($datos); /*llamamos a la funcion registrar que esta dentro de clase usuarios */
			}
			else{
				$error .= "usuario existente";
			}
		}
		else
		{
			$error .= "usuario con caracteres con espacios";
		}
	}else{
		$error .= "Hay campos vacios, debe llenarlos";
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

	<script src="http://code.responsivevoice.org/responsivevoice.js"></script>
	<script src="javascript/accesibilidad_registro.js"></script>
</head>
<body>
	<div class="contenedor-form">

	<p id="registro-sms-oculto" class="icono_reproducible" onclick="ejecutar_ayuda_registro()"><strong>📢</strong></p>
	
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
			<input type="text" id="registro-pais"     class="input-control" name="pais" placeholder="Pais">
			<label for="registro-profesion"><strong>Profesión:</strong></label>
			<input type="text" class="input-control" name="profe" id="registro-profesion" placeholder="Profesión">
			
			
			<input type="submit" value="Registrar" name="registrar" class="log-btn" id="registro-submit" >
		</form>
		<?php if(!empty($error)): ?>
			<p class="error"><?php echo $error ?></p>
		<?php endif;?> 
		<?php
			/*
			La class=error permite invocar los estilos en el archivo login.css para color rojo en :  .contenedor-form .error{, recordar que .contenedor-form implica a todo el formulario de registro y también si el $error no está vacío(porque el usuario cometió un error en el registro), entonces si no ha cometido tal error, NO SE cargará ese parrafo en código html sobre la interfaz en pantalla
			*/ 
		?>
		<div class="registrar">

			<a id="tengoCuenta" href="login.php">Ir a login</a>

		</div>
	</div>
</body>
</html>