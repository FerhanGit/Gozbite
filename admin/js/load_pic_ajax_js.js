var httpReq;
var targetObj;
var msgsObj;
var oTdName;
var oTdValType;

function createRequestObject() {
   var ro;

   if (window.XMLHttpRequest) {
      ro = new XMLHttpRequest();
   } else {
      if (window.ActiveXObject) {
         ro = new ActiveXObject("Microsoft.XMLHTTP");
      }
   }
   return ro;
}

function get_pic(dObj, chsdVl) {
	
	  detailsObj = document.getElementById(dObj);
     
      httpReq = createRequestObject();
      var aParams = new Array();
      var sParam = encodeURIComponent("srcID");
      sParam += "=";
      sParam += encodeURIComponent(chsdVl);
      aParams.push(sParam);

    
      sBody = aParams.join("&");
      url = "load_pic.php";
      httpReq.open("POST", url, true);
      httpReq.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      httpReq.onreadystatechange = handleResponsePic;
      httpReq.send(sBody);
      
     
}



function checkReadyState() {
   if(httpReq.readyState < 4) {
     
   } else if(httpReq.readyState == 4) {
      
      return (httpReq.status == 200);
   }
}

function handleResponsePic() {
   if(checkReadyState()) {
      if(httpReq.responseText) {
         detailsObj.innerHTML = httpReq.responseText;
       
       
      }
   }
}