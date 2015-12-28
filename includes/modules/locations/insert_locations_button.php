<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$insert_location_button = "";
	
	$insert_location_button .= '<ul id="opishi-button-destinaciq" style="float:left;margin-bottom:20px;">
		<li>
			<a class="opishi_button_destinaciqLi" href="опиши-дестинация,описание_на_градове_села_курорти_дестинации_от_цял_свят.html" onclick="if('.($_SESSION['userID']?'false':'true').') {alert(\'Необходимо е да се идентифицирате с потребителско име и парола преди да опишете желаната Дестинация.\'); return false;} " title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Опиши Дестинация] body=[Опишете Вашия град, село или любимо място в България и по целия свят! Възможност за добавяне на неограничен снимков и видео материал!]\'>Опиши дестинация</a>
		</li>
	</ul>
	<br style="clear:left;">';
 	
	
	return $insert_location_button;
	  
	?>
