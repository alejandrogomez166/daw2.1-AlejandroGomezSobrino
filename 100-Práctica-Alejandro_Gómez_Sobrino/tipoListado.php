<?php
	require_once "_varios.php";

	$conexionBD = obtenerPdoConexionBD();

	// Los campos que incluyo en el SELECT son los que luego podré leer
    // con $fila["campo"].
	$sql = "SELECT id, Nombre FROM tipo ORDER BY Nombre";

    $select = $conexionBD->prepare($sql);
    $select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
    $rs = $select->fetchAll();

    // INTERFAZ:
    // $rs
?>

<!--categoriaListado -->

<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<h1>Tipos</h1>

<table border='1'>

	<tr>
		<th>Nombre</th>
	</tr>

	<?php foreach ($rs as $fila) { ?>
        <tr>
            <td><a href='tipoFicha.php?id=<?=$fila["id"]?>'> <?=$fila["Nombre"] ?> </a></td><!--'categoriaFicha.php -->
            <td><a href='tipoEliminar.php?id=<?=$fila["id"]?>'> (X)                   </a></td><!--categoriaEliminar.php-->
        </tr>
	<?php } ?>

</table>

<br />

<a href='tipoFicha.php?id=-1'>Crear entrada</a><!--categoriaFicha.php -->

<br />
<br />

<a href='alimentoListado.php'>Gestionar listado de comida</a><!--personaListado.php -->

</body>

</html>