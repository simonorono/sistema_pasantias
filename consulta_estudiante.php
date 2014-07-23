<?php

require_once ('globals.php');
require_once('db.php');
validate_session ('estudiante');
$db = new PgDB();
$id = session_var('usuario_id');
$qry=$db->query("SELECT * FROM usuario,pasantia WHERE usuario.id = $id AND usuario.id=pasantia.usuario_id");

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
            <?php require_once("include/menu_estudiantes.php"); ?>
            <div class="content">
                <?php
require_once ("include/fecha.php");
if (pg_num_rows($qry)==0)
    echo "<h2 align='center'>Usted no se ha registrado como pasante</h2>";
else{
                ?>
                <div align="center">
                    <table>
                        <thead>
                            <tr>
                                <th  scope="col">Nombre</th>
                                <th  scope="col">C.I</th>
                                <th  scope="col">Registrada</th>
                                <th  scope="col">Validada</th>
                                <th  scope="col">Número asignado</th>
                                <th  scope="col">Carta sellada</th>
                                <th  scope="col">Entrego copia</th>
                                <th  scope="col">Entrego borrador</th>
                                <th  scope="col">Retiro borrador</th>
                                <th  scope="col">Entrega final</th>
                                <th  scope="col">Carga de nota</th>
                            </tr>
                        </thead>
                        <?php

    $row= pg_fetch_array($qry);
    echo "<tr>";

    echo "<th>".$row['nombre']." ".$row['apellido']."</th>";

    echo "<th>".$row['cedula']."</th>";

    echo "<th>".date( "d/m/Y", strtotime($row['m01_registrada']))."</th>";

    if(!empty($row['m02_aceptada'])) {
        echo "<th>".date( "d/m/Y", strtotime($row['m02_aceptada']))."</th>";
    }
    else {
        echo "<th><p>---</p></th>";
    }
    if(!empty($row['m03_numero_asignado'])) {
        echo "<th>".date( "d/m/Y", strtotime($row['m03_numero_asignado']))."</th>";
    }
    else {
        echo "<th><p>---</p></th>";
    }
    if(!empty($row['m04_sellada'])) {
        echo "<th>".date( "d/m/Y", strtotime($row['m04_sellada']))."</th>";
    }
    else {
        echo "<th><p>---</p></th>";
    }
    if(!empty($row['m05_entrego_copia'])) {
        echo "<th>".date( "d/m/Y", strtotime($row['m05_entrego_copia']))."</th>";
    }
    else {
        echo "<th><p>---</p></th>";
    }
    if(!empty($row['m06_entrego_borrador'])) {
        echo "<th>".date( "d/m/Y", strtotime($row['m06_entrego_borrador']))."</th>";
    }
    else {
        echo "<th><p>---</p></th>";
    }
    if(!empty($row['m07_retiro_borrador'])) {
        echo "<th>".date( "d/m/Y", strtotime($row['m07_retiro_borrador']))."</th>";
    }
    else {
        echo "<th><p>---</p></th>";
    }
    if(!empty($row['m08_entrega_final'])) {
        echo "<th>".date( "d/m/Y", strtotime($row['m08_entrega_final']))."</th>";
    }
    else {
        echo "<th><p>---</p></th>";
    }
    if(!empty($row['m09_carga_nota'])) {
        if($row['aprobada']==true)
            echo "<th><p>aprobado</p></th>";
        else if($row['aprobada']==false)
            echo "<th><p>reprobado</p></th>";
    }
    else {
        echo "<th><p>---</p></th>";
    }

    echo "</tr>";}


                        ?>
                    </table>
                </div>
            </div>
            <?php require_once ("include/pie.php"); ?>
        </div>
    </body>

</html>
<style type="text/css">
    table {
        font: 1.0em Arial, Helvetica, sans-serif;

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
    th {
        font-weight:200;
        background-color:#82c0ff;
        background:-o-linear-gradient(bottom, #82c0ff 5%, #56aaff 100%);
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #82c0ff), color-stop(1, #56aaff) );
        background:-moz-linear-gradient( center top, #82c0ff 5%, #56aaff 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#82c0ff", endColorstr="#56aaff");
        background: -o-linear-gradient(top,#82c0ff,56aaff);
        background-color:#FFF;
        border-top: solid 1px black;
        border-bottom: solid 1px gray;
        background: rgb(59,103,158); /* Old browsers */
        background: -moz-linear-gradient(top,  rgba(59,103,158,1) 0%, rgba(43,136,217,1) 50%, rgba(32,124,202,1) 51%, rgba(125,185,232,1) 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(59,103,158,1)), color-stop(50%,rgba(43,136,217,1)), color-stop(51%,rgba(32,124,202,1)), color-stop(100%,rgba(125,185,232,1)));
        background: -webkit-linear-gradient(top,  rgba(59,103,158,1) 0%,rgba(43,136,217,1) 50%,rgba(32,124,202,1) 51%,rgba(125,185,232,1) 100%);
        background: -o-linear-gradient(top,  rgba(59,103,158,1) 0%,rgba(43,136,217,1) 50%,rgba(32,124,202,1) 51%,rgba(125,185,232,1) 100%);
        background: -ms-linear-gradient(top,  rgba(59,103,158,1) 0%,rgba(43,136,217,1) 50%,rgba(32,124,202,1) 51%,rgba(125,185,232,1) 100%);
        background: linear-gradient(to bottom,  rgba(59,103,158,1) 0%,rgba(43,136,217,1) 50%,rgba(32,124,202,1) 51%,rgba(125,185,232,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3b679e', endColorstr='#7db9e8',GradientType=0 );
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
