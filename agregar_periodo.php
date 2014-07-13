<?php

require_once('globals.php');
validate_session('tutor_licom');

?>

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Agregar periodo académico.</title>
        <link href="css/estilo.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div class="container">
            <div class="header">
                <?php require_once("include/cabecera.php"); ?>
            </div>
            <?php require_once("include/menu_licom.php"); ?>
            <div class="content">
                <?php require_once("include/fecha.php"); ?>
                <div align="center">
                    <h1>Agregar periodo académico</h1>
                    <table class="s_table">
                        <tr>
                            <td>
                                <form method="post" action="do_agregar_periodo.php">
                                    <p>
                                        <label for="anio">Año</label>
                                        <input type="text" name="anio" id="anio" required pattern="^[2][0-9]{3}$"/>
                                    </p>
                                    <p>
                                        <label for="tipo">Tipo</label>
                                        <select name="tipo" id="tipo">
                                            <option value="primero">Primero</option>
                                            <option value="segundo">Segundo</option>
                                            <option value="único">Único</option>
                                        </select>
                                    </p>
                                    <p align="center">
                                        <input type="submit" id="button" name="button" value="Ingresar" />
                                    </p>
                                </form>
                                <script type="application/javascript" src="validaciones.js"></script>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php require_once("include/pie.php"); ?>
        </div>
    </body>

</html>
