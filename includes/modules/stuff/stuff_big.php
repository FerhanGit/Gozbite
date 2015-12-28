<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$stuff_big = "";
   	
			
$stuff_big .= '<div class="postBig">
<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
	<div id="Main_Top" style="float:left; width:660px; ">
	

	<div id="track1" class="track" style="margin-right:5px; width: 130px; margin-bottom:3px;" >
	   <div id="handle1" class="handle" style="width: 30px;" ><p id="changed" style="color:#FFFFFF; text-align:center;  font-size:10px; font-weight:bold; line-height:1.2;">12px</p></div>
	</div>';
	
	
	/*
$stuff_big .= '
	
	<script type="text/javascript">
		new Control.Slider(\'handle1\' , \'track1\',
		{
			range: $R(10,28),
			values: [10,12,14,18,24,28],
			sliderValue: 12,
			onChange: function(v){
				var objTextBody = document.getElementById("BANER_KVADRAT_AND_NEWS_DIV");		
			   	objTextBody.style.fontSize = v+"px";
			   	$(\'changed\').innerHTML = v+\'px\';
			},
			onSlide: function(v) {
			  	var objTextBody = document.getElementById("BANER_KVADRAT_AND_NEWS_DIV");
			  	objTextBody.style.fontSize = v+"px";
			  	$(\'changed\').innerHTML = v+\'px\';			  
			}
		} );
	</script>';
	
*/	
	
$stuff_big .= ' 
	  	<h4 style=\'margin: 10px 0px 0px 0px; padding-left:20px; color: #0099FF; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;\'>'.getPageTitle($_REQUEST['get']).'</h4>
    </div><br style="clear:left;"/>';

    
		$sql = "SELECT pageID, title, abriviature FROM pages WHERE parent_id = (SELECT pageID FROM pages WHERE abriviature = '".$_REQUEST['get']."') ORDER BY rank , title";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultMenuPages = $conn->result;
		$numMenuPages = $conn->numberrows;
		if($numMenuPages > 0)
		{
			
			 $stuff_big .= '<li style="list-style-type:none;">  ';                                        
				
				for($d=0;$d<$numMenuPages;$d++)
				{
				
					 $stuff_big .= '<img id="img_trip'.$d.'" src="images/menu_strelka_'.($resultMenuPages[$d]['abriviature']==$_REQUEST['getmore']?'orange':'white').'.png" />&nbsp;';
					 $stuff_big .= '<a style=" font-size:14px; line-height:1.8;" href="разгледай-страница-'.$_REQUEST['get'].'-'.$resultMenuPages[$d]['abriviature'].','.myTruncateToCyrilic($resultMenuPages[$d]['title'],200,'_','') .'.html" target="_self">'.$resultMenuPages[$d]['title'].'</a><br />';
				
				} 
				
			 $stuff_big .= '</li>';
	
		}
		
		
 $stuff_big .= '   <div id="BANER_KVADRAT_AND_NEWS_DIV" style="padding:10px 0px 10px 0px;">';

	
		$get = $_REQUEST['getmore']?$_REQUEST['getmore']:$_REQUEST['get'];
		
		
	if(isset($get))
	{ 	         
		$stuff = getPageContent($get);
				
		//print $stuff['title']; 
		$stuff_big .= "<br />";
		$stuff_big .= $stuff['body'] ;		

		if($get == 'feedback')
		{ 
			if(isset($_REQUEST['sendFeedback'])) 
			  {
		      $txt      	= trim(htmlspecialchars($_REQUEST['txt']));
		      $senderName	= trim(htmlspecialchars($_REQUEST['ownName']));
		      $senderMail 	= trim($_REQUEST['email']);
		
		      $errors = "";
		      $message = "";
		
		      if(!isset($senderName) || (strlen($senderName) <= 0))
		         $errors = "<br /><span  style='color:#FF0000;'>Моля, попълнете името си! </span>";
		
		      if(!isset($senderMail) || !preg_match("/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$/", $senderMail))
		         $errors .= "<br /><span  style='color:#FF0000;'>Моля, въведете валиден имейл! </span>";
		
		      if(!isset($txt) || (strlen($txt) <= 0))
		         $errors .= "<br /><span  style='color:#FF0000;'>Моля, попълнете текста на съобщението! </span>";
		
		      if(strlen($errors) <= 0) {
		         // Sending Mail
		         $mailTo 		= 'office@gozbite.com';
		         $mailFrom 		= "GoZbiTe.Com <office@gozbite.com>";
		
		         require_once("includes/classes/htmlMimeMail.class.php");
		
		         $mail = new htmlMimeMail();
		         $mail->setTextCharset('utf-8');
		         $mail->setHtmlCharset('utf-8');
		         $mail->setHeadCharset('utf-8');
		
		         
		         $htmlTxt = "<br />Емайл на подателя: ".$senderMail."<br />";
		         $htmlTxt .= "<br />Име на подателя: ".$senderName."<br /><br />";
		         
		         $htmlTxt .= nl2br($txt)."<br />";
		

		         $mail->setHtml($htmlTxt);
		
		         $mail->setSubject("GoZbiTe.Com, saobshtenie ot potrebitel na site-a GoZbiTe.Com");
		
		         $mail->setFrom($mailFrom);
		
		
		         if($mail->send(array($mailTo)))
		            $message = "<br /><span  style='color:#FF0000;'>Благодарим Ви!<br />Вашето съобщение е изпратено успешно.</span><br />";
		         else {
		            $message = "<br /><span  style='color:#FF0000;'>По технически причини вашето съобщение не беше изпратено.</span><br />";
						//print_r($mail->errors);
					}
					
		      }
		   }
		
   
	
$stuff_big .= '			
		<form method = "post" name = "itemform" action = "" onsubmit = "return validate();">
		<table border = "0" cellspacing = "0" cellpadding = "3">
		            <caption><strong>Изпрати твоето мнение или коментар</strong></caption>
		            <tr><td colspan = "2">&nbsp;</td></tr>
		            <tr><td colspan = "2" style = "height: 10px;"></td></tr>';
		
		          
		               if($errors || $message) {
		                  $stuff_big .= "<tr><td colspan = \"2\" valign = \"top\" align = \"left\" class = \"txt11 orange\"><br />";
		                  if(strlen($errors) > 0) {
		                     $stuff_big .= $errors;
		                  } elseif(strlen($message) > 0) {
		                     $stuff_big .= $message;
		                  }
		                  $stuff_big .= "</td></tr><br />";
		                  $stuff_big .= "<tr><td colspan = \"2\" style = \"height: 10px;\"></td></tr><br />";
		               }
		         
$stuff_big .= '     <tr>
		               <td align = "right" valign="top"><label for = "ownName">Вашето име:</label></td>
		               <td valign="top"><input type = "text" style="width:220px" id = "ownName" name = "ownName" value = "" /><br /><br /></td>
		            </tr>
		            <tr>
		               <td align = "right" valign="top"><label for = "email">Вашият e-mail:</td>
		               <td valign="top"><input type="text" style="width:220px" id = "email" name = "email" value = "" /><br /><br /></td>
		            </tr>
		            <tr>
		               <td align = "right" valign="top"><label for = "txt">Текст на съобщението Ви:</label></td>
		               <td valign="top"><textarea  style="width:220px" name = "txt" cols = "30" rows = "5"></textarea></td>
		            </tr>
		            <tr><td colspan = "2">&nbsp;</td></tr>
		            <tr>
		               <td align = "right" colspan = "2" style = "padding-right: 80px; padding-bottom: 20px;">
		               <input type="submit" name = "sendFeedback" value = "изпрати" /></td>
		            </tr>
		         </table>
		      <input type = "hidden" name = "confirmOK" value = "" />
		</form>';


 
		}	
	}				

			
       
$stuff_big .= '</div>
	</div>
</div>	';


return $stuff_big;

?>