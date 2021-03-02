<?php
    require_once "_com/DAO.php";

   $categoria = DAO::categoriaModificar($_REQUEST["id"], $_REQUEST["nombre"]);


    echo $categoria;
?>