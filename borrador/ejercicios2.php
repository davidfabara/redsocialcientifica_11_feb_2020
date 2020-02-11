<?php 
    ob_start()
?>
<?php
    require('proto.php');


    echo "bien<br><hr>";

    $x = "3";
    $y = "2";
    $z = "3";
    $y = array("uno" => "1", "dos" => "2", 3, "tres" => array("uno" => "1", "dos" => "2", array("uno" => "1", "dos" => "2", 3)));
    var_dump($y);
    echo "<hr>", 'El elemento $y["tres"][0][0] es: ', "<br>", var_dump($y["tres"][0][0]);


    echo "<hr>$x y $z podemos ver que no se aplica el conflicto de comillas anidadas";

?>
<!Doctype html>
<html>
<head>
<script src="ejercicios.js"></script>
<link rel="stylesheet" href="ejercicios.css" />
</head
<body>
    <p><h1 onclick=mostrar()>click</h1>
    </p>

    <p id="textoInsertado"><h1 onclick=mostrar()>textoX</h1></p>
    <a href="<?php $_SERVER['PHP_SELF'];/* ; */ ?>">Recargar</a>
</body>
</html>
<?php 
    ob_end_flush()
?>