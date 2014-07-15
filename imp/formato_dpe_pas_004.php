<?php

require('../fpdf/fpdf.php');
require_once ('../globals.php');
require_once ('../db.php');

validate_session('estudiante');

date_default_timezone_set('America/Caracas');

class PDF extends FPDF
{
    function membrete()
    {

        $this->SetMargins(30,25);
        //linea superior
        $this->Line(28, 20, 187, 20);
        $this->Line(28, 20.7, 187, 20.7);

        //linea inferior
        $this->Line(28,53,187,53);
        $this->Line(28,53.7,187,53.7);

        //linea izquierda
        $this->Line(186,54,186,20);
        $this->Line(186.7,54,186.7,20);

        //linea derecha
        $this->Line(28,54,28,20);
        $this->Line(28.7,54,28.7,20);

        //linea interna izquierda
        $this->Line(70,41,70,21);

        //linea interna derecha
        $this->Line(142,41,142,21);

        //Membrete
        $this->SetFont('Arial','',10);
        $this->SetXY(30,22);
        $this->MultiCell(153,5,utf8_decode("Universidad del Zulia\nFacultad Experimental de Ciencias\nDivisión de programas Especiales\nLicenciatura en Computación"), 0, "C", 0);

        //imagen
        $this->Image("logotipo.jpg",40,21,-380);

        $this->SetFont('Arial','B',14);
        $this->SetXY(147,25);
        $this->MultiCell(150,5,utf8_decode("DPE-PAS-004"), 0, "J", 0);

        $this->SetFont('Arial','B',7);
        $this->SetXY(157,32.5);
        $this->MultiCell(150,5,utf8_decode("R/1 01-10"), 0, "J", 0);

        $this->SetFont('Arial','B',10);
        $this->SetXY(30,38);
        $this->MultiCell(153,5,utf8_decode("\nHOJA DE APROBACIÓN DE PASANTÍA ANTE UNA EMPRESA/INSTITUCIÓN DE UN ESTUDIANTE DE LA LICENCIATURA EN COMPUTACIÓN"), 0, "C", 0);

    }

    function cuerpo()
    {

        $db = new PgDB();
        $id = session_var('usuario_id');

        $this->SetMargins(20,25);
        $alto = 10;
        $ancho = 172;


        $query = "SELECT supervisor, cargo_supervisor, nombre, apellido, cedula, usuario.telefono_celu, usuario.direccion, usuario.email
                FROM pasantia INNER JOIN usuario ON pasantia.usuario_id = usuario.id AND usuario.id = $id";

        $reco = $db->query($query);
        $row = pg_fetch_array($reco);

        $this->SetFont('Arial', '', 12);

        $this->SetXY(30, 85);
        $this->MultiCell(147,5,utf8_decode("__________________________\nTutor Industrial\n$row[supervisor]\nCargo: $row[cargo_supervisor]"),0,'C',0);

        $this->SetXY(30, 135);
        $this->MultiCell(147,5,utf8_decode("Sello de la empresa"),0,'C',0);


        $this->SetXY(30, 175);
        $this->MultiCell(147,5,utf8_decode("____________________________\nBr: $row[nombre] $row[apellido]\nC.I. No.: $row[cedula]\nTeléfono: $row[5]\nDirección: $row[6]\nCorreo Electrónico: $row[7]"),0,'C',0);


        $this->SetXY(30,230);
        $this->MultiCell(153,5,utf8_decode("\n______________________________\nProf. Olinto Rodríguez\nCoordinador de Pasantías de LICOM"), 0, "C", 0);


    }
}

//Main


$pdf=new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->membrete();
$pdf->cuerpo();
$pdf->Output("formato_dpe_pas_002.pdf", "D");

?>
