<?php
   $incPath = dirname(__FILE__)."/";
   require_once($incPath."../../includes/functions.php");
   require_once($incPath."../../includes/config.inc.php");
   require_once($incPath."../../includes/classes/mysqldb.class.php");
   require_once($incPath."../../includes/classes/paging.class.php");
   
   $conn = new mysqldb();

   if($conn->error || !$conn->dbconnection) {
      print "<div style = \"font-family: Verdana, Helvetica, sans-serif; color: red;\">Няма достъп до базата!</div>";
      exit();
   }
   
session_start();

 if (isset($_SESSION['valid_user']))
 {
	
    $sql = "DELETE FROM sessions WHERE  (conn_time + INTERVAL 30 MINUTE) < NOW()";
    $conn->setSQL($sql);
    $conn->updateDB();
    
    $sql = "UPDATE sessions SET conn_time=NOW() WHERE session_name='".$_SESSION['valid_user']."'";
    $conn->setSQL($sql);
    $conn->updateDB();

  
 	$sql="SELECT * FROM sessions WHERE session_name='".$_SESSION['valid_user']."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$numSession=$conn->numberrows;
	if ($numSession<1)	{ unset($_SESSION['valid_user']); session_destroy();}
 }
 
 
   	 	if ($pageName == 'hospitals' or $pageName=='edit_hospital' or $pageName=='edit_hospitals' or $pageName =='doctors' or $pageName == 'edit_doctor' or $pageName == 'edit_doctors')
   		{
   			$theme_color = 'green';
   		}
   		elseif($pageName =='bolesti' or $pageName == 'edit_bolesti') 
   		{
   			$theme_color = 'red';
   		}
   		elseif ($pageName == 'home' or $pageName == 'news' or $pageName == 'edit_news')
   		{
   			$theme_color = 'blue';
   		}
   		else $theme_color = 'blue';
   
   		
?>