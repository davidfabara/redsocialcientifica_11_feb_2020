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
function artyomSay(mensaje){
    artyom.say(mensaje);
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
function pausar_lector(){
    responsive_voice("Lector pausado");
}
function reanudar_lector(){
    responsive_voice("    ");
    responsiveVoice.resume();
    console.log("Lector reanudado");
    setTimeout(function(){    
        responsive_voice("Lector reanudado");     
    /* Reanuda la pausa temporal del lector, tras pasar 5 segundos desde su ejecución del comando pausar
     lector */
    }, 1000);
    /* Reanuda el control del lector */
}
function cancelar_lector(){
    responsive_voice("Lector cancelado");
    setTimeout(function(){    
        responsiveVoice.pause();    
    /* Reanuda la pausa temporal del lector, tras pasar 5 segundos desde su ejecución del comando pausar lector */
    }, 2000);
    console.log("Lector cancelado hasta pronunciar comando, reanudar lector");
    /* Para completamente toda instancia de lector en pantalla hasta recibir el comando de: reanudar lector o si se re-carga la página*/
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