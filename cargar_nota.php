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
                    <h1>Cargar nota</h1>
                    <form action="do_cargar_nota.php<?php echo $_GET['id']; ?>" method="post">
                        <select id="nota" name="nota">
                            <option value="aprobada">Aprobada</option>
                            <option value="reprobada">Reprobada</option>
                        </select>
                        <br/>
                        <br/>
                        <input type="submit" value="Cargar" />
                    </form>
                </div>
            </div>
            <br/>
            <?php include("include/pie.php"); ?>
        </div>
    </body>

</html>
