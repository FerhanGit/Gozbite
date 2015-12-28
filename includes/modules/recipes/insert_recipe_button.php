<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$insert_recipe_button = "";
	
	$insert_recipe_button .= '<ul id="publish-button-recipe" style="float:left;margin-bottom:20px;">
		<li><a class="publish_button_recipeLi" href="добави-нова-рецепта,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" onclick="if('.(($_SESSION['user_type'] == 'firm' OR $_SESSION['user_type'] == 'user' OR $_SESSION['user_kind'] == 2) ? 'true' : 'false').') {return true;} else {alert(\'За да добавите рецепта е нужно да сте регистриран!\'); return false;}">Добави Рецепта</a></li>
	</ul>
	<br style="clear:left;">';
	
	if($_SESSION['user_type'] == 'firm' OR $_SESSION['user_type'] == 'user' OR $_SESSION['user_kind'] == 2) 
	{
		$insert_recipe_button .= '<div class="boxRight">
				<div class="title" style="margin-bottom:10px">Моите Рецепти</div>      		
		  	  	<div class="detailsDiv" style=" width:280px; margin-bottom:10px; margin-left:10px;   border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">				 
		  	 		<div style="float:left;width:135px;" align="center"><a href="рецепти-'.(($_SESSION['user_type']=='firm')?'firmID':'userID').'='.$_SESSION['userID'].',вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">&rarr; Моите рецепти</a></div>
		  	 		<div style="float:left;width:140px;" align="center"><a href="добави-нова-рецепта,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">&rarr; Публикувай рецепта</a></div>
		  	 		<br  style="clear:left;"/>
		  	  	</div>		
		   	</div>';
	} 



	return $insert_recipe_button;
	  
	?>
