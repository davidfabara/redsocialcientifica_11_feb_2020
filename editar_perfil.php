<?php
include_once 'modelo/modelo-editar-perfil.php'; 
 ?>
 <!DOCTYPE html>
 <html lang="es">
 <head>
 	<meta charset="UTF-8">
 	<title>Editar Perfil</title>
	 <link rel="stylesheet" href="css/login.css">
	<script type="text/javascript" src="javascript/mostrar_contenido.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.0/annyang.min.js"></script>
	<script src="plugins/librerias/artyom.js"></script>
	<script src="https://code.responsivevoice.org/responsivevoice.js?key=7RpgTxHY"></script>
	<script type="text/javascript" src="javascript/accesibilidad_reproducir_contenido.js"></script>
	<script src="javascript/accesibilidad_editar_perfil.js"></script>
 </head>
 <body>
 <header class="botones_lector_reproduccion">
		<h1>Lector</h1>
		<button id="boton_pausar" class="boton_lector" onclick="pausar_lector()">Pausar</button>
		<button id="boton_reanudar" class="boton_lector" onclick="reanudar_lector()">Reanudar</button>
		<button id="boton_cancelar" class="boton_lector" onclick="cancelar_lector()">Cancelar</button>	
</header>
	
 	<div class="contenedor-form">
 		<h1>Editar perfil</h1>

		 <button id="editar-perfil-sms-oculto" class="icono_reproducible" onclick="ejecutar_ayuda_editar_perfil()">Ayuda</button>

		 <form action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" method="post">
			<label for="nombre-edit"><strong>Nombre</strong>
			</label>
			<input type="text" id="nombre-edit" name="nombre" class="input-control" value="<?php echo $usuario[0]["nombre"]; ?>">
			 
			<label for="usuario-edit"><strong>Usuario</strong>
			</label>
			 <input type="text" id="usuario-edit" name="usuario" class="input-control" value="<?php echo $usuario[0]["usuario"]; ?>">
			 
			<label for="profesion-edit"><strong>Profesión</strong>
			</label>
			 <input type="text" id="profesion-edit" name="profesion" class="input-control" value="<?php echo $usuario[0]["profesion"]; ?>">
			
			<label for="pais-edit"><strong>País</strong>
			</label>
			<input type="text" id="pais-edit" name="pais" class="input-control" value="<?php echo $usuario[0]["pais"]; ?>">

			<label for="discapacidad-edit"><strong>Discapacidad Visual</strong>
			</label>
			
			<select name="discapacidad" id="discapacidad-edit" class="categoria">
				<option id="discapacidad-edit1" class="opcion">Sin discapacidad</option>
				<option id="discapacidad-edit2" class="opcion">Discapacidad moderada</option>
				<option id="discapacidad-edit3" class="opcion">Discapacidad grave o ceguera</option>
				<option id="discapacidad-edit4" class="opcion">Protección de la vista</option>
				<option selected class="opcion"><?php echo $usuario[0]["discapacidad"]; ?></option>

			</select>
			 <?php /*El valor (value), incrusta los valores en el campo de texto porque son  correspondientes al que el usuario contiene registrados  referente a el perfil en la base de datos, cuando nosotros hacemos clic en editar, se registraran los mismos  */
			 ?>
			<img src="<?php echo $usuario[0]["foto_perfil"]; ?>"alt="<?php echo "Foto de perfil de : ".$usuario[0]["nombre"];?>" class="publi-img-perfil_de_loginCSS">
			<?php /* La clase publi-img-perfil en style.css se ha agregado para dar formato a la fotografia incrustada como referencia para ser mostrarse mientras se edita */?>
			<label for="editar-foto"><strong>Editar foto</strong></label>
			 <input type="file" id="editar-foto"name="foto">
			 <?php /*Cuando hacemos click en acpetar los cambios, podremos ver la imagen actualizada de la foto de perfil */?>
 			<input type="submit" value="Editar" name="editar" id="edit-submit" class="log-btn">
 		</form>
 		<div class="registrar">
 			<a id="return-perfil" href="perfil.php?CodUsua=<?php echo $_SESSION['CodUsua']; ?>" class="enlace-boton">Volver al Perfil</a>
			 <?php /* Para volver al perfil del usuario de SESSION */?>
 		</div>
 	</div>
 </body>
 </html>