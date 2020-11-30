<?php

    $numero = (int) $_REQUEST["numero"];

    if (isset($_REQUEST["intento"])) { 
        $intento = (int) $_REQUEST["intento"];

        $contador = (int) $_REQUEST["contador"] + 1;


       }

       else { 
         $intento = null;

        $contador = 0;
    }

?>


<!DOCTYPE html>
<html>

<head>
    <title>Adivina el número</title>
</head>

<body>

<h1>adivina</h1>


<?php

    if ($intento == null) {
       
    } elseif ($intento < $numero) {
        echo "<p>El número es mayor </p>";
    } elseif ($intento > $numero) {
        echo "<p>El número es menor </p>";
    } else {
        echo "<p>Has ganado,el número es $numero y has tenido $contador intentos.</p>";
    }



    if ($intento != $numero) { 
?>

        <form method="post">

            <p> Introduce un número</p>
            <input type="hidden" name="numero" value="<?=$numero?>">
            <input type="number" name="intento">

            <input type="hidden" name="contador" value="<?=$contador?>">
            

            <input type="submit" value="Adivinar">
        </form>

<?php
    }
?>

</body>

</html>