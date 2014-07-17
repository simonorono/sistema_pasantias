<?php

require_once('globals.php');
require_once('db.php');

validate_session2('tutor_licom', 'dpe');

$db = new PgDB();

$periodo = $db->query('SELECT id FROM periodo WHERE periodo.activo = TRUE');
$rowp=  pg_fetch_array($db->query('SELECT anio,tipo FROM periodo WHERE periodo.activo = TRUE'));
$tipo_cuenta = session_var('tipo_cuenta');


//error_reporting(0);
if (pg_num_rows($periodo) == 0) $error = 'periodo';
else {
    $periodo = pg_fetch_row($periodo, 0)[0];

    $qry = "SELECT usuario.cedula, usuario.nombre, usuario.apellido, pasantia.id FROM pasantia INNER JOIN usuario ON usuario.id = pasantia.usuario_id AND pasantia.periodo_id = $periodo";

    if ($tipo_cuenta == 'dpe') $qry = $qry . " AND pasantia.valida = TRUE ORDER BY pasantia.id";
    else $qry = $qry . " ORDER BY pasantia.id";

    $pasantias = $db->query($qry);
    $num_total_registros = pg_num_rows($pasantias);
    $tam_total=ceil($num_total_registros/10);
    if (pg_num_rows($pasantias) == 0) $error = 'pasantia';
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
if (isset($error)) {
    if ($error == 'periodo') {
                    ?>
                    <h2>No hay periodo activo.</h2>
                    <?php
    } else if ($error == 'pasantia') {
                    ?>
                    <h2>No hay pasantías activas en el periodo activo.</h2>
                    <?php
    }
} else {


    echo "<h3>Periodo ".$rowp['tipo']." ".$rowp['anio']."</h3>";
                    ?>
                    <form method="post" action="pasantias.php">
                        <p>Buscar por cédula:
                            <input type="text" name="search" id="search"/>
                        </p>
                        <label for="pagina">Página:</label>
                        <?php
    echo "<select name='indice' id='pagina'>";
    for($i=0;$i<$tam_total;$i++)
    {
        echo "<option value='".$i."'>".($i+1)."</option>";
    }
                        ?>
                        <input type="submit" id="boton2" name="boton" value="aceptar"/>
                    </form>
                    <table>
                        <thead>
                            <tr class="periodo_tr">
                                <th>Cédula</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                            </tr>
                        </thead>

                        <?php
    $TAMANO_PAGINA = 10;
    extract($_POST);
    if(!(isset($indice) && isset($search))){
        $pos = 0;
        $pagina=1;
        $busqueda=null;
    }

    else{
        $pagina=$indice;
        if(isset($search))
            $busqueda=$search;
        $pos = ($pagina) * $TAMANO_PAGINA;

    }
    if(isset($_GET['busqueda']) && isset($_GET['bandera'])){
        $busqueda=$_GET['busqueda'];
        $bandera=$_GET['bandera'];
    }
    else
        $bandera=0;
    if(!$busqueda){
        for ($i = 0; $i < $TAMANO_PAGINA; $i++) {
            if($num_total_registros<=($i+$pos))
                break;
            else{
                $row = pg_fetch_row($pasantias, ($i+$pos));

                        ?>
                        <tr class="periodo_tr">
                            <td class="periodo_td"><a href="pasantia.php?id=<?php echo $row[3]; ?>"><?php echo $row[0]; ?></a></td>
                            <td class="periodo_td"><?php echo $row[1]; ?></td>
                            <td class="periodo_td"><?php echo $row[2]; }?></td>
                        </tr>
                        <?php
        }
    }
    else{
        $pos=$bandera * $TAMANO_PAGINA;
        $qry= "SELECT usuario.cedula, usuario.nombre, usuario.apellido, pasantia.id FROM pasantia INNER JOIN usuario ON usuario.id = pasantia.usuario_id AND pasantia.periodo_id = $periodo WHERE usuario.cedula LIKE '%$busqueda%' ORDER BY usuario.cedula ";
        $pasantias=$db->query($qry);
        $num_total_registros = pg_num_rows($pasantias);
        for ($i = 0; $i < $TAMANO_PAGINA; $i++){//debido a que el qry cambia la cantidad de rows por busqueda tambien
            if($num_total_registros<=($i+$pos))
                break;
            $row = pg_fetch_row($pasantias, ($i+$pos));
                        ?>
                        <tr class="periodo_tr">
                            <td class="periodo_td"><a href="pasantia.php?id=<?php echo $row[3]; ?>"><?php echo $row[0]; ?></a></td>
                            <td class="periodo_td"><?php echo $row[1]; ?></td>
                            <td class="periodo_td"><?php echo $row[2]; ?></td>
                        </tr>
                        <?php

        }
    }
}

                        ?>
                    </table>
                    <?php
if($busqueda)
{
    if($bandera==0 && ceil($num_total_registros/10)>1)
        echo "<a href='pasantias.php?bandera=1&busqueda=".$busqueda."'>pagina siguiente</a>";
    else if($bandera>0 &&$bandera+1<ceil($num_total_registros/10) ){
        echo "<a href='pasantias.php?bandera=".($bandera+1)."&busqueda=".$busqueda."'>pagina siguiente</a>";
        echo "<br>";
        echo "<a href='pasantias.php?bandera=".($bandera-1)."&busqueda=".$busqueda."'>pagina anterior</a>";
    }
    else if ($bandera+1==ceil($num_total_registros/10) && $bandera!=0)
        echo "<a href='pasantias.php?bandera=".($bandera-1)."&busqueda=".$busqueda."'>pagina anterior</a>";

}?>
                </div>
            </div>
            <br/>
            <?php include( "include/pie.php"); ?>
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
    th {font-weight:200;
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
