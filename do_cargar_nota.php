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
    $today = date ('Y-m-d', time());
    $qry = "UPDATE pasantias SET m09_nota_cargada = '$today', aprobada = $val";
    $db->query($qry);
    header ("Location: done.php?=estado_pasantias.php");
}

?>
