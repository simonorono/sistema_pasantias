<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>Bienvenido</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<link href="css/estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="container">
  <div class="header"><?php include("include/cabecera.php"); ?></div>
  <?php include("include/menu.php"); ?>
  


  <div class="content" >
  <?php include("include/fecha.php"); ?>
    <div align="center">
      <table width="412" height="135" border="5">
        <tr>
          <th width="402" scope="col"><div align="center""><h1>Inicio de sesion</h1></div></th>
        </tr>
        <tr>
          <td><p>
            <form method="post">
              <label for="usuario">usuario:</label>
              <input type="text" name="usuario" id="usuario"/>
              <br />
              </br>
              <label for="clave">clave:</label>
              <input type="password"  name="clave" id="clave"/>
              </p>
              <p align="center"> 
                <input type="submit" style="border-style: hidden;" id="boton2" name="boton" value="aceptar"/>
              </p>
            </form>
          </td>
        </tr>
        <td>&nbsp;
          <a href="RegUsuario.php" style="text-decoration-color: #03C">no estas registrado?</a>
          </td>
  </table>
    </div>
  </div>
  
  <?php include("include/pie.php"); ?>
    
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
</html>