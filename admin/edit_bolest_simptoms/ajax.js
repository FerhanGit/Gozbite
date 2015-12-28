		function GetXmlHttpObject(handler)
		{ 
		var objXmlHttp=null
		
		if (navigator.userAgent.indexOf("Opera")>=0)
		{
		alert("This example doesn't work in Opera") 
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
		alert("Error. Scripting for ActiveX might be disabled") 
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

		var url = "getagents.php?param="; // The server-side scripts	
		
		function getagents(column,direc) {		
				var myRandom=parseInt(Math.random()*99999999);  // cache buster
				xmlHttp=GetXmlHttpObject(handleHttpResponse);
				xmlHttp.open("GET",url + escape(column) + "&mode=list&dir=" + direc + "&rand=" + myRandom, true);
				xmlHttp.send(null);
				
		}
		
		function saveRecord(mode,id,param,dir)
		{
			id = document.getElementById("txtId").value;
			name = document.getElementById("txtName").value;
			
				var myRandom=parseInt(Math.random()*99999999);  // cache buster
				xmlHttp=GetXmlHttpObject(handleHttpResponse);
				xmlHttp.open("GET","getagents.php?id="+id+"&name="+name+"&mode="+mode+"&param=" + escape(param) + "&dir=" + dir + "&rand=" + myRandom, true);
				xmlHttp.send(null);
		}
		
		function saveNewRecord(mode,param,dir)
		{
			//id = document.getElementById("txtId").value;
			
			name = document.getElementById("txtName").value;
			
	
		if ( name.length == 0 ) 
		{
			alert("Please enter value for all the fields");
			
		}
		else
		{
				var myRandom=parseInt(Math.random()*99999999);  // cache buster
				xmlHttp=GetXmlHttpObject(handleHttpResponse);
				xmlHttp.open("GET","getagents.php?name="+name+"&mode="+mode+"&param=" + escape(param) + "&dir=" + dir + "&rand=" + myRandom, true);
				xmlHttp.send(null);			
		}
		}
		
		function newRecord(mode,param,dir)
		{
				var myRandom=parseInt(Math.random()*99999999);  // cache buster
				xmlHttp=GetXmlHttpObject(handleHttpResponse);
				xmlHttp.open("GET","getagents.php?mode="+mode+"&param=" + escape(param) + "&dir=" + dir + "&rand=" + myRandom, true);
				xmlHttp.send(null);
		}
		
		function manipulateRecord(mode,id,param,dir)
		{
		if ( confirm("Are you sure you want to "+mode+" record ?") != 1 )
		{
			return false;	
		}	

				var myRandom=parseInt(Math.random()*99999999);  // cache buster
				xmlHttp=GetXmlHttpObject(handleHttpResponse);
				xmlHttp.open("GET","getagents.php?id="+id+"&mode="+mode+"&param=" + escape(param) + "&dir=" + dir + "&rand=" + myRandom, true);
				xmlHttp.send(null);
		}	
		
		
		function handleHttpResponse() {
			if (xmlHttp.readyState == 4) {
			  document.getElementById("hiddenDIV").style.visibility="visible"; 		
			  document.getElementById("hiddenDIV").innerHTML='';
			  document.getElementById("hiddenDIV").innerHTML=xmlHttp.responseText;
			  }
		}