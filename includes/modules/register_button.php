<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$register_button = "";
	if(!isset($_SESSION['valid_user'])) 
	{
		$register_button .= '<ul id="reg-button" style="float:left;margin-bottom:20px;">
			<li><a class="reg_buttonLi" href="регистрация,регистрация_в_системата_на_gozbite_com.html">Потребители</a></li>
		</ul>
		<br style="clear:left;">';
 	} 
	
		return $register_button;
	  
	?>
