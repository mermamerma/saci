<?
	require_once("../librerias/db_postgresql.inc.php");
	require_once ('../cdatos/cpuntos.php');
	require_once('aplicaciones.php');

	validar_sesion();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="pragma" content="no-cache">
        <link rel="shortcut icon" href="../comunes/imagenes/favicon.ico" type="image/x-icon" >
        <script src="../comunes/js/funciones.js" type="text/javascript"></script>
  		<script type="text/javascript" src="../comunes/js/jquery-1.4.2.min.js"></script>		

        <style>
            body {padding:0px;margin:0px;text-align:left;font:11px verdana, arial, helvetica, serif; background-color:#FFFFFF;}

        </style>
        <script language="javascript">          
			function test () {
				
			}
            function ValidarObjetos(objX,tipoX)
            {

                var obj = document.getElementById(objX);
                var filter=/^[A-Za-z][A-Za-z0-9_.]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/;
                var filter2=/^[A-Z]*-[0-9]/;
                var filter3=/^([0-9\s\+\-])+$/;
                var filter4=/^([0-9])+$/;

                switch (tipoX) {
                        case 'combo':
                                obj.style.border = "1px solid #7f9db9";
                        break;

                        case 'email':
                            if (obj.value!='')
                            {
                                if (filter.test(obj.value))
                                {
                                    obj.style.border = "1px solid #7f9db9";
                                    return true;
                                }else
                                {
                                    alert("Ingrese una dirección de correo válida");
                                    obj.style.border = "1px solid #FF0000";
                                    return false;
                                }
                            }
                            else
                            {
                                 obj.style.border = "1px solid #7f9db9";
                                 return true;
                            }

                            break;

                        case 'cedrif':

                                if (filter4.test(obj.value))
                                {
                                    obj.style.border = "1px solid #7f9db9";
                                    return true;
                                }else
                                {
                                    alert("Ingrese una cédula o RIF válido");
                                    obj.style.border = "1px solid #FF0000";
                                    return false;
                                }

                                break;

                        case 'telefono':

                            if (filter3.test(obj.value))
                            {
                                    obj.style.border = "1px solid #7f9db9";
                                    return true;
                            }else{
                                    alert("Ingrese un número de teléfono válido");
                                    obj.style.border = "1px solid #FF0000";
                                    return false;
                            }
                            break;


                        case 'int4':
                                if (isNaN(parseInt(obj.value))){
                                        alert('Ingrese solo números enteros');
                                        obj.style.border = "1px solid #FF0000";return;
                                }else{
                                        obj.style.border = "1px solid #7f9db9";
                                }
                        break;

                        case 'date':
                                if (!isDate(obj.value)){
                                        obj.style.border = "1px solid #FF0000";return;
                                }else{
                                        obj.style.border = "1px solid #7f9db9";return;
                                }
                        break;

                        case 'time':
                            break;

                        case 'numerico':
                                if (isNaN(parseFloat(obj.value))){
                                        alert('Ingrese solo números');
                                        obj.style.border = "1px solid #FF0000";return;
                                }else{
                                        obj.style.border = "1px solid #7f9db9";return;
                                }
                        break;

                        case 'bool':
                                if ((obj.value!='Si') && (obj.value!='No')){
                                        alert('Ingrese solo Si o No');
                                        obj.style.border = "1px solid #FF0000";return;
                                }else{
                                        obj.style.border = "1px solid #7f9db9";return;
                                }
                        break;

                        default:
                        break;
                }
            }
           

            function ocultar(id, msj)
            {
                  var log = $(id);
                log.innerHTML= msj;
                log.style.backgroundColor= '#fff36f';
                log.style.padding= '5px';
                new Effect.Fade(id, {from: 1, to: 0, duration: 2.0});
                new Effect.SlideUp(id, {queue: 'parallel', duration: 2.0});
            }

            function guardar()
            {
                //if (!validaSelect(document.frminforme.id_decision,'Decisión'))return false;
                if (!campoRequerido(document.frminforme.asunto,"Asunto")) return false;
                if (!campoRequerido(document.frminforme.argumentacion,"Argumentación")) return false;
                
				
				$.ajax({
					url:'<?=BASE_URL?>paginas/procesar_pto_cta.php',
					type:'post',
					data:$('#frminforme').serialize(),
					success:function(data){
					//$('#activityanimation').hide();
					$('#resultado-ajax').show();
					$('#resultado-ajax').html(data);					
			}
		});
				
                //alert('Proceso el Pto. de Cta.');
				//window.document.getElementById('accion').value='guardar';
				//document.frminforme.submit();

            }

            function enviar(idinforme, nsocial)
            {

                var resp
                resp=confirm('¿ Esta Seguro que Desea Enviar el Informe al Gerente ?');

                if ((resp)&& (idinforme>0))
                {
                    if ((nsocial<=0) && (document.frminforme.tipo_solicitante.value==103))
                    {
                        alert('No es Posible Enviar el Informe al Gerente Debido a que No Existe un Informe Social Asociado al Caso');
                    }
                    else
                    {
                        if (!campoRequerido(document.frminforme.analisis,"Análisis")) return false;
                        if (!campoRequerido(document.frminforme.sugerencias,"Sugerencias")) return false;

                        window.document.getElementById('accion').value='enviar';
                        document.frminforme.submit();
                    }                    
                }
                else
                {
                    alert('No es Posible Enviar el Informe al Gerente Debido a que No Existe un Informe de Comite Asociado al Caso');
                }         
            }

            function cerrar()
            {
                window.open('lst_casos_comite_nuevos.php','contenido')
            }

            function imprimir(idcaso)
            {
                id_pto_cta = $('#id_pto_cta').val();
				if (id_pto_cta == '')
					alert('¡Debe Gurdar el Punto de Cuenta Primero Antes de Imprimirlo..!') ;
				else
					window.open('../reportes/rpt_punto_cuenta.php?idcaso='+idcaso,'_blank')
            }
			
			function desbloquear()
            {
                var id=document.getElementById('descripcion_caso');
				if (id.readOnly == true)
				{
					id.readOnly=false;
				}
				else
				{
					id.readOnly=true;
				}				
            }

        </script>
    </head>


    <link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />

    <body>
        <script src="../comunes/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>
        <center>    
			<div id="resultado-ajax"></div>
            <form name="frminforme" id="frminforme" method="post" action="#">            
            <input type="hidden" id="id_pto_cta" name="id_pto_cta" value="">
			<input type="hidden" id="id_caso" name="id_caso" value="<?= $_GET['id_caso']?>">                
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="65%" class="menu_izq_titulo">
							<img src="../comunes/imagenes/logo_form.gif" />
							Punto de Cuenta <br />
							Caso N° <?= $_GET['id_caso']?> / <span id="desc_pto_cta"></span>
						</td>
                        <td width="20%" align="center" class="menu_izq_titulo">
						<img src="../comunes/imagenes/16_save.gif" onmouseover="Tip('Guardar')" onmouseout="UnTip()" border="0" onclick="javascript:guardar()"/>
						<img src="../comunes/imagenes/printer.png" onmouseover="Tip('Imprimir Punto de Cuenta')" onmouseout="UnTip()" border="0" onclick="javascript:imprimir('<?=$_REQUEST["id_caso"]?>')"/>
						<img src="../comunes/imagenes/door_in.png" onmouseover="Tip('Cerrar')" onmouseout="UnTip()" border="0" onclick="javascript:cerrar('<?=$_REQUEST["id_caso"]?>')"/>
						</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="capaMensajes"></div>
                        </td>
                    </tr>
					<tr>
                      <td colspan="2">

                            <table width="100%" border="0"  class="tablaTitulo" >

                                <tr>
                                <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
                                        <strong>Datos Generales del Punto de Cuenta </strong>                                    </div>                                </td>
                            </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td><strong>Asunto:</strong> <span class="requerido">*</span></td>
                                <td>
									<textarea name="asunto" id="asunto" rows="5" class="inputbox" onkeypress="return validar_texto(this.form,this,event,'')"  style="width:466px; height:95px; margin-bottom:10px;" ></textarea>
									  
								</td>
                            </tr>
                            
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>Argumentación:</strong> <span class="requerido">*</span> </td>
                                <td colspan="3">
                                    <input name="argumentacion" type="text" class="inputbox" id="argumentacion" style="width:464px;">                                </td>
                            </tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td><strong>Decisión:</strong></td>
                              <td><select name="id_decision" id="id_decision" style="width:160px;" class="inputbox">
                                <option value="-1" selected="selected">Sin Decisión...</option>
                                <?php
								echo ($dat->Cargarlista("select idmaestro, descripcion from maestro where estatus=1 AND idpadre=333 order by descripcion",''));
								?>
                              </select></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td><strong>Anexos: </strong></td>
                              <td>
								<table width="465px" border="1" class="tablaTitulo">
								<tbody><tr bgcolor="#f8f8f8" onmouseout="this.style.background='#f8f8f8';this.style.color='black'" onmouseover="this.style.background='#f0f0f0';this.style.color='blue';" style="margin-left: -20px; background: none repeat scroll 0% 0% rgb(248, 248, 248); color: black;">
								<td width="70%" align="left"><strong>Carta de Solicitud </strong></td>
								<td width="70%" align="center"><input type="checkbox" value="t" name="carta_solicitud" id="carta_solicitud"></td>
								</tr><tr bgcolor="#f8f8f8" onmouseout="this.style.background='#f8f8f8';this.style.color='black'" onmouseover="this.style.background='#f0f0f0';this.style.color='blue';" style="margin-left: -20px; background: none repeat scroll 0% 0% rgb(248, 248, 248); color: black;">
								<td align="left"><b>Informe Social </b></td>
								<td align="center"><input type="checkbox" value="t" name="informe_social" id="informe_social"></td>
								</tr><tr bgcolor="#f8f8f8" onmouseout="this.style.background='#f8f8f8';this.style.color='black'" onmouseover="this.style.background='#f0f0f0';this.style.color='blue';" style="margin-left: -20px; background: none repeat scroll 0% 0% rgb(248, 248, 248); color: black;">
								<td align="left"><b>Informe Médico </b></td>
								<td align="center"><input type="checkbox" value="t"  name="informe_medico" id="informe_medico"></td>
								</tr><tr bgcolor="#f8f8f8" onmouseout="this.style.background='#f8f8f8';this.style.color='black'" onmouseover="this.style.background='#f0f0f0';this.style.color='blue';" style="margin-left: -20px; background: none repeat scroll 0% 0% rgb(248, 248, 248); color: black;">
								<td align="left"><strong>Presupuesto</strong></td>
								<td align="center"><input type="checkbox" value="t" name="presupuesto" id="presupuesto"></td>
								</tr><tr bgcolor="#f8f8f8" onmouseout="this.style.background='#f8f8f8';this.style.color='black'" onmouseover="this.style.background='#f0f0f0';this.style.color='blue';" style="margin-left: -20px; background: none repeat scroll 0% 0% rgb(248, 248, 248); color: black;">
								<td align="left"><b>Copia de la Cédula de Identidad </b></td>
								<td align="center"><input type="checkbox" value="t" name="copia_ci" id="copia_ci"></td>
								</tr></tbody>
								</table>							  </td>
                            </tr>
                            
                            <tr>
                              <td>&nbsp;</td>
                              <td><strong>Monto:</strong></td>
                              <td>
							  	<input name="monto" type="text" class="inputbox" id="monto" style="width:464px;" onkeypress="return validar_monto2(this.form,this,event,'')" />							  </td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td><strong>Razón Social:</strong></td>
                              <td><input name="razon_social" type="text" class="inputbox" id="razon_social" style="width:464px;" /></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td><strong>R.I.F.:</strong></td>
                              <td><input name="rif" type="text" class="inputbox" id="rif" style="width:464px;" /></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td><strong>Concepto:</strong></td>
                              <td><input name="concepto" type="text" class="inputbox" id="concepto" style="width:464px;" /></td>
                            </tr>
                            
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><strong> Observaciones:</strong></td>
                                  <td colspan="3"><textarea name="observaciones" id="observaciones" rows="5" class="inputbox" onkeypress="return validar_texto(this.form,this,event,'')"  style="width:466px; height:95px; margin-bottom:10px;"></textarea></td>
                                </tr>
                                <tr>
                                <td>&nbsp;</td>
                                <td colspan="4"><div align="center"> <img src="../comunes/imagenes/16_save.gif" onmouseover="Tip('Guardar')" onmouseout="UnTip()" border="0" onclick="javascript:guardar()"/> <img src="../comunes/imagenes/printer.png" onmouseover="Tip('Imprimir Informe')" onmouseout="UnTip()" border="0" onclick="javascript:imprimir('<?=$_REQUEST["id_caso"]?>')"/> <img src="../comunes/imagenes/door_in.png" onmouseover="Tip('Cerrar')" onmouseout="UnTip()" border="0" onclick="javascript:cerrar('<?=$_REQUEST["id_caso"]?>')"/> </div></td>
                                </tr>
                                <td colspan="6" style="border:#CCCCCC solid 1px;"><div align="center" style="background-image: url('../comunes/imagenes/barra.png')">
                                     <br>
                                    </div>									</td>
                            </tr>
                        </table>
                      </td>
                    </tr>
                </table>
             </form>
        </center>
		<?php
		$id_caso	= $_GET['id_caso'] ;
		$obj_pto = new cpuntos();
		$pto_cta = $obj_pto->getPunto($id_caso);
		$response = '';
		if ($pto_cta !== FALSE) {			
			$response .= "$('#desc_pto_cta').html('Punto de Cuenta N° {$pto_cta->rowset["id_pto_cta"]}');";
			$response .= "$('#id_pto_cta').val('{$pto_cta->rowset["id_pto_cta"]}');";
			$response .= "$('#asunto').val('{$pto_cta->rowset["asunto"]}');";
			$response .= "$('#argumentacion').val('{$pto_cta->rowset["argumentacion"]}');";
			$response .= ($pto_cta->rowset["carta_solicitud"] == 't')	? '$("#carta_solicitud").attr("checked", "checked");' : false ;
			$response .= ($pto_cta->rowset["informe_social"] == 't')	? '$("#informe_social").attr("checked", "checked");' : false ;
			$response .= ($pto_cta->rowset["informe_medico"] == 't')	? '$("#informe_medico").attr("checked", "checked");' : false ;
			$response .= ($pto_cta->rowset["presupuesto"] == 't')		? '$("#presupuesto").attr("checked", "checked");' : false ;
			$response .= ($pto_cta->rowset["copia_ci"] == 't')			? '$("#copia_ci").attr("checked", "checked");' : false ;
			$response .= "$('#monto').val('".to_moneda($pto_cta->rowset["monto"])."');";
			$response .= "$('#razon_social').val('{$pto_cta->rowset["razon_social"]}');";
			$response .= "$('#rif').val('{$pto_cta->rowset["rif"]}');";
			$response .= "$('#concepto').val('{$pto_cta->rowset["concepto"]}');";
			$response .= "$('#id_decision').val('{$pto_cta->rowset["id_decision"]}');";
			$response .= "$('#observaciones').val('{$pto_cta->rowset["observaciones"]}');";			
		}
		else {
			$response .= "$('#desc_pto_cta').html('Punto de Cuenta Sin Guardar');";
		}
		javascript($response);
		?>
    </body>
</html>