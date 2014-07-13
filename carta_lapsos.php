<?php

require_once('globals.php');
require_once('calendario/calendario.php');

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

                    <h1>Generar carta de lapsos</h1>
                    <form name="lapsos" action="imp/carta_lapsos.php" method="post" id="jform">
                        <p>
                            <label for="entrega_borrador">Entrega del borrador del informe:</label>
                            <?php escribe_formulario_fecha_vacio('entrega_borrador', 'lapsos'); ?>
                        </p>
                        <p>
                            <label for="retiro_borrador">Retiro del borrador del informe:</label>
                            <?php escribe_formulario_fecha_vacio('retiro_borrador', 'lapsos'); ?>
                        </p>
                        <p>
                            <label for="entrega_final">Entrega final del informe:</label>
                            <?php escribe_formulario_fecha_vacio('entrega_final', 'lapsos'); ?>
                        </p>
                        <br/>
                        <input type="submit" value="Descargar carta"/>
                    </form>
                    <script type="text/javascript" src="validaciones.js"></script>
                </div>
            </div>
            <br/>
            <?php include("include/pie.php"); ?>
        </div>
    </body>

</html>
