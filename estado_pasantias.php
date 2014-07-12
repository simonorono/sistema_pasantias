<?php

require_once('globals.php');
validate_session2('tutor_licom', 'dpe');
date_default_timezone_set('America/Caracas');

?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sistema de pasantías. Administrador LiCom.</title>
        <link href="css/estilo.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="container">
            <div class="header">
                <?php include("include/cabecera.php"); ?>
            </div>
            <?php require_once("include/menu_dpe.php"); ?>
            <div class="content">
                <?php require_once("include/fecha.php"); ?>
                <div align="center">
                    <?php require_once("consulta.php"); ?>
                </div>
            </div>
            <?php include("include/pie.php"); ?>
        </div>
    </body>

</html>
