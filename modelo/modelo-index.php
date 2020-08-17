<?php
 ob_start();/* Un error importante en las caeceras header, solucionado  con esta instrucción y su similar al final, he usado convet to UTF-8*/
	session_start();
	require('funciones/funciones.php');
	require('clases/clases.php');
	verificar_session(); /* Si el usuario esta registrado de lo contrario se retornará a login.php */
	/*
		TODO: SEGURIDAD : desde un inicio ya verificamos con esta función si existe una sesión actual
		de un usuario, caso contrario se moviliza a login.php , esto implica seguridad para que usuarios 
		no autorizados no puedan acceder.
		Cuando cargamos el index.php siempre necesitaremos que se cargue la cabecera y la sección para subir
		 contenido, eso se lo hace con require.php y subir.php y al finalizar este archivo index.php, 
		 utilizamos un require('publicacion.php'); para invocar a todas las publicaciones justo antes 
		 de subir un contenido , al subir contenido se le devuelve el control a index.php para recargar 
		 la página y actualizar  las publicaciones junto a la nueva.
	*/
	require('header.php');
	/*
		Require código html de cabecera, pero este código no finaliza el documento html, así que continua 
		inmediatamente después con subir.php
	*/
	require('subir.php');
	/*
        Después de que se ejecuta subir.php(implica subir contenido incluyendo texto y archivo) se le devuelve
         el control a index.php

		Cuando se ha enviado el formulario del header.php nos vamos a buscar.php, el orden es el siguiente :
        1. header.php (a partir de ahí como nos encontramos en la cabecera, podemos o bien dirigirnos a  ver 
        perfil con lo cual pefil.php completaría el </body></html> y o bien si queremos confirmar una 
        solicitud.php de contacto nos seguimos quedando en el header por lo que ese archivo solicitud.php 
        se ejecuta y le devuelve el control a header.php, también podemos ir a post.php o a cerrar.php , 
        desde perfil.php(que puede cerrar el body y el documento html) la antepenúltima línea  del código
         se require publicacion.php con el objetivo de cargar todas las publicaciones del usuario, pero si 
         nos seguimos quedando en el header y no hemos tomado la decisión de ver nuestro perfil aún, lo que 
         podemos hacer también)
	*/
	tiempo_sesion_mensaje();

	if(isset($_POST['publicar']) and !empty($_POST['titulo']))
	{
		/*
            Este condicional siempre se ejecuta independientemente si se suben o no archivos, así que 
            !empty($_FILES) nunca esta vacia o esta incorrectamente procesada prueba de ello es el directorio 
            "/subidos" presente en todas las publicaciones en la base de datos
		*/
		if(!empty($_FILES)){
			$destino = 'subidos/';
			$destino_archivo_generico = 'img/';
			$archivoSinConf=$_FILES['archivo']['name'];
			$img = $destino . $_FILES['archivo']['name'];
			$tipo=explode('.', $archivoSinConf);
			$tipo1 = end($tipo);
			$url="";
			if($tipo1 == 'jpg' || $tipo1 == 'JPG' || $tipo1 == 'png' || $tipo1 == 'PNG')
			{
				//	move_uploaded_file($tmp, $destino . $nuevo .'.'.$tipo);
				/*
                    existen 3 posibilidades, que se trate de una imagen, que se trate de un archivo o que 
                    se trate de una publicación sin haber subido documentos adjuntos
				*/
				$img = $destino . $_FILES['archivo']['name'];
				$url=$img;
			}
			else {
				if($archivoSinConf!==""){
					/*
                        si $_FILES['archivo']['name']; esta vacío, por ejm al concatenar con "destino", 
                        ese $_FILES['archivo']['name']; nos retorna "", una cadena vacía, por ello se lo comparo con "" más no con NULL
					*/
					$url = $destino . $_FILES['archivo']['name'];
					$img = $destino_archivo_generico.'no_imagen.jpg';
				}else{
					$url=null;
					$img=null;
				}
			}
			$tmp = $_FILES['archivo']['tmp_name'];
		}
		$titulo = $_POST['titulo'];		
		$autor=empty($_POST['autor'])?$_SESSION['nombre']:$_POST['autor'];
		$fecha = fechaPost();
		$categoria=$_POST['categoria'];
		$contenido="";
		$contInt="";
		$cont_temp1=""; /* Contenido temporal del último índice del post, para $value4 */
		$cont_temp2="";
		$cont_temp3="";
		$cont_tempX="";
		$cont_pagina="false";

		if(!empty($_POST['subir_cont'])){
			foreach ($_POST['subir_cont'] as $clave1 => $value1) {
				if($clave1==="introduccion")
					$clave1="introducción";
				$contenido.="<hr><br><strong><center>".ucfirst($clave1)."</center></strong><br>";
				foreach ($value1 as $clave2 => $value2) {
					$contInt.="<br>";	/* Salto de línea para siguiente párrafo */
					foreach ($value2 as $clave3 => $value3) {
						foreach($value3 as $clave4 => $value4){
							if($value4!=null){
								
								if($clave4==='parrafo')
									$contInt.=$value4." ";

								if($clave4==='apellido'){
									if($clave4==='apellido')
										$cont_temp1=" ( ".$value4.", ";							
								}
								if($clave4==='anio'){
									$cont_temp2=$value4." ) ";
									$cont_tempX=$value4;
								}						
								if($clave4==='pagina'){
									$cont_temp3=$cont_tempX.":".$value4.")";
									$cont_pagina="true";
								}								
							}	
					}					
				}
				if($cont_pagina==="true"){
					$contInt.=$cont_temp1.$cont_temp3;
				}else{
					$contInt.=$cont_temp1.$cont_temp2;

				}
				$cont_temp1=""; 
				$cont_temp2="";
				$cont_temp3="";
				$cont_tempX="";
				$cont_pagina="false";
				$contenido.="<justify>".$contInt."</justify>";
				$contInt="";
				}
		
			}
			if(!empty($_POST['alt'])){
				$contenido.="<br>"."Descripción de archivo adjunto: "."<br>".$_POST['alt'];
			}
		}
		post::agregar($_SESSION['CodUsua'], $titulo, $autor, $fecha, $categoria, $contenido, $img, $url);
		move_uploaded_file($tmp, $url);
		/*
            $tmp  contiene el nombre temporal y la localidad temporal, $url contiene la nueva localidad y 
            el nombre del archivo hacia donde queremos que se mueva el archivo
		*/
		/*
            TODO: header('location: index.php') TODO:es para que no se vuelva a subir la publicación y 
            carguemos nuevamente index.php, recordar que lo primero que lee este archivo index.php son  
            las funciones, las clases y los los "require" tanto el header.php y subir.php, como no se
             establecerá este condicional de "subir contenidos ,archivos", simplemente se cargarán después 
             de lo anterior dicho, las publicaciones con require('publicacion.php');
			
            TODO: (IMPORTANTE ) TODO: Si ya publicamos con subir.php, que no tiene una finalización de 
            código html, nos movemos a este condicional, y como ya hemos subido contenido nos 
            movemos(obligadamente a más de subir un archivo(foto) debemos subir contenido o una potencial 
            descripcion), retornamos y recargamos index.php con header('location: index.php');para actualizar 
            la nueva publicación , luego esas variables $_POST['publicar'], $_FILES y $_POST['contenido' 
            estarín vacías y al recargar con header('location: index.php'); por lo que tanto en un inicio 
            como despues de una publicación estas variables quedan vacías y solo se guardan en la base de 
            datos para invocarlas cuando sean necesarias y luego  seguir a las siguientes líneas de código
             de index.php que finaliza el código con require('publicacion.php'); seguido de </body></html>
		*/
		header('location: index.php');
	}
	$amigos = amigos::codigos_amigos($_SESSION['CodUsua']);
	if(!empty($_GET['buscar'])){
		$post = post::mostrarTodo_busqueda($_GET['buscar']);
		$_SESSION['mensaje']="Tu búsqueda por título o por categoría se ha realizado con éxito";
		$_SESSION['tiempo'] = time();		
	}else{
		$post = post::mostrarTodo($amigos[0]['amigos'], $_SESSION['CodUsua']);
	}
	/*
        $_GET['buscar'], se recibe desde buscar.php, con el objetivo de filtrar las busquedas basadas 
        en el contenido
        Este condicional nos garantiza que si no estamos buscando , estamos mostrando todas las publicaciones
         de los amigos y de si mismo del usuario de sesión

        La función mostrarTodo($amigos[0]['amigos']); nos permitíra mostrar todas las publicaciones, [0] 
        es la tabla 0, porque solo tenemos 1 tabla en esta consulta
        recordar que select group_concat(usua_enviador,',', usua_receptor) as amigos exactamente COMO AMIGOS,
        por ello se carga ese indice en ($amigos[0]['amigos']), por	que ese ['amigos'] contiene todos los
        group_concat(usua_enviador,',', usua_receptor) así que una cosa es $amigos al que se le asigna con 
        la consulta $amigos=amigos::codigos_amigos($_SESSION['CodUsua']); y otra cosa es ['amigos']  que
        conforma $amigos[0]['amigos']), el 'amigos' el que hace referencia a group_concat
        (usua_enviador,',', usua_receptor) as amigos el que se retorna en 
        amigos::codigos_amigos($_SESSION['CodUsua']);
	*/
	if(isset($_POST['comentario']))
	{
		/*
			Importante: if(!empty($_POST['comentario'])) implica que aunque enfoquemos la sección de comentarios y tratemos de enviar un comentario "vacío", el condicional mencionado es para que SOLO cuando ese comentario no este vacio se pueda registrar en la base de datos y generar una notificacion
			TODO:En publicacion.php hay<input type="text" name="comentario" placeholder="Escribe un comentario">, entonces desde el formulario, el usuario al momento de escribir y al efectuar ese comentario, es en dónde se invoca (concordando con sección de código de require('publicacion.php'); que es el ultimo "require" de este archivo index.html, entonces al enviar este formulario en publicacion.php, podemos capturar la variable $_POST['comentario']) para agregar los comentarios a la base de datos y procesar las notificaciones y luego con header('location: index.php'); recargamos la página para establecer los cambios efectuados.
		
			esta instruccion <a href="<?php echo $_SERVER['PHP_SELF'] ?>?mg=1&&CodPost=
			<?php echo $posts['CodPost'] ?>" al parecer llamamos a $_GET['CodPost'] y tenemos por un lado un $_GET['CodPost'] y por
			otro un $_POST['CodPost'] en index.php
		*/
		if(!empty($_POST['comentario']))
		{
			comentarios::agregar($_POST['comentario'], $_SESSION['CodUsua'], $_POST['CodPost']);
			notificaciones::agregar(1, $_POST['CodPost'], $_SESSION['CodUsua']);
			header('location: index.php');
		/*
			TODO: el primer algumento de notificaciones::agregar(1,... implica que se ha comentado y enviamos ese valor "1" como
			un valor clave para indicar el envio de una notificación, recordar que $_POST['CodPost']) es un imput de tipo hidden
			para que al momento de escribir y enviar este pequeño formulario desde publicacion.php se envíe en segundo plano debido
			a <input type="hidden" name="CodPost" value="<?php echo $posts['CodPost'] ?>"> 
		*/
		}
	}

	if(isset($_GET['mg']))
	{
		/*
			El valor recibido por mg con 0 implica que un usuario no ha seleccionado el OK(me gusta), y el 2 implica que es ya se
			ha seleccionado Ok, y es evidente que no se debe registrar mas de 1 OK por publicacion
			TODO: He sustituido "false" por 0, nos da exactamente el mismo resultado, porque los valores de la columna "acción" que
			son valores 0 o 1 procesados en notificaciones::agregar , registran la notificación hasta que el usuario la vea
		*/
		if($_GET['mg']==0){
			mg::agregar($_GET['CodPost'], $_SESSION['CodUsua']);

			/*
				En la función agregar de clase mg es en dónde se insertarán los me gusta efectuados en publicacion.php para luego en
				notificaciones::agregar registrar la notificación, perfil si ya se ha puesto me gusta, no pasaremos por este condicional
				más sera por ==2. En mg::agregar se procesa SQL de "insert into mg(CodLike, CodPost, CodUsua) values(null, :CodPost,
				:CodUsua)"); 
			*/
			notificaciones::agregar(false, $_GET['CodPost'], $_SESSION['CodUsua']);
			header('location: index.php');
			/*
				false, es un valor que da lo mismo poner 0 para el argumento que se recibirá como parámetro sobre $accion (0 implica
				que es necesario establecer una notificación). En notificaciones::agregar function agregar($accion, $CodPost, $CodUsua)
				, se invoca a la consulta SQL con "insert into notificaciones(CodNot, accion, CodPost, CodUsua, visto) values(null,
				:accion, :CodPost, :CodUsua, 0)");
			*/
		}
		if($_GET['mg']==2){
		}
	}
	if(isset($_GET['denuncia']))
	{
		if($_GET['denuncia']==0){
			denuncias::agregar($_GET['CodPost'], $_SESSION['CodUsua']);
			header('location: index.php');
		}
		if($_GET['denuncia']==2){
		}
	}
	require('publicacion.php');
?>
<?php
  ob_end_flush() /* ;Para evitar problemas de header, existe un controlador de flujo también al inicio del código de este archivo */
 ?>