<?php 

class usuarios{

	public  static function registrar($datos) 
	{
		$con = conexion(); //llama a la funcion conexion de funciones.php ojo esta en espanol el nombre de esta funcion)
		$consulta = $con->prepare("insert into usuarios(CodUsua, nombre, usuario, pass, pais, profesion, discapacidad, foto_perfil) values(null, :nombre, :usuario, :pass, :pais, :profe, :discapacidad, :foto_perfil)");
		$consulta->execute(array(':nombre' => $datos[0],
								  ':usuario' => $datos[1],
								  ':pass' => $datos[2],
								  ':pais' => $datos[3],
								  ':profe' => $datos[4],
								  ':discapacidad' => $datos[5],
								  ':foto_perfil' => 'img/sin foto de perfil.jpg'
							));
		/*Notar que con prepare se prepara la conexion y con $consulta->execute se ejecuta la consulta con un array asociativo recordando que el parametro $datos en esta funcion registrar contiene un array de todos los datos del formulario de registro del usuario */
	}


	public static function verificar($usuario) //Para verificar si usuario existe
	{
		$con = conexion(); /* Se llama a la funcion "conexion" de funciones.php enviando argumentos usuario y contrasena para acceso a base de datos*/
		$consulta = $con->prepare("select * from usuarios where usuario = :usuario");
		$consulta->execute(array(':usuario' => $usuario)); 
		/*$usuario es el parametro recibido en esta funcion y :usuario es el elemento que con un array asociativo, apunta a $usuario */
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
        /*El valor $CodUsua (siendo un valor int en la base de datos registrada), se recibe como parametro en esta funcion , los indices de los arreglos solo son para correlacionar los elementos del arreglo con los valores de los arrays asociativos sobre la consulta SQL, los $datos deben ser un arreglo en el cual se introduce los valores de nombre, usuario ,profesion, pais,foto_perfil que serian los datos a editar y si no simplemente se han dejado por defecto los campos en los cuales no se ha editado, no necesitamos de ->		$resultado = $consulta->fetchAll();
        porque no retornaremos resultados, pues con header('location: editar_perfil.php'); ya se actualizarian en la pantalla los datos que previsamente fueron actualizados en la base de datos */

		
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
	}


	public static function post_por_usuario($CodUsua)
	{
        /* Para buscar una publicacion por usuario*/
		$con = conexion();
		$consulta = $con->prepare("select U.CodUsua, U.nombre, U.foto_perfil, P.CodPost, P.titulo, P.autor, P.fecha, P.categoria, P.contenido, P.img, P.url from usuarios U inner join post P on U.CodUsua = P.CodUsua where P.CodUsua = :CodUsua ORDER BY P.CodPost DESC limit 10");
        /*P.CodUsua = :CodUsua es necesario, porque si bien codigo SQL inmediato anterior permite hacer una relacion con CodUsua entre las tablas "usuarios" con "post", esto es generico y para todos los registros, para aplicar espacifidad  necesitamos filtrar por el $CodUsua enviado como parametro en esta funcion con repsto a P.CodUsua de Post, recordando la necesidad del INNER JOIN es debido a que necesitamos mas datos de los registros del usuario para llamar a datos como nombre, foto_perfil del usuario y justamente las columnas que se ha seleccionado en SELECT , el ORDER BY P.CodPost DESC implicaera un orden descendente de mayor a menor, si bien no tenemos registrado una fecha, el CodPost esta programado como AUTO-INCREMENT, TODO:por ello los POST mas recientes seran los valores mas altos de CodPost TODO:*/
		$consulta->execute(array(':CodUsua' => $CodUsua));
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	public static function mostrarTodo($amigos)
	{
		/* Funcion para mostrar todas las publicaciones de los amigos del usuario de las sesion, porque en amigos::codigos_amigos($_SESSION['CodUsua']); esta funcion se ejecuta en index.html inmediatamente "antes" de esta funcion mostrarTodo($amigos)  , se envia como parametro $_SESSION['CodUsua']), LUEGO  desde index.php se llama con $post = post::mostrarTodo($amigos[0]['amigos'] al ejecutar esta ultima se puede capturar en publicacion.php el valor retornado con :
		<?php if(!empty($post)): ?>
		<?php foreach($post as $posts): ?>
		;
   		*/
		$con = conexion();
		$consulta = $con->prepare("select U.CodUsua, U.nombre, U.foto_perfil, P.CodPost, P.titulo, P.fecha, P.categoria, P.autor, P.contenido, P.img, P.url from usuarios U inner join post P on U.CodUsua = P.CodUsua where P.CodUsua in($amigos) ORDER BY P.CodPost DESC limit 10");
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
        /* Limitar las ocurrencias implica una optimizacion para rendimiento */
        /*
        Evidencia de que en IN se separan por comas los argumentos, tal cual como la variable $amigos: https://www.w3schools.com/sql/sql_in.asp.
        usando group_concat() : https://www.w3resource.com/mysql/aggregate-functions-and-grouping/aggregate-functions-and-grouping-group_concat.php
        "in" nos devolveria todos los registros de los elementos de la consulta de $amigos = amigos::codigos_amigos($_SESSION['CodUsua']) que como sabemos implica a (" select group_concat(usua_enviador,',', usua_receptor) as amigos from amigos where (usua_enviador = :CodUsua or usua_receptor = :CodUsua) and status = 1 "); , lo que sucede en post::mostrarTodo($amigos); es que $amigos a mas de la consulta SQL efectuada con la seleccion de    select group_concat(usua_enviador,',', usua_receptor) as amigos nos filtra esos valores separados por ",", que justamente el "in" procesa distintas variables separadas por coma   ,
        LA IMPORTANCIA DE USAR LA VARIABLE $amigo y NO un array asociativo, es porque al usar la variable $amigos y NO :amigos es  nos aseguramos que se reconoceran valores enteros devido a los pares usua_enviador, usua_receptor que los tenemos devido a $amigos = amigos::codigos_amigos($_SESSION['CodUsua']);*/
	}
	public static function mostrarTodo_busqueda($buscar){
		$con = conexion();
		$consulta = $con->prepare("select U.CodUsua, U.nombre, U.foto_perfil, P.CodPost, P.titulo, P.autor, P.fecha, P.categoria,P.contenido, P.img, P.url from usuarios U inner join post P on U.CodUsua = P.CodUsua where P.titulo like :buscar or P.categoria like :buscar or U.nombre like :buscar or P.autor like :buscar  ORDER BY P.CodPost DESC");
		$consulta->execute(array(':buscar' => "%$buscar%"));
		$resultado = $consulta->fetchAll();
		return $resultado;
		/* Cada uno de las potenciales busquedas van en funcion del argumento $buscar ya sea por el titulo, categoria, o nombre u autor todo esto llamado desde index.php y anteriormente desde buscar.php */

	}

	public static function mostrar_por_codigo_post($CodPost)
	{
		$con = conexion();
		$consulta = $con->prepare("select U.CodUsua, U.nombre, U.foto_perfil, P.CodPost, P.titulo, P.autor, P.fecha, P.categoria,P.contenido, P.img, P.url from usuarios U inner join post P on U.CodUsua = P.CodUsua where P.CodPost = :CodPost ORDER BY P.CodPost DESC");
		$consulta->execute(array(':CodPost' => $CodPost));
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


}


class comentarios{

	public static function agregar($comentario, $CodUsua, $CodPost)
	{
		/* El objetico de esta funcion es agregar los comentarios a la base de datos, esto se lo hcae desde index.php desde comentarios::agregar($_POST['comentario'], $_SESSION['CodUsua'], $_POST['CodPost']);, no retornamos valores, porque en las siguiente instruccion   notificaciones::agregar(1, $_POST['CodPost'], $_SESSION['CodUsua']); lo que hacemos es registrar la notifcacion y esto es gracias a 
		header('location: index.php'); que recargara la pagina para hacer visibles las notificaciones actualziadas */
		$con = conexion();
		$consulta = $con->prepare("insert into comentarios(comentario, CodUsua, CodPost) values(:comentario, :CodUsua, :CodPost) ");
		$consulta->execute(array(
					':comentario' => $comentario,
					':CodUsua' => $CodUsua,
					':CodPost' => $CodPost

					));
	}


	public static function mostrar($CodPost)
	{
		$con = conexion();
		$consulta = $con->prepare("select U.nombre, C.comentario, C.CodCom from usuarios U inner join comentarios C on U.CodUsua = C.CodUsua where C.CodPost = :CodPost ORDER BY C.CodCom ASC") ;
		$consulta->execute(array(':CodPost' => $CodPost));
		$resultado = $consulta->fetchAll();
		return $resultado;
		/* TODO: SE HA ARREGLADO ,es importante el ORDER BY, para justamente ir ordenando las publicaciones por el Codigo de comentario que es univoco y es autoincrement, como en publicaciones.php , el comentario involucra a un codPost especifico y cada uno tiene varios comentarios (los procesados en esta funcion), solo basta ordenar los comentarios en base a CodCom en el cual cada registro de la consulta SQL  tienen asociado un nombre y el contenido de ese comentario  */
		
	}
	

}



class mg
{
	public static function agregar($CodPost, $CodUsua)
	{
		/*Desde perfil.php se llama a esta funcion ;    mg::agregar($_GET['CodPost'], $_SESSION['CodUsua']); con la finalidad de que en esta funcion los parametros recibidos INSERTEN un registro para el "me gusta" */
		$con = conexion();
		$consulta = $con->prepare("insert into mg(CodLike, CodPost, CodUsua) values(null, :CodPost, :CodUsua)");
		$consulta->execute(array(':CodPost' => $CodPost, ':CodUsua' => $CodUsua));
	}
	/*function borrar($CodLike)
	{
		Desde perfil.php se llama a esta funcion ;    mg::agregar($_GET['CodPost'], $_SESSION['CodUsua']); con la finalidad de que en esta funcion los parametros recibidos INSERTEN un registro para el "me gusta"
        
		$con = conexion("root", "");
		$consulta = $con->prepare("delete from mg where CodLike in($CodLike)");
		$consulta->execute();
	} 
    */



	public static function mostrar($CodPost)
	{
		/* Para contar la cantidad de mg , desde la clase publicacion.php se llama con mg::mostrar($posts['CodPost'])[0][0]* , /* Es IMPORTANTE TODO: agregar [0][0] para conformar $posts['CodPost'])[0][0], de lo contrario nos dara un error de conversion de array a String, la consulta SQL :  "select count(*) from mg where CodPost = :CodPost"*/
		$con = conexion();
		$consulta = $con->prepare("select count(*) from mg where CodPost = :CodPost");
		$consulta->execute(array(':CodPost' => $CodPost));
		$resultados = $consulta->fetchAll();
		return $resultados;
		/* Tabla mg tiene las columnas 	CodLike	CodPost	CodUsua, donde la llave primaria es CodLike */
	}


	public static function verificar_mg($CodPost, $CodUsua)
	{
		/*Para verificar si un usuario ya ha dado megusta a una publicacion, retornara el conteo (count) de los resultados, NO NOS INTERESA el cuantos me gusta, solo si hay por lo menos un me gusta. $CodUsua como parametro contiene $_SESSION['CodUsua'] <?php if(mg::verificar_mg($posts['CodPost'], $_SESSION['CodUsua']) == 0): ?>
		<a href="<?php echo $_SERVER['PHP_SELF'] ?>?mg=1&&CodPost=<?php echo $posts['CodPost'] ?>" class="like icon-checkmark2"></a>
		<?php /* mg=1 implica que hay cero me gusta por parte del usuario puede existir muchos me gustas, pero NOS ESTAMOS ENFOCANDO EN EL USUARIO DE SESION, en este caso, el icono tendra un contorno de visto vacio si no ha puesto me gusta( lo mas comun), y si ha puesto me gusta se mostrara un icono con un contorno completo con la siguiente seccion de codigo de publicacion.php
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
		/* Para contar la cantidad de denuncias sobre una publicacion , desde la clase publicacion.php se llama con denuncias::mostrar($posts['CodPost'])[0][0]* , /* Es IMPORTANTE TODO: agregar [0][0] para conformar $posts['CodPost'])[0][0], de lo contrario nos dara un error de conversion de array a String, la consulta SQL :  "select count(*) from mg where CodPost = :CodPost"*/
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
		/*Desde perfil.php se llama a esta funcion ;    denuncias::agregar($_GET['CodPost'], $_SESSION['CodUsua']); con la finalidad de que en esta funcion los parametros recibidos INSERTEN un registro para la deduncia */
		$con = conexion();
		$consulta = $con->prepare("insert into denuncia(CodDen, CodPost, CodUsua) values(null, :CodPost, :CodUsua)");
		$consulta->execute(array(':CodPost' => $CodPost, ':CodUsua' => $CodUsua));
	}
}



class notificaciones
{
	/* En perfil.php en los condicionales que comprueban si if(isset($_POST['comentario'])) y despues  if(isset($_GET['mg'])) , la accion implica que un usuario puede dar me gusta o tambien puede comentar una publicacion en perfil.php se controla con los condicionales comprobando en ellos si existe un comentario o en el caso de si ha sido presionado el "me gusta"(icono de visto)*/

	public static function agregar($accion, $CodPost, $CodUsua)
	{ /* desde index.php debido al "comentario" de un usuario desde publicacion.php, se llama a esta funcion con notificaciones::agregar(1, $_POST['CodPost'], $_SESSION['CodUsua']); */
		/* "visto" es para saber si un usuario ya ha visto una notificacion , valores 1 o 0, 1 para notificacion de comentarios, 0 en el caso de me gusta */
		$con = conexion();
		$consulta = $con->prepare("insert into notificaciones(CodNot, accion, CodPost, CodUsua, visto) values(null, :accion, :CodPost, :CodUsua, 0)");

		/*El valor 0 indica que un usuario aun no ha visto una notificacion que posteriormente se registrara */
		
		$consulta->execute(array(
			':accion' => $accion, 
			':CodPost' => $CodPost, 
			':CodUsua' => $CodUsua
			));
	}


	public static function mostrar($CodUsua)
	{
		/* desde header.php con la instruccion $not = notificaciones::mostrar($_SESSION['CodUsua']) */
		/*Para mostrar las notificaciones de un usuario pero no sobre las actividades sobre si mismo */
		$con = conexion();
		$consulta = $con->prepare("select U.CodUsua, U.nombre, N.CodNot, N.accion, N.CodPost from notificaciones N inner join usuarios U on U.CodUsua = N.CodUsua where N.CodPost in(select CodPost from post where CodUsua = :CodUsua) and N.visto = 0 and N.CodUsua != :CodUsua");
		/*Sentencia "on", para indicar los campos relacionados, la instruccion N.CodUsua != :CodUsua es necesaria porque una notificacion no debe implicar a las actividades del usuario de la sesion sobre si mismo mas solo a las actividades que impliquen con otros usuarios SIN EMBARGO No le  HE BORRADO, aunque siempre se puede ver las actividades de un usuario a si mismo , produce problemas inesperados */
		$consulta->execute(array(
			':CodUsua' => $CodUsua
			));
		$resultados = $consulta->fetchAll();
		return $resultados;
        /*debe existir un INNER JOIN entre POST usando el cod de las notificaciones y la accion 1 o 0 que reresentan si ha visto o no ha visto el usuario una notificacion y el CodPost que representa al codigo univoco de cada POST que es una llave foranea para POST de un usuario , necesitamos de la tabla USUARIOS porque desplegaremos el usuario en cada notificacion*/

	}

	public static function vistas($CodNot)
	{
		/* Se llama a esta funcion desde header.php. Para actualizar el campo visto de la tabla notificaciones */

		$con = conexion();
		$consulta = $con->prepare("update notificaciones set visto = 1 where CodNot = :CodNot");
		/* CodNot es u  valor univoco por lo tanto al hacer click en una notificacion especifica nos aseguramos que se guarde en el campo visto=1 que implica que ya se ha visto, ya que por defecto es 0, estas notificaciones persistiran hasta que se vean */
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
		/*Para agregar una solicitud de amistad , $usua_enviador es quien envia la solicitud de amistad y $usua_receptor quien recibe esa solicitud de amistad aplicando unicidad con CodAm , los campos status , solicitud son de tipo bit, asi que el valor sera 0 o 1, el campo "solicitud" indica cuando se ha enviado una solicitud de amistad y "status"  cuando se ha aceptado una solicitud de amistad pero estatus tambien permite reconocer si un usuario es amigo de otro basado en la unicidad de CodAm , tanto para $usua_enviador, $usua_receptor puesto que no hay como enviar una solicitud a una persona que ya es amigo*/

		$con = conexion();
		$consulta = $con->prepare("insert into amigos(CodAm, usua_enviador, usua_receptor, status, solicitud) values(null, :usua_enviador, :usua_receptor, :status, :solicitud)");
		$consulta->execute(array(
							':usua_enviador' => $usua_enviador,
							':usua_receptor' => $usua_receptor,
							':status' => '',
							':solicitud' => 1

			));
			/* "solicitud"=> 1 para indicar que la solicitud se ha enviado, recordar que es un array asociativo */
	}

	public static function verificar($usua_enviador, $usua_receptor)
	{
		/* Se llama desde perfil.php con amigos::verificar($_SESSION['CodUsua'], $_GET['CodUsua'] ); */
		/*Queremos comprobar si un usuario es amigo de otro usuario asi que cada uno puede entrar en categoria de usuario enviador o receptor indistintamente */
		$con = conexion();
		$consulta = $con->prepare("select * from amigos where (usua_enviador = :usua_enviador and usua_receptor = :usua_receptor) or (usua_enviador = :usua_receptor and usua_receptor = :usua_enviador) ");
		$consulta->execute(array(
							':usua_enviador' => $usua_enviador,
							':usua_receptor' => $usua_receptor,
				

			));

		$resultados = $consulta->fetchAll();
		return $resultados;
		
	/* $_SESSION['CodUsua'] siempre tendra el codigo del usuario que esta navegando en el computador nas $_GET['CodUsua'] es una variable que se recibira cada vez que se llame a perfil.php para procesados por usurio individual con respecto a $_SESSION['CodUsua']*/
	}

	public static function codigos_amigos($CodUsua)
	{
		/* group_concat() nos mostrara los resultados en una sola fila, separados por un argumento sea espacio, coma etc; en este caso por ',' con el objetivo de ser procesados por in($amigos), el in procesa elementos separados por ',' */

		$con = conexion();
		$consulta = $con->prepare(" select group_concat(usua_enviador,',', usua_receptor) as amigos from amigos where (usua_enviador = :CodUsua or usua_receptor = :CodUsua) and status = 1 ");

		/*CodUsua implica a $_SESSION['CodUsua'] por lo que se envia como argumento desde index.php veo que tanto el usuario que tanto los comentarios de los usuarios receptores como los usuarios que envian el sms , son todos estos los que deben */
		
		/*  de index.php  TODO:
		$amigos = amigos::codigos_amigos($_SESSION['CodUsua']);
		$post = post::mostrarTodo($amigos[0]['amigos']);

        /*$amigos es el array que contiene los resultados de la funcion codigos_amigos en clase amigos, lo que sucede es que select group_concat(usua_enviador,',', usua_receptor) as amigos , como eso es el SELECT de la consulta efectuada , group_concat retorna un string con los valores No nulos de un grupo pasado como argumento en este caso retorna esa concatenacion y son valores numericos pero son pares de valores separados por ',' , por ello la ncesidad de IN que se efectua en post::mostrarTodo($amigos[0]['amigos']);, en el cual
        Evidencia de que en IN se separan por comas los argumentos, tal cual como la variable $amigos: https://www.w3schools.com/sql/sql_in.asp.
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
		A.status != 1 es para las solicitudes que aun NO han sido acceptadas que se le han enviado al usuario $CodUsua pasado como parametro*/
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
		/* Para aceptar una solicitud de amistad, y con set status = 1 actualizamos el estado en la base de datos para la siguiente vez se reconozca a un usuario que ya seria amigo */
		$con = conexion();
		$consulta = $con->prepare(" update amigos set status = 1 where CodAm = :CodAm");
		$consulta->execute(array(
						':CodAm' => $CodAm
			));
	}

	public static function eliminar_solicitud($CodAm)
	{
		/* Para eliminar una solicitud de amistad , para eliminar ese registro  de una solicitud de $CodAm pasado como parametro */
		$con = conexion();
		$consulta = $con->prepare("delete from amigos where CodAm = :CodAm");
		$consulta->execute(array(
						':CodAm' => $CodAm
			));
	}

	public static function cantidad_amigos($CodUsua)
	{
		/* Para contabilizar la cantidad de amigos, esta funcion es llamada desde perfil.php para mostrar ese valor contabilizado */
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