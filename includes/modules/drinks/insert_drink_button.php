<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$insert_drink_button = "";
	
	$insert_drink_button .= '<ul id="publish-button-drink" style="float:left;margin-bottom:20px;">
		<li><a class="publish_button_drinkLi" href="добави-нова-напитка,екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати_кафе_чай_спиртни.html" onclick="if('.(($_SESSION['user_type'] == 'firm' OR $_SESSION['user_type'] == 'user' OR $_SESSION['user_kind'] == 2) ? 'true' : 'false').') {return true;} else {alert(\'За да добавите рецепта или описание на напитка е нужно да сте регистриран!\'); return false;}">Добави Напитка</a></li>
	</ul>
	<br style="clear:left;">';
	
	if($_SESSION['user_type'] == 'firm' OR $_SESSION['user_type'] == 'user' OR $_SESSION['user_kind'] == 2) 
	{
		$insert_drink_button .= '<div class="boxRight">
				<div class="title" style="margin-bottom:10px">Моите Напитки</div>      		
		  	  	<div class="detailsDiv" style=" width:280px; margin-bottom:10px; margin-left:10px;   border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">				 
		  	 		<div style="float:left;width:135px;" align="center"><a href="напитки-'.(($_SESSION['user_type']=='firm')?'firmID':'userID').'='.$_SESSION['userID'].',екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати_кафе_чай_спиртни.html">&rarr; Моите напитки</a></div>
		  	 		<div style="float:left;width:140px;" align="center"><a href="добави-нова-напитка,екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати_кафе_чай_спиртни.html">&rarr; Публикувай напитка</a></div>
		  	 		<br  style="clear:left;"/>
		  	  	</div>		
		   	</div>';
	} 



	return $insert_drink_button;
	  
	?>
