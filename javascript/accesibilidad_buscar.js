
/* Accesibilidad para perfil, comandos de voz */
/* Variables globales */
var deletreo = "";
var texto="";
var siguiente="";
var tipo_buscar="";

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
        
        artyom.say("Estas en la sección de buscar, comando ayuda disponible");


};

function ejecutar_ayuda() {

    artyom.say( "Estas el la sección de buscar,  con comandos de voz pronuncia opción 1 o página principal, opción 2, para enfocar en buscar, opción 3, para enfocar en el campo de búsqueda por título o categoría, opción 4 para escuchar ayuda, opción 5, para ver solicitudes, opción 6, para ver las noticias, opción 7 para acceder a tu perfil, opción 8 para cerrar, para crear un texto, pronuncia ayuda para crear texto");          

}

function ejecutar_ayuda_texto(){

    artyom.say("Para crear un texto, pronunciar crear texto seguido del texto a procesar, para deletrear una frase, pronunciar deletrear seguido del carácter a procesar, para pegar la frase de deletrear con el texto, pronuncia ejemplo: pegar texto en búsqueda. Para escribir directamente, pronuncia:  buscar seguido del dictado");
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

        'ayuda para crear texto': () => {
            ejecutar_ayuda_texto();
          
        },
        'opción 1': () => {
            document.getElementById('vinculo_principal').click();
            
          

        },
        'página principal': () => {
            document.getElementById('vinculo_principal').click();
            
          

        },
        'opción 2': (value) => {
            console.log("opcion2 ejecutado");
            artyom.say("Pronunciar buscar, seguido de tu parámetro de búsqueda, para acceder, presionar la tecla enter");
            document.getElementById('busqueda').focus();
            tipo_buscar="buscar";
            
          artyom.say("Presionar enter para acceder si ya existe un texto asignado");

        },

        'buscar *value': (value) => {
            console.log("Buscar ejecutado");
             if(tipo_buscar==="título o por categoría"){
                document.getElementById('busqueda-buscarPHP').value=value;
                document.getElementById('busqueda-buscarPHP').focus();

             }else{
                document.getElementById('busqueda').value=value;
                document.getElementById('busqueda').focus();
             }
             artyom.say("Estas buscando en "+tipo_buscar+" el valor de: "+value+ "presiona enter para ejecutar la búsqueda");




            
        },
        'opción 3': () => {
            /* Ahora el campo de búsqueda se enfoca específicamente en contenidos por títulos o por categoría*/ 
            console.log("Búsqueda por título o por categoría");
            tipo_buscar="título o por categoría";
            document.getElementById('busqueda-buscarPHP').focus()
            artyom.say("Enfocado en búsqueda por título o por categoría");
            artyom.say("Presionar enter para acceder si ya existe un texto asignado");
  
            
        },
        'opción 4': () => {
            ejecutar_ayuda();
  
            
        },
        'opción 5': () => {
            console.log("Publicar ejecutado");
            document.getElementById('nav-solicitud').children[0].focus();
            document.getElementById('icon-usuario').click();
            //document.getElementById('info-solicitud').click();
            artyom.say("Solicitudes mostradas");
     
        },
        'opción 7': () => {
            console.log("Perfil ejecutado");

            document.getElementById('navegacion_perfil').click();
            //document.getElementById('info-solicitud').click();
     
        },
        'opción 8': () => {
            console.log("Cerrar ejecutado");

            document.getElementById('navegacion_cerrar').click();
            //document.getElementById('info-solicitud').click();
     
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
            artyom.say("Estas en la sección de búsqueda, comando ayuda disponible");
          

        },
        'pegar *tipoText en buscar': (tipoText) => {
            if(tipoText==="texto")
                val=texto;
            if(tipoText==="deletrear")
                val=deletreo;

                if(tipo_buscar==="título o por categoría"){
                    document.getElementById('busqueda-buscarPHP').value=val;
                    document.getElementById('busqueda-buscarPHP').focus();
    
                 }else{
                    document.getElementById('busqueda').value=val;
                    document.getElementById('busqueda').focus();
                 }
                 artyom.say("Pegado texto en la búsqueda principal en "+tipo_buscar+" el valor de: "+value+ "presiona enter para ejecutar la búsqueda");

        },

    };



    // agregamos los comandos de voz

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