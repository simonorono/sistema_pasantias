<?php

session_start();
if (session_status() == PHP_SESSION_ACTIVE) extract($_SESSION);

if(isset($tipo_cuenta) &&
   isset($username)) {
    if($tipo_cuenta !== 'estudiante')
        header('Location: index.php');
} else {
    header('Location: index.php');
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
                <?php include( "include/cabecera.php"); ?>
            </div>
            <?php require_once( "include/menu_estudiantes.php"); ?>
            <div class="content">
                <?php require_once( "include/fecha.php"); ?>
                <div align="center">

                    <h2>Seleccione una opción en el menú de la izquierda.</h2>

                </div>
            </div>
            <?php include( "include/pie.php"); ?>
        </div>
    </body>

</html>
