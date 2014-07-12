
<?php

include('db.php');
$db = new PgDB();
$periodos=($db->query("SELECT * FROM periodo where periodo.activo=TRUE"));
$rowp = pg_fetch_array($periodos);
$num_total_registros = pg_num_rows($db->query("SELECT * FROM usuario,pasantia WHERE pasantia.usuario_id=usuario.id AND pasantia.periodo_id=$rowp[id]"));
$tam_total=ceil($num_total_registros/10);
date_default_timezone_set('America/Caracas');

?>
<form method="post" action="estado_pasantias.php">
    <?php

error_reporting(E_ALL ^ E_NOTICE);
$rowp = pg_fetch_array($periodos);
echo "<h1>Periodo ".$rowp['tipo']." ".$rowp['anio']."</h1>";

    ?>

    <p>Buscar por cédula:
        <input type="text" name="busqueda" id="search"/>
    </p>
    <label for="pagina">Página</label>

    <?php

echo "<select name='indice' id='pagina'>";

for($i=0;$i<$tam_total;$i++)
{
    echo "<option value='".$i."'>".($i+1)."</option>";
}

    ?>
    <input type="submit" style="border-style: hidden;" id="boton2" name="boton" value="aceptar"/>
</form>
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
            <th  scope="col">Enrego borrador</th>
            <th  scope="col">Retiro borrador</th>
            <th  scope="col">Entrega final</th>
            <th  scope="col">Carga de nota</th>
        </tr>
    </thead>


    <?php

$TAMANO_PAGINA = 10;

//examino la página a mostrar y el inicio del registro a mostrar

$pagina=$_POST["indice"];
$busqueda=$_POST["busqueda"];
if (!$pagina) {
    $pos = 0;
    $pagina=1;
}
else {
    $pagina=$_POST["indice"];
    $pos = ($pagina) * $TAMANO_PAGINA;//el mas 2 es para no mostrar a monica y a olinto

}
if(!$busqueda) {
    $qry = "SELECT * FROM usuario,pasantia,periodo WHERE pasantia.periodo_id=periodo.id AND pasantia.usuario_id=usuario.id AND periodo.activo=TRUE ORDER BY pasantia.id LIMIT $TAMANO_PAGINA OFFSET $pos";
    $results = $db->query($qry);
    while($row = pg_fetch_array($results))
    {
        // $row es un array con todos los campos existentes en la tabla
        //var_dump($row[12]);
        //die();
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
        else if(!empty($row['m03_numero_asignado'])) {
            echo "<th><a href='marcar.php?id=$row[12]&n=4'>Marcar</a></th>";
        }
        else {
            echo "<th><p>---</p></th>";
        }

        if(!empty($row['m05_entrego_copia'])) {
            echo "<th>".date( "d/m/Y", strtotime($row['m05_entrego_copia']))."</th>";
        }
        else if(!empty($row['m04_sellada'])) {
            echo "<th><a href='marcar.php?id=$row[12]&n=5'>Marcar</a></th>";
        }
        else {
            echo "<th><p>---</p></th>";
        }

        if(!empty($row['m06_entrego_borrador'])) {
            echo "<th>".date( "d/m/Y", strtotime($row['m06_entrego_borrador']))."</th>";
        }
        else if(!empty($row['m05_entrego_copia'])) {
            echo "<th><a href='marcar.php?id=$row[12]&n=6'>Marcar</a></th>";
        }
        else {
            echo "<th><p>---</p></th>";
        }

        if(!empty($row['m07_retiro_borrador'])) {
            echo "<th>".date( "d/m/Y", strtotime($row['m07_retiro_borrador']))."</th>";
        }
        else if(!empty($row['m06_entrego_borrador'])) {
            echo "<th><a href='marcar.php?id=$row[12]&n=7'>Marcar</a></th>";
        }
        else {
            echo "<th><p>---</p></th>";
        }

        if(!empty($row['m08_entrega_final'])) {
            echo "<th>".date( "d/m/Y", strtotime($row['m08_entrega_final']))."</th>";
        }
        else if(!empty($row['m07_retiro_borrador'])) {
            echo "<th><a href='marcar.php?id=$row[12]&n=8'>Marcar</a></th>";
        }
        else {
            echo "<th><p>---</p></th>";
        }

        if(!empty($row['m09_carga_nota'])) {
            echo "<th>".date( "d/m/Y", strtotime($row['m09_carga_nota']))."</th>";
        }
        else if(!empty($row['m08_entrega_final'])) {
            echo "<th><a href='cargar_nota.php?id=$row[12]'>Cargar nota</a></th>";
        }
        else {
            echo "<th><p>---</p></th>";
        }

        echo "</tr>";
    }
}
else
{
    $busqueda= $_POST["busqueda"];

    $results= $db->query("SELECT * FROM usuario, pasantia WHERE usuario.cedula LIKE '%$busqueda%' AND pasantia.usuario_id = usuario.id ");

    if(pg_fetch_row($results)<1) {
        echo "<h2>Ningún usuario posee la cédula buscada<h2>";
    }
    else {
        $row = pg_fetch_array($results,0);

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
        else if(!empty($row['m03_numero_asignado'])) {
            echo "<th><a href='marcar.php?id=$row[12]&n=4'>Marcar</a></th>";
        }
        else {
            echo "<th><p>---</p></th>";
        }

        if(!empty($row['m05_entrego_copia'])) {
            echo "<th>".date( "d/m/Y", strtotime($row['m05_entrego_copia']))."</th>";
        }
        else if(!empty($row['m04_sellada'])) {
            echo "<th><a href='marcar.php?id=$row[12]&n=5'>Marcar</a></th>";
        }
        else {
            echo "<th><p>---</p></th>";
        }

        if(!empty($row['m06_entrego_borrador'])) {
            echo "<th>".date( "d/m/Y", strtotime($row['m06_entrego_borrador']))."</th>";
        }
        else if(!empty($row['m05_entrego_copia'])) {
            echo "<th><a href='marcar.php?id=$row[12]&n=6'>Marcar</a></th>";
        }
        else {
            echo "<th><p>---</p></th>";
        }

        if(!empty($row['m07_retiro_borrador'])) {
            echo "<th>".date( "d/m/Y", strtotime($row['m07_retiro_borrador']))."</th>";
        }
        else if(!empty($row['m06_entrego_borrador'])) {
            echo "<th><a href='marcar.php?id=$row[12]&n=7'>Marcar</a></th>";
        }
        else {
            echo "<th><p>---</p></th>";
        }

        if(!empty($row['m08_entrega_final'])) {
            echo "<th>".date( "d/m/Y", strtotime($row['m08_entrega_final']))."</th>";
        }
        else if(!empty($row['m07_retiro_borrador'])) {
            echo "<th><a href='marcar.php?id=$row[12]&n=8'>Marcar</a></th>";
        }
        else {
            echo "<th><p>---</p></th>";
        }

        if(!empty($row['m09_carga_nota'])) {
            echo "<th>".date( "d/m/Y", strtotime($row['m09_carga_nota']))."</th>";
        }
        else if(!empty($row['m08_entrega_final'])) {
            echo "<th><a href='cargar_nota.php?id=$row[12]'>cargar nota</a></th>";
        }
        else {
            echo "<th><p>---</p></th>";
        }

        echo "</tr>";
    }
}

echo "</table>";

    ?>
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
