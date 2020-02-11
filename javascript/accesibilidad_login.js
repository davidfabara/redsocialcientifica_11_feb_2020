var deletreo = "";
var texto="";

/* Las líneas anteriores implican la lista de variables globales */

/* Nos aseguramos de cargar el sintetizador justo cuando la página completa se cargue */
window.addEventListener('load', ejecutarArtyom);

function ejecutarArtyom() {
    /* Este mecanismo es predefinido por la página oficial de Artyom.com por lo cual los parámetros usados se deberían usar los mismos para el adecuado funcionamiento del sistema */
        artyom.initialize({
        lang: "es-ES", // idioma nativo para reproducción del lector
        continuous: false, // Evitar el reconocimiento ya que usamos la herramienta annyang
        listen: false, // Iniciar TODO: Esta variable con FALSE permite desactivar el sintetizador !
        debug: true, // Muestra un informe en la consola
        speed: 1.3 // Velocidad normal con  1
        
        });
        
        artyom.say("Te encuentras en el login, comando ayuda disponible")


};
function localizacion_login(){
    artyom.say("Te encuentras en el login, comando ayuda disponible");
}

function ejecutar_ayuda_login() {

    artyom.say( "Estas en el formulario de login, se tiene 2 campos de entrada, puedes acceder a ellos pronunciándolos, el primero es usuario, el segundo es el password, el tercero es acceder si eres nuevo, di:  ir a registro, para ayuda avanzada, pronuncia este comando, para saber lo que escribiste, pronuncia, leer texto o deletreo según sea el caso");          

}
function ayuda_avanzada(){
    artyom.say("Para guardar en memoria pronuncia crear texto o para  deletrear di deletrear, seguido del carácter así susecivamente, luego pronuncias, pegar texto o deletrear, o borrar según sea el caso, seguido del nombre del input al que deseas asignar, ejemplo pegar texto en usuario.");
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
    console.log("Posición de correccion:"+(indice+1)+", la correccion seria: "+val);
    artyom.say("Texto actual:"+texto);
    console.log("Texto actual:"+texto);


}

function pegarElementos(tipo_input, tipoElemento){
    /* Para eliminar caracteres especiales, tildes de los inputs recabados con el sintetizador de voz e incluir la ñ */
    if(tipo_input==='password')
        tipo_input=tipo_input.replace('word','');

    tipo_input=tipo_input.replace(' ', '').normalize('NFD')
    .normalize('NFD')
           .replace(/([^n\u0300-\u036f]|n(?!\u0303(?![\u0300-\u036f])))[\u0300-\u036f]+/gi,"$1")
           .normalize();

            /* 
                OJO, esto solo funcionaria para inputs concretos en los cuales es importante eliminar los espacios entre los caracteres, las tíles y acentos ortográficos como lo son el usuario y pasword obteniendo un texto limpio

             stackoverflow(2019) Eliminar signos diacríticos en JavaScript. Eliminar tildes (acentos ortográficos), virgulillas, diéresis, cedillas.Recuperado de : https://es.stackoverflow.com/questions/62031/eliminar-signos-diacr%C3%ADticos-en-javascript-eliminar-tildes-acentos-ortogr%C3%A1ficos

           */

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
            artyom.say("Se ha pegado el "+tipoElemento+" en "+tipo_input);
        }else{
            artyom.say("No existe el input con nombre : "+tipo_input);
        }
                  
    }

}
/* TODO: */


if (annyang) {
    annyang.setLanguage('es-ES');

    var commands = {
        'ayuda': () => {
            $("#login-sms-oculto").click();
          

        },
        'ayuda avanzada': () => {
            ayuda_avanzada();
        },
        'información': () => {
            $("#login-sms-oculto").trigger("click");
        },
        'usuario *value': (value) => {
            $("#login-usuario").val(
                value
                .toLowerCase()
                .replace('arroba', '@')
                .replace(' ', '') /* Unirá la interpretacion de varias palabras y las tomará como 1*/
            
                
            );
            artyom.say("Escribiste en usuario."+value);          
            annyang.start();
        },
 
        'deletrear *value': (value) => {

            /* Técnicas para mejorar la presición de la síntesis de voz para escritura de frases, palabras o letras concretas */

            if(deletreo == "")
                artyom.say("Decir palabras que evoquen el primer carácter para aumentar la presición, ejemplo david para el carácter d");

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


           artyom.say("Dictado actual : "+deletreo);
           console.log("Dictado actual : "+deletreo);

        },
        'crear texto *value': (value) => {

            if(texto===""){
                texto+=value;  
            }else{
                texto+=" "+value;
            }
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
        'pegar deletrear en *value': (value) => {
            if(value==="texto"){
                texto+=deletreo;
                artyom.say("Texto actual:"+texto);
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
        //introducimos el password
        'password *value': (value) => {
            $("#password-input").val(value.toLowerCase());
            artyom.say("Escribiste en password."+value);
        },
        //mostramos los valores del formulario
        'acceder': () => {
            artyom.say("Accediendo a página principal");
            $("#submit-input").click();

        }, // Redirigir a la sección de registro
        'ir a registro': () => {
            document.getElementById('link_a_registro').click();


        },
        'dónde estoy': () => {
            artyom.say("El lector se ha iniciado");
            console.log("El lector se ha iniciado");
          

        },
       

    };

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