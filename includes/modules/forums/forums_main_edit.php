<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
 	$forums_main_edit = "";

  
	$edit = $_REQUEST['edit']?$_REQUEST['edit']:$_REQUEST['questionID'];
	$category_clause = ''; // tova e za da se znae dali da se vklu4i kategoriqta pri validirane
	$citate_text = '';
	$citate_title = '';
	
	if(isset($_REQUEST['citate']) && $_REQUEST['citate'] > 0)
	{
		$clauses = array();
	   	$clauses['where_clause'] = " AND q.questionID = '".$_REQUEST['citate']."'";
		$clauses['order_clause'] = '';
		$clauses['limit_clause'] = ' LIMIT 1';
		$forum_citate_info = $this->getItemsList($clauses);
	
		if(!$forum_citate_info)
		{
			return false;
		}
		$resultCitate = $forum_citate_info[$_REQUEST['citate']];	
		$citate_title .= "RE: ".($resultCitate['autor_type'] == 'user' ? get_user_nameByUserID($resultCitate['autor']) : get_firm_nameByFirmID($resultCitate['autor']));
		$citate_text .= "<u>".($resultCitate['autor_type'] == 'user' ? get_user_nameByUserID($resultCitate['autor']) : get_firm_nameByFirmID($resultCitate['autor']))."</u> каза: <br /><i><цитат>".$resultCitate['question_body']."<край на цитата></i><br /><br />";
		
	}
	
	if(isset($_REQUEST['edit_forum']) && $_REQUEST['edit_forum'] > 0)
	{
		$clauses = array();
	   	$clauses['where_clause'] = " AND q.questionID = '".$_REQUEST['edit_forum']."'";
		$clauses['order_clause'] = '';
		$clauses['limit_clause'] = ' LIMIT 1';
		$forum_edit_forum_info = $this->getItemsList($clauses);
	
		if(!$forum_edit_forum_info)
		{
			return false;
		}
		$resultEditForum = $forum_edit_forum_info[$_REQUEST['edit_forum']];	
		$citate_title .= $resultEditForum['question_title'];
		$citate_text .= $resultEditForum['question_body'];
		
		/* Ne dopuskame redakciq na chujdi statii */
		if($resultEditForum['autor'] != $_SESSION['userID'] && $_SESSION['user_kind'] != 2) exit;
		
	}
	
	if (isset($edit) && $edit > 0)
	{
		$editID=$edit;
		
		$clauses = array();
	   	$clauses['where_clause'] = " AND q.questionID = '".$editID."'";
		$clauses['order_clause'] = '';
		$clauses['limit_clause'] = ' LIMIT 1';
		$forum_edit_info = $this->getItemsList($clauses);
	
		if(!$forum_edit_info)
		{
			return false;
		}
		$resultEdit = $forum_edit_info[$editID];	
		
	
	}

	
$forums_main_edit .= '<div id="search_form" style=" margin-top:0px; width:650px;">

<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">

<div class="postBig">';
 		
$forums_main_edit .= '		<div class="detailsDiv" style="float:left; width:150px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
				<a  href="javascript://" onclick=" new Effect.toggle($(\'writeComment\'),\'Blind\'); "  style="color:#FFF; font-weight:bold;"  title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Напиши твоето мнение] body=[Публикувай мнение по тема, която те вълнува и коментирай съвместно с останалите потребители на GoZbiTe.Com!]\'><u> '.(($_REQUEST['questionID']>0 OR $_REQUEST['edit']>0)?' &rarr;Напиши твоето мнение':' &rarr;Създай нова тема').' </u></a> 
				<br style="clear:both;" />		
           	</div>

<div id="writeComment" style="display:'.(($_REQUEST['edit'] > 0 OR $_REQUEST['edit_forum'] > 0 OR isset($_REQUEST['insert_question_btn']) OR isset($_REQUEST['edit_question_btn']) OR (isset($_REQUEST['create_topic']) && $_REQUEST['create_topic'] == 1))?'block':'none').';  margin-top:20px; width:550px;">';
  
		
		if(isset($_REQUEST['edit_forum']) && $_REQUEST['edit_forum'] > 0)
		{	
			$forums_main_edit .= '<br style="clear:both;" />	<input type="submit" value="Редактирай" id="edit_question_btn" title="Редактирай" name="edit_question_btn" onclick="return checkForCorrectDataForum(\''.$category_clause.'\')">';	
		}
		else
		{	  	
			$forums_main_edit .= '<br style="clear:both;" />	<input type="submit"  value="Добави" id="insert_question_btn" title="Добави" name="insert_question_btn" onclick="if('.($_SESSION['userID']?'true':'false').') {return checkForCorrectDataForum(\''.$category_clause.'\');} else{alert(\'Съжалявам, необходимо е да влезете в системата за да направите своя коментар.\');return false;} ">';	
		}
				
				
		if((isset($_REQUEST['insert_question_btn']) OR isset($_REQUEST['edit_question_btn'])) && ((!empty($_REQUEST['question_title'])) && (!empty($_REQUEST['question_body']))) && !empty($_REQUEST['verificationcode']))
		{
			$forums_main_edit .= "<br style='clear:both;' />	<font color='red'>Благодарим Ви за активното участие в сайта GoZbiTe.Com. Вашето мнение/коментар ще бъде публикувано веднага щом се одобри от модератора.</font>";
		}
		elseif(isset($_REQUEST['insert_question_btn']) OR isset($_REQUEST['edit_question_btn']))
		{
			$forums_main_edit .= "<br style='clear:both;' />	<font color='red'>Вашето мнение/коментар не беше публикувано сполучливо, поради неправилно попълнена форма. Благодарим Ви за активното участие в сайта GoZbiTe.Com.</font>";
		
		}

		$forums_main_edit .= '	<br style="clear:both;" />
				
				<input type=\'hidden\' name=\'MAX_FILE_SIZE\' value=\'4000000\'>
				<div id="writeComment" style="margin-left:20px;"> '; 
		
		if(count($resultEdit)<1)
		{	    	 
		 	$category_clause = 'question_category';
	    
			
			$forums_main_edit .= ' 	<br /> Раздел* : <br />
			 	<select name="question_category" id="question_category">
	
				<option value ="">избери</option>';
              
                 		$sql="SELECT * FROM question_category ORDER BY rank, name";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultCat=$conn->result;
						$numCat=$conn->numberrows;
						for ($i=0;$i<$numCat;$i++)
					   {      
						 $forums_main_edit .= ' <option value = "'.$resultCat[$i]['id'].'">'.$resultCat[$i]['name'].'</option> ';
									 
					   } 
				  $forums_main_edit .= '</select>';

		}
		else {
		 	$forums_main_edit .= '<input type="hidden" name="question_category" value="'.$resultEdit['category_id'].'"/>';			
		}
				  
			if(isset($_REQUEST['edit_forum']) && $_REQUEST['edit_forum'] > 0)
			{
				$forums_main_edit .= '<input type=\'hidden\' name=\'edit_forum\' value=\''.$_REQUEST['edit_forum'].'\'>
				  <input type=\'hidden\' name=\'autor\' value=\''.$resultEditForum['autor'].'\'>
				  <input type=\'hidden\' name=\'autor_type\' value=\''.$resultEditForum['autor_type'].'\'>'; // naro4no ostavqme originalniq avtor
				
			}

			
			if(isset($edit) && isset($_REQUEST['edit_forum']) && $edit == $_REQUEST['edit_forum'])
			{
				$parentID = 0;
				$forums_main_edit .= '<input type=\'hidden\' name=\'edit_forum\' value=\''.$_REQUEST['edit_forum'].'\'>
				  <input type=\'hidden\' name=\'autor\' value=\''.$resultEditForum['autor'].'\'>
				  <input type=\'hidden\' name=\'autor_type\' value=\''.$resultEditForum['autor_type'].'\'>'; // naro4no ostavqme originalniq avtor
				
			}
			elseif(isset($edit) && $edit > 0)					  
			{
				$parentID = $edit;
			}
			else
			{
				$parentID = $edit;
			}
			$forums_main_edit .= '	 <br style="clear:both;"/> 
				 <input type="hidden" name="parentID" value="'.$parentID.'"/>

				  <table>
    				 <tr><td colspan="2">	    				  				
    				 		 <br /> Заглавие* :<br /> 
    				 		<textarea rows = "1" cols = "80"  name="question_title" id="question_title"   maxlength="100" onkeyup="return ismaxlength(this)">'.$citate_title.'</textarea>
    				</td></tr>
    				
    				 <tr><td colspan="2">	    				  				
    				 		 <br /> Текст* :<br /> ';
							 			
				include_once("FCKeditor/fckeditor.php");
				$oFCKeditor = new FCKeditor('question_body') ;
				$oFCKeditor->BasePath   = "FCKeditor/";
				$oFCKeditor->Width      = '640';
				$oFCKeditor->Height     = '300' ;
				$oFCKeditor->Value      = ((strlen($citate_text) > 0) ? $citate_text : ""); 
		        $forums_main_edit .= $oFCKeditor->CreateHtml();
			

    				 	
    				$forums_main_edit .= '</td></tr>
    				
    				<tr><td valign="top">
    				 <br />
    				  		 <fieldset style="width:120px;" ><img src="verificationimage/picture.php" /></fieldset>
				      		
    				 </td><td valign="top">
    				 <br />
    				 		<input type="text" name="verificationcode" value="" />
    				 		<br />
							Въведете кода, показан на картинката.		
					</td></tr>
					
    				</table>
    							  
    				    <br /> <br />';

    				 
				if(isset($_REQUEST['edit_forum']) && $_REQUEST['edit_forum'] > 0)
				{	
		  			$forums_main_edit .= '<input type="submit" value="Редактирай" id="edit_question_btn" title="Редактирай" name="edit_question_btn" onclick="return checkForCorrectDataForum(\''.$category_clause.'\')">';	
		  		}
				else
				{	  	
		  			$forums_main_edit .= ' <input type="submit"  value="Добави" id="insert_question_btn" title="Добави" name="insert_question_btn" onclick="if('.($_SESSION['userID']?'true':'false').') {return checkForCorrectDataForum(\''.$category_clause.'\');} else{alert(\'Съжалявам, необходимо е да влезете в системата за да направите своя коментар.\');return false;} ">';	
		  		}
				
$forums_main_edit .= '									
    			</div>
    
     			
</div>';

	  $forums_main_edit .= ' </div>
		 </div>	     		 	
 </div>
 <br style="clear:left;">';
	

	        
	    
	return $forums_main_edit;
	  
	?>
