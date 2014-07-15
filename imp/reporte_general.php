<?php

require('../mc_table.php');
//require_once("../fpdf/fpdf.php");
require_once('jpgraph-3.5.0b1/src/jpgraph.php');
require_once('jpgraph-3.5.0b1/src/jpgraph_pie.php');
require_once ("jpgraph-3.5.0b1/src/jpgraph_pie3d.php");
require_once('../db.php');
require_once('../conteo.php');

date_default_timezone_set('America/Caracas');

$pdf=new PDF_MC_Table('P', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetMargins(20,20);

$db = new PgDB();

//QUERY PARA LOS ESTUDIANTES DEL PERIODO ACTIVO
/*$query = "SELECT nombre, apellido, cedula, m01_registrada ::timestamp::date, m02_aceptada ::timestamp::date, m03_numero_asignado ::timestamp::date, m05_entrego_copia ::timestamp::date,
            m06_entrego_borrador ::timestamp::date, m07_retiro_borrador ::timestamp::date,  m08_entrega_final ::timestamp::date, m09_carga_nota ::timestamp::date, aprobada
            FROM usuario INNER JOIN pasantia ON usuario.id = pasantia.usuario_id AND usuario.tipo = 'estudiante' INNER JOIN periodo ON periodo.id = pasantia.periodo_id AND periodo.activo = TRUE";


$reco = pg_query($query);
$row = pg_fetch_array($reco);
*/


//QUERY PARA EL PERIDO ACTIVO
$queryPer = "SELECT tipo, anio FROM periodo WHERE activo = TRUE";
$recoPer = pg_query($queryPer);
$rowPer = pg_fetch_array($recoPer);


$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(0,5,utf8_decode("\nRepública Bolivariana de Venezuela\nUniversidad del Zulia\nFacultad Experimental de Ciencias\nDivisión de Programas Especiales\nSistema de Pasantías\n"), 0, "C", 0);
$pdf->MultiCell(165,5,utf8_decode("\n\nReporte General"), 0, "C", 0);
$pdf->MultiCell(165,5,utf8_decode("\n$rowPer[tipo] - $rowPer[anio]"), 0, "C", 0);
$pdf->Ln();



$inscritos = contar("SELECT COUNT(*) FROM pasantia INNER JOIN periodo ON periodo.id = pasantia.periodo_id AND periodo.activo = TRUE WHERE pasantia.m01_registrada IS NOT NULL");
$aprobados = contar("SELECT COUNT(*) FROM pasantia INNER JOIN periodo ON periodo.id = pasantia.periodo_id AND periodo.activo = TRUE WHERE pasantia.aprobada = TRUE");
$reprobados = contar("SELECT COUNT(*) FROM pasantia INNER JOIN periodo ON periodo.id = pasantia.periodo_id AND periodo.activo = TRUE WHERE pasantia.aprobada = FALSE");

$pdf->Image("logotipo.jpg",20,12,-280);

//GENERAR LA TABLA
$pdf->SetXY(57,70);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetWidths(array(30,30,30));
$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C','C'));
$pdf->Row(array("Inscritos", "Aprobados", "Reprobados"));

$pdf->SetX(57);
$pdf->SetFont('Arial','',12);
$pdf->SetWidths(array(30,30,30));
$pdf->SetAligns(array('C','C','C'));

$pdf->Row(array("$inscritos", "$aprobados", "$reprobados"));


//GENERAR LA GRAFICA

$graph = new PieGraph(640, 480);
$graph->SetShadow();
$graph->title->Set("APROBADOS / REPROBADOS");
$graph->title->SetFont(FF_FONT2,FS_BOLD);

if($aprobados != 0 || $reprobados != 0)
{
    $data = array($aprobados, $reprobados);
    $p1 = new PiePlot($data);
    $p1->value->Show(true);
    $p1->SetLegends(array("Aprobados", "Reprobados"));
} else if($inscritos <= 0) {
    $data = array(1);
    $p1 = new PiePlot($data);
    $p1->value->Show(true);
    $p1->SetLegends(array(utf8_decode("No hay notas definitivas, ni inscritos aún.")));
} else {
    $data = array($inscritos);
    $p1 = new PiePlot($data);
    $p1->value->Show(true);
    $p1->SetLegends(array(utf8_decode("No hay notas definitivas aún")));
}

$p1->SetSize(0.30);

$graph->Add($p1);
$graph->Stroke("asd.png");

$pdf->Image("asd.png", 0, 100, 200, 140);
unlink("asd.png");

$pdf->Output("reporte_general.pdf" ,"D");

?>
