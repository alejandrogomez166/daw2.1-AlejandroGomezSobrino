<?php

    require_once "_com/_Varios.php";
    require_once "_com/DAO.php";

    if (haySesionRamIniciada()) redireccionar("MuroVerGlobal.php");

    $datosErroneos = isset($_REQUEST["datosErroneos"]);

    $identificadorErroneo = isset($_REQUEST["identificadorErroneo"]);

?>

<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<h1>Crear nuevo usuario</h1>

<?php if ($datosErroneos) { ?>
    <p style='color: #ff0000;'>No se ha podido iniciar sesión con los datos proporcionados. Inténtelo de nuevo.</p>
<?php } ?>

<?php if ($identificadorErroneo) { ?>
    <p style='color: #ff0000;'>Ya existe un usuario con ese identificador. Inténtelo de nuevo.</p>
<?php } ?>

<form action='UsuarioNuevoCrear.php' method="post">
    <label for='identificador'>Identificador</label>
    <input type='text' name='identificador'><br><br>

    <label for='contrasenna'>Contraseña</label>
    <input type='password' name='contrasenna' id='contrasenna'><br><br>

    <label for='contrasenna2'>Confirma la contraseña</label>
    <input type='password' name='contrasenna2' id='contrasenna2'><br><br>

    <label for='nombre'>Nombre</label>
    <input type='text' name='nombre'><br><br>

    <label for='apellidos'>Apellidos</label>
    <input type='text' name='apellidos'><br><br>

    <input type='submit' value='Crear usuario'>
</form>

<p>¿Ya tiene cuenta? <a href='SesionInicioFormulario.php'>¡Inicie sesión aquí!</a>.</p>

</body>

</html>