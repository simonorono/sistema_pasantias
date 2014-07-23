<?php

require_once ('globals.php');
require_once ('db.php');

validate_session2('tutor_licom', 'dpe');

$tipo_cuenta = session_var('tipo_cuenta');

$db = new PgDB();

if (isset($_GET['validar'])) {
    $id = $_GET['validar'];
    $today = date ('Y-m-d', time());
    $qry = "UPDATE pasantia SET valida = TRUE, m02_aceptada = '$today' WHERE pasantia.id = $id";
    $db->query($qry);
    header ("Location: done.php?go=pasantias.php");
}

if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $qry = "DELETE FROM pasantia WHERE pasantia.id = $id";
    $db->query($qry);
    header ("Location: done.php?go=pasantias.php");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $headers = ['Compañia', 'Email', 'Departamento', 'Dirección', 'Dirigido a', 'Actividad', 'Actividades', 'Supervisor', 'Cargo del supervisor', 'Horario', 'Teléfono celular', 'Teléfono de oficina', 'Tiempo completo', 'Fecha de inicio', 'Fecha de fin'];

    $qry = "SELECT compania, email, departamento, direccion, dirigido_a, actividad, actividades, supervisor, cargo_supervisor, horario, telefono_celu, telefono_ofic, tiempo_completo, fecha_inicio, fecha_fin, numero_carta, valida FROM pasantia WHERE pasantia.id = $id";

    $result = $db->query($qry);
}
else {
    die('Missing parameters.');
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
if (pg_num_rows($result) != 0) {
    $pasantia = pg_fetch_row($result, 0);
    //var_dump($pasantia);die();
    if ($pasantia[13] == "t") $pasantia[12] = "Sí";
    else $pasantia[12] = "No";
    $pasantia[13] = date_format (DateTime::createFromFormat('Y-m-d 00:00:00', $pasantia[13]), 'd/m/Y');
    $pasantia[14] = date_format (DateTime::createFromFormat('Y-m-d 00:00:00', $pasantia[14]), 'd/m/Y');
                    ?>

                    <table>
                        <?php
    for ($i = 0; $i < 15; $i++) {
                        ?>
                        <tr class="periodo_tr" style="border-bottom: 1px solid black">
                            <td class="periodo_td"><?php echo $headers[$i]; ?></td>
                            <td class="periodo_td" style="white-space: pre; border-bottom: 1px solid black"><?php echo $pasantia[$i]; ?></td>
                        </tr>
                        <?php
    }
                        ?>
                        <tr>
                            <td>
                                <br/>
                                <br/>
                                <p>
                                    <?php
    if ($tipo_cuenta == 'dpe') {
        if ($pasantia[15] == null) {
                                    ?>
                                    <a href="numero_carta.php?id=<?php echo $_GET['id'] ?>">Asignar número de carta</a>
                                    <?php
        }
    } else {
        if ($pasantia[16] == "f") {
                                    ?>
                                    <a href="pasantia.php?validar=<?php echo $_GET['id'] ?>">Validar</a>  -
                                    <a style="paddig-left: 2px" href="pasantia.php?eliminar=<?php echo $_GET['id'] ?>">Eliminar</a>
                                    <?php
        }
    }
                                    ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                    <br/>
                    <br/>

                    <?php
}
                    ?>

                </div>
            </div>
            <?php include( "include/pie.php"); ?>
        </div>
    </body>

</html>
