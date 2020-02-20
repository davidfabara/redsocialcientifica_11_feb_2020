<?php 

function conexion()
{
	try {
		$usuario='root';
		$pass='';

		$con = new PDO('mysql:host=localhost;dbname=red_social', $usuario, $pass);
		return $con; // Se crea una instancia de PDO para con $con asignarle la conexión a la base de datos tanto usuario como contraseña podrían establecer unicidad
		
	} catch (PDOException $e) {
		return $e->getMessage();
	}
}


function datos_vacios($datos)
{
	$vacio = false;
	$tam = count($datos); // contará el tamaño total del arreglo recibido
	for($c = 0; $c < $tam; $c++) 
	{
		if(empty($datos[$c])) /*Con este condicional nos aseguramos que si algún dato de los suministrados en el formulario de registro en el que alguno este vacío, simplemente se asignara vacio en true y se saldrá del condicional con "breack;" puesto que apenas se detecte un valor vacio, se debe rapidamente informar */
		{
			$vacio = true;
			break;
		}
	}

	return $vacio; // Se retornará el valor booleano de la variable $vacio si alguno de los elementos del array $datos es vacío se retornará false, true en caso contrario
}


function limpiar($limpio) /**/
			{
				$limpio = htmlspecialchars($limpio); //quita caracteres de html
				$limpio = trim($limpio); //quita espacios
				$limpio = stripcslashes($limpio); /*TODO:quitar barras invertidas, 	esto actualizaría a $limpio */
				return $limpio;
			}
		

function verificar_session()
{
	if(!isset($_SESSION['CodUsua']))
	{ 
		/*Si no hay usuario que haya iniciado una sesion, simplemente se redirecciona a login.php inmediatamente */
		header('location: login.php');
	}
}
function fechaPost(){
	/* retorna una fecha con año, mes, día y horas y minutos de la publicación */
	date_default_timezone_set('America/New_York');
	setlocale(LC_ALL,"hu_HU.UTF8");
	$fecha=(strftime("%Y/%m/%e %H:%M"));

	return $fecha;
}

function tiempo_sesion_mensaje(){
	$limite = 10;
	if(isset($_SESSION['tiempo']) ) {
		$sesion_actual = time() - $_SESSION['tiempo'];
			if($sesion_actual > $limite)
			{
				return $_SESSION['mensaje'] ="";
			}else{
				return $_SESSION['mensaje'];
			}
		}
	 

}
		
	

 ?>