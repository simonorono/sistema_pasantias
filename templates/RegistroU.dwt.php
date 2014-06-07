<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>Documento sin título</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<link href="css/estilo.css" rel="stylesheet" type="text/css" />
<style>
    label{
        width: 160px;
    }
</style>
</head>

<body>

<div class="container">
  <div class="header"><?php include("include/cabecera.php"); ?></div>
 <?php include("include/menu.php"); ?>
  <div class="content">
  <?php include("include/fecha.php"); ?>
<table width="700" height="135" border="0">
  <tr>
      <th width="402" scope="col"><div align="left"><h1 align="center">Registro</h1></div></th>
  </tr>
  <tr>
    <td>
      <form method="post">
      <label for="usuario">nombre de usuario:</label>
      <input type="text" name="usuario" id="usuario"/>
      <br />
      </br>
      <label for="clave">clave de usuario:</label>
      <input type="password"  name="clave" id="clave"/>
      <br />
      </br>
         <label for="correo">Correo electronico:</label>
      <input type="text"  name="correo" id="correo"/>
      <br />
      </br>
         <label for="nombre">Su(s) nombre(s):</label>
      <input type="text"  name="nombre" id="nombre"/>
        <br />
      </br>
         <label for="nombre">Su(s) apeliido(s):</label>
      <input type="text"  name="apellido" id="apellido"/>
        <br />
      </br>


      <label for="cedula">Su cedula:
      <select name="menuCI">
         <option value="V">V:</option>
         <option value="E">E:</option>
      </select>
      </label>
      <input type="text"  name="cedula" id="cedula"/>
        <br />
      </br>
         <label for="carnet">Su codigo de carnet:</label>
      <input type="text"  name="carnet" id="carnet"/>
      <p align="center">
        <input type="submit" style="border-style: hidden;" id="boton2" name="boton" value="aceptar"/>
    </p>
      </form>
      </td>
  </tr>

</table>

    <!-- end .content --></div>

  <?php include("include/pie.php"); ?>

    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
</html>
