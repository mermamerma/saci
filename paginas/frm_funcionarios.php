<?
	require_once("../librerias/db_postgresql.inc.php");
	require_once("../cdatos/cfuncionarios.php");
	include_once('aplicaciones.php');
	
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
            function guardar() {
				sexo = $("input[name='sexo']:checked").val(); 
				if (sexo == null )
					alert('¡Debe de Seleccionar el Sexo del Funcionario..!')
				else {
					$.ajax({
						url:'<?=BASE_URL?>paginas/procesar_funcionarios.php',
						type:'post',
						data:$('#form1').serialize(),
						success:function(data){
						//$('#activityanimation').hide();						
						$('#resultado-ajax').html(data);					
					}});
				}
            }
        </script>
    </head>
    <link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
    <body>
        <script src="../comunes/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>
        <center>    
			<div id="resultado-ajax"></div>
            <form name="form1" id="form1" method="post" action="#">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="65%" class="menu_izq_titulo"><img src="../comunes/imagenes/group_edit.png" /> Funcionarios Firmantes</td>
                        <td width="20%" align="center" class="menu_izq_titulo"><img src="../comunes/imagenes/16_save.gif" onmouseover="Tip('Guardar')" onmouseout="UnTip()" border="0" onclick="javascript:guardar()"/></td>
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
                                    <strong>Datos Generales de los Funcionarios Firmantes </strong>									</div>								</td>
                            </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                              
                            
                            <tr>
                                <td height="37">&nbsp;</td>
                                <td>
                                    <strong>Nombre del Secretario(a) General:</strong></td>
                                <td colspan="3">
                                    <input name="nombre_secretario" type="text" class="inputbox" id="nombre_secretario" style="width:464px;">                                </td>
                            </tr>
                            
                            <tr>
                              <td height="35">&nbsp;</td>
                              <td><strong>Sexo:</strong></td>
                              <td>
							  	<label>
                                <input name="sexo" id="sexo_m" type="radio" value="M" />
                              	Masculino								</label>
								<label>
                                <input name="sexo" id="sexo_f" type="radio" value="F" />
                              	Femenino								</label>							  </td>
                            </tr>
                            <tr>
                              <td height="35">&nbsp;</td>
                              <td><strong>Cargo del Secretario(a) General:</strong> </td>
                              <td><input name="cargo_secretario" type="text" class="inputbox" id="cargo_secretario" style="width:464px;" /></td>
                            </tr>
                            <tr>
                              <td height="35">&nbsp;</td>
                              <td><strong>Número de Resolución:</strong></td>
                              <td><input name="num_resolucion" type="text" class="inputbox" id="num_resolucion" style="width:464px;" /></td>
                            </tr>
                            <tr>
                              <td height="35">&nbsp;</td>
                              <td><strong>Fecha de Resolución:</strong></td>
                              <td><input name="fecha_resolucion" type="text" class="inputbox" id="fecha_resolucion" style="width:464px;" /></td>
                            </tr>
                            <tr>
                              <td height="33">&nbsp;</td>
                              <td><strong>Número de Gaceta:</strong></td>
                              <td><input name="num_gaceta" type="text" class="inputbox" id="num_gaceta" style="width:464px;" /></td>
                            </tr>
                            <tr>
                              <td height="27">&nbsp;</td>
                              <td><strong>Fecha de Gaceta:</strong></td>
                              <td><input name="fecha_gaceta" type="text" class="inputbox" id="fecha_gaceta" style="width:464px;" /></td>
                            </tr>
                            <tr>
                              <td height="38">&nbsp;</td>
                              <td><strong>Nombre del(a) Director(a) Aten. al Cdno.:</strong></td>
                              <td><input name="nombre_dir_ac" type="text" class="inputbox" id="nombre_dir_ac" style="width:464px;" /></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td><strong>Cargo del(a) Director(a) Aten. al Cdno.:</strong></td>
                              <td><input name="cargo_dir_ac" type="text" class="inputbox" id="cargo_dir_ac" style="width:464px;" /></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td><strong>Elaborador del Punto de Cuenta</strong></td>
                              <td><input name="elab_pto_cta" type="text" class="inputbox" id="elab_pto_cta" style="width:464px;" /></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td colspan="2" align="center">
							  <img src="../comunes/imagenes/16_save.gif" onmouseover="Tip('Guardar')" onmouseout="UnTip()" border="0" onclick="javascript:guardar()"/>
							  </td>
                              </tr>
                            
                            
                                <td colspan="6" style="border:#CCCCCC solid 1px;">
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png')">
                                     <br>
                                    </div>								</td>
                            </tr>
                        </table>
                      </td>
                    </tr>
                </table>
             </form>
        </center>
			<?php
		$funcionarios = new cfuncionarios();
		$row = $funcionarios->getFirmantes() ;
		
		
		if ($row) {			
			$html = '<script>';			
			$html .= "$('#nombre_secretario').val('{$row->rowset['nombre_secretario']}');";
			$html .= ($row->rowset['sexo'] == 'M') ? "$('#sexo_m').attr('checked', true);" : null;
			$html .= ($row->rowset['sexo'] == 'F') ? "$('#sexo_f').attr('checked', true);" : null;
			$html .= "$('#cargo_secretario').val('{$row->rowset['cargo_secretario']}');";
			$html .= "$('#num_resolucion').val('{$row->rowset['num_resolucion']}');";
			$html .= "$('#fecha_resolucion').val('{$row->rowset['fecha_resolucion']}');";
			$html .= "$('#num_gaceta').val('{$row->rowset['num_gaceta']}');";
			$html .= "$('#fecha_gaceta').val('{$row->rowset['fecha_gaceta']}');";
			$html .= "$('#nombre_dir_ac').val('{$row->rowset['nombre_dir_ac']}');";
			$html .= "$('#cargo_dir_ac').val('{$row->rowset['cargo_dir_ac']}');";
			$html .= "$('#elab_pto_cta').val('{$row->rowset['elab_pto_cta']}');";
			$html .= '</script>';
			echo $html ;			
		}		

		?>
    </body>
</html>