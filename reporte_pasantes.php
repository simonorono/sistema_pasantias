<?php
require('../pasantias/mc_table.php');
include('db.php');


$pdf=new PDF_MC_Table('L', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetMargins(20,20);


$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(0,5,utf8_decode("\nRepública Bolivariana de Venezuela\nUniversidad del Zulia\nFacultad Experimental de Ciencias\nDivisión de Programas Especiales\nSistema de Pasantías\n"), 0, "C", 0);
$pdf->MultiCell(228,5,utf8_decode("\nReporte de Pasantes Registrados"), 0, "C", 0);
$pdf->Ln();

$pdf->Image("logotipo.jpg",20,12,-280);

	$db = new PgDB();

	$query = "SELECT nombre, apellido, cedula, aprobada, m01_registrada ::timestamp::date, m02_aceptada ::timestamp::date, m03_numero_asignado ::timestamp::date, m05_entrego_copia ::timestamp::date,
			m06_entrego_borrador ::timestamp::date, m07_retiro_borrador ::timestamp::date,	m08_entrega_final ::timestamp::date, m09_carga_nota ::timestamp::date
			FROM usuario INNER JOIN pasantia ON usuario.id = pasantia.usuario_id AND usuario.tipo = 'estudiante'";


	$reco = pg_query($query);
	$row = pg_fetch_array($reco);

		$pdf->SetFont('Arial', 'B', '10');
		$pdf->SetWidths(array(25,20,22,22,25,25,25,25,25,25));
		$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C','C'));
		$pdf->Row(array("\nNombre", "\nC.I", "\nRegistrada", "\nAceptada", "Fecha Numero asignado", "\nEntrega de copia",
		 "\nEntrega de borrador", "\nRetiro borrador", "\nEntrega Final", "\nCarga de Nota"));


	while($row = pg_fetch_array($reco))
	{
		$pdf->SetFont('Arial','',10);
		$pdf->SetWidths(array(25,20,22,22,25,25,25,25,25,25));
		$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C','C'));


		$pdf->Row(array("$row[nombre]\n$row[apellido]", "\n$row[cedula]", "\n$row[m01_registrada]", "\n$row[m02_aceptada]",
		"\n$row[m03_numero_asignado]", "\n$row[m05_entrego_copia]", "\n$row[m06_entrego_borrador]",
		"\n$row[m07_retiro_borrador]", "\n$row[m08_entrega_final]", "\n$row[m09_carga_nota]"));
	}

//$pdf->Output("reporte_pasantes.pdf" ,"D");
$pdf->Output();
?>
