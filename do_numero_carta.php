<?php

require_once ('db.php');
require_once ('globals.php');

date_default_timezone_set('America/Caracas');

$db = new PgDB();

extract ($_POST);
$id = $_GET['id'];

if (!(isset($numero_carta) &&
      isset($id)))
    die('Missing parameters');

if (strlen($numero_carta) != 3)
    die('Error');

$today = date ('Y-m-d', time());

$qry = "UPDATE pasantia SET numero_carta = '$numero_carta', m03_numero_asignado = '$today' WHERE pasantia.id = '$id'";

$db->query($qry);

header ('Location: pasantias.php');

?>
