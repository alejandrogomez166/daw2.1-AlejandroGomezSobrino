<?php

    require_once "_Varios.php";
    require_once "DAO.php";

    // Comprobamos si hay sesión-usuario iniciada.
    //   - Si la hay, no intervenimos. Dejamos que la pág se cargue.
    //     (Mostrar info del usuario logueado y tal...)
    //   - Si NO la hay, redirigimos a SesionInicioFormulario.php

    if (!haySesionRamIniciada() && !intentarCanjearSesionCookie()) {
        redireccionar("SesionInicioFormulario.php");
    }

    $publicaciones = DAO::obtenerPublicacionesComunes();


?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php pintarInfoSesion(); ?>

<h1>Muro global</h1>

<h3>Publicar en el Muro Global</h3>

<form action="PublicacionNuevaCrear.php?muroGlobal" method="post">
    <label for="asunto">Asunto</label>
    <input type="text" name="asunto" placeholder="Escriba aquí su asunto"><br><br>

    <p>Contenido</p>
    <textarea rows="4" cols="50" name="contenido" placeholder="Escriba aquí su mensaje"></textarea><br><br>

    <input type="submit" value="Publicar">
</form>

<h3>Publicaciones</h3>
<table border="1">
    <tr>
        <th>Fecha</th>
        <th>Emisor</th>
        <th>Asunto</th>
        <th>Contenido</th>
    </tr>
    <?php foreach ($publicaciones as $publicacion) {
        $usuario = DAO::obtenerUsuarioPorId($publicacion->getEmisorId());
        ?>

        <tr>
            <td> <?=$publicacion->getFecha()?> </td>
            <td><a href="MuroVerDe.php?id=<?=$publicacion->getEmisorId()?>"> <?=$usuario->getNombre() . " " . $usuario->getApellidos()?> </a></td>
            <td> <?=$publicacion->getAsunto()?> </td>
            <td> <?=$publicacion->getContenido()?> </td>
        </tr>
    <?php } ?>
</table>

<br>

<a href='Index.php'>Ir al inicio</a>
<a href='MuroVerDe.php?id=<?=$_SESSION["id"]?>'>Ir a mi muro.</a>

</body>

</html>