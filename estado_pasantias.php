<?php

require_once('globals.php');
validate_session2('tutor_licom', 'dpe');
date_default_timezone_set('America/Caracas');
$tipo = session_var('tipo_cuenta');

?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sistema de pasantías.</title>
        <link href="css/estilo.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="container">
            <div class="header">
                <?php include("include/cabecera.php"); ?>
            </div>
            <?php
if ($tipo == 'tutor_licom') {
    require_once('include/menu_licom.php');
} else if ($tipo == 'dpe') {
    require_once('include/menu_dpe.php');
}
            ?>
            <div class="content">
                <?php require_once("include/fecha.php"); ?>
                <div align="center">
                    <?php require_once("consulta.php"); ?>
                </div>
            </div>
            <br/>
            <?php include("include/pie.php"); ?>
        </div>
    </body>

</html>
