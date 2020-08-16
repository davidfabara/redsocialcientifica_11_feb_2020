var deletreo = "";
var texto="";

/* Nos aseguramos de cargar el sintetizador justo cuando la página completa se cargue */
window.addEventListener('load', ejecutarArtyom);

function ejecutarArtyom() {
        artyom.initialize({
        lang: "es-ES", // idioma nativo para reproducción del lector
        continuous: false, // Evitar el reconocimiento ya que usamos la herramienta annyang
        listen: false, // Iniciar TODO: Esta variable con FALSE permite desactivar el sintetizador !
        debug: true, // Muestra un informe en la consola
        speed: 1.0 // Velocidad normal con  1
        
        });
        let mensaje=document.getElementById('mensaje_registro').value;
        
        artyomSay(mensaje+"Te encuentras en el registro, se tiene 7 campos de entrada, discapacidad visual que por defecto está seleccionado sin discapacidad, luego le siguen los campos nombre, usuario, password, país, profesión, captha, el botón de registrar y el acceso para ir a login, para pausar el lector pronunciar, pausar lector,  para ayuda pronuncia, ayuda")



};


function ejecutar_ayuda_registro() {

    artyomSay("Te encuentras en el formulario de registro, se tiene 7 campos de entrada, el primero es el tipo de discapacidad visual que por defecto está seleccionado sin discapacidad, pronuncia discapacidad visual seguido del número del uno al cuatro para(moderada, grave, grave o ciega, protección de la vista), los siguientes campos son nombre, usuario, password, país, profesión, captcha, en el caso de captcha pronunciar reproducir clave para escuchar y se posicionará automáticamente en ese campo captcha, con comandos de voz representativos hacia estos input o suministrando los valores manualmente, seguido del valor de entrada puedes registrarte, al final pronuncias, registrar, o pronunciar ir a login para regrezar, pronunciar ayuda avanzada para escritura asistida");
          
}
function ejecutar_ayuda_avanzada(){
    artyomSay("Para guardar en memoria pronuncia crear texto o para  deletrear di deletrear, seguido del carácter así susecivamente, luego pronuncias, pegar texto o deletrear, o borrar según sea el caso, seguido del nombre del input al que deseas asignar, ejemplo pegar texto en usuario. Puedes enfocarte con un teclado en braille en los campos nombre, usuario o password, país, profesión, captha,  pronunciando, ejemplo enfocar en usuario");

}
function comprobar_captcha(){

    var baseConocimiento=["El nombre de marlon es: ", "Algo que que es correcto es incorrecto, si o no para respuesta", "La multiplicación de 7 por 2 es: ", "La multiplicación de 12 por 8 dividido por 8 por 12 es:", "Escriba  la palabra dado en orden inverso", "Escriba solo las vocales de la palabra angelical", "Escriba solo las vocales de la palabra estados", "Escriba la operación que resulta de 12 por 10", "Un sinónimo de grande es alto, responda si o no", "Un sinónimo de pequeño es corto, responda si o no"];

    let i=(Math.random()*baseConocimiento.length);
    let selectCaptcha=baseConocimiento[parseInt(i)];
    console.log("Ejecutado, función comprobar_captcha, con valor: "+selectCaptcha);

     responsive_voice("Las respuestas son en minúsculas y sin espacios. La clave es: "+selectCaptcha+ ", se enfocará automáticamente en el campo captcha para respuesta"); 

     document.getElementById('captcha-registro').focus();


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
    console.log("Posición de correccion:"+(indice+1)+", la corrección sería: "+val);
    artyomSay("Texto actual:"+texto);
    console.log("Texto actual:"+texto);


}
function pegarElementos(tipo_input, tipoElemento){
    /* Para eliminar caracteres especiales, tildes de los inputs recabados con el sintetizador de voz e incluir la ñ */

    if(tipo_input==='profesión'||tipo_input==='profesion')
        tipo_input=tipo_input.replace('sion','').replace('sión','');

    if(tipo_input==='password')
        tipo_input=tipo_input.replace('word','');

    tipo_input=tipo_input.replace(' ', '').normalize('NFD')
    .normalize('NFD')
           .replace(/([^n\u0300-\u036f]|n(?!\u0303(?![\u0300-\u036f])))[\u0300-\u036f]+/gi,"$1")
           .normalize();

           /* stackoverflow(2019) Eliminar signos diacríticos en JavaScript. Eliminar tildes (acentos ortográficos), virgulillas, diéresis, cedillas.Recuperado de : https://es.stackoverflow.com/questions/62031/eliminar-signos-diacr%C3%ADticos-en-javascript-eliminar-tildes-acentos-ortogr%C3%A1ficos */

    if((deletreo != ""&&tipoElemento==="deletreo")||(texto != ""&&tipoElemento==="texto")){ /* Asegurar que no este vacio las variables globales */

        
        if(document.body.contains(document.getElementsByName(tipo_input)[0])){
            console.log(tipo_input);
            if(tipoElemento==="deletreo")
                document.getElementsByName(tipo_input)[0].value=deletreo;
            if(tipoElemento==="texto")
                document.getElementsByName(tipo_input)[0].value=texto;
    
            document.getElementsByName(tipo_input)[0].focus();
            if(tipo_input==='pass')
                tipo_input='password'; /* Para el procesamiento de salida del lector */
            if(tipo_input==='profe')
                tipo_input='profesión' /* Se accede por el nombre */
                artyomSay("Se ha pegado el "+tipoElemento+" en "+tipo_input);
        }else{
            artyomSay("No existe el input con nombre : "+tipo_input);
        }
                       
    }

}
/* T

/* TODO: */

function reanudarAnnyang() {

    annyang.start(); /* Una vez terminado de reproducir mensaje, se renueva la síntesis de comandos de voz*/
}



if (annyang) {
annyang.setLanguage('es-ES');
    var commands = {
        'ayuda': () => {
            $("#registro-sms-oculto").click();
        },
        'ayuda avanzada': () => {
            ejecutar_ayuda_avanzada();

        },
        'pausar lector': () => {
            pausar_lector();
        },
        'reanudar lector': () => {
            reanudar_lector();
        },
        'cancelar lector': () => {
            cancelar_lector();
        },
        'discapacidad visual *value': (value) => {

            artyomSay(" Pronuncia discapacidad visual seguido del número : 1 para sin discapacidad, 2 para discapacidad moderada , 3 para discapacidad grave o ciega, 4 para protección de la vista");
            value=value.replace('uno','1').replace('dos','2').replace('tres','3').replace('cuatro','4').replace('cinco','5').replace('seis','6').replace('siete','7').replace('ocho','8').replace('nueve','9').replace(' ','');

            value=parseInt(value.charAt(0)); /* Conversión a entero */
            value=value-1;
            document.getElementById('opcion2').focus();

            if(value==0||value==1||value==2||value==3){
                document.getElementById('discapacidad-registro').children[value].selected=true;
            }
            
            artyomSay("seleccionado la opcion"+(value+1));
            console.log("seleccionado la opcion"+(value+1));


 
        },
        
        'nombre *value': (value) => {
            artyomSay("Escribiste en nombre."+value);
            console.log($("#nombre-registro").val(value.charAt(0).toUpperCase() + value.slice(1)));
                
        },
                
        'usuario *value': (value) => {
            artyomSay("Escribiste en usuario."+value);
            $("#usuario-registro").val(
                value
                .toLowerCase()
            );

        },
        
        'deletrear *value': (value) => {
            /* Técnicas para mejorar la presición de la síntesis de voz para escritura de frases, palabras o letras concretas */

            if(deletreo == "")
                artyomSay("Decir palabras que evoquen el primer carácter para aumentar la presición, ejemplo david para el caracter d");

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


           artyomSay("Dictado actual:"+deletreo);
           console.log("Dictado actual:"+deletreo);
            

        },
        'crear texto *value': (value) => {

            if(texto===""){
                texto+=value;  
            }else{
                texto+=" "+value;
            }
            artyomSay("Texto actual:"+texto);
            console.log("Texto actual:"+texto);
        },
        'leer deletrear':() => {
            if(deletreo===""){
                artyomSay("Deletreo actual vacío");
            }else{
                artyomSay("Deletreo actual:"+deletreo);
            }

            console.log(deletreo);
        },
        'leer texto':() => {
            if(texto===""){
                artyomSay("Texto actual vacío");
            }else{
                artyomSay("Texto actual:"+texto);
            }

            console.log(texto);
        },
        'pegar deletrear en *value': (value) => {
            if(value==="texto"){
                texto+=deletreo;
                artyomSay("Texto actual:"+texto);
                console.log("Texto actual:"+texto);
            }else{
                pegarElementos(value,"deletreo");
            }

        },
        'pegar texto en *value': (value) => {
            pegarElementos(value,"texto");
        },
        'borrar deletrear': () => {
            deletreo = '';
            console.log('deletreo esta:' + deletreo);
            artyomSay('deletreo borrado');
        },
        'borrar texto': () => {
            texto = '';
            console.log('Texto actual está vacío');
            artyomSay("Texto actual está vacío");
        },
        'corregir texto': () => {
            artyomSay("Decir el número donde se presente:");


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
            artyomSay("Como ejemplo, para corregir la primera palabra, decir corregir elemento 1 con, seguido del texto a corregir. La corrección es aplicada a : "+acum);

            console.log("Texto para corregir, el array original es:"+texto_a_corregir);
        },
        'corregir elemento *num con *val': (num,val) => {
            correccion(num,val);
        },

        //introducimos el password
        'password *value': (value) => {
            artyomSay("Escribiste en password."+value);
            $("#registro-password").val(value.toLowerCase());

        },
        //mostramos los valores del formulario
        'país *value': (value) => {
            artyomSay("Escribiste en país."+value);
            $("#registro-pais").val(value.charAt(0).toUpperCase() + value.slice(1));
            /* Conversión a mayúscula solo el primer carácter */


        },
        'origen *value': (value) => {
                 $("#registro-pais").val(value.charAt(0).toUpperCase() + value.slice(1));


        },

        'profesión *value': (value) => {
            artyomSay("Escribiste en profesión."+value);
            $("#registro-profesion").val(value.charAt(0).toUpperCase() + value.slice(1));

        },

        'reproducir clave': () => {
            $("#captcha-sms-oculto").click();

        },
        'captcha *value': (value) => {
            artyomSay("Escribiste en el captcha ."+value);
            $("#captcha-registro").val(value.charAt(0).toLowerCase() + value.slice(1));

        },
        'registrar': () => {
            artyomSay("Registrado");
            $("#registro-submit").click();

        },
   
        'eres nuevo': () => {
            $("#tengoCuenta").click();
            if (responsiveVoice.voiceSupport()) {

            responsiveVoice.speak("Has accedido");
            }

        },
        
        'ir a login': () => {
            document.getElementById('tengoCuenta').click();


        },


        'donde estoy': () => {
            if (responsiveVoice.voiceSupport()) {
            responsiveVoice.speak("Estas en el formulario registro de acceso");
            }

        },/* TODO: */
        'tengo cuenta': () => {
           /* "ESTO FUNCIONA" */ 
        document.getElementById('tengoCuenta').click();

        },
        'enfocar en *tipoInput': (tipoInput) => {
            /* Para enfocar en algún input, útil para sistemas híbridos de accesibilidad */

           var enfocado=tipoInput;
           
           if(tipoInput==="discapacidad visual"||tipoInput==="discapacidad"){
            tipoInput='opcion2';
           }
           if(tipoInput==="nombre"||tipoInput==="nomb"){
                tipoInput='nombre-registro';
            }
            if(tipoInput==="usuario"||tipoInput==="user"){
                tipoInput='usuario-registro';
            }
            if(tipoInput==="password"||tipoInput==="contraseña"){                
                tipoInput='registro-password';
            }
            if(tipoInput==="París"||tipoInput==="país"||tipoInput==="pais"){                
                tipoInput='registro-pais';
                enfocado="país";
            }
            if(tipoInput==="profesión"||tipoInput==="profesion"){                
                tipoInput='registro-profesion';
            }
            if(tipoInput==="captcha"||tipoInput==="capture"||tipoInput==="casa"){                
                tipoInput='captcha-registro';
            }


            if(document.body.contains( document.getElementById(tipoInput))){

                    artyom.say("Enfocado en"+ enfocado);
                    document.getElementById(tipoInput).focus();
            }else{
                    artyom.say("El input no existe, volver a intentar");
                    console.log("El input incorrecto es: "+enfocado);    
            }              
    
    },
};
    // Añadimos los comandos


    annyang.addCommands(commands);

    // Empezamos la escucha
    annyang.start();
}
if (!annyang) {
    console.log("El reconocimiento de voz de annyang no es compatible con el navegador");
    if (responsiveVoice.voiceSupport()) {
        responsiveVoice.speak(
            "El reconocimiento de voz de annyang no es compatible con el navegador, se recomienda Chrome"
        );

    }
}
