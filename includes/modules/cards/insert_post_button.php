<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$insert_post_button = "";
	
	$insert_post_button .= '<ul id="publish-button-post" style="float:left;margin-bottom:20px;">
		<li><a class="publish_button_postLi" href="публикувай-статия,публикувай_полезни_здравни_статии.html" onclick="if('.($_SESSION['userID']?'false':'true').') {alert(\'Необходимо е да се идентифицирате с потребителско име и парола преди да публикувате Вашата статия или Полезен съвет.\'); return false;} " title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Публикувай Статия или Полезен съвет] body=[Споделите с читателите на oHBoli.Bg статия или полезен съвет, допълнени с неограничен снимков и видео материал!]\'>Публикувай Статия</a></li>
	</ul>
	<br style="clear:left;">';
 	
	
	return $insert_post_button;
	  
	?>
