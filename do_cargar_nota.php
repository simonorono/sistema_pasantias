<?php

require_once('db.php');
require_once('globals.php');

$db = new PgDB();

validate_session('tutor_licom');

extract ($_POST);

if (!isset($nota)) {
    die('Missing parameters');
}

if ($nota == "aprobada") {
    $val = "true";
} else if ($nota == "reprobada") {
    $val = "false";
}

if (isset($val)) {
    $id = $_GET['id'];
    $today = date ('Y-m-d', time());
    $qry = "UPDATE pasantia SET m09_carga_nota = '$today', aprobada = $val WHERE pasantia.id = $id";
    $db->query($qry);
    header ("Location: done.php?go=estado_pasantias.php");
}

?>
