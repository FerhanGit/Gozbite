<?php

	  
    $file_name = $_REQUEST['file_name'];
  
   									 
	$file_content = file_get_contents('http://gozbite.com/'.$file_name);
  
	print $file_content;
?>