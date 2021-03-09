<?php

require_once "_Varios.php";
require_once "DAO.php";


$identificador = $_REQUEST["identificador"];
$contrasenna = $_REQUEST["contrasenna"];
$contrasenna2 = $_REQUEST["contrasenna2"];
$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];

//Si las contraseñas no coinciden
if($contrasenna != $contrasenna2){
    redireccionar("UsuarioNuevoFormulario.php?datosErroneos");
}

//Si ya existe un usuario con ese identificador
if(DAO::buscaUsuarioIdentificador($identificador) == 1){
    redireccionar("UsuarioNuevoFormulario.php?identificadorErroneo");
}


$usuarioCreado = DAO::crearUsuario($identificador, $contrasenna, $nombre, $apellidos);

if($usuarioCreado == 1){
    redireccionar("SesionInicioFormulario.php");
} else {
    redireccionar("UsuarioNuevoFormulario.php?datosErroneos");
}