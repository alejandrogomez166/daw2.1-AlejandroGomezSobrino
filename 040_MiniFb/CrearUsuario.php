<?php
require_once"_Varios.php";
?>

<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>
<h1>Cración de nuevo usuario</h1>

<form action="CrearUsuario.php" method="post">
	<label>Nombre de usuario</label>
	<input type="text" name="usuarion">
	<br>
	<label>Contraseña</label>
	<input type="text" name="contrasennan">
	<br>
	<label>Repite la contraseña</label>
	<input type="text" name="contrasennanc">
	<br>
	<label>Nombre</label>
	<input type="text" name="nombre">
	<br>
	<label>Apellido</label>
	<input type="text" name="apellido">
	<br>
	<input type="submit" value="Crear Cuenta">
</form>
</body>

</html>

<?php
	

if (isset($_REQUEST["contrasennan"])&& isset($_REQUEST["usuarion"])) {
	$contrasenna = $_REQUEST["contrasennan"];
	$compcontrasenna = $_REQUEST["contrasennanc"];
	$usuario = $_REQUEST["usuarion"];
	$nombre = $_REQUEST["nombre"];
	$apellido = $_REQUEST["apellido"];

	if($contrasenna != $compcontrasenna || $contrasenna==null || $compcontrasenna== null){
		echo "Las contraseñas no coinciden";
}
	elseif(comprobarUsuario($usuario)){
		echo " El usuario que quieres usar ya esta siendo utilizado";


}
	else 
	//metodo que crea el usuario
	$id=dameID();
	//crearUsuario($id,$usuario,$contrasenna,$nombre,$apellido);

	//redireccionar("SesionInicioMostrarFormulario.php");
}







?>