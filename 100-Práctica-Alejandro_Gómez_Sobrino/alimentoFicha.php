<?php
	require_once "_varios.php";

	$conexion = obtenerPdoConexionBD();
	
	// Se recoge el parámetro "id" de la request.
	$id = (int)$_REQUEST["id"];

	// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren VER la ficha de un alimento existente
	// (y $nueva_entrada tomará false).
	$nuevaEntrada = ($id == -1);
	
	if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
		$nombre = "<introduzca nombre>";
        $cantidad = "<introduzca cantidad>";
        $carrito = false;
		$tipoId = 0;
	} else { // Quieren VER la ficha de un alimento existente, cuyos datos se cargan.
        $sqlAlimento = "SELECT * FROM tienda WHERE id=?";

        $select = $conexion->prepare($sqlAlimento);
        $select->execute([$id]); // Se añade el parámetro a la consulta preparada.
        $rsAlimento = $select->fetchAll();

        // Con esto, accedemos a los datos de la primera (y esperemos que única) fila que haya venido.
		$nombre = $rsAlimento[0]["Nombre"];
        $cantidad = $rsAlimento[0]["Cantidad"];
        $carrito = ($rsAlimento[0]["Carrito"] == 1); // En BD está como TINYINT. 0=false, 1=true. Con esto convertimos a booolean.
		$aTipoId = $rsAlimento[0]["id"];
	}

	
	
	// Con lo siguiente se deja preparado un recordset con todas las categorías.
	
	$sqlTipos = "SELECT * FROM tipo ORDER BY Nombre";

    $select = $conexion->prepare($sqlTipos);
    $select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
    $rsTipos = $select->fetchAll();



    // INTERFAZ:
    // $personaNombre
    // $personaTelefono
    // $personaApellidos
    // $personacarrito
    // $personatipoId
    // $rsCategorias
?>




<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<?php if ($nuevaEntrada) { ?>
	<h1>Nueva ficha de alimento</h1>
<?php } else { ?>
	<h1>Ficha de alimentos</h1>
<?php } ?>

<form method='post' action='alimentoGuardar.php'>

<input type='hidden' name='id' value='<?= $id ?>' />

    <label for='nombre'>Nombre: </label>
    <input type='text' name='nombre' value='<?=$nombre ?>' />
    <br/>

    <label for='cantidad'> Cantidad: </label>
    <input type='text' name='cantidad' value='<?=$cantidad ?>' />
    <br/>

    <label for='tipoId'>Tipo: </label>
    <select name='tipoId' value='<?=$aTipoId?>'/>
        <?php
            foreach ($rsTipos as $tipoCategoria) {
                $tipoId = (int) $tipoCategoria["id"];
                $tipoNombre = $tipoCategoria["Nombre"];

                if ($tipoId == $aTipoId) $seleccion = "selected='true'";
                else                                     $seleccion = "";

                echo "<option value='$tipoId' $seleccion>$tipoNombre</option>";

                // Alternativa (peor):
                // if ($tipoId == $personatipoId) echo "<option value='$tipoId' selected='true'>$tipoNombre</option>";
                // else                                     echo "<option value='$tipoId'                >$tipoNombre</option>";
            }
        ?>
    </select>
    <br/>

    <label for='carrito'>Carrito</label>
    <input type='checkbox' name='carrito' <?= $carrito ? "checked" : "" ?> />
    <br/>

    <br/>

<?php if ($nuevaEntrada) { ?>
	<input type='submit' name='crear' value='Crear comida' />
<?php } else { ?>
	<input type='submit' name='guardar' value='Guardar cambios' />
<?php } ?>

</form>

<?php if (!$nuevaEntrada) { ?>
    <br />
    <a href='alimentoEliminar.php?id=<?=$id ?>'>Eliminar comida.</a>
<?php } ?>

<br />
<br />

<a href='alimentoListado.php'>Volver al listado de comida.</a>

</body>

</html>