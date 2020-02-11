<?php 

function conexion()
{
	try {
		$usuario='root';
		$pass='';

		$con = new PDO('mysql:host=localhost;dbname=red_social', $usuario, $pass);
		return $con; // Se crea una instancia de PDO para con $con asignarle la conexion a la base de datos tanto usuario como contraseña podrian establecer unicidad
		
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
		if(empty($datos[$c])) /*Con este condicional nos aseguramos que si algún dato de los suministrados en el formulario de registro en el que alguno este vacio, simplemente se asignara vacio en true y se saldrá del condicional con "breack;" puesto que a penas se detecte un valor vacio, se debe rapidamente informar */
		{
			$vacio = true;
			break;
		}
	}

	return $vacio; // Se retornará el valor booleano de la variable $vacio si alguno de los elementos del array $datos es vacio se retornará false, true en caso contrario
}


function limpiar($limpio) /**/
			{
				$limpio = htmlspecialchars($limpio); //quita caracteres de html
				$limpio = trim($limpio); //quita espacios
				$limpio = stripcslashes($limpio); /*TODO:quitar barras invertidas, 	esto actualizaria a $limpio */
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
	/* retorna una fecha con anio, mes, dia y horas y minutos de la publicacion */
	date_default_timezone_set('America/New_York');
	setlocale(LC_ALL,"hu_HU.UTF8");
	$fecha=(strftime("%Y/%m/%e %H:%M"));

	return $fecha;
}

		
	

 ?>