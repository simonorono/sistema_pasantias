<?php

require_once('globals.php');
validate_session('estudiante');

require_once('db.php');
require_once('calendario/calendario.php');

$db = new PgDB();

$count = $db->query('SELECT count(*) FROM usuario INNER JOIN pasantia ON usuario.id = pasantia.usuario_id');
$count = pg_fetch_row($count, 0)[0];

$periodo = $db->query('SELECT count(*) FROM periodo WHERE periodo.activo = TRUE');
$periodo = pg_fetch_row($periodo, 0)[0];

?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Registro de pasantía.</title>
        <link href="./css/estilo.css" rel="stylesheet" type="text/css" />
        <script type="application/javascript" src="calendario/javascript.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <?php require_once("include/cabecera.php"); ?>
            </div>
            <?php require_once("include/menu_estudiantes.php"); ?>
            <div class="content">
                <?php require_once("include/fecha.php"); ?>
                <?php if ($periodo != 1) { ?>

                <div align="center">
                    <h2>No hay perido activo, consulte con el administrador.</h2>
                </div>

                <?php } else if ($count == 0) { ?>

                <h1 align="center">Registro de pasantias</h1>
                <table align="center">
                    <tr>
                        <td>
                            <form method="post" name="rp" action="do_registro.php" id="jform">
                                <p>
                                    <label for="compania">Nombre de la compañia</label>
                                    <input type="text" name="compania" id="compania" required/>
                                </p>
                                <p>
                                    <label for="compania_email">Correo de la compañia</label>
                                    <input type="text" name="compania_email" id="compania_email" required/>
                                </p>
                                <p>
                                    <label for="direccion">Dirección</label>
                                    <textarea name="direccion" id="direccion" required></textarea>
                                </p>
                                <p>
                                    <label for="dirigido_a">Dirigido a</label>
                                    <input type="text" name="dirigido_a" id="dirigido_a" required/>
                                </p>
                                <p>
                                    <label for="supervisor">Supervisor</label>
                                    <input type="text" name="supervisor" id="supervisor" required/>
                                </p>
                                <p>
                                    <label for="actividad">Actividad</label>
                                    <input type="text" name="actividad" id="actividad" required/>
                                </p>
                                <p>
                                    <label for="actividades">Actividades</label>
                                    <textarea name="actividades" id="actividades" required></textarea>
                                </p>
                                <p>
                                    <label for="telefono_celu">Teléfono celular</label>
                                    <input type="text" name="telefono_celu" id="telefono_celu" required/>
                                </p>
                                <p>
                                    <label for="telefono_ofic">Teléfono de oficina</label>
                                    <input type="text" name="telefono_ofic" id="telefono_ofic" required/>
                                </p>
                                <p>
                                    <label for="fecha_inicio">Fecha de inicio</label>
                                    <?php escribe_formulario_fecha_vacio('fecha_inicio', 'rp'); ?>
                                </p>
                                <p>
                                    <label for="fecha_fin">Fecha de finalización</label>
                                    <?php escribe_formulario_fecha_vacio('fecha_fin', 'rp'); ?>
                                </p>
                                <p>
                                    <label for="tiempo_completo">Tiempo Completo</label>
                                    <input type="checkbox" id="tiempo_completo" name="tiempo_completo"/>
                                </p>
                                <p>
                                    <input type="submit" value="Registrar">
                                </p>
                            </form>
                            <script type="application/javascript" src="validacion_registro.js"></script>
                        </td>
                    </tr>
                </table>

                <?php } else { ?>

                <div align="center">
                    <h2>No puede registrar más de una pasantia.</h2>
                </div>

                <?php } ?>

            </div>
            <?php require_once("include/pie.php"); ?>
        </div>
    </body>
</html>
