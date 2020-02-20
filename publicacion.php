<section>
    <?php if(!empty($post)): ?>
    <?php 
        /* 
            En index.php en $post = post::mostrarTodo($amigos[0]['amigos']); es en dónde se inicializa esta variable recordando que desde el mismo index.php $amigos = amigos::codigos_amigos($_SESSION['CodUsua']); en el cual se retorná select group_concat(usua_enviador,',', usua_receptor) as amigos así que de ahí se inicializa ['amigos'], y en ta tabla 0(pues es la única tabla) porque en la página principal se mostrará todos los post de los amigos o colaboradores  
        */
        /* 
            TODO: A diferencia de editar_perfil.php con $post = post::post_por_usuario($_GET['CodUsua']); (inicializando y asignando un valor a $post desde perfil.php), aqui  usamos un foreach que apunta al array en este caso $post, cuando usamos una función y procesamos fetchall(), lo que sucede es que lo convierte en un array bidimensional asociativo que apunta a la tabla[0] y el segundo índice contiene las columnas, ejm "select * from usuarios where CodUsua = :CodUsua", y el valor es justamente cada una de las columnas  select*, pero aqui en $post usamos un $posts lo cual en cada iteración en la que no necesitamos especificar esa tabla[0] pues ya esta explícito y se asigna sobre $posts 
        */
        ?>


    <button class="" value="<?php echo count($post); ?>">Cantidad de post =<?php echo count($post); ?></button>

    <?php foreach($post as $clave=>$posts): ?>
    <?php if($clave<count($post)):?>
    <article class="publicacion">
    <label for="<?php echo 'speech_post'.$clave; ?>" onclick="reproducir_contenido(<?php echo $clave; ?>)"><strong>Publicación <?php echo $clave+1; ?>📢</strong></label>

	<p class="speech-post" style="display:none;" id="<?php echo "speech_post".$clave; ?>"></p>
        <div class="publi-info-perfil">
            <table>
                <tr>
                    <td><a href="#"><img src="<?php echo $posts['foto_perfil']; ?>" alt="Foto de perfil de: <?php echo $posts['nombre']; ?>"
                                class="publi-img-perfil"></a></td>
                    <td><a href="perfil.php?CodUsua=<?php echo $posts['CodUsua']; ?>" class="nombre-usuario">
                            <?php echo $posts['nombre']; ?></a></td>
                </tr>
            </table>
            <div name="mostrandoNumero"></div>
        </div>
        <div class="publi-contenido">
            <?php
            /*
                $posts['contenido']; es la parte del contenido de una publicación específica, cargando todos los elementos, pero existe una sección  de contenidos y otra que es los archivos(puede ser una imagen o un documento)
            */
            ?>
            <div id="<?php echo 'textos'.$clave; ?>">

                <p>
                    <?php echo "<center><h1>".$posts['titulo']."</h1></center><hr>"."Autor: ". $posts['autor']."<hr>"."Fecha: ".$posts['fecha']."<hr>Categoría: ".$posts['categoria']."<hr>"; ?>

                    <input type="hidden" name="cabecera_de_post_oculto_sin_caracteres_de_formato_html" value="<?php
                 echo ('Título '.$posts['titulo'].'Autor ' . $posts['autor'].'Fecha '.$posts['fecha']).'Categoría'.$posts['categoria']; ?>">

                </p>
                <button class="boton" onclick="mostrar_contenido(<?php echo $clave; ?>)">Mostrar todo</button>
                <?php 
                /* 
                    <!--input type="hidden  (en este caso al presionar enter), lo que sucede es que esta variable a manera de botón se envía (junto con las otras variables con sus respectivos valores)y se ejecutará como un hilo de la publicación  ejm : https://www.w3schools.com/tags/que tryit.asp?filename=tryhtml5_input_type_hidden  --> 
                */
                ?>
                <input type="hidden" name="contenido_oculto" value="<?php
                 echo $posts['contenido']; ?>">
                 
                 <input type="hidden" name="contenido_oculto_sin_caracteres_de_formato_html" value="<?php
                 echo strip_tags($posts['contenido'],' '); ?>">

                <div name="mostrando_contenidos"></div>

            </div>
        </div>
        <?php if(!empty($posts['img'])): ?>
            <?php $archivo="Archivo adjunto de publicación"?>
        <?php else: ?>
            <?php $archivo=""?>
        <?php endif;?>
        <div class="publi-thumb" style="display:none;"><a href="<?php echo $posts['url']; ?>"><img src="<?php echo $posts['img']; ?>" alt="<?php echo $archivo ?>"></a></div>
        <p class="conteo-like">
            <?php echo mg::mostrar($posts['CodPost'])[0][0]; ?> OK
        </p>
        <hr>

        <p class="conteo-denuncia">
            <?php echo denuncias::mostrar($posts['CodPost'])[0][0]; ?> Denuncias
        </p>
        <hr>
            <?php
            /* 
                mg es la cantidad de me gusta, que les interesa o que les parece OK.
                Se lo va a hacer directamente sin utilizar una variable que contenga los resultados, el primer [0] es la tabla cero, el segundo [0] es el nombre del campo, pero en este caso 0 porque nos va a retornar un solo campo, esta funcion mg::mostrar.
                Es importante:  [0][0] para conformar $posts['CodPost'])[0][0], de lo contrario nos dara un error de conversion de array a String, la consulta SQL :  "select count(*) from mg where CodPost = :CodPost"
            */
                ?>
            <?php
            /*
                Se envia $posts['CodPost'] como argumento en la clase comentarios en su función mostrar, para seleccionar el nombre y comentario y array asociativo ,  de la consulta SQL :  "select U.nombre, C.comentario from usuarios U inner join comentarios C on U.CodUsua = C.CodUsua where C.CodPost = :CodPost") 
            */ 
            ?>
        <div name="mostrar_comentarios" style="display:none;">
            <?php $comentario = comentarios::mostrar($posts['CodPost']); ?>
                <?php 
                /* 
                    A diferencia de mg::mostrar que retornaba un conteo de los me gusta, aquí en cambio con comentarios::mostrar, aquí es en la sección de "comentarios"(en la parte inferior de una publicación),se mostrará "select U.nombre, C.comentario, C.CodCom from usuarios U inner join comentarios C on U.CodUsua = C.CodUsua where C.CodPost = :CodPost ORDER BY C.CodCom ASC")
                */ 
                ?>
            <?php $comen_acum="";$acum_c=""; ?>
            <?php if(!empty($comentario)): ?>
            <?php foreach($comentario as $c): ?>
            <p class="comentario-nombre">
                <?php echo $c['nombre']; $acum_c= $c['nombre']." " ?><span class="comentarios">
                    <?php echo $c['comentario'];$acum_c.= $c['comentario']." "  ?></span>
                <hr>
            </p>
            <?php $comen_acum.=$acum_c.'. '; ?>
            <?php endforeach; ?>
            <?php endif; ?>
            <input type="hidden" name="comentarios-acumulados" value="<?php
                 				echo strip_tags(empty($comen_acum)||$comen_acum===""?"No existen comentarios para esta publicación":$comen_acum); ?>">
        </div>
        <div class="publi-contene-like">
                <?php 
                /* 
                    mg::verificar_mg($posts['CodPost'], $_SESSION['CodUsua']) , función verificar en clase mg tiene el objetivo de comprobar si un usuario de la SESSION ya ha dado me gusta a una publicación por ello el condicional compara con ==0 
                */ 
                ?>
            <?php 
             if(mg::verificar_mg($posts['CodPost'], $_SESSION['CodUsua']) == 0): ?>
            <a class="enlace-boton-ok" id="<?php echo 'elementoOk'.$clave; ?>" href="<?php echo $_SERVER['PHP_SELF'] ?>?mg=0&&CodPost=<?php echo $posts['CodPost'] ?>" class="sin-ok">✔️ OK</a>
                <?php 
                /* 
                    el condicional retornará cero si no hay alguien que ha dado me gusta a una publicación mg=1 implica que hay cero me gustas por parte del usuario puede existir muchos me gustas, pero nos estamos enfocando en el usuario de sesión, en este caso, el ícono tendrá un contorno de visto vacío si no ha puesto me gusta, y si ha puesto me gusta se mostrará un ícono con un contorno completo, mucho ojo, no vamos a retornar valores, solo a llamar a distintos íconos por true o por false; el condicional compara ==0 si hay me gustas(CodLike) del usuario de sessión sobre un POST específico gracias al foreach de publicacion.php podemos iterar valores especificos de $post as $posts 
                */ ?>
            <?php else: ?>
            <?php /* class="like icon-checkmark2"> implica a una clase llamada like y otra llamada icon-checkmark2 para el ícono*/ ?>
            <a class="enlace-boton-ok" id="<?php echo 'elementoOk'.$clave; ?>" href="<?php echo $_SERVER['PHP_SELF'] ?>?mg=2&&CodPost=<?php echo $posts['CodPost'] ?>" class="con-ok">✅OK</a>
            <?php endif; ?>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="comentario" method="post">
                <label for="<?php echo 'comentario'.$clave; ?>">Comentario:</label>

                <input type="text" id= "<?php echo 'comentario'.$clave ?>" name="comentario" placeholder="Escribe un comentario">
                <input type="hidden" name="CodPost" value="<?php echo $posts['CodPost'] ?>">
            </form>
        </div>
        <div class="denuncias">
            <?php 
             if(denuncias::verificar_denuncia($posts['CodPost'], $_SESSION['CodUsua']) == 0): ?>
            <a class="enlace-boton-denuncia" id="<?php echo 'elementoDenuncia'.$clave; ?>" href="<?php echo $_SERVER['PHP_SELF'] ?>?denuncia=0&&CodPost=<?php echo $posts['CodPost'] ?>" class="denunciando">🔘Denunciar</a>
            <?php else: ?>
            <a class="enlace-boton-denuncia" id="<?php echo 'elementoDenuncia'.$clave; ?>"href="<?php echo $_SERVER['PHP_SELF'] ?>?denuncia=2&&CodPost=<?php echo $post['CodPost'] ?>" class="denunciado">🔴Denunciado</a>
            <?php endif; ?>
        </div>
    </article>
    <?php endif; ?>

    <?php endforeach; ?>
    <?php endif; ?>

</section>