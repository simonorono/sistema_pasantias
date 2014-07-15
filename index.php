
<?php

session_start();
if (session_status() == PHP_SESSION_ACTIVE) extract($_SESSION);

if(isset($tipo_cuenta) &&
   isset($username)) {
    if($tipo_cuenta == 'tutor_licom') {
        header('Location: licom.php');
    }
    else if($tipo_cuenta == 'estudiante') {
        header('Location: main.php');
    }
    else if($tipo_cuenta == 'dpe') {
        header('Location: dpe.php');
    }
}

$usr = "";

if (isset($_GET['u'])) {
    $usr = $_GET['u'];
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sistema de pasantías.</title>
        <link href="css/estilo.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="container">
            <div class="header">
                <?php require_once("include/cabecera.php"); ?>
            </div>
            <?php require_once("include/menu_general.php"); ?>
            <div class="content">
                <?php require_once("include/fecha.php"); ?>
                <div align="center">
                    <h1>Inicio de sesión</h1>
                    <?php
if (isset($_GET['err'])) {
                    ?>
                    <div style="color:#DC0909">Usuario o contraseña incorrectos.</div>
                    <?php
} else { echo '<br/>'; }
                    ?>
                    <table class="s_table" id="tabla">
                        <tr>
                            <td>
                                <form method="post" action="do_inicio.php">
                                    <p>
                                        <label for="username">Nombre de usuario</label>
                                        <input type="text" name="username" id="username" value="<?php echo $usr; ?>" required/>
                                    </p>
                                    <p>
                                        <label for="password">Contraseña</label>
                                        <input type="password" name="password" id="password" required/>
                                    </p>
                                    <p align="center">
                                        <input type="submit" id="button" name="button" value="Ingresar" />
                                    </p>
                                </form>
                            </td>
                        </tr>
                        <td>
                            <a href="registro.php" style="text-decoration-color: #03C">Registrarse</a>
                        </td>
                    </table>
                    <script type="application/javascript" src="validaciones.js"></script>
                </div>
            </div>
            <?php require_once("include/pie.php"); ?>
        </div>
    </body>

</html>
