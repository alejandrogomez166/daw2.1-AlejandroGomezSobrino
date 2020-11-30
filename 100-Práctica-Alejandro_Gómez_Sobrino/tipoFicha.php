<?php
	require_once "_varios.php";

	$conexion = obtenerPdoConexionBD();
	
	// Se recoge el parámetro "id" de la request.
	$id = (int)$_REQUEST["id"];

	// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
	// (y $nueva_entrada tomará false).
	$nuevaEntrada = ($id == -1);

	if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
		$categoriaNombre = "<introduzca nombre>";
	} else { // Quieren VER la ficha de una categoría existente, cuyos datos se cargan.
		$sql = "SELECT Nombre FROM tipo WHERE id=?";

        $select = $conexion->prepare($sql);
        $select->execute([$id]); // Se añade el parámetro a la consulta preparada.
        $rs = $select->fetchAll();
		
		 // Con esto, accedemos a los datos de la primera (y esperemos que única) fila que haya venido.
		$categoriaNombre = $rs[0]["Nombre"];
	}



    $sql = "SELECT * FROM tienda WHERE tipoId=? ORDER BY Nombre";

    $select = $conexion->prepare($sql);
    $select->execute([$id]); // Array vacío porque la consulta preparada no requiere parámetros.
    $rsalimentosDeLaCategoria = $select->fetchAll();


	// INTERFAZ:
   
?>
	


<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<?php if ($nuevaEntrada) { ?>
	<h1>Nueva ficha de tipos</h1>
<?php } else { ?>
	<h1>Ficha de nuevo tipos</h1>
<?php } ?>

<form method='post' action='tipoGuardar.php'>

<input type='hidden' name='id' value='<?=$id?>' />

<ul>
	<li>
		<strong>Nombre: </strong>
		<input type='text' name='nombre' value='<?=$categoriaNombre?>' />                   
	</li>
</ul>

<?php if ($nuevaEntrada) { ?>
	<input type='submit' name='crear' value='Crear nuevo tipo' />
<?php } else { ?>
	<input type='submit' name='guardar' value='Guardar cambios' />
<?php } ?>

</form>

<br />
<?php if ($id != -1) { ?>
<p>Alimentos que pertenecen al tipo:</p>

<ul>
<?php
    foreach ($rsalimentosDeLaCategoria as $fila) {
        echo "<li>$fila[Nombre]  $fila[Cantidad] unidades(kg)</li>"; 					
    }
?>
</ul>

<?php
}
?>
<?php if (!$nuevaEntrada) { ?>
    <br />
    <a href='tipoEliminar.php?id=<?=$id?>'>Eliminar tipo</a>
<?php } ?>

<br />
<br />

<a href='tipoListado.php'>Volver a la lista de tipos.</a>

</body>

</html>