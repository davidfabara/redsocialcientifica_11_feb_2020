<?php 
class usuarios{
	public  static function registrar($datos) 
	{
		$con = conexion(); //llama a la función conexion de funciones.php ojo está en español el nombre de esta función)
		$consulta = $con->prepare("insert into usuarios(CodUsua, nombre, usuario, pass, pais, profesion, discapacidad, foto_perfil) values(null, :nombre, :usuario, :pass, :pais, :profe, :discapacidad, :foto_perfil)");
		$consulta->execute(array(':nombre' => $datos[0],
								  ':usuario' => $datos[1],
								  ':pass' => $datos[2],
								  ':pais' => $datos[3],
								  ':profe' => $datos[4],
								  ':discapacidad' => $datos[5],
								  ':foto_perfil' => 'img/sin foto de perfil.jpg'
							));
		/*Notar que con prepare se prepara la conexion y con $consulta->execute se ejecuta la consulta con un array asociativo recordando que el parámetro $datos en esta función registrar contiene un array de todos los datos del formulario de registro del usuario */
	}
	public static function verificar($usuario) //Para verificar si usuario existe
	{
		$con = conexion(); /* Se llama a la función "conexion" de funciones.php enviando argumentos usuario y contraseña para acceso a base de datos*/
		$consulta = $con->prepare("select * from usuarios where usuario = :usuario");
		$consulta->execute(array(':usuario' => $usuario)); 
		/*$usuario es el parámetro recibido en esta función y :usuario es el elemento que con un array asociativo, apunta a $usuario */
		$resultado = $consulta->fetchAll(); /*fetchAll() recupera todos los datos */
		return $resultado;
	}
	public static function editar($CodUsua, $datos)
	{
		/* Desde editar_perfil.php se evoca este método con la intensión de poder actualizar los valores de perfil del usuario */
		$con = conexion();
		$consulta = $con->prepare("update usuarios set nombre = :nombre, usuario = :usuario, profesion = :profesion, pais = :pais, foto_perfil = :foto_perfil, discapacidad = :discapacidad where CodUsua = :CodUsua");
		$consulta->execute(array(':nombre' => $datos[0],
								  ':usuario' => $datos[1],
								  ':profesion' => $datos[2],
								   ':pais' => $datos[3],
								  ':foto_perfil' => $datos[4],
								  ':discapacidad' => $datos[5],
								  ':CodUsua' => $CodUsua

							));
		/*El valor $CodUsua (siendo un valor int en la base de datos registrada), se recibe como parámetro 
		en esta función , los índices de los arreglos solo son para correlacionar los elementos del arreglo 
		con los valores de los arrays asociativos sobre la consulta SQL, los $datos deben ser un arreglo en 
		el cual se introduce los valores de nombre, usuario ,profesión, país, foto_perfil que serían los datos
		a editar y si no simplemente se han dejado por defecto los campos en los cuales no se ha editado, 
		no necesitamos de -> $resultado = $consulta->fetchAll(); porque no retornaremos resultados, 
		pues con header('location: editar_perfil.php'); ya se actualizarían en la pantalla los datos que 
		previamente fueron actualizados en la base de datos */
	}
	public static function usuario_por_codigo($CodUsua)
	{
		$con = conexion();
		$consulta = $con->prepare("select * from usuarios where CodUsua = :CodUsua");
		$consulta->execute(array(':CodUsua' => $CodUsua));
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
}
class post{
	public static function agregar($CodUsua, $titulo, $autor, $fecha, $categoria, $contenido, $img, $url)
	{
		$con = conexion();
		$consulta = $con->prepare("insert into post(CodPost, CodUsua, titulo, autor, fecha, categoria, contenido, img, url) values(null, :CodUsua, :titulo, :autor, :fecha, :categoria, :contenido, :img, :url)");
		$consulta->execute(array(':CodUsua' => $CodUsua,
								 ':titulo' => $titulo,
								 ':autor' => $autor,
								 ':fecha' => $fecha,
								 ':categoria' => $categoria,
								 ':contenido' => $contenido,
								 ':img' => $img,
                                 ':url' => $url
			));
		$_SESSION['mensaje'] = 'Tu publicación se ha enviado con éxito y se encuentra en esta página principal después del formulario para subir una publicación, para visualizarla  recuerda hacer click en mostrar todo para ver su contenido';

		$_SESSION['tiempo'] = time();
	}
	public static function post_por_usuario($CodUsua)
	{
        /* Para buscar una publicación por usuario*/
		$con = conexion();
		$consulta = $con->prepare("select U.CodUsua, U.nombre, U.foto_perfil, P.CodPost, P.titulo, P.autor, P.fecha, P.categoria, P.contenido, P.img, P.url from usuarios U inner join post P on U.CodUsua = P.CodUsua where P.CodUsua = :CodUsua ORDER BY P.CodPost DESC limit 10");
		/*P.CodUsua = :CodUsua es necesario, porque si bien el código SQL inmediato anterior permite 
		hacer una relación con CodUsua entre las tablas "usuarios" con "post", esto es genérico y para 
		todos los registros, para aplicar espacifidad  necesitamos filtrar por el $CodUsua enviado como
		 parámetro en esta función con respecto a P.CodUsua de Post, recordando la necesidad del INNER JOIN 
		 es debido a que necesitamos más datos de los registros del usuario para llamar a datos como nombre, 
		 foto_perfil del usuario y justamente las columnas que se ha seleccionado en SELECT , 
		 el ORDER BY P.CodPost DESC implicará un orden descendente de mayor a menor, si bien no tenemos 
		 registrado una fecha, el CodPost esta programado como AUTO-INCREMENT, TODO:por ello los POST más 
		 recientes serán los valores más altos de CodPost */
		$consulta->execute(array(':CodUsua' => $CodUsua));
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public static function mostrarTodo($amigos, $CodUsua)
	{
		/* Función para mostrar todas las publicaciones de los amigos del usuario de la sesión, porque en 
		amigos::codigos_amigos($_SESSION['CodUsua']); esta función se ejecuta en index.html inmediatamente 
		"antes" de esta función mostrarTodo($amigos)  , se envía como parámetro $_SESSION['CodUsua']), luego 
		desde index.php se llama con $post = post::mostrarTodo($amigos[0]['amigos'] al ejecutar esta última 
		se puede capturar en publicacion.php el valor retornado con :
		<?php if(!empty($post)): ?>
		<?php foreach($post as $posts): ?>
		;
   		*/
		$con = conexion();
		$consulta = $con->prepare("select U.CodUsua, U.nombre, U.foto_perfil, P.CodPost, P.titulo, P.fecha, P.categoria, P.autor, P.contenido, P.img, P.url from usuarios U inner join post P on U.CodUsua = P.CodUsua where P.CodUsua = :CodUsua ORDER BY P.CodPost DESC limit 10");
		$consulta->execute(array(':CodUsua' => $CodUsua));
		$resultado = $consulta->fetchAll();
		return $resultado;
        /* Limitar las ocurrencias implica una optimización para rendimiento */
        /*
		Evidencia de que en IN se separan por comas los argumentos, tal cual como la variable $amigos: 
		https://www.w3schools.com/sql/sql_in.asp.
		usando group_concat() : https://www.w3resource.com/mysql/aggregate-functions-and-grouping/aggregate-
		functions-and-grouping-group_concat.php
		"in" nos devolveria todos los registros de los elementos de la consulta de $amigos = amigos::codigos_
		amigos($_SESSION['CodUsua']) que como sabemos implica a (" select group_concat(usua_enviador,',', 
		usua_receptor) as amigos from amigos where (usua_enviador = :CodUsua or usua_receptor = :CodUsua) and 
		status = 1 "); , lo que sucede en post::mostrarTodo($amigos); es que $amigos a mas de la consulta SQL 
		efectuada con la seleccion de    select group_concat(usua_enviador,',', usua_receptor) as amigos nos 
		filtra esos valores separados por ",", que justamente el "in" procesa distintas variables separadas por
		 coma, La importancia de usar la variable $amigo y no un array asociativo, es porque al usar la 
		 variable $amigos y no :amigos es  aseguramos que se reconocerán valores enteros devido a los pares 
		 usua_enviador, usua_receptor que los tenemos devido a $amigos = amigos::codigos_
		 amigos($_SESSION['CodUsua']);*/
	}
	public static function mostrarTodo_busqueda($buscar){
		$con = conexion();
		$consulta = $con->prepare("select U.CodUsua, U.nombre, U.foto_perfil, P.CodPost, P.titulo, P.autor, P.fecha, P.categoria,P.contenido, P.img, P.url from usuarios U inner join post P on U.CodUsua = P.CodUsua where P.titulo like :buscar or P.categoria like :buscar or U.nombre like :buscar or P.autor like :buscar  ORDER BY P.CodPost DESC");
		$consulta->execute(array(':buscar' => "%$buscar%"));
		$resultado = $consulta->fetchAll();
		if(!empty($resultado)){
			$_SESSION['mensaje'] = 'Tu búsqueda se ha realizado con éxito, se desplegará en la página principal. ';
		}else{
			$_SESSION['mensaje'] = 'No hay coincidencias de búsqueda por título o categoría';
		}
		$_SESSION['tiempo'] = time();
		return $resultado;
		/* Cada una de las potenciales búsquedas van en función del argumento $buscar ya sea por el título, categoría, o nombre u autor todo esto llamado desde index.php y anteriormente desde buscar.php */
	}
	public static function mostrar_por_codigo_post($CodPost)
	{
		$con = conexion();
		$consulta = $con->prepare("select U.CodUsua, U.nombre, U.foto_perfil, P.CodPost, P.titulo, P.autor, P.fecha, P.categoria,P.contenido, P.img, P.url from usuarios U inner join post P on U.CodUsua = P.CodUsua where P.CodPost = :CodPost ORDER BY P.CodPost DESC");
		$consulta->execute(array(':CodPost' => $CodPost));
		$resultado = $consulta->fetchAll();
		$_SESSION['tiempo'] = time();
		return $resultado;
	}
}
class comentarios{
	public static function agregar($comentario, $CodUsua, $CodPost)
	{
		/* El objetivo de esta función es agregar los comentarios a la base de datos, esto se lo hace desde index.php desde comentarios::agregar($_POST['comentario'], $_SESSION['CodUsua'], $_POST['CodPost']);, no retornamos valores, porque en las siguiente instrucción   notificaciones::agregar(1, $_POST['CodPost'], $_SESSION['CodUsua']); lo que hacemos es registrar la notifcacion y esto es gracias a 
		header('location: index.php'); que recargará la página para hacer visibles las notificaciones actualziadas */
		$con = conexion();
		$consulta = $con->prepare("insert into comentarios(comentario, CodUsua, CodPost) values(:comentario, :CodUsua, :CodPost) ");
		$consulta->execute(array(
					':comentario' => $comentario,
					':CodUsua' => $CodUsua,
					':CodPost' => $CodPost

					));
		$_SESSION['mensaje'] = 'Tu último comentario fue registrado exitosamente';

		$_SESSION['tiempo'] = time();
	}
	public static function mostrar($CodPost)
	{
		$con = conexion();
		$consulta = $con->prepare("select U.nombre, C.comentario, C.CodCom from usuarios U inner join comentarios C on U.CodUsua = C.CodUsua where C.CodPost = :CodPost ORDER BY C.CodCom ASC") ;
		$consulta->execute(array(':CodPost' => $CodPost));
		$resultado = $consulta->fetchAll();
		return $resultado;
		/* TODO: Se ha arreglado ,es importante el ORDER BY, para justamente ir ordenando las publicaciones
		 por el código de comentario que es unívoco y es autoincrement, como en publicaciones.php , 
		 el comentario involucra a un codPost específico y cada uno tiene varios comentarios
		  (los procesados en esta función), solo basta ordenar los comentarios en base a CodCom en el cual 
		  cada registro de la consulta SQL  tienen asociado un nombre y el contenido de ese comentario  */
	}
}
class mg
{
	public static function agregar($CodPost, $CodUsua)
	{
		/*Desde perfil.php se llama a esta función ;    mg::agregar($_GET['CodPost'], $_SESSION['CodUsua']); con la finalidad de que en esta función los parametros recibidos INSERTEN un registro para el "me gusta" */
		$con = conexion();
		$consulta = $con->prepare("insert into mg(CodLike, CodPost, CodUsua) values(null, :CodPost, :CodUsua)");
		$consulta->execute(array(':CodPost' => $CodPost, ':CodUsua' => $CodUsua));
	}
	/*function borrar($CodLike)
	{
		Desde perfil.php se llama a esta funcion ; mg::agregar($_GET['CodPost'], $_SESSION['CodUsua']); 
		con la finalidad de que en esta funcion los parametros recibidos INSERTEN un registro para el
		 "me gusta"
        
		$con = conexion("root", "");
		$consulta = $con->prepare("delete from mg where CodLike in($CodLike)");
		$consulta->execute();
	} 
    */
	public static function mostrar($CodPost)
	{
		/* Para contar la cantidad de mg , desde la clase publicacion.php se llama con mg::mostrar($posts['CodPost'])[0][0]* , /* Es importante: agregar [0][0] para conformar $posts['CodPost'])[0][0], de lo contrario nos dara un error de conversion de array a String, la consulta SQL :  "select count(*) from mg where CodPost = :CodPost"*/
		$con = conexion();
		$consulta = $con->prepare("select count(*) from mg where CodPost = :CodPost");
		$consulta->execute(array(':CodPost' => $CodPost));
		$resultados = $consulta->fetchAll();
		return $resultados;
		/* Tabla mg tiene las columnas 	CodLike	CodPost	CodUsua, donde la llave primaria es CodLike */
	}
	public static function verificar_mg($CodPost, $CodUsua)
	{
		/*Para verificar si un usuario ya ha dado ok a una publicacion, retornará el conteo (count) de los 
		resultados, no nos interesa cuantos me gusta, solo si hay por lo menos un me gusta. $CodUsua como
		 parametro contiene $_SESSION['CodUsua'] <?php if(mg::verificar_mg($posts['CodPost'], $_SESSION['CodUsua']) == 0): ?>
		<a href="<?php echo $_SERVER['PHP_SELF'] ?>?mg=1&&CodPost=<?php echo $posts['CodPost'] ?>" 
		class="like icon-checkmark2"></a>
		<?php /* mg=1 implica que hay cero me gusta por parte del usuario puede existir muchos me gustas, 
		pero nos estamos enfocando en el usaurio de sesión, en este caso, el ícono tendrá un contorno de visto 
		acío si no ha puesto me gusta( lo mas común), y si ha puesto me gusta se mostrará un ícono con un
		 contorno completo con la siguiente sección de codigo de publicacion.php
		<?php else: ?>
		<a href="<?php echo $_SERVER['PHP_SELF'] ?>?mg=1&&CodPost=<?php echo $posts['CodPost'] ?>" class="like icon-checkmark"></a>
		
		*/
		$con = conexion();
		$consulta = $con->prepare("select CodLike from mg where CodPost = :CodPost and CodUsua = :CodUsua");
		$consulta->execute(array(':CodPost' => $CodPost, ':CodUsua' => $CodUsua));
		$resultados = $consulta->fetchAll();
		return count($resultados);
	}
    /*function codigoLike($CodPost, $CodUsua)
    {
    $con = conexion("root", "");
		$consulta = $con->prepare("select CodLike from mg where CodPost = $CodPost and CodUsua = $CodUsua");
		$consulta->execute();
		$resultados = $consulta->fetchAll();
		return $resultados;
	}
    */
}
class denuncias{
	public static function mostrar($CodPost)
	{
		/* Para contar la cantidad de denuncias sobre una publicación , desde la clase publicacion.php se llama con denuncias::mostrar($posts['CodPost'])[0][0]* , /* Es importante: agregar [0][0] para conformar $posts['CodPost'])[0][0], de lo contrario nos dará un error de conversión de array a String, la consulta SQL :  "select count(*) from mg where CodPost = :CodPost"*/
		$con = conexion();
		$consulta = $con->prepare("select count(*) from denuncia where CodPost = :CodPost");
		$consulta->execute(array(':CodPost' => $CodPost));
		$resultados = $consulta->fetchAll();
		return $resultados;
		/* Tabla mg tiene las columnas 	CodLike	CodPost	CodUsua, donde la llave primaria es CodLike */
	}
	public static function verificar_denuncia($CodPost, $CodUsua){

		$con = conexion();
		$consulta = $con->prepare("select CodDen from denuncia where CodPost = :CodPost and CodUsua = :CodUsua");
		$consulta->execute(array(':CodPost' => $CodPost, ':CodUsua' => $CodUsua));
		$resultados = $consulta->fetchAll();
		return count($resultados);
	 }
 	public static function agregar($CodPost, $CodUsua){
		/*Desde perfil.php se llama a esta función ;    denuncias::agregar($_GET['CodPost'], $_SESSION['CodUsua']); con la finalidad de que en esta función los parámetros recibidos INSERTEN un registro para la denuncia */
		$con = conexion();
		$consulta = $con->prepare("insert into denuncia(CodDen, CodPost, CodUsua) values(null, :CodPost, :CodUsua)");
		$consulta->execute(array(':CodPost' => $CodPost, ':CodUsua' => $CodUsua));
	}
}
class notificaciones
{
	/* En perfil.php en los condicionales que comprueban si if(isset($_POST['comentario'])) y después  if(isset($_GET['mg'])) , la acción implica que un usuario puede dar ok o también puede comentar una publicación en perfil.php se controla con los condicionales comprobando en ellos si existe un comentario o en el caso de si ha sido presionado el "me gusta"(ícono de visto)*/

	public static function agregar($accion, $CodPost, $CodUsua)
	{ /* desde index.php debido al "comentario" de un usuario desde publicacion.php, se llama a esta función con notificaciones::agregar(1, $_POST['CodPost'], $_SESSION['CodUsua']); */
		/* "visto" es para saber si un usuario ya ha visto una notificación , valores 1 o 0, 1 para notificación de comentarios, 0 en el caso de me gusta */
		$con = conexion();
		$consulta = $con->prepare("insert into notificaciones(CodNot, accion, CodPost, CodUsua, visto) values(null, :accion, :CodPost, :CodUsua, 0)");
		/*El valor 0 indica que un usuario aún no ha visto una notificación que posteriormente se registrará */	
		$consulta->execute(array(
			':accion' => $accion, 
			':CodPost' => $CodPost, 
			':CodUsua' => $CodUsua
			));
	}
	public static function mostrar($CodUsua)
	{
		/* Desde header.php con la instruccion $not = notificaciones::mostrar($_SESSION['CodUsua']) */
		/*Para mostrar las notificaciones de un usuario pero no sobre las actividades sobre si mismo */
		$con = conexion();
		$consulta = $con->prepare("select U.CodUsua, U.nombre, N.CodNot, N.accion, N.CodPost from notificaciones N inner join usuarios U on U.CodUsua = N.CodUsua where N.CodPost in(select CodPost from post where CodUsua = :CodUsua) and N.visto = 0 and N.CodUsua != :CodUsua");
		/*Sentencia "on", para indicar los campos relacionados, la instruccion N.CodUsua != :CodUsua es necesaria porque una notificación no debe implicar a las actividades del usuario de la sesion sobre si mismo mas solo a las actividades que impliquen con otros usuarios sin embargo no se ha borrado, aunque siempre se puede ver las actividades de un usuario de si mismo , produce problemas inesperados */
		$consulta->execute(array(
			':CodUsua' => $CodUsua
			));
		$resultados = $consulta->fetchAll();
		return $resultados;
		/*Debe existir un INNER JOIN entre POST usando el cod de las notificaciones y la accion 1 o 0 que
		 representan si ha visto o no ha visto el usuario una notificación y el CodPost que representa al 
		 codigo unívoco de cada POST que es una llave foránea para POST de un usuario , necesitamos de la
		  tabla "Usuarios" porque desplegaremos el usuario en cada notificacion*/
	}
	public static function vistas($CodNot)
	{
		/* Se llama a esta función desde header.php. Para actualizar el campo visto de la tabla
		 notificaciones */

		$con = conexion();
		$consulta = $con->prepare("update notificaciones set visto = 1 where CodNot = :CodNot");
		/* CodNot es un  valor unívoco por lo tanto al hacer click en una notificación específica nos 
		aseguramos que se guarde en el campo visto=1 que implica que ya se ha visto, ya que por defecto 
		es 0, estas notificaciones persistirán hasta que se vean */
		$consulta->execute(array(
			':CodNot' => $CodNot
			));
	}
}
class amigos
{
	public static function agregar($usua_enviador, $usua_receptor)
	{
		/* Se llamada desde perfil.php */
		/*Para agregar una solicitud de amistad , $usua_enviador es quien envía la solicitud de amistad y
		 $usua_receptor quien recibe esa solicitud de amistad aplicando unicidad con CodAm , los campos status , solicitud son de tipo bit, asi que el valor sera 0 o 1, el campo "solicitud" indica cuando se ha enviado una solicitud de amistad y "status"  cuando se ha aceptado una solicitud de amistad pero estatus también permite reconocer si un usuario es amigo de otro basado en la unicidad de CodAm , tanto para $usua_enviador, $usua_receptor puesto que no hay como enviar una solicitud a una persona que ya es amigo*/

		$con = conexion();
		$consulta = $con->prepare("insert into amigos(CodAm, usua_enviador, usua_receptor, status, solicitud) values(null, :usua_enviador, :usua_receptor, :status, :solicitud)");
		$consulta->execute(array(
							':usua_enviador' => $usua_enviador,
							':usua_receptor' => $usua_receptor,
							':status' => '',
							':solicitud' => 1

			));
			/* "solicitud"=> 1 para indicar que la solicitud se ha enviado, recordar que es un array
			 asociativo */
	}
	public static function verificar($usua_enviador, $usua_receptor)
	{
		/* Se llama desde perfil.php con amigos::verificar($_SESSION['CodUsua'], $_GET['CodUsua'] ); */
		/*Queremos comprobar si un usuario es amigo de otro usuario asi que cada uno puede entrar en categoría
		 de usuario enviador o receptor indistintamente */
		$con = conexion();
		$consulta = $con->prepare("select * from amigos where (usua_enviador = :usua_enviador and usua_receptor = :usua_receptor) or (usua_enviador = :usua_receptor and usua_receptor = :usua_enviador) ");
		$consulta->execute(array(
							':usua_enviador' => $usua_enviador,
							':usua_receptor' => $usua_receptor,
			));

		$resultados = $consulta->fetchAll();
		return $resultados;	
	/* $_SESSION['CodUsua'] siempre tendrá el código del usuario que esta navegando en el computador 
	nas $_GET['CodUsua'] es una variable que se recibirá cada vez que se llame a perfil.php para procesados 
	por usurio individual con respecto a $_SESSION['CodUsua']*/
	}
	public static function codigos_amigos($CodUsua)
	{
		/* group_concat() nos mostrará los resultados en una sola fila, separados por un argumento sea espacio, coma etc; en este caso por ',' con el objetivo de ser procesados por in($amigos), el in procesa elementos separados por ',' */

		$con = conexion();
		$consulta = $con->prepare(" select group_concat(usua_enviador,',', usua_receptor) as amigos from amigos where (usua_enviador = :CodUsua or usua_receptor = :CodUsua) and status = 1 ");

		/*CodUsua implica a $_SESSION['CodUsua'] por lo que se envía como argumento desde index.php  */
		
		/*  De index.php 
		$amigos = amigos::codigos_amigos($_SESSION['CodUsua']);
		$post = post::mostrarTodo($amigos[0]['amigos']);

		/*$amigos es el array que contiene los resultados de la función codigos_amigos en clase amigos, 
		lo que sucede es que select group_concat(usua_enviador,',', usua_receptor) as amigos , como eso 
		es el SELECT de la consulta efectuada , group_concat retorna un string con los valores No nulos 
		de un grupo pasado como argumento en este caso retorna esa concatenación y son valores numéricos 
		pero son pares de valores separados por ',' , por ello la necesidad de IN que se efectúa en 
		post::mostrarTodo($amigos[0]['amigos']);, en el cual hay evidencia de que en IN se separan por comas 
		los argumentos, tal cual como la variable $amigos: https://www.w3schools.com/sql/sql_in.asp.
        usando group_concat() : https://www.w3resource.com/mysql/aggregate-functions-and-grouping/aggregate-functions-and-grouping-group_concat.php
        */

		$consulta->execute(array(
						':CodUsua' => $CodUsua
			));

		$resultados = $consulta->fetchAll();
		return $resultados;
	}

	public static function solicitudes($CodUsua)
	{
		/* Para mostrar todas las solicitudes de un usuario, 
		A.status != 1 es para las solicitudes que aún no han sido acceptadas que se le han enviado al usuario 
		$CodUsua pasado como parámetro*/
		$con = conexion();
		$consulta = $con->prepare(" select U.CodUsua, U.nombre, A.CodAm from usuarios U inner join amigos A on U.CodUsua = A.usua_enviador where A.usua_receptor = :CodUsua and A.status != 1");
		$consulta->execute(array(
						':CodUsua' => $CodUsua
			));

		$resultados = $consulta->fetchAll();
		return $resultados;
	}

	public static function aceptar($CodAm)
	{
		/* Para aceptar una solicitud de amistad, y con set status = 1 actualizamos el estado en la base 
		de datos para la siguiente vez se reconozca a un usuario que ya sería amigo */
		$con = conexion();
		$consulta = $con->prepare(" update amigos set status = 1 where CodAm = :CodAm");
		$consulta->execute(array(
						':CodAm' => $CodAm
			));
	}

	public static function eliminar_solicitud($CodAm)
	{
		/* Para eliminar una solicitud de amistad , para eliminar ese registro  de una solicitud de $CodAm 
		pasado como parámetro */
		$con = conexion();
		$consulta = $con->prepare("delete from amigos where CodAm = :CodAm");
		$consulta->execute(array(
						':CodAm' => $CodAm
			));
	}

	public static function cantidad_amigos($CodUsua)
	{
		/* Para contabilizar la cantidad de amigos, esta función es llamada desde perfil.php para mostrar 
		ese valor contabilizado */
		$con = conexion();
		$consulta = $con->prepare(" select count(*) from amigos where (usua_enviador = :CodUsua or usua_receptor = :CodUsua) and status = 1 ");
		$consulta->execute(array(
						':CodUsua' => $CodUsua
			));

		$resultados = $consulta->fetchAll();
		return $resultados;
	}
}
?>