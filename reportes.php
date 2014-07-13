<?php

require_once('globals.php');

validate_session('tutor_licom');

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
            <?php require_once('include/menu_estudiantes.php'); ?>
            <div class="content">
                <?php require_once("include/fecha.php"); ?>
                <div align="center">
                    <h1>Reportes</h1>
                    <form action="do_reportes.php" method="post">
                        <select id="tipo_reporte" name="tipo_reporte">
                            <option value="general">Reporte general</option>
                            <option value="hitos">Estadísticas de hitos</option>
                            <option value="pasantes">Pasantes</option>
                        </select>
                        <br/>
                        <br/>
                        <input type="submit" value="Descargar" />
                    </form>
                </div>
            </div>
            <br/>
            <?php include("include/pie.php"); ?>
        </div>
    </body>

</html>
