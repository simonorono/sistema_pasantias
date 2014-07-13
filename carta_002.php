<?php

require_once('db.php');
require_once('globals.php');

validate_session('estudiante');

$id = session_var('usuario_id');
$db = new PgDB();
$r = $db->query("SELECT * FROM pasantia WHERE pasantia.usuario_id = $id");

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
                    <?php
if (pg_num_rows($r) != 0) {
                    ?>
                    <h2>Presione <a href="imp/formato_dpe_pas_002.php">aquí</a> para descargar su carta de registro.</h2>
                    <?php
} else {
                    ?>
                    <h2>No tiene pasantía registrada.</h2>
                    <?php
}
                    ?>
                </div>
            </div>
            <br/>
            <?php include("include/pie.php"); ?>
        </div>
    </body>

</html>
