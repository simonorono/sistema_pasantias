<?php

require_once('globals.php');

validate_session('tutor_licom');

extract($_POST);

if (!isset($tipo_reporte)) {
    die('Missing parameters');
}

switch($tipo_reporte) {
    case "general":
    header("Location: imp/reporte_general.php");
    break;

    case "hitos":
    header("Location: imp/reporte_graficas.php");
    break;

    case "pasantes":
    header("Location: imp/reporte_pasantes.php");
    break;

    default:
    break;
}

?>
