<?php

require_once ('globals.php');
require_once ('db.php');

validate_session ('tutor_licom');

$db = new PgDB();

if (isset ($_GET['op']) && isset ($_GET['id'])) {
    if ($_GET['op'] == 'del') {
        $qry = 'DELETE FROM periodo WHERE periodo.id = ' . $_GET['id'];
        $db->query ($qry);
        header ('Location: periodos.php');
    }
    if ($_GET['op'] == 'act') {
        $qry = 'UPDATE periodo SET activo = FALSE WHERE TRUE';
        $db->query ($qry);
        $qry = 'UPDATE periodo SET activo = TRUE WHERE periodo.id = ' . $_GET['id'];
        $db->query ($qry);
        header ('Location: periodos.php');
    }
}

extract($_POST);

header('Content-Type: text/html; charset=utf-8');

if (!(isset($anio)
      && isset($tipo)))
    die('Missing parameters.');

if ($anio < 2000 && $anio > 2999) {
    die('Año fuera de rango.');
}

$db->query('UPDATE periodo SET activo = false');
$qry = "INSERT INTO periodo (anio, tipo, activo) VALUES ('$anio', '$tipo', 'true')";
$db->query($qry);

header('Location: index.php');

?>
