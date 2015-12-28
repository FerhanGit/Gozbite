<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


    require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
	   	
   	$guides_letters = "";
	$guides_letters .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';
   	$guides_letters .= '
<div class="postBig">
<h4>
<div class="hbox hbox_ajax"> 
<div> 
	<div align="center"> 
		<h2> 
			Справочник от А до Я	
		</h2> 												
	</div> 
</div> 
</div> 
</h4>		



		<div class="detailsDiv" style="float:left; text-align:center; width:650px; color:#FFFFFF; font-weight:bold; margin-bottom:5px; padding:5px; padding-top:0px; background-color:#39C6EE;">
			<div id="postsContent" class="ContBox">
			<div style="margin-left:100px;">';				 
	  	 	
	  	 			$c=0;	
	  	  			$ArrayLetters	= array('А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь','Ю','Я');
		  	 		foreach ($ArrayLetters as $letter)
	  	  			{ 
	  	  				$c++;
	  	  				$guides_letters .= '<div class="detailsDiv" style="float:left;width:15px; text-align:center; margin-bottom:10px; margin-left:5px;   border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
							<a style="color:#FF6600; font-weight:bold;" href="справочник-буква-'.$letter.',храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html" >'.$letter.'</a>	
						</div>	';
						  				
						if($c%15==0) $guides_letters .= '<br style="clear:both;"/>';
	  	  			}  	  			
	  	  	$guides_letters .= ' 	  	  				  		
					<br style="clear:left;"/>  	
			</div>	 
	  	  		 		<label>Подсказващо търсене<img src=\'images/help.png\' title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Подсказващо търсене!] body=[&rarr; Въведене търсена от Вас <span style="color:#FF6600;font-weight:bold;">дума или израз</span> и системата ще извърши търсене за описания в справочника, съдържащи тази <span style="color:#FF6600;font-weight:bold;">дума или израз</span>.]\' /></label><br />
					 	<div>
							<input  type="text" size="30" id="inputString" name="inputString" AUTOCOMPLETE=OFF  onkeyup="if(this.value.length > 2 ) { lookupGuide(this.value);} else{$(\'#suggestions\').hide();}" value="Търси..." onfocus="if(this.value!=\'Търси...\'){this.value=this.value;} else {this.value=\'\';}" onblur="$(\'#suggestions\').hide(); if(this.value==\'\'){this.value = \'Търси...\';} else {this.value = this.value;}" >
						</div>						
						<div onclick="$(\'#suggestions\').hide();">
							<div class="suggestionsBox" id="suggestions" style="display: none; z-index: 1000; position: relative; margin-left:10px; -moz-border-radius:7px; -webkit-border-radius:7px; min-width: 300px; max-width: 400px;">
								<img src="images/top_arrow.gif" style="position: relative; top: -12px; left: -50px;" alt="upArrow" />
								<div class="suggestionList" id="autoSuggestionsList" style="color:#FFFFFF;"></div>
							</div>
						</div>										
							
							  		
				<br style="clear:both;"/>  	  			
			</div>	
				<br style="clear:both;"/>		
		</div>

</div>	

	
<br style="clear:left;"/></div> <br style="clear:left;"/>';
				
				  
				  	        
		        
	return $guides_letters;
	  
	?>