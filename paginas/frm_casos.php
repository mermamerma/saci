<?

    require_once ('../comunes/xajax/xajax_core/xajax.inc.php');
    require_once("../librerias/db_postgresql.inc.php");
    require_once('../librerias/funciones_ajax.php');
    require_once('../cdatos/ccasos.php');
	
    $xajax= new xajax();
    

    $xajax->registerFunction('nuevo_remitente');
    $xajax->registerFunction('guardar_remitente');
    $xajax->registerFunction('mostrar_remitentes');
    $xajax->registerFunction('guardar_caso');
    $xajax->registerFunction('mostrar_subcategorias');
    $xajax->registerFunction('validar_solicitante');

    $xajax->processRequest();
	$xajax->setFlag('debug',false);
    $xajax->configure('javascript URI', '../xajax/');
    
	
	@ob_end_clean();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="pragma" content="no-cache">
        <link rel="shortcut icon" href="../comunes/imagenes/favicon.ico" type="image/x-icon" >

        <link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
		
		<?php
			$xajax->printJavascript('../comunes/xajax/')
		?>
        <script src="../comunes/js/funciones.js" type="text/javascript"></script>
        <script src="../comunes/js/jquery.js" type="text/javascript"></script>
        <script src="../comunes/js/jquery.maskedinput.js" type="text/javascript"></script>
        <script type="text/javascript" src="../comunes/js/prototype.js"></script>
        <script type="text/javascript" src="../comunes/js/effects.js"></script>
        <script type="text/javascript" src="../comunes/js/scriptaculous.js"></script>

        <style>
            body {padding:0px;margin:0px;text-align:left;font:11px verdana, arial, helvetica, serif; background-color:#FFFFFF;}
        </style>
        
        <script language="javascript">

            document.oncontextmenu = function(){return false}
            var strSeperator = '/';
            var shift=false;
            var crtl=false;
            var alt=false;

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

            function inicio()
            {
                if(self.gfPop)
                {
                        gfPop.fPopCalendar(document.frmcaso.f_inicio);
                }
            }

            function cambio_inicio()
            {
                if (inicio=='')
                {
                    alert('Fecha Inv&aacute;lida');
                    document.frmcaso.f_inicio.value='';
                }
                else
                {
                    document.frmcaso.fecha_inicio.value=document.frmcaso.f_inicio.value;
                }
            }

            function nuevo_remitente()
            {

                div = $('dvRemitente');
                div.toggle();

                if (div.innerHTML=='')
                {
                    div.toggle();
                    div.update('<div align="center"><img src="../comunes/imagenes/ajax-loader.gif"></div>');
                    xajax_nuevo_remitente();
                }
                else
                {
                    d = div.descendants();
                    if(d[0].id!='div_r')
                    {
                        div.show();
                        div.update('<div align="center"><img src="../comunes/imagenes/ajax-loader.gif"></div>');
                        xajax_nuevo_remitente();
                    }
                }

            }

            function guardar_remitente()
            {
                xajax_guardar_remitente(xajax.getFormValues('frmcaso'));
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

            function mostrar_combos(idremitente)
            {
                xajax_validar_solicitante(xajax.getFormValues('frmcaso'), '0');
                xajax_mostrar_remitentes(idremitente);
                mostrar_subcateg();
            }

            function guardar()
            {

                if (!campoRequerido(document.frmcaso.fecha_inicio,"Fecha de Registro")) return false;
                if (!validaSelect(document.frmcaso.tipo_caso,'Tipo de Caso'))return false;
                if (!campoRequerido(document.frmcaso.descripcion_caso,"Descripción del Caso")) return false;
                xajax_guardar_caso(xajax.getFormValues('frmcaso'));

            }
            function seguimiento()
            {
                var idcaso=document.frmcaso.idcaso.value;
                window.open('lst_seguimientos.php?idcaso='+idcaso,'contenido');
            }


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

	function RifFormat(vRifName,mensaje,postab,escribo,evento) {

		tecla=getkey(evento);
		vRifName.value=vRifName.value.toUpperCase();
		vRifValue=vRifName.value;
		valor=vRifValue.substring(2,12);
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

		tam=vRifValue.length;
		if (escribo) {
		if ( tecla==8 || tecla==37)
		{
			if (tam>2)
				vRifName.value=vRifValue.substr(0,tam-1);
			else
				vRifName.value='';
				return false;
		}

		if (tam==0 && tecla==74) {
			vRifName.value='J-';
			return false;
		}

		if (tam==0 && tecla==86) {
			vRifName.value='V-';
			return false;
		}
                
                if (tam==0 && tecla==71) {
			vRifName.value='G-';
			return false;
		}
                
		else if ((tam==0 && ! (tecla<14 || tecla==74 || tecla==86 || tecla==46)))
		return false;
		else if ((tam>1) && !(tecla<14 || tecla==16 || tecla==46 || tecla==8 || (tecla >= 48 && tecla <= 57) || (tecla>=96 && tecla<=105)))
		return false;
		}
		if (noerror)
		return true;

		alert('Debe ser un Rif Válido\nPor Favor Reescribalo');
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

        function selec_instruccion(obj)
        {           
            document.frmcaso.cedula_benef.disabled = obj.checked;
            document.frmcaso.rif_benef.disabled = obj.checked;
            document.frmcaso.telefonos_benef.disabled = obj.checked;
            document.frmcaso.razon_social_benef.disabled = obj.checked;
            document.frmcaso.sexo.disabled = obj.checked;
            document.frmcaso.tipo_beneficiario.disabled = obj.checked;
            document.frmcaso.email_benef.disabled = obj.checked;
            document.frmcaso.edad.disabled = obj.checked;
            document.frmcaso.comunidad_benef.disabled = obj.checked;
        }

        function mostrar_subcateg()
        {
            var idtipocaso=document.frmcaso.tipo_caso.value;
            var idcategoria=document.frmcaso.categoria_caso.value;
            var idcaso=document.frmcaso.idcaso.value;

            xajax_mostrar_subcategorias(idtipocaso, idcategoria,idcaso);
        }

        function hab_texto(obj, indice)
        {
            tx_cantidad='document.frmcaso.txtcantidad'+indice;
            tx_monto='document.frmcaso.txtmonto'+indice;
            ocantidad = eval(tx_cantidad);
            omonto = eval(tx_monto);
            ocantidad.disabled=!obj.checked;
            omonto.disabled=!obj.checked;
        }

        function validar_solicitante()
        {
            xajax_validar_solicitante(xajax.getFormValues('frmcaso'), '1');
        }

        function imprimir_social(idcaso)
        {
            window.open('../reportes/rpt_social.php?idcaso='+idcaso,'_blank')
        }

         function imprimir_comite(idcaso)
        {
            window.open('../reportes/rpt_comite.php?idcaso='+idcaso,'_blank')
        }

        function cerrar()
        {
            history.back(1);
        }

        </script>
    </head>

            <?
				
				if(isset($_REQUEST["accion"]))
				{
				
					if ($_REQUEST["accion"]=="nuevo")
					{
						$_REQUEST['idestatus']="61";
						$_REQUEST["parentesco"]="12";
						$_REQUEST["sestatus_caso"]="Registrado";
						$_REQUEST["tipo_solicitante"]="112";
						$_REQUEST["tipo_beneficiario"]="112";

					}
					else if ($_REQUEST["accion"]=="editar" || $_REQUEST["accion"]=="consultar")
					{
					
						//echo $_REQUEST["idcaso"]; die();
						$ccaso=new ccasos();
						$data_caso=new Recordset();
						$data_caso=$ccaso->getDataCaso($_REQUEST["idcaso"]);

						$ccaso->set_idusuario_seg($_SESSION["idusuario"]);
						$desc_seg=" <b>Consult&oacute;</b> el Caso <b>(Id: ".$_REQUEST["idcaso"].")</b>";
						$ccaso->set_descripcion_seg($desc_seg);
						$ccaso->set_idcaso_seg($_REQUEST["idcaso"]);
						$ccaso->crearSeguimiento();


						if ($data_caso)
						{
							$_REQUEST["idsolicitante"]=$data_caso->rowset["idsolicitante"];
							
							$_REQUEST['razon_social_solic']=$data_caso->rowset["razon_social_solic"];
							$_REQUEST['rif_solic']=$data_caso->rowset["rif_solic"];
							$_REQUEST['cedula_solic']=$data_caso->rowset["cedula_solic"];
							$_REQUEST['email_solic']=$data_caso->rowset["correo_electronico_solic"];
							$_REQUEST['telefonos_solic']=$data_caso->rowset["telefonos_solic"];
							$_REQUEST["parentesco"]=$data_caso->rowset["idparentesco_solic"];
							$_REQUEST["tipo_solicitante"]=$data_caso->rowset["idtipo_solicitante_solic"];

							$_REQUEST["idbeneficiario"]=$data_caso->rowset["idbeneficiario"];

							$_REQUEST['razon_social_benef']=$data_caso->rowset["razon_social_benef"];
							$_REQUEST['rif_benef']=$data_caso->rowset["rif_benef"];
							$_REQUEST['cedula_benef']=$data_caso->rowset["cedula_benef"];
							$_REQUEST['telefonos_benef']=$data_caso->rowset["telefonos_benef"];
							@$_REQUEST["tipo_beneficiario"]=$data_caso->rowset["tipo_beneficiario"];
							$_REQUEST['email_benef']=$data_caso->rowset["correo_electronico_benef"];
							$_REQUEST["sexo"]=$data_caso->rowset["sexo_benef"];
							$_REQUEST['edad']=$data_caso->rowset["edad_benef"];
							$_REQUEST['comunidad_benef']=$data_caso->rowset["comunidad_benef"];
							$_REQUEST["tipo_beneficiario"]=$data_caso->rowset["idtipo_solicitante_benef"];

							$_REQUEST["fecha_inicio"]=fecha($data_caso->rowset["fecha_registro"]);
							$_REQUEST["f_inicio"]=fecha($_REQUEST["fecha_inicio"]);
							$_REQUEST["sestatus_caso"]=$data_caso->rowset["sestatus_caso"];
							$_REQUEST["idremitente"]=$data_caso->rowset["idremitente"];
							$_REQUEST['responsable']=$data_caso->rowset["responsable_remitente"];
							$_REQUEST["tipo_caso"]=$data_caso->rowset["idtipocaso"];
							$_REQUEST["categoria_caso"]=$data_caso->rowset["idcategoria"];                        
							$_REQUEST["estado"]=$data_caso->rowset["idestado"];
							$_REQUEST["municipio"]=$data_caso->rowset["idmunicipio"];
							$_REQUEST["parroquia"]=$data_caso->rowset["idparroquia"];
							$_REQUEST["descripcion_caso"]=$data_caso->rowset["descripcion_caso"];
							$_REQUEST["instruccion"]=$data_caso->rowset["instruccion"];
							$_REQUEST['idestatus']=$data_caso->rowset["idestatus"];

							if ($_REQUEST["instruccion"]=="1")  $_REQUEST["instruccion"]="checked";
							else $_REQUEST["instruccion"]="";

							if ($_REQUEST["idsolicitante"]==$_REQUEST["idbeneficiario"]) $_REQUEST["identico"]="checked";
							else $_REQUEST["identico"]="";

							mostrar_subcategorias($_REQUEST["tipo_caso"], $_REQUEST["categoria_caso"], $_REQUEST["idcaso"]);                   
							
							
						}

						if ($_REQUEST["accion"]=="consultar")   $_REQUEST["lectura"]="1";
						else $_REQUEST["lectura"]="0";

					}
				}

            ?>

<body onload="mostrar_combos('<?=$_REQUEST["idremitente"]?>')">
        <script src="../comunes/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>
        <center>

            <form name="frmcaso" id="frmcaso" method="post">
                <input type="hidden" id="idcaso" name="idcaso" value="<?= $_REQUEST['idcaso'] ?>">
                <input type="hidden" name="fecha_inicio" id="fecha_inicio"  value="<? echo $_REQUEST["fecha_inicio"];?>">
                <input type="hidden" id="accion" name="accion" value="<?= $_REQUEST['accion'] ?>">
                <input type="hidden" id="idestatus" name="idestatus" value="<?= $_REQUEST['idestatus'] ?>">
                <input type="hidden" id="idsolicitante" name="idsolicitante" value="<?= $_REQUEST['idsolicitante'] ?>">
                <input type="hidden" id="idbeneficiario" name="idbeneficiario" value="<?= $_REQUEST['idbeneficiario'] ?>">

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    
                    <tr>
                        <td width="65%" class="menu_izq_titulo"><img src="../comunes/imagenes/logo_form.gif" />
                        <?
                            if ($_REQUEST["idcaso"]>0)
                            {

                                $ninforme_comite=$ccaso->Count("informe_comite", "idcaso=".$_REQUEST["idcaso"]);
                                $ninforme_social=$ccaso->Count("informe_social", "idsolicitante=".$_REQUEST["idsolicitante"]);
                                
                                echo "Caso (N&deg; ".$_REQUEST["idcaso"]."  -  Estatus: ".$_REQUEST["sestatus_caso"].") ";
                            }
                            else
                            {
                                echo "Casos";
                            }
                        ?>

                        </td>
                        <td width="20%" align="center" class="menu_izq_titulo">

                        <?   if ($_REQUEST["accion"]!="consultar" && $_REQUEST["idestatus"]!=CERRADO)  {  ?>
                                <img src="../comunes/imagenes/16_save.gif" onmouseover="Tip('Guardar el Caso')" onmouseout="UnTip()" border="0" onclick="javascript:guardar()"/>
                        <? }  ?>
                        <?   if ($_REQUEST["idcaso"]>0)  {  ?>
                                <img src="../comunes/imagenes/18_settings.gif" onmouseover="Tip('Ver Seguimientos del Caso')" onmouseout="UnTip()" border="0" onclick="javascript:seguimiento()"/>
                        <? }
                            if ($_REQUEST["accion"]=="consultar")
                            {

                                if ($ninforme_comite>0){
                            ?>

                            <img src="../comunes/imagenes/report.png" onmouseover="Tip('Imprimir Informe del Comite')" onmouseout="UnTip()" border="0" onclick="javascript:imprimir_comite('<?=$_REQUEST["idcaso"]?>')"/>
                            <? }
                                if ($ninforme_social>0){
                            ?>
                            <img src="../comunes/imagenes/sitemap_color.png" onmouseover="Tip('Imprimir Informe Social')" onmouseout="UnTip()" border="0" onclick="javascript:imprimir_social('<?=$_REQUEST["idcaso"]?>')"/>
                            <?  }

                            } ?>

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

                            <table width="100%" border="1" class="tablaTitulo" >
                            <tr>
                                <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
                                        <strong>Datos del Solicitante</strong>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td width="1">&nbsp;</td>
                                <td width="95">&nbsp;</td>
                                <td width="176">&nbsp;</td>
                                <td width="89">&nbsp;</td>
                                <td width="199">&nbsp;</td>
                            </tr>

                                <tr>
                                   <td colspan="5">
                                       <div id="dvMensaje"></div>
                                   </td>
                                </tr>

                                <tr>
                                   <td colspan="5">
                                       <div align="left" id="dvsolicitante" style="margin-left: 5px;"></div>
                                   </td>
                                </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td colspan="2">
                                   <strong>Datos del Beneficiario es Id&eacute;ntico:</strong>
                                   <input type="checkbox" id="identico" name="identico" onmouseover="Tip('Seleccionar Sólo si los Datos del Solicitantes son Idénticos a los Datos del Beneficiario')"  onmouseout="UnTip()" <? echo $_REQUEST["identico"]; ?>  onchange="javascript:selec_instruccion(this)" value="1">
                                </td>
                                <td>&nbsp;
                                   
                                </td>
                                <td>&nbsp;       </td>
                            </tr>

                                <tr>
                                <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
                                        <strong>Datos del Beneficiario</strong>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td width="1">&nbsp;</td>
                                <td width="95">&nbsp;</td>
                                <td width="176">&nbsp;</td>
                                <td width="89">&nbsp;</td>
                                <td width="199">&nbsp;</td>
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
                                        <input name="cedula_benef" type="text" class="inputbox" id="cedula_benef" onkeypress="return CedulaFormat(this,'Cédula de Identidad Invalida',-1,true,event)" onmouseout="UnTip()" maxlength="12" value="<?= $_REQUEST['cedula_benef'] ?>" ></input>
                                    </label>
                                </td>
                                <td>
                                    <strong>R.I.F:</strong>
                                </td>
                                <td>
                                    <label>
                                        <input name="rif_benef" type="text" class="inputbox" id="rif_benef" onkeypress="return RifFormat(this,'Rif del Beneficiario Invalido',-1,true,event)" onmouseout="UnTip()" maxlength="12" value="<?= $_REQUEST['rif_benef'] ?>" ></input>
                                    </label>
                                </td>
                            </tr>
                            
                                 <tr>
                                <td width="1">&nbsp;</td>
                                <td width="95">
                                    <strong>Raz&oacute;n Social:</strong>
                                </td>
                                <td width="464" colspan="3">
                                    <label>
                                        <input name="razon_social_benef" type="text" class="inputbox" id="razon_social_benef" style="width:464px;" onkeypress="return validar_texto(this.form,this,event,'')" value="<?= $_REQUEST['razon_social_benef'] ?>"></input>
                                    </label>
                                </td>
                            </tr>
                            

                                <tr>
                                <td>&nbsp;</td>

                                <td>
                                    <strong>Telefono(s):</strong>
                                </td>
                                <td colspan="3">
                                    <input name="telefonos_benef" type="text" class="inputbox" id="telefonos_benef" onkeypress="return validar_telefono(this.form,this,event,'')" style="width:464px;" value="<?= $_REQUEST['telefonos_benef'] ?>">
                                </td>
                            </tr>


                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>Tipo de Beneficiario:</strong>
                                </td>
                                <td>
                                    <select name="tipo_beneficiario" id="tipo_beneficiario" style="width:160px;" class="inputbox">
                                    <option value>Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmaestro, descripcion from vtipo_solicitantes where estatus=1 order by descripcion", $_REQUEST["tipo_beneficiario"]));
                                    ?>
                                    </select>
                                </td>
                                <td>
                                    <strong>Correo Electr&oacute;nico:</strong>
                                </td>
                                <td>
                                    <input name="email_benef" type="text" class="inputbox" id="email_benef" onBlur="ValidarObjetos('email_benef','email');" value="<?= $_REQUEST['email_benef'] ?>"></input>
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Sexo:
                                    </strong>
                                </td>
                                <td>
                                    <label>
                                        <select name="sexo" id="sexo" style="width:160px;" class="inputbox">
                                            <option value="" <? if ($_REQUEST["sexo"]=="") echo "selected";   ?> >Seleccione...</option>
                                            <option value="M" <? if ($_REQUEST["sexo"]=="M") echo "selected";   ?>>Masculino</option>
                                            <option value="F" <? if ($_REQUEST["sexo"]=="F") echo "selected";   ?>>Femenino</option>
                                    </select>
                                    </label>
                                </td>
                                <td>
                                    <strong>Edad:</strong>
                                </td>
                                <td>
                                    <input name="edad" type="text" class="inputbox" id="edad" maxlength="2" value="<?= $_REQUEST['edad'] ?>">
                                </td>
                            </tr>


                                 <tr>
                                <td>&nbsp;</td>

                                <td>
                                    <strong>Comunidad:</strong>
                                </td>
                                <td colspan="3">
                                    <input name="comunidad_benef" type="text" class="inputbox" id="comunidad_benef"  onkeypress="return validar_texto(this.form,this,event,'')" style="width:464px;" value="<?= $_REQUEST['comunidad_benef'] ?>">
                                </td>
                            </tr>


                                <tr>
                                <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
                                        <strong>Datos Generales del Caso</strong>
                                    </div>
                                </td>
                            </tr>

                                  <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Fecha de Registro:
                                    </strong>
                                </td>
                                <td>

                                       <input class="inputbox_fecha" name="f_inicio"  id="f_inicio"  onchange="cambio_inicio();" value="<? echo $_REQUEST["fecha_inicio"];?>" size="10"   readonly="true" />
                                <a href="javascript:void(0)"  onclick="inicio();" hidefocus><img class="PopcalTrigger"  style="width:36px; height:19px;  margin-left:5px;" align="absbottom" src="../comunes/calendar/btn_dis_cal.gif"  border="0" alt="" /></a>
                                <!--  Calendario  -->
                                <iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../comunes/calendar/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
                                <!--  Calendario  -->


                                <strong style="font:bold xx-large; color: red;" >*</strong>
                                </td>
                                <td>
                                    <strong>Instrucci&oacute;n</strong>
                                </td>
                                <td>
                                    <input type="checkbox" id="instruccion" name="instruccion" value="1" <? echo $_REQUEST["instruccion"]; ?> > </input>
                                </td>
                            </tr>


                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>Remitente:</strong>
                                </td>
                                <td>
                                    <div id="capaRemitente">
                                        <select name="remitente" id="remitente" style="width:160px;" class="inputbox">
                                            <option value="0">Seleccione</option>
                                        </select>
                                        <a  href="javascript:nuevo_remitente()"><img src="../comunes/imagenes/ico_16_8.gif" onmouseover="Tip('Nuevo Remitente')" onmouseout="UnTip()" style="margin-left:5px; margin-right:5px;" width="16" height="16" border="0" /></a>
                                    </div>
                                </td>
                                <td>
                                    <strong>Responsable:</strong>
                                </td>
                                <td>
                                    <input name="responsable" type="text" class="inputbox" id="responsable" onkeypress="return validar_texto(this.form,this,event,'')" maxlength="80" value="<?= $_REQUEST['responsable'] ?>">
                                </td>
                            </tr>


                            <tr>
                                <td colspan="5">
                                    <div id="dvRemitente"></div>
                                </td>
                             </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>Tipo de Caso:</strong>
                                </td>
                                <td>
                                    <label>
                                    <select name="tipo_caso" id="tipo_caso" style="width:160px;" class="inputbox" >
                                    <option value>Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmaestro, descripcion from vtipos_casos order by descripcion", $_REQUEST["tipo_caso"]));
                                    ?>
                                    </select>
                                    </label>
                                    <strong style="font:bold xx-large; color: red;" >*</strong>
                                </td>
                                <td>
                                    <strong>Categor&iacute;a del Caso:</strong>
                                </td>
                                <td>
                                    <select name="categoria_caso" id="categoria_caso" style="width:160px;" class="inputbox" onchange="javascript:mostrar_subcateg()" >
                                    <option value>Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmaestro, descripcion from vcategorias_casos order by descripcion", $_REQUEST["categoria_caso"]));
                                    ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="3"><div id="dvSubcategoria"></div></td>
                            </tr>

                                <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Estado:
                                    </strong>
                                </td>
                                <td>
                                    <label>
                                    <select name="estado" id="estado" style="width:160px;" class="inputbox" onchange='cargaContenido_Estados(this.id)'>
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idestado, descripcion from estados order by descripcion", $_REQUEST["estado"]));
                                    ?>
                                    </select>
                                    </label>
                                </td>
                                <td>
                                    <strong>Municipio:</strong>
                                </td>
                                <td>
                                    <select name="municipio" id="municipio" style="width:160px;" class="inputbox" onchange='cargaContenido_Estados(this.id)'>
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmunicipio, descripcion from municipios where idestado=".$_REQUEST["estado"]." order by descripcion", $_REQUEST["municipio"]));
                                    ?>
                                    </select>
                                </td>
                            </tr>

                                <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Parroquia:
                                    </strong>
                                </td>
                                <td>
                                    <label>
                                       <select name="parroquia" id="parroquia" style="width:160px;" class="inputbox">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idparroquia, descripcion from parroquias where idmunicipio=".$_REQUEST["municipio"]." order by descripcion", $_REQUEST["parroquia"]));
                                    ?>
                                    </select>
                                    </label>
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>





                                <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Descripci&oacute;n del Caso:
                                    </strong>
                                    <strong  style="font:bold xx-large; color: red;" >*</strong>
                                </td>


                                <td colspan="3">
                                   <textarea name="descripcion_caso" id="descripcion_caso" rows="8" class="inputbox" onkeypress="return validar_texto(this.form,this,event,'descripcion_caso')"  style="width:466px; height:120px; margin-bottom:10px;" <?if($_REQUEST["lectura"]=="1"){echo"readonly='readonly'";}?>><?if(isset($_REQUEST["descripcion_caso"])){echo $_REQUEST["descripcion_caso"];}?></textarea>                                   
                                </td>

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