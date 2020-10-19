<?php 

// variables pasadas
$tipo = $_REQUEST["Calculadora"];
$num = $_REQUEST["numero"];
$num2 = $_REQUEST["numero2"];
$valor =0;
$texto = "la $tipo de $num y $num2 es igual a ";
//vemos la operación que hay que hacer
switch($tipo){
	case "sum":
	$valor= $num + $num2;
	
	echo $texto . $valor;
	break;

	case "res" :
	$valor = $num - $num2;
	echo $texto . $valor;
	break;

	case "mul":
	$valor = $num * $num2;
	echo $texto . $valor;
	break;

	case 'div':
	if($num2 == 0){
		echo "La division no se puede hacar porque no se puede dividir por cero";
		break;
	}
	$valor = $num / $num2;

	echo $texto . $valor;
	break;

	default :
	echo "Cómo has llegado aqui?";

}





?>