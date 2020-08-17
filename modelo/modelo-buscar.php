<?php 
session_start();
require('funciones/funciones.php');
require('clases/clases.php');
require('header.php');
verificar_session();
tiempo_sesion_mensaje();
if(isset($_GET['busqueda']))
{
	$nombre = $usuario = $_GET['busqueda'];
	/*Buscamos el nombre del usuario, ubicamos las siguientes instrucciones:*/
	$con = conexion();
	$consulta = $con->prepare("select * from usuarios where nombre like :nombre or usuario like :usuario");
	$consulta->execute(array(':nombre' => "%$nombre%", ':usuario'=>"%$usuario%"));
	/* Para q se reconozca ponemos a "%$nombre%" como un array asociativo sobre ':nombre', 
	  si lo ponemos sobre la consulta SQL nos podría dar conflictos por anidamiento 
	  de comillas dobles.Recordando que las comillas dobles reconocen variables dentro de ellas, 
	  por ello permiten procesar la variable $nombre y el % implica que puede estar buscada por 
	  fragmentos de ese nombre puesto en búsqueda tanto en la parte izquierda como derecha
	  y la posibilidad de que existan más usuarios con el mismo nombre */
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