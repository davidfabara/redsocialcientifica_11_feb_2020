<?php 
include_once 'modelo/modelo-buscar.php';
 ?>
	<script src="javascript/accesibilidad_buscar.js"></script>
	<div class="resultados-busqueda">
		<h1>Resultados de usuarios:</h1>
		<?php if(!empty($resultados)): ?>
			<?php foreach($resultados as $r): ?>
				<div class="usuarios">
					<div class="img">
						<a href="perfil.php?CodUsua=<?php echo $r['CodUsua']; ?>"><img src="<?php echo $r['foto_perfil']; ?>" alt="Foto de perfil de <?php echo $r['nombre']; ?>"></a>
					</div>
					<?php /* Al momento de mostrar resultados, se visualizará la foto de perfil y el nombre, y esa foto de perfil como la imagen representará un enlace hacia el perfil de dicho usuario de los resultados de búsqueda */?>
					<div class="nombre">
						<a href="perfil.php?CodUsua=<?php echo $r['CodUsua']; ?>"><?php echo $r['nombre']; ?></a>
						<?php /*Nos aparecerá un  enlace que nos permitirá acceder como un hipervínculo al perfil de un usuario, el resultado se mostrará con la foto de perfil asociada al nombre con ese vínculo al perfil específico del usuario que busquemos en las búsquedas, como los RESULTADOS de búsqueda pueden implicar a más de un usuario con el mismo nombre pero con diferente CodUsua, lo que pasa es que existe un foreach que nos permite iterar $resultados as $r para acceder de la misma manera(anterior expuesta) a cada usuario que coincida */?>
					</div>							
				</div>
			<?php endforeach; ?>
		<?php else: ?>
			<h1 class="no-resultados">No se encontraron usuarios con esa descripción</h1><br><hr><br>	
		<?php endif; ?>		
	</div>
	<div class="busqueda-titulo">
			<form action="index.php" method="get" id="buscar_completo">
			<label for="busqueda-buscarPHP"><strong><h1>Buscar por título o por categoría: </h1></strong></label>
			<input type="hidden" id="mensaje_buscar" value="<?php echo $_SESSION['mensaje'];?>">	
				<input type="text" id="busqueda-buscarPHP" name="buscar" value="<?php echo $_GET['busqueda'] ?>">
				<?php /*  Si hacemos "enter" el formulario devolverá el control a buscar.php, en ese archivo  se recibe  $_GET['busqueda'] y si existe un usuario se mostrará,los existentes segun coincidencias de búsqueda, pero también se cargará en el elemento value una búsqueda lista sobre el título de publicaciones */
				?>
			</form>
	</div>
</body>
</html>