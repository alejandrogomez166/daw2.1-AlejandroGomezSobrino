<?php


require_once"_Varios.php";



// TODO ...$_REQUEST["..."]...
$identificador = $_REQUEST['identificador'];
$contrasenna = $_REQUEST['contrasenna'];
// TODO Verificar (usar funciones de _Varios.php) identificador y contrasenna recibidos y redirigir a ContenidoPrivado1 (si OK) o a iniciar sesión (si NO ok).

$arrayUsuario = obtenerUsuario($identificador, $contrasenna);

if ($arrayUsuario) { // HAN venido datos: identificador existía y contraseña era correcta.
    // TODO Llamar a marcarSesionComoIniciada($arrayUsuario) ...

    // TODO Redirigir.
    redireccionar("ContenidoPrivado1.php");
} else {
	redireccionar("SesionInicioMostrarFormulario.php");
    // TODO Redirigir.
}