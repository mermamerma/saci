		function GetXmlHttpObject(handler)
		{ 
		var objXmlHttp=null
		
		if (navigator.userAgent.indexOf("Opera")>=0)
		{
		alert("El Sistema no Esta Optimizado para el Explorador Opera") 
		return 
		}
		if (navigator.userAgent.indexOf("MSIE")>=0)
		{ 
		var strName="Msxml2.XMLHTTP"
		if (navigator.appVersion.indexOf("MSIE 5.5")>=0)
		{
		strName="Microsoft.XMLHTTP"
		} 
		try
		{ 
		objXmlHttp=new ActiveXObject(strName)
		objXmlHttp.onreadystatechange=handler 
		return objXmlHttp
		} 	
		catch(e)
		{ 
		alert("Error. los Script ActiveX estan Deshabilitados") 
		return 
		} 
		} 
		if (navigator.userAgent.indexOf("Mozilla")>=0)
		{
		objXmlHttp=new XMLHttpRequest()
		objXmlHttp.onload=handler
		objXmlHttp.onerror=handler 
		return objXmlHttp
		}
		}

		var url = "../librerias/cgrid_maestro.php?param="; // The server-side scripts	
		
		function getagents(column,direc) {		
				var myRandom=parseInt(Math.random()*99999999);  // cache buster
				xmlHttp=GetXmlHttpObject(handleHttpResponse);
				xmlHttp.open("GET",url + escape(column) + "&mode=list&dir=" + direc + "&rand=" + myRandom, true);
				xmlHttp.send(null);
		}
		
		function saveRecord(mode,id,param,dir)
		{
			cod = document.getElementById("codigo").value;
			descripcion = document.getElementById("descripcion").value;
			alias = document.getElementById("alias").value;

			if ( descripcion.length == 0 ) 
			{
				alert("Por Favor Introduzca la Descripción del Registro");
				
			}
			else if ( alias.length == 0 ) 
			{
				alert("Por Favor Introduzca el alias del Registro");
				
			}
			else
			{
				var myRandom=parseInt(Math.random()*99999999);  // cache buster
				xmlHttp=GetXmlHttpObject(handleHttpResponse);
				xmlHttp.open("GET","../librerias/cgrid_maestro.php?codigo="+cod+"&descripcion="+descripcion+"&alias="+alias+"&mode="+mode+"&param=" + escape(param) + "&dir=" + dir + "&rand=" + myRandom, true);
				xmlHttp.send(null);
			}
		}
		
		function saveNewRecord(mode,param,dir)
		{
			descripcion = document.getElementById("descripcion").value;
			alias = document.getElementById("alias").value;
	
			if ( descripcion.length == 0 ) 
			{
				alert("Por Favor Introduzca la Descripción del Registro");				
			}
			else if (alias.length == 0 ) 
			{
				alert("Por Favor Introduzca el Alias del Registro");				
			}
			else
			{
					var myRandom=parseInt(Math.random()*99999999);  // cache buster
					xmlHttp=GetXmlHttpObject(handleHttpResponse);
					xmlHttp.open("GET","../librerias/cgrid_maestro.php?descripcion="+descripcion+"&alias="+alias+"&mode="+mode+"&param=" + escape(param) + "&dir=" + dir + "&rand=" + myRandom, true);
					xmlHttp.send(null);			
			}
			
		}
		
		function newRecord(mode,param,dir)
		{
				var myRandom=parseInt(Math.random()*99999999);  // cache buster
				xmlHttp=GetXmlHttpObject(handleHttpResponse);
				xmlHttp.open("GET","../librerias/cgrid_maestro.php?mode="+mode+"&param=" + escape(param) + "&dir=" + dir + "&rand=" + myRandom, true);
				xmlHttp.send(null);
		}
		
		function manipulateRecord(mode,id,param,dir)
		{
			var tipo="";
			if (mode=="update") tipo="Actualizar";
			if (mode=="delete") tipo="Eliminar";
			
			if ( confirm("Esta Seguro que Desea "+tipo+" el Registro ?") != 1 )
			{
				return false;	
			}	

				var myRandom=parseInt(Math.random()*99999999);  // cache buster
				xmlHttp=GetXmlHttpObject(handleHttpResponse);
				xmlHttp.open("GET","../librerias/cgrid_maestro.php?id="+id+"&mode="+mode+"&param=" + escape(param) + "&dir=" + dir + "&rand=" + myRandom, true);
				xmlHttp.send(null);
		}	
		
		
		function handleHttpResponse() {
			if (xmlHttp.readyState == 4) {
			  document.getElementById("hiddenDIV").style.visibility="visible"; 		
			  document.getElementById("hiddenDIV").innerHTML='';
			  document.getElementById("hiddenDIV").innerHTML=xmlHttp.responseText;
			  }
		}