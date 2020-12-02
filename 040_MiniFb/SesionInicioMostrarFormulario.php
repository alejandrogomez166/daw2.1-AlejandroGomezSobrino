<?php

?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Iniciar Sesión</h1>

llamad a los campos IGUAL que en la BD:
<form action="SesionInicioComprobar.php"method="post">
	<label>Identificador</label>
	<input type="text" name="identificador">
	<label>Contraseña</label>
	<input type="text" name="contrasenna">
	<input type="submit" value="enviar">
</form>


</body>

</html>