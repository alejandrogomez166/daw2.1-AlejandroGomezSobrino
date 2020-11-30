<?php
	require_once "_varios.php";

	$conexion = obtenerPdoConexionBD();

	// Se recogen los datos del formulario de la request.
	$id = (int)$_REQUEST["id"];
	$nombre = $_REQUEST["nombre"];
	$cantidad = $_REQUEST["cantidad"];
    $tipoId = (int)$_REQUEST["tipoId"];
    $carrito = isset($_REQUEST["Carrito"]);

	// Si id es -1 quieren INSERTAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren ACTUALIZAR la ficha de una tienda existente
	// (y $nueva_entrada tomar false).
	$nuevaEntrada = ($id == -1);
	
	if ($nuevaEntrada) {
		// Quieren CREAR una nueva entrada, así que es un INSERT.
 		$sql = "INSERT INTO tienda (Nombre, Cantidad, Carrito, tipoId) VALUES (?, ?, ?, ?)";
        $parametros = [$nombre, $cantidad, $carrito?1:0, $tipoId];
	} else {
		// Quieren MODIFICAR una tienda existente y es un UPDATE.
 		$sql = "UPDATE tienda SET Nombre=?, Cantidad=?, Carrito=?, tipoId=? WHERE id=?";
        $parametros = [$nombre, $cantidad, $carrito?1:0, $tipoId, $id];
 	}

    $sentencia = $conexion->prepare($sql);
    // Esta llamada devuelve true o false según si la ejecución de la sentencia ha ido bien o mal.
    $sqlConExito = $sentencia->execute($parametros); // Se añaden los parámetros a la consulta preparada.

    //Se consulta la cantidad de filas afectadas por la ultima sentencia SQL.
    $numFilasAfectadas = $sentencia->rowCount();
    $unaFilaAfectada = ($numFilasAfectadas == 1);
    $ningunaFilaAfectada = ($numFilasAfectadas == 0);

    // Está todo correcto de forma NORMAL si NO ha habido errores y se ha visto afectada UNA fila.
    $correcto = ($sqlConExito && $unaFilaAfectada);

    // Si los datos no se habían modificado, también está correcto, pero de otra manera.
    $datosNoModificados = ($sqlConExito && $ningunaFilaAfectada);
?>



<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<?php
	// Todo bien tanto si se han guardado los datos nuevos como si no se habían modificado.
	if ($correcto || $datosNoModificados) { ?>

		<?php if ($id == -1) { ?>
			<h1>Inserción completada</h1>
			<p>Se ha insertado correctamente la nueva entrada de <?php echo $nombre; ?>.</p>
		<?php } else { ?>
			<h1>Guardado completado</h1>
			<p>Se han guardado correctamente los datos de <?php echo $nombre; ?>.</p>

			<?php if ($datosNoModificados) { ?>
				<p>No has modificado nada</p>
			<?php } ?>
		<?php }
?>

<?php
	} else {
?>

	<h1>Error en la modificación.</h1>
	<p>No se han podido guardar los datos del alimento.</p>

<?php
	}
?>

<a href='alimentoListado.php'>Volver al listado de los alimento.</a>

</body>

</html>