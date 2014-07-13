<?php

require_once('db.php');
require_once('globals.php');

$db = new PgDB();

date_default_timezone_set('America/Caracas');

validate_session2('tutor_licom', 'dpe');

if (!(isset($_GET['id']) &&
      isset($_GET['n']))) {
    die("Faltan parametros");
}

$id = $_GET['id'];
$n = $_GET['n'];

switch ($n) {
    case 4:
    $hito = 'm04_sellada';
    break;

    case 5:
    $hito = 'm05_entrego_copia';
    break;

    case 6:
    $hito = 'm06_entrego_borrador';
    break;

    case 7:
    $hito = 'm07_retiro_borrador';
    break;

    case 8:
    $hito = 'm08_entrega_final';
    break;

    default:
    die("Ese hito no se puede marcar o no existe.");
    break;
}

$today = date ('Y-m-d', time());
$qry = "UPDATE pasantia SET $hito = '$today' WHERE pasantia.id = $id";

$db->query($qry);

header('Location: done.php?go=estado_pasantias.php');

?>
