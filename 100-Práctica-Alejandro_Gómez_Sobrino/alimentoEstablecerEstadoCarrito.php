<?php
    require_once "_varios.php";

    $conexion = obtenerPdoConexionBD();

    $id = $_REQUEST["id"];

    $sql = "UPDATE tienda SET carrito = (NOT (SELECT carrito FROM tienda WHERE id=?)) WHERE id=?";
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute([$id, $id]);

    redireccionar("alimentoListado.php");
?>