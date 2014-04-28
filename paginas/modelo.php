
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="pragma" content="no-cache">
        <link rel="shortcut icon" href="comunes/imagenes/favicon.ico" type="image/x-icon" >
        <link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
        
        <script src="../comunes/js/funciones.js" type="text/javascript"></script>
        <script src="../comunes/js/prototype.js" type="text/javascript"></script>
        <script src="../comunes/js/jquery.js" type="text/javascript"></script>
        <script src="../comunes/js/jquery.maskedinput.js" type="text/javascript"></script>
        <style>
            body {padding:0px;margin:0px;text-align:left;font:11px verdana, arial, helvetica, serif; background-color:#FFFFFF;}
        </style>
        <script language="javascript">
            jQuery(function($){
                $("#strtlfhab").mask("(0999) 999.99.99",{placeholder:" "});
            });

            jQuery(function($){
                $("#strdocumento").mask("9999999?99",{placeholder:""});
            });

            function ValCam(objX,tipoX)
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

		case 'combotipo':
			if (obl.value==""){
				alert("Seleccione un Tipo de Usuario");
				obj.style.border = "1px solid #FF0000";
			}else{
				obj.style.border = "1px solid #7f9db9";
			}
		break;

		case 'varchar':
			obj.style.border = "1px solid #7f9db9";
		break;

		case 'email':
			if (filter.test(obj.value)){
				obj.style.border = "1px solid #7f9db9";
				return true;
			}else{
				alert("Ingrese una dirección de correo válida");
				obj.style.border = "1px solid #FF0000";
				return false;
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
			if (filter3.test(obj.value)){
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

		case 'float8':
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

    
            
            function validar(acc, tipo, login)
            {
                if (!campoRequerido(document.frmcontacto.strnombre,"Nombre")) return false;
                if (!campoRequerido(document.frmcontacto.strapellido,"Apellido")) return false;
                if (!campoRequerido(document.frmcontacto.strdocumento,"Cedula")) return false;
                if (!campoRequerido(document.frmcontacto.stremail,"Email")) return false;
                if (!campoRequerido(document.frmcontacto.strtlfhab,"Telefono")) return false;
                if (!campoRequerido(document.frmcontacto.strmediafirma,"Media Firma")) return false;
                if (!campoRequerido(document.frmcontacto.memdireccion,"Dirección")) return false;
                if (!validarFirma('firma', 'Firma')) return false;

                if(tipo == 'Interno')
                {
                    if (!campoRequerido(document.frmcontacto.strlogin,"Login")) return false;
                    if (!validaSelect(document.frmcontacto.id_cargo_maestro,'Cargo'))return false;
                    if (!validaSelect(document.frmcontacto.id_estatus_maestro,'Estatus'))return false;
                    if (!validaSelect(document.frmcontacto.id_profile_maestro,'Perfil'))return false;
                    if (!validaSelect(document.frmcontacto.id_dpto_maestro,'Departamento'))return false;

                    xajax_verificarLogin(document.frmcontacto.strlogin.value);
                    if(login != document.frmcontacto.strlogin.value)
                    {
                        if (!validaLogin(document.frmcontacto.valLogin, document.frmcontacto.strlogin)) return false;
                    }

                }
                if(acc == 'INS')
                {
                    if(tipo == 'Interno')
                    {
                        document.frmcontacto.strfirma.value= FCKeditorAPI.__Instances['firma'].GetHTML();
                    }

                    xajax_verificarDocumento(document.frmcontacto.strdocumento.value);
                    xajax_insertContacto(xajax.getFormValues('frmcontacto'));

                }else
                {
                    if(tipo == 'Interno'){
                        document.frmcontacto.strfirma.value= FCKeditorAPI.__Instances['firma'].GetHTML();
                    }
                    xajax_updateContacto(xajax.getFormValues('frmcontacto'));

                }

            }

          
        </script>
    </head>
    <body>
        <script src="../comunes/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>
        <center>
            <form name="frmcontacto" id="frmcontacto" method="post">
                <input type="hidden" id="id_contacto" name="id_contacto" value="<?= $_REQUEST['id'] ?>">
                <input type="hidden" name="strfirma" id="strfirma" value="">
                <input type="hidden" name="id_tipo_maestro" id="id_tipo_maestro" value="<?= $_REQUEST['id_tipo_maestro'] ?>">
                <input type="hidden" id="valLogin" name="valLogin" value="">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="65%" class="menu_izq_titulo"><img src="../comunes/imagenes/manager_user.gif" />Usuarios</td>
                        <td width="10%" align="center" class="menu_izq_titulo">

                            <?php if($_REQUEST['volver'] == "pendiente"){ ?>
                                 <img src="../comunes/imagenes/arrow_undo.png" onmouseover="Tip('Volver')" onmouseout="UnTip()" border="0" onclick="javascript:location.href='blank.php'"/>
                                 <img src="../comunes/imagenes/guardar.png" onmouseover="Tip('Guardar Contacto Interno')" onmouseout="UnTip()" border="0" onclick="validar2('<?php echo $_REQUEST['acc'] ?>', '<?php echo $_REQUEST['tipo'] ?>', '<?= $_REQUEST['login'] ?>');"/>
                            <?php } else { ?>
                            	 <img src="../comunes/imagenes/16_save.gif" onmouseover="Tip('Volver')" onmouseout="UnTip()" border="0" onclick="javascript:location.href='contactoVista.php'"/>
                            <?php }  ?>
                        </td>
                    </tr>
                    <tr>
                        <table width="100%" border="0"  class="tablaTitulo" >
                            <tr>
                                <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png')">
                                        <strong>Datos Personales</strong>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="1">&nbsp;</td>
                                <td width="95">
                                    <label id="lstrnombre" style="celda_etiqueta">
                                        Nombres:
                                    </label>
                                </td>
                                <td width="176">
                                    <label>
                                    <?php if($_REQUEST['volver'] == "pendiente"){ ?>
                                        <input name="strnombre" type="text" class="inputbox" id="strnombre" readOnly="true" value="<?= $_REQUEST['nombre'] ?>">
                                    <?php } else { ?>
                                    	<input name="strnombre" type="text" class="inputbox" id="strnombre" value="<?= $_REQUEST['nombre'] ?>">
                                    <?php }  ?>
                                    </label>
                                </td>
                                <td width="89">
                                    <label id="lstrapellido">
                                        Apellidos:
                                    </label>
                                </td>
                                <td width="199">
                                <?php if($_REQUEST['volver'] == "pendiente"){ ?>
                                    <input name="strapellido" type="text" class="inputbox" id="strapellido" readOnly="true" value="<?= $_REQUEST['apellido'] ?>">
                                 <?php } else { ?>
                                 	 <input name="strapellido" type="text" class="inputbox" id="strapellido" value="<?= $_REQUEST['apellido'] ?>">
                                 <?php }  ?>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <label id="lstrdocumento">
                                        C&eacute;dula:
                                    </label>
                                </td>
                                <td>
                                    <label>
                                    <?php if($_REQUEST['volver'] == "pendiente"){ ?>
                                        <input name="strdocumento" type="text" class="inputbox" id="strdocumento" maxlength="9" readOnly="true" value="<?= $_REQUEST['documento'] ?>">
                                    <?php } else { ?>
                                    	<input name="strdocumento" type="text" class="inputbox" id="strdocumento" maxlength="9" value="<?= $_REQUEST['documento'] ?>" >
                                    <?php }  ?>
                                    </label>
                                </td>
                                <td>
                                    <label id="lstremail">Correo:</label>
                                </td>
                                <td>
                                    <input name="stremail" type="text" class="inputbox" id="stremail" onBlur="ValCam('stremail','email');" value="<?= $_REQUEST['email'] ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <label id="lstrtlfhab">
                                        Tel&eacute;fono:
                                    </label>
                                </td>
                                <td>
                                    <input name="strtlfhab" type="text" class="inputbox" maxlength="12" id="strtlfhab" value="<?= $_REQUEST['tlfn'] ?>">
                                </td>
                                <td>
                                    <label id="lstrext">
                                        Extensi&oacute;n:
                                    </label>
                                </td>
                                <td>
                                    <input name="strext" type="text" class="inputbox" maxlength="5" id="text" value="<?= $_REQUEST['ext'] ?>" />
                                </td>
                            </tr>
                           
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <label id="lmemdireccion">
                                        Direcci&oacute;n:
                                    </label>
                                </td>
                                <td colspan="4">
                                    <label>
                                        <textarea name="memdireccion" id="memdireccion" class="textareabox" cols="10"><?= $_REQUEST['direccion'] ?></textarea>
                                    </label>
                                </td>

                            </tr>
                           
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <tr>
                                <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png')">
                                        <strong>Datos del Sistema</strong>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <label id="lstrlogin">
                                        Login:
                                    </label>
                                </td>
                                <td>

                                    <input name="strlogin" type="text" class="inputbox" id="strlogin"  value="<?= $_REQUEST['login'] ?>">



                                </td>
                                <?php if($_REQUEST['volver'] != "pendiente"){ ?>
                                	<td>
                                    	<input type="button" value="Verificar" onclick="xajax_verificarLogin(document.frmcontacto.strlogin.value);">
                                	</td>
                                	<td><div id="capaLogin">&nbsp;</div></td>
                                <?php } ?>
                            </tr>
                            
                           <?php if($_REQUEST['volver'] != "pendiente"){ ?>
    	                        <tr>
 	                               <td>&nbsp;</td>
                                	<td>
                            	        <label id="lid_cargo_maestro">
                        	                Cargo:
                    	                </label>
                	                </td>
            	                    <td>
        	                            <label>
    	                                    <div id='capaCargo'>
	                                            <select name="id_cargo_maestro" id="id_cargo_maestro" class="selectbox">
                                            	    <option value="0">Seleccione</option>
                                        	    </select>
                                    	    </div>
                                	    </label>
                            	    </td>
                        	        <td>
                    	                <label id="lid_estatus_maestro">
                	                        Estatus:
            	                        </label>
        	                        </td>
    	                            <td>
 	                                   <label>
                                        	<div id='capaEstatus'>
                                    	        <select name="id_estatus_maestro" id="id_estatus_maestro" class="selectbox">
                                	                <option value="0">Seleccione</option>
                            	                </select>
                        	                </div>
                    	                </label>
                	                </td>
            	                </tr>
        	                    <tr>
    	                            <td>&nbsp;</td>
	                                <td>
                            	        <label id="lid_profile_maestro">
                        	                Perfil:
                    	                </label>
                	                </td>
            	                    <td>
        	                            <label>
    	                                    <div id='capaProfile'>
 	                                           <select name="id_profile_maestro" id="id_profile_maestro" class="selectbox">
                                                	<option value="0">Seleccione</option>
                                            	</select>
                                        	</div>
                                    	</label>
                                	</td>
                                	<td>
                            	        <label id="lid_dpto_maestro">
                        	                Departamento:
                    	                </label>
                	                </td>
            	                    <td>
        	                            <label>
    	                                    <div id='capaDpto'>
  	                                          <select name="id_dpto_maestro" id="id_dpto_maestro" class="selectbox">
                                            	    <option value="0">Seleccione</option>
                                        	    </select>
                                    	    </div>
                                	    </label>
                            	    </td>
                        	    </tr>
                    	        <tr>
                	                <td>&nbsp;</td>
            	                    <td>
         	                           <label id="lid_coord_maestro">
                                    	    Coordinaci&oacute;n:
                                	    </label>
                            	    </td>
                        	        <td>
                    	                <label>
                                        	<div id='capaCoord'>
                                    	        <select name="id_coord_maestro" id="id_coord_maestro" class="selectbox">
                                	                <option value="0">Seleccione</option>
                            	                </select>
                        	                </div>
                    	                </label>
                	                </td>
            	                    <td>
        	                            <label id="lid_coordext_maestro">
    	                                    Coordinaci&oacute;n Extra:
	                                    </label>
                                	</td>
                                	<td>
                                    	<label>
                                        	<div id='capaCoordext'>
                                            	<select name="id_coordext_maestro" id="id_coordext_maestro" class="selectbox">
                                                	<option value="0">Seleccione</option>
                                            	</select>
                                        	</div>
                                    	</label>
                                	</td>
                            	</tr>


                            <?php } else {?>
                            	<tr>
                                	<td>&nbsp;</td>
                                	<td>
                                    	<label id="lstrpassword">
                                        	Nueva Clave:
                                   		 </label>
                               		</td>
                                	<td>
                                    	<input name="strpassword" type="password" class="inputbox" id="strpassword" value="<?=$_REQUEST['password']?>" />
                                	</td>
                               		<td>
                                    	<label id="lstrpassword2">
                                        	Confirme Clave:
                                    	</label>
                                	</td>
                                	<td><input name="strpassword2" type="password" class="inputbox" id="strpassword2" value="<?=$_REQUEST['password']?>" /></td>
                            	</tr>
                            <?php } ?>


                                <td colspan="6" style="border:#CCCCCC solid 1px;">
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png')">
                                        <br>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </tr>
                </table>
             </form>
        </center>
    </body>
</html>