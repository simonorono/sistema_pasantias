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
        //$tab = "\t\t\t\t";
        $this->SetXY(30,40);

        $db = new PgDB();
        $qryPeriodo = "SELECT tipo, anio FROM periodo WHERE periodo.activo = TRUE";
        $recoPeriodo = $db->query($qryPeriodo);
        $rowPeriodo = pg_fetch_array($recoPeriodo);

        $periodo = "$rowPeriodo[anio].$rowPeriodo[tipo]";

        //parte 1
        $this->SetFont('Arial','B',12);

        $this->MultiCell(153,$esp,utf8_decode("($entrega_borrador). ENTREGA DEL BORRADOR INFORME DE PASANTÍAS.\n"),0,'J',0);

        $this->Ln();
        $this->SetX(35);
        $this->SetFont('Arial','',12);
        $this->MultiCell(153,$esp,utf8_decode("a) El borrador se recibirá en la DIVISIÓN DE PROGRAMAS ESPECIALES."),0,'J',0);

        $this->SetX(35);
        $this->MultiCell(153,$esp,utf8_decode("b) PUEDE SER entregado en hojas reutilizadas."),0,'J',0);

        $this->SetX(35);
        $this->MultiCell(153,$esp,utf8_decode("c) NO SE ACEPTARÁ ENTREGA DIGITAL. Tampoco se aceptará el CD con el informe ni otro documento que no esté especificado en ESTA COMUNICACIÓN."),0,'J',0);

        $this->SetX(35);
        $this->MultiCell(153,$esp,utf8_decode("d) Es OBLIGATORIA la entrega de  la  hoja  de  evaluación  del   tutor de las pasantías."),0,'J',0);

        $this->SetX(35);
        $this->MultiCell(153,$esp,utf8_decode("e) Para que el alumno pueda realizar las correcciones al documento final, el borrador se retirará el día ($retiro_borrador).\n\n"),0,'J',0);


        $this->SetFont('Arial','B',12);

        //parte 2
        $this->Ln();
        $this->Ln();

        $this->SetXY(30, 100);
        $this->MultiCell(153,5,utf8_decode("($entrega_final). ENTREGA FINAL INFORME DE PASANTÍAS.\n\n"),0,'J',0);

        $this->SetFont('Arial', '', 12);

        $this->SetX(35);
        $this->MultiCell(153,$esp,utf8_decode("1) El alumno COPIARÁ el informe digital CORREGIDO en el computador de la División de Programas Especiales."),0,'J',0);

        $this->SetX(35);
        $this->MultiCell(153,$esp,utf8_decode("2) El nombre del archivo será: $periodo.nombre.apellido.doc. Ejemplo: Si el alumno se llama José Ramírez el archivo debe llamarse $periodo.jose.ramirez.doc (SIN CARACTERES ESPECIALES)."),0,'J',0);

        $this->SetX(35);
        $this->MultiCell(153,$esp,utf8_decode("3) El documento tendrá el formato correspondiente a la NORMATIVA LUZ."),0,'J',0);

        $this->SetX(35);
        $this->MultiCell(153,$esp,utf8_decode("4) Se recibirá un CD virgen. NUEVO. EN BLANCO. SIN USAR. El color del CD no importa."),0,'J',0);

        $this->SetX(35);
        $this->MultiCell(153,$esp,utf8_decode("5) Solo se entregará en físico: "),0,'J',0);

        $this->SetX(50);
        $this->MultiCell(138,$esp,utf8_decode("a) La hoja de aprobación (la hoja que lleva las firmas del pasante, la del tutor en la organización donde se hizo la pasantía y la del coordinador de pasantías)."),0,'J',0);

        $this->SetX(50);
        $this->MultiCell(138,$esp,utf8_decode("b) Las hojas de evaluación del tutor en la empresa."),0,'J',0);

        $this->SetX(50);
        $this->MultiCell(138,$esp,utf8_decode("c) La hoja de registro de pasantías."),0,'J',0);

        $this->SetX(35);
        $this->MultiCell(153,$esp,utf8_decode("6) No se aceptará otro documento en físico. ESTOS   DOCUMENTOS DEBEN ESTAR SELLADOS POR LAS INSTITUCIONES CORRESPONDIENTES (LUZ Y LA ORGANIZACIÓN DONDE SE REALIZÓ LA PASANTÍA)."),0,'J',0);

        $this->SetX(35);
        $this->MultiCell(153,$esp,utf8_decode("7) El CD Virgen así como los anexos del punto 5, se entregarán en un sobre manila. NO TIENE QUE SER NUEVO ESTE SOBRE."),0,'J',0);


        $this->SetFont('Arial', 'B', 12);
        $this->Ln();
        $this->SetX(35);
        $this->MultiCell(145,$esp,utf8_decode("SI EL ALUMNO NO CUMPLE CON LAS ENTREGAS EN LAS FECHAS INDICADAS SU CALIFICACIÓN EN LA CÁTEDRA ''PRÁCTICA PROFESIONAL II' SERÁ ''SIN INFORMACIÓN'' Y TENDRÁ QUE INSCRIBIRLA EN OTRO SEMESTRE."),0,'J',0);

        $this->Ln();
        $this->SetX(35);
        $this->MultiCell(145,$esp,utf8_decode("NO HABRÁ PRÓRROGA.\nNO HABRÁ EXCEPCIONES."),0,'C',0);

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
