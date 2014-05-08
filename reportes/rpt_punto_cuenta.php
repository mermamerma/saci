<?php

require_once '../cdatos/ccasos.php';
require_once('../comunes/tcpdf/config/lang/eng.php');
require_once('../comunes/tcpdf/tcpdf.php');
require_once('../librerias/CNumeroaLetra.php');


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
            // Position at 15 mm from bottom7.650,65
            $this->SetY(-25);
            // Set font
            $this->SetFont('times', 'I', 8);
            // Page number
            $this->Cell(0, 10, "SACi - Sistema de Atención al Ciudadano, Generado el ".fechaactual()."  Página ".$this->getAliasNumPage()."/".$this->getAliasNbPages(), 0, 0, 'C');
	}

}//class


$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$ccaso=new ccasos();



$id_pto_cta=$_REQUEST["idcaso"];
$data_informeSocial=$ccaso->getPuntosCuentas($id_pto_cta);
$array_sexo ['M'] = array ('c1' => 'Ciudadano Secretario General Ejecutivo','c2' => 'el', 'c3' => 'al',   'c4' => 'del');
$array_sexo ['F'] = array ('c1' => 'Ciudadana Secretaria General Ejecutiva','c2' => 'la', 'c3' => 'a la', 'c4' => 'de la' );

#echo var_dump($data_informeSocial);exit;
if ($data_informeSocial == FALSE) {
	mensaje('No se ha guardado aún el Punto de Cuenta');exit;
}
else {

	$fecha_creacion		= $data_informeSocial->rowset["fechacreacion"];
	$sexo				= $data_informeSocial->rowset["sexo"];
	$id_pto_cta			= $data_informeSocial->rowset["id_pto_cta"];
	$asunto				= $data_informeSocial->rowset["asunto"];
	$argumentacion		= $data_informeSocial->rowset["argumentacion"];
	$nombre_secretario	= $data_informeSocial->rowset["nombre_secretario"];
	$cargo_secretario	= $data_informeSocial->rowset["cargo_secretario"];
	$num_resolucion		= $data_informeSocial->rowset["num_resolucion"];
	$fecha_resolucion	= $data_informeSocial->rowset["fecha_resolucion"];
	$num_gaceta			= $data_informeSocial->rowset["num_gaceta"];
	$fecha_gaceta		= $data_informeSocial->rowset["fecha_gaceta"];
	$rif				= $data_informeSocial->rowset["rif"];
	$concepto			= $data_informeSocial->rowset["concepto"];
	$nombre_dir_ac		= $data_informeSocial->rowset["nombre_dir_ac"];
	$cargo_dir_ac		= $data_informeSocial->rowset["cargo_dir_ac"];
	$elab_pto_cta		= $data_informeSocial->rowset["elab_pto_cta"];
	$firma				= $data_informeSocial->rowset["firma"];
	$monto				= $data_informeSocial->rowset["monto"];
	// Procesar el Monto en letras
	$numero				= new CNumeroaLetra();
	$pos				= stripos($monto, '.');
	$centimos			= substr($monto,$pos+1) ;			
	$numero->setNumero($monto);
	$monto_letra		= $numero->letra().$centimos.'/100';
	$monto_numero		= to_moneda($monto) ;
	//s
	$razon_social		= $data_informeSocial->rowset["razon_social"];
	$observaciones		= $data_informeSocial->rowset["observaciones"];
	$descripcion		= $data_informeSocial->rowset["descripcion"] ;

	$todos_anexos  = '' ;
	$carta_solicitud	= ($data_informeSocial->rowset["carta_solicitud"]=="t")	? 'Carta de solicitud, ' : ''   ;
	$informe_social		= ($data_informeSocial->rowset["informe_social"]=="t")	? 'Informe Social, ' : ''   ;
	$informe_medico		= ($data_informeSocial->rowset["informe_medico"]=="t")	? 'Informe Médico, ' : ''   ;		
	$presupuesto		= ($data_informeSocial->rowset["presupuesto"]=="t")		? 'Presupuesto, ' : ''   ;
	$copia_ci			= ($data_informeSocial->rowset["copia_ci"]=="t")		? 'Copia de la Cédula de Identidad, ' : ''   ;
	$todos_anexos .= $carta_solicitud.$informe_social.$informe_medico.$presupuesto.$copia_ci ;
	$len = strlen($todos_anexos);
	$todos_anexos = (substr($todos_anexos, 0, $len - 2)) ;
	#$todos_anexos 
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

	$pdf->SetFont('helvetica', '', 8);
	$pdf->setY(30);
	$pdf->writeHTML('<span style="text-align:left;"> <b>OFICINA DE ATENCION AL CIUDADANO</b></span>', true, 0, true, true);
	$pdf->SetFont('helvetica', '', 12);
	$pdf->setY(40);
	$pdf->writeHTML('<span style="text-align:center;"> <b>PUNTO DE CUENTA PARA '.strtoupper($array_sexo[$sexo]['c2']).' '.strtoupper($array_sexo[$sexo]['c1']).'</b></span>', true, 0, true, true);


	$pdf->setY(50);
	$pdf->SetFont('helvetica', '', 11);

$tb1 = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
         <td style="text-align:left;"><b>PRESENTANTE:</b></td>
		 <td style="text-align:left;"><b>OFICINA DE ATENCIÓN AL CIUDADANO</b></td>
    </tr>
</table>
EOD;

	$pdf->writeHTML($tb1, true, false, false, false, '');


	$pdf->setY(60);
	$txt = "Nro: $id_pto_cta" ;
	$txt1 = "Fecha: $fecha_creacion";
	// Multicell test
	$pdf->MultiCell(55, 5, ''.$txt, 1, 'L', 0, 0, '', '', true);
	$pdf->MultiCell(40, 5, '', 0, 'C', 0, 0, '', '', true);
	$pdf->MultiCell(65, 5, ''.$txt1, 1, 'L', 0, 1, '', '', true);


	$pdf->setY(70);
	$pdf->SetFont('helvetica', '', 11);
$tb4 = <<<EOD

<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        
		 <td style="text-align:left;"><b>1) Asunto:</b>  $asunto</td>
    </tr>
</table>
EOD;

	$pdf->writeHTML($tb4, true, false, false, false, '');

	$pdf->setY(50);
	$mensaje1 = '<span style="text-align:left;">2)&nbsp;<b>Argumentación:  </b>'.$argumentacion;
	$mensaje2 = '<span style="text-align:justify;">3)&nbsp;<b>Anexos: </b> '.$todos_anexos.'</span>';
	$mensaje3 = '<span style="text-align:justify;">4)&nbsp;<b>Soluciones Propuestas '.$array_sexo[$sexo]['c3'].' '.$array_sexo[$sexo]['c1'].':</b> 
				 Se somete a la consideración '.$array_sexo[$sexo]['c4'].' '.$array_sexo[$sexo]['c1'].' del Ministerio del Poder Popular para Relaciones Exteriores, 
				 según Resolucion N° '.$num_resolucion.' del '.$fecha_resolucion.', publicada en Gaceta Oficial de la República Bolivariana de Venezuela N° '.$num_gaceta.', 
				de fecha '.$fecha_gaceta.', autorizar la cantidad de <b> '.$monto_letra.' (Bs. '.$monto_numero.'),</b> a favor de <b>'.$razon_social.', RIF.: '.$rif.',</b>  '.$concepto.'  </span>';
	$mensaje4 = '<span style="text-align:left;"><b>Decisión:</b></span>';
	//para imprimir los parametros de los mensajes
	$pdf->SetFont('helvetica', '', 11);
	$pdf->writeHTML('<br/><br/><br/><br/><br/><br/><br/><br/><br/>'.$mensaje1, true, 0, true, true);
	$pdf->writeHTML('<br/><br/>'.$mensaje2, true, 0, true, true);
	$pdf->writeHTML('<br/><br/>'.$mensaje3, true, 0, true, true);
	$pdf->writeHTML('<br/><br/>'.$mensaje4, true, 0, true, true);

	/*--------------------------------------------------------------------------------------------------------------------------------------------*/

	$pdf->setY(159);
	if ($data_informeSocial->rowset["id_decision"] == -1) {
		$color	= '#FFFFFF';
		$chk	= K_PATH_IMAGES."check_vacio_decision.png";
		$font	= 'medium';
		$decision = "
			<table>
			<tr align=\"center\">
			<td><img style='margin-top:20px;' src=\"".$chk."\"></td>
			<td><img style='margin-top:20px;' src=\"".$chk."\"></td>
			<td><img style='margin-top:20px;' src=\"".$chk."\"></td>
			<td><img style='margin-top:20px;' src=\"".$chk."\"></td>
			</tr>
			<tr>
			<td>APROBADO</td>
			<td>NEGADO</td>
			<td>VISTO</td>
			<td>DIFERIDO</td>
			</tr>
			</table>";
	}
	else {
		$color	= '#999999';		
		$font	= 'xx-large';
		$decision = $descripcion ;
	}
$tb5 = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
<tr>
	 <td style="text-align:center;">DECISIÓN E INSTRUCCIONES</td>
</tr>
<tr>
	 <td style="text-align:center; color: #000000;	font-weight: bold;	background-color:$color ;font-size:$font;">$decision</td>
</tr>

<tr>
	<td style="text-align:center;">
	<b>$nombre_secretario<br />$cargo_secretario<br /></b>MINISTERIO DEL PODER POPULAR PARA RELACIONES EXTERIORES<br />
	<span style="font-size: 24px">Según Resolución N° $num_resolucion de $fecha_resolucion<br />Publicada en Gaceta Oficial de la República Bolivariana de Venezuela N° $num_gaceta, de fecha $fecha_gaceta</span> 
	</td>
</tr>


</table>
EOD;

	$pdf->writeHTML($tb5, true, false, false, false, '');

	/*--------------------------------------------------------------------------------------------------------------------------------------------*/

	$pdf->startPageGroup();
	$pdf->AddPage();
	$pdf->Image(K_PATH_IMAGES.'cabecero_reporte.png', 20, 8, 170, 20);
	$pdf->SetFont('helvetica','', 8);
	$pdf->setY(30);
	$pdf->writeHTML('<span style="text-align:left;"> <b>OFICINA DE ATENCIÓN AL CIUDADANO</b></span>', true, 0, true, true);
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->setY(40);
	$pdf->writeHTML('<span style="text-align:center;"> <b>HOJA DE TRAMITACIÓN</b></span>', true, 0, true, true);

	$pdf->Ln(8);
	// Vertical alignment
	$pdf->MultiCell(50, 40,'ASUNTO:', 1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');
	$pdf->MultiCell(130, 40, $argumentacion,1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');

	$pdf->setY(93);
	$pdf->MultiCell(50, 40, 'ORDENADO POR: ', 1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');
	$pdf->MultiCell(130, 40, $nombre_secretario." \n ".$cargo_secretario,1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');

	$pdf->setY(133);
	$pdf->MultiCell(50, 40, 'REVISADO POR: ', 1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');
	$pdf->MultiCell(130, 40, $nombre_dir_ac." \n ".$cargo_dir_ac,1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');

	$pdf->setY(173);
	$pdf->MultiCell(50, 40, 'ELABORADO POR: ', 1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');
	$pdf->MultiCell(130, 40, $elab_pto_cta,1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');

	$pdf->setY(213);
	$pdf->MultiCell(50, 40, 'FECHA DE ELABORACIÓN: ', 1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');
	$pdf->MultiCell(130, 40, $fecha_creacion, 1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');

	/*--------------------------------------------------------------------------------------------------------------------------------------------*/

	$pdf->startPageGroup();
	$pdf->AddPage();
	$pdf->Image(K_PATH_IMAGES.'cabecero_reporte.png', 20, 8, 170, 20);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->setY(30);
	$pdf->writeHTML('<span style="text-align:left;"> <b>OFICINA DE ATENCION AL CIUDADANO</b></span>', true, 0, true, true);
	$pdf->setY(40);
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->MultiCell(50, 40, 'TIPO  DE  DOCUMENTO ', 1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');
	$tipo_doc = strtoupper($array_sexo[$sexo]['c3'].' '.$array_sexo[$sexo]['c1']);
	$pdf->MultiCell(130, 40, "PUNTO DE CUENTA $tipo_doc", 1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');
	$pdf->setY(80);
	$pdf->MultiCell(50, 40, 'ASUNTO ', 1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');
	$pdf->MultiCell(130, 40,$argumentacion, 1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');
	$pdf->setY(120);
	$pdf->MultiCell(50, 40, 'PROCEDENCIA ', 1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');
	$pdf->MultiCell(130, 40, 'Oficina de Atencion al Ciudadano', 1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');
	$pdf->setY(160);
	$pdf->MultiCell(50, 40, 'FECHA ', 1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');
	$pdf->MultiCell(130, 40, $fecha_creacion, 1, 'C',0, 0, '', '', true, 0, false, true, 40, 'M');

	$pdf->Output("rpt_comite", 'I');
}
?>
