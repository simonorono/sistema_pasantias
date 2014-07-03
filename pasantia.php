<?php

require_once ('globals.php');
require_once ('db.php');

validate_session('tutor_licom');

$db = new PgDB();

if (isset($_GET['validar'])) {
    $id = $_GET['validar'];
    $qry = "UPDATE pasantia SET valida = TRUE WHERE pasantia.id = $id";
    $db->query($qry);
    header ("Location: pasantias.php");
}

if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $qry = "DELETE FROM pasantia WHERE pasantia.id = $id";
    $db->query($qry);
    header ("Location: pasantias.php");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $headers = ['Compañia', 'Email', 'Departamento', 'Dirección', 'Dirigido a', 'Actividad', 'Actividades', 'Supervisor', 'Cargo del supervisor', 'Horario', 'Teléfono celular', 'Teléfono de oficina', 'Tiempo completo', 'Fecha de inicio', 'Fecha de fin'];
    $qry = <<<"STR"
        SELECT
            compania,
            email,
            departamento,
            direccion,
            dirigido_a,
            actividad,
            actividades,
            supervisor,
            cargo_supervisor,
            horario,
            telefono_celu,
            telefono_ofic,
            tiempo_completo,
            fecha_inicio,
            fecha_fin
        FROM
            pasantia
        WHERE
            pasantia.id = $id;
STR;
    $result = $db->query($qry);
}
else {
    die();
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
            <?php require_once( "include/menu_licom.php"); ?>
            <div class="content">
                <?php require_once( "include/fecha.php"); ?>
                <div align="center">

                    <?php
if (pg_num_rows($result) != 0) {
    $pasantia = pg_fetch_row($result, 0);
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
                                <p><a href="pasantia.php?validar=<?php echo $_GET['id'] ?>">Validar</a>  -
                                <a style="paddig-left: 2px" href="pasantia.php?eliminar=<?php echo $_GET['id'] ?>">Eliminar</a></p>
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