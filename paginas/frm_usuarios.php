<?

       require_once("../librerias/db_postgresql.inc.php");
       require_once('../cdatos/cusuarios.php');
       $cusuario=new cusuarios();

        if ($_REQUEST["accion"]=="nuevo")
        {
            $_REQUEST['idestatus']="1";

        }
        else if ($_REQUEST["accion"]=="editar" || $_REQUEST["accion"]=="consultar")
        {

            $cusuario->set_idusuario($_REQUEST["idusuario"]);
            $cusuario->getData();

            $_REQUEST["grupo"]=$cusuario->get_idgrupo();
            $_REQUEST["nombres"]=$cusuario->get_nombres();
            $_REQUEST["apellidos"]=$cusuario->get_apellidos();
            $_REQUEST["cedula"]=$cusuario->get_cedula();
            $_REQUEST["email"]=$cusuario->get_email();
            $_REQUEST["login"]=$cusuario->get_login();
            $_REQUEST["idestatus"]=$cusuario->get_idestatus();
            $_REQUEST["iniciales"]=$cusuario->get_iniciales();
            $_REQUEST["firma"]=$cusuario->get_firma();

        }else if ($_REQUEST["accion"]=="guardar")
        {

           $cusuario->set_idgrupo($_REQUEST["grupo"]);
           $cusuario->set_nombres($_REQUEST["nombres"]);
           $cusuario->set_apellidos($_REQUEST["apellidos"]);
           $cusuario->set_cedula($_REQUEST["cedula"]);
           $cusuario->set_email($_REQUEST["email"]);
           $cusuario->set_login($_REQUEST["login"]);
           $cusuario->set_idestatus($_REQUEST["idestatus"]);
           $cusuario->set_iniciales($_REQUEST["iniciales"]);
           $cusuario->set_firma($_REQUEST["firma"]);

           if ($_REQUEST["idusuario"]>0)
           {
               $cusuario->set_idusuario($_REQUEST["idusuario"]);
               $ult_usuario=$cusuario->Update();

               if ($ult_usuario>0)
               {
                   mensaje("Se ha Actualizado el Usuario con Exito");
                   open_pag("lst_usuarios.php", "contenido");
               }
               else
               {
                   mensaje("Han Ocurrido Errores al Intentar Actualizar el Usuario");
               }

           }
           else
           {

               $ult_usuario=$cusuario->Insertar();

               if ($ult_usuario>0)
               {
                   mensaje("Se ha Registrado el Usuario con Exito");
                   open_pag("lst_usuarios.php", "contenido");
               }
               else
               {
                   mensaje("Han Ocurrido Errores al Intentar Registrar el Usuario");
               }
           }


        }


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="pragma" content="no-cache">
        <link rel="shortcut icon" href="../comunes/imagenes/favicon.ico" type="image/x-icon" >
        <script src="../comunes/js/funciones.js" type="text/javascript"></script>
        <script src="../comunes/js/jquery.js" type="text/javascript"></script>
        <script src="../comunes/js/jquery.maskedinput.js" type="text/javascript"></script>
        <script type="text/javascript" src="../comunes/js/prototype.js"></script>
        <script type="text/javascript" src="../comunes/js/effects.js"></script>
        <script type="text/javascript" src="../comunes/js/scriptaculous.js"></script>

         <link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
         
        <style>
            body {padding:0px;margin:0px;text-align:left;font:11px verdana, arial, helvetica, serif; background-color:#FFFFFF;}
        </style>
        <script language="javascript">

            document.oncontextmenu = function(){return false}
            var strSeperator = '/';
            var shift=false;
            var crtl=false;
            var alt=false;

            function CedulaFormat(vCedulaName,mensaje,postab,escribo,evento) {

		tecla=getkey(evento);
		vCedulaName.value=vCedulaName.value.toUpperCase();
		vCedulaValue=vCedulaName.value;
		valor=vCedulaValue.substring(2,12);
		var numeros='0123456789/';
		var digit;
		var noerror=true;

		if (shift && tam>1) {
			return false;
		}

		for (var s=0;s<valor.length;s++){
			digit=valor.substr(s,1);

			if (numeros.indexOf(digit)<0)
			{
				noerror=false;
				break;
			}
		}

		tam=vCedulaValue.length;
		if (escribo) {
		if ( tecla==8 || tecla==37)
		{
			if (tam>2)
				vCedulaName.value=vCedulaValue.substr(0,tam-1);
			else
				vCedulaName.value='';
				return false;
		}

		if (tam==0 && tecla==69) {
			vCedulaName.value='E-';
			return false;
		}

		if (tam==0 && tecla==86) {
			vCedulaName.value='V-';
			return false;
		}

		if (tam==0 && tecla==80) {
			vCedulaName.value='P-';
			return false;
		}

		else if ((tam==0 && ! (tecla<14 || tecla==69 || tecla==86 || tecla==46)))
		return false;
		else if ((tam>1) && !(tecla<14 || tecla==16 || tecla==46 || tecla==8 || (tecla >= 48 && tecla <= 57) || (tecla>=96 && tecla<=105)))
		return false;
		}
		if (noerror)
		return true;

		alert('Debe ser una Cédula Válida\nPor Favor Reescribala');
		return false;
	}

	function getkey(e)
	{
		if (window.event)
		{
			shift= event.shiftKey;
			ctrl= event.ctrlKey;
			alt=event.altKey;
			return window.event.keyCode;
		}
		else if (e)
		{
			var valor=e.which;
			if (valor>96 && valor<123)
			{
				valor=valor-32;
			}

			return valor;

		}
		else
		return null;
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

                if (!campoRequerido(document.frmusuario.nombres,"Nombres")) return false;
                //if (!campoRequerido(document.frmusuario.cedula,"Cédula")) return false;
                if (!campoRequerido(document.frmusuario.login,"Nombre de Usuario")) return false;
                if (!validaSelect(document.frmusuario.grupo,'Grupo de Usuario'))return false;

                window.document.getElementById('accion').value='guardar';
		document.frmusuario.submit();


            }

            function cerrar()
            {
                window.open("lst_usuarios.php", "contenido");
            }
           
        </script>

 
                 
    </head>

    <body>       

            
        
            <script src="../comunes/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>
            <center>
            <link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />

            <form name="frmusuario" id="frmusuario" method="post" action="frm_usuarios.php">
                <input type="hidden" id="idusuario" name="idusuario" value="<?= $_REQUEST['idusuario'] ?>">                
                <input type="hidden" id="accion" name="accion" value="<?= $_REQUEST['accion'] ?>">
                <input type="hidden" id="idestatus" name="idestatus" value="<?= $_REQUEST['idestatus'] ?>">
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="65%" class="menu_izq_titulo"><img src="../comunes/imagenes/manager_user.gif" />Usuarios</td>
                        <td width="10%" align="center" class="menu_izq_titulo">
                        <?   if ($_REQUEST["accion"]!="consultar")  {  ?>
                        <img src="../comunes/imagenes/16_save.gif" onmouseover="Tip('Guardar')" onmouseout="UnTip()" border="0" onclick="javascript:guardar('<?=$_REQUEST["accion"]?>')"/>
                        <? }  ?>                    
                        <img src="../comunes/imagenes/door_in.png" onmouseover="Tip('Cerrar')" onmouseout="UnTip()" border="0" onclick="javascript:cerrar()"/>
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
                                        <strong>Datos del Usuario</strong>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            
                                <tr>
                                <td width="1">&nbsp;</td>
                                <td width="95">
                                    <strong>Nombres:</strong>
                                </td>
                                <td width="176">
                                    <label>
                                        <input name="nombres" type="text" class="inputbox" id="nombres" onkeypress="return validar_texto(this.form,this,event,'')" value="<?= @$_REQUEST['nombres'] ?>"></input>
                                    </label>
                                </td>
                                <td width="89">
                                    <strong>
                                        Apellidos:
                                    </strong>
                                </td>
                                <td width="199">

                                 	 <input name="apellidos" type="text" class="inputbox" id="apellidos" onkeypress="return validar_texto(this.form,this,event,'')" value="<?= @$_REQUEST['apellidos'] ?>">

                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        C&eacute;dula:
                                    </strong>
                                </td>
                                <td>
                                    <label>
                                        
                                        <input name="cedula" type="text" class="inputbox" id="cedula" onkeypress="return CedulaFormat(this,'Cédula de Identidad Invalida',-1,true,event)" onmouseout="UnTip()" maxlength="12" value="<?= @$_REQUEST['cedula'] ?>" ></input>

                                    </label>
                                </td>
                                <td>
                                    <strong>Correo Electr&oacute;nico:</strong>
                                </td>
                                <td>
                                    <input name="email" type="text" class="inputbox" id="email" onBlur="ValidarObjetos('email','email');" value="<?= @$_REQUEST['email'] ?>">
                                </td>
                            </tr>                                


                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Nombre de Usuario:
                                    </strong>
                                </td>
                                <td>
                                    <label>
                                        <input name="login" type="text" class="inputbox" id="login" onkeypress="return validar_texto(this.form,this,event,'')" maxlength="50" value="<?= @$_REQUEST['login'] ?>" ></input>
										<img onmouseout="UnTip()" onmouseover="Tip('Debe de ser un usuario válido en el correo institucional')"  src="../comunes/imagenes/help3.gif" width="17" height="20" style="vertical-align: middle" />
                                    </label>
                                </td>
                                <td>
                                    <strong>Grupo de Usuario:</strong>
                                </td>
                                <td>
                                    <select name="grupo" id="grupo" style="width:160px;" class="inputbox">
                                    <option value>Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmaestro, descripcion from vgrupos_usuarios where estatus=1 order by descripcion", @$_REQUEST["grupo"]));
                                    ?>
                                    </select>
                                </td>
                            </tr>  


                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Iniciales:
                                    </strong>
                                </td>
                                <td>
                                    <label>
                                        <input name="iniciales" type="text" class="inputbox" id="iniciales" onkeypress="return validar_texto(this.form,this,event,'')" maxlength="2" value="<?= @$_REQUEST['iniciales'] ?>" ></input>
                                    </label>
                                </td>
                                <td><strong>
                                        Firma del Informe:
                                    </strong></td>
                                <td><label>
                                        <input name="firma" type="text" class="inputbox" id="firma" onkeypress="return validar_texto(this.form,this,event,'')" maxlength="50" value="<?= @$_REQUEST['firma'] ?>" ></input>
                                    </label></td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                                <td colspan="6" style="border:#CCCCCC solid 1px;">
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png')">
                                        <br>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        </td>

                    </tr>
                </table>
             </form>
        </center>
    </body>
</html>