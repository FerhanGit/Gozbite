<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$insert_survey_button = "";
		
	
if($_SESSION['userID'] > 0 && $_SESSION['user_kind'] == 2) // Samo za ADMIN-i
{
	
	$insert_survey_button = "";
	
	$insert_survey_button .= '<ul id="publish-button-survey" style="float:left;margin-bottom:20px;">
		<li><a class="publish_button_surveyLi" href="публикувай-анкета,анкети_допитвания.html">Публикувай АНКЕТА</a></li>
	</ul>
	<br style="clear:left;">';
 	
} 

return $insert_survey_button;

?>
