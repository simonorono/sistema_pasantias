<?php

require_once ("db.php");
require_once ("error.php");

header ('Content-Type: text/html; charset=utf-8');

function check_username ($var) {
    $db = new PgDB ();
    $qry = "SELECT 1 FROM usuario WHERE usuario.username = '$var'";
    $result = $db->query ($qry);
    if(pg_num_rows ($result) > 0)
        return pg_fetch_row ($result, 0)[0];
    else return 0;
}

function check_email ($var) {
    $db = new PgDB ();
    $qry = "SELECT 1 FROM usuario WHERE usuario.email = '$var'";
    $result = $db->query ($qry);
    if(pg_num_rows ($result) > 0)
        return pg_fetch_row ($result, 0)[0];
    else return 0;
}

extract($_POST);

if (!(isset ($username) &&
      isset ($password) &&
      isset ($email) &&
      isset ($nombre) &&
      isset ($apellido) &&
      isset ($cedula) &&
      isset ($telefono_celu) &&
      isset ($telefono_habi) &&
      isset ($cod_carne)))
    die ("Missing parameters.");

if (strlen ($username) < 6) $error = 1;
if (strlen ($password) < 6) $error = 2;
if (!filter_var ($email, FILTER_VALIDATE_EMAIL)) $error = 3;
if (strlen ($nombre) == 0) $error = 4;
if (strlen ($apellido) == 0) $error = 5;
if (strlen ($cedula) == 0) $error = 6;
if (check_username($username) == 1) $error = 7;
if (check_email($email) == 1) $error = 8;
if (strlen ($cod_carne) != 11) $error = 9;
if (strlen ($telefono_celu) == 0) $error = 10;
if (strlen ($telefono_habi) == 0) $error = 11;

if (isset ($error)) {
    die($error_registro[$error]);
}
else {

    $hash_passwd = hash('sha512', $password);

    $db = new PgDB();

    $qry = "INSERT INTO usuario (username, password, email, nombre, apellido, cedula, tipo, cod_carne, telefono_celu, telefono_habi) VALUES ('$username', '$hash_passwd', '$email', '$nombre', '$apellido', '$cedula', 'estudiante', '$cedula', '$telefono_celu', '$telefono_habi')";

    $db->query($qry);
    header('Location: done.php?go=index.php');
}
?>
