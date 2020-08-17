
<?php
 include_once 'modelo/modelo-post.php';
?>
<body>
</body>
 <script type="text/javascript" src="javascript/post.js"></script>
 <button id="post-sms-oculto" class="icono_reproducible" onclick="ejecutar_ayuda_post()">Ayuda</button>
        <input type="hidden" id="mensaje_pagina_publicacion" value="<?php echo tiempo_sesion_mensaje(); ?>">
 </html>