<!DOCTYPE html>
<html>
<head>
    <title>Ejemplo</title>
</head>
<body>

<?php
$array = array("Ecatepec","Guadalajara","Puebla","Tijuana","Ciudad Juarez");
$array[6] = "Zapopan";


$ciudadMexico["1"] = "Monterrey";
$ciudadMexico["3"] = "Reynosa";

foreach ($array as $contenido) {
	echo $contenido;
}



?>

</body>
</html>