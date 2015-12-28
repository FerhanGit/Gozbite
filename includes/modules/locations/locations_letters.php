<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$locations_letters = "";
	
	$locations_letters .= '
   	
   	<div class="boxRight">
		<div class="title" style="margin-bottom:10px">Дестинации</div>
      
		<div class="detailsDiv" style="width:290px; margin-bottom:10px; margin-left:5px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';
				 
	  	 			$c=0;	
	  	  			$ArrayLetters	= array('А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь','Ю','Я');
		  	 		foreach ($ArrayLetters as $letter)
	  	  			{ 
	  	  				$c++;
	  	  				$locations_letters .= '<div class="detailsDiv" style="float:left;width:14px; text-align:center; margin-bottom:10px; margin-left:5px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
							<a style="color:#FFFFFF; text-decoration:none; font-weight:bold;" href="javascript:void(0);" onclick="destinationLoad(\''.$letter.'\');" >'.$letter.'</a>	
						</div>	';
						  				
						if($c%10==0) $guides_letters .= '<br style="clear:both;"/>';
	  	  			}  	  			
                    $locations_letters .= ' 	  	  				  		
					<br style="clear:left;"/>  	
			</div>	
            
			<hr><br />
			<div style=" text-align:center;">
				<label>Подсказващо търсене<img src=\'images/help.png\' title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Подсказващо търсене!] body=[&rarr; Въведене търсена от Вас <span style="color:#FF6600;font-weight:bold;">дума или израз</span> и системата ще извърши търсене за Дестинации, съдържащи тази <span style="color:#FF6600;font-weight:bold;">дума или израз</span>.]\' /></label><br />
				<div style=" text-align:center;">
					<input  type="text" size="30" id="inputString" name="inputString" AUTOCOMPLETE=OFF  onkeyup="if(this.value.length > 2 ) { lookupDestination(this.value);} else{$(\'suggestions\').hide();}" value="Търси..." onfocus="if(this.value!=\'Търси...\'){this.value=this.value;} else {this.value=\'\';}" onblur="if(this.value==\'\'){this.value = \'Търси...\';} else {this.value = this.value;}" >
				</div>						
				<div onclick="$(\'suggestions\').hide();">
					<div class="suggestionsBox" id="suggestions" style="display: none; z-index: 1000; margin-left:580px; -moz-border-radius:7px; -webkit-border-radius:7px; min-width: 300px;">
						<img src="images/top_arrow.gif" style="position: relative; top: -10px; left: 20px;" alt="upArrow" />
						<div class="suggestionList" id="autoSuggestionsList" style="color:#FFFFFF;"></div>
					</div>
				</div>		
			</div>	<br />			
  	  		<hr><br />
  	  		
  	  		<div class="detailsDiv" style="width:300px; margin-bottom:10px; ">
		
  	  			<div id="destinationDIV" style="width:290px;overflow:hidden; margin-left:5px;   border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;"></div>
  	  		
  	  		</div>
   	</div>';
 	
	
	return $locations_letters;
	  
	?>
