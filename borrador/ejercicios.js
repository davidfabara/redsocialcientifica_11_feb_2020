$variable_parecida_a_php="Variable parecida en sintaxis a la de php como:"+ '$variable_parecida_a_php';

var variable_de_javaScript="<br>Esta es una variable de JavaScript guardada en: "+'var variable_de_javaScript';

_variableQueIniciaConGuionBajo="<br>Variable que se declara con guion bajo como: "+'_variableQueIniciaConGuionBajo';


function mostrar(){
    document.querySelector('#textoInsertado').innerHTML=$variable_parecida_a_php+variable_de_javaScript+_variableQueIniciaConGuionBajo;
}

window.addEventListener('load',
    function(e){
        document.querySelector('#textoInsertado').innerHTML='texto superpuesto al texto original';
    },false);

