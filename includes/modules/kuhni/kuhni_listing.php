<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/
	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	$kuhni_listing = "";

	
	$sql="SELECT id, name, info, rating, times_rated FROM kuhni ORDER BY name ASC";
	$conn->setsql($sql);
	$conn->getTableRows();
	$items=$conn->result;



	$kuhni_listing .= '<div class="postBig">';
	$kuhni_listing .= require("includes/modules/googleAdsenseMain_468_60.php"); // Pokazva GoogleAdsense 
	$kuhni_listing .= '<br style="clear:left;"/>';	
	$kuhni_listing .= '<div class="post">';



	if($items)
	{
		$kuhni_listing .= '<div class="date">Световни Кухни </div>';
			
	}	 

	  	if ($items) 
		{
			
			foreach ($items as $kuhniInfo)
			{
				
				
							
				$kuhni_listing .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
					<table><tr><td>	
						<div class="detailsDiv" style="float:left; width:645px;margin-bottom:10px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
								<div style=" float:left; margin-left:6px; width:200px;color:#FFF;  font-size:12px; font-weight:bold;" >
								
								<div style="float:left; margin-right:2px; " >
									
									<fb:like href="http://www.GoZBiTe.Com/разгледай-кухня-'.$kuhniInfo['id'].','.myTruncateToCyrilic(strip_tags($kuhniInfo['info']),100,'_','') .'.html" layout="button_count"	show_faces="false" width="50" height="30" action="like" colorscheme="light"></fb:like>
								
								</div>
								
								</div>';
								
								$kuhni_listing .= '<div style=" float:right;  margin-right:5px; font-weight:bold; color:#FFFFFF; background:transparent;" ><h3 align="left"><a style="font-size:14px; color:#FFFFFF; font-weight:bold;" href="разгледай-кухня-'.$kuhniInfo['id'].','.myTruncateToCyrilic(strip_tags($kuhniInfo['info']),100,'_','') .'.html">'.$kuhniInfo['name'] .' кухня</a></h3></div>';
								
								if(($_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) {	
									$kuhni_listing .= '<div style="float:right; margin-right:5px;" ><a href="редактирай-кухня-'.$kuhniInfo['id'].','.myTruncateToCyrilic(strip_tags($kuhniInfo['info']),100,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>';
								}
																	
								$kuhni_listing .='<br style="clear:both;"/>
						</div>
						<br style="clear:both;"/>
						<h4 style="color:#FF8400; font-weight:normal; background:transparent;"> <a href="разгледай-кухня-'.$kuhniInfo['id'].','.myTruncateToCyrilic(strip_tags($kuhniInfo['info']),100,'_','') .'.html">'.myTruncate(strip_tags($kuhniInfo['info']), 300, " ").'</a> </h4>
						
						</td></tr></table>
	       				
	       				
	       		</div> ';   
	   
	       		
	       		
	   
		 		} 
			}


	
	
		$kuhni_listing .= '</div>
		</div>	';
	



	return $kuhni_listing;
  

?>

