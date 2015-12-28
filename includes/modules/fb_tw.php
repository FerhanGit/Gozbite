<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$fb_tw = "";
	if(!isset($_SESSION['valid_user'])) 
	{
		$fb_tw .='<ul id="fb_tw">
		<li><a class="fbLi" href="http://www.facebook.com/sharer.php?u=http://www.gozbite.com&amp;t=GoZbiTe.Com - насладата от живота!" target="_blank">FaceBook</a></li>
		<li><a class="twLi" href="http://twitter.com/home?status=GoZbiTe.Com - насладата от живота!, http://www.gozbite.com"  target="_blank">Twitter</a></li>';
		$fb_tw .='</ul>';
		
		$fb_tw .='<br style="clear:left;"><br style="clear:left;">';
 	} 
	
		return $fb_tw;
	  
	?>
