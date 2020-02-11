<?php echo "Array de unidimensional (1,2) 1 fila y 2 columnas"."\n<br><br><hr>"; 


?>

<?php  
$array = array(array(1,2,3,4,5),array(1,4,6,8,10));
echo 'El array es : $array = array(array(1,2,3,4,5),array(1,4,6,8,10));',"<br>Recorriendo el primer elemento del :",'$array',"multiplicando por 2<hr>";
foreach($array[0] as &$valor)
    $valor=$valor*2; /*La direccion de $valor pasa a ser la del array, lo que le pase a $valor le pasara al array*/
foreach($array[0] as $clave => $valor2)
    echo "$clave .... $valor2<hr>";
/* La clave implica el indice del arreglo*/
echo "Ahora rrecorriendo un array bidimensional, el primero los 2 array secundarios y el segundo los elementos individuales de esos arrays primero´s: <br>";
    foreach($array as $primer)
        foreach($primer as $clave=>$segundo)
            echo "$clave .... $segundo<hr>";

echo "Ahora analizar un array tridimensional del array: ".'$arrayTri = array(array(array(1,2,3,4,5),array(1,4,6,8,10)),array(array(1,8,12,16,20),array(2,16,24,32,40));'."<hr>";

$arrayTri = array(array(array(1,2,3,4,5),array(1,4,6,8,10)),array(array(1,8,12,16,20),array(2,16,24,32,40)));
                  
foreach($arrayTri as $primer)
        foreach($primer as $segundo)
        foreach($segundo as $clave=>$tercero)
            echo "$clave .... $tercero<hr>";

?>
<?php
    echo "Las variables de los otras secciones  PHP declaradas, se comportan como variables globales en las siguientes secciones de codigo.<br>El elemento".'$arrayTri[0][1][3] es: '.$arrayTri[0][1][3];
?>

<?php
    echo "<br><br><hr><em>Ahora insertaremos valores al final de cada array (tenemos 2) en el arreglom principal de ahi bidimensional de un array","utilizaremos como ejemplo el array bidimensional :</em> ",'$array = array(array(1,2,3,4,5),array(1,4,6,8,10));',"<br><br><hr>";
   
    foreach($array as $primer){
        array_push($primer,100);
        foreach($primer as $clave=>$segundo){
             echo "$clave .... $segundo<hr>";
    
        }
    }
        echo "Ahora el array ahora es :".'array(array(2,4,6,8,10,100),array(1,4,6,8,10,100));',"<br><br><hr>";
           
    
?>

<?php
    echo "Ahora eliminar ese mismo elemento agregado para quedarnos con el array bidimensional originalmente planteado, ".'usaremos unset($variableAeliminar):'."el objetivo es quedarnos con el array original pero agregado con 100 al ultimo de cada array individual del mas grande como :". 'array(array(2,4,6,8,10,100),array(1,4,6,8,10,100)); borrando unset($array[0][5], $array[1][5]);',"<br><br><hr>";


    
    unset($array[0][5], $array[1][5]);
    echo "Ahora el arreglo ",'$array nos queda aplicando unset(): ',var_dump($array),"<hr>";
    /* NOta : TODO(0): Intenete ubicar la instruccion unset(..) dentro del foreach con comportamientos extraños, por ello los ubique aqui en el inicio*/
    $i=0;$j=0;
    foreach($array as $primer){
        //$ultimo=end($primer);
        
        foreach($primer as $clave=>$segundo){
            
            echo "$clave .... $segundo<hr>";
                unset($array[$i][$j]);
            
            $j++;
            }
        $j=0;
        $i++;
        
        }
echo "Ahora el arreglo finalmente eliminando los elementos individuales del ",'$array nos queda un array bidimensional vacio sin elementos de ningun tipo: ',var_dump($array),"<br><hr>";
   
/* Lo que hacemos es nuevamente agisnar al $array con los valores supuestamente inciales pero los volvemos a asignar con los de por defecto pero agregados con 100(manualmente), luego iteramos y con unset() solo cuando el argumento coincida con el elemento corrable en este caso cuando el condicional ocupa la 6ta posicion, indice 5, lo que pasa es que se ejecuta el unset en 2 iteraciones en cada foreach, ahora foreach no funciona igual   que un for, las variables i,j cambian en tiempo de ejecucion y como en ninguna ocasion los foreach controlan sus incrementos, debemos a $j=0; puesto que adquiere el maximo indice de cada subarray en cada iteracion*/
    

?>
<?php
/* Array asiociativo multidimensional (tridimensional) */

echo "<hr><hr>CON UN ARRAY ASOCIATIVO MULTIDIMENSIONAL: <br><br>";
$arrayTri = array("PRIMER ARRAY"=>array(array("UNO"=>1,"DOS"=>2,"TRES"=>3,"CUATRO"=>4),array(1,4,6,8,10)),"SEGUNDO ARRAY"=>array(array(1,8,12,16,20),array(2,16,24,32,40)));
echo "El array aosciativo de :","\$arrayTri = array(\"PRIMER ARRAY\"=>array(array(\"UNO\"=>1,\"DOS\"=>2,\"TRES\"=>3,\"CUATRO\"=>4),array(1,4,6,8,10)),array(array(1,8,12,16,20),array(2,16,24,32,40)));","es: con 'var_dump()'<br><br>".var_dump($arrayTri),"<br><br>";
                  
foreach($arrayTri as $clave1=>$primer){
    echo "Elementos del array, el array principal: ",var_dump($arrayTri[$clave1]),"<br><br>";
    foreach($primer as $clave2=>$segundo){ 
        echo "Elementos del array, el array secundario: ",var_dump($primer[$clave2]),"<br>";
        foreach($segundo as $clave=>$tercero){
            echo "$clave .... $tercero<br>";
        }
        
    }
       

}
        

echo "el elemento \$arrayTri[\"PRIMER ARRAY\"][0][\"UNO\"] es : ".$arrayTri["PRIMER ARRAY"][0]["UNO"]."<br><br><br>","<br>el elemento \$arrayTri[\"PRIMER ARRAY\"][0][1] es :",$arrayTri["PRIMER ARRAY"][1][1],"<hr><hr>";


            

?>



<?php
 echo "Ahora a ordenar los elementos del array, hemos nuevamente asignado los valores iniciales al array:".'$array= array(array(1,2,3,4,5),array(1,4,6,8,10));';
$array= array(array(100,1,2,3,4,5),array(100,1,4,6,8,10));
echo "el array SIN ordenar es: ",var_dump($array),"<br><hr>";
sort($array);
echo "el array ordenado es:",var_dump($array),"<br><hr>";



?>
<?php

    function elementosLista(){
        $uno="uno";
        $dos="dos";
        $tres=3;
        return array($uno,$dos,$tres);
    }
    list($un,$do,$tre)=elementosLista();

    echo "Los 3 numeros en lista y aignando a 3 variables inicializadas y declaradas con el emenento LIST de php, tenemos : $un, $do, $tre";

?>
<?php
//TIPOS DE DATOS, DECLARACION ESCALAR
// MODO COERCITIVO:
function suma(int $a, int $b){
    return $a+$b;
}
echo "retorna la suma de un String(6)+int(5), pero a la final php los interpreta como la suma de 2 valores enteros: ";
var_dump(suma('6',5));


?>
<?php
echo "<br><hr>Como a una misma variable en php se le pueden asignar distintos tipos de datos<br><hr>";
 $var="valorString";
 var_dump($var);
 $var=2;
 var_dump($var);
 $var=array(2,4,5);
 var_dump($var);
 ?>

<?php
 	
date_default_timezone_set('America/New_York');/* Esta instruccion es importante, de lo contrario nos ubica en otra zona horaria*/

echo "<br><hr>Ahora un ejercicio con el tiempo: <hr>";

setLocale(LC_ALL, "es_ES");/* Esta instruccion es para que las fechas y horas de strftime es stablezcan en espanol*/

echo "El mes es: ",date("F")." , El dia del mes con 2 digitos es: ".date("j").", el dia de la semana es: ". date("N")." , en la hora: ".date("g").date("a")."con minutos".date("i")."<br><hr>";

echo "ahora modificando la fecha por funciones en español:";

echo "es (con una variable basada en las cookies: )".date(DATE_COOKIE)."<hr>";

echo strftime("Hoy es %A y son las %H:%M");
echo strftime("El año es %Y y el mes es %B");

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Arrays multidimensionales</title>
</head>

<body>
    <section><a></a></section>
</body>

</html>
