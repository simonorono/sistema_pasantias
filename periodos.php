
<?php

require_once ('globals.php');
require_once ('db.php');
validate_session ('tutor_licom');

$db = new PgDB();
$result = $db->query ("SELECT id, anio, tipo, activo FROM periodo ORDER BY periodo.anio");

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
                <?php require_once("include/cabecera.php"); ?>
            </div>
            <?php require_once("include/menu_general.php"); ?>
            <div class="content">
                <?php require_once("include/fecha.php"); ?>
                <div align="center">
                    <h1>Inicio de sesión</h1>
                    <?php

if (pg_num_rows ($result) == 0) {

                    ?>

                    <h2>No existen periodos.</h2>

                    <?php

} else {

                    ?>
                    <table>
                        <tr>
                            <th>Año</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                        </tr>
                        <?php

    for ($i = 0; $i < pg_num_rows($result); $i++) {
        $row = pg_fetch_row($result, $i);

                        ?>
                        <tr class="periodo_tr">
                            <td class="periodo_td"><?php echo $row[1]; ?></td>
                            <td class="periodo_td"><?php echo $row[2]; ?></td>
                            <td class="periodo_td"><?php if ($row[3] == 't') { echo 'ACTIVO'; } else { echo 'INACTIVO'; } ?></td>
                            <td class="periodo_td"><a href="do_agregar_periodo.php?op=del&id=<?php echo $row[0]; ?>">Eliminar</td>

                                <?php

        if ($row[3] == "f") {

                                ?>

                            <td class="periodo_td"><a href="do_agregar_periodo.php?op=act&id=<?php echo $row[0]; ?>">Activar</td>

                                <?php

        }

                                ?>
                        </tr>

                        <?php

    }
}

                        ?>

                    </table>
                </div>
            </div>
            <?php require_once("include/pie.php"); ?>
        </div>
    </body>

</html>
