<?php

    require_once '../header.inc.php';



   
   $type	=	$_REQUEST['type'];

   if(isset($type) && $type != '')
   {
		$sql = sprintf("insert into log_main_menu_clicks set type = '%s', refferer = '%s', remote_addr = '%s', remote_host='%s', user_type = '%s', user_id = %d, date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $type, $_SERVER['PHP_REFFER'], $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']), $_SESSION['user_type'], $_SESSION['userID']);
		$conn->setsql($sql);
		$conn->insertDB();
   }
 
	
  
  ?>
 