<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$bulletin = "";
	$bulletin .= '<div class="boxRight" >
					<div class="title" style="margin-bottom:10px" align="center" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Информационен Бюлетин] body=[Абонирайте се за Информационния Бюлетин на GoZBiTe.Com, като въведете Вашия е-мейл адрес и периодично ще получавате актуалната информация, полезни съвети и много кулинарни статии!]\' >Абонирай се за нашия инфо Бюлетин</div>
					<div id="bulletinDiv" align="center">Въведете Вашия e-mail адрес:<br /><input type="text" name="mail_toSend" id="mail_toSend" value="" onkeypress="javascript:submitOnEnter(event)"> <input type="submit" value="Абонирай се" name="insertToBulletin" onclick="insertUserForBulletin($(\'mail_toSend\').value); return false;"></div>
				</div>';
		
	return $bulletin;
	  
	?>
