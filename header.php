 <!DOCTYPE html>
 <html lang="es">
 <head>
 	<meta charset="UTF-8">
 	<title>Sitio Web Prototipo</title>
 	<link rel="stylesheet" href="icomoon/style.css"><!--iconos icomoon a importar configurable sobre los iconos en el archivo css del directorio icomoon/style.css  -->
	
	 <?PHP if(limpiar($_SESSION['discapacidad']) == limpiar('Discapacidad moderada') or limpiar($_SESSION['discapacidad']) == limpiar('Discapacidad grave o ciega') or ($_SESSION['discapacidad'])== limpiar('Sin discapacidad')):?>
	 <?php /* Solo si el usuario es una persona con discapacidad se cargara la hoja de estilo de style.css , pero al ser universal se puede compartir permisos */ ?>
	 <link rel="stylesheet" href="css/style.css">

	 <?php endif;?>
	 <?PHP if(limpiar($_SESSION['discapacidad']) == limpiar('Protección de la vista')):?>
	 <?php 
	 /* Solo si el usuario es una persona sin discapacidad se cargará la hoja de estilo predeterminada
	 */ 
	?>
	  <link rel="stylesheet" href="css/proteccion_vista.css">
	 
	 <?php endif;?>

	 <?PHP 
	 
	 if(limpiar($_SESSION['discapacidad']) == limpiar('Discapacidad moderada') or limpiar($_SESSION['discapacidad']) == limpiar('Discapacidad grave o ciega')):?>
	 <?php 
	 /* Solo si el usuario es una persona con discapacidad se cargará los scripts de accesibilidad de asistencia de síntesis de voz
	 */ 
	?>




	<?php endif;?>
	 <?php 
	 /* Finalización de el cargado de los scripts de accesibilidad de asistencia de síntesis de voz

	 https://code.responsivevoice.org/responsivevoice.js?key=7RpgTxHY

	 */ 
	?>
	 <script src="javascript/librerias/jquery3.4.1_min.js"></script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
	 <script type="text/javascript" src="javascript/mostrar_contenido.js"></script>

	 
	<script src="javascript/librerias/artyom.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.0/annyang.min.js"></script>
	<script src="https://code.responsivevoice.org/responsivevoice.js?key=7RpgTxHY"></script>
	<script type="text/javascript" src="javascript/accesibilidad_reproducir_contenido.js"></script>

 </head>
 <div class="botones_lector_reproduccion">
		<h1>Lector</h1>
		<button id="boton_pausar" class="boton_lector" onclick="pausar_lector()">Pausar</button>
		<button id="boton_reanudar" class="boton_lector" onclick="reanudar_lector()">Reanudar</button>
		<button id="boton_cancelar" class="boton_lector" onclick="cancelar_lector()">Cancelar</button>	
</div>
 <body>
 	<header>
 		 <a id="vinculo_principal" href="index.php"><h1 class= "titulo" >Sitio Web Prototipo</h1></a>

 		<form action="buscar.php" method="get" id="buscar">
		 	<label for="busqueda"><strong>Buscar:</strong></label>
 			<input type="text" id="busqueda" name="busqueda" placeholder="Buscar">
			<?php /*  Si hacemos "enter" el formulario devolverá el control a buscar.php, en ese archivo  se recibe  $_GET['busqueda'] y si existe un usuario de mostrará, los existentes según coincidencias de búsqueda  */?>
 		</form>
 		<nav>
 			<ul>
 				<li><a id="publicar_principal" href="index.php">Publicar</a></li>
				 <?php /* TODO: aquí podríamos posicionar una nueva busqueda orientada a buscar por titulo de contenido */ ?>

				<li id="info-solicitud">
				<?php $soli = amigos::solicitudes($_SESSION['CodUsua']); ?>
					<span id="icon-usuario">Solicitudes<span class="no-leido"><?php if(count($soli) > 0) echo count($soli); ?></span></span>

					<?php /* <!-- se contara las solicitudes numéricamente $ soli es un arreglo y count determina la cantidad de elementos(registros) que tiene ese arreglo y con la clase no-leido en el css lo que hacemos es darle color rojo, se accede a icon-users , es una clase que invoca a los estilos de icomoon/style.css el conteo es numerico con la clase no-leido, la llamada a amigos::solicitudes($_SESSION['CodUsua']) retornara los $resultados con la consulta SQL procesada --> */ ?>
					<?php  $soli_acum=""; $acum_s=""; ?>
					<?php if(count($soli) > 0): ?>
					<ul id="nav-solicitud">


						<?php foreach($soli as $solicitudes): ?>
						<?php /* Si contabilización de $soli es >0 se ejecutará las instrucciones.Array $solicitudes apunta a $soli y foreach iterará todos los arrays de $soli que contienen los resultados de la consulta SQL procesada anteriormente (se mostrarán los usuarios que han enviado solicitudes de amistad) */?>
						<li><a href="perfil.php?CodUsua=<?php echo $solicitudes['CodUsua']; ?>"><?php echo $solicitudes['nombre'];$acum_s=$solicitudes['nombre']; ?></a>

						</li>
						<?php /* Para mostrar las solicitudes asociadas al nombre del usuario implicado */ 
						?>
						<ul>
							<li><a href="solicitud.php?CodAm=<?php echo $solicitudes['CodAm']; ?>&&accion=1" class="icon-checkmark">&nbsp;Aceptar</a></li>
							 <?php /* <!-- icon-checkmark como ícono da la posibilidad de ACEPTAR a una solicitud de un usuario con accion=1 esta solicitud se envía a solicitud.php en donde se leen con if( isset($_GET['CodAm']) and isset($_GET['accion']))tambien &nbsp; para espacio en html--> */ 
							 ?>
							<li><a href="solicitud.php?CodAm=<?php echo $solicitudes['CodAm']; ?>&&accion=2" class="icon-cross">&nbsp;Rechazar</a></li>
							<?php /* <!-- icon-cross como icono da la posibilidad de RECHAZAR a una solicitud de un usuario que desea contactarle--> */ 
							?>
						</ul>
						<?php $soli_acum.=$acum_s." "; ?>
						<?php endforeach; ?>

					</ul>
					<?php endif; ?>
					<input type="hidden" name="solicitudes-acumuladas" value="<?php
                 		echo strip_tags(empty($soli_acum)||$soli_acum===""?"No existen solicitudes":$soli_acum); ?>">
				</li>

				<li id="info-notificaciones">
					<?php $not = notificaciones::mostrar($_SESSION['CodUsua']); ?>
					<?php /* Para mostrar las notificaciones del usuario de SESSION */?>
					<span id="icon-campana">Noticias<span class="no-leido"><?php if(!empty($not)) echo count($not)?></span></span>
					<?php  $noti_acum=""; $acum_n=""; ?>
					<?php if(!empty($not)): ?>
						<ul id="nav-notificaciones">
							<li>

							<?php foreach($not as $noti): ?>
								<a href="post.php?CodNot=<?php echo $noti['CodNot']; ?>&&CodPost=<?php echo $noti['CodPost']; ?>">
									<?php echo $noti['nombre'];$acum_n= $noti['nombre'];?>
									<?php if($noti['accion'] == 0): ?>
										<p><?php echo " Ha puesto ok en tu publicación"; $acum_n.=" Ha puesto ok en tu publicación"; ?></p>	
									<?php else: ?>
										<p><?php echo " Comentó tu publicación"; $acum_n.=" Comentó tu publicación"; ?></p>	
								<?php endif; ?>
								</a>
							<?php $noti_acum.=$acum_n.', '; ?>
							<?php endforeach; ?>

							<?php /* Los valores de acción de la tabla notificaciones al ser de tipo bit, puede tener los valores 0 o 1 , TODO: los valores de CodNot son unívocos pueden haber muchas CodNot por cada CodPost(de una publicación) por ello al hacer click se debe enviar a post.php para actualizar las vistas y actualizar en la base de datos y en la interfaz de la página  */ ?>
							</li>
						</ul>

						<?php endif; ?>
						<input type="hidden" id="notificaciones-acumuladas" value="<?php
                 				echo strip_tags(empty($noti_acum)||$noti_acum===""?"No existen notificaciones":$noti_acum); ?>">
				</li>

 				<li class="info_usuario">
 					<a href="#"><?php echo $_SESSION['nombre']; ?></a>
 					<ul id="nav-perfil">
						 <?php /*<!--nav-perfil en CSS tiene visibility: hidden; para q tanto ver perfil como cerrar no se muestren y solo con la propiedad hover sean visibles, pero si podemos ver el perfil de otros usuarios, pero el usuario de la sesión puede verlo haciendo click en perfil o haciendo click en su nombre como vínculo -->  */?>
 						<li><a id="navegacion_perfil"  href="perfil.php?CodUsua=<?php echo $_SESSION['CodUsua']; ?>">Perfil</a></li>
 						<li><a id="navegacion_cerrar"   href="cerrar.php">Cerrar</a></li>
 					</ul>
 				</li>
 			</ul>
			<?php  /*TODO: $_SESSION['CodUsua'] contendría un valor unívoco para la sesión de un usuario */?>
 		</nav>
 	</header>
	<?php
	/*<!-- TODO: Si notamos aquí, FALTA la finalización del cuerpo y el contenido de subir.php iría inmediatamente después de este <header> --> */
	?>