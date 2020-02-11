var mostrar_comentario = "";

function iniciar() {
    mostrarNumero();
}

function mostrar_contenido(clave) {
    var contenido = document.getElementsByName("contenido_oculto")[clave].value;
    var comentario = document.getElementsByName("mostrar_comentarios");
    var mostrando_contenido = document.getElementsByName("mostrando_contenidos");
    var imagen_archivo=document.getElementsByClassName("publi-thumb");
    mostrando_contenido[clave].innerHTML = contenido;
    comentario[clave].style.display = 'block';
    imagen_archivo[clave].style.display = 'block';



}

function mostrarNumero() {
    var longitud = document.getElementsByName("mostrandoNumero").length;
    for (var i = 0; i < longitud; i++)
        document.getElementsByName("mostrandoNumero")[i].innerHTML = "Post_" + (i + 1);

}
window.addEventListener("load", iniciar, false); /* Ejecucion automatica a penas se cargue la pagina */