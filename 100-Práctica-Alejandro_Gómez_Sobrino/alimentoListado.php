<?php
    require_once "_varios.php";

    $conexion = obtenerPdoConexionBD();
    //ordenación cutre
    if(isset($_REQUEST["order"])){
    $orderby = $_REQUEST["order"];
   
    }
    else
       $orderby=0;
    $mostrarcarrito = isset($_REQUEST["carrito"]);

    $posibleClausulaWhere = $mostrarcarrito ? "WHERE t.carrito=1" : "";
    if($orderby ==1){
    $sql = "
               SELECT
                    t.id     AS tId,
                    t.Nombre AS tNombre,
                    t.Cantidad AS tCantidad,
                    t.Carrito AS tCarrito,
                    c.id     AS cId,
                    c.nombre AS cNombre
                FROM
                   tienda AS t INNER JOIN tipo AS c
                   ON t.tipoId = c.id
                $posibleClausulaWhere
                ORDER BY t.Nombre
            ";
        }
        if ($orderby == 2) {
           $sql = "
               SELECT
                    t.id     AS tId,
                    t.Nombre AS tNombre,
                    t.Cantidad AS tCantidad,
                    t.Carrito AS tCarrito,
                    c.id     AS cId,
                    c.nombre AS cNombre
                FROM
                   tienda AS t INNER JOIN tipo AS c
                   ON t.tipoId = c.id
                $posibleClausulaWhere
                ORDER BY t.Cantidad
            ";
        }
        if ($orderby == 3){
                $sql = "
               SELECT
                    t.id     AS tId,
                    t.Nombre AS tNombre,
                    t.Cantidad AS tCantidad,
                    t.Carrito AS tCarrito,
                    c.id     AS cId,
                    c.nombre AS cNombre
                FROM
                   tienda AS t INNER JOIN tipo AS c
                   ON t.tipoId = c.id
                $posibleClausulaWhere
                ORDER BY c.Nombre
            ";
        }
        if($orderby != 1 && $orderby !=2 && $orderby !=3){
                $sql = "
               SELECT
                    t.id     AS tId,
                    t.Nombre AS tNombre,
                    t.Cantidad AS tCantidad,
                    t.Carrito AS tCarrito,
                    c.id     AS cId,
                    c.nombre AS cNombre
                FROM
                   tienda AS t INNER JOIN tipo AS c
                   ON t.tipoId = c.id
                $posibleClausulaWhere
                ORDER BY t.Nombre
            ";
        }

    $select = $conexion->prepare($sql);
    $select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
    $rs = $select->fetchAll();


    // INTERFAZ:
  
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Listado de Alimentos</h1>

<table border='1'>

    <tr>
        <th><a href="alimentoListado.php?order=1">Nombre</a></th>
        <th><a href="alimentoListado.php?order=2">Cantidad(kg)</a></th>
        <th><a href="alimentoListado.php?order=3">Tipo</a></th>
    </tr>

    <?php
    foreach ($rs as $fila) { ?>
        <tr>
            <td>
                <?php
                    echo "<a href='alimentoFicha.php?id=$fila[tId]'>";
                    echo "$fila[tNombre]";
                    
                    echo "</a>";

                     $urlImagen = $fila["tCarrito"] ? "carrito.png" : "nocarrito.png";
                    echo " <a href='alimentoEstablecerEstadoCarrito.php?id=$fila[tId]'><img src='$urlImagen' width='16' height='16'></a>";
                    ?>

            </td>
            <td><a href= 'alimentoFicha.php?id=<?=$fila["tId"]?>'> <?= $fila["tCantidad"] ?> </a></td>
            <td><a href= 'tipoFicha.php?id=<?=$fila["cId"]?>'> <?= $fila["cNombre"] ?> </a></td>
            <td><a href='alimentoEliminar.php?id=<?=$fila["tId"]?>'> (X)                      </a></td>
        </tr>
    <?php } ?>

</table>

<br />

<?php if (!$mostrarcarrito) {?>
    <a href='alimentoListado.php?carrito'>Mostrar alimentos con carrito</a>
<?php } else { ?>
    <a href='alimentoListado.php'>Mostrar todos los alimentos</a>
<?php } ?>

<br />
<br />

<a href='alimentoFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='tipoListado.php'>Gestionar listado de los tipos</a>

</body>

</html>