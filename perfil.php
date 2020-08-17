<?php
 include_once 'modelo/modelo-perfil.php';
?>
<script src="javascript/accesibilidad_perfil.js"></script>
<button id="perfil-sms-oculto" class="icono_reproducible" onclick="ejecutar_ayuda()"><center>Ayuda</center></button>
			<button id="subir-sms-oculto" class="icono_reproducible" onclick="reproducir_detalle_perfil(0)">Detalle de perfil</button>
<div id="perfil">
    <ul>
        <li>	
			<img src="<?php echo $usuario[0]['foto_perfil']; ?>" alt="<?php echo " El nombre del usuario es:" .
                $usuario[0]['nombre']; ?>" id="img"></li>
        <li>
            <h1>
                <?php echo $usuario[0]['nombre']; ?>
            </h1>
            <ul>
                <li><strong>Discapacidad Visual ♿️ :</strong><span>
                        <?php echo $usuario[0]['discapacidad']; ?></span></li>
                <li><strong>Profesión: </strong><span>
                        <?php echo $usuario[0]['profesion']; ?></span></li>
                <li><strong>Pais: </strong> <span>
                        <?php echo $usuario[0]['pais']; ?></span></li>
                <li><strong>Amigos: </strong><span>
                        <?php if (!empty(amigos::cantidad_amigos($_GET['CodUsua'])))
							echo amigos::cantidad_amigos($_GET['CodUsua'])[0][0];
										/* [0][0]Tabla cero y campo cero */														
						    else echo 0;
						?>																
                    </span>
				</li>
				<li>
					<input type="hidden" name="contenido_oculto_perfil" value="<?php
                 	echo " El nombre del usuario es: " .
					 $usuario[0]['nombre']."Discapacidad ".$usuario[0]['discapacidad']."Profesión ".$usuario[0]['profesion']."País ".$usuario[0]['pais'] ?>">
					<input type="hidden" id="mensaje_perfil" value="<?php echo tiempo_sesion_mensaje(); ?>">
				 </li>
            </ul>
        </li>
        <?php /*Si CodUsua diferente de la misma variable como argumento pero de la SESSION evidentemente es que nos encontramos en otro perfil */ ?>
        <?php if ($_GET['CodUsua'] != $_SESSION['CodUsua']) : ?>
        <?php if (empty($verificar_amigos)) : ?>
        <li><a id="agregar-amigo" href="perfil.php?CodUsua=<?php echo $_GET['CodUsua']; ?>&&agregar=<?php echo $_GET['CodUsua']; ?>">Agregar</a></li>
        <?php elseif ($verificar_amigos[0]['status'] == true) : ?>
		<li>
			<a id="amigos"href="#">Amigos</a>
		</li>
        <?php else : ?>
        <li>
			<a id="solicitud-enviada"href="#">Solicitud enviada</a>
		</li>
        <?php endif; ?>
        <?php else : ?>
        <?php /* Este else: implica que $_GET['CodUsua'] = $_SESSION['CodUsua'] entonces se trata del usuario de SESSION */ ?>
        <li>
			<a id= "edit_perfi" class="editar-acceso" href="editar_perfil.php">Editar</a>
		</li>
		<?php 
		/*
         Hay 4 posibilidades debido al condicional $verificar_amigos, que se procesa en el código php superior
          debido a amigos::verificar, evidentemente el usuario de SESSION sera el único que tendrá la 
          posibilidad de ver siempre "Editar" 
		 */
		?>
        <?php endif; ?>
    </ul>
</div>
<?php require('publicacion.php'); ?>
<?php 
/* Abajo de el header > perfil debemos ubicar todas las publicaciones que impliquen al usuario
CodUsuario de la página actual, porque puede darse el caso que estemos en el perfil de otro usuario y 
sus publicaciones solo son de aquellas en las cual el ha publicado*/ ?>
</body>
</html>