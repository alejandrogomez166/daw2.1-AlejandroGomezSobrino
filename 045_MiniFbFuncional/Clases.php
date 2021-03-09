<?php

abstract class Dato
{
}

trait Identificable
{
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}

class Usuario extends Dato
{
    use Identificable;

    private string $identificador;
    private string $contrasenna;
    private ?string $codigoCookie;
    private ?string $caducidadCodigoCookie;
    private string $tipoUsuario;
    private string $nombre;
    private string $apellidos;

    public function __construct(int $id, string $identificador, string $contrasenna, ?string $codigoCookie, ?string $caducidadCodigoCookie,
                                string $tipoUsuario, string $nombre, string $apellidos)
    {
       self::setId($id);
       $this->setIdentificador($identificador);
       $this->setContrasenna($contrasenna);
       $this->setCodigoCookie($codigoCookie);
       $this->setCaducidadCodigoCookie($caducidadCodigoCookie);
       $this->setTipoUsuario($tipoUsuario);
       $this->setNombre($nombre);
       $this->setApellidos($apellidos);
    }

    public function getIdentificador(): string
    {
        return $this->identificador;
    }

    public function setIdentificador(string $identificador): void
    {
        $this->identificador = $identificador;
    }


    public function getContrasenna(): string
    {
        return $this->contrasenna;
    }

    public function setContrasenna($contrasenna)
    {
        $this->contrasenna = $contrasenna;
    }


    public function getCodigoCookie(): string
    {
        return $this->codigoCookie;
    }

    public function setCodigoCookie(?string $codigoCookie): void
    {
        $this->codigoCookie = $codigoCookie;
    }


    public function getCaducidadCodigoCookie(): string
    {
        return $this->caducidadCodigoCookie;
    }


    public function setCaducidadCodigoCookie(?string $caducidadCodigoCookie): void
    {
        $this->caducidadCodigoCookie = $caducidadCodigoCookie;
    }

    public function getTipoUsuario(): string
    {
        return $this->tipoUsuario;
    }


    public function setTipoUsuario($tipoUsuario): void
    {
        $this->tipoUsuario = $tipoUsuario;
    }



    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }


    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function setApellidos($apellidos): void
    {
        $this->apellidos = $apellidos;
    }

}

class Publicacion extends Dato
{
    use Identificable;

    private string $fecha;
    private string $emisorId;
    private ?string $destinatarioId;
    private ?string $destacadaHasta;
    private string $asunto;
    private string $contenido;


    public function __construct(int $id, string $fecha, string $emisorId, ?string $destinatarioId, ?string $destacadaHasta, string $asunto, string $contenido)
    {
        self::setId($id);
        $this->setFecha($fecha);
        $this->setEmisorId($emisorId);
        $this->setDestinatarioId($destinatarioId);
        $this->setDestacadaHasta($destacadaHasta);
        $this->setAsunto($asunto);
        $this->setContenido($contenido);
    }



    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }


    public function getEmisorId(): string
    {
        return $this->emisorId;
    }

    public function setEmisorId($emisorId): void
    {
        $this->emisorId = $emisorId;
    }


    public function getDestinatarioId(): string
    {
        return $this->destinatarioId;
    }


    public function setDestinatarioId(?string $destinatarioId): void
    {
        $this->destinatarioId = $destinatarioId;
    }

    public function getDestacadaHasta(): string
    {
        return $this->destacadaHasta;
    }


    public function setDestacadaHasta(?string $destacadaHasta): void
    {
        $this->destacadaHasta = $destacadaHasta;
    }


    public function getAsunto(): string
    {
        return $this->asunto;
    }

    public function setAsunto($asunto): void
    {
        $this->asunto = $asunto;
    }

    public function getContenido(): string
    {
        return $this->contenido;
    }

    public function setContenido($contenido): void
    {
        $this->contenido = $contenido;
    }

}