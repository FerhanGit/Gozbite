<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


    require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
	   	
   	$sub_menus = "";
	$sub_menus .= '
<div class="postBig">
		<div class="detailsDiv" style="float:left;margin-left:10px; text-align:center; width:980px; color:#FFFFFF; font-weight:bold; margin-bottom:5px; background-color:#39C6EE;">
			<div id="postsContent" class="ContBox">';
				
	  	 	if($params['page_name'] == 'recipes')
			{				
					$sql = "SELECT id,name FROM recipe_category WHERE parentID=0 ORDER BY  rank, name";
					$conn->setsql($sql);
					$conn->getTableRows();
					$resultMenuRecipes = $conn->result;
					$numMenuRecipes = $conn->numberrows;
					foreach ($resultMenuRecipes as $MenuRecipes)
	  	  			{ 
	  	  				$sub_menus .= '<div style="margin-left:15px;"><div class="detailsDiv" style="float:left;width:120px; text-align:center; margin-bottom:10px; margin-left:5px; padding:5px; '.($MenuRecipes['id'] == $_REQUEST['category']?' background-color:#FF6600; border-top:3px solid #0099FF;':' background-color:#F1F1F1; border-top:3px solid #0099FF;').'">
										<a style="'.($MenuRecipes['id'] == $_REQUEST['category']?'color:#FFFFFF;':'color:#FF6600;').' font-weight:bold;" href="рецепти-категория-'.$MenuRecipes['id'].','.myTruncateToCyrilic($MenuRecipes['name'],200,'_','') .'.html" >'.$MenuRecipes['name'].'</a>	
									</div></div>	';						  				
					}  	  			
				$sub_menus .= ' 	  	  				  		
					<br style="clear:left;"/>  	
					 
	  	  		 		<label>Подсказващо търсене<img src=\'images/help.png\' title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Подсказващо търсене!] body=[&rarr; Въведене търсена от Вас <span style="color:#FF6600;font-weight:bold;">дума или израз</span> и системата ще извърши търсене за рецепти, съдържащи тази <span style="color:#FF6600;font-weight:bold;">дума или израз</span>.]\' /></label><br />
					 	<div>
							<input  type="text" size="30" id="inputString" name="inputString" AUTOCOMPLETE=OFF  onkeyup="if(this.value.length > 2 ) { lookupRecipe(this.value);} else{$(\'#suggestions\').hide();}" value="Търси..." onfocus="if(this.value!=\'Търси...\'){this.value=this.value;} else {this.value=\'\';}" onblur="$(\'#suggestions\').hide(); if(this.value==\'\'){this.value = \'Търси...\';} else {this.value = this.value;}" >
						</div>						
						<div onclick="$(\'#suggestions\').hide();">
							<div class="suggestionsBox" id="suggestions" style="display: none; z-index: 1001; position: relative; -moz-border-radius:7px; -webkit-border-radius:7px; min-width: 300px; max-width: 400px;">
								<img src="images/top_arrow.gif" style="position: relative; top: -12px; left: 100px;" alt="upArrow" />
								<div class="suggestionList" id="autoSuggestionsList" style="color:#FFFFFF;"></div>
							</div>
						</div>';									
							
			}
			elseif($params['page_name'] == 'drinks')
			{				
					$sql = "SELECT id,name FROM drink_category WHERE parentID=0 ORDER BY  rank, name";
					$conn->setsql($sql);
					$conn->getTableRows();
					$resultMenuDrinks = $conn->result;
					$numMenuDrinks = $conn->numberrows;
					foreach ($resultMenuDrinks as $MenuDrinks)
	  	  			{ 
	  	  				$sub_menus .= '<div style="margin-left:15px;"><div class="detailsDiv" style="float:left;width:80px; text-align:center; margin-bottom:10px; margin-left:5px; padding:5px; '.($MenuDrinks['id'] == $_REQUEST['category']?' background-color:#FF6600; border-top:3px solid #0099FF;':' background-color:#F1F1F1; border-top:3px solid #0099FF;').'">
										<a style="'.($MenuDrinks['id'] == $_REQUEST['category']?'color:#FFFFFF;':'color:#FF6600;').' font-weight:bold;" href="напитки-категория-'.$MenuDrinks['id'].','.myTruncateToCyrilic($MenuDrinks['name'],200,'_','') .'.html" >'.$MenuDrinks['name'].'</a>	
									</div></div>	';						  				
					}  	  			
				$sub_menus .= ' 	  	  				  		
					<br style="clear:left;"/>  	
					 
	  	  		 		<label>Подсказващо търсене<img src=\'images/help.png\' title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Подсказващо търсене!] body=[&rarr; Въведене търсена от Вас <span style="color:#FF6600;font-weight:bold;">дума или израз</span> и системата ще извърши търсене за напитки, съдържащи тази <span style="color:#FF6600;font-weight:bold;">дума или израз</span>.]\' /></label><br />
					 	<div>
							<input  type="text" size="30" id="inputString" name="inputString" AUTOCOMPLETE=OFF  onkeyup="if(this.value.length > 2 ) { lookupDrink(this.value);} else{$(\'#suggestions\').hide();}" value="Търси..." onfocus="if(this.value!=\'Търси...\'){this.value=this.value;} else {this.value=\'\';}" onblur="$(\'#suggestions\').hide(); if(this.value==\'\'){this.value = \'Търси...\';} else {this.value = this.value;}" >
						</div>						
						<div onclick="$(\'#suggestions\').hide();">
							<div class="suggestionsBox" id="suggestions" style="display: none; z-index: 1001; position: relative; -moz-border-radius:7px; -webkit-border-radius:7px; min-width: 300px; max-width: 400px;">
								<img src="images/top_arrow.gif" style="position: relative; top: -12px; left: 100px;" alt="upArrow" />
								<div class="suggestionList" id="autoSuggestionsList" style="color:#FFFFFF;"></div>
							</div>
						</div>';									
							
			}			
				$sub_menus .= ' <br style="clear:both;"/>  	  			
			</div>	
				<br style="clear:both;"/>		
		</div>

</div>	

	
<br style="clear:left;"/>';
				
				  
				  	        
		        
	return $sub_menus;
	  
	?>