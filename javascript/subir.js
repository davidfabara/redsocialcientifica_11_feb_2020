var boton = "";
var boton_subir = "";
var descripcion = "";
var referencia = "";
var cita = "";
var i=0;
var i_ref=0;
var j_res = 0;
var j_int = 0;
var j_cont = 0;
var j_conc = 0;
var j_ref = 0;

var y=0;
var y_res=0; var y_int=0; var y_conte=0; var y_conc=0;



function iniciar() {
    boton = document.getElementById("descripcionArchivos").addEventListener("click", descripcionArchivos, false);
    /* citar_Resumen=document.getElementById( "refResumen" ).addEventListener( "click", citar,resumen, false ); */
    boton_subir = document.getElementById("boton_mostrar_subir").addEventListener("click", mostrar_subir, false);
}

function mostrar_subir() {
    var subi = document.getElementsByClassName("subir");
    if (subi[0].style.display == 'none') {
        subi[0].style.display = 'table';
        if (responsiveVoice.voiceSupport()) {

            responsiveVoice.speak("Formulario de publicación mostrado");
        }
        
    } else {
        subi[0].style.display = 'none';
        if (responsiveVoice.voiceSupport()) {

            responsiveVoice.speak("Formulario de publicación oculto");
        }
    }
}


function descripcionArchivos() {
    descripcion += "<input type=" + '"text"' + ' name="alt" placeholder =' + "Descripcion de archivo><br>";
    /*Si se hace click de manera iterativa, se puede invocar a varios eventos y como cadena es un acumulador, simplemente absorvera lo que tiene y aumentara lo asignado */
    document.getElementById("addDescripcionArchivos").innerHTML = descripcion;
    /* La cadena se convierte a codigo html y se inyecta hacia el id de addDescripcionArchivos*/
}

function select_citar(subir_cont, tipoTextArea, tipoInput, tipoDiv){
    var x;

    if(tipoTextArea==='resumen')
         x=0;
    if(tipoTextArea==='introduccion')
        x=1;
    if(tipoTextArea==='contenido')
        x=2;
    if(tipoTextArea==='conclusiones')
        x=3;
    
    cita=`<hr><input type="button" value="Cita basada en el autor(Cita textual y de menos de 40 palabras)" class="boton" id="opcion1_${x}"  onclick="parrafo_citar('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Cita basada en el autor(Cita textual y de menos de 40 palabras)')">

    <input type="button" value="Cita basada en el texto(Cita textual y de menos de 40 palabras)" class="boton" id="opcion2_${x}"
    onclick = "parrafo_citar('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Cita basada en el texto(Cita textual y de menos de 40 palabras)')">

    <input type = "button" value = "Cita basada en el autor(Cita textual y de más de 40 palabras)" class = "boton" id="opcion3_${x}"
    onclick = "parrafo_citar('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Cita basada en el autor(Cita textual y de más de 40 palabras)')">

    <input type = "button" value="Cita basada en el texto(Cita textual y de más de 40 palabras)" class = "boton" id="opcion4_${x}"
    onclick = "parrafo_citar('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Cita basada en el texto(Cita textual y de más de 40 palabras)')">

    <input type = "button" value="Cita basada en el texto(parafraseo)" class = "boton" id="opcion5_${x}"
    onclick = "parrafo_citar('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Cita basada en el texto(parafraseo)')">

    <input type = "button" value ="Cita basada en el autor(parafraseo)" class = "boton" id="opcion6_${x}"
    onclick = "parrafo_citar('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Cita basada en el autor(parafraseo)')">

    <input type = "button" value="Autor corporativo" class = "boton" id="opcion7_${x}"
    onclick = "parrafo_citar('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Autor corporativo')">

    <input type = "button" value="Anónimo" class = "boton" id="opcion8_${x}"
    onclick = "parrafo_citar('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Anónimo')">

    <input type = "button" value="Cita de una cita" class = "boton" id="opcion9_${x}"
    onclick = "parrafo_citar('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Cita de una cita')">`;

    document.getElementsByClassName(tipoDiv+'_select')[0].innerHTML = cita;
}

function select_referencia(subir_cont,tipoTextArea, tipoInput, tipoDiv){

    referencia = `<hr><input type="button" value="Libro con autor" class="boton" id="opcion1_ref_${i}"  onclick="parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Libro con autor')">

    <input type = "button" value = "Libro con editor" class = "boton" id="opcion2_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Libro con editor')">

    <input type = "button" value = "Libro en versión electrónica" class = "boton" id="opcion3_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Libro en versión electrónica')">
    <input type = "button" value = "DOI" class = "boton" id="opcion4_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','DOI')">
    <input type = "button" value = "Capítulo de un libro" class = "boton" id="opcion5_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Capítulo de un libro')">
    <input type = "button" value = "Artículos científicos" class = "boton" id="opcion6_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Artículos científicos')">
    <input type = "button" value = "Artículo con DOI" class = "boton" id="opcion7_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Artículo con DOI')">
    <input type = "button" value = "Artículo online" class = "boton" id="opcion8_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Artículo online')">
    <input type = "button" value = "Periódico impreso u online" class = "boton" id="opcion9_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Periódico impreso u online')">
    <input type = "button" value = "Artículo de revista impreso u online" class = "boton" id="opcion10_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Artículo de revista impreso u online')">
    <input type = "button" value = "Informe de autor corporativo, informe gubernamental" class = "boton" id="opcion11_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Informe de autor corporativo, informe gubernamental')">
    <input type = "button" value = "Sinopsis y conferencias" class = "boton" id="opcion12_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Sinopsis y conferencias')">
    <input type = "button" value = "Tesis y trabajos de grado" class = "boton" id="opcion13_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Tesis y trabajos de grado')">
    <input type = "button" value = "Referencia de página web" class = "boton" id="opcion14_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Referencia de pagina web')">
    <input type = "button" value = "CD ROM" class = "boton" id="opcion15_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','CD ROM')">
    <input type = "button" value = "Enciclopedia en línea" class = "boton" id="opcion16_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Enciclopedia en línea')">
    <input type = "button" value = "Película o cinta cinematográfica" class = "boton" id="opcion17_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Película o cinta cinematográfica')">
    <input type = "button" value = "Serie de televisión" class = "boton" id="opcion18_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Serie de televisión')">
    <input type = "button" value = "Video" class = "boton" id="opcion19_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Video')">
    <input type = "button" value = "Podcast" class = "boton" id="opcion20_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Podcast')">
    <input type = "button" value = "Blogs" class = "boton" id="opcion21_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Blogs')">
    <input type = "button" value = "Grabación de música" class = "boton" id="opcion22_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Grabación de música')">
    <input type = "button" value = "Fotografias" class = "boton" id="opcion23_ref_${i}"
    onclick = "parrafo_referencias('${subir_cont}','${tipoTextArea}','${tipoInput}','${tipoDiv}','Fotografías')">
    
    `;

    /*var referencia = `<label><input type="checkbox" id="cbox1" value="first_checkbox" onclick="referencia('${tipoTextArea}','${tipoInput}','${tipoDiv},'libro con autor')"> Libro con autor</label><br><input type="checkbox" id="cbox2" value="second_checkbox" onclick="referencia('${tipoTextArea}','${tipoInput}','${tipoDiv},'libro con editor')"><label for="cbox2">Libro con editor</label>`
    ;*/

                            
    
    document.getElementsByClassName(tipoDiv+'_select')[i].innerHTML = referencia;
}
function parrafo_citar(subir_cont, tipoTextArea, tipoInput, tipoDiv, tipoCita){
    var j=0;
    var tipoTextArea1="";
    /*  Puede ser reutilizable, pero ojo con el nombre de la funcion */
    if(tipoTextArea==='resumen'){
        y=y_res;
        j=j_res;
    

    }
         
    if(tipoTextArea==='introduccion'){
        y=y_int;
        j=j_int;
    }
        
    if(tipoTextArea==='contenido'){
        y=y_conte;
        j=j_cont;
        
    }
    if(tipoTextArea==='conclusiones'){
        y=y_conc;
        j=j_conc;

    }
        
    
    var n = 0;

     /* Para que cada primer elemento de parrafo inicie con indice 0 */
    if(y>0)
        n=-1;

    if(tipoTextArea!="introduccion"){
        tipoTextArea1=tipoTextArea;
    }else{
        tipoTextArea1="introducción";
    }
        

    cita= "<label class=\"label\">Párrafo " +(y+2) + " de " +tipoTextArea1+ " hacia referencia : "+tipoCita+" (Dejar en blanco si se ingresa manualmente)</label>"+"<textarea name=\"" +subir_cont+ "[" +tipoTextArea + "]"+"[" + (y) + "]"+"[" + (++n) + "]" + "[parrafo]"+ "\" + id=\"" + tipoTextArea + " " + (++j) + "\" class =\"contenidos\" rows=\"4\" cols=\"40\" placeholder=\"Párrafo " +(y+2) + " de " +tipoTextArea1+ " hacia referencia : "+tipoCita+" (Dejar en blanco si se ingresa manualmente)\"></textarea><br>";



    config_cita(subir_cont,tipoTextArea, tipoInput, tipoDiv, tipoCita,n,y,j);

    if(tipoTextArea==='resumen')
        y_res++;
    if(tipoTextArea==='introduccion')
        y_int++;
    if(tipoTextArea==='contenido')
        y_conte++;
    if(tipoTextArea==='conclusiones')
        y_conc++;


    
}

function parrafo_referencias(subir_cont, tipoTextArea, tipoInput, tipoDiv, tipoReferencia){

    /*  Puede ser reutilizable, pero ojo con el nombre de la funcion */
    var n = 0;

    var j=0;
    


    if(tipoTextArea==='referencias'){
            i=i_ref;
            j=j_ref;
    
    }
    /* Para que cada primer elemento de parrafo inicie con indice 0 */
    if(i>0)
        n=-1;


    referencia= "<label class=\"label\">Párrafo " +(i+2) + " de " +tipoTextArea+ " hacia referencia : "+tipoReferencia+" (Nota: aquí puede poner la cita manualmente o un párrafo referenciado a una cita )</label>"+"<textarea name=\"" +subir_cont+ "[" +tipoTextArea + "]"+"[" + (i) + "]"+"[" + (++n) + "]" + "[parrafo]"+ "\" id=\"" + tipoTextArea +" "+ (++j) + "\" class =\"contenidos\" rows=\"4\" cols=\"40\" placeholder=\"Párrafo " +(i+2) + " de " +tipoTextArea+ " hacia referencia : "+tipoReferencia+" \"></textarea><br>";


    config_referencia(subir_cont,tipoTextArea, tipoInput, tipoDiv, tipoReferencia, n , i, j);

    if(tipoTextArea==='referencias')
        i_ref++;
    
}
function config_cita(subir_cont, tipoTextArea, tipoInput, tipoDiv, tipoCita, n, y, j ){
    
    var indiceInicial=j;

    if(tipoCita==="Cita basada en el autor(Cita textual y de menos de 40 palabras)"||tipoCita==="Cita basada en el autor(Cita textual y de más de 40 palabras)"||tipoCita==="Cita basada en el autor(parafraseo)"){

        cita+= "<label>Apellido-s de "+tipoCita+ " para párrafo "+(y+2)+" (Separar cada uno con coma, si son 3 a 5 autores se separan con \"comas\" si hay más de 6 autores solo se pone el primero y \"et al. \" al final)<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+"[" + (y) + "]"+ "[" + (++n) + "]" + "[apellido]"+"\" id=\"" + tipoTextArea + " " + (++j) + "\" placeholder=\"Apellido-s de autor\" class = \"contenidos\"><label><br><hr>" +

        "<label>Año de "+tipoCita+" párrafo "+(y+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (y) + "]" + "[" + (++n) + "]" + "[anio]"+ "\" id=\"" + tipoTextArea + " " + (++j) + "\" placeholder=\"Año de publicación\" class = \"contenidos\"></label><br><hr>";
    }else

    if(tipoCita==="Cita basada en el texto(Cita textual y de menos de 40 palabras)"||tipoCita==="Cita basada en el texto(Cita textual y de más de 40 palabras)"||tipoCita==="Cita basada en el texto(parafraseo)"){
        cita+= "<label>Apellido-s de "+tipoCita+ " para párrafo"+(y+2)+"(Separar cada uno con coma, si son 3 a 5 autores se separan con \"comas\" si hay más de 6 autores solo se pone el primero y \"et al.\" al final)<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+"[" + (y) + "]"+ "[" + (++n) + "]" + "[apellido]"+"\" id=\"" + tipoTextArea + " " + (++j) + "\" + placeholder=\"Apellido-s de autor\" class = \"contenidos\"></label><br><hr>" +

        "<label>Año de "+tipoCita+" para párrafo "+(y+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (y) + "]" + "[" + (++n) + "]" + "[anio]"+ "\" id=\"" + tipoTextArea + " " + (++j) + "\" placeholder=\"Año de publicación\" class = \"contenidos\"></label><br><hr>"+

        "<label>Páginas de "+tipoCita+" para párrafo (Con formato: p.número de páginas) "+(y+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (y) + "]" + "[" + (++n) + "]" + "[pagina]"+ "\" id=\"" + tipoTextArea + " " + (++j) + "\" placeholder=\"Número de páginas\" class = \"contenidos\"></label><br><hr>"
        
        
        ;
        
    }else
    if(tipoCita==="Autor corporativo"){
        cita+= "<label>Nombre de organización de "+tipoCita+ " para párrafo "+(y+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+"[" + (y) + "]"+ "[" + (++n) + "]" + "[Nom_organizacion]"+"\" id=\"" + tipoTextArea + " " + (++j) + "\" placeholder=\"Apellido-s de autor\" class = \"contenidos\"></label><br><hr>" +

        "<label>Sigla de organización de "+tipoCita+ " para párrafo "+(y+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+"[" + (y) + "]"+ "[" + (++n) + "]" + "[sigla]"+"\" id=\"" + tipoTextArea + " " + (++j) + "\" placeholder=\"Apellido-s de autor\" class = \"contenidos\"></label><br><hr>"+

        "<label>Año de "+tipoCita+" para párrafo "+(y+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (y) + "]" + "[" + (++n) + "]" + "[anio]"+ "\" id=\"" + tipoTextArea + " " + (++j) + "\" placeholder=\"Año de publicacion\" class = \"contenidos\"></label><br><hr>";
    }else 
    if(tipoCita==="Anónimo"){
        cita+= "<label>El apellido ponemos como 'Anónimo' "+tipoCita+ " para párrafo "+(y+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+"[" + (y) + "]"+ "[" + (++n) + "]" + "[apellido]"+"\" id=\"" + tipoTextArea + " " + (++j) + "\" placeholder=\"Apellido-s de autor\" class = \"contenidos\"></label><br><hr>" +

        "<label>Año de "+tipoCita+" para párrafo "+(y+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (y) + "]" + "[" + (++n) + "]" + "[anio]"+ "\" id=\"" + tipoTextArea + " " + (++j) + "\" placeholder=\"Año de publicación\" class = \"contenidos\"></label><br><hr>"+

        "<label>Paginas de "+tipoCita+" para párrafo (Con formato: p.número de páginas) "+(y+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (y) + "]" + "[" + (++n) + "]" + "[pagina]"+ "\" id=\"" + tipoTextArea + " " + (++j) + "\" placeholder=\"Número de páginas\" class = \"contenidos\"></label><br><hr>"
        
        
        ;
        
    }else
    if(tipoCita==="Cita de una cita"){
        cita+= "<label>Apellido-s de autor de opinión o afirmación de "+tipoCita+ " para párrafo "+(y+2)+"(Separar cada uno con coma, si son 3 a 5 autores se separan con \"comas\" si hay más de 6 autores solo se pone el primero y \"et al.\" al final)<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+"[" + (y) + "]"+ "[" + (++n) + "]" + "[apellido]"+"\" id=\"" + tipoTextArea + " " + (++j) + "\" placeholder=\"Apellido-s de autor\" class = \"contenidos\"></label><br><hr>" +

        "<label>Apellido-s de autor de la cita "+tipoCita+ " para párrafo "+(y+2)+"(Separar cada uno con coma, si son 3 a 5 autores se separan con \"comas\" si hay más de 6 autores solo se pone el primero y \"et al.\" al final)<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+"[" + (y) + "]"+ "[" + (++n) + "]" + "[apellido]"+"\" id=\"" + tipoTextArea + " " + (++j) + "\" placeholder=\"Apellido-s de autor\" class = \"contenidos\"></label><br><hr>"+

        "<label>Año de"+tipoCita+"para párrafo"+(y+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (y) + "]" + "[" + (++n) + "]" + "[anio]"+ "\" id=\"" + tipoTextArea + " " + (++j) + "\" placeholder=\"Año de publicación\" class = \"contenidos\"></label><br><hr>";
    }




    cita+= "<br><br><br><br><hr>" + "<div class=\"" + tipoDiv + "\"></div>";

    if(tipoTextArea==='resumen'){
        y=y_res;
        j_res=j;
    

    }
         
    if(tipoTextArea==='introduccion'){
        y=y_int;
        j_int=j;
    }
        
    if(tipoTextArea==='contenido'){
        y=y_conte;
        j_cont=j;
        
    }
    if(tipoTextArea==='conclusiones'){
        y=y_conc;
        j_conc=j;

    }


    document.getElementsByClassName(tipoDiv)[y].innerHTML = cita;



    if(document.body.contains(document.getElementById(tipoTextArea +' '+indiceInicial))){
        document.getElementById(tipoTextArea +' '+indiceInicial).focus();
        artyom.say(tipoCita+". "+(j+1)+"input totales. "+"Enfocado en el primero, elemento "+(parseInt(indiceInicial)+1)+" de "+tipoTextArea);
        }

   /* Para enfocar el primer elemento creado e informar al usuario*/
}


function config_referencia(subir_cont, tipoTextArea, tipoInput, tipoDiv, tipoReferencia, n,i, j){

    var indiceInicial=j;

    if(tipoReferencia==="Libro con autor"){

        referencia+= "<label>Apellido-s de "+tipoReferencia+ " para párrafo "+(i+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+"[" + (i) + "]"+ "[" + (++n) + "]" + "[apellido]"+"\" id=\"" + tipoTextArea +" "+ (++j) + "\" placeholder=\"Apellido-s de autor\" class = \"contenidos\"></label><br><hr>" +

        "<label>Iniciales de nombre-s "+tipoReferencia+"para párrafo "+(i+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (i) + "]"+ "[" + (++n) + "]" + "[nombre]" + "\" id=\"" + tipoTextArea +" "+ (++j) + "\" placeholder=\"Iniciales de nombre-s ( separadas por punto )\" class = \"contenidos\"></label><br><hr>" + 

        "<label>Año de "+tipoReferencia+"para párrafo "+(i+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (i) + "]" + "[" + (++n) + "]" + "[anio]"+ "\" id=\"" + tipoTextArea +" "+ (++j) + "\" placeholder=\"Año de publicación\" class = \"contenidos\"></label><br><hr>"+

        "<label>Título de "+tipoReferencia+"para párrafo"+(i+2)+"<input type=\"text\"" + " name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (i) + "]" + "[" + (++n) + "]" + "[titulo]"+"\" id=\"" + tipoTextArea +" "+ (++j) + "\" placeholder=\"Título de la publicación\" class = \"contenidos\"></label><br><hr>" +
    
        "<label>Ciudad de "+tipoReferencia+"para párrafo "+(i+2)+"<input type=\"text\"" + " name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (i) + "]"+"[" + (++n) + "]" + "[ciudad]"+"\" id=\"" + tipoTextArea +" "+ (++j) + "\" placeholder=\"Ciudad\" class = \"contenidos\"></label><br><hr>" +

        "<label>País de"+tipoReferencia+" para párrafo "+(i+2)+"<input type=\"text\"" + " name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (i) + "]"+"[" + (++n) + "]" + "[pais]"+"\" id=\"" + tipoTextArea +" "+ (++j) + "\" placeholder=\"País\" class = \"contenidos\"></label><br><hr>" +

        "<label>Editorial de"+tipoReferencia+" para párrafo "+(i+2)+"<input type=\"text\"" + " name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (i) + "]"+"[" + (++n) + "]" + "[editorial]"+"\" id=\"" + tipoTextArea +" "+ (++j) + "\" placeholder=\"Editorial\" class = \"contenidos\"></label><br><hr>" ;
      

    }else
    if(tipoReferencia==="Libro con editor"){
        referencia+= "<label>Apellido-s de "+tipoReferencia+ " para párrafo "+(i+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+"[" + (i) + "]"+ "[" + (++n) + "]" + "[apellido]"+"\" id=\"" + tipoTextArea +" "+ (++j) + "\" placeholder=\"Apellido de autor\" class = \"contenidos\"></label><br><hr>" +

        "<label>Iniciales de nombre-s "+tipoReferencia+"para párrafo "+(i+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (i) + "]"+ "[" + (++n) + "]" + "[nombre]" + "\" id=\"" + tipoTextArea +" "+ (++j) + "\" placeholder=\"Iniciales de nombre-s ( separadas por punto)\" class = \"contenidos\"></label><br><hr>" + 
        "<label>(Ed) de"+tipoReferencia+" para párrafo(no necesita modificarse)"+i+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (i) + "]" + "[" + (++n) + "]" + "[anio]"+ "\" id=\"" + tipoTextArea +" "+ (++j) + "\"  class = \"contenidos\"></label><br><hr>"+

        "<label>Año de "+tipoReferencia+"para párrafo "+(i+2)+"<input type=\"text\"" + "name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (i) + "]" + "[" + (++n) + "]" + "[anio]"+ "\" id=\"" + tipoTextArea +" "+ (++j) + "\" placeholder=\"Año de publicación\" class = \"contenidos\"></label><br><hr>"+

        "<label>Título de "+tipoReferencia+"para párrafo "+(i+2)+"<input type=\"text\"" + " name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (i) + "]" + "[" + (++n) + "]" + "[titulo]"+"\" id=\"" + tipoTextArea +" "+ (++j) + "\" placeholder=\"Título de la publicación\" class = \"contenidos\"></label><br><hr>" +
    
        "<label>Ciudad de "+tipoReferencia+" para párrafo"+(i+2)+"<input type=\"text\"" + " name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (i) + "]"+"[" + (++n) + "]" + "[ciudad]"+"\" id=\"" + tipoTextArea +" "+ (++j) + "\" placeholder=\"Ciudad\" class = \"contenidos\"></label><br><hr>" +

        "<label>País de "+tipoReferencia+" para párrafo"+(i+2)+"<input type=\"text\"" + " name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (i) + "]"+"[" + (++n) + "]" + "[pais]"+"\" id=\"" + tipoTextArea +" "+ (++j) + "\" placeholder=\"País\" class = \"contenidos\"></label><br><hr>" +

        "<label>Editorial de "+tipoReferencia+" para párrafo"+(i+2)+"<input type=\"text\"" + " name=\"" +subir_cont+ "[" +tipoTextArea + "]"+ "[" + (i) + "]"+"[" + (++n) + "]" + "[editorial]"+"\" id=\"" + tipoTextArea +" "+ (++j) + "\" placeholder=\"Editorial\" class = \"contenidos\"></label><br><hr>" ;
    }else{
        artyom.say("Solo las 2 primeras referencias disponibles, pero se creará un párrafo nuevo");
    }



    referencia+= "<br><br><br><br><hr>" + "<div class=\"" + tipoDiv + "\"></div>";
    if(tipoTextArea==='referencias'){

        j_ref=j;
        i=i_ref;

    }

    document.getElementsByClassName(tipoDiv)[i].innerHTML = referencia;


        /* Comentario:
            Si se hace click de manera iterativa, se puede invocar a varios eventos y como  (document.getElementsByClassName(tipoDiv)[i].innerHTML) que sabemos que se llama al elemento que desde un inicio esta vacio(al crearlo), simplemente absorvera lo que tiene y asignara un valor, RECORDAR que NO es una variable GLOBAL, y recordar que en tiempo de ejecucion primero se intenta llamar al  <div class=\""+tipoDiv+"\"></div> y si no existe en codigo html y dara un error pues no esta definido aun y al parecer no permite inicializar algo que aun no existe, simplemente no se prodra ejecutar, a partir del 2do elemento como ya seria un tipo DIV que seria el 2do pues los inputs de la primera ejecucion serian los primeros de su tipo, se puede invocar sin problemas este nuevo div "ya creado" pues existe, en tiempo de ejecucion siempre se crea un div que seria un grado+1 superior, desde un inicio el div cero tipoDiv solo  se sobreescribe pues ya existe  
            
            Esto se agregaria para otro boton de citar:
            +`<input type=\"button\" value= \"Citar\" class=\"boton\" onclick=\"citar('${tipoTextArea}', '${tipoInput}','${tipoDiv}')\">` + "<div class=\"" + tipoDiv + "\"></div>";

    
        */
       if(document.body.contains(document.getElementById(tipoTextArea +' '+indiceInicial))){
        document.getElementById(tipoTextArea +' '+indiceInicial).focus();
        artyom.say(tipoReferencia+". "+(j+1)+"input totales. "+"Enfocado en el primero, elemento "+(parseInt(indiceInicial)+1)+" de "+tipoTextArea);
        }

   /* Para enfocar el primer elemento creado  e informar al usuario*/

}


window.addEventListener("load", iniciar, false);