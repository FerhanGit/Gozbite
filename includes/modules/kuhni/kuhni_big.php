<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$kuhni_big = "";
   	
			
   	
$sql="SELECT id, name, info, rating, times_rated FROM kuhni WHERE id = '".$_REQUEST['kuhnq']."'";
$conn->setsql($sql);
$conn->getTableRow();
$kuhnqResult=$conn->result;

$kuhni_big .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';
$kuhni_big .= '<div class="postBig">	
<h4 style="color:#FF8400;">
	<div style=" float:left; margin-left:0px; width:640px; color:#0099FF; font-weight:bold;" >'.$kuhnqResult['name'].' национална кухня 
		<div style="float:right;margin-top:5px;">
			<div id="track1" class="track" style=" margin-right:5px; width: 130px; margin-bottom:3px;" >
			   <div id="handle1" class="handle" style="width: 30px;" ><p id="changed" style="color:#FFFFFF; text-align:center;  font-size:10px; font-weight:bold; line-height:1.2;">12px</p></div>
			</div>
		</div>	';
if(($_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) 
{	
	$kuhni_big .= '<div style="float:right; margin-right:5px;" ><a href="редактирай-кухня-'.$kuhnqResult['id'].','.myTruncateToCyrilic($kuhnqResult['name'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a>';
	
}	

$kuhni_big .= '		
	</div>	
	<br style="clear:both;"/>	
</h4>';




$kuhni_big .= '
<div class="detailsDiv" style="float:left; width:650px;margin-bottom:5px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
	<fb:like href="http://www.gozbite.com/разгледай-кухня-'.$_REQUEST['kuhnq'].','.myTruncateToCyrilic($kuhnqResult['name'],100,'_','') .'.html" layout="button_count"	show_faces="false" width="50" height="21" action="like" colorscheme="light"></fb:like>								
	<div style=" float:right; margin-right:5px; font-weight:bold; color:#FFF;" ><h3 align="left"><a style="font-size:14px; font-weight:bold; color:#FFF;" href="рецепти-kuhnq='.$_REQUEST['kuhnq'] .','.myTruncateToCyrilic($kuhnqResult['name'],200,'_','') .'.html" >Разгледай всички рецепти от '.$kuhnqResult['name'].' кухня</a></h3></div>								
	<br style="clear:both;"/>	
</div>
	
	</div>';
	
	/*		
	$kuhni_big .= '<script type="text/javascript">
		new Control.Slider(\'handle1\' , \'track1\',
		{
			range: $R(10,28),
			values: [10,12,14,18,24,28],
			sliderValue: 12,
			onChange: function(v){
				var objTextBody = document.getElementById("kuhnqBody");		
			   	objTextBody.style.fontSize = v+"px";
			   	$(\'changed\').innerHTML = v+\'px\';
			},
			onSlide: function(v) {
			  	var objTextBody = document.getElementById("kuhnqBody");
			  	objTextBody.style.fontSize = v+"px";
			  	$(\'changed\').innerHTML = v+\'px\';			  
			}
		} );
	</script>';
	*/
	
	

/*
$kuhni_big .= '

<!-- HTML CODE -->
<div class="exemple3" data-average="6" data-id="'.$_REQUEST['postID'].'" style=" float:left;width:200; margin-top:0px; color:#ffffff;"></div>

<!-- JS to add -->
<script type="text/javascript">
  jQuery(document).ready(function(){
	jQuery(".exemple3").jRating({
	  step:true,
	  length : 6, // nb of stars
	  decimalLength:1 // number of decimal in the rate
	});
  });
</script>

';*/

	
		

$kuhni_big .= '
	<br style="clear:both;"/>	
	    	<div id="kuhnqBody" style="margin-top:20px;">
	      		'.stripslashes($kuhnqResult['info']).'
	      	</div>';

$kuhni_big .= '	</div>';

return $kuhni_big;

?>