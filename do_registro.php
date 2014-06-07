<?php

require("db.php");
require("error.php");
header('Content-Type: text/html; charset=utf-8');
function check_username ($var) {
    $db = new PgDB();
    $qry = "SELECT 1 FROM usuario WHERE usuario.username = '$var'";
    $result = $db->query($qry);
    if(pg_num_rows($result) > 0)
        return pg_fetch_row($result, 0)[0];
    else return 0;
}

function check_email ($var) {
    $db = new PgDB();
    $qry = "SELECT 1 FROM usuario WHERE usuario.email = '$var'";
    $result = $db->query($qry);
    if(pg_num_rows($result) > 0)
        return pg_fetch_row($result, 0)[0];
    else return 0;
}

extract($_POST);

if (!(isset($username) &&
      isset($password) &&
      isset($email) &&
      isset($nombre) &&
      isset($apellido) &&
      isset($cedula)))
    die("Missing parameters.");

if (strlen($username) < 6) $error = 1;
if (strlen($password) < 6) $error = 2;
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 3;
if (strlen($nombre) == 0) $error = 4;
if (strlen($apellido) == 0) $error = 5;
if (strlen($cedula) == 0) $error = 6;
if (check_username($username) == 1) $error = 7;
if (check_email($email) == 1) $error = 8;

if (isset($error)) {
    die($error_registro[$error]);
}
else {

    $hash_passwd = hash('sha512', $password);

    $db = new PgDB();

    $qry = "INSERT INTO usuario (username, password, email, nombre, apellido, cedula, tipo) VALUES ('$username', '$hash_passwd', '$email', '$nombre', '$apellido', '$cedula', 'estudiante')";

    $db->query($qry);
    header('Location: index.php');
}
?>
