<?php
  
   
  require_once '../header.inc.php';
   

 
   
   $mail_toSend = $_REQUEST['mail_toSend'];
  
   $response = "";
  
   	if($mail_toSend != '')
		$sql="SELECT bulletinID FROM bulletins WHERE mail_toSend = '".$mail_toSend."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$Itm  = $conn->result;	
   		if($conn->numberrows > 0 ) 
   		{
   			$response .= "Този e-mail адрес вече е абониран за инфо бюлетин-а.";
   		}
   		else 
   		{
   			$sql="INSERT INTO bulletins SET mail_toSend = '".$mail_toSend."', registered_on = NOW() ";
			$conn->setsql($sql);
			$conn->insertDB();
			
   			$response .= "Абонирахте се успешно за инфо бюлетин-а.";
   		}
       
   
   print $response;
  ?>
 