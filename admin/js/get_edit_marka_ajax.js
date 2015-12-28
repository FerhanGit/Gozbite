var httpReq;
var targetObj;

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

function getModel(dObj, chsdVl) {
   detailsObj      = document.getElementById(dObj);
   
   if((chsdVl > 0) || (chsdVl == -1)) {
     
      httpReq = createRequestObject();
      var aParams = new Array();
      var sParam = encodeURIComponent("markaID");
      sParam += "=";
      sParam += encodeURIComponent(chsdVl);
      aParams.push(sParam);

     
      sBody = aParams.join("&");
      url = "edit_marka_model/get_edit_model.php";
      httpReq.open("POST", url, true);
      httpReq.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      httpReq.onreadystatechange = handleResponseModel;
      httpReq.send(sBody); 
      
   }
}



function checkReadyState() {
   if(httpReq.readyState < 4) {
   } else if(httpReq.readyState == 4) {
      return (httpReq.status == 200);
   }
}

function handleResponseModel() {
   if(checkReadyState()) {
      if(httpReq.responseText) {
         detailsObj.innerHTML = httpReq.responseText;
        
        
      }
   }
}