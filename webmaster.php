<?php
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('Content-Type: text/html; charset=utf-8');
    header('WWW-Authenticate: Basic realm="Administrador"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Necesita autorización para ingresar a esta página.';
    exit;
} else {
    //echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
    //echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
    if($_SERVER['PHP_AUTH_PW'] != 'simon'){
    header('HTTP/1.0 401 Unauthorized');}
    echo $_SERVER['PHP_AUTH_PW'];
}
?>
