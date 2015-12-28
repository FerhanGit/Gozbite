<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$forum_big = "";
   	
	$clauses = array();
   	$clauses['where_clause'] = " AND q.questionID = '".$_REQUEST['questionID']."'";
	$clauses['order_clause'] = '';
	$clauses['limit_clause'] = ' LIMIT 1';
	$forum_big_info = $this->getItemsList($clauses);

	if(!$forum_big_info)
	{
		return false;
	}
	$forumBig = $forum_big_info[$_REQUEST['questionID']];	
		
	
	$forum_big .=	'<script type="text/javascript">
						makeViewLog(\'question\',\''.$forumBig['questionID'].'\');
					</script>';
	
$forum_big .= '
<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">

<div class="postBig">';



//************ Автора за всяка тема ****************
		$sql="SELECT ".(($forumBig['autor_type']=='user')?" CONCAT(first_name, ' ', last_name)":'name')." as 'autor_name', username as 'autor_username', location_id as 'location_id' FROM ".(($forumBig['autor_type']=='user')?'users':'firms')." WHERE ".(($forumBig['autor_type']=='user')?'userID':'id')." = '".$forumBig['autor']."' LIMIT 1";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultMneniqAvtor = $conn->result['autor_name'];	
		$resultQuestionAvtorUsername = $conn->result['autor_username'];
		$resultMneniqAvtorLocation = $conn->result['location_id'];
		
		if($forumBig['autor'] == 1 && $forumBig['autor_type'] == 'user')
		{
			$resultMneniqAvtor = 'Админ';
		}
		
		if($forumBig['autor_type']=='user')
		{
			if(is_file("pics/users/".$forumBig['autor']."_avatar.jpg")) $picFileQuestionOwner= "pics/users/".$forumBig['autor']."_avatar.jpg";
		   	else $picFileQuestionOwner = 'pics/users/no_photo_thumb.png';
		}
		elseif($forumBig['autor_type']=='firm')
		{
			if(is_file("pics/firms/".$forumBig['autor']."_logo.jpg")) $picFileQuestionOwner= "pics/firms/".$forumBig['autor']."_logo.jpg";
		   	else $picFileQuestionOwner = 'pics/firms/no_logo.png';
		}
		
	   		
		list($width, $height, $type, $attr) = getimagesize($picFileQuestionOwner);
		$pic_width_or_height = 100;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
		if (($height) && ($width))	
		{
			if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
			else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
		}
			 
	//***********************************************************************
	
	
	//========================= Вземаме броя на мненията за всеки Участник =============================
	
    	$sql="SELECT cnt_comment FROM ".(($forumBig['autor_type']=='user')?'users':'firms')." WHERE ".(($forumBig['autor_type']=='user')?'userID':'id')." = '".$forumBig['autor']."' LIMIT 1";
    	$conn->setsql($sql);
    	$conn->getTableRow();
		$resultCntMneniqForAutor = $conn->result['cnt_comment'];
    	
	//==================================================================================================
	
	//========================= Проверяваме дали участника е ОН-Лайн ===================================
			
    	$sql="SELECT session_name FROM sessions WHERE session_name = '".$resultQuestionAvtorUsername."' LIMIT 1";
    	$conn->setsql($sql);
    	$conn->getTableRow();
		$resultAutorOnLine = (($conn->result['session_name'] != '')?1:0);
    	
	//==================================================================================================
					
				
				
$forum_big .= '
<div class="postBig">

		<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
			
			<table><tr><td valign="top">
				<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
					'.(($forumBig['autor_type'] == 'user') ? '<a href="разгледай-потребител-'.$forumBig['autor'].',сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html">'.$resultMneniqAvtor : (($forumBig['autor_type'] == 'firm')? '<a href="разгледай-фирма-'.$forumBig['autor'].',сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html">'.$resultMneniqAvtor :''))  .'</a>
				</div>
				<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
					<h3><a style="color:#0099FF; font-size:10px; " href="http://gozbite.com/разгледай-дестинация-'.$resultMneniqAvtorLocation .','.str_replace(array(' ',','),array('_','_'),locationTracker($resultMneniqAvtorLocation)).'_описание_на_градове_села_курорти_дестинации_от_цял_свят.html">'.locationTracker($resultMneniqAvtorLocation).'</a></h3>
				</div>
		        
				<div style="border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >'.(($forumBig['autor_type'] == 'user') ? '<a href="разгледай-потребител-'.$forumBig['autor'].',сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html">' : (($forumBig['autor_type'] == 'firm')? '<a href="разгледай-фирма-'.$forumBig['autor'].',сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html">' : '')).'<img width="'.$newwidth.'" height="'.$newheight.'" src="'.$picFileQuestionOwner.'" /></a></div>
				<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
					Мнения:'.$resultCntMneniqForAutor.'
				</div>
				<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
					'.(($resultAutorOnLine == 1)?'<font color="green">Он-лайн</font>':'<font color="red">Оф-лайн</font>').'
				</div>		
				<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
					<fb:like href="http://www.gozbite.com/разгледай-форум-тема-'.get_question_parentID($forumBig['questionID']).','.myTruncateToCyrilic(strip_tags($forumBig['question_body']),200,'_','') .'.html#question_'.$forumBig['questionID'].'" layout="button_count"	show_faces="false" width="50" height="21" action="like" colorscheme="light"></fb:like>								
				</div>
			</td>
			<td style="border-right:1px dotted #CCCCCC; padding:2px; width:10px;"></td>
			<td valign="top">
				
	    
	    <div class="detailsDiv" style="float:left; width:510px;margin-bottom:0px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
	    	<div style=" float:left; font-size:14px; margin-left:6px; color:#FFF; " >Прочетено '.($forumBig['cnt']?$forumBig['cnt']:1 ).' пъти</div>
			<div style=" float:left; font-size:14px; margin-right:5px; color:#FFF;" > | <a style="font-size:14px; color:#FFF; text-decoration:underline;" href="javascript://" onclick=" new Effect.toggle($(\'readComment\'),\'Blind\'); "> ('.($forumBig['numQuestionAnsers']?$forumBig['numQuestionAnsers']:0).') отговор/и</a> </div>								
			<br style="clear:both;"/>
	    </div>
	    <br style="clear:both;" />	';   
	   
	   $forum_big .= ' <h4 style="color:#FF8400"><a href="разгледай-форум-тема-'.get_question_parentID($forumBig['questionID']).','.$_REQUEST['page'].','.myTruncateToCyrilic($forumBig['question_title'],200,'_','') .'.html#question_'.$forumBig['questionID'].'">'.stripslashes($forumBig['question_title']) .'</a></h4>
			
				<div class="detailsDiv" style="float:left; width:510px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
					<div style=" float:left; margin-right:5px;  font-size:12px;  font-weight:bold; color:#FFF; width:180px;" >
							
						<a href="отговори-форум-тема-'.$forumBig['questionID'].','.$_REQUEST['page'].','.myTruncateToCyrilic($forumBig['question_title'],200,'_','') .'.html"><img src="images/forum_otgovori.png" /></a>
						<a href="отговори-форум-тема-цитирай-'.$forumBig['questionID'].','.$forumBig['questionID'].','.myTruncateToCyrilic($forumBig['question_title'],200,'_','') .'.html"><img src="images/forum_otgovori_citat.png" /></a>							
						
					</div>
					<div style="float:right; background-image:url(images/comment.png); background-position:top; background-repeat:no-repeat; width:25px; height:25px; text-align:center; font-size:8px; color:#FF6600;">'.($forumBig['numQuestionAnsers']?$forumBig['numQuestionAnsers']:0).'</div>
					<div style=" float:right; margin-right:5px; color:#FFF; font-size:12px; font-weight:bold;" ><i>'.convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($forumBig['created_on']))).'</i></div>
					<div style=" float:right; margin-right:5px;  font-size:12px;  font-weight:bold; color:#FFF;" ><h3 align="left"><a style=" font-size:12px; color:#FFF;" href="форум-категория-'.$forumBig['category_id'].','.myTruncateToCyrilic($forumBig['category'],200,'_','') .'.html">'.$forumBig['category'].'</a> | </h3></div>';						
					
					if((($forumBig['autor'] == $_SESSION['userID'] && $_SESSION['user_type']==$forumBig['autor_type']) or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) {	
						$forum_big .= '<div style="float:right; margin-right:5px;" ><a href="редактирай-форум-мнение-'.$forumBig['questionID'].','.$forumBig['questionID'].','.myTruncateToCyrilic($forumBig['question_title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>';
					}
					if(($_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) {
						$forum_big .= '<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm(\'Сигурни ли сте?\')) {return false;}" href="изтрий-форум-тема-'.$forumBig['questionID'].','.myTruncateToCyrilic($forumBig['question_title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
					}					
					$forum_big .= '<br style="clear:both;"/>	
		        </div>
		                 				
				<div id="questionBodyDiv" style=" margin-left:0px; width:510px;">';
					
		 		if(count($forumBig)>0)
			    	{  
		    			$forum_big .= stripslashes(proceed_citate($forumBig['question_body'])); 
		    		}    	   	
				$forum_big .= '
		   		 </div> 
				
			</td></tr></table>
			
			<hr style="float:left;margin-top:20px;color: #eee;background-color: #eee; height:1px; border:0; width:650px;" />  
			
			<br style="clear:both;" />
		</div>';
				 
 		
	   
$forum_big .= '<div id="options">
	
<div id="starDiv" style=" float:left;width:200; margin-top:0px; color:#ffffff;"> </div>';

$forum_big .= '<script language="javascript" type="text/javascript">
   new Starbox("starDiv", '.$forumBig['rating'].', { rerate: false, max: 6, stars: 6, buttons: 12, color:"#FF6600",hoverColor:"#0099FF", total: '.$forumBig['times_rated'].', indicator: " Рейтинг #{average} от #{total} гласа", ghosting: true ,onRate: function(element, info) {
   	var indicator = element.down(".indicator");
  	var restore = indicator.innerHTML;
    indicator.update("Вие дадохте оценка " + info.rated.toFixed(2));
    window.setTimeout(function() { indicator.update("Благодарности!") }, 2000);
    //window.setTimeout(function() { indicator.update(restore) }, 4000);
    new Effect.Highlight(indicator);
    
     
	}});';
	
$forum_big .= 'function saveStar(event) {
			
	  new Ajax.Request("includes/tools/savestar.php?questionID='.$_REQUEST['questionID'].'", {
	    parameters: event.memo,  
	    onSuccess: function(transport) {
		   	var indicator = $(\'starDiv\').down(\'.indicator\');
		    if (transport.responseText){   
		    	window.setTimeout(function() { indicator.update(transport.responseText) }, 4000);  	    	  		    	    	
		    }     
		    else indicator.update("Вие ще сте пръв с Вашата оценка");	  
			}
		}
	  );
}         
document.observe("starbox:rated", saveStar);

</script>';


$forum_big .= '<div style="float:right;margin-right:10px;">
            <div style="float:left; margin-right:2px;" >
				<span style="background:transparent; color:#FFFFFF; font-size:12px; font-weight:bold;">Сподели в: </span>
				<a href="http://www.facebook.com/sharer.php?u=http://www.gozbite.com/разгледай-форум-тема-'.get_question_parentID($forumBig['questionID']).','.myTruncateToCyrilic($forumBig['question_title'],200,'_','') .'.html#question_'.$forumBig['questionID'].'&amp;t='.$forumBig['question_title'].'" target="_blank"><img src="images/facebook.png" border="0" alt="" question_title="" width="16" hspace="1" height="16" class="absmiddle" /></a>&nbsp;
				<a href="http://twitter.com/home?status='.myTruncateToCyrilic($forumBig['question_title'],200,'_','') .', http://www.gozbite.com/разгледай-форум-тема-'.$forumBig['questionID'].','.myTruncateToCyrilic($forumBig['question_title'],200,'_','') .'.html" target="_blank"><img src="images/twitter.png" border="0" alt="" question_title="" width="16" hspace="1" height="16" class="absmiddle" /></a>&nbsp;<a href="http://www.google.com/buzz/post" data-locale="bg" target="_blank"><img src="i/ico/google.png" border="0" alt="" question_title="" width="16" hspace="1" height="16" class="absmiddle" /></a>
			</div>';
			
$forum_big .= '<div style="float:right; margin-right:2px;" >';
$forum_big .= '<a href = "javascript://void(0);" onclick = \'window.open("includes/tools/sendStuffToFriend.php?questionID='.$forumBig['questionID'].'", "sndWin", "top=0, left=0, width=440px, height=500px, resizable=yes, toolbars=no, scrollbars=yes");\' class = "smallOrange"><img style="margin-left:5px;" src="images/send_to_friend.png" alt="Изпрати на приятел" width="14" height="14"></a></div>';
$forum_big .= '<div style="float:right; margin-right:2px;" >';
$forum_big .= '<a href = "javascript://" onclick = "window.print();"  class = "smallOrange"><img style="margin-left:5px;" src="images/print.gif" alt="Разпечатай" width="14" height="14"></a></div>';
$forum_big .= '</div></div>';

$forum_big .= '

	  			<br style="clear:both;"/>   		    	
					
		<div id="readComment" style="width:650px;display:block;margin-left:0px;">';
			
		

// ==================== ALL RESULTS =========================
   	$clauses = array();
	$clauses['where_clause'] = "  AND q.active = '1' AND q.parentID = '".$forumBig['questionID']."'";
	$clauses['order_clause'] = '  ORDER BY q.created_on DESC';
	$clauses['limit_clause'] = '';
	$items_all = $this->getItemsList($clauses);
	$total = count($items_all);
//----------------- paging ----------------------


		$pp = $_REQUEST['limit']!=""?$_REQUEST['limit']:10; 
	
		$numofpages = ceil($total / $pp);
		if ((!isset($_REQUEST['page']) or ($_REQUEST['page']==""))) 
		{
			$page = 1;
		}
		else
		{
			$page = $_REQUEST['page'];
		}
		$limitvalue = $page * $pp - ($pp);
// -----------------------------------------------  

   	
   	
   	
	// =================== PER PAGE LISTING =====================
	$clauses = array();
	$clauses['where_clause'] = " AND q.active = '1' AND q.parentID = '".$forumBig['questionID']."'";
	$clauses['order_clause'] = ' ORDER BY q.created_on ASC';
	$clauses['limit_clause'] = ' LIMIT '.$limitvalue.' , '.$pp;
	$items = $this->getItemsList($clauses);
	
	
			
			if($items) 
			{
			
				$forum_big .=  '<div class="paging" style="float:left;  width:300px; margin:10px 180px 10px 180px;  padding:5px 0 5px 0;" align="center">';
			
				$forum_big .= per_page("разгледай-форум-тема-".$forumBig['questionID'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
				
				$forum_big .= '<div align="center" style="margin-top:10px;">';
				$forum_big .= '	по
						<select style="width:50px;" name="limit_fast" id="limit_fast"  onchange="fastLimit(this);">
							<option value="5"  '.(($_REQUEST['limit'] == 5)?"selected":"").'  selected>5</option>
							<option value="10"  '.((!isset($_REQUEST['limit']) OR $_REQUEST['limit'] == 10)?"selected":"").'  >10</option>
							<option value="20"  '.(($_REQUEST['limit'] == 20)?"selected":"").'  >20</option>
							<option value="50"  '.(($_REQUEST['limit'] == 50)?"selected":"").'  >50</option>
							<option value="100"  '.(($_REQUEST['limit'] == 100)?"selected":"").' >100</option>				  			
						</select>
						на страница
					</div>
				
				</div> ';
		 	
				$i=0;
				foreach ($items as $questionID => $forumAnsers)
				{
	    	    
	    	    //************ Автора за всяка тема ****************
					$sql="SELECT ".(($forumAnsers['autor_type']=='user')?" CONCAT(first_name, ' ', last_name)":'name')." as 'autor_name', username as 'autor_username', location_id as 'location_id'  FROM ".(($forumAnsers['autor_type']=='user')?'users':'firms')." WHERE ".(($forumAnsers['autor_type']=='user')?'userID':'id')." = '".$forumAnsers['autor']."' LIMIT 1";
					$conn->setsql($sql);
					$conn->getTableRow();
					$resultAnserAvtor = $conn->result['autor_name'];	
					$resultAnserAvtorUsername = $conn->result['autor_username'];	
					$resultAnserAvtorLocation = $conn->result['location_id'];
	
					if($forumAnsers['autor'] == 1 && $forumAnsers['autor_type'] == 'user')
					{
						$resultAnserAvtor = 'Админ';
					}
			
					if($forumAnsers['autor_type']=='user')
					{
						if(is_file("pics/users/".$forumAnsers['autor']."_avatar.jpg")) $picFileAnserOwner= "pics/users/".$forumAnsers['autor']."_avatar.jpg";
					   	else $picFileAnserOwner = 'pics/users/no_photo_thumb.png';
					}
					elseif($forumAnsers['autor_type']=='firm')
					{
						if(is_file("pics/firms/".$forumAnsers['autor']."_logo.jpg")) $picFileAnserOwner= "pics/firms/".$forumAnsers['autor']."_logo.jpg";
					   	else $picFileAnserOwner = 'pics/firms/no_logo.png';
					}
					
				   		 
					list($width, $height, $type, $attr) = getimagesize($picFileAnserOwner);
					$pic_width_or_height = 100;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
					if (($height) && ($width))	
					{
						if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
						else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
					}			
		
				//***********************************************************************

				//========================= Вземаме броя на мненията за всеки Участник =============================
				
			    	$sql="SELECT cnt_comment FROM ".(($forumAnsers['autor_type']=='user')?'users':'firms')." WHERE ".(($forumAnsers['autor_type']=='user')?'userID':'id')." = '".$forumAnsers['autor']."' LIMIT 1";
			    	$conn->setsql($sql);
			    	$conn->getTableRow();
					$resultCntMneniqForAutor = $conn->result['cnt_comment'];
			    	
				//==================================================================================================
				
				//========================= Проверяваме дали участника е ОН-Лайн ===================================
						
			    	$sql="SELECT session_name FROM sessions WHERE session_name = '".$resultAnserAvtorUsername."' LIMIT 1";
			    	$conn->setsql($sql);
			    	$conn->getTableRow();
					$resultAutorOnLine = (($conn->result['session_name'] != '')?1:0);
			    	
				//==================================================================================================
					
	    	$forum_big .= '<div class="detailsDiv"  id="question_'.$forumAnsers['questionID'].'"  style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #FF6600; padding:5px; background-color:#F1F1F1;">
				<table><tr><td valign="top">
					
				<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
					'.(($forumAnsers['autor_type'] == 'user') ? '<a href="разгледай-потребител-'.$forumAnsers['autor'].',сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html">'.$resultAnserAvtor : (($forumAnsers['autor_type'] == 'firm')? '<a href="разгледай-фирма-'.$forumAnsers['autor'].',сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html">'.$resultAnserAvtor :'')) .'</a>
				</div>
				<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
					<h3><a style="color:#0099FF; font-size:10px; " href="http://gozbite.com/разгледай-дестинация-'.$resultAnserAvtorLocation .','.str_replace(array(' ',','),array('_','_'),locationTracker($resultAnserAvtorLocation)).'_описание_на_градове_села_курорти_дестинации_от_цял_свят.html">'.locationTracker($resultAnserAvtorLocation).'</a></h3>
				</div>
		       <div style="border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >'.(($forumAnsers['autor_type'] == 'user') ? '<a href="разгледай-потребител-'.$forumAnsers['autor'].',сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html">' : (($forumAnsers['autor_type'] == 'firm')? '<a href="разгледай-фирма-'.$forumAnsers['autor'].',сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html">' : '')).'<img width="'.$newwidth.'" height="'.$newheight.'" src="'.$picFileAnserOwner.'" /></a></div>
					
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						Мнения:'.$resultCntMneniqForAutor.'
					</div>
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						'.(($resultAutorOnLine == 1)?'<font color="green">Он-лайн</font>':'<font color="red">Оф-лайн</font>').'
					</div>	
					<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
						<fb:like href="http://www.gozbite.com/разгледай-форум-тема-'.get_question_parentID($forumBig['questionID']).','.myTruncateToCyrilic(strip_tags($forumAnsers['question_body']),200,'_','') .'.html#question_'.$forumAnsers['questionID'].'" layout="button_count"	show_faces="false" width="50" height="21" action="like" colorscheme="light"></fb:like>								
					</div>					
				</td>
				<td style="border-right:1px dotted #CCCCCC; padding:2px; width:10px;"></td>
				<td valign="top">
					<h4 style="color:#0099FF;"><a   style="color:#0099FF;" href="разгледай-форум-тема-'.get_question_parentID($forumAnsers['questionID']).','.$page.','.myTruncateToCyrilic($forumAnsers['question_title'],200,'_','') .'.html#question_'.$forumAnsers['questionID'].'">'.$forumAnsers['question_title'] .'</a></h4>
				
					<div class="detailsDiv" style="float:left; width:510px;margin-bottom:20px; border-top:3px solid #FF6600; padding:5px; background-color:#FF9900;">
						<a href="отговори-форум-тема-'.$forumBig['questionID'].','.$_REQUEST['page'].','.myTruncateToCyrilic($forumBig['question_title'],200,'_','') .'.html"><img src="images/forum_otgovori.png" /></a>							
						<a href="отговори-форум-тема-цитирай-'.$forumBig['questionID'].','.$forumAnsers['questionID'].','.myTruncateToCyrilic($forumBig['question_title'],200,'_','') .'.html"><img src="images/forum_otgovori_citat.png" /></a>							
						<div style=" float:right; margin-right:5px; color:#FFF; font-size:12px; font-weight:bold;" ><i>'.convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($forumAnsers['created_on']))).'</i></div>
						<div style=" float:right; margin-right:5px;  font-size:12px;  font-weight:bold; color:#FFF;" ><h3 align="left"><a style=" font-size:12px; color:#FFF;" href="форум-категория-'.$forumBig['category_id'].','.myTruncateToCyrilic($forumBig['category'],200,'_','') .'.html">'.$forumBig['category'].'</a> | </h3></div>';						
						
						if((($forumAnsers['autor'] == $_SESSION['userID'] && $_SESSION['user_type']==$forumAnsers['autor_type']) or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) {	
							$forum_big .= '<div style="float:right; margin-right:5px;" ><a href="редактирай-форум-мнение-'.$forumBig['questionID'].','.$forumAnsers['questionID'].','.myTruncateToCyrilic($forumAnsers['question_title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>';
						}
						if(($_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) {
							$forum_big .= '<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm(\'Сигурни ли сте?\')) {return false;}" href="изтрий-форум-мнение-'.$forumAnsers['questionID'].','.myTruncateToCyrilic($forumAnsers['question_title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
						}				
						$forum_big .= '<br style="clear:both;"/>	
			        </div>
			                 				
					<div  style="margin-top:5px; width:510px; overflow:hidden;  ">
			       		'.stripslashes(proceed_citate($forumAnsers['question_body'])).'						
					</div>    
					
				</td></tr></table>
				
				<hr style="float:left;margin-top:20px;color: #eee;background-color: #eee; height:1px; border:0; width:650px;" />  
				
				<br style="clear:both;" />
			</div>';
			
					 		
	    	  
                } 
				
				$forum_big .=  '<div class="paging" style="float:left;  width:300px; margin:10px 180px 10px 180px;  padding:5px 0 5px 0;" align="center">';
				$forum_big .= per_page("разгледай-форум-тема-".$forumBig['questionID'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
				$forum_big .= '</div>';	
			
	    	}    
			
	    	
	    	$forum_big .= '</div>	
			<br style="clear:both;" />	   
				
  </div>';

		$forum_big .= '	
					

</div>
<br style="clear:left;"/></div>';


return $forum_big;

?>