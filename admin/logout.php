<?php
session_start();
include_once("inc/dblogin.inc.php");


$sql = "DELETE FROM sessions WHERE  session_name='".$_SESSION['valid_user']."'";
$conn->setSQL($sql);
$conn->updateDB();
			 
unset($_SESSION['valid_user']);
session_destroy();
echo "<script>document.location.href='index.php'</script>";
?>