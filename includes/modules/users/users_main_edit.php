<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

   	$users_main_edit = "";

	
	if($_REQUEST['add_friend'] > 0 && $_REQUEST['friend_type'] != '')
	{
		$sql = sprintf("INSERT INTO friendships SET sender = '%s', sender_type = '%s', recipient = '%s', recipient_type = '%s', send_date = NOW()  ", $_SESSION['userID'], $_SESSION['user_type'], $_REQUEST['add_friend'], $_REQUEST['friend_type']);
	    $conn->setsql($sql);
	    $conn->insertDB();
	}
	
	
	
	if($_REQUEST['accept_friend'] > 0 && $_REQUEST['friend_type'] != '')
	{
		$sql = sprintf("UPDATE friendships SET friendship_accepted = '1', friendship_rejected = '0', accept_date = NOW()  WHERE recipient = %d  AND sender = %d ", $_SESSION['userID'], $_REQUEST['accept_friend']);
	    $conn->setsql($sql);
	    $conn->updateDB();
	}
	
	
	if($_REQUEST['remove_friend'] > 0 && $_REQUEST['friend_type'] != '')
	{
		$sql = sprintf("UPDATE friendships SET friendship_rejected = '1' , friendship_accepted = '0' WHERE (sender = %d OR recipient = %d) AND (sender = %d OR recipient = %d)  ", $_SESSION['userID'], $_SESSION['userID'], $_REQUEST['remove_friend'], $_REQUEST['remove_friend']);
	    $conn->setsql($sql);
	    $conn->updateDB();
	}
	
	if($_REQUEST['from_profile'] == 1)
	{
				
		$users_main_edit .='<script type="text/javascript">
		       window.location.href=\'редактирай-профил,изгради_социални_контакти_с_други_потребители.html\';
			</script>';
		
		
	}

	        
	    
	return $users_main_edit;
	  
	?>
