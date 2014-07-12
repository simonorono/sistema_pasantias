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
                        <thead>
                        <tr class="periodo_tr">
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                        </tr>
                    </thead>

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

<style type="text/css">
table {
    font: 0.8em Arial, Helvetica, sans-serif;

    background:#e8eef7;
    color:#000;
    table-layout: fixed;
    width: :50%;
    border:1px solid #000000;
    box-shadow: 5px 3px 5px #888888;

    -moz-border-radius-bottomleft:9px;
    -webkit-border-bottom-left-radius:9px;
    border-bottom-left-radius:9px;
    -moz-border-radius-bottomright:9px;
    -webkit-border-bottom-right-radius:9px;
    border-bottom-right-radius:9px;
    -moz-border-radius-topright:9px;
    -webkit-border-top-right-radius:9px;
    border-top-right-radius:9px;
    -moz-border-radius-topleft:9px;
    -webkit-border-top-left-radius:9px;
    border-top-left-radius:9px;
    }
#itsthetable > table {width:50%;}
#itsthetable {
    height:350px;
    overflow:auto;
    background:#c6dbff;
    padding-bottom:3px;
    }
th {font-weight:200;
background-color:#82c0ff;
    background:-o-linear-gradient(bottom, #82c0ff 5%, #56aaff 100%);    background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #82c0ff), color-stop(1, #56aaff) );
    background:-moz-linear-gradient( center top, #82c0ff 5%, #56aaff 100% );
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#82c0ff", endColorstr="#56aaff");  background: -o-linear-gradient(top,#82c0ff,56aaff);
    background-color:#FFF;
    border-top: solid 1px black;
    border-bottom: solid 1px gray;
    background: rgb(59,103,158); /* Old browsers */
background: -moz-linear-gradient(top,  rgba(59,103,158,1) 0%, rgba(43,136,217,1) 50%, rgba(32,124,202,1) 51%, rgba(125,185,232,1) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(59,103,158,1)), color-stop(50%,rgba(43,136,217,1)), color-stop(51%,rgba(32,124,202,1)), color-stop(100%,rgba(125,185,232,1))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  rgba(59,103,158,1) 0%,rgba(43,136,217,1) 50%,rgba(32,124,202,1) 51%,rgba(125,185,232,1) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  rgba(59,103,158,1) 0%,rgba(43,136,217,1) 50%,rgba(32,124,202,1) 51%,rgba(125,185,232,1) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  rgba(59,103,158,1) 0%,rgba(43,136,217,1) 50%,rgba(32,124,202,1) 51%,rgba(125,185,232,1) 100%); /* IE10+ */
background: linear-gradient(to bottom,  rgba(59,103,158,1) 0%,rgba(43,136,217,1) 50%,rgba(32,124,202,1) 51%,rgba(125,185,232,1) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3b679e', endColorstr='#7db9e8',GradientType=0 ); /* IE6-9 */
}
tr{
    font-weight:400;
    background-color:#fff;

}

tr th, tr td {border-bottom:2px solid #fff;}


table a:hover {color:#fff; background:#000; display:block;}
tbody tr th  {
    width:100px;

    background:transparent url("det1gmail.gif") left top no-repeat;
    }



</style>