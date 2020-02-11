
var inputs=".";
function iniciar(){
    
   


}
function mostrarInputs(usuario,usuario1){
   
    inputs+=document.getElementById(usuario).value +" , "+document.getElementById(usuario1).value+"; ";
    
    document.getElementById("mostrarInputs").innerHTML="<h1>"+inputs+"</h1>";
    
}
function mostrarEnInput(){
    document.getElementById("mostrar_un_input_con_todos_los_inputs").innerHTML="<input type= \"text\" name=\"inputRaro\" value= \""+inputs+"\">";
    paraFormularioFinal();
}
function paraFormularioFinal(){
    document.getElementById("insertarInputForm").innerHTML="<form name= \"form\" method=\"post\"><input type=\"text\" name=\"formularioFinal\"  value= \""+inputs+"\"></input><input type=\"submit\" name=\"submit\"></form>";
     
        
        

    
    
}





window.addEventListener('load',iniciar,false);