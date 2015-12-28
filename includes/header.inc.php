<?php

//	error_reporting(E_ALL);
//	ini_set('display_errors', 1);
	error_reporting(~E_NOTICE);
	ini_set('display_errors', 0);

	if(isset($_GET['pg']) && ($_GET['pg'] == 'stuff') OR ( $_GET['pg'] == 'forums' ))
	{
		//error_reporting(E_ALL);
		//ini_set('display_errors', 1);
	}
	header('Content-type: text/html;charset=utf-8');
		
   $incPath = dirname(__FILE__)."/";
   require_once($incPath."functions.php");
   require_once($incPath."config.inc.php");
   require_once($incPath."bootstrap.inc.php");
   
   $conn = new mysqldb();
	
   if($conn->error || !$conn->dbconnection) {
      print "<div style = \"font-family: Verdana, Helvetica, sans-serif; color: red;\">Няма достъп до базата!</div>";
      exit();
   }
   
	session_start();


	$settings = '';
	$site = new Site($settings);
	
 if (isset($_SESSION['valid_user']))
 {
	
    $sql = "DELETE FROM sessions WHERE  (conn_time + INTERVAL 30 MINUTE) < NOW()";
    $conn->setSQL($sql);
    $conn->updateDB();
    
    $sql = "UPDATE sessions SET conn_time = NOW() WHERE session_name = '".$_SESSION['valid_user']."'";
    $conn->setSQL($sql);
    $conn->updateDB();

  
 	$sql="SELECT * FROM sessions WHERE session_name = '".$_SESSION['valid_user']."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$numSession = $conn->numberrows;
	if ($numSession<1)	{ unset($_SESSION['valid_user']); session_destroy();}
 }
 
 
    
   		
Log::msg(basename(__FILE__)."\t Start the page");

// start the page
$body = '';
$site->body = & $body;



?>
