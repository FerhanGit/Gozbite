<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$insert_aphorism_button = "";
	
	$insert_aphorism_button .= '<ul id="publish-button-aphorism" style="float:left;margin-bottom:20px;">
		<li><a class="publish_button_aphorismLi" href="публикувай-афоризъм,интересни_забавни_поучителни_афоризми.html" onclick="if('.($_SESSION['userID']?'false':'true').') {alert(\'Необходимо е да се идентифицирате с потребителско име и парола преди да публикувате Вашия афоризъм или интересна фраза.\'); return false;} " title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Публикувай Афоризъм или Интересна фраза] body=[Споделите с читателите на GoZbiTe.Com афоризъм или интересна фраза, допълнени със снимков материал!]\'>Публикувай Афоризъм</a></li>
	</ul>
	<br style="clear:left;">';
 	
	
	
if($_SESSION['userID'] > 0) 
{
	$insert_aphorism_button .= '<div class="boxRight">
		<div class="title" style="margin-bottom:10px">Моите Афоризми</div>      
		<div class="detailsDiv" style=" width:280px; margin-bottom:10px; margin-left:10px;   border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">				 
  	 		<div style="float:left;width:135px;" align="center"><a href="афоризми-aphorism_autor_type='.$_SESSION['user_type'].'&aphorism_autor='.$_SESSION['userID'].',публикувай_интересни_забавни_поучителни_афоризми.html"  title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Моите Афоризми] body=[Всички афоризми публикувани от Вас. Като техен автор имате възможност да ги редактирате по всяко време!]\'>&rarr; Моите Афоризми</a></div>
  	 		<div style="float:left;width:140px;" align="center"><a href="публикувай-афоризъм,публикувай_интересни_забавни_поучителни_афоризми.html" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Публикувай Афоризъм] body=[Споделите с читателите на GoZbiTe.Com афоризъм или интересна фраза, допълнена със снимков материал!]\'>&rarr; Добави Афоризъм</a></div>
  	 		<br  style="clear:left;"/>
  	  	</div>	
   	</div>';
} 

	$insert_aphorism_button .= '<div class="boxRight">
		<div class="title" style="margin-bottom:10px"><div style="margin-left:6px; width:300px;color:#FFFFFF;font-weight:bold;" ><h3><a style="color:#FFFFFF;font-weight:bold;" href="търси-афоризъм,интересни_забавни_поучителни_афоризми.html">ТЪРСИ АФОРИЗЪМ</a></h3></div>  </div>      		
   	</div>';


	return $insert_aphorism_button;
	  
	?>
