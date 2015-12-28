function selectAllQuarters(SELECT)
{ 
	 for (var n=0; n < document.itemform.length; n++)
	 if (document.itemform.elements[n].type=='checkbox')
	 {
	 	 if (document.itemform.elements[n].name=='offerChck[]')
		 {	
		 	document.itemform.elements[n].checked=SELECT;  
		 		 
		 }
	 }
	
			
}


var defsize=14;
function newsFsize(inc){
	var objText = document.getElementById("newsDiv");
	var objTextBody = document.getElementById("newsBodyDiv");
	var objTextComment = document.getElementById("readComment");
	defsize = defsize - (-inc);
	fsz=defsize;
	var nsz;
	nsz = defsize
	if(nsz<6){
		nsz = 6;
		defsize=6;
	}
	if(nsz>32){
		nsz = 32;
		defsize=32;
	}
	nsz=nsz+"px";
	
	objText.style.fontSize = nsz;
	objTextBody.style.fontSize = nsz;
	objTextComment.style.fontSize = nsz;
}
function newsFsize_d(){
	defsize=14;
	var objText = document.getElementById("newsDiv");
	var objTextBody = document.getElementById("newsBodyDiv");
	var objTextComment = document.getElementById("readComment");
	objText.style.fontSize = "14px";
	objTextBody.style.fontSize = "14px";
	objTextComment.style.fontSize = "14px";
}




function postsFsize(inc){
	var objText = document.getElementById("postDiv");
	var objTextBody = document.getElementById("postBodyDiv");
	var objTextComment = document.getElementById("readComment");
	defsize = defsize - (-inc);
	fsz=defsize;
	var nsz;
	nsz = defsize
	if(nsz<6){
		nsz = 6;
		defsize=6;
	}
	if(nsz>32){
		nsz = 32;
		defsize=32;
	}
	nsz=nsz+"px";
	
	objText.style.fontSize = nsz;
	objTextBody.style.fontSize = nsz;
	objTextComment.style.fontSize = nsz;
}
function postsFsize_d(){
	defsize=14;
	var objText = document.getElementById("postDiv");
	var objTextBody = document.getElementById("postBodyDiv");
	var objTextComment = document.getElementById("readComment");
	objText.style.fontSize = "14px";
	objTextBody.style.fontSize = "14px";
	objTextComment.style.fontSize = "14px";
}




function hospitalsFsize(inc){
	var objText = document.getElementById("hospitalDiv");
	var objTextBody = document.getElementById("hospitalBodyDiv");
	var objTextComment = document.getElementById("readComment");
	defsize = defsize - (-inc);
	fsz=defsize;
	var nsz;
	nsz = defsize
	if(nsz<6){
		nsz = 6;
		defsize=6;
	}
	if(nsz>32){
		nsz = 32;
		defsize=32;
	}
	nsz=nsz+"px";
	
	objText.style.fontSize = nsz;
	objTextBody.style.fontSize = nsz;
	objTextComment.style.fontSize = nsz;
}
function hospitalsFsize_d(){
	defsize=14;
	var objText = document.getElementById("hospitalDiv");
	var objTextBody = document.getElementById("hospitalBodyDiv");
	var objTextComment = document.getElementById("readComment");
	objText.style.fontSize = "14px";
	objTextBody.style.fontSize = "14px";
	objTextComment.style.fontSize = "14px";
}






function doctorsFsize(inc){
	var objText = document.getElementById("doctorDiv");
	var objTextBody = document.getElementById("doctorBodyDiv");
	var objTextComment = document.getElementById("readComment");
	defsize = defsize - (-inc);
	fsz=defsize;
	var nsz;
	nsz = defsize
	if(nsz<6){
		nsz = 6;
		defsize=6;
	}
	if(nsz>32){
		nsz = 32;
		defsize=32;
	}
	nsz=nsz+"px";
	
	objText.style.fontSize = nsz;
	objTextBody.style.fontSize = nsz;
	objTextComment.style.fontSize = nsz;
}
function doctorsFsize_d(){
	defsize=14;
	var objText = document.getElementById("doctorDiv");
	var objTextBody = document.getElementById("doctorBodyDiv");
	var objTextComment = document.getElementById("readComment");
	objText.style.fontSize = "14px";
	objTextBody.style.fontSize = "14px";
	objTextComment.style.fontSize = "14px";
}





function bolestiFsize(inc){
	var objText = document.getElementById("bolestiDiv");
	var objTextBody = document.getElementById("bolestiBodyDiv");
	var objTextComment = document.getElementById("readComment");
	defsize = defsize - (-inc);
	fsz=defsize;
	var nsz;
	nsz = defsize
	if(nsz<6){
		nsz = 6;
		defsize=6;
	}
	if(nsz>32){
		nsz = 32;
		defsize=32;
	}
	nsz=nsz+"px";
	
	objText.style.fontSize = nsz;
	objTextBody.style.fontSize = nsz;
	objTextComment.style.fontSize = nsz;
}
function bolestiFsize_d(){
	defsize=14;
	var objText = document.getElementById("bolestiDiv");
	var objTextBody = document.getElementById("bolestiBodyDiv");
	var objTextComment = document.getElementById("readComment");
	objText.style.fontSize = "14px";
	objTextBody.style.fontSize = "14px";
	objTextComment.style.fontSize = "14px";
}



