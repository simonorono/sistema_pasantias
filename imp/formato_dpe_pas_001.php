<?php

require('../fpdf/fpdf.php');
require_once ('../globals.php');
require_once ('../db.php');

validate_session("estudiante");

date_default_timezone_set('America/Caracas');

$db = new PgDB();
$id = session_var('usuario_id');

$qry = "SELECT nombre, apellido, cedula, dirigido_a, numero_carta FROM usuario INNER JOIN pasantia ON pasantia.usuario_id = usuario.id AND usuario.id = $id";

$reco = $db->query($qry);

$row = pg_fetch_array($reco);

$pdf = new FPDF('P','mm','Letter');
$pdf->AddPage();


$fecha = date ('d-m-Y', time());
$nroCP = "$row[numero_carta]";
$ciudadano = "$row[dirigido_a]";
$nombre = "$row[nombre] $row[apellido]";
$cedula = "$row[cedula]";


//linea superior
$pdf->Line(28, 20, 187, 20);
$pdf->Line(28, 20.7, 187, 20.7);

//linea inferior
$pdf->Line(28,53,187,53);
$pdf->Line(28,53.7,187,53.7);

//linea izquierda
$pdf->Line(186,54,186,20);
$pdf->Line(186.7,54,186.7,20);

//linea derecha
$pdf->Line(28,54,28,20);
$pdf->Line(28.7,54,28.7,20);

//linea interna izquierda
$pdf->Line(70,41,70,21);

//linea interna derecha
$pdf->Line(142,41,142,21);

//Membrete
$pdf->SetFont('Arial','',10);
$pdf->SetXY(30,22);
$pdf->MultiCell(153,5,utf8_decode("Universidad del Zulia\nFacultad Experimental de Ciencias\nDivisión de programas Especiales\nLicenciatura en Computación"), 0, "C", 0);

//imagen
$pdf->Image("logotipo.jpg",40,21,-380);

$pdf->SetFont('Arial','B',14);
$pdf->SetXY(147,25);
$pdf->MultiCell(150,5,utf8_decode("DPE-PAS-001"), 0, "J", 0);

$pdf->SetFont('Arial','B',7);
$pdf->SetXY(157,32.5);
$pdf->MultiCell(150,5,utf8_decode("R/1 01-10"), 0, "J", 0);

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(30,38);
$pdf->MultiCell(153,5,utf8_decode("\nCARTA DE POSTULACIÓN DE PASANTÍA ANTE UNA EMPRESA/INSTITUCIÓN DE UN ESTUDIANTE DE LA LICENCIATURA EN COMPUTACIÓN"), 0, "C", 0);


//Intro a la carta
$pdf->SetFont('Arial','',12);
$pdf->SetXY(30,60);
$pdf->MultiCell(153,5,utf8_decode("Maracaibo, $fecha"), 0, "J", 0);

$pdf->SetXY(155,70);
$pdf->MultiCell(153,5,utf8_decode("CP-$nroCP-2010"), 0, "J", 0);

$pdf->SetXY(30,80);
$pdf->MultiCell(153,5,utf8_decode("Ciudadano \n$ciudadano\nSu Despacho.-"), 0, "J", 0);


//Cuerpo de la carta
$pdf->SetXY(30,100);
$pdf->MultiCell(153,5,utf8_decode("Sirva la presente para postular al Br $nombre titular de la Cédula de Identidad No.: $cedula, estudiante de la Licenciatura en Computación de la Facultad Experimental de Ciencias de la Universidad del Zulia para desempeñarse como pasante de su organización.\n
	El periodo de pasantía debe tener una duración mínima de seis (6) semanas a tiempo completo o doce (12) semanas a medio tiempo, quedando la remuneración otorgada al pasante, el horario y duración definitiva del periodo de común acuerdo entre las partes.
	\nSu organización asignará un supervisor que deberá cumplir con las siguientes asignaciones:
	*\t\t\tOrientar y evaluar las actividades desempeñadas por el pasante.
	*\t\t\tEnviar el formato de actividades a realizar por el pasante (Formato_DPE-PAS-002_Registro de Pasantías) en un sobre sellado al supervisor académico al inicio de las pasantías.
	*\t\t\tRevisar el informe final de la pasantía.
	*\t\t\tEnviar el formato de evaluación (Formato_DPE-PAS-003_Evaluación de Pasantías) en un sobre sellado al supervisor académico al finalizar las pasantías.
	\nSin otro particular a que hacer referencia, atentamente,\n\n"),0,'J',0);


//Atentamente...
$pdf->SetXY(30,220);
$pdf->MultiCell(153,5,utf8_decode("\n______________________________\nProf. Olinto Rodríguez\nCoordinador de Pasantías de LICOM"), 0, "C", 0);

$pdf->Output("formato_dpe_pas_001.pdf", "D");

?>
