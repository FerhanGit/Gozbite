<?php
   

   $response = "";
   $srcID=$_REQUEST['srcID'];  
               
 $response .="<img src=\"../pics/cars/".$srcID."\" />";
 
   print $response;
?>