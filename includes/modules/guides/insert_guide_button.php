<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$insert_guide_button = "";
	
	$insert_guide_button .= '<ul id="publish-button-guide" style="float:left;margin-bottom:20px;">
		<li><a class="publish_button_guideLi" href="публикувай-справочник,храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html" onclick="if('.($_SESSION['userID']?'false':'true').') {alert(\'Необходимо е да се идентифицирате с потребителско име и парола преди да публикувате Вашето Справочно Описание.\'); return false;} " title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Публикувай Справочно Описание] body=[Споделите с читателите на GoZBiTe.Com описание на храна, продукт, подправка, напитка или друго, допълнени с неограничен снимков и видео материал!]\'>Публикувай Справочно Описание</a></li>
	</ul>
	<br style="clear:left;">';
 	
	if($_SESSION['user_type'] == 'firm' OR $_SESSION['user_type'] == 'user' OR $_SESSION['user_kind'] == 2) 
	{
		$insert_guide_button .= '<div class="boxRight">
		<div class="title" style="margin-bottom:10px">Моите описания</div>      		
  	  	<div class="detailsDiv" style=" width:280px; margin-bottom:10px; margin-left:10px;   border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">				 
  	 		<div style="float:left;width:135px;" align="center"><a href="справочник-'.((($_SESSION['user_type']=='firm')?'firmID':'userID')).'='.($_SESSION['userID']).',храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">&rarr; Моите описания</a></div>
  	 		<div style="float:left;width:140px;" align="center"><a href="публикувай-справочник,храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">&rarr; Публикувай описание</a></div>
  	 		<br  style="clear:left;"/>
  	  	</div>		
   	</div>';
	} 

	return $insert_guide_button;
	  
?>
