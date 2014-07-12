<?php

function validate_session($tipo) {
    session_start();
    if (session_status() == PHP_SESSION_NONE) $error = 1;
    if ($_SESSION['tipo_cuenta'] !== $tipo) $error = 1;
    if(isset($error)) header('Location: index.php');
}

function validate_session2($tipo1, $tipo2) {
    session_start();
    if (session_status() == PHP_SESSION_NONE) $error = 1;
    if ($_SESSION['tipo_cuenta'] !== $tipo1 && $_SESSION['tipo_cuenta'] !== $tipo2) $error = 1;
    if(isset($error)) header('Location: index.php');
}

function logout() {
    session_start();
    unset($_SESSION['tipo_cuenta']);
    unset($_SESSION['username']);
    unset($_SESSION['nombre']);
    unset($_SESSION['apellido']);
    session_destroy();
    header('Location: index.php');
}

function session_var($name) {
    if (session_status() == PHP_SESSION_NONE)
        return null;
    else
        return $_SESSION[$name];
}

?>
