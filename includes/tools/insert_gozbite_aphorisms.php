<?php
ini_set('max_execution_time', '5750');
ini_set('memory_limit','128M');

	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);
	
include_once("dblogin.inc.php");
require_once("../classes/Upload.class.php");
   
$rssFeed= "http://gozbite.com/make_Aphorisms_XML.php";

$xml=@simplexml_load_file($rssFeed, null, LIBXML_NOCDATA);

if(is_object($xml) && !empty($xml))
foreach($xml as $val)
{
	
	 $image 	= $val->image; 
	 $thumb		= $val->thumb;				
	 $source	= $val->source;
	 $body		= $val->body;
	 $date		= $val->date;
	 $unix_time= $val->unix_time;
	
		
	
	if (isset($source) && ($source != "") && (isset($body) && ($body != "")))
	{
	                
    	$body = removeBadTags($body);		// Remove Bad tags from text
											                
    		
    	$sql = sprintf("INSERT INTO aphorisms SET title = '%s',
                                             	 body = '%s',
                                             	 autor_type = '%s',
                                             		 autor = '%d',
                                             		  active = '1',
                                             		    date = '%s'
                                             	
                                             ON DUPLICATE KEY UPDATE
                                             
                                             	      title = '%s',
                                             		 body = '%s',
                                             		autor_type = '%s',
                                                 autor = '%d',
                                                active = '1'
                                              ",    	
    										  $source,
								               $body,
								                'user',
								             	   1,	
								             	   $date,							             			
								             		$source,
								             	   $body,
								             	  'user',
								               1								             			
								             );
								                                 
                                   
         $conn->setsql($sql);
         $lastID = $conn->insertDB();

                
    
// ----------------- za ka4vane na snimkite ---------------------------------------
				
         	if(isset($image)) 
         	{	
				$uploaddir = "../pics/aphorisms/";
				
				if(eregi("no_photo",$image))
				{
					 $sql = "UPDATE aphorisms SET picURL = '".$lastID.".jpg' WHERE aphorismID = '".$lastID."'";
			         $conn->setsql($sql);
				 	 $conn->updateDB(); 
				}
	  			else 
	  			{
	  				// ni6to ne vkarvame v picURL za da vzeme no_photo_big.jpg        		
	  			}
					        				 		
								
         }

         
     
	//=============================================================================================================
	
        
      } 
			 
	}	
	

?>