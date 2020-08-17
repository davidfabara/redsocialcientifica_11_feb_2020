<?php
require('funciones/funciones.php');
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
	if(datos_vacios($datos) == false){
		if(!strpos($datos[1], " ")){ /*strpos, permite saber si un carácter como argumento esta presente dentro de algun string dado , $datos[1] implica a el usuario  y queremos controlar que no tenga espacios en blanco  con el argumento " " por ello !strpos */
			if(empty(usuarios::verificar($datos[1]))){/* Se envía $_POST['usuario'] a la función verificar de la clase usuarios para verificar si existe o no el ususario*/
				if(comprobar_captcha($captcha)===false){
					/* echo "<audio id='mensaje_desde_registro' overflow:hidden src='img/registro_exito.mp3' visibility:hidden autoplay></audio>";
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