<?php

?>

<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>
<h1>Creación de nuevo usuario</h1>

<form action="CrearUsuario.php" method="post">
	<label>Nombre de usuario</label>
	<input type="text" name="usuario">
	<br>
	<label>Contraseña</label>
	<input type="text" name="contrasenia">
	<br>
	<label>Repite la contraseña</label>
	<input type="text" name="contraseniaC">
	<br>
	<input type="submit" value="Crear Cuenta">
</form>
</body>

</html>
<?php
if (isset($_REQUEST["contrasenia"])) {
	$contrasenia = $_REQUEST["contrasenia"];
$compcontrasenia = $_REQUEST["contraseniaC"];

if($contrasenia != $compcontrasenia){
	echo "Las contraseñas no coinciden";
}

}



?>