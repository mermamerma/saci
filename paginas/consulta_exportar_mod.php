<?

#header('Content-type: application/vnd.ms-excel');
#header("Content-Disposition: attachment; filename=consulta_casos.xls");
#header("Pragma: no-cache");
#header("Expires: 0");

require_once("../librerias/db_postgresql.inc.php");
require_once('../comunes/tcpdf/tcpdf.php');
require_once('aplicaciones.php');

validar_sesion();

class MYPDF extends TCPDF {
	// Page footer
        public function Header()
        {
            // Logo
            $this->Image(K_PATH_IMAGES.'cabecero_horizontal.png', 20, 8, 250, 20);
            // Set font
            $this->SetFont('times', 'B', 12);
            $this->Ln(25);
            $this->Cell(80);
            $this->Cell(30, 10, $this->title, 0, 0, 'C');
	}

	public function Footer()
        {
            // Position at 15 mm from bottom7.650,65
            $this->SetY(-25);
            // Set font
            $this->SetFont('times', 'I', 8);
            // Page number
            $this->Cell(0, 10, "SACi - Sistema de Atención al Ciudadano, Generado el ".fechaactual()." por ".$this->author.".   Página ".$this->getAliasNumPage()."/".$this->getAliasNbPages(), 0, 0, 'C');
	}

}//class

ob_end_clean();
$modo = $_GET['modo'] ;
$tabla = '' ;
$tabla .='
<table border="1">
<thead>
<TR>
	<TD ><b>N° Caso</b></TD>
	<TD><b>Remitente</b></TD>
	<TD><b>Solicitante</b></TD>
	<TD><b>Beneficiario</b></TD>
	<TD><b>Ingreso Familiar</b></TD>
	<TD><b>Fecha de Registro</b></TD>
	<TD><b>Procesado</b></TD>
	<TD><b>Estatus</b></TD>
	<TD><b>Analista</b></TD>
</TR>
</thead>
<tbody>';
$tabla2 = $tabla ;
$textout='';
$filtro="";
//echo $sql;
#die($_SESSION["filtro_caso"]) ;
##die($_SESSION['consulta_sql']) ;
#die($sql) ;
#var_dump($_SESSION); exit;
$dat->Conectar();
$rscaso = new Recordset($_SESSION['consulta_sql'], $dat->conn);
$ind = 1;
$estiloFila = '';
while ($rscaso->Mostrar()) {
	$tabla.= "<tr>";
	$tabla.= "<td ALIGN=center> ".$rscaso->rowset["idcaso"]." </td>";
	$tabla.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["sremitente"])." </td>";
	$tabla.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["razon_social_solic"])." </td>";
	$tabla.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["razon_social_benef"])." </td>";
	$tabla.= "<td ALIGN=LEFT> ".to_moneda2($rscaso->rowset["ingreso_familiar"])." </td>";				
	$tabla.= "<td ALIGN=LEFT> ".($rscaso->rowset["fecha_registro"])." </td>";
	$tabla.= "<td ALIGN=LEFT> ".($rscaso->rowset["fecha_proceso"])." </td>";
	$tabla.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["sestatus_caso"])." </td>";
	$tabla.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["sanalista"])." </td>";					
	$tabla.="</tr>";
	
	$tabla2.= "<tr $estiloFila>";
	$tabla2.= "<td ALIGN=center> ".$rscaso->rowset["idcaso"]." </td>";
	$tabla2.= "<td ALIGN=LEFT> ".($rscaso->rowset["sremitente"])." </td>";
	$tabla2.= "<td ALIGN=LEFT> ".($rscaso->rowset["razon_social_solic"])." </td>";
	$tabla2.= "<td ALIGN=LEFT> ".($rscaso->rowset["razon_social_benef"])." </td>";
	$tabla2.= "<td ALIGN=LEFT> ".to_moneda2($rscaso->rowset["ingreso_familiar"])." </td>";				
	$tabla2.= "<td ALIGN=LEFT> ".($rscaso->rowset["fecha_registro"])." </td>";
	$tabla2.= "<td ALIGN=LEFT> ".($rscaso->rowset["fecha_proceso"])." </td>";
	$tabla2.= "<td ALIGN=LEFT> ".($rscaso->rowset["sestatus_caso"])." </td>";
	$tabla2.= "<td ALIGN=LEFT> ".($rscaso->rowset["sanalista"])." </td>";					
	$tabla2.="</tr>";
	$ind++;
	$rscaso->Siguiente();
	$estiloFila = ($estiloFila=='') ? 'bgcolor="#EEEEFF"' : '';
}	
$tabla .=	'</TBODY></TABLE>' ;
$tabla2 .=	'</TBODY></TABLE>' ;

if ($modo == 'xls') {				
	header('Content-type: application/vnd.oasis.opendocument.spreadsheet');
	header("Content-Disposition: attachment; filename=consulta_casos.ods");
	header("Pragma: no-cache");
	header("Expires: 0"); 

	echo $tabla ;
	
}
elseif ($modo = 'pdf') {	
	
	$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetAuthor($_SESSION["usuario_actual"]);
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "", "");
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	#$pdf->setLanguageArray($l);
	$pdf->AddPage();
	$pdf->SetFont('helvetica', '', 8);
	$pdf->setY(30);
	$pdf->writeHTML('<span style="text-align:left;"> <b>OFICINA DE ATENCION AL CIUDADANO</b></span>', true, 0, true, true);
	$pdf->writeHTML($tabla2, true, false, false, false, '');
	$pdf->Output("reporte", 'I');
}
	
		


