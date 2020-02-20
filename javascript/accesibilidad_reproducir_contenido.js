var reproducir = "";


function reproducir_contenido(clave){
    var cabecera = document.getElementsByName("cabecera_de_post_oculto_sin_caracteres_de_formato_html")[clave].value;
    var contenido = document.getElementsByName("contenido_oculto_sin_caracteres_de_formato_html")[clave].value;
    contenido=cabecera+contenido;
    var blanco=" ";
    var signoMas="+";
    var signoBarra="/";
    var contingencia=contenido.replace(blanco,signoMas);contingencia=contenido.replace(signoBarra,signoMas);

    clave++;
    
    responsive_voice(contenido,'Post'+clave);

    
}
function responsive_voice(contenido,post){
    if (responsiveVoice.voiceSupport()) { 
        responsiveVoice.setDefaultVoice("Spanish Latin American Female");
        /* 
            Si esta disponible el sistema de responsiveVoiceJS para no incurrir en pausar el sistetizador de voz e incurrir en respuestas que puedan  involucrar llamadas innecesarias 
        */      
        responsiveVoice.speak(` ${post} ${contenido}`);

        /*
        Se reproducira el contenido, asegurandonos que previamente desde publicacion.php se limpio el codigo de todo caracter de html con la intencion de reproducir texto neto
        */



    }else{  
        
                

    }

}
function responsive_voice(contenido){
    if (responsiveVoice.voiceSupport()) { 
        responsiveVoice.setDefaultVoice("Spanish Latin American Female");
        /* 
            Si esta disponible el sistema de responsiveVoiceJS para no incurrir en pausar el sistetizador de voz e incurrir en respuestas que puedan  involucrar llamadas innecesarias 
        */      
        responsiveVoice.speak(`${contenido}`);

        /*
        Reproduccion del contenido
        */



    }
        

         
         
    

}
function reproducir_detalle_perfil(clave){
    var contenido = document.getElementsByName("contenido_oculto_perfil")[clave].value;

    responsive_voice(contenido,"Detalle de perfil");

}

