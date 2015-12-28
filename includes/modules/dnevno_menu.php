<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/



	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
   	$relax = "";
	
	
   	
		$relax .= ' <iframe align="center"  valign="middle" src="http://gozbite.com/inc/dnevno_menu_za_ohboli.inc.php" height="430" width="310" frameborder="0" scrolling="No" allowTransparency="true" style="background-color:transparent;"></iframe>';
						
	
	return $relax
	  
	?>
