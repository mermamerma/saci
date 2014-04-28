<?php

require_once '../cdatos/ccasos.php';
require_once('../comunes/tcpdf/config/lang/eng.php');
require_once('../comunes/tcpdf/tcpdf.php');


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
<td align=\"left\" width=\"30%\"><b>N° ".$num_caso."</b></td>
</tr>

<tr>
<td align=\"left\" width=\"20%\"><b>ASUNTO: </b></td>
<td align=\"left\" width=\"80%\" colspan=\"2\">".$ssolic."  ".$sidentidad.", ".$sestado."</td>
</tr>

<tr>
<td align=\"left\" width=\"20%\"><b>DE:</b></td>
<td align=\"left\" width=\"50%\">COMITÉ DE ANÁLISIS DE CASOS</td>

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

<tr style=\"background-color: #c0c0c0\">
<td align=\"CENTER\" width=\"25%;\"><b>ANEXOS</b></td>
<td align=\"CENTER\" width=\"75%;\"><b>CÓDIGO PRESUPUESTARIO</b></td>
</tr>
<tr>
	<td><span style=\"text-align:justify;\">".$anexos."</span></td>
	<td>
		<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"\">
			<tr>
				<td> PROYECTO </td>
				<td> ACCIÓN CENTRALIZADA</td>
				<td> ACCIÓN ESPECÍFICA</td>
				<td> PARTIDA </td>
				<td> GENÉRICA </td>
				<td> ESPECÍFICA </td>
				<td> SUB-ESPECÍFICA</td>			
			</tr>
		
		</table>
	</td>
</tr>

</table>

<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
<tr style=\"background-color: #c0c0c0\">
<td align=\"left\" colspan=\"3\"><b>DECISIÓN DEL COMITÉ: </b></td>
</tr>
<tr>
<td align=\"center\" height=\"30px;\" valign=\"bottom\"><br>( ".$saprobado." )<br>Aprobado</td>
<td align=\"center\" height=\"30px;\" valign=\"bottom\"><br>( ".$snegado." )<br>Negado</td>
<td align=\"center\" height=\"30px;\" valign=\"bottom\"><br>( ".$sdiferido." )<br>Diferido</td>
</tr>

<tr style=\"background-color: #c0c0c0\">
<td align=\"left\" colspan=\"3\"><b>OBSERVACIONES DEL COMITÉ: </b></td>
</tr>

<tr><td colspan=\"3\"><span style=\"text-align:justify;\">".$observacion_comite."</span></td></tr>

<tr style=\"background-color: #c0c0c0\"><td align=\"left\" colspan=\"3\"><b>PREPARADO POR EL COMITÉ DE CASOS: </b></td>
</tr>
<tr>
<td align=\"center\" height=\"40px;\" valign=\"bottom\"><br><br><br><br>$smiembro1</td>
<td align=\"center\" height=\"40px;\" valign=\"bottom\"><br><br><br><br>$smiembro2</td>
<td align=\"center\" height=\"40px;\" valign=\"bottom\"><br><br><br><br>$smiembro3</td>
</tr>
</table>

";



?>