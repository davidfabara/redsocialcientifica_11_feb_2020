<?php 
session_start();
require('funciones/funciones.php');
require('clases/clases.php');
verificar_session();
	$usuario = usuarios::usuario_por_codigo($_SESSION['CodUsua']);
	/*
    Como ['CodUsua'] es unívoco y con la función que ejecuta la consulta SQl sobre "select * from usuarios 
    where CodUsua = :CodUsua", obtenemos todas las columnas de la "TABLA usuarios" como CodUsua,nombre,	
    usuario, pass,país, profesión,edad,foto_perfil, la consulta SQL implica todos los datos del usuario de 
    SESSION por lo tanto solo sobre 1 usuario.
	*/
	if(isset($_POST['editar'])){
		if(!empty($_FILES)){
			$destino = 'subidos/';
			$destino_archivo_generico = 'img/';
			
			$archivoSinConf=$_FILES['foto']['name'];
			$img = $destino . $_FILES['foto']['name'];

			$tipo=explode('.', $archivoSinConf);
			$tipo1 = end($tipo);

			if($tipo1 == 'jpg' || $tipo1 == 'JPG' || $tipo1 == 'png' || $tipo1 == 'PNG'){
				
				$foto_perfil = $destino . $_FILES['foto']['name'];
				$tmp = $_FILES['foto']['tmp_name'];
				move_uploaded_file($tmp, $foto_perfil);
				/*Solo si es una imagen, se procesará de lo contrario nos quedamos con la foto anterior */	
			}else{
				$foto_perfil = $usuario[0]['foto_perfil'];
					
			}
		}else{
			$foto_perfil = $usuario[0]['foto_perfil'];	
		}
	    /*tmp_name es el nombre temporal que le da el sistema al archivo */
		/*En la siguiente línea se declara e inicializa el arreglo $datos */
		$datos = array(
				$_POST['nombre'],
				$_POST['usuario'],
				$_POST['profesion'],
				$_POST['pais'],
				$foto_perfil,
				$_POST['discapacidad']
			);
		if(strpos($datos[1], " ")  == false){
			/*
             strpos controla ( en este caso)el argumento "espacio", porque un usuario no puede tener espacios 
             dentro de el 
			*/
			usuarios::editar($_SESSION['CodUsua'], $datos);
			/*
             editar() implica a la función de la clase usuarios que con sus argumentos pueden recibirse como 
             parámetros en la consulta SQL de ; ("update usuarios set nombre = :nombre, usuario = :usuario, 
             profesion = :profesion, pais = :pais, foto_perfil = :foto_perfil, discapacidad = :discapacidad 
             where CodUsua = :CodUsua");
			*/
			if($_SESSION['discapacidad'] !=$_POST['discapacidad'])
				$_SESSION['discapacidad'] =$_POST['discapacidad'];
			/* Solo si hay una actualización en el tipo de discapacidad, se actualizará la variable de sesión */
			header('location: editar_perfil.php');
			/* 
			recargamos para actualizar visiblemente los cambios ya procesados en base de datos
			 */
		}
	}
 ?>