<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Registro de nuevo usuario</title>
        <link href="./css/estilo.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div class="container">
            <div class="header">
                <?php require_once("include/cabecera.php"); ?>
            </div>
            <?php require_once("include/menu_general.php"); ?>
            <div class="content">
                <?php require_once("include/fecha.php"); ?>
                <h1 align="center">Registro</h1>
                <table align="center">
                    <tr>
                        <td>
                            <form method="post" action="do_registro.php" id="jform">
                                <p>
                                    <label for="usuario">Nombre de usuario</label>
                                    <input type="text" name="username" id="username" required pattern="^\w{6,20}$"/>
                                </p>
                                <p>
                                    <label for="clave">Contraseña</label>
                                    <input type="password" name="password" id="password" required pattern="^.{6,}$"/>
                                </p>
                                <p>
                                    <label for="correo">Correo electrónico</label>
                                    <input type="email" name="email" id="email" required/>
                                </p>
                                <p>
                                    <label for="nombre">Nombre</label>
                                    <input type="text" name="nombre" id="nombre" required/>
                                </p>
                                <p>
                                    <label for="nombre">Apellido</label>
                                    <input type="text" name="apellido" id="apellido" required/>
                                </p>
                                <p>
                                    <label for="telefono_celu">Telefóno celular</label>
                                    <input type="text" name="telefono_celu" id="telefono_celu" required/>
                                </p>
                                <p>
                                    <label for="telefono_habi">Telefóno de habitación</label>
                                    <input type="text" name="telefono_habi" id="telefono_habi" required/>
                                </p>
                                <p>
                                    <label for="cedula">Cédula</label>
                                    <input type="text" name="cedula" id="cedula" required>
                                </p>
                                <p>
                                    <label for="cod_carne">Código de carné</label>
                                    <input type="text" name="cod_carne" id="cod_carne" required pattern="^\d{11,11}$">
                                </p>
                                <p align="center">
                                    <input type="submit" value="Registrarse" name="send" id="send"/>
                                </p>
                            </form>
                            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
                            <script type="application/javascript" src="validaciones.js"></script>
                        </td>
                    </tr>
                </table>
            </div>
            <?php require_once("include/pie.php"); ?>
        </div>
    </body>
</html>
