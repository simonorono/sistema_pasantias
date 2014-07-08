<?php

require_once('globals.php');
require_once('db.php');

validate_session2('tutor_licom', 'dpe');

$db = new PgDB();

$periodo = $db->query('SELECT id FROM periodo WHERE periodo.activo = TRUE');
$tipo_cuenta = session_var('tipo_cuenta');

if (pg_num_rows($periodo) == 0) $error = 'periodo';
else {
    $periodo = pg_fetch_row($periodo, 0)[0];

    $qry = "SELECT usuario.cedula, usuario.nombre, usuario.apellido, pasantia.id FROM pasantia INNER JOIN usuario ON usuario.id = pasantia.usuario_id AND pasantia.periodo_id = $periodo";

    if ($tipo_cuenta == 'dpe') $qry = $qry . "AND pasantia.valida = TRUE";

    $pasantias = $db->query($qry);
    if (pg_num_rows($pasantias) == 0) $error = 'pasantia';
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sistema de pasantías. Administrador LiCom.</title>
        <link href="css/estilo.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="container">
            <div class="header">
                <?php include( "include/cabecera.php"); ?>
            </div>
            <?php
if ($tipo_cuenta == 'dpe') {
    require_once("include/menu_dpe.php");
}
else {
    require_once("include/menu_licom.php");
}
            ?>
            <div class="content">
                <?php require_once( "include/fecha.php"); ?>
                <div align="center">

                    <?php
if (isset($error)) {
    if ($error == 'periodo') {
                    ?>
                    <h2>No hay periodo activo.</h2>
                    <?php
    } else if ($error == 'pasantia') {
                    ?>
                    <h2>No hay pasantias en el periodo activo.</h2>
                    <?php
    }
} else {
                    ?>

                    <table>
                        <tr class="periodo_tr">
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                        </tr>

                        <?php
    for ($i = 0; $i < pg_num_rows($pasantias); $i++) {
        $row = pg_fetch_row($pasantias, $i);
                        ?>
                        <tr class="periodo_tr">
                            <td class="periodo_td"><a href="pasantia.php?id=<?php echo $row[3]; ?>"><?php echo $row[0]; ?></a></td>
                            <td class="periodo_td"><?php echo $row[1]; ?></td>
                            <td class="periodo_td"><?php echo $row[2]; ?></td>
                        </tr>
                        <?php
    }
                        ?>

                    </table>

                    <?php
}
                    ?>
                </div>
            </div>
            <?php include( "include/pie.php"); ?>
        </div>
    </body>

</html>
