<?php

require('../fpdf/fpdf.php');
require_once ('../globals.php');
require_once ('../db.php');

validate_session('estudiante');

date_default_timezone_set('America/Caracas');

class PDF_MC_Table extends FPDF
{
    var $widths;
    var $aligns;
    var $height;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function Row($data)
    {
        $height = 1.5;
        //Calculate the height of the row
        $nb=$height;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function Row_without_borders($data)
    {
        $height = 2.2;
        //Calculate the height of the row
        $nb=$height;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            //$this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

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
        $this->MultiCell(150,5,utf8_decode("DPE-PAS-003"), 0, "J", 0);

        $this->SetFont('Arial','B',7);
        $this->SetXY(157,32.5);
        $this->MultiCell(150,5,utf8_decode("R/1 01-10"), 0, "J", 0);

        $this->SetFont('Arial','B',10);
        $this->SetXY(30,41);
        $this->MultiCell(153,5,utf8_decode("\nEVALUACIÓN DE LA PASANTÍA DE LA LICENCUATURA EN COMPUTACIÓN"), 0, "C", 0);

    }

    function formatoTabla()
    {

        $db = new PgDB();
        $id = session_var('usuario_id');

        $this->SetMargins(20,25);
        $alto = 10;
        $ancho = 172;


        $qryUsr = "SELECT nombre, apellido, cedula, direccion, cod_carne, telefono_celu, telefono_habi, email FROM
            usuario WHERE usuario.id = $id";

        $reco = $db->query($qryUsr);
        $rowUsr = pg_fetch_array($reco);


        //Identificación del Alumno
        $this->SetFont('Arial','B',12);
        $this->SetXY(20,60);
        //$this->MultiCell($ancho,$alto,utf8_decode("Identificación del Alumno: "),0);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row_without_borders(array(utf8_decode("\nIdentificación del Alumno: \n ")));

        $this->SetFont('Arial','',12);

        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));


        $this->Row(array(utf8_decode("\nNombres y Apellidos: $rowUsr[nombre] $rowUsr[apellido]")));

        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));

        //AQUI ES DONDE VA LA DIRECCIÓN DEL USUARIO
        $this->Row(array((utf8_decode("\nDirección: $rowUsr[direccion]"))));

        $this->SetX(20);
        $this->SetWidths(array(85,85));
        $this->SetAligns(array('L'));
        $this->Row(array((utf8_decode("\nC.I.: $rowUsr[cedula]")), (utf8_decode("\nCarnet Nro.: $rowUsr[cod_carne]")) ));

        $this->SetX(20);
        $this->SetWidths(array(85,85));
        $this->SetAligns(array('L'));
        $this->Row(array((utf8_decode("\nCelular: $rowUsr[telefono_celu]")), (utf8_decode("\nTeléfono Habitación: $rowUsr[telefono_habi]")) ));

        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row(array(utf8_decode("\nCorreo Electrónico: $rowUsr[email]")));


        $qryEmpr = "SELECT compania, pasantia.direccion, pasantia.telefono_celu, telefono_ofic, pasantia.email
                FROM pasantia INNER JOIN usuario ON pasantia.usuario_id = usuario.id AND usuario.id = $id";

        $reco = $db->query($qryEmpr);
        $rowEmpr = pg_fetch_array($reco);


        //Identificación de la Empresa
        $this->SetFont('Arial','B',12);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row_without_borders(array(utf8_decode("\n\nIdentificación de la Empresa / Institución: \n ")));

        $this->SetFont('Arial', '', 12);

        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row(array(utf8_decode("\nNombre: $rowEmpr[compania]")));

        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row(array((utf8_decode("\nDirección: $rowEmpr[direccion]"))));

        $this->SetX(20);
        $this->SetWidths(array(85,85));
        $this->SetAligns(array('L'));
        $this->Row(array((utf8_decode("\nCelular: $rowEmpr[2]")), (utf8_decode("\nTeléfono: $rowEmpr[telefono_ofic]")) ));

        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row(array(utf8_decode("\nCorreo Electrónico: $rowEmpr[email]")));


        //QUERY PARA DATOS DEL PASANTE
        $qryPas = "SELECT actividad, supervisor, cargo_supervisor, departamento, horario, fecha_inicio::timestamp::date, fecha_fin::timestamp::date, tiempo_completo, actividades
                FROM pasantia INNER JOIN usuario ON pasantia.usuario_id = usuario.id AND usuario.id = $id";

        $reco = $db->query($qryPas);
        $rowPas = pg_fetch_array($reco);

        //Datos de las actividades de la Pasantia

        /*$this->SetFont('Arial','B',12);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row_without_borders(array(utf8_decode("\n\nDatos de las actividades de la Pasantía: \n ")));
        */

        $this->SetFont('Arial', '', 12);

        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row(array(utf8_decode("\nActividad del Pasante en la Empresa / Institución: $rowPas[actividad]")));

        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row(array((utf8_decode("\nNombre del Supervisor Inmediato: $rowPas[supervisor]"))));

        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row(array((utf8_decode("\nCargo que ocupa: $rowPas[cargo_supervisor]"))));

        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row(array((utf8_decode("\nDepartamento donde realizó la pasantía: $rowPas[departamento]"))));

        $this->SetX(20);
        $this->SetWidths(array(85,85));
        $this->SetAligns(array('L'));
        $this->Row(array((utf8_decode("\nFecha de inicio: $rowPas[fecha_inicio]")), (utf8_decode("\nFecha de finalización: $rowPas[fecha_fin]")) ));

        if($rowPas['tiempo_completo'] == TRUE)
        {
            $this->SetWidths(array(45, 45, 17.5, 45, 17.5));
            $this->SetAligns(array('L'));
            $this->Row(array((utf8_decode("\nTiempo de pasantía: ")), (utf8_decode("\nTiempo completo: ")), (utf8_decode("  \n     X  ")), (utf8_decode("\nMedio tiempo: ")), (utf8_decode("\n"))));
        }

        else
        {
            $this->SetWidths(array(45, 45, 17.5, 45, 17.5));
            $this->SetAligns(array('L'));
            $this->Row(array((utf8_decode("\nTiempo de pasantía: ")), (utf8_decode("\nTiempo completo: ")), (utf8_decode("\n")), (utf8_decode("\nMedio tiempo: ")), (utf8_decode("  \n     X  "))));
        }


        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row(array((utf8_decode("\nHorario de trabajo del Pasante: $rowPas[horario]"))));

        $this->Ln();

        //EVALUACIÓN DEL ESTUDIANTE
        $this->SetFont('Arial', 'B', 12);

        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('C'));
        $this->Row(array((utf8_decode("\nEVALUACIÓN DEL ESTUDIANTE POR PARTE DE LA EMPRESA"))));

        $this->SetWidths(array(95, 15, 15, 15, 15, 15));
        $this->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));
        $this->Row(array((utf8_decode("\nASPECTOS")), "\nDEF", "\nSAT", "\nBUE", "\nMB", "\nEXC"));

        $this->SetFont('Arial', '', 12);

        $this->SetWidths(array(95, 15, 15, 15, 15, 15));
        $this->SetAligns(array('L', 'C', 'C', 'C', 'C', 'C'));
        $this->Row(array((utf8_decode("\n Puntualidad")), "", "", "", "", ""));

        $this->SetWidths(array(95, 15, 15, 15, 15, 15));
        $this->SetAligns(array('L', 'C', 'C', 'C', 'C', 'C'));
        $this->Row(array((utf8_decode("\n Cooperación")), "", "", "", "", ""));

        $this->SetWidths(array(95, 15, 15, 15, 15, 15));
        $this->SetAligns(array('L', 'C', 'C', 'C', 'C', 'C'));
        $this->Row(array((utf8_decode("\n Iniciativa")), "", "", "", "", ""));

        $this->SetWidths(array(95, 15, 15, 15, 15, 15));
        $this->SetAligns(array('L', 'C', 'C', 'C', 'C', 'C'));
        $this->Row(array((utf8_decode("\n Habilidad/Destreza")), "", "", "", "", ""));

        $this->SetWidths(array(95, 15, 15, 15, 15, 15));
        $this->SetAligns(array('L', 'C', 'C', 'C', 'C', 'C'));
        $this->Row(array((utf8_decode("\n Responsabilidad")), "", "", "", "", ""));

        $this->SetWidths(array(95, 15, 15, 15, 15, 15));
        $this->SetAligns(array('L', 'C', 'C', 'C', 'C', 'C'));
        $this->Row(array((utf8_decode("\n Organización")), "", "", "", "", ""));

        $this->SetWidths(array(95, 15, 15, 15, 15, 15));
        $this->SetAligns(array('L', 'C', 'C', 'C', 'C', 'C'));
        $this->Row(array((utf8_decode("\n Eficiencia")), "", "", "", "", ""));

        $this->SetWidths(array(95, 15, 15, 15, 15, 15));
        $this->SetAligns(array('L', 'C', 'C', 'C', 'C', 'C'));
        $this->Row(array((utf8_decode("\n Dedicación")), "", "", "", "", ""));

        $this->SetWidths(array(95, 15, 15, 15, 15, 15));
        $this->SetAligns(array('L', 'C', 'C', 'C', 'C', 'C'));
        $this->Row(array((utf8_decode("\n Respeto Jerárquico")), "", "", "", "", ""));

        $this->SetWidths(array(95, 15, 15, 15, 15, 15));
        $this->SetAligns(array('L', 'C', 'C', 'C', 'C', 'C'));
        $this->Row(array((utf8_decode("\n Sociabilidad")), "", "", "", "", ""));

        $this->SetWidths(array(95, 15, 15, 15, 15, 15));
        $this->SetAligns(array('L', 'C', 'C', 'C', 'C', 'C'));
        $this->Row(array((utf8_decode("\n Presentación")), "", "", "", "", ""));

        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row(array((utf8_decode("\nEmita una opinión sobre el rendimiento académico del Pasante:\n\n\n"))));

        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row(array((utf8_decode("\nEmita una opinión sobre el conocimiento de los equipos que manejó el Pasante:\n\n\n"))));

        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row(array((utf8_decode("\n¿Qué recomendaciones daría Usted para completar la formación del Pasante?\n\n\n"))));

        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array('L'));
        $this->Row(array((utf8_decode("\nOtras sugerencias:\n\n\n"))));


        $this->Ln();
        $this->SetX(20);
        $this->SetWidths(array(56, 57, 57));
        $this->SetAligns(array('L'));
        $this->Row(array((utf8_decode("\nFecha: ")), (utf8_decode("\nSello de la Empresa / Institución: \n\n\n\n\n ")), (utf8_decode("\nFirma del Supervisor Inmediato: "))));
    }
}
//Main

$pdf=new PDF_MC_Table('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Membrete();
$pdf->formatoTabla();
$pdf->Output("formato_dpe_pas_003.pdf", "D");

?>
