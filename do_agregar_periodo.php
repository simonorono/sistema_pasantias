<?php
session_start();
if (session_status() == PHP_SESSION_NONE) $error=1;
else {
    if ($_SESSION['tipo_cuenta'] !== 'tutor_licom') $error=1;
}
if (isset($error)) header('Location: index.php');

require_once('db.php');

extract($_POST);

header('Content-Type: text/html; charset=utf-8');

if (!(isset($anio)
      && isset($tipo)))
    die('Missing parameters.');

$db = new PgDB();

if ($anio < 2000 && $anio > 2999) {
    die('Año fuera de rango.');
}

$db->query('UPDATE periodo SET activo = false');
$qry = "INSERT INTO periodo (anio, tipo, activo) VALUES ('$anio', '$tipo', 'true')";
$db->query($qry);

header('Location: index.php');

?>
