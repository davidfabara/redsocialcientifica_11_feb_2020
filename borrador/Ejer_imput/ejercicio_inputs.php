<?php
 $variable_global="";
?>

<!Doctype html>
<html>
    <head>
        <script src="ejercicio_input.js"></script>
        <link rel="stylesheet" href="ejercicios.css" />
    </head>
    <body>
        <?php /* <form name= "form" method="post"> */?>
            <input type="text" name="usuario" class="input-control" id="usuario" placeholder="Usuario1">
            <input type="text" name="usuario" id="usuario1" class="input-control" placeholder="Usuario2">
            
            
            <?php /* <input type="submit" value="Registrar" name="registrar" class="log-btn" id="submit"> */ ?>
        <?php /* </form> */ ?>
        
        <button id="boton_para_mostrar" onclick="mostrarInputs('usuario','usuario1')">Enviar</button><hr>
        <?php /* <form name= "form2" method="post"> */?>
            <input type="text" name="usuario2" class="input-control" id="usuario2" placeholder="Usuario2">
            <input type="text" name="usuario3" id="usuario3" class="input-control" placeholder="Usuario3">
            
            <?php /* <input type="submit" value="Registrar" name="registrar" class="log-btn" id="submit"> */ ?>
            <?php /* </form> */ ?>
        <button id="boton_para_mostrar" onclick="mostrarInputs('usuario2','usuario3')">Enviar</button>
        
        <h3>Cuando le quitas el input type submit, no se interpretan las variables REQUEST'usuario' propias de un formulario, pero si se atrapan en el codigo javascript, haciendo perfecto para construir un sistema infinito de pares de inputs que se guarden infinitamente, pero ojo, NO poner en la funcion iniciar() porque la misma se ejecuta al inicio, y si no hay valores se captan valores NULOS por ello deben ir al momento de hacer click en "Mostrar inputs con la intension de hacer que se guarden, reutilizamos la funcion mostrarInputs, enviando argumentos de los ID de los imputs especificos, PERO se reciben como parametros iguales, con la intension de reutilizar codigo "</h3><h2>NOTA: Mucho cuidado, por ejm los input type text necesitan un nombre de lo contrario si le asignas un VALUE solo captara el primer string hasta un espacio en blanco, le veo como un BUG, pero con SOLUCION</h2>

        <div id="mostrarInputs"></div><hr>

        <button id="boton_mostrar_un_input_con_todos_los_inputs" onclick="mostrarEnInput()">Mostrar todos los input como value en un input text</button>

        <div id ="mostrar_un_input_con_todos_los_inputs"></div>
        
       
        
         
        <div id="insertarInputForm"></div>
        <?php if(isset($_REQUEST['formularioFinal']) and isset($_REQUEST['submit']) ): ?>
        <p>

            <?php
                $variable_global.=$_REQUEST['formularioFinal']; 
                echo var_dump($_REQUEST['formularioFinal']),"La variable Global es: $variable_global ";
            ?>
        </p>
        
        <?php endif; ?>
        
    </body>
</html>