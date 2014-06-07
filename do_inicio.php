<?php

require('db.php');
require('error.php');
extract($_POST);

if (!(isset($username) &&
      isset($password)))
    die('Missing parameters');

$hash_password = hash('sha512', $password);

$db = new PgDB();
$qry = "SELECT password, nombre, apellido, tipo FROM usuario WHERE usuario.username = '$username'";
$result = $db->query($qry);

if (pg_num_rows($result) == 0) $error = 1;
else {
    $data = pg_fetch_row($result, 0);
    $db_password = $data[0];
    $db_nombre = $data[1];
    $db_apellido = $data[2];
    $db_tipo = $data[3];
}

if ($hash_password != $db_password) $error = 2;

if (isset($error)) {
    header('Content-Type: text/html; charset=utf-8');
    die($error_inicio[$error]);
}
else {
    session_start();
    $_SESSION['nombre'] = $db_nombre;
    $_SESSION['apellido'] = $db_apellido;
    $_SESSION['username'] = $username;
    $_SESSION['tipo_cuenta'] = $db_tipo;
    header('Location: index.php');
}

?>
