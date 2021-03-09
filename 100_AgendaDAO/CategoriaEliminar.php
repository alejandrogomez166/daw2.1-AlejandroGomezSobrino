<?php
	require_once "_com/Varios.php";
	require_once "_com/DAO.php";
	$conexionBD = obtenerPdoConexionBD();

	// Se recoge el parámetro "id" de la request.
	$id = (int)$_REQUEST["id"];

	$correctoNormal=DAO::eliminarCategoriaPorId($id);
	?>



<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<?php if ($correctoNormal) { ?>

	<h1>Eliminación completada</h1>
	<p>Se ha eliminado correctamente la categoría.</p>

<?php }  else { ?>

	<h1>Error en la eliminación</h1>
	

<?php } ?>

<a href='CategoriaListado.php'>Volver al listado de categorías.</a>

</body>

</html>