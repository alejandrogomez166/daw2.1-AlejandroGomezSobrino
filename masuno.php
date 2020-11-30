<?php
//no funciona la parte del segundo formulario
$conta = 0;
$numero = "null";
if (isset($_POST["conta"])){

$conta = $_POST["conta"] + 1 ;
}


if(isset($_POST["numero"])){

$conta = intval($_POST["numero"]);
}


echo $conta;
?>


<html>

 
<form name="f1"  method="post">
<input type="hidden" name="conta" value="<?=$conta?>">
<input type="submit" value="Incrementar">





</form>
 <form name="f2"  method="post">

<input type = "hidden" name="numero" value="<?=$numero?>">
<input type="text"  value="Cambia el número">
</form>


</html>