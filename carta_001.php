<?php

require_once('db.php');
require_once('globals.php');

$db = new PgDB();

validate_session('estudiante');

$id = session_var('usuario_id');

$qry = "SELECT numero_carta FROM pasantia WHERE pasantia.usuario_id = $id";
$result = $db->query($qry);

if (pg_num_rows($result) == 0) {
    $error = 'pasantia';
} else {
    $numero_carta = pg_fetch_row($result, 0)[0];
    if ($numero_carta == null) {
        $error = 'numero';
    }
}

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
if (isset($error)) {
    if ($error == 'pasantia') {
                    ?>
                    <h2>No tiene pasantía registrada.</h2>
                    <?php
    } else if ($error == 'numero') {
                    ?>
                    <h2>No puede imprimir la carta de postulación, el número de carta no ha sido asignado.</h2>
                    <?php
    }
} else {
                    ?>
                    <h2>Presione <a href="imp/formato_dpe_pas_001.php">aquí</a> para descargar su carta de postulación.</h2>
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
