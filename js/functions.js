function selectAllSimptoms(SELECT)
{ 
	i = 0;
    while(document.getElementById('bolest_simptom'+i)) {         
		 document.getElementById('bolest_simptom'+i).checked = SELECT;           
         i++;
    }
}


var defsize=14;
function postsFsize(inc){
	//var objText = document.getElementById("postDiv");
	var objTextBody = document.getElementById("postBodyDiv");
	var objTextComment = document.getElementById("readComments");
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
	
	//objText.style.fontSize = nsz;
	objTextBody.style.fontSize = nsz;
	objTextComment.style.fontSize = nsz;
}
function postsFsize_d(){
	defsize=14;
	//var objText = document.getElementById("postDiv");
	var objTextBody = document.getElementById("postBodyDiv");
	var objTextComment = document.getElementById("readComments");
	//objText.style.fontSize = "12px";
	objTextBody.style.fontSize = "14px";
	objTextComment.style.fontSize = "14px";
}





function firmsFsize(inc){
	//var objText = document.getElementById("firmDiv");
	var objTextBody = document.getElementById("firmBodyDiv");
	var objTextComment = document.getElementById("readComments");
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
	
	//objText.style.fontSize = nsz;
	objTextBody.style.fontSize = nsz;
	objTextComment.style.fontSize = nsz;
}
function firmsFsize_d(){
	defsize=14;
	//var objText = document.getElementById("firmDiv");
	var objTextBody = document.getElementById("firmBodyDiv");
	var objTextComment = document.getElementById("readComments");
	//objText.style.fontSize = "14px";
	objTextBody.style.fontSize = "14px";
	objTextComment.style.fontSize = "14px";
}







function locationsFsize(inc){
	//var objText = document.getElementById("firmDiv");
	var objTextBody = document.getElementById("locationBodyDiv");
	var objTextComment = document.getElementById("readComments");
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
	
	//objText.style.fontSize = nsz;
	objTextBody.style.fontSize = nsz;
	objTextComment.style.fontSize = nsz;
}
function locationsFsize_d(){
	defsize=14;
	//var objText = document.getElementById("firmDiv");
	var objTextBody = document.getElementById("locationBodyDiv");
	var objTextComment = document.getElementById("readComments");
	//objText.style.fontSize = "14px";
	objTextBody.style.fontSize = "14px";
	objTextComment.style.fontSize = "14px";
}






function questionFsize(inc){
	//var objText = document.getElementById("questionDiv");
	var objTextBody = document.getElementById("questionBodyDiv");
	var objTextComment = document.getElementById("readComments");
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
	
	//objText.style.fontSize = nsz;
	objTextBody.style.fontSize = nsz;
	objTextComment.style.fontSize = nsz;
}
function questionFsize_d(){
	defsize=14;
	//var objText = document.getElementById("questionDiv");
	var objTextBody = document.getElementById("questionBodyDiv");
	var objTextComment = document.getElementById("readComments");
	//objText.style.fontSize = "12px";
	objTextBody.style.fontSize = "14px";
	objTextComment.style.fontSize = "14px";
}






function bolestiFsize(inc){
	//var objText = document.getElementById("bolestiDiv");
	var objTextBody = document.getElementById("bolestiBodyDiv");
	var objTextComment = document.getElementById("readComments");
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
	
	//objText.style.fontSize = nsz;
	objTextBody.style.fontSize = nsz;
	objTextComment.style.fontSize = nsz;
}
function bolestiFsize_d(){
	defsize=16;
	//var objText = document.getElementById("bolestiDiv");
	var objTextBody = document.getElementById("bolestiBodyDiv");
	var objTextComment = document.getElementById("readComments");
	//objText.style.fontSize = "12px";
	objTextBody.style.fontSize = "16px";
	objTextComment.style.fontSize = "16px";
}






function selectselected (fromSelObj, toSelObj) {
var fromlength = fromSelObj.options.length;
var tolength = toSelObj.options.length;
for (var i = 0; i < fromlength; i++) {
if (fromSelObj.options[i].selected) {
// check if it doesn't already exists in the target
var exists = false;
for (var j = 0; j < tolength; j++) {
if (toSelObj.options[j].value == fromSelObj.options[i].value) {
exists = true;
}
}
if (!exists) { 
var newOption = new Option(fromSelObj.options[i].text, fromSelObj.options[i].value);
toSelObj.options.add(newOption, toSelObj.options.selectedIndex);
}
}
}

}



function getSelectedSimptoms () {
	var selObj = document.getElementById('bolest_simptom');
	var tolength = selObj.options.length;
	j = 0;
    slctd = new Array();
    for (var i = 0; i < tolength; i++) {
	   if (selObj.options[i].selected) {
	        slctd[j] = selObj.options[i].value;
	        j++
	    }     
   }

   if(slctd.length > 0)
      return slctd.join(",");
   else
      return "";
   
   
}



function removeselected (selObj) {
var tolength = selObj.options.length;
for (var i = 0; i < tolength; i++) {
if (selObj.options[i].selected) {
selObj.remove(i);
}
}
}

function selectall (fromSelObj, toSelObj) {
toSelObj.options.length = 0;
fromlength = fromSelObj.options.length;
for (var i = 0; i < fromlength; i++) {
toSelObj.options[toSelObj.options.length] = new Option(fromSelObj.options[i].text, fromSelObj.options[i].value) ;
}
}

function removeall (selObj) {
selObj.options.length = 0;
}


function move(selObj, direction) {
	var newindex = 0;
	var index = selObj.options.selectedIndex;
	if (index > -1) {
	switch(direction){
	case "up":
	newindex = (index>0)?index-1:0;break;
	case "down":
	newindex = (index<(selObj.options.length-1))?(index+1):index;break;
	case "top":
	newindex = 0;break;
	case "down":
	newindex = selObj.options.length-1;break;
	}
	var tempVal = selObj.options[newindex].value;
	var tempTxt = selObj.options[newindex].text;
	selObj.options[newindex].text = selObj.options[index].text
	selObj.options[newindex].value = selObj.options[index].value;
	selObj.options[index].text = tempTxt;
	selObj.options[index].value = tempVal;
	selObj.options[index].selected = false;
	selObj.options[newindex].selected = true;
	}
}
function selectAllOptions(SELECT_NAME)
{ 	  i = 0;
	  var tolength2 = SELECT_NAME.options.length;	  
	  for (var i = 0; i < tolength2; i++) {
		//  alert('vvs'+SELECT_NAME.options.length);
		  SELECT_NAME.options[i].selected = true; 
	  }      
}


function update_footer_overlay_div_Content(file_name)
{
	new Ajax.Updater('footer_overlay_div_Content', 'includes/tools/ajax_footer_overlay_load.php?file_name='+file_name, {
		  method: 'get',onSuccess: function() {
	                    //   new Effect.Opacity('SubCatsDiv', {duration: 1.0, from:0.3, to:1.0});
		  }
	});		
	
}

function set_active_region(str, id, is_city, txt_x, txt_y) {
	//alert(str);
	document.getElementById('choosed_from_map').value = str;
	document.searchform.map_str.value = str;
	document.getElementById('citiesOrRegions').value = (is_city) ? 1 : 2;
	document.getElementById('ctsRgnsID').value = id;
	document.getElementById('txt_x').value = txt_x;
	document.getElementById('txt_y').value = txt_y;
}


function getFastSearchAphorisms(aphorism_body,fromDate,toDate)
{
	jQuery.ajax({
	  	type: "GET",
  		url: 'includes/tools/Ajax_Fast_Search.php?pg_current=aphorisms&aphorism_body='+aphorism_body+'&fromDate='+fromDate+'&toDate='+toDate
	 }).done(function(data) {
	 	jQuery("#fastSearchDiv").html(data);	
	 	jQuery('#fastSearchDiv').animate({
		    opacity: 0.85
		  }, 1000, function() {
		    // Animation complete.
		  });	 		 		 	
	 });
	 										
}


function getFastSearchPosts(post_category,post_body,fromDate,toDate)
{
	jQuery.ajax({
	  	type: "GET",
  		url: 'includes/tools/Ajax_Fast_Search.php?pg_current=posts&post_category='+post_category+'&post_body='+post_body+'&fromDate='+fromDate+'&toDate='+toDate
	 }).done(function(data) {
	 	jQuery("#fastSearchDiv").html(data);	
	 	jQuery('#fastSearchDiv').animate({
		    opacity: 0.85
		  }, 1000, function() {
		    // Animation complete.
		  });	 		 		 	
	 });	 	 									
}


function getFastSearchQuestions(question_category,question_body,fromDate,toDate)
{
	jQuery.ajax({
	  	type: "GET",
  		url: 'includes/tools/Ajax_Fast_Search.php?pg_current=forums&question_category='+question_category+'&question_body='+question_body+'&fromDate='+fromDate+'&toDate='+toDate
	 }).done(function(data) {
	 	jQuery("#fastSearchDiv").html(data);	
	 	jQuery('#fastSearchDiv').animate({
		    opacity: 0.85
		  }, 1000, function() {
		    // Animation complete.
		  });	 		 		 	
	 });									
}


function getFastSearchDrinks(drink_category,title)
{
	jQuery.ajax({
	  	type: "GET",
  		url: 'includes/tools/Ajax_Fast_Search.php?pg_current=drinks&drink_category='+drink_category+'&title='+title
	 }).done(function(data) {
	 	jQuery("#fastSearchDiv").html(data);	
	 	jQuery('#fastSearchDiv').animate({
		    opacity: 0.85
		  }, 1000, function() {
		    // Animation complete.
		  });	 		 		 	
	 });									
}

function getFastSearchRecipes(recipe_category,title,kuhnq)
{
	jQuery.ajax({
	  	type: "GET",
  		url: 'includes/tools/Ajax_Fast_Search.php?pg_current=recipes&recipe_category='+recipe_category+'&title='+title+'&kuhnq='+kuhnq
	 }).done(function(data) {
	 	jQuery("#fastSearchDiv").html(data);	
	 	jQuery('#fastSearchDiv').animate({
		    opacity: 0.85
		  }, 1000, function() {
		    // Animation complete.
		  });	 		 		 	
	 });									
}

function getFastSearchFirms(firm_category,firm_name,manager,phone,email,cityName,description)
{
	jQuery.ajax({
	  	type: "GET",
  		url: 'includes/tools/Ajax_Fast_Search.php?pg_current=firms&firm_category='+firm_category+'&firm_name='+firm_name+'&manager='+manager+'&phone='+phone+'&email='+email+'&cityName='+cityName+'&description='+description
	 }).done(function(data) {
	 	jQuery("#fastSearchDiv").html(data);	
	 	jQuery('#fastSearchDiv').animate({
		    opacity: 0.85
		  }, 1000, function() {
		    // Animation complete.
		  });	 		 		 	
	 });								
}
	
	
function getFastSearchBolesti(bolest_category,bolest_body,simptoms)
{
	jQuery.ajax({
	  	type: "GET",
  		url: 'includes/tools/Ajax_Fast_Search.php?pg_current=bolesti&bolest_category='+bolest_category+'&bolest_body='+bolest_body+'&bolest_simptom='+simptoms
	 }).done(function(data) {
	 	jQuery("#fastSearchDiv").html(data);	
	 	jQuery('#fastSearchDiv').animate({
		    opacity: 0.85
		  }, 1000, function() {
		    // Animation complete.
		  });	 		 		 	
	 });									
}

/***********************************************
* Textarea Maxlength script- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

function ismaxlength(obj)
{
	var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
	if (obj.getAttribute && obj.value.length>mlength)
	obj.value=obj.value.substring(0,mlength)
}
    






function checkForCorrectDataKuhni() 
{
    theForm = document.searchform;
    
         
     if(theForm.name.value.length == 0) {
       alert('Моля, въведете Наименование на Кухнята!');
       theForm.name.value = "";
       theForm.name.focus();
       return false;
    }
   
  	var oEditor = FCKeditorAPI.GetInstance('info');
	var contents = oEditor.GetXHTML(true);	

    if(contents.length < 25)  { //сложил съм 5 екстра символа защото май едитора добавя едно "<br />" автоматично към съдържанието
       alert('Моля, Въведете Описание на Кухнята!');
       theForm.info.value = "";
       theForm.info.focus();
       return false;
	}

  

        
 }    


function checkForCorrectDataAphorism() 
{
    theForm = document.searchform;
    
         
     if(theForm.aphorism_title.value.length == 0) {
       alert('Моля, въведете Автор/Източник на Афоризъма!');
       theForm.aphorism_title.value = "";
       theForm.aphorism_title.focus();
       return false;
    }
   
  

   if(theForm.aphorism_body.value.length == 0) {
       alert('Моля, въведете Текст на Афоризъма!');
       theForm.aphorism_body.value = "";
       theForm.aphorism_body.focus();
       return false;
    }

        
 }    



function checkForCorrectDataPost() 
{
    theForm = document.searchform;
    
         
     if(theForm.post_title.value.length == 0) {
       alert('Моля, въведете Заглавие на Статията!');
       theForm.post_title.value = "";
       theForm.post_title.focus();
       return false;
    }
   
     
	 if(theForm.post_category.value == '-1' || theForm.post_category.value == '' )  {
        alert('Моля, изберете Категория на Статията!');
       theForm.post_category.options[0].selected = true;
        theForm.post_category.focus();
        return false;
   }
   
   
   var oEditor = FCKeditorAPI.GetInstance('post_body');
	var contents = oEditor.GetXHTML(true);		

   if(contents.length < 25)  { //сложил съм 5 екстра символа защото май едитора добавя едно "<br />" автоматично към съдържанието
       alert('Моля, Въведете Текст на Статията!');
       theForm.post_body.value = "";
       theForm.post_body.focus();
       return false;
    }


   if(theForm.post_source.value.length == 0) {
       alert('Моля, въведете Източник на Статията!');
       theForm.post_source.value = "";
       theForm.post_source.focus();
       return false;
    }

        
 }    

function checkForCorrectDataFirm(theForm,curren_username) 
{
	           	  
	if(theForm.firm_category.value == '-1' || theForm.firm_category.value == '' )  {
		alert('Моля, изберете категория на Вашата организация!');
		theForm.firm_category.value = "-1";
		theForm.firm_category.focus();
		return false;
	}
            
     if(theForm.firm_name.value.length < 5) {
        alert('Моля, въведете наименование на организацията!');
        theForm.firm_name.value = "";
        theForm.firm_name.focus();
        return false;
     }
     
	   	            
     if(theForm.username.value.length < 5) {
        alert('Моля, въведете потребителско име по-голямо от 5 символа!');
        theForm.username.value = "";
        theForm.username.focus();
        return false;
     }
     
    if(curren_username == 'n/a' || curren_username != theForm.username.value)
	{	
				
		jQuery.ajax({
		  	type: "POST",
	  		url: "includes/tools/Ajax_Check_Unique_Username.php",
	  		data: {type: firm, username: theForm.username.value}
		 }).done(function(data) {
		 	 if (transport.responseText.match(/exist/))
   			    {
   			    	alert('Избраното потребителско име е заето!Моля, въведете потребителско име!');
   			   	theForm.username.value = "";
				theForm.username.focus();
                		return false;
   			    }		 	
		 });			 		 			
   	  } 	
     
      if(theForm.password.value.length < 5) {
        alert('Моля, въведете парола (по-голяма от 5 символа)!');
        theForm.password.value = "";
        theForm.password.focus();
        return false;
     }
     
     
      if(theForm.password.value != theForm.password2.value) {
        alert('Двете пароли не съвпадат!');
        theForm.password2.value = "";
        theForm.password2.focus();
        return false;
     }
     
     
          
        
   emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	if (emailPattern.test(theForm.email.value)){
			
	}else {
		if(theForm.email.value != 'n/a' && theForm.email.value != 'няма')
		{
			alert('Моля, въведете коректен Е-мейл адрес!');
           	theForm.email.value = "";
           	theForm.email.focus();
			return (false);
		}
	}
	
	     
          
      if(theForm.cityName.value.length == 0)  {
         alert('Моля, изберете населено място!');
         theForm.cityName.value = "";
         theForm.cityName.focus();
         return false;
      }
     
    
   	var oEditor = FCKeditorAPI.GetInstance('description');
	var contents = oEditor.GetXHTML(true);	

    if(contents.length < 25)  { //сложил съм 5 екстра символа защото май едитора добавя едно "<br />" автоматично към съдържанието
       alert('Моля, Въведете Текст на Описанието!');
       theForm.description.value = "";
       theForm.description.focus();
       return false;
	}
	
	
	if(theForm.verificationcode.value.length == 0)  
	{
		alert('Моля, въведете коректен код за сигурност!');
		theForm.verificationcode.value = "";
		theForm.verificationcode.focus();
		return false;
	}
}


      
 
 	function checkForCorrectDataRecipe() 
 	{
     
 		theForm = document.searchform;
        
   	   	
        if(theForm.title.value.length == 0) {
           alert('Моля, въведете наименование на Рецептата!');
           theForm.title.value = "";
           theForm.title.focus();
           return (false);	
        }
              
        
         if(!(theForm.recipe_category.value > 0)) {
           alert('Моля, въведете Вид на Рецептата!');
           theForm.recipe_category.value = "";
           theForm.recipe_category.focus();
           return (false);	
        }
       

         
   	    var oEditor = FCKeditorAPI.GetInstance('info');
   		var contents = oEditor.GetXHTML(true);		

   	    if(contents.length < 25)  { //сложил съм 5 екстра символа защото май едитора добавя едно "<br />" автоматично към съдържанието
               alert('Моля, Въведете начин на приготвяне!');
               theForm.info.value = "";
               theForm.info.focus();
               return false;
            }
                      
      }
      
      
      
      
       
 
 
 	function checkForCorrectDataDrink() 
 	{
     
	      theForm = document.searchform;
         
     	      	   	
         if(theForm.title.value.length == 0) {
            alert('Моля, въведете наименование на Напитката!');
            theForm.title.value = "";
            theForm.title.focus();
            return (false);	
         }
               
         
          if(!(theForm.drink_category.value > 0)) {
            alert('Моля, въведете Вид на Напитката!');
            theForm.drink_category.value = "";
            theForm.drink_category.focus();
            return (false);	
         }
        

          
    	    var oEditor = FCKeditorAPI.GetInstance('info');
    		var contents = oEditor.GetXHTML(true);		

    	    if(contents.length < 25)  { //сложил съм 5 екстра символа защото май едитора добавя едно "<br />" автоматично към съдържанието
                alert('Моля, Въведете начин на приготвяне!');
                theForm.info.value = "";
                theForm.info.focus();
                return false;
             }
                          
                      
      }

     
      
  
function checkForCorrectDataBolest(theForm) 
{
    //theForm = document.searchform;
    
         
     if(theForm.bolest_title.value.length == 0) {
       alert('Моля, въведете Наименование на Болеста!');
       theForm.bolest_title.value = "";
       theForm.bolest_title.focus();
       return false;
    }
   
   if(theForm.bolest_category.value == '-1' || theForm.bolest_category.value == '' )  {
         alert('Моля, изберете Категория на Болеста!');
         theForm.bolest_category.value = "-1";
         theForm.bolest_category.focus();
         return false;
   }
	 
  
   
   var oEditor = FCKeditorAPI.GetInstance('bolest_body');
	var contents = oEditor.GetXHTML(true);		

   if(contents.length < 25)  { //сложил съм 5 екстра символа защото май едитора добавя едно "<br />" автоматично към съдържанието
       alert('Моля, Въведете Текст на Описанието!');
       theForm.bolest_body.value = "";
       theForm.bolest_body.focus();
       return false;
    }


   if(theForm.bolest_source.value.length == 0) {
       alert('Моля, въведете Източник на Описанието!');
       theForm.bolest_source.value = "";
       theForm.bolest_source.focus();
       return false;
    }

        
 }    
 

var  fields = 0;
function addInputs(type) 
{
	if(type == 'drink')
	{
		if (fields != 30) 
	 	{ 
	 		$('#products_table').append("<tr><td><br /><input type = 'text' name = 'drinks_products[]' value = '' size = '50'></td></tr>\n");
	 		fields += 1;
	 	} 
	 	else 
		{
	 		$('#products_table').append("<br />Разрешени са максимум 30 полета.");
		 	document.searchform.addField.disabled=true;
	 	}
	}
 	
	if(type == 'recipe')
	{
		if (fields != 30) 
	 	{ 
	 		$('#products_table').append("<tr><td><br /><input type = 'text' name = 'recipes_products[]' value = '' size = '50'></td></tr>\n");
	 		fields += 1;
	 	} 
	 	else 
		{
	 		$('#products_table').append("<br />Разрешени са максимум 30 полета.");
		 	document.searchform.addField.disabled=true;
	 	}
	}
 	
}

 	
 	
 	
 	
 	
 	
 	
 	
 	function checkForCorrectDataLocation() 
 	{
     
 		theForm = document.searchform;
        
   	   	
        if(theForm.cityName.value == '-1' || theForm.cityName.value == '' )  {
	         alert('Моля, изберете Населено Място, която ще опишете!');
	        theForm.cityName.options[0].selected = true;
	         theForm.cityName.focus();
	         return false;
	    }
	    
	    
	    var oEditor = FCKeditorAPI.GetInstance('info');
		var contents = oEditor.GetXHTML(true);		

	    if(contents.length < 25)  { //сложил съм 5 екстра символа защото май едитора добавя едно "<br />" автоматично към съдържанието
            alert('Моля, Въведете описание на Населеното Място!');
            theForm.info.value = "";
            theForm.info.focus();
            return false;
         }
                      
      }
      
      
      function checkForExistDescription(location_id)
	{
		theForm = document.searchform;
        		
		jQuery.ajax({
		  	type: "POST",
	  		url: "includes/tools/Ajax_Check_IF_Destination_Is_Described.php",
	  		data: {location_id: location_id}
		 }).done(function(data) {
		 	 if (transport.responseText.match(/exist/))
   			    {
   			    	alert('Избраната дестинация вече е описана! Моля, изберете друга дестинация, която да опишете!');
   			   		theForm.cityName.options[0].selected = true;
                		theForm.cityName.focus();
                		return false;
   			    }		 	
		 });			 
	}
      
      
      
      function checkForCorrectDataForum(category_clause) {
         theForm = document.searchform;
              
        if(category_clause == 'question_category')
        {
             if(theForm.question_category.value == '-1' || theForm.question_category.value == '' )  {
	            alert('Моля, изберете Раздел на Вашия коментар!');
	            theForm.question_category.options[0].selected = true;
	            theForm.question_category.focus();
	            return false;
             }
        }

         
          if(theForm.question_title.value.length == 0) {
            alert('Моля, въведете Заглавие на Вашия коментар!');
            theForm.question_title.value = "";
            theForm.question_title.focus();
            return false;
         }
         
        
        var oEditor = FCKeditorAPI.GetInstance('question_body');
		var contents = oEditor.GetXHTML(true);		

		if(contents.length < 10)  { //сложил съм 5 екстра символа защото май едитора добавя едно "<br />" автоматично към съдържанието
			alert('Моля, въведете Вашето мнение или коментар!');
			theForm.question_body.value = "";
			theForm.question_body.focus();
			return false;
		}
        
         
         if(theForm.verificationcode.value.length == 0)  {
             alert('Моля, въведете коректен код за сигурност!');
             theForm.verificationcode.value = "";
             theForm.verificationcode.focus();
             return false;
          }
               
      }

     
      
 	
 	  function set_active(value,type,typeID,activated_deactivated_by)
      {		
      		if(value==1) action='Активирахте';
      		else action = 'Деактивирахте';
      		alert('Вие токущо '+action+' информационната единица!');
      
      		var pars = 'typeID=' + typeID + '&is_active='+ value + '&type=' + type + '&activated_deactivated_by=' + activated_deactivated_by;
      
 		jQuery.ajax({
		  	type: "POST",
	  		url: "includes/tools/ajax_activating.php?" + pars 
		 }).done(function(data) {
		 	jQuery("#bulletinDiv").html(data);				 	
		 });			 			 
      }
      


function submitOnEnter(e) 
{
    var ENTER_KEY = 13;
    var code = "";

    if (window.event) // IE
    {
        code = e.keyCode;
    }
    else if (e.which) // Netscape/Firefox/Opera
    {
        code = e.which;
    }
    
    if (code == ENTER_KEY) {
        insertUserForBulletin(jQuery('#mail_toSend').val());
        return false;
    }
}

 function insertUserForBulletin(mail_toSend) 
{
 theForm = document.searchform;         

	 	emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	 	if (emailPattern.test(theForm.mail_toSend.value))
	 	{
	 		jQuery.ajax({
			  	type: "GET",
		  		url: "includes/tools/Ajax_Check_Insert_User_For_Bulletin.php?mail_toSend=" +mail_toSend
			 }).done(function(data) {
			 	jQuery("#bulletinDiv").html(data);				 	
			 });
			 	
	 	}
	 	else 
	 	{			
	 		alert("Моля, въведете коректен Е-мейл адрес!");
	  		theForm.mail_toSend.value = "";
	  		theForm.mail_toSend.focus();
	 		return (false);			
	 	}
	 }

	 
	 
	 
function checkForCorrectComment() {
 	theForm = document.searchform;
	 
	  	if(theForm.verificationcode.value.length == 0)  {
		    alert('Моля, въведете коректен код за сигурност!');
		    theForm.verificationcode.value = "";
		    theForm.verificationcode.focus();
		    return false;
		 }
	 
	 
	  	if(theForm.comment_body.value.length == 0) {
		    alert('Моля, въведете Вашия коментар!');
		    theForm.comment_body.value = "";
		    theForm.comment_body.focus();
		    return false;
		 }
	}

	     

	    	
		function hidemsgArea()
		{
			setTimeout("jQuery('#suggestions').hide();", 5000);
		}
			
		
function lookup(inputString) 
{
	if(inputString.length == 0) {
		// Hide the suggestion box.
		jQuery('#suggestions').hide();
	} else { 
		jQuery.ajax({
		  	type: "GET",
	  		url: 'includes/tools/Ajax_autoComplete_Simptoms.php?queryString=' +inputString
		 }).done(function(data) {
		 	jQuery("#autoSuggestionsList").html(data);	
		 	jQuery('#suggestions').show();		 		 		 	
		 });	
		 		 				
	}
} 

function sendMailWhenEpayBg(price) {

	jQuery.ajax({
	  	type: "GET",
  		url: 'includes/tools/Ajax_sendMailWhenEpayBg.php?price=' +price
	 }).done(function(data) {
	 	jQuery("#bulletinDiv").html(data);	
	 	//jQuery('#suggestions').show();		 		 		 	
	 });	
				
}
	
	
	
function lookupHomePage(inputString) {
	if(inputString.length == 0) {
		// Hide the suggestion box.
		jQuery('#suggestions').hide();
	} else { 
		jQuery.ajax({
		  	type: "GET",
	  		url: 'includes/tools/Ajax_autoComplete_Simptoms.php?pg_curr=home_page&queryString=' +inputString
		 }).done(function(data) {
		 	jQuery("#autoSuggestionsList").html(data);	
		 	jQuery('#suggestions').show();		 		 		 	
		 });	
		 				
	}
} 
		
function lookupLocation(inputString) 
{
	if(inputString.length == 0) {
		// Hide the suggestion box.
		jQuery('#suggestions').hide();
	} else { 
		jQuery.ajax({
		  	type: "GET",
	  		url: 'includes/tools/Ajax_autoComplete_iFrame_loc.php?queryString=' +inputString
		 }).done(function(data) {
		 	jQuery("#autoSuggestionsList").html(data);	
		 	jQuery('#suggestions').show();		 		 		 	
		 });			
	}
} 
	
		
function updateLocSelect(cityName,locID)
{
	document.getElementById('cityName').value = locID;
	document.getElementById('inputString').value = cityName;	
	setTimeout("jQuery('#suggestions').hide();", 10);												
}

	
function fill(thisValue) {
//			jQuery('#inputString').val(thisValue);
//			setTimeout("jQuery('#suggestions').hide();", 5000);
			jQuery('#inputString').val(''); //изчистваме полето за да се въведе следващия симптом
			
}




	function updateSimptomSelect(type,simptom,simpt_ID)
	{
		if(type == 'bolesti')
		{
			document.getElementById('ALL_SIMPTOMS').value = simpt_ID;
			document.getElementById('inputString').value = simptom;			
			selectselected(document.getElementById('ALL_SIMPTOMS'), document.getElementById('bolest_simptom'));
			selectAllOptions(document.getElementById('bolest_simptom'));
		}	
		else if(type == 'lekarstva')
		{
			document.getElementById('ALL_SIMPTOMS').value = simpt_ID;
			document.getElementById('inputString').value = simptom;				
			selectselected(document.getElementById('ALL_SIMPTOMS'), document.getElementById('lekarstvo_simptom'));
			selectAllOptions(document.getElementById('lekarstvo_simptom'));
		}	
		else if(type == 'home_page')
		{
			document.getElementById("bolest_simptom").value = simpt_ID;
			document.getElementById("inputString").value = simptom;				
			document.searchform.action ="разгледай-болести,характерен_симптом_"+simptom+".html"; 
			document.searchform.submit();
		}
		
	}


	
	
function slideBody(num)
{	
/*	tova sum go sprql, poneje e izli6no zasega		
	if (!(jQuery('#textBody_'+num)))
	{
		i = 0;
      	while(document.getElementById('textBody_'+i)) 
      	{	      		
        	if (jQuery('#textBody_'+i))
        	{
        		//new Effect.BlindUp('textBody_'+i);	
        	}
			i++;	      		
      	}	
      		//new Effect.BlindDown('textBody_'+num);
		
	}
	*/
}



	
	function next_previous(type,currentID)
	{
		if(currentID > 0)
		{
			if(type == 'posts')
			{
				jQuery.ajax({
				  	type: "GET",
			  		url: 'includes/tools/Ajax_next_previous_posts.php?postID=' +currentID
				 }).done(function(data) {
				 	jQuery("#next_previousDIV").html(data);
				 	jQuery('#next_previousDIV').animate({
					    opacity: 0.85
					  }, 1000, function() {
					    // Animation complete.
					  });
				 });
			 
			}
			if(type == 'drinks')
			{
				jQuery.ajax({
				  	type: "GET",
			  		url: 'includes/tools/Ajax_next_previous_drinks.php?drinkID='+currentID
				 }).done(function(data) {
				 	jQuery("#next_previousDIV").html(data);
				 	jQuery('#next_previousDIV').animate({
					    opacity:0.85
					  }, 1000, function() {
					    // Animation complete.
					  });
				 });
				 
			}
			if(type == 'recipes')
			{
				jQuery.ajax({
				  	type: "GET",
			  		url: 'includes/tools/Ajax_next_previous_recipes.php?recipeID='+currentID
				 }).done(function(data) {
				 	jQuery("#next_previousDIV").html(data);
				 	jQuery('#next_previousDIV').animate({
					    opacity: 0.85
					  }, 1000, function() {
					    // Animation complete.
					  });
				 });
				 
			}
			if(type == 'firms')
			{
				jQuery.ajax({
				  	type: "GET",
			  		url: 'includes/tools/Ajax_next_previous_firms.php?firmID='+currentID
				 }).done(function(data) {
				 	jQuery("#next_previousDIV").html(data);
				 	jQuery('#next_previousDIV').animate({
					    opacity: 0.85
					  }, 1000, function() {
					    // Animation complete.
					  });
				 });
				 
			}
			if(type == 'locations')
			{
				jQuery.ajax({
				  	type: "GET",
			  		url: 'includes/tools/Ajax_next_previous_destinations.php?locationID='+currentID
				 }).done(function(data) {
				 	jQuery("#next_previousDIV").html(data);
				 	jQuery('#next_previousDIV').animate({
					    opacity: 0.85
					  }, 1000, function() {
					    // Animation complete.
					  });
				 });
				
			}
			if(type == 'aphorisms')
			{
				jQuery.ajax({
				  	type: "GET",
			  		url: 'includes/tools/Ajax_next_previous_aphorisms.php?aphorismID='+currentID
				 }).done(function(data) {
				 	jQuery("#next_previousDIV").html(data);
				 	jQuery('#next_previousDIV').animate({
					    opacity: 0.85
					  }, 1000, function() {
					    // Animation complete.
					  });
				 });
				 
			}
			if(type == 'bolesti')
			{
				jQuery.ajax({
				  	type: "GET",
			  		url: 'includes/tools/Ajax_next_previous_bolesti.php?bolestID='+currentID
				 }).done(function(data) {
				 	jQuery("#next_previousDIV").html(data);
				 	jQuery('#next_previousDIV').animate({
					    opacity: 0.85
					  }, 1000, function() {
					    // Animation complete.
					  });
				 });
				 
			}
			
		}	
						
	}
	
	
	
	
function makeViewLog(type,ID) 
{
			
	
	   
		jQuery.ajax({
		  type: "POST",
	  	url: "includes/tools/Ajax_make_view_log.php",
	  	data: { type: type, ID: ID }
		  //other stuff you need to build your ajax request
		 }).done(function() {
		   //update your div
		 });
	
		
}



function updateGuideSelect(guide,guide_ID)
{
	document.getElementById('inputString').value = guide;		

	document.location.href = 'разгледай-справочник-'+guide_ID+','+guide+'.html'; 
	
}


function lookupGuide(inputString) 
{
	if(inputString.length == 0) {
		// Hide the suggestion box.
		jQuery('#suggestions').hide();
	} else { 
		
		jQuery.ajax({
		  	type: "GET",
	  		url: 'includes/tools/Ajax_autoComplete_Guides.php?queryString=' +inputString	  				  	
		 }).done(function(data) {
		 	jQuery("#autoSuggestionsList").html(data);
		 	jQuery('#suggestions').show();
		 });
		   				
	}
} 


function updateRecipeSelect(recipe,recipe_ID)
{
	document.getElementById('inputString').value = recipe;		

	document.location.href = 'разгледай-рецепта-'+recipe_ID+','+recipe+'.html'; 
	
}

function lookupRecipe(inputString) 
{
	if(inputString.length == 0) {
		// Hide the suggestion box.
		jQuery('#suggestions').hide();
	} else {
		jQuery.ajax({
		  	type: "GET",
	  		url: 'includes/tools/Ajax_autoComplete_Recipes.php?queryString=' +inputString	  				  	
		 }).done(function(data) {
		 	jQuery("#autoSuggestionsList").html(data);
		 	jQuery('#suggestions').show();
		 });		   				
	}	
} 


function updateDrinkSelect(drink,drink_ID)
{
	document.getElementById('inputString').value = drink;		

	document.location.href = 'разгледай-напитка-'+drink_ID+','+drink+'.html'; 
	
}

function lookupDrink(inputString) 
{
	if(inputString.length == 0) {
		// Hide the suggestion box.
		jQuery('#suggestions').hide();
	} else { 
		
		jQuery.ajax({
		  	type: "GET",
	  		url: 'includes/tools/Ajax_autoComplete_Drinks.php?queryString=' +inputString	  				  	
		 }).done(function(data) {
		 	jQuery("#autoSuggestionsList").html(data);
		 	jQuery('#suggestions').show();
		 });		   				
	}		
} 



function updateDestinationSelect(destination,destination_ID)
{
	document.getElementById('inputString').value = destination;		

	document.location.href = 'разгледай-дестинация-'+destination_ID+','+destination+'.html'; 
	
}

function lookupDestination(inputString) 
{
	if(inputString.length == 0) {
		// Hide the suggestion box.
		jQuery('#suggestions').hide();
	} else { 
		
		jQuery.ajax({
		  	type: "GET",
	  		url: 'includes/tools/Ajax_autoComplete_Destinations.php?queryString=' +inputString	  				  	
		 }).done(function(data) {
		 	jQuery("#autoSuggestionsList").html(data);
		 	jQuery('#suggestions').show();
		 });		   				
	}		
} 

function destinationLoad(letter)
{									
	new Ajax.Updater('destinationDIV', 'includes/tools/Ajax_destination_loader.php?letter='+letter, {
	  method: 'get',onSuccess: function() {
	  	 new Effect.SlideDown('destinationDIV');
      }
	});	
	
}



var gFiles = 4;
function addFile() {
	if(gFiles == 9) {alert('Максималния брой снимки е 10'); return false;}
    var li = document.createElement('li');
    li.setAttribute('id', 'file-' + gFiles);
    li.innerHTML = '<input type="file" name="pics[]"><br /><span onclick="removeFile(\'file-' + gFiles + '\')" style="cursor:pointer;"> - Премахни полето</span>';
    document.getElementById('files-root').appendChild(li);
    gFiles++;
}
function removeFile(aId) {
    var obj = document.getElementById(aId);
    obj.parentNode.removeChild(obj);
     gFiles--;
}