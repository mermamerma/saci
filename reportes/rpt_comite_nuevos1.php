<?php

require_once '../cdatos/ccasos.php';
require_once('../comunes/tcpdf/config/lang/eng.php');
require_once('../comunes/tcpdf/tcpdf.php');


class MYPDF extends TCPDF
{
	// Page footer
        public function Header()
        {
            // Logo
            $this->Image(K_PATH_IMAGES.'cabecero_reporte.png', 20, 8, 170, 20);
            // Set font
            $this->SetFont('times', 'B', 12);
            $this->Ln(25);
            $this->Cell(80);
            $this->Cell(30, 10, $this->title, 0, 0, 'C');
	}

	public function Footer()
        {
            // Position at 15 mm from bottom
            $this->SetY(-25);
            // Set font
            $this->SetFont('times', 'I', 8);
            // Page number
            //$this->Cell(0, 10, 'Pag. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            $this->Cell(0, 10, "Generado a Través del Sistema Tierra Fértil en Números. en fecha (".fechaactual()."). Licencia: GPL/GNU. Creado por ".$this->author.".   Página ".$this->getAliasNumPage()."/".$this->getAliasNbPages(), 0, 0, 'C');

	}

}//class


$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$ccaso=new ccasos();

$idcaso=$_REQUEST["idcaso"];

$data_caso=new Recordset();
$data_caso=$ccaso->getDataCasoActual($idcaso);
$data_informe=$ccaso->getData_Informe_Comite_nuevos($idcaso);
$data_miembros=$ccaso->getMiembrosComite();

if ($data_caso)
{
    /*
    $sbenef=$data_caso->rowset["razon_social_benef"];
    $rif_benef=$data_caso->rowset["rif_benef"];
    $cedula_benef=$data_caso->rowset["cedula_benef"];
    if ($cedula_benef=="")  $sidentidad=$rif_benef;
    else    $sidentidad=$cedula_benef;
    */
    
	$num_caso=$data_caso->rowset["idcaso"];
    $ssolic=$data_caso->rowset["razon_social_solic"];
    $rif_solic=$data_caso->rowset["rif_solic"];
    $cedula_solic=$data_caso->rowset["cedula_solic"];
	$year=$data_caso->rowset["year"];
    
    if ($cedula_solic=="")  $sidentidad=$rif_solic;
    else    $sidentidad=$cedula_solic;
    
    $planteamiento=$data_caso->rowset["descripcion_caso"];
    $sestado=$data_caso->rowset["sestado_solic"];
}


if ($data_informe)
{
    
    $idinforme=$data_informe->rowset["idinforme"];
    $analisis=$data_informe->rowset["analisis"];
    $sugerencia=$data_informe->rowset["sugerencia"];
    $anexos=$data_informe->rowset["anexos"];
    $idestatus_final=$data_informe->rowset["idestatus_final"];
    $observacion_comite=$data_informe->rowset["observaciones"];
    
    $saprobado="";  $snegado="";    $sdiferido="";
    if ($idestatus_final==APROBADO) $saprobado="X";
    if ($idestatus_final==NEGADO)   $snegado="X";
    if ($idestatus_final==DIFERIDO) $sdiferido="X";

}

if ($data_miembros)
{    
    $omiembros= explode(",", $data_miembros);
    
    
    if($omiembros)
    {
        
        $ind=1;
        $smiembro1="";  $smiembro2="";  $smiembro3="";
        
        foreach ($omiembros as $valor)
        {
            if ($ind==1)    $smiembro1=$valor;
            if ($ind==2)    $smiembro2=$valor;
            if ($ind==3)    $smiembro3=$valor;
            
            $ind++;
        }
    }
    
}//if

$pdf->SetTitle('');
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($_SESSION["usuario_actual"]);

$pdf->SetSubject('Comite');
$pdf->SetKeywords('Comite');

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "", "");

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);

$pdf->AddPage();

$pdf->SetFont('times', '', 10);

$tabla="




<table cellspacing=\"0\" cellpadding=\"1\" border=\"0\">
<tr>
<td width=\"100%\" align=\"center\" valign=\"middle\">
<b>COMITÉ DE ANALISIS DE CASOS</b><br><br>
</td>       
</tr>
</table>";


$tabla.="<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
<tr>
<td align=\"left\" width=\"20%\"><b>PARA:</b></td>
<td align=\"left\" width=\"50%\">Administración</td>
<td align=\"left\" width=\"30%\"><b>N° ".$num_caso."-".$year."</b></td>
</tr>

<tr>
<td align=\"left\" width=\"20%\"><b>ASUNTO: </b></td>
<td align=\"left\" width=\"80%\" colspan=\"2\">".$ssolic."  ".$sidentidad.", ".$sestado."</td>
</tr>

<tr>
<td align=\"left\" width=\"20%\"><b>DE:</b></td>
<td align=\"left\" width=\"50%\">COMITÉ DE ANÁLISIS DE CASOS</td>
<td align=\"left\" width=\"30%\"><b>N° de Págs.: ".$pdf->getAliasNbPages()." de ".$pdf->getAliasNumPage()."</b></td>
</tr>

</table>

</br>

";

$tabla.="<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">

<tr style=\"background-color: #c0c0c0\">
<td align=\"left\" width=\"100%;\"><b>PLANTEAMIENTO:</b></td>
</tr>
<tr><td><span style=\"text-align:justify;\">".$planteamiento."</span></td></tr>

<tr style=\"background-color: #c0c0c0\">
<td align=\"left\" width=\"100%;\"><b>ANALISIS REALIZADO POR EL COMITE: </b></td>
</tr>
<tr><td><span style=\"text-align:justify;\">".$analisis."</span></td></tr>

<tr style=\"background-color: #c0c0c0\">
<td align=\"left\" width=\"100%;\"><b>SUGERENCIAS Y CONCLUSIONES DEL COMITE: </b></td>
</tr>
<tr><td><span style=\"text-align:justify;\">".$sugerencia."</span></td></tr>
</table>
<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
	<tr style=\"background-color: #c0c0c0\">
		<td align=\"CENTER\" width=\"25%;\"><b>ANEXOS</b></td>
		<td align=\"CENTER\" width=\"75%;\" colspan=\"7\"><b>CÓDIGO PRESUPUESTARIO</b></td>
	</tr>
<tr>
	<td rowspan=\"2\"><span style=\"text-align:justify;\">".$anexos."</span></td>
	<td align=\"CENTER\" style=\"font-size: 14px; font-weight: bold;\">PROYECTO</td>
	<td align=\"CENTER\" style=\"font-size: 14px; font-weight: bold;\">ACCIÓN CENTRALIZADA</td>
	<td align=\"CENTER\" style=\"font-size: 14px; font-weight: bold;\">ACCIÓN ESPECÍFICA</td>
	<td align=\"CENTER\" style=\"font-size: 14px; font-weight: bold;\">PARTIDA</td>
	<td align=\"CENTER\" style=\"font-size: 14px; font-weight: bold;\">GENÉRICA</td>
	<td align=\"CENTER\" style=\"font-size: 14px; font-weight: bold;\">ESPECÍFICA</td>
	<td align=\"CENTER\" style=\"font-size: 14px; font-weight: bold;\">SUB-ESPECÍFICA</td>	
</tr>
<tr>
	<td height=\"35px\"> &nbsp;</td>
	<td> &nbsp; </td>
	<td> &nbsp;</td>
	<td> &nbsp;</td>
	<td> &nbsp;</td>
	<td> &nbsp;</td>
	<td> &nbsp;</td>
</tr>
</table>

<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
<tr style=\"background-color: #c0c0c0\">
<td align=\"CENTER\" colspan=\"4\"><b>RESULTADO</b></td>
</tr>
<tr>
	<td align=\"LEFT\" height=\"30px;\" style=\"font-size: 18px; font-weight: bold;\" width=\"15%\">
		<br>[&nbsp;&nbsp;] APROBADO <br>
		<br>[&nbsp;&nbsp;] NEGADO <br>
		<br>[&nbsp;&nbsp;] VISTO
	</td>
	<td align=\"LEFT\" height=\"30px;\" style=\"font-size: 14px; font-weight: bold;\" width=\"25%\">INSTRUCCIONES</td>
	<td align=\"left\" height=\"30px;\" style=\"font-size: 18px; font-weight: bold;\" width=\"20%\">
		<br><br>[&nbsp;&nbsp;] FIRMA GERENTE GENERAL<br>
		<br><br>[&nbsp;&nbsp;] FIRMA DIRECTOR
	</td>
	<td align=\"center\" height=\"30px;\" width=\"40%\">&nbsp;</td>
</tr>
</table>
<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
	<tr style=\"background-color: #c0c0c0\">
		<td align=\"CENTER\" ><b>ELABORADO Y PRESENTADO</b></td>
		<td align=\"CENTER\" ><b>OFC. DE PLANIFICACIÓN Y PRESUPUESTO</b></td>
		<td align=\"CENTER\" ><b>OFC. DE ADMINISTRACIÓN Y FINANZAS </b></td>
	</tr>
	<tr>
		<td align=\"center\" height=\"40px;\" valign=\"bottom\"><br><br><br><br>COORD. DE COMITÉ</td>
		<td align=\"center\" height=\"40px;\" valign=\"bottom\"><br><br><br><br>COORD. PRESUPUESTO</td>
		<td align=\"center\" height=\"40px;\" valign=\"bottom\"><br><br><br><br>COORD. DE ADMINISTRACIÓN</td>
	</tr>
</table>";

$pdf->Ln(10);
$pdf->writeHTML($tabla, true, false, true, false, '');

$numero_rpt = rand(50,10000);
$pdf->Output("rpt_comite".$numero_rpt, 'I');

?>
