<?php

require_once("fpdf/fpdf.php");
require_once('jpgraph-3.5.0b1/src/jpgraph.php');
require_once('jpgraph-3.5.0b1/src/jpgraph_pie.php');
require_once("jpgraph-3.5.0b1/src/jpgraph_pie3d.php");
require_once('db.php');
require_once('conteo.php');

class reporte extends fpdf
{

function graficarPDF()
{
	$solo_registrados = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m01_registrada IS NOT NULL AND pasantia.m02_aceptada IS NULL");
	$solo_aceptadas = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m02_aceptada IS NOT NULL AND pasantia.m03_numero_asignado IS NULL");
	$solo_numero_asignado = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m03_numero_asignado IS NOT NULL AND pasantia.m04_sellada IS NULL");
	$solo_sellada = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m04_sellada IS NOT NULL AND pasantia.m05_entrego_copia IS NULL");
	$solo_entrego_copia = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m05_entrego_copia IS NOT NULL AND pasantia.m06_entrego_borrador IS NULL");
	$solo_entrego_borrador = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m06_entrego_borrador IS NOT NULL AND pasantia.m07_retiro_borrador IS NULL");
	$solo_retiro_borrador = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m07_retiro_borrador IS NOT NULL AND pasantia.m08_entrega_final IS NULL");
	$finalizaron = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m08_entrega_final IS NOT NULL");

	$data = array($solo_registrados, $solo_aceptadas, $solo_numero_asignado, $solo_sellada, $solo_entrego_copia, $solo_entrego_borrador, $solo_retiro_borrador, $finalizaron); //aqui va la cantidad que llevará cada parte del grafico

	$graph = new PieGraph(640, 480); //tamaño de la letra del titulo y la leyenda
	$graph->SetShadow();

	$graph->title->Set("REPORTE TOTAL");
	$graph->title->SetFont(FF_FONT2,FS_BOLD);

	$p1 = new PiePlot($data); //se llenara el grafico dependiendo de cuantos datos sean
	//$p1->SetCenter(0.5,0.55); //no se pa que es esto ._.
	$p1->value->Show(true); //mostrar los valores en %

	$p1->SetLegends(array("Registradas", "Aceptadas", "Numeros Asignados", "Selladas", "Entrega de Copias", "Entrega de Borrador", "Retiro de Borrador", "Finalizaron")); //la leyenda del gráfico
	$p1->SetSize(0.30); //el radio del gráfico
	//$p1->SetAngle(45); //setear el angulo

	$graph->Add($p1);
	$graph->Stroke("asd.png");
	$this->Image("asd.png", -15, 60, 240, 180); // x, y, ancho, altura.
	$this->Image("logotipo.jpg",20,12,-280);
	unlink("asd.png");

}

}

$pdf=new reporte('P', 'mm', 'Letter');//creamos el documento pdf
$pdf->AddPage();//agregamos la pagina
$pdf->SetFont("Arial","B",12);//establecemos propiedades del texto tipo de letra, negrita, tamaño
//$pdf->Cell(40,10,'hola mundo',1);
$pdf->MultiCell(200,5,utf8_decode("\nRepública Bolivariana de Venezuela\nUniversidad del Zulia\nFacultad Experimental de Ciencias\nDivisión de Programas Especiales\nSistema de Pasantías\n"), 0, "C", 0);
$pdf->graficarPDF();
$pdf->Output();


?>

