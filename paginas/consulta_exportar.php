
<?
/*
        header('Content-type: application/vnd.oasis.opendocument.spreadsheet');
        header("Content-Disposition: attachment; filename=consulta_casos.ods");
        header("Pragma: no-cache");
        header("Expires: 0"); 
 */
?>

<?
  
        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=consulta_casos.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
  
        require_once("../librerias/db_postgresql.inc.php");
        ob_end_clean();

    ?>

        <BODY TEXT="#000000">
        <TABLE FRAME=VOID CELLSPACING=0 COLS=9 RULES=NONE BORDER=0>
	<COLGROUP><COL WIDTH=86><COL WIDTH=86></COLGROUP>
	<TBODY>
		<TR>
	
			<TD WIDTH=86 ALIGN=LEFT>N&deg; Caso</TD>
                        <TD WIDTH=300 ALIGN=LEFT>Descripci&oacute;n del Caso</TD>
                        <TD WIDTH=86 ALIGN=LEFT>Fecha de Registro</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Remitente</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Tipo de Caso</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Categor&iacute;a del Caso</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Estatus del Caso</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Estado</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Municipio</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Parroquia</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Instruccion</TD>

                        <TD WIDTH=200 ALIGN=LEFT>Beneficiario</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Edad Beneficiario</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Fecha Nac. Beneficiario</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Lugar Nac. Beneficiario</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Nacionalidad Beneficiario</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Ocupaci&oacute;n Beneficiario</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Estado Civil Beneficiario</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Estado Beneficiario</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Municipio Beneficiario</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Parroquia Beneficiario</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Parentesco Beneficiario</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Grado Instrucci&oacute;n Beneficiario</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Tipo Beneficiario</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Sexo Beneficiario</TD>

                        <TD WIDTH=200 ALIGN=LEFT>Solicitante</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Edad Solicitante</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Fecha Nac. Solicitante</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Lugar Nac. Solicitante</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Nacionalidad Solicitante</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Ocupaci&oacute;n Solicitante</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Estado Civil Solicitante</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Estado Solicitante</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Municipio Solicitante</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Parroquia Solicitante</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Parentesco Solicitante</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Grado Instrucci&oacute;n Solicitante</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Tipo Solicitante</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Sexo Solicitante</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Ingreso Mensual Solicitante</TD>

                        <TD WIDTH=200 ALIGN=LEFT>Total Ingreso</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Tipo de Vivienda</TD>
                        <TD WIDTH=200 ALIGN=LEFT>Tenencia de la Vivienda</TD>
                        
		</TR>

	<?

		$textout='';
		$filtro="";

                //echo $sql;

                $sql="select vc.idcaso, vc.descripcion_caso, vc.fecha_registro, vc.sremitente, vc.stipocaso, vc.scategoria, vc.sestatus_caso, vc.sestado, vc.smunicipio, vc.sparroquia, case when vc.instruccion='1' then 'SI' when vc.instruccion='0' then 'NO' end as sinstruccion,
                vc.razon_social_benef, vc.edad_benef, vc.fecha_nac_benef, vc.lugar_nac_benef, vc.snacionalidad_benef, vc.socupacion_benef, vc.scivil_benef, vc.sestado_benef, vc.smunicipio_benef, vc.sparroquia_benef, vc.sparentesco_benef,
                vc.sgrado_instruccion_benef, vc.ingreso_mensual_benef, vc.stipo_solicitante_benef, case when vc.sexo_benef='M' then 'Masculino' when vc.sexo_benef='F' then 'Femenino' end as ssexo_benef,
                vc.razon_social_solic, vc.edad_solic, vc.fecha_nac_solic, vc.lugar_nac_solic, vc.snacionalidad_solic, vc.socupacion_solic, vc.scivil_solic, vc.sestado_solic, vc.smunicipio_solic, vc.sparroquia_solic, vc.sparentesco_solic,
                vc.sgrado_instruccion_solic, vc.ingreso_mensual_solic, vc.stipo_solicitante_solic, case when vc.sexo_solic='M' then 'Masculino' when vc.sexo_solic='F' then 'Femenino' end as ssexo_solic,
                (select sum(ingreso_mensual) as total_ingreso from nucleo_familiar where idsolicitante=vc.idsolicitante) as total_ingreso,
                vs.stipo_vivienda, vs.stenencia_vivienda from vcasos vc left join vinforme_social vs on vc.idsolicitante=vs.idsolicitante ".$_SESSION["filtro_caso"]." order by idcaso desc";

                //echo $sql;
                
                $dat->Conectar();
                $rscaso=new Recordset($sql, $dat->conn);
                $ind=1;

                
                while ($rscaso->Mostrar())
                {

                    $textout.= "<tr>";
                    $textout.= "<td ALIGN=center> ".$rscaso->rowset["idcaso"]." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["descripcion_caso"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".fecha($rscaso->rowset["fecha_registro"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["sremitente"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["stipocaso"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".trim(utf8_decode($rscaso->rowset["scategoria"]));
                    $textout.= "<td ALIGN=LEFT> ".trim(utf8_decode($rscaso->rowset["sestatus_caso"]));
                    $textout.= "<td ALIGN=LEFT> ".trim(utf8_decode($rscaso->rowset["sestado"]));
                    $textout.= "<td ALIGN=LEFT> ".trim(utf8_decode($rscaso->rowset["smunicipio"]));
                    $textout.= "<td ALIGN=LEFT> ".trim(utf8_decode($rscaso->rowset["sparroquia"]));
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["sinstruccion"])." </td>";

                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["razon_social_benef"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["edad_benef"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".fecha($rscaso->rowset["fecha_nac_benef"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["lugar_nac_benef"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["snacionalidad_benef"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["socupacion_benef"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["scivil_benef"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["sestado_benef"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["smunicipio_benef"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["sparroquia_benef"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["sparentesco_benef"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["sgrado_instruccion_benef"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["stipo_solicitante_benef"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["ssexo_benef"])." </td>";
                    
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["razon_social_solic"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".$rscaso->rowset["edad_solic"]." </td>";
                    $textout.= "<td ALIGN=LEFT> ".fecha($rscaso->rowset["fecha_nac_solic"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["lugar_nac_solic"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["snacionalidad_solic"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["socupacion_solic"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["scivil_solic"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["sestado_solic"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["smunicipio_solic"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["sparroquia_solic"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["sparentesco_solic"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["sgrado_instruccion_solic"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["stipo_solicitante_solic"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".utf8_decode($rscaso->rowset["ssexo_solic"])." </td>";
                    $textout.= "<td ALIGN=LEFT> ".trim(moneda($rscaso->rowset["ingreso_mensual_solic"]));
                                        
                    $textout.= "<td ALIGN=LEFT> ".trim(moneda($rscaso->rowset["total_ingreso"]));
                    $textout.= "<td ALIGN=LEFT> ".trim(utf8_decode($rscaso->rowset["stipo_vivienda"]));
                    $textout.= "<td ALIGN=LEFT> ".trim(utf8_decode($rscaso->rowset["stenencia_vivienda"]));
                    
                    $textout.="</td></tr>";
                    $ind++;
                    $rscaso->Siguiente();

                }//while
              
                echo $textout;

	?>
	</TBODY>

</TABLE>

<!-- ************************************************************************** -->

</BODY>