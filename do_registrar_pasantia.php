<?php

date_default_timezone_set('America/Caracas');

require_once ('db.php');
require_once ('error.php');
require_once ('globals.php');

extract ($_POST);

if (isset ($tiempo_completo)) $tiempo_completo = 'TRUE';
else $tiempo_completo = 'FALSE';

if (!(isset ($compania) &&
      isset ($compania_email) &&
      isset ($departamento) &&
      isset ($direccion) &&
      isset ($dirigido_a) &&
      isset ($supervisor) &&
      isset ($cargo_supervisor) &&
      isset ($actividad) &&
      isset ($actividades) &&
      isset ($horario) &&
      isset ($telefono_celu) &&
      isset ($telefono_ofic) &&
      isset ($fecha_inicio) &&
      isset ($fecha_fin) &&
      isset ($tiempo_completo))) {
    die ("Missing parameters");
}

if (strlen ($compania) == 0) $error = 1;
if (strlen ($compania_email) == 0) $error = 2;
if (strlen ($direccion) == 0) $error = 3;
if (strlen ($dirigido_a) == 0) $error = 4;
if (strlen ($supervisor) == 0) $error = 5;
if (strlen ($actividad) == 0) $error = 6;
if (strlen ($actividades) == 0) $error = 7;
if (strlen ($horario) == 0) $error = 8;
if (strlen ($telefono_celu) == 0) $error = 9;
if (strlen ($telefono_ofic) == 0) $error = 10;
if (strlen ($fecha_inicio) == 0) $error = 11;
if (strlen ($fecha_fin) == 0) $error = 12;

var_dump($fecha_inicio);
$fecha_inicio = date_format (DateTime::createFromFormat('d/m/Y', $fecha_inicio), 'Y-m-d');
$fecha_fin = date_format (DateTime::createFromFormat('d/m/Y', $fecha_fin), 'Y-m-d');
$today = date ('Y-m-d', time());
die();

if (isset ($error)) {
    var_dump($error);
    die($error);
}
else {
    $db = new PgDB();
    session_start();
    $usuario_id = $_SESSION['usuario_id'];

    $qry = "SELECT id FROM periodo WHERE periodo.activo = TRUE";
    $result = $db->query($qry);
    $periodo_id = pg_fetch_row ($result, 0)[0];

    $qry = "INSERT INTO pasantia (usuario_id, periodo_id, compania, email, departamento, direccion, dirigido_a, supervisor, cargo_supervisor, actividad, actividades, horario, telefono_celu, telefono_ofic, fecha_inicio, fecha_fin, tiempo_completo, m01_registrada, valida) VALUES ($usuario_id, $periodo_id, '$compania', '$compania_email', '$departamento', '$direccion', '$dirigido_a', '$supervisor', '$cargo_supervisor', '$actividad', '$actividades', '$horario', '$telefono_celu', '$telefono_ofic', '$fecha_inicio', '$fecha_fin', $tiempo_completo, '$today', false)";

    $db->query($qry);
}

header ('Location: index.php');

?>
