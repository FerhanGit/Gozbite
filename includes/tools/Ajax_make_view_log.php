<?php

    require_once("../functions.php");
	require_once("../config.inc.php");
	require_once("../bootstrap.inc.php");
   
   	$conn = new mysqldb();
	

   
   $type	=	$_REQUEST['type'];
   $ID 		= 	$_REQUEST['ID'];
  
   if($type == 'post')
   {
   		log_post($ID); 
   }
   elseif($type == 'drink')
   {
   		log_drink($ID); 
   }
   elseif($type == 'recipe')
   {
   		log_recipe($ID); 
   }
   elseif($type == 'firm')
   {
   		log_firm($ID); 
   }
   elseif($type == 'guide')
   {
   		log_guide($ID); 
   }
   elseif($type == 'location')
   {
   		log_location($ID); 
   }
   elseif($type == 'card')
   {
   		log_card($ID); 
   }
   elseif($type == 'question')
   {
   		log_question($ID); 
   }
    elseif($type == 'bolest')
   {
   		log_bolest($ID); 
   }
   
   
   
	
	
	
	
  
  ?>
 