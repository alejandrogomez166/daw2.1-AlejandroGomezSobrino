<?php

require_once "Clases.php";
require_once "_Varios.php";

class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "minifb"; // Schema
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false, // Modo emulación desactivado para prepared statements "reales"
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Que los errores salgan como excepciones.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // El modo de fetch que queremos por defecto.
        ];

        try {
            $pdo = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage());
            exit("Error al conectar" . $e->getMessage());
        }

        return $pdo;
    }

    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rs = $select->fetchAll();

        return $rs;
    }

    // Devuelve:
    //   - null: si ha habido un error
    //   - 0, 1 u otro número positivo: OK (no errores) y estas son las filas afectadas.
    private static function ejecutarActualizacion(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        if (!$sqlConExito) return null;
        else return $actualizacion->rowCount();
    }

    /* USUARIO */
    public static function crearUsuario(string $identificador, string $contrasenna, string $nombre, string $apellidos)
    {
        $consulta = "INSERT INTO usuario (identificador, contrasenna, codigoCookie, caducidadCodigoCookie, tipoUsuario, nombre, apellidos) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $parametros = [$identificador, $contrasenna, NULL, NULL, 0, $nombre, $apellidos];

        return self::ejecutarActualizacion($consulta, $parametros);
    }

    public static function  buscaUsuarioIdentificador(string $identificador)
    {
        $consulta = "SELECT * FROM usuario WHERE identificador=?";
        $parametros = [$identificador];

        return self::ejecutarActualizacion($consulta, $parametros);
    }


    public static function obtenerUsuarioPorContrasenna(string $identificador, string $contrasenna): ?Usuario
    {
        $consulta = "SELECT * FROM Usuario WHERE identificador=? AND BINARY contrasenna=?";
        $parametros = [$identificador, $contrasenna];

        $rs = self::ejecutarConsulta($consulta, $parametros);

        $usuario = new Usuario($rs[0]["id"], $rs[0]["identificador"], $rs[0]["contrasenna"], $rs[0]["codigoCookie"], $rs[0]["caducidadCodigoCookie"],
            $rs[0]["tipoUsuario"], $rs[0]["nombre"], $rs[0]["apellidos"]);

        return $usuario;

    }

    public static function obtenerUsuarioPorId(string $id): ?Usuario
    {
        $consulta = "SELECT * FROM Usuario WHERE id=?";
        $parametros = [$id];

        $rs = self::ejecutarConsulta($consulta, $parametros);

        $usuario = new Usuario($rs[0]["id"], $rs[0]["identificador"], $rs[0]["contrasenna"], $rs[0]["codigoCookie"], $rs[0]["caducidadCodigoCookie"],
            $rs[0]["tipoUsuario"], $rs[0]["nombre"], $rs[0]["apellidos"]);

        return $usuario;


    }

    public static function obtenerUsuarioPorCodigoCookie(string $identificador, string $codigoCookie): ?array
    {
        $consulta = "SELECT * FROM Usuario WHERE identificador=? AND BINARY codigoCookie=?";
        $parametros = [$identificador, $codigoCookie];

        $rs = self::ejecutarConsulta($consulta, $parametros);

        // $rs[0] es la primera (y esperemos que única) fila que ha podido venir. Es un array asociativo.
        if(self::ejecutarActualizacion($consulta, $parametros) == 1){
            return $rs[0];
        } else{
            return null;
        }
    }

    public static function actualizarUsuarioEnBd(string $id, string $identificador, string $nombre, string $apellidos, string $contrasenna)
    {
        $consulta = "UPDATE usuario SET identificador=?, contrasenna=?, nombre=?, apellidos=? WHERE id=?";
        $parametros = [$identificador, $contrasenna, $nombre, $apellidos, $id];

        return self::ejecutarActualizacion($consulta, $parametros);
    }

    /* COOKIES */
    public static function actualizarCodigoCookieEnBD(?string $codigoCookie)
    {
        $consulta = "UPDATE Usuario SET codigoCookie=? WHERE id=?";
        $paramentros = [$codigoCookie, $_SESSION["id"]];

        self::ejecutarActualizacion($consulta, $paramentros);

        // TODO Para una seguridad óptima convendría anotar en la BD la fecha de caducidad de la cookie y no aceptar ninguna cookie pasada dicha fecha.
    }

    function establecerSesionCookie(Usuario $usuario)
    {
        // Creamos un código cookie muy complejo (no necesariamente único).
        $codigoCookie = generarCadenaAleatoria(32); // Random...

        self::actualizarCodigoCookieEnBD($codigoCookie);

        // Enviamos al cliente, en forma de cookies, el identificador y el codigoCookie:
        setcookie("identificador", $usuario->getIdentificador(), time() + 600);
        setcookie("codigoCookie", $codigoCookie, time() + 600);
    }

    /* PUBLICACION */

    public static function obtenerPublicacionesComunes(): ?array
    {
        $datos = [];

        $consulta = "SELECT * FROM publicacion WHERE destinatarioId IS NULL ORDER BY fecha DESC";
        $parametros = [];

        $rs = self::ejecutarConsulta($consulta, $parametros);

        foreach ($rs as $fila) {
            $publicacion = new Publicacion($fila["id"], $fila["fecha"], $fila["emisorId"], $fila["destinatarioId"], $fila["destacadaHasta"], $fila["asunto"], $fila["contenido"]);
            array_push($datos, $publicacion);
        }

        return $datos;

    }

    public static function obtenerPublicacionesUsuario(Usuario $usuario): ?array
    {
        $datos = [];

        $consulta = "SELECT * FROM publicacion WHERE emisorId=? ORDER BY fecha DESC";
        $parametros = [$usuario->getId()];

        $rs = self::ejecutarConsulta($consulta, $parametros);

        foreach ($rs as $fila) {
            $publicacion = new Publicacion($fila["id"], $fila["fecha"], $fila["emisorId"], $fila["destinatarioId"], $fila["destacadaHasta"], $fila["asunto"], $fila["contenido"]);
            array_push($datos, $publicacion);
        }

        return $datos;
    }

    public static function obtenerPublicacionesRecibidas(Usuario $usuario): ?array
    {
        $datos = [];

        $consulta = "SELECT * FROM publicacion WHERE destinatarioId=? ORDER BY fecha DESC";
        $parametros = [$usuario->getId()];

        $rs = self::ejecutarConsulta($consulta, $parametros);

        foreach ($rs as $fila) {
            $publicacion = new Publicacion($fila["id"], $fila["fecha"], $fila["emisorId"], $fila["destinatarioId"], $fila["destacadaHasta"], $fila["asunto"], $fila["contenido"]);
            array_push($datos, $publicacion);
        }

        return $datos;
    }

    public static function crearPublicacion(string $emisorId, ?string $destinatarioId, string $asunto, string $contenido): ?int
    {
        $fecha = date("Y-m-d H:i:s");
        $consulta = "INSERT INTO publicacion (fecha, emisorId, destinatarioId, destacadaHasta, asunto, contenido) VALUES (?, ?, ?, ?, ?, ?)";
        $parametros = [$fecha, $emisorId, $destinatarioId, NULL, $asunto, $contenido];

        return self::ejecutarActualizacion($consulta, $parametros);
    }

    public static function eliminarPublicacion(string $publicacionId)
    {
        $consulta = "DELETE FROM publicacion WHERE id=?";
        $parametros = [$publicacionId];

        return self::ejecutarActualizacion($consulta, $parametros);


    }

}