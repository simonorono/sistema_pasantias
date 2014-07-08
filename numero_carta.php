<?php

require_once('globals.php');
validate_session('dpe');

?>

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Asignar número de carta.</title>
        <link href="css/estilo.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div class="container">
            <div class="header">
                <?php require_once("include/cabecera.php"); ?>
            </div>
            <?php require_once("include/menu_dpe.php"); ?>
            <div class="content">
                <?php require_once("include/fecha.php"); ?>
                <div align="center">
                    <h1>Asignar número de carta.</h1>
                    <table class="s_table">
                        <tr>
                            <td>
                                <form method="post" action="do_numero_carta.php?id=<?php echo $_GET['id']; ?>">
                                    <p>
                                        <label for="numero_carta">Número</label>
                                        <input type="text" name="numero_carta" id="numero_carta" required pattern="^[a-zA-Z0-9]{3}$"/>
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
