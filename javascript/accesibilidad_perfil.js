/* Accesibilidad para perfil, comandos de voz */
/* Variables globales */
var deletreo = "";
var texto="";
var siguiente="";

responsiveVoice.setDefaultVoice("Spanish Latin American Female");

window.addEventListener('load', ejecutarArtyom);
function ejecutarArtyom() {
        artyom.initialize({
        lang: "es-ES", // idioma nativo para reproducción del lector
        continuous: false, // Evitar el reconocimiento ya que usamos la herramienta annyang
        listen: false, // Iniciar TODO: Esta variable con FALSE permite desactivar el sintetizador !
        debug: true, // Muestra un informe en la consola
        speed: 1.3 // Velocidad normal con  1
        
        });
        
        artyom.say("Estas en el perfil, comando ayuda disponible");


};

function ejecutar_ayuda() {

    artyom.say( "Estas en el perfil, se tiene un menú superior con accesos, en el cuerpo del documento se tiene el perfil seguido de la lista de publicaciones de ese perfil con comandos de voz pronuncia: opción 1 o página principal, opción 2 o buscar, opción 3 o publicar, opción 4 o detalle de perfil, opción 5 o solicitudes, opción 6 o noticias, opción 7 o perfil, opción 8 o cerrar , opción 9 para acceder a la lista de publicaciones, opción 10 o editar perfil, para comentar pronunciar ayuda para comentar, para crear un texto, pronuncia ayuda para crear texto, para enviar una solicitud de amistad, pronuncia, enviar solicitud o simplemente, agregar");          

}

function ejecutar_ayuda_texto(){

    artyom.say("Para crear un texto, pronunciar crear texto seguido del texto a procesar, para deletrear una frase, pronunciar deletrear seguido del carácter a procesar, para pegar la frase de deletrear con el texto, pronuncia pegar deletrear en texto, para el caso de pegar un texto en algún input, pronunciar pegar seguido de la palabra texto o deletrear seguido de la palabra elemento seguido de la palabra número seguido del número de elemento seguido del nombre del imput, ejm para pegar el texto creado en el primer comentario, sería, pegar texto en elemento número 1 de comentario.");
}
function ejecutar_ayuda_comentar(){

    artyom.say("Para el caso de comentar, se invoca con el comando: elemento seguido de la palabra número seguido del número de elemento seguido de la palabra, de, seguido de la palabra, comentario, seguido de la palabra, con, seguido del texto libre a dictar a partir de ese momento, ejm.");
}
function pegarDeletreo(parametro){

    if(deletreo != ""){
        $(parametro).val(deletreo);
    }
}

function correccion(num, val){
    /* Corregir elementos de un texto actual */
    var indice=parseInt(num)-1;
    var texto_a_corregir=texto.split(" ");
    if(val==="deletrear")
        val=deletreo;
    
        texto_a_corregir[indice]=val;
    


    texto=""; /* variable global texto se actualizará por completo */
    console.log("El valor de texto_a_corregir[indice] es: "+texto_a_corregir[indice]);
 
    var aux2=texto_a_corregir;
   
    for(var i=0;i<aux2.length;i++){
        texto+=aux2[i]+" ";
    }
    texto=texto.trim(); //Eliminar los espacios en blanco en las secciones de los extremos de la cadena
    console.log("Posición de corrección:"+(indice+1)+", la corrección seria: "+val);
    artyom.say("Texto actual:"+texto);
    console.log("Texto actual:"+texto);


}

/* TODO: */


if (annyang) {
    annyang.setLanguage('es-ES');

    var commands = {
        'ayuda': () => {
            ejecutar_ayuda();
          

        },
        'ayuda para comentar': () => {
            ejecutar_ayuda_comentar();
          
        },
        'ayuda para crear texto': () => {
            ejecutar_ayuda_texto();
          
        },
        'leer solicitudes': () => {
            artyom.say(document.getElementsByName('solicitudes-acumuladas')[0].value);
          
        },
        'leer notificaciones': () => {
            artyom.say(document.getElementById('notificaciones-acumuladas').value);
          
        },
        'enviar solicitud': (value) => {


   
            
            if(document.body.contains( document.getElementById('agregar-amigo'))){
                document.getElementById('agregar-amigo').click();
                artyom.say("solicitud enviada");
                console.log("solicitud enviada");
            }
          
        },
        'agregar': (value) => {


   
            
            if(document.body.contains( document.getElementById('agregar-amigo'))){
                document.getElementById('agregar-amigo').click();
                artyom.say("solicitud enviada");
                console.log("solicitud enviada");
            }
          
        },
        'leer comentarios de publicación *clave': (clave) => {
            /* TODO: */
            clave=clave.replace('uno','1').replace('un','1').replace('dos','2').replace('tres','3').replace('cuatro','4').replace('cinco','5').replace('seis','6').replace('siete','7').replace('ocho','8').replace('nueve','9').replace(' ','');
            clave=parseInt(clave.charAt(0)); /* Conversión a entero */
            console.log("Lectura de comentarios de publicación "+clave);
            clave=clave-1;

            if(document.body.contains( document.getElementById('speech_post'+clave))){
                if((document.getElementsByName('comentarios-acumulados')[clave].value)!==""){
                    artyom.say(document.getElementsByName('comentarios-acumulados')[clave].value);
                    console.log((document.getElementsByName('comentarios-acumulados')[clave].value));
                }else{
                    artyom.say("No existen comentarios para la publicación"+clave);
                }

            }else{
                artyom.say("Comando no comprendido, volver a intentar");
                console.log("Comando no comprendido, volver a intentar");
            }

          
        },
        'opción 1': () => {
            document.getElementById('vinculo_principal').click();
            
          

        },
        'página principal': () => {
            document.getElementById('vinculo_principal').click();
            
          

        },
        'opción 2': (value) => {
            console.log("opcion2 ejecutado");
            artyom.say("Pronunciar buscar, seguido de tu parametro de búsqueda, para acceder, presionar la tecla enter");
            
            
          

        },

        'buscar *value': (value) => {
            console.log("Estas buscando "+value+" presiona enter para acceder");
            artyom.say("Estas buscando "+value+" presiona enter para acceder");

            document.getElementById('busqueda').value=value;
            document.getElementById('busqueda').focus();;


            
        },
        'opción 3': () => {
            console.log("Publicar");
            document.getElementById('vinculo_principal').click();
  
            
        },
        'publicar': () => {
            console.log("Publicar");
            document.getElementById('vinculo_principal').click();
  
            
        },
        'opción 4': () => {
            console.log(" Detalle del perfil");
            reproducir_detalle_perfil(0)
  
            
        },
        'detalle de perfil': () => {
            console.log("Perfil");
            reproducir_detalle_perfil(0)
  
            
        },
        'opción 5': () => {
            artyom.say(document.getElementsByName('solicitudes-acumuladas')[0].value);
     
        },
        'solicitudes': () => {
            artyom.say(document.getElementsByName('solicitudes-acumuladas')[0].value);
     
        },
        'opción 6': () => {
            artyom.say(document.getElementById('notificaciones-acumuladas').value);
     
        },
        'noticias': () => {
            artyom.say(document.getElementById('notificaciones-acumuladas').value);
     
        },
        'opción 7': () => {
            console.log("Perfil ejecutado");

            document.getElementById('navegacion_perfil').click();
            //document.getElementById('info-solicitud').click();
     
        },
        'perfil': () => {
            console.log("Perfil ejecutado");

            document.getElementById('navegacion_perfil').click();
            //document.getElementById('info-solicitud').click();
     
        },
        'opción 8': () => {
            console.log("Cerrar ejecutado");

            document.getElementById('navegacion_cerrar').click();
            //document.getElementById('info-solicitud').click();
     
        },
        'cerrar': () => {
            console.log("Cerrar ejecutado");

            document.getElementById('navegacion_cerrar').click();
            //document.getElementById('info-solicitud').click();
     
        },
        'opción 9': () => {
            console.log("reproducir publicación ejecutado");
            artyom.say("Pronunciar, reporducir publicación, seguido del número de publicación, ejemplo, reproducir publicación 1");
            
            
          

        },
        'opción 10': () => {
            console.log("Edicion perfil ejecutado");
            document.getElementById("edit_perfi").click();        

        },
        'editar perfil': () => {
            console.log("Edicion perfil ejecutado");
            document.getElementById("edit_perfi").click();        

        },
        'editar': () => {
            console.log("Edicion perfil ejecutado");
            document.getElementById("edit_perfi").click();        

        },


        'que está escrito': () => {
            console.log("Escrito : "+deletreo);
            artyom.say("Escrito"+deletreo);
            

            /*
            $("#busqueda").trigger($.Event('keypress', { keycode: 13 }));
            */
            
        },

 
        'deletrear *value': (value) => {
            

            /* Técnicas para mejorar la presición de la síntesis de voz para escritura de frases, palabras o letras concretas */

            if(deletreo == "")
                artyom.say("Decir palabras que evoquen el primer carácter para aumentar la presición");

            if(value.match("abrir paréntesis"))
                value=value.replace(value,'(');

            if(value.match("cerrar paréntesis"))
                value=value.replace(value,')');

            if(value.match("coma"))
                value=value.replace(value,', ');

            if(value.match("punto"))
                value=value.replace(value,'. ');

            if(value.match("espacio"))
                value=value.replace(value,' ');



                value=value.replace('be', 'b')
                .replace('ce', 'c')
                .replace('de', 'd')
                .replace('ele', 'l')
                .replace('efe', 'f')
                .replace('ge', 'g')
                .replace('ache', 'h')
                .replace('eme', 'm')
                .replace('eñe', 'ñ')
                .replace('ere', 'r')
                .replace('ese', 's')
                .replace('te', 't')
                .replace('uve', 'v')
                .replace('ye', 'y')
                .replace('zeta','z')
                .replace('guión bajo','_')
                .replace('b grande', 'b')
                .replace('b pequeña', 'v')
                .replace('uno','1').replace('dos','2').replace('tres','3').replace('cuatro','4').replace('cinco','5').replace('seis','6').replace('siete','7').replace('ocho','8').replace('nueve','9');
    
            if (value.match("mayúscula")){
                value=value.toUpperCase() 
    
            }else{
                value=value.toLowerCase()
            }
        
            
            deletreo += value.charAt(0);


           artyom.say("Dictado actual:"+deletreo);
            console.log(deletreo);

        },
        'crear texto *value': (value) => {
            if(texto===""){
                texto+=value;  
            }else{
                texto+=" "+value;
            }
            texto=texto.charAt(0).toUpperCase() + texto.slice(1); /* Convertir a mayúsculas únicamente el primer caracter de todo el texto */
            artyom.say("Texto actual : "+texto);
            console.log("Texto actual : "+texto);
        },
        'leer deletrear':() => {
            if(deletreo===""){
                artyom.say("Deletreo actual vacío");
            }else{
                artyom.say("Deletreo actual:"+deletreo);
            }

            console.log(deletreo);
        },
        'leer texto':() => {
            if(texto===""){
                artyom.say("Texto actual vacío");
            }else{
                artyom.say("Texto actual:"+texto);
            }

            console.log(texto);
        },
        'pegar deletrear en texto': (value) => {
            texto+=deletreo;
            artyom.say("Texto actual:"+texto);
            console.log("Texto actual:"+texto);

        },

        'borrar deletrear': () => {
            deletreo = '';
            console.log('Deletreo actual es:' + deletreo);
            artyom.say("Deletreo borrado:");
        },
        'borrar texto': () => {
            texto = '';
            console.log('Texto actual está vacío');
            artyom.say("Texto actual está vacío");
        },
        'corregir texto': () => {
            artyom.say("Decir el número donde se presente:");


            var texto_a_corregir=texto.split(" ");
            /* split crea un array con argumento separador con el espacio en blanco */
            var aux=texto_a_corregir;
            var acum="";
            for(var i=0;i<aux.length;i++){
                acum+=" elemento "+(i+1)+" "+aux[i];

            /*
                aux apunta a los elementos individuales del array texto_a_corregir
             */
            }
            artyom.say("Como ejemplo, para corregir la primera palabra, decir corregir elemento 1 con, seguido del texto a corregir. La corrección es aplicada a : "+acum);

            console.log("Texto para corregir, el array original es:"+texto_a_corregir);
        },
        'corregir elemento *num con *val': (num,val) => {
            correccion(num,val);
        },
        
        'dónde estoy': () => {
            artyom.say("Estas en la sección principal, comando ayuda disponible");
          

        },
        'acceder': () => {
            $("#submit-input").click();

        }, // Para invocar todos los imput de registro
        'elemento número *num de *tipoInput con *val': (num,tipoInput,val) => {
            /* Se puede escribir en los inputs del formulario y sobre los comentarios de una publicación */

            if(tipoInput==="comentario"||tipoInput==="Comentario")
                invocar_input_formulario('comentario', num, val);
              

        },
        'pegar *tipoText en elemento número *num de *tipoInput': (tipoText,num,tipoInput) => {
            if(tipoText==="texto")
                val=texto;
            if(tipoText==="deletrear")
                val=deletreo;

            if(tipoInput==="comentario"||tipoInput==="Comentario")
                invocar_input_formulario('comentario', num, val);
              

        },
        'reproducir publicación *value': (value) => {
            var value=value.replace('uno','1').replace('dos','2').replace('tres','3').replace('cuatro','4').replace('cinco','5').replace('seis','6').replace('siete','7').replace('ocho','8').replace('nueve','9');
            if(value==='diez'||value==='10'){
                reproducir_publicacion(9);
            }else{
                value=parseInt(value.charAt(0));
                reproducir_publicacion(value-1);
            }
        },

    };

    function reproducir_publicacion(value){
        if(document.body.contains( document.getElementById('speech_post'+value))){
            reproducir_contenido(value);
        }else{
            artyom.say("La publicación nombrada sobrepasa el límite o no existe, volver a intentar");
                console.log("El input es:"+value);
        }
    }

    function invocar_input_formulario(tipoInput,num,val){

        num=num.trim();
        if(num==='una'){
 
         num=num.replace('una','1');
        }else{
        
        }
        console.log("tipoInput es:"+tipoInput+", num ="+num+", val="+val);
        var espacio=" ";
         if(tipoInput==="comentario"){
             espacio="";
         }
 
         var num=parseInt(num)-1;
         if (num===0&&tipoInput!="comentario"){
             num=""; espacio="";
         }
         if(tipoInput==="comentario"){
             espacio="";
         }
                 
 
            /* Comprobando la existencia del identificador invocado con la voz, para proceder a agregar el valor del input suministrado por invocación asociada con comando de voz 
            
                    valor=valor.substring(2, valor.length);
             */
 
         if(document.body.contains( document.getElementById(tipoInput+ espacio+ num))){
                 document.getElementById(tipoInput+ espacio+ num).value=val.charAt(0).toUpperCase() + val.slice(1);
                 artyom.say("Estas escribiendo en"+ tipoInput+" elemento "+(num+1)+", "+val);
                 document.getElementById(tipoInput+ espacio+ num).focus();
         }else{
                 artyom.say("El imput no existe, volver a intentar");
                 console.log("El número de elemento es "+num+". El input  de texto es: "+val);
 
         }
            /* Recordar que cada estructura, tanto resumen, contenido, conclusiones, recomendaciones tienen un identificador no indexado por ello si num===0 simplemente queda vacio como si sucede con sus hijos en jerarquia del array tridimensional pero basado en el ID mas no en el nombre ejm resumen 1, el cual seria el primer elemento como hijo de resumen*/
 
     }
    // Añadimos los comandos

    annyang.addCommands(commands);

    // Empezamos la escucha
    annyang.start();
}
if (!annyang) {
    console.log("El reconocimiento de voz de annyang no es compatible con el navegador");
    
        artyom.say(
            "El reconocimiento de voz de annyang no es compatible con el navegador, se recomienda Chrome"
        );

    
}