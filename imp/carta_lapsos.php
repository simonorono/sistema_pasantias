<?php

require('../fpdf/fpdf.php');
require_once ('../globals.php');
require_once ('../db.php');

extract($_POST);

if (!(isset($entrega_borrador) &&
      isset($retiro_borrador) &&
      isset($entrega_final))) {
    die('Faltan parametros');
}

class PDF extends FPDF
{

    function membrete()
    {
        $db = new PgDB();
        $qryPeriodo = "SELECT tipo, anio FROM periodo WHERE periodo.activo = TRUE";
        $recoPeriodo = $db->query($qryPeriodo);
        $rowPeriodo = pg_fetch_array($recoPeriodo);

        $periodo = "$rowPeriodo[tipo]-$rowPeriodo[anio]";


        $this->SetFont('Arial','B',12);
        $this->SetXY(30,20);

        $this->MultiCell(153,5,utf8_decode("INFORME DE PASANTÍAS\n(PRACTICA PROFESIONAL II)\nFECHAS IMPORTANTES - $periodo\n"), 0, "C", 0);
    }

    function cuerpo($entrega_borrador, $retiro_borrador, $entrega_final)
    {
        $esp = 5;
        $tab = "\t\t\t\t";
        $this->SetXY(30,40);

        $db = new PgDB();
        $qryPeriodo = "SELECT tipo, anio FROM periodo WHERE periodo.activo = TRUE";
        $recoPeriodo = $db->query($qryPeriodo);
        $rowPeriodo = pg_fetch_array($recoPeriodo);

        $periodo = "$rowPeriodo[anio].$rowPeriodo[tipo]";

        //subtitulo
        $this->SetFont('Arial','B',12);

        $this->MultiCell(153,$esp,utf8_decode("($entrega_borrador). ENTREGA DEL BORRADOR INFORME DE PASANTÍAS.\n"),0,'J',0);

        $this->SetX(30);
        $this->SetFont('Arial','',12);
        $this->MultiCell(153,$esp,utf8_decode("$tab a) El borrador se recibirá en la DIVISIÓN DE PROGRAMAS ESPECIALES.\n"),0,'J',0);

        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab b) PUEDE SER entregado en hojas reutilizadas.\n"),0,'J',0);

        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab c) NO SE ACEPTARÁ ENTREGA DIGITAL. Tampoco se aceptará el CD con"),0,'J',0);

        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab     el   informe   ni   otro   documento  que  no   esté  especificado   en   ESTA"),0,'J',0);

        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab     COMUNICACIÓN.\n"),0,'J',0);

        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab d) Es OBLIGATORIA la entrega de  la  hoja  de  evaluación  del   tutor de las \n"),0,'J',0);

        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab     pasantías.\n"),0,'J',0);

        //Fecha documento final se busca en la BD**********************************************
        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab e) Para que el alumno pueda realizar las correcciones al documento final, el\n"),0,'J',0);

        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab     borrador se retirará el día ($retiro_borrador).\n"),0,'J',0);

        //$tab = "\t\t\t\t\t";
        //$esp = 5;
        $this->SetFont('Arial','B',12);

        $this->SetXY(30, 100);
        $this->MultiCell(153,5,utf8_decode("($entrega_final). ENTREGA FINAL INFORME DE PASANTÍAS.\n\n"),0,'J',0);

        $this->SetFont('Arial', '', 12);

        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab 1) El alumno COPIARÁ el informe digital CORREGIDO en el computador de"),0,'J',0);

        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab     la División de Programas Especiales."),0,'J',0);

        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab 2) El nombre del archivo será:  $periodo.nombre.apellido.doc. Ejemplo:  Si  el"),0,'J',0);

        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab     alumno     se     llama     José   Ramírez     el     archivo    debe   llamarse"),0,'J',0);

        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab     $periodo.jose.ramirez.doc (SIN CARACTERES ESPECIALES)."),0,'J',0);

        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab 3) El documento tendrá el formato correspondiente a la NORMATIVA LUZ."),0,'J',0);

        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab 4) Se recibirá un CD virgen. NUEVO. EN BLANCO. SIN USAR. El color del             CD no importa."),0,'J',0);

        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("$tab 5) Solo se entregará en físico: "),0,'J',0);

        $this->SetX(50);
        $this->MultiCell(153,$esp,utf8_decode("a) La hoja de aprobación (la hoja que lleva las firmas del pasante, la \n    del tutor en la organización donde se hizo la pasantía   y   la   del \n    coordinador de pasantías)."),0,'J',0);

        $this->SetX(50);
        $this->MultiCell(153,$esp,utf8_decode("b) Las hojas de evaluación del tutor en la empresa"),0,'J',0);

        $this->SetX(50);
        $this->MultiCell(153,$esp,utf8_decode("c) La hoja de registro de pasantías"),0,'J',0);

        $this->SetX(29);
        $this->MultiCell(153,$esp,utf8_decode("$tab 6) No   se  aceptará  otro  documento  en   físico.   ESTOS   DOCUMENTOS"),0,'J',0);

        $this->SetX(29);
        $this->MultiCell(153,$esp,utf8_decode("         DEBEN      ESTAR      SELLADOS       POR       LAS       INSTITUCIONES"),0,'J',0);

        $this->SetX(40);
        $this->MultiCell(153,$esp,utf8_decode("CORRESPONDIENTES (LUZ Y LA ORGANIZACIÓN DONDE SE REALIZÓ "),0,'J',0);

        $this->SetX(40);
        $this->MultiCell(153,$esp,utf8_decode("LA PASANTÍA)."),0,'J',0);

        $this->SetX(29);
        $this->MultiCell(153,$esp,utf8_decode("$tab 7) El CD Virgen así como los anexos del punto 5, se entregarán en un sobre"),0,'J',0);

        $this->SetX(40);
        $this->MultiCell(153,$esp,utf8_decode(" Manila. NO TIENE QUE SER NUEVO ESTE SOBRE."),0,'J',0);

        $this->SetFont('Arial', 'B', 12);
        $this->Ln();
        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("SI EL ALUMNO NO CUMPLE CON LAS ENTREGAS EN LAS FECHAS INDICADAS SU CALIFICACIÓN EN LA CÁTEDRA ''PRÁCTICA PROFESIONAL II' SERÁ ''SIN INFORMACIÓN'' Y TENDRÁ QUE INSCRIBIRLA EN OTRO SEMESTRE."),0,'J',0);

        $this->Ln();
        $this->SetX(30);
        $this->MultiCell(153,$esp,utf8_decode("NO HABRÁ PRÓRROGA.\nNO HABRÁ EXCEPCIONES."),0,'C',0);

    }
}

//Main

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->membrete();
$pdf->cuerpo($entrega_borrador, $retiro_borrador, $entrega_final);
$pdf->Output("carta_lapsos.pdf", "D");
?>
