<?php

require_once '../cdatos/ccasos.php';
require_once '../cdatos/csolicitantes.php';
require_once('../comunes/tcpdf/config/lang/eng.php');
require_once('../comunes/tcpdf/tcpdf.php');
require_once '../paginas/aplicaciones.php';


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


        public function  Footer()
        {
            // Position at 15 mm from bottom
            $this->SetY(-15);
            // Set font
            $this->SetFont('times', 'I', 8);
            // Page number
            //$this->Cell(0, 10, 'Pag. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            $this->Cell(0, 10, "SACi - Sistema de Atención al Ciudadano, Generado el ".fechaactual().". Por ".$this->author.".   Página ".$this->getAliasNumPage()."/".$this->getAliasNbPages(), 0, 0, 'C');

        }
}//class


$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$ccaso=new ccasos();
$csolic=new csolicitantes();

$idcaso=$_REQUEST["idcaso"];

$total_ingreso="0";
$data_caso=new Recordset();
$data_caso=$ccaso->getDataCasoActual($idcaso);
//print_r($data_caso);

if ($data_caso)
{
    $csolic->set_idsolicitante($data_caso->rowset["idsolicitante"]);
    $data_solic=$csolic->getDataSolicitante();    
}

if ($data_solic)
{
    $idsolicitante=$data_caso->rowset["idsolicitante"];
    $csolic->set_idsolicitante($data_caso->rowset["idsolicitante"]);
    $data_informe=$csolic->getData_Informe_Social_nuevo();
    $razon_social=$data_solic->rowset["razon_social"];
    $rif=$data_solic->rowset["rif"];
    $cedula=$data_solic->rowset["cedula"];
    
    if ($cedula=="")  $sidentidad=$rif;
    else    $sidentidad=$cedula;

    if ($data_solic->rowset["sexo"]=="M")   $sexo="Masculino";
    else if ($data_solic->rowset["sexo"]=="F")   $sexo="Femenino";
    else    $sexo="";
    
    if ($data_solic->rowset["fecha_nac"])   $fecha_nac=fecha($data_solic->rowset["fecha_nac"]);
    else 
		$fecha_nac = '';
	##var_dump($data_solic->rowset["fecha_nac"]);exit ;
    $lugar_nac=$data_solic->rowset["lugar_nac"];
    $edad=$data_solic->rowset["edad"];
    $nacionalidad=$data_solic->rowset["snacionalidad"];
    $ocupacion=$data_solic->rowset["socupacion"];
    $civil=$data_solic->rowset["scivil"];
    $direccion=$data_solic->rowset["direccion"];
    $telefonos=$data_solic->rowset["telefonos"];
    $estado=$data_solic->rowset["sestado"];
    $municipio=$data_solic->rowset["smunicipio"];
    $parroquia=$data_solic->rowset["sparroquia"];
    $comunidad=$data_solic->rowset["comunidad"];
    
}

if ($data_informe)
{
    $idinforme=$data_informe->rowset["idinforme"];
    $misiones=$data_informe->rowset["misiones"];
    $tipo_vivienda=$data_informe->rowset["stipo_vivienda"];
    $tenencia_vivienda=$data_informe->rowset["stenencia_vivienda"];
    $servicios_publicos=$data_informe->rowset["servicios_publicos"];
    $area_fisico=$data_informe->rowset["area_fisico"];
    $area_economica=$data_informe->rowset["area_economica"];
    $condiciones_salud=$data_informe->rowset["condiciones_salud"];
    $observacion=$data_informe->rowset["observacion"];
    $usuario_creador=$data_informe->rowset["susuario"];

}

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
<b>INFORME SOCIAL N° ".$idinforme." </b><br><br>
</td>
</tr>
</table>";

$tabla.="<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">

<tr style=\"background-color: #c0c0c0\">
<td align=\"left\" colspan=\"3\"><b>1.- DATOS DEL SOLICITANTE:</b></td>
</tr>
<tr>
<td><b>Nombres y Apellidos:</b><br>".$razon_social."</td>
<td><b>Cédula / R.I.F.:</b><br>".$sidentidad."</td>
<td><b>Sexo:</b><br>".strtoupper($sexo)."</td>
</tr>

<tr>
<td><b>Lugar de Nacimiento:</b><br>".$lugar_nac."</td>
<td><b>Fecha de Nacimiento:</b><br>".$fecha_nac."</td>
<td><b>Edad:</b><br>".$edad."</td>
</tr>

<tr>
<td><b>Nacionalidad:</b><br>".strtoupper($nacionalidad)."</td>
<td><b>Ocupación:</b><br>".strtoupper($ocupacion)."</td>
<td><b>Estado Civil:</b><br>".strtoupper($civil)."</td>
</tr>

<tr>
<td colspan=\"2\"><b>Teléfono(s):</b><br>".$telefonos."</td>
<td><b>Comunidad:</b><br>".$comunidad."</td>
</tr>

<tr>
<td colspan=\"3\"><b>Dirección:</b><br>".$direccion."</td>
</tr>

<tr>
<td><b>Estado:</b><br>".strtoupper($estado)."</td>
<td><b>Municipio:</b><br>".strtoupper($municipio)."</td>
<td><b>Parroquia:</b><br>".strtoupper($parroquia)."</td>
</tr>

</table>
<br>

<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
<tr style=\"background-color: #c0c0c0\">
<td align=\"left\" colspan=\"3\"><b>2.- EDUCACIÓN:</b></td>
</tr></table><br>";

$ccaso->Conectar();
$rs_misiones=new Recordset("select idmaestro, descripcion from vmisiones where estatus=1", $ccaso->conn);
$rs_misiones_selec=new Recordset("select misiones from informe_social_actuales where idsolicitante=".$idsolicitante, $ccaso->conn);

if ($rs_misiones_selec->Mostrar())
{
    $data_mision=explode(",", $rs_misiones_selec->rowset["misiones"]);
}

$tabla.="<table width=\"50%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
<tr><td colspan=\"2\" align=\"center\"><b>Misiones</b></td></tr>";

    while($rs_misiones->Mostrar())
    {

        $chk=K_PATH_IMAGES."check_no.png";

        if ($data_mision)
        {
            
            foreach ($data_mision as $valor)
            {                
                if ($rs_misiones->rowset["idmaestro"]==$valor)
                {
                    $chk=K_PATH_IMAGES."check_si.png";
                }                
            }
        }

        $tabla.="<tr>
                <td><b>".$rs_misiones->rowset["descripcion"]."</b></td>
                <td align=\"center\"><img style='margin-top:20px;' src=\"".$chk."\"></td>
                </tr>
                ";
        $rs_misiones->Siguiente();
    }

$tabla.="</table><br>

<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
<tr style=\"background-color: #c0c0c0\">
<td align=\"left\" colspan=\"3\"><b>3.- CARACTERISTICAS DE LA VIVIENDA:</b></td>
</tr>
<tr>
<td colspan=\"2\"><b>Tipo de Vivienda donde habita actualmente:</b><br>".strtoupper($tipo_vivienda)."</td>
<td><b>Tenencia de la Vivienda:</b><br>".strtoupper($tenencia_vivienda)."</td>
</tr>
</table>

<br>

<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
<tr style=\"background-color: #c0c0c0\">
<td align=\"left\" colspan=\"3\"><b>ÁREA FÍSICO - AMBIENTAL:</b></td>
</tr>
<tr>
<td colspan=\"3\"><span style=\"text-align:justify;\">".$area_fisico."</span></td>
</tr>
</table>
<br>

";
#die ($tabla);
$pdf->Ln(10);
$pdf->writeHTML($tabla, true, false, true, false, '');

#$pdf->AddPage('P', PDF_PAGE_FORMAT);


$ccaso->Conectar();

$rs_servicios_selec=new Recordset("select servicios_publicos from informe_social_actuales where idsolicitante=".$idsolicitante, $ccaso->conn);
$rs_servicios=new Recordset("select idmaestro, descripcion from vservicios_publicos where estatus=1", $ccaso->conn);

if ($rs_servicios_selec->Mostrar())
{
    $data_mision=explode(",", $rs_servicios_selec->rowset["servicios_publicos"]);
}

$tabla="<table width=\"50%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
<tr><td colspan=\"2\" align=\"center\"><b>Servicios Públicos Disponibles</b></td></tr>";

while($rs_servicios->Mostrar())
{

    $chk=K_PATH_IMAGES."check_no.png";

    if ($data_mision)
    {
        foreach ($data_mision as $valor)
        {
            if ($rs_servicios->rowset["idmaestro"]==$valor)
            {
                $chk=K_PATH_IMAGES."check_si.png";
            }
        }
    }

    $tabla.="<tr>
            <td><b>".$rs_servicios->rowset["descripcion"]."</b></td>
            <td align=\"center\"><img style='margin-top:20px;' src=\"".$chk."\"></td>
            </tr>
            ";

    $rs_servicios->Siguiente();
}



$tabla.="</table><br>

<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
<tr style=\"background-color: #c0c0c0\">
<td align=\"left\" colspan=\"3\"><b>4.- PERFIL SOCIOECONOMICO DEL NÚCLEO FAMILIAR:</b></td>
</tr>
</table>

<br>";


$tabla.="<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
<tr  style=\"font-size:30px\; background-color:#E9E9E9 \">
<td align=\"center\"><b>Nombre y Apellido</b></td>
<td align=\"center\" ><b>C.I.</b></td>
<td align=\"center\"  ><b>Edad</b></td>
<td align=\"center\"  ><b>Nacimiento</b></td>
<td align=\"center\" ><b>Parentesco</b></td>
<td align=\"center\" ><b>Grado de Instrucción</b></td>
<td align=\"center\" ><b>Ocupación</b></td>
<td align=\"center\" ><b>Ingreso Mensual (Bs.f.)</b></td>
</tr>

";


$ccaso->Conectar();

$strSql="SELECT razon_social, cedula, edad, TO_CHAR(fecha_nac, 'DD-MM-YYYY') as f_nacimiento, idparentesco, ( SELECT maestro.descripcion FROM maestro WHERE maestro.idmaestro = idparentesco) AS sparentesco, 
idgrado_instruccion, ( SELECT maestro.descripcion FROM maestro WHERE maestro.idmaestro = idgrado_instruccion) AS sgrado,
 idocupacion, sexo, 
 CASE WHEN sexo::text = 'F'::text THEN 'FEMENINO'::text WHEN sexo::text = 'M'::text THEN 'MASCULINO'::text ELSE NULL::text END AS ssexo, 
 ( SELECT maestro.descripcion FROM maestro WHERE maestro.idmaestro = idocupacion) AS socupacion, ingreso_mensual 
 FROM solicitantes_actuales where idsolicitante=".$idsolicitante."
 union 
 SELECT razon_social, cedula, edad, TO_CHAR(f_nacimiento, 'DD-MM-YYYY') as f_nacimiento, idparentesco, ( SELECT maestro.descripcion FROM maestro WHERE maestro.idmaestro = idparentesco) AS sparentesco, 
 idgrado_instruccion, ( SELECT maestro.descripcion FROM maestro WHERE maestro.idmaestro = idgrado_instruccion) AS sgrado, idocupacion, sexo, 
 CASE WHEN sexo::text = 'F'::text THEN 'FEMENINO'::text WHEN sexo::text = 'M'::text THEN 'MASCULINO'::text ELSE NULL::text END AS ssexo, 
 ( SELECT maestro.descripcion FROM maestro WHERE maestro.idmaestro = idocupacion) AS socupacion, ingreso_mensual 
 FROM nucleo_familiar_nuevos where idsolicitante=".$idsolicitante." order by edad";
#die($strSql);
$rs_perfil=new Recordset($strSql, $ccaso->conn);
$x = $rs_perfil->Mostrar();
#var_dump($x); exit;
$total_ingreso=0;
#var_dump($rs_perfil->rowset["razon_social"]) ; exit ;
while($rs_perfil->Mostrar())
{
    $tabla.="<tr style=\"font-size:27px\">
                <td align=\"center\" style=\"font-size:22px\">".to_mayuscula($rs_perfil->rowset["razon_social"])."</td>
                <td align=\"center\" >".$rs_perfil->rowset["cedula"]."</td>
                <td align=\"center\" ><b>".$rs_perfil->rowset["edad"]."</b></td>
				<td align=\"center\" ><b>".$rs_perfil->rowset["f_nacimiento"]."</b></td>
                <td align=\"center\" ><b>".ucwords(strtolower($rs_perfil->rowset["sparentesco"]))."</b></td>
                <td align=\"left\" >".ucwords(strtolower($rs_perfil->rowset["sgrado"]))."</td>
                <td align=\"left\" >".ucwords(strtolower($rs_perfil->rowset["socupacion"]))."</td>
                <td align=\"right\" >".to_moneda($rs_perfil->rowset["ingreso_mensual"])."</td>
            </tr>";
    
    if ($rs_perfil->rowset["ingreso_mensual"]>0)  $total_ingreso=sumar($total_ingreso, $rs_perfil->rowset["ingreso_mensual"] );
    $rs_perfil->Siguiente();
    
}//while


$tabla.="<tr>
<td align=\"right\" colspan=\"7\"><b>Total de Ingreso:</b></td>
<td align=\"right\"><b>".to_moneda($total_ingreso)."</b></td>
</tr>
</table>
<br>

<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
<tr style=\"background-color: #c0c0c0\">
<td align=\"left\" colspan=\"3\"><b>ÁREA SOCIO-ECONÓMICA:</b></td>
</tr>
<tr>
<td colspan=\"3\"><span style=\"text-align:justify;\">".$area_economica."</span></td>
</tr>
</table>
<br>


<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
<tr style=\"background-color: #c0c0c0\">
<td align=\"left\" colspan=\"3\"><b>CONDICIONES DE SALUD:</b></td>
</tr>
<tr>
<td colspan=\"3\"><span style=\"text-align:justify;\">".$condiciones_salud."</span></td>
</tr>
</table>
<br>


<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
<tr style=\"background-color: #c0c0c0\">
<td align=\"left\" colspan=\"3\"><b>OBSERVACIÓN:</b></td>
</tr>
<tr>
<td colspan=\"3\"><span style=\"text-align:justify;\">".$observacion."</span></td>
</tr>
</table>
<br>

<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
<tr style=\"background-color: #c0c0c0\">
<td align=\"left\"><b>ELABORADO POR:</b></td>
<td align=\"left\"><b>FECHA:</b></td>
</tr>
<tr>
<td align=\"center\"><b>".strtoupper($usuario_creador)."</b></td>
<td align=\"center\"><b>".fechaactual()."</b></td>
</tr>
</table>
<br>

";

$pdf->Ln(10);
$pdf->writeHTML($tabla, true, false, true, false, '');

$numero_rpt = rand(50,10000);
$pdf->Output("rpt_social".$numero_rpt, 'I');

?>
