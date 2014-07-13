<div class="sidebar1">
    <script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css" />
    <div id="menu" class="Accordion" tabindex="2" style="color:FFF;">
        <div class="AccordionPanel">
            <div class="AccordionPanelTab">Estudiantes</div>
            <div class="AccordionPanelContent">
                <p class="pmenu"><a href="index.php">Inicio</a></p>
                <p class="pmenu"><a href="registrar_pasantia.php">Registrar pasantia</a></p>
                <p class="pmenu"><a href="carta_001.php">Carta de postulación</a></p>
                <p class="pmenu"><a href="carta_002.php">Carta de registro</a></p>
                <?php
                $id=session_var('usuario_id');
                echo "<p class='pmenu'><a href='consulta_estudiante.php?id=".$id."'>Estado de pasantia</a></p>";
                ?>
                <p class="pmenu"><a href="logout.php">Salir</a></p>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        var Accordion1 = new Spry.Widget.Accordion("menu");
    </script>
</div>
