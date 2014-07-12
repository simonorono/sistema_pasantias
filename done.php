<?php

require_once('globals.php');
validate_session2('tutor_licom', 'dpe');
$tipo = session_var('tipo_cuenta');

$url = $_GET['go'];

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
if ($tipo == 'estudiante') {
    require_once('include/menu_estudiante.php');
} else if ($tipo == 'tutor_licom') {
    require_once('include/menu_licom.php');
} else {
    require_once('include/menu_dpe.php');
}
            ?>
            <div class="content">
                <?php require_once("include/fecha.php"); ?>
                <div align="center">
                    <h2>Operación realizada con exito</h2>
                    <p>Presione <a href='<?php echo $url ?>'>aquí</a> para continuar</p>
                </div>
            </div>
            <?php include("include/pie.php"); ?>
        </div>
    </body>

</html>
