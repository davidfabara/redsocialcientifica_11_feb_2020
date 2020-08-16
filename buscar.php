<?php 
session_start();
require('funciones.php');
require('clases/clases.php');
require('header.php');
verificar_session();

tiempo_sesion_mensaje();
if(isset($_GET['busqueda']))
{

	$nombre = $usuario = $_GET['busqueda'];
	
	/*Como no tenemos una función que nos ayude para buscar por el nombre completo de este o por el usuario(que no contiene espacios), ubicamos las siguientes instrucciones:  */
	$con = conexion();
	$consulta = $con->prepare("select * from usuarios where nombre like :nombre or usuario like :usuario");
	$consulta->execute(array(':nombre' => "%$nombre%", ':usuario'=>"%$usuario%"));
	/* Para q se reconozca ponemos a "%$nombre%" como un array asociativo sobre ':nombre', si lo ponemos sobre la consulta SQL nos podría dar conflictos por anidamiento de comillas dobles.Recordando que las comillas dobles reconocen variables dentro de ellas, por ello permiten procesar la variable $nombre y el % implica que puede estar buscada por fragmentos de ese nombre puesto en búsqueda tanto en la parte izq como der.,y la posibilidad de que existan más usuarios con el mismo nombre */
	$resultados = $consulta->fetchAll();
	if(!empty($resultados)){
		$_SESSION['mensaje'] = 'Tu búsqueda de usuario se ha realizado con éxito, también puedes encontrarlo en la sección de búsqueda por título o por categoría, si buscaste por esta última opción y presionaste enter, debes estar en la sección principal con el resultado de búsqueda';
	}else{
		$_SESSION['mensaje'] = 'La última consuta no dió usuarios de coincidencias con tu búsqueda, tratar de buscar por título o por categoría, si ya presionaste enter, debes encontrarte en la página principal con el resultado de búsqueda';
	}


	$_SESSION['tiempo'] = time();
	tiempo_sesion_mensaje();
}


/* Se procesarán todas las variables filtradas en la consulta SQL, sobre el array asociativo $resultados */
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
			<center>
			<form action="index.php" method="get" id="buscar_completo">
			<label for="busqueda-buscarPHP"><strong><h1>Buscar por título o por categoría: </h1></strong></label>
			<input type="hidden" id="mensaje_buscar" value="<?php echo $_SESSION['mensaje'];?>">	
				
				<input type="text" id="busqueda-buscarPHP" name="buscar" value="<?php echo $_GET['busqueda'] ?>">
				<?php /*  Si hacemos "enter" el formulario devolverá el control a buscar.php, en ese archivo  se recibe  $_GET['busqueda'] y si existe un usuario se mostrará,los existentes segun coincidencias de búsqueda, pero también se cargará en el elemento value una búsqueda lista sobre el título de publicaciones */
				?>
			</form>
			</center>
	</div>
	
</body>

</html>