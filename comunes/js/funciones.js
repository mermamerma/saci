
function validar_num(form,field,evt,NextOb)
{
var key;
var keychar;






if (window.event)
   key = window.event.keyCode;
else if (evt)
   key = evt.which;
else
   return true;
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();

// control keys
if ((key==null) || (key==0) ||  (key==8) ||  (key==9) || (key==13) || (key==27) )


if (key==13)
{

	var next=0, found=false
var f=eval("document."+form.name);
if(evt.keyCode!=13) {





	return;
	}
if (NextOb!=""){
	eval("document."+form.name+"."+NextOb+".focus()");

	return;
}
for(var i=0;i<f.length;i++)	{
	if(field.name==f.elements[i].name){
		next=i+1;
		found=true
		break;
	}
}

while(found){
	if( f.elements[next].disabled==false &&  f.elements[next].type!='hidden'){
		f.elements[next].focus();

		break;
	}
	else{
		if(next<f.length-1)
			next=next+1;
		else
			break;
	}
}

	
	//alert('s');
}else
{

   return true;
}

else


if ((("0123456789").indexOf(keychar) > -1))



   return true;
else
   return false;






}

function fn_enter(form,field,evt,NextOb,accion)
{
	var next=0, found=false
	var f=eval("document."+form.name);
	if(evt.keyCode!=13)
	{
	return;
	}
	else
	{
	// formulario.oculto.value="validar";

		document.form1.submit();

	}
}


function validar_monto2(form,field,evt,NextOb)
{
var key;
var keychar;
var coma

if (window.event)
   key = window.event.keyCode;
else if (evt)
   key = evt.which;
else
   return true;
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();

// control keys
var  cam
var i
var cero
cam=field.value;
coma=0;
cero=0;

if (!cam)
{
	coma=1;
}
else
{
	if(cam[0]=='0')
	{
		cero=1;
	}
}

i=0;
while(cam[i])
{

if (cam[i]==',')
{
coma=1;
cero=0;
}

i=i+1;
}

if ((key==null) || (key==0) ||  (key==8) ||  (key==9) || (key==13) || (key==27) )


if (key==13)
{

	var next=0, found=false
var f=eval("document."+form.name);
if(evt.keyCode!=13) {
		return;
	}
if (NextOb!=""){


	eval("document."+form.name+"."+NextOb+".focus()");

	return;
}
for(var i=0;i<f.length;i++)	{
	if(field.name==f.elements[i].name){
		next=i+1;
		found=true
		break;
	}
}

while(found){
	if( f.elements[next].disabled==false &&  f.elements[next].type!='hidden'){
		f.elements[next].focus();

		break;
	}
	else{
		if(next<f.length-1)

			next=next+1;

		else



			break;
	}
}


	//alert('s');
}else
{
   return true;
}

else


if (((",").indexOf(keychar) > -1))
{
	if (coma==1)
	{
	return false;
	}else
	{

	  return(',');
	}

}

if((("0").indexOf(keychar) > -1))
{
if (cero==1)
{
	return false;
}else{
return true;
}
}

else{

if ((("123456789").indexOf(keychar) > -1))

	if (cero==1)
	{
	return false;
	}
	else{

   return true;
   }
else
   return false;

}

}

function validar_telefono(form,field,evt,NextOb)
{
    var key;
    var keychar;

    if (window.event)
       key = window.event.keyCode;
    else if (evt)
       key = evt.which;
    else
       return true;

    keychar = String.fromCharCode(key);
    keychar = keychar.toLowerCase();

    // control keys
    if ((key==null) || (key==0) ||  (key==8) ||  (key==9) || (key==13) || (key==27) )


    if (key==13)
    {
        
        var next=0, found=false
        var f=eval("document."+form.name);
        if(evt.keyCode!=13)
        {
            return;
        }

        if (NextOb!=""){
            eval("document."+form.name+"."+NextOb+".focus()");
            return;
        }
        for(var i=0;i<f.length;i++)
        {
            if(field.name==f.elements[i].name)
            {
                next=i+1;
                found=true
                break;
            }
        }

        while(found)
        {
            if( f.elements[next].disabled==false &&  f.elements[next].type!='hidden'){
                f.elements[next].focus();
                break;
            }
            else
            {
                if(next<f.length-1)
                    next=next+1;
                else
                    break;
            }
        }

    
        //alert('s');
    }else
    {

       return true;
    }

    else


    if ((("0123456789-()/; ").indexOf(keychar) > -1))

       return true;
    else
       return false;

}

function validar_texto(form,field,evt,NextOb)
{

var key;
var keychar;

if (window.event)
   key = window.event.keyCode;
else if (evt)
   key = evt.which;
else
   return true;

keychar = String.fromCharCode(key);
//keychar = keychar.toLowerCase();

// control keys
if ((key==null) || (key==0) ||  (key==8) ||  (key==9) || (key==13) || (key==27) )


if (key==13)
{
	var next=0, found=false
	var f=eval("document."+form.name);
		if(evt.keyCode!=13) {	return; }
			if (NextOb!="")
			{	eval("document."+form.name+"."+NextOb+".focus()");
				return;
			}

		for(var i=0;i<f.length;i++)	{
			if(field.name==f.elements[i].name)
			{
				next=i+1;
				found=true
				break;
			}
		}//for

	while(found)
	{
		if( f.elements[next].disabled==false &&  f.elements[next].type!='hidden')
		{
			f.elements[next].focus();
			break;
		}
		else
		{
			if(next<f.length-1)
				next=next+1;
			else
				break;
		}

	}//while

}else
{

   return true;
}

else


if (keychar.match(/^([A-Za-z0-9_@/().,;+{}%&$!��|#*-?]|\xC1|\xC9|\xCD|\xD3|\xDA|\xE1|\xE9|\xED|\xF3|\xFA|\xF1|\xD1|\s|\.)*$/g))
	return true;
else
	return false;

}

function acceptNum(evt){
    var nav4 = window.Event ? true : false;
    var key = nav4 ? evt.which : evt.keyCode;
    return (key <= 13 || (key >= 48 && key <= 57));
}

function formatearDecimal(cantDecimales, formInput){
    var ofrmcampo= formInput;
	if (cantDecimales > 0){
		var i=0;
		var aux=1;
		for (i = 0; i< cantDecimales; i++){
			aux= aux * 10;
		}
		numero = ofrmcampo.value * aux;
		numero = Math.round(numero);
		numero = numero/aux;
	}
    formInput.value= numero;
}
function NumCheck(e, field) {
    key = e.keyCode ? e.keyCode : e.which
    if (key == 8)
        return true
    if (key > 47 && key < 58) {
        if (field.value == "")
            return true
        regexp = /,[0-9]{2}$/
        return !(regexp.test(field.value))
    }
    if (key == 46) {
        if (field.value == "")
            return false
        regexp = /^[0-9]+$/
        return regexp.test(field.value)
    }
  return false
}
function validaSelect(formInput,campo){
     var resultado = true;
     var ofrmcampo = formInput;
     if(ofrmcampo.selectedIndex == 0 ){
         resultado = false;
     }
     if (!resultado ){
         alert('Por Favor seleccione una opcion para el campo ' + campo +'.');
         ofrmcampo.style.borderColor= 'Red';
         ofrmcampo.focus();
     }
    return resultado;
}
function campoRequerido(formInput,campo){
    var resultado = true;
	var ofrmcampo = formInput;
	if ((ofrmcampo.value == "") || (ofrmcampo.value.length == 0)){
        alert('Por favor introduzca un valor en ' + campo +'.');
		ofrmcampo.style.borderColor= 'Red';
         ofrmcampo.focus();
		resultado = false;
	}
	return resultado;
}
function setSelectInput(formInput,valor){
    var objSelect = formInput;
    for (var i=0;i<objSelect.length;i++){
        if(objSelect[i].value == valor){
            formInput[i].selected = true;
        }
    }
}
function setInputText(formInput,valor){
    formInput.value = valor;
}
function setHidden(frmhidden,valorhidden){
    var ofrmhidden = frmhidden;
    ofrmhidden.value = valorhidden;
}
function setRadioInput(formInput,valor){
    var objRadio = formInput;
    for (var i=0;i<objRadio.length;i++){
        if(objRadio[i].value == valor){
            formInput[i].checked = true;
        }
    }
}
function validarEditor(formInput, campo){
    var resultado = true;
    fckEditor1val = FCKeditorAPI.__Instances[formInput].GetHTML();
    fckEditor1val2 = fckEditor1val.stripTags();
    if(fckEditor1val2 == "" ){
        alert('Por favor introduzca el contenido del documento.');
        resultado = false;
	}
	return resultado;
}

function validarFirma(formInput, campo){
    var resultado = true;
    fckEditor1val = FCKeditorAPI.__Instances[formInput].GetHTML();
    fckEditor1val2 = fckEditor1val.stripTags();
    if(fckEditor1val2 == "" ){
        alert('Por favor introduzca la Firma.');
        resultado = false;
	}
	return resultado;
}

function validaLogin(formInput1, formInput2){
    var resultado = true;
	var ofrmcampo1 = formInput1;
    var ofrmcampo2 = formInput2;
	if (ofrmcampo1.value == 2){
        alert('Este login no esta disponible debe introducir otro login');
		ofrmcampo2.style.borderColor= 'Red';
        ofrmcampo2.focus();
		resultado = false;
	}else if (ofrmcampo1.value == ""){
        alert('Debe verificar si el login esta disponible');
        ofrmcampo2.focus();
		resultado = false;
    }
	return resultado;
}
function compararPassword(formInput1, formInput2){
    var resultado = true;
	var ofrmcampo1 = formInput1;
    var ofrmcampo2 = formInput2;
	if (ofrmcampo1.value != ofrmcampo2.value){
        alert('Los password no son iguales');
        ofrmcampo1.style.borderColor= 'Red';
		ofrmcampo2.style.borderColor= 'Red';
        ofrmcampo2.focus();
		resultado = false;
	}
	return resultado;
}
function validaLongitud(formInput,campo,cantidad){
	var resultado = true;
	var ofrmcampo = formInput;
	if (ofrmcampo.value.length >= cantidad){
		alert('Ha excedido la longitud maxima de caracteres para el campo ' + campo +'.');
		ofrmcampo.focus();
		resultado = false;
	}
	return resultado;
}

function campoAsunto(formInput,campo){
    var resultado = true;
	var ofrmcampo = formInput;
    ofrmcampo.value = ofrmcampo.value.replace(/^\s*|\s*$/g,"");
    var valor = ofrmcampo.value.toLowerCase();
	if (valor == "en el texto"){
        alert('Debe introducir un valor diferente en el ' + campo +'.');
		ofrmcampo.style.borderColor= 'Red';
        ofrmcampo.focus();
		resultado = false;
	}
	return resultado;
}

function passwordDiffZero(formInput){
    var resultado = true;
	var ofrmcampo = formInput;
	if ((ofrmcampo.value == "0000")){
        alert('Por favor introduzca un valor diferente de \'0000\'');
		ofrmcampo.style.borderColor= 'Red';
         ofrmcampo.focus();
		resultado = false;
	}
	return resultado;
}

function mueveReloj(im){
    var m="am";

    momentoActual = new Date();

    hora = momentoActual.getHours();

    minuto = momentoActual.getMinutes();

    segundo = momentoActual.getSeconds();



    if(hora==12){

        m="pm";

    }

    if(hora==13){

        hora="0"+1;

        m="pm";

    }

    if(hora==14){

        hora="0"+2;

        m="pm";

    }

    if(hora==15){

        hora="0"+3;

        m="pm";

    }

    if(hora==16){

        hora="0"+4;

        m="pm";

    }

    if(hora==17){

        hora="0"+5;

        m="pm";

    }

    if(hora==18){

        hora="0"+6;

        m="pm";

    }

    if(hora==19){

        hora="0"+7;

        m="pm";

    }

    if(hora==20){

        hora="0"+8;

        m="pm";

    }

    if(hora==21){

        hora="0"+9;

        M="pm";

    }

    if(hora==22){

        hora=10;

        m="pm";

    }

    if(hora==23){

        hora=11;

        m="pm";

    }

    if((hora==0)||(hora==24)){

        hora=12;

        m="am";

    }



    str_segundo = new String (segundo)

    if (str_segundo.length == 1)

        segundo = "0" + segundo;



    str_minuto = new String (minuto)

    if (str_minuto.length == 1)

        minuto = "0" + minuto;



    str_hora = new String (hora)

    if (str_hora.length == 1)

        hora = "0" + hora;



    horaImprimible = hora + ":" + minuto + ":" + segundo+" "+m;



    if (im==1){

        //document.getElementById('reloj').innerHTML = "<img src='imagenes/design/flag_ve.gif'>&nbsp;&nbsp;" + horaImprimible;

        document.getElementById('reloj').innerHTML = horaImprimible;

        setTimeout("mueveReloj(1)",1000);

    }

    else{

        document.getElementById('reloj').innerHTML = horaImprimible;

        setTimeout("mueveReloj(0)",1000);

    }





}



//********************************************/

// ajax para combos dependientes

function nuevoAjax()
{
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try
	{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp;
}

function buscarEnArray(array, dato)
{
	// Retorna el indice de la posicion donde se encuentra el elemento en el array o null si no se encuentra
	var x=0;
	while(array[x])
	{
		if(array[x]==dato) return x;
		x++;
	}
	return null;
}



// Declaro los selects que componen el documento HTML. Su atributo ID debe figurar aqui.
var listadoSelects_estados=new Array();
listadoSelects_estados[0]="estado";
listadoSelects_estados[1]="municipio";
listadoSelects_estados[2]="parroquia";

function cargaContenido_Estados(idSelectOrigen)
{

	// Obtengo la posicion que ocupa el select que debe ser cargado en el array declarado mas arriba
	var posicionSelectDestino=buscarEnArray(listadoSelects_estados, idSelectOrigen)+1;
	// Obtengo el select que el usuario modifico
	var selectOrigen=document.getElementById(idSelectOrigen);
	// Obtengo la opcion que el usuario selecciono
	var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
	// Si el usuario eligio la opcion "Elige", no voy al servidor y pongo los selects siguientes en estado "Selecciona opcion..."
	if(opcionSeleccionada==0)
	{
		var x=posicionSelectDestino, selectActual=null;
		// Busco todos los selects siguientes al que inicio el evento onChange y les cambio el estado y deshabilito
		while(listadoSelects_estados[x])
		{
			selectActual=document.getElementById(listadoSelects_estados[x]);
			selectActual.length=0;

			var nuevaOpcion=document.createElement("option"); nuevaOpcion.value=0; nuevaOpcion.innerHTML="Seleccione ...";
			selectActual.appendChild(nuevaOpcion);	selectActual.disabled=true;
			x++;
		}
	}
	// Compruebo que el select modificado no sea el ultimo de la cadena
	else if(idSelectOrigen!=listadoSelects_estados[listadoSelects_estados.length-1])
	{
		// Obtengo el elemento del select que debo cargar
		var idSelectDestino=listadoSelects_estados[posicionSelectDestino];
		var selectDestino=document.getElementById(idSelectDestino);
		// Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=nuevoAjax();
		ajax.open("GET", "../librerias/jx_edo_mcpo_parr.php?select="+idSelectDestino+"&opcion="+opcionSeleccionada, true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==1)
			{
				// Mientras carga elimino la opcion "Selecciona Opcion..." y pongo una que dice "Cargando..."
				selectDestino.length=0;
				var nuevaOpcion=document.createElement("option"); nuevaOpcion.value=0; nuevaOpcion.innerHTML="Cargando...";
				selectDestino.appendChild(nuevaOpcion); selectDestino.disabled=true;
			}
			if (ajax.readyState==4)
			{
				selectDestino.parentNode.innerHTML=ajax.responseText;
			}
		}
		ajax.send(null);
	}
}


// Declaro los selects que componen el documento HTML. Su atributo ID debe figurar aqui.
var listadoSelects_categoria=new Array();
listadoSelects_categoria[0]="tipo_caso";
listadoSelects_categoria[1]="categoria";
listadoSelects_categoria[2]="subcategoria";

function cargaContenido_Categoria(idSelectOrigen)
{
    
	// Obtengo la posicion que ocupa el select que debe ser cargado en el array declarado mas arriba
	var posicionSelectDestino=buscarEnArray(listadoSelects_categoria, idSelectOrigen)+1;

	// Obtengo el select que el usuario modifico
	var selectOrigen=document.getElementById(idSelectOrigen);
	// Obtengo la opcion que el usuario selecciono
	var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
	// Si el usuario eligio la opcion "Elige", no voy al servidor y pongo los selects siguientes en estado "Selecciona opcion..."
	if(opcionSeleccionada==0)
	{
		var x=posicionSelectDestino, selectActual=null;
		// Busco todos los selects siguientes al que inicio el evento onChange y les cambio el estado y deshabilito
		while(listadoSelects_categoria[x])
		{
			selectActual=document.getElementById(listadoSelects_categoria[x]);
			selectActual.length=0;

			var nuevaOpcion=document.createElement("option"); nuevaOpcion.value=0; nuevaOpcion.innerHTML="Seleccione ...";
			selectActual.appendChild(nuevaOpcion);	selectActual.disabled=true;
			x++;
		}
	}
	// Compruebo que el select modificado no sea el ultimo de la cadena
	else if(idSelectOrigen!=listadoSelects_categoria[listadoSelects_categoria.length-1])
	{
            
		// Obtengo el elemento del select que debo cargar
		var idSelectDestino=listadoSelects_categoria[posicionSelectDestino];
                
		var selectDestino=document.getElementById(idSelectDestino);
                
		// Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=nuevoAjax();
		ajax.open("GET", "../librerias/jx_categoria_subcateg.php?select="+idSelectDestino+"&opcion="+opcionSeleccionada, true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==1)
			{
				// Mientras carga elimino la opcion "Selecciona Opcion..." y pongo una que dice "Cargando..."
				selectDestino.length=0;
				var nuevaOpcion=document.createElement("option"); nuevaOpcion.value=0; nuevaOpcion.innerHTML="Cargando...";
				selectDestino.appendChild(nuevaOpcion); selectDestino.disabled=true;
			}
			if (ajax.readyState==4)
			{
				selectDestino.parentNode.innerHTML=ajax.responseText;
			}
		}
		ajax.send(null);
	}
}