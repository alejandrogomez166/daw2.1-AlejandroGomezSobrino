<?php

declare(strict_types=1);
session_start();
function obtenerPdoConexionBD(): PDO
{
    $servidor = "localhost";
    $bd = "MiniFb";
    $identificador = "root";
    $contrasenna = "";
    $opciones = [
        PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];

    try {
        $conexion = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
    } catch (Exception $e) {
        error_log("Error al conectar: " . $e->getMessage()); // El error se vuelca a php_error.log
        exit('Error al conectar'); //something a user can understand
    }

    return $conexion;
}
//acabar
function obtenerUsuario(string $identificador, string $contrasenna): ?array
{
	$conexionBD= obtenerPdoConexionBD();
	//consulta de sql para ver si existe el user y la contraseña
	$sql = 'SELECT * FROM Usuario WHERE identificador =? AND contrasenna =?';
	$consulta = $conexionBD->prepare($sql);
	//ejecutamos la consulta
	$consulta->execute([$identificador, $contrasenna]);
	$rs = $consulta->fetchAll();

	if($consulta->rowCount()==1){
		 return $user = array('id'=> $rs[0]['id'], 'identificador' => $rs[0]['identificador'],'contrasenna' => $rs[0]['contrasenna']);
	}
	else{
		return null;
	}
    // TODO Pendiente hacer.

    // "SELECT * FROM Usuario WHERE identificador=? AND contrasenna=?"

    // Conectar con BD, lanzar consulta, ver si viene 1 fila o ninguna...

    // Devolver una cosa u otra para que sepan (true/false).
    //return $rs[0];
    
}

function marcarSesionComoIniciada(array $arrayUsuario)
{	
	
	
	$_SESSION["id"]= $arrayUsuario['id'];
	$_SESSION["identificador"]= $arrayUsuario['identificador'];
	
    // TODO Anotar en el post-it todos estos datos:
    // $_SESSION["id"] = ...
    // $_SESSION["identificador"] = ...
    // ...
}

function haySesionIniciada(): bool
{
    
	if (isset($_SESSION["id"])) {
		
		return true;

		
	}
	else
	{
    // TODO Pendiente hacer la comprobación.

    // Está iniciada si isset($_SESSION["id"])

    return false;
}
}
function cerrarSesion()
{
	session_destroy();
	unset($_SESSION["id"]);
	unset($_SESSION["identificador"]);
	

    // TODO session_destroy() y unset de $_SESSION (por si acaso).
}

// (Esta función no se utiliza en este proyecto pero se deja por si se optimizase el flujo de navegación.)
// Esta función redirige a otra página y deja de ejecutar el PHP que la llamó:
function redireccionar(string $url)
{
    header("Location: $url");
    exit;
}

function syso(string $contenido)
{
    file_put_contents('php://stderr', $contenido . "\n");
}