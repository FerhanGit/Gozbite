<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
 	$aphorism_main_edit = "";

   	$edit=$_REQUEST['edit'];



	if (isset($edit))
	{
		$editID=$edit;
		
		$clauses = array();
	   	$clauses['where_clause'] = " AND a.aphorismID = '".$editID."'";
		$clauses['order_clause'] = '';
		$clauses['limit_clause'] = ' LIMIT 1';
		$aphorism_edit_info = $this->getItemsList($clauses);
	
		if(!$aphorism_edit_info)
		{
			return false;
		}
		$resultEdit = $aphorism_edit_info[$editID];	
		
				
		/* Ne dopuskame redakciq na chujdi statii */
		if($resultEdit['autor'] != $_SESSION['userID'] && $_SESSION['user_kind'] != 2) exit;
		
	
	}

	
$aphorism_main_edit .= '<div id="search_form" style=" margin-top:0px; width:650px;">

<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #6DCA31; padding:5px; background-color:#F1F1F1;">

<div class="postBig">';
 		
	
	$aphorism_main_edit .= '<div style="margin:0px; margin-top:10px; width:100px;">';	
			  		
		  		if (eregi("^[0-9]+",$edit))
		  		{	
		  			$aphorism_main_edit .= '<input type="submit" value="Редактирай Афоризма" id="edit_btn" title="Редактирай Афоризма" name="edit_btn" onclick="return checkForCorrectDataAphorism();">';	
		  		
		  	 
		  		}
		  
		  	
		  		if (!eregi("^[0-9]+",$edit))
		  		{	
		  	
		  			$aphorism_main_edit .= '<input type="submit" value="Добави Афоризма" id="insert_btn" title="Добави Афоризма" name="insert_btn"  onclick="return checkForCorrectDataAphorism();">';	
		  		
		  	 
		  		}
					  	
				  		
				
	$aphorism_main_edit .= ' </div>
				  <br /><br /><br />
				  
				  <input type=\'hidden\' name=\'MAX_FILE_SIZE\' value=\'999999999\'>
				  <input type=\'hidden\' name=\'edit\' value=\''.$edit.'\'>
				  <input type=\'hidden\' name=\'autor\' value=\''.$resultEdit['autor'].'\'>
				  <input type=\'hidden\' name=\'autor_type\' value=\''.$resultEdit['autor_type'].'\'>
				
				 Текст на Афоризма*<br /> 
				 <textarea rows = "2" cols = "53"  name="aphorism_body" id="aphorism_body" >'.$resultEdit['body'].'</textarea>
			 	   <br /><br />
			 	   
				 Автор/Източник на Афоризма *<br /> 
				 <textarea rows = "1" cols = "53"  name="aphorism_title" id="aphorism_title" >'.$resultEdit['title'].'</textarea>
			 	  <br /><br />
			 	  			 	  			  
				            		 	            		 		
           		 <table><tr>
           		 	<td valign="top">
	           		  Снимка
					 	<div id="picsDv">';
						 					  		
	                  			$aphorism_main_edit .= "<div style = \"margin: 0px 0px 5px 0px;\">\n";
	                  			$aphorism_main_edit .= " <input type = \"file\" name = \"aphorism_pic\">";
	                  			$aphorism_main_edit .= "</div>\n";	               	  		
		           		 	      
	           		 $aphorism_main_edit .= '</div>	
           		 	
                  	</td>
                  	<td valign="top"> ';
	                 
						if ($resultEdit['picURL']!='')
						{  
							$aphorism_main_edit .= "<div style='float:left; margin:0px; width:200px;' >";
								  
						        			
							$aphorism_main_edit .= '<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><img width="60" height="60"  src="pics/aphorisms/';
							if($resultEdit['picURL']!='') $aphorism_main_edit .= $resultEdit['picURL']; 
							else $aphorism_main_edit .= "no_photo_thumb.png";
							
							$aphorism_main_edit .= '" /></div>
							<div style="float:left;cursor:pointer;" >
								<a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-снимка-на-афоризъм-'.$resultEdit['picURL'].','.(!empty($resultEdit['title'])?myTruncateToCyrilic($resultEdit['title'],100,'_',''):'интересни_забавни_поучителни_афоризми').'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
							</div>';
					
						  
						  	$aphorism_main_edit .= "</div>";
						}

				         
			       	$aphorism_main_edit .='</td></tr>
			       
       			</table>
       	 	<br /><br />
      Полетата отбелязани с "*" са задължителни.	   
      <br /><br />';
          
	if ($_REQUEST['edit'] > 0)
	{
		 $aphorism_main_edit .= '<input type=\'checkbox\' id=\'active'.$_REQUEST['edit'].'\' name=\'active'.$_REQUEST['edit'].'\' '.((($resultEdit["active"] == 1) ? 'checked' : '')).' onclick=\'if(this.checked) {set_active(1,"aphorism",'.$_REQUEST['edit'].','.$_SESSION['userID'].');} else{set_active(0,"aphorism",'.$_REQUEST['edit'].','.$_SESSION['userID'].');} \'/> Фразата е активна.<a href=\'#\' id=\'aktivirane_aphorism\' style=\'z-index:1000;\'><img src=\'images/help.png\' /></a>';
	
	}	 
	
	$aphorism_main_edit .= '<br /> <br />

 


      <div style="margin:0px; margin-top:10px; width:100px;">';	
			  		
	  		if (eregi("^[0-9]+",$edit))
	  		{	
	  	
	  		$aphorism_main_edit .= '<input type="submit" value="Редактирай Афоризма" id="edit_btn" title="Редактирай Афоризма" name="edit_btn"  onclick="return checkForCorrectDataAphorism();">	';
	  		
	  	
	  		}
	  	
	  	
	  		if (!eregi("^[0-9]+",$edit))
	  		{	
	  
	  		$aphorism_main_edit .= ' <input type="submit" value="Добави  Афоризма" id="insert_btn" title="Добави Афоризма" name="insert_btn"  onclick="return checkForCorrectDataAphorism();">	';
	  		
	  
	  		}
	  	
	
	  $aphorism_main_edit .= ' </div>
		 </div> </div>		     		 	
 </div>
 <br style="clear:left;">';
	

	        
	    
	return $aphorism_main_edit;
	  
	?>
