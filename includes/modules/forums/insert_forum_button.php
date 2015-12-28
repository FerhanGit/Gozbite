<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$insert_forum_button = "";
	
	$insert_forum_button .= '<ul id="publish-button-forum" style="float:left;margin-bottom:20px;">
		<li><a class="publish_button_forumLi" href="създай-форум-тема,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" onclick="if('.($_SESSION['userID']?'false':'true').') {alert(\'Необходимо е да се идентифицирате с потребителско име и парола преди да публикувате Вашето мнение или коментар.\'); return false;} " title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Публикувай Тема/Коментар] body=[Споделите с читателите на GoZBiTe.Com Тема/Коментар!]\'>Публикувай Тема/Коментар</a></li>
	</ul>
	<br style="clear:left;">';
 	
	if($_SESSION['user_type'] == 'firm' OR $_SESSION['user_type'] == 'user' OR $_SESSION['user_kind'] == 2) 
	{
		$insert_forum_button .= '<div class="boxRight">
		<div class="title" style="margin-bottom:10px">Моите Теми</div>      
		<div class="detailsDiv" style=" width:280px; margin-bottom:10px; margin-left:10px;   border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">				 
  	 		<div style="float:left;width:135px;" align="center"><a href="форум-autor_type='.$_SESSION['user_type'].'&autor='.$_SESSION['userID'].',вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html"  title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Моите Теми/Коментари] body=[Всички Теми/Коментари публикувани от Вас. Като техен автор имате възможност да ги редактирате по всяко време!]\'>&rarr; Моите Теми/Коментари</a></div>
  	 		<div style="float:left;width:140px;" align="center"><a href="създай-форум-тема,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Публикувай Тема/Коментар] body=[Споделите с читателите на GoZbiTe_Com Тема/Коментар!]\'>&rarr; Публикувай Теми/Коментари</a></div>
  	 		<br  style="clear:left;"/>
  	  	</div>	
   	</div>';
	} 

	return $insert_forum_button;
	  
	?>
