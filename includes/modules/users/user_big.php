<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	$user_big = "";
	
	if($_REQUEST['userID'] == 1) 
	{ 
		$users_main_edit .='<script type="text/javascript">
	       window.location.href=\'прочети-статии,интересни_статии_полезни_съвети_за_готвене_и_хранене.html\';
		</script>';
	
	}
	
	
	$sql="SELECT * FROM users WHERE userID = '".$_REQUEST['userID']."' LIMIT 1";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultUserProfile = $conn->result;
	$numUserProfile    = $conn->numberrows;
	
		   	
   
   	
$user_big .= '<div id="contentUser" style="background-color:#E9F2FC;" align="center">';

$user_big .= '<div class="postBig">
					<h4>
						<div style="margin-left:6px; height:22px; width:450px;color:#0099FF;font-weight:bold;" >Профил на Майстор-Готвача</div>		
					</h4>
					<br style="clear:both;" />
				</div>';
	
	
	//***********************************************************************
		
		if(is_file("pics/users/".$resultUserProfile[0]['userID']."_avatar.jpg")) $picFile= "pics/users/".$resultUserProfile[0]['userID']."_avatar.jpg";
	   	else $picFile = 'pics/users/no_photo_thumb.png';
		
		list($width, $height, $type, $attr) = getimagesize($picFile);
		$pic_width_or_height = 100;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
		if (($height) && ($width))	
		{
			if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
			else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
		}
			 
	//***********************************************************************
	

		//========================= Проверяваме дали участника е ОН-Лайн ===================================
			
    	$sql="SELECT session_name FROM sessions WHERE session_name = '".$resultUserProfile[0]['username']."' LIMIT 1";
    	$conn->setsql($sql);
    	$conn->getTableRow();
	$resultAutorOnLine = (($conn->result['session_name'] != '')?1:0);
    	
	//==================================================================================================
					
				

		
	//========================= Проверяваме дали участника има приетели ===================================
			
    	$sql="SELECT * FROM friendships WHERE (sender = '".$resultUserProfile[0]['userID']."' OR recipient = '".$resultUserProfile[0]['userID']."') AND friendship_accepted = '1'";
    	$conn->setsql($sql);
    	$conn->getTableRows();
	$numFriends = $conn->numberrows;
    	$resultFriends = $conn->result;
    	
	//==================================================================================================
					

    //================================== Последни Мнения/Коментари =====================================
			
    	$sql="SELECT questionID as 'questionID', question_body as 'question_body' FROM questions WHERE autor_type = 'user' AND autor = '".$resultUserProfile[0]['userID']."' LIMIT 5";
    	$conn->setsql($sql);
    	$conn->getTableRows();
	$numLastQuestions = $conn->numberrows;
    	$resultLastQuestions = $conn->result;
    	
	//==================================================================================================
					
	//====================================== Последни Статии ===========================================
			
    	$sql="SELECT postID as 'postID', body as 'body' FROM posts WHERE autor_type = 'user' AND autor = '".$resultUserProfile[0]['userID']."' LIMIT 5";
    	$conn->setsql($sql);
    	$conn->getTableRows();
	$numLastPosts = $conn->numberrows;
    	$resultLastPosts = $conn->result;
    	
	//==================================================================================================

    	
    					
	//====================================== Последни Рецепти ===========================================
			
    	$sql="SELECT id as 'id', title as 'title' FROM recipes WHERE user_id = '".$resultUserProfile[0]['userID']."' LIMIT 5";
    	$conn->setsql($sql);
    	$conn->getTableRows();
	$numLastRecipes = $conn->numberrows;
    	$resultLastRecipes = $conn->result;
    	
	//==================================================================================================

    	
    						
	//====================================== Последни Напитки ===========================================
			
    	$sql="SELECT id as 'id', title as 'title' FROM drinks WHERE user_id = '".$resultUserProfile[0]['userID']."' LIMIT 5";
    	$conn->setsql($sql);
    	$conn->getTableRows();
	$numLastDrinks = $conn->numberrows;
    	$resultLastDrinks = $conn->result;
    	
	//==================================================================================================
		
	
    	
    						
	//====================================== Последни Заболявания ===========================================
			
    	$sql="SELECT bolestID as 'bolestID', title as 'title' FROM bolesti WHERE autor_type = 'user' AND autor = '".$resultUserProfile[0]['userID']."' LIMIT 5";
    	$conn->setsql($sql);
    	$conn->getTableRows();
	$numLastBolesti = $conn->numberrows;
    	$resultLastBolesti = $conn->result;
    	
	//==================================================================================================
		
	
    						
	//====================================== Последни Справочни Описания ===========================================
			
    	$sql="SELECT id as 'id', title as 'title' FROM guides WHERE user_id AND autor = '".$resultUserProfile[0]['userID']."' LIMIT 5";
    	$conn->setsql($sql);
    	$conn->getTableRows();
	$numLastGuides = $conn->numberrows;
    	$resultLastGuides = $conn->result;
    	
	//==================================================================================================


	//====================================== Последни Фрази ===========================================
			
    	$sql="SELECT aphorismID as 'aphorismID', body as 'body' FROM aphorisms WHERE autor_type = 'user' AND autor = '".$resultUserProfile[0]['userID']."' LIMIT 5";
    	$conn->setsql($sql);
    	$conn->getTableRows();
	$numLastAphorisms = $conn->numberrows;
    	$resultLastAphorisms = $conn->result;
    	
	//==================================================================================================
		
	
	if($resultUserProfile[0]['userID'] == 1)
	{
		$resultProfilName = 'Админ';
	}
	else
	{
		$resultProfilName = ($resultUserProfile[0]['first_name'].' '.$resultUserProfile[0]['last_name']);
	}
	
	
$user_big .= '	
	<div class="detailsDiv" style="float:left; width:640px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; margin-left:6px; background-color:#FFFFFF; ">
			<table><tr><td valign="top">
				<div style="border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" ><a href="разгледай-потребител-'.$resultUserProfile[0]['userID'].','.myTruncateToCyrilic($resultUserProfile[0]['first_name'].' '.$resultUserProfile[0]['last_name'],200,'_','') .'.html"><img width="'.$newwidth.'" height="'.$newheight.'" src="'.$picFile.'" /></a></div>
				
				<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
					'.(($resultAutorOnLine == 1)?'<font color="green">Он-лайн</font>':'<font color="red">Оф-лайн</font>').'
				</div>';
				if($_SESSION['userID'] > 0) {
$user_big .= '		<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
					<a style="font-size:10px; " href="приятел-потребител-from_profile=1&friend_type=user&add_friend='.$resultUserProfile[0]['userID'].'&userID='.$resultUserProfile[0]['userID'] .',гозбите_ком_приятелства.html" onclick="if(!confirm(\'Сигурни ли сте, че искате да го добавите за Ваш приятел?\')) return false;">Стани Приятел</a>
					</div>';	
				 } 
				else { 	
$user_big .= '		<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
					<a style="font-size:10px; " href="javascript:void(0);" onclick="alert(\'Ако искате да го добавите за Ваш приятел - трябва да се регистрирате!\'); return false;">Стани Приятел</a>				
					</div>	';
				} 		
				if($_SESSION['userID'] > 0) 
				{							
$user_big .= '		<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >';
					$user_big .= sprintf("<a style=\"font-size:10px; \" href = \"javascript://\" onclick = \"window.open('includes/tools/sendMSGtofriend.php?userID=%d', 'sndWin', 'top=0, left=0, width=400px, height=300px, resizable=no, toolbars=no, scrollbars=yes');\"> Изпрати Съобщение</a>", $resultUserProfile[0]['userID']);				
$user_big .= '		</div>';		
			    } 	
				else {
$user_big .= '		<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
					<a style="font-size:10px; " href="javascript:void(0);" onclick="alert(\'Ако искате да изпратите Съобщение - трябва да имате се регистрирате!\'); return false;">Изпрати Съобщение</a>								
					</div>	';
				} 		
$user_big .= '</td>
			<td style="border-right:1px dotted #CCCCCC; padding:2px; width:10px;"></td>
			<td valign="top">
				<h4 style="color:#FF8400">'.$resultProfilName.'</h4>
			
				<div class="detailsDiv" style="float:left; width:500px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
					<div style=" float:left; margin-left:5px;"><h4><a style="color:#FFF; font-size:12px; " target="_blank" href="разгледай-дестинация-'.$resultUserProfile[0]['location_id'] .','.myTruncateToCyrilic(get_location_type_and_nameBylocationID($resultUserProfile[0]['location_id']),100,"_","").'_описание_на_градове_села_курорти_дестинации_от_цял_свят.html">'.locationTracker($resultUserProfile[0]['location_id']).'</a></h4></div>
					<br style="clear:both;" />	
		        </div>';
		                 				
					
$user_big .= '				
			<div class="main-body-top" style="margin-top:50px;"></div>	
						
			<table style=" background-color:#FFFFFF;font-size:12px;">
			<tr><td width="300" style="padding-left:10px; background-color:#0099FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4><a style="color:#FFF; font-size:12px; " href="форум-autor_type=user&autorID='.$resultUserProfile[0]['userID'] .',вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">Мнения във Форума и Коментари</a></h4></td>
			<td width="25" align="center"><img height="25" src="images/i_all.jpg" /></td>
			<td width="300" style="padding-left:10px; background-color:#0099FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4>'.$resultUserProfile[0]['cnt_comment'].'</h4>		
			</td></tr>
			<tr><td width="300" style="padding-left:10px; background-color:#0066FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4><a style="color:#FFF; font-size:12px; " href="статии-post_autor_type=user&post_autor='.$resultUserProfile[0]['userID'] .',вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">Публикувани Статии</a></h4></td>
			<td width="25" align="center"><img height="25" src="images/i_all.jpg" /></td>
			<td width="300" style="padding-left:10px; background-color:#0066FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4>'.$resultUserProfile[0]['cnt_post'].'</h4>	
			</td></tr>
			<tr><td width="300" style="padding-left:10px; background-color:#0099FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4><a style="color:#FFF; font-size:12px; " href="рецепти-userID='.$resultUserProfile[0]['userID'] .',вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">Описани Готварски Рецепти</a></h4></td>
			<td width="25" align="center"><img height="25" src="images/i_all.jpg" /></td>
			<td width="300" style="padding-left:10px; background-color:#0099FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4>'.$resultUserProfile[0]['cnt_recipe'].'</h4>		
			</td></tr>
			<tr><td width="300" style="padding-left:10px; background-color:#0066FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4><a style="color:#FFF; font-size:12px; " href="напитки-userID='.$resultUserProfile[0]['userID'] .',екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">Описани Рецепти за Напитки </a></h4></td>
			<td width="25" align="center"><img height="25" src="images/i_all.jpg" /></td>
			<td width="300" style="padding-left:10px; background-color:#0066FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4>'.$resultUserProfile[0]['cnt_drink'].'</h4>		
			</td></tr>
			<tr><td width="300" style="padding-left:10px; background-color:#0099FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4><a style="color:#FFF; font-size:12px; " href="справочник-userID='.$resultUserProfile[0]['userID'] .',храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html">Справочни описания</a></h4></td>
			<td width="25" align="center"><img height="25" src="images/i_all.jpg" /></td>
			<td width="300" style="padding-left:10px; background-color:#0099FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4>'.$resultUserProfile[0]['cnt_guide'].'</h4>		
			</td></tr>
			<tr><td width="300" style="padding-left:10px; background-color:#0066FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4><a style="color:#FFF; font-size:12px; " href="болести-userID='.$resultUserProfile[0]['userID'] .',симптоми_лечение_и_описания_на_заболявания.html">Описания на Болести</a></h4></td>
			<td width="25" align="center"><img height="25" src="images/i_all.jpg" /></td>
			<td width="300" style="padding-left:10px; background-color:#0066FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4>'.$resultUserProfile[0]['cnt_bolest'].'</h4>		
			</td></tr>
			<tr><td width="300" style="padding-left:10px; background-color:#0099FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4><a style="color:#FFF; font-size:12px; " href="афоризми-autor_type=user&autor='.$resultUserProfile[0]['userID'] .',интересни_забавни_поучителни_афоризми.html">Фрази/Афоризми</a></h4></td>
			<td width="25" align="center"><img height="25" src="images/i_all.jpg" /></td>
			<td width="300" style="padding-left:10px; background-color:#0099FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4>'.$resultUserProfile[0]['cnt_aphorism'].'</h4>		
			</td></tr>
			<tr><td width="300" style="padding-left:10px; background-color:#0066FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4>Приятели</h4></td>
			<td width="25" align="center"><img height="25" src="images/i_all.jpg" /></td>
			<td width="300" style="padding-left:10px; background-color:#0066FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4>'.($numFriends?$numFriends:0).'</h4>		
			</td></tr>
			<tr><td width="300" style="padding-left:10px; background-color:#0099FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4>Дата на Регистрация</h4></td>
			<td width="25" align="center"><img height="25" src="images/i_all.jpg" /></td>
			<td width="300" style="padding-left:10px; background-color:#0099FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4>'.convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($resultUserProfile[0]['date_register']))).'</h4>		
			</td></tr>
			<tr><td width="300" style="padding-left:10px; background-color:#0066FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4>Последно влизане</h4></td>
			<td width="25" align="center"><img height="25" src="images/i_all.jpg" /></td>
			<td width="300" style="padding-left:10px; background-color:#0066FF; color:#FFFFFF; border:1px solid #FFFFFF; "><h4>'.convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($resultUserProfile[0]['last_login']))).'</h4>		
			</td></tr>
			</table>	
			
						
			<div class="main-body-bottom"></div>
			
			
			</td></tr></table>
			
			
			<br style="clear:both;" />
	</div>
		<br style="clear:both;" />
		
	
	
	<div class="detailsDiv" style="float:left; width:640px; margin-bottom:20px; border-top:3px solid #0099FF; padding:5px;  margin-left:6px; background-color:#FFFFFF;">
	<div class="postBig">
		<h4>
			<div style="margin-left:6px;  height:22px; width:640px; color:#0099FF; font-weight:bold;" >Приятели</div>		
		</h4>
		<br style="clear:both;"/>
	</div>';
		
	for($n=0; $n<$numFriends; $n++) 
	{	

	 	$sql="SELECT * FROM users WHERE userID = '".($resultFriends[$n]['sender'] == $_REQUEST['userID'] ? $resultFriends[$n]['recipient'] : $resultFriends[$n]['sender'])."' LIMIT 1";
    	$conn->setsql($sql);
    	$conn->getTableRow();
		$resultFriendDetails = $conn->result;
    	
		
	//***********************************************************************
		
		if(is_file("pics/users/".$resultFriendDetails['userID']."_avatar.jpg")) $picFile= "pics/users/".$resultFriendDetails['userID']."_avatar.jpg";
	   	else $picFile = 'pics/users/no_photo_thumb.png';
		
		list($width, $height, $type, $attr) = getimagesize($picFile);
		$pic_width_or_height = 100;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
		if (($height) && ($width))	
		{
			if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
			else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
		}
	   	 
	//***********************************************************************
	
	//========================= Проверяваме дали участника е ОН-Лайн ===================================
				
    	$sql="SELECT session_name FROM sessions WHERE session_name = '".$resultFriendDetails['username']."' LIMIT 1";
    	$conn->setsql($sql);
    	$conn->getTableRow();
		$resultAutorOnLine = (($conn->result['session_name'] != '')?1:0);
    	
	//==================================================================================================
	
	//======================================= Име на Приятеля ==========================================
		$FriendName = $resultFriendDetails['first_name'].' '.$resultFriendDetails['last_name'];
		if($resultFriendDetails['userID'] == 1)
		{
			$FriendName = 'Админ';
		}
	//==================================================================================================
	
$user_big .= '
		<table style="float:left;"><tr><td valign="top">
			<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
				<a href="разгледай-потребител-'.$resultFriendDetails['userID'].','.$FriendName.'.html">'.$FriendName.'
			</div>
			<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
				<h3><a style="color:#0099FF; font-size:10px; " target="_blank"  href="http://gozbite.com/разгледай-дестинация-'.$resultFriendDetails['location_id'] .','.myTruncateToCyrilic(get_location_type_and_nameBylocationID($resultFriendDetails['location_id']),100,"_","").'_описание_на_градове_села_курорти_дестинации_от_цял_свят.html">'.locationTracker($resultFriendDetails['location_id']).'</a></h3>
			</div>
		        
			<div style="border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" ><a href="разгледай-потребител-'.$resultFriendDetails['userID'].','.$FriendName.'.html"><img width="'.$newwidth.'" height="'.$newheight.'" src="'.$picFile.'" /></a></div>
			
			<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
				'.(($resultAutorOnLine == 1)?'<font color="green">Он-лайн</font>':'<font color="red">Оф-лайн</font>').'
			</div>
							
		</td>
		</tr>
		</table>';
	 } 
$user_big .= '		<br style="clear:both;" />	
	</div>
		<br style="clear:both;" />	
		
		
		
							
					
	<table><tr><td valign="top">
		
	
	<div class="detailsDiv" style="float:left; width:310px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#FFFFFF; text-align:left;">
		<div class="postBig">
			<h4>
				<div style="margin-left:6px; height:22px; width:310px;color:#0099FF;font-weight:bold;" >Последни Мнения/Коментари</div>		
			</h4>
			<br style="clear:both;" />
		</div>';
	
	
	 for($n=0; $n<$numLastQuestions; $n++) 
	 {
$user_big .= '		<div class="main-body-top"></div>	
			<img src=\'images/orange_six.png\' style=\'width:10px;height:10px;margin-right:2px;\'/><a class="read_more_link" style="color:#000000; font-size:12px;" href="index.php?pg=forums&questionID='.get_question_parentID($resultLastQuestions[$n]['questionID']).'#question_'.$resultLastQuestions[$n]['questionID'].'">'.myTruncate($resultLastQuestions[$n]['question_body'], 300, " ").'</a>
		<div class="main-body-bottom"></div>';
			
	 } 
$user_big .= '		<br style="clear:both;" />	
	</div>		
		<br style="clear:both;" />	
		
	</td><td valign="top">
		
	
	
	<div class="detailsDiv" style="float:left; width:310px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#FFFFFF; text-align:left;">
		<div class="postBig">
			<h4>
				<div style="margin-left:6px; height:22px; width:310px;color:#0099FF;font-weight:bold;" >Последни Статии</div>		
			</h4>
			<br style="clear:both;" />
		</div>';
	
		for($n=0; $n<$numLastPosts; $n++) 
		{
		$user_big .= '	<div class="main-body-top"></div>	
				<img src=\'images/orange_six.png\' style=\'width:10px;height:10px;margin-right:2px;\'/><a class="read_more_link" style="color:#000000; font-size:12px;" href="прочети-статия-'.$resultLastPosts[$n]['postID'].','.myTruncateToCyrilic(strip_tags($resultLastPosts[$n]['body']),100,'_','') .'.html">'.myTruncate($resultLastPosts[$n]['body'], 300, " ").'</a>
			<div class="main-body-bottom"></div>';
				
		}
$user_big .= '		<br style="clear:both;" />	
	</div>
		<br style="clear:both;" />	
		
		
	</td></tr>
	
	
	
	<tr><td valign="top">
		
	
	<div class="detailsDiv" style="float:left; width:310px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#FFFFFF; text-align:left;">
		<div class="postBig">
			<h4>
				<div style="margin-left:6px; height:22px; width:310px;color:#0099FF;font-weight:bold;" >Последни Рецепти</div>		
			</h4>
			<br style="clear:both;" />
		</div>';
	
	
		for($n=0; $n<$numLastRecipes; $n++) 
		{
			$user_big .= '<div class="main-body-top"></div>	
				<img src="images/orange_six.png" style="width:10px;height:10px;margin-right:2px;"/><a style="color:#000000; font-size:12px;" href="разгледай-рецепта-'.$resultLastRecipes[$n]['id'].','.myTruncateToCyrilic($resultLastRecipes[$n]['title'],100,'_','') .'.html">'.myTruncate($resultLastRecipes[$n]['title'], 300, " ").'</a>
			<div class="main-body-bottom"></div>';
			
		}
		
$user_big .= '		
		<br style="clear:both;" />	
	</div>		
		<br style="clear:both;" />	
		
	</td><td valign="top">
		
	
	
	<div class="detailsDiv" style="float:left; width:310px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#FFFFFF; text-align:left;">
		<div class="postBig">
			<h4>
				<div style="margin-left:6px; height:22px; width:310px;color:#0099FF;font-weight:bold;" >Последни Напитки</div>		
			</h4>
			<br style="clear:both;" />
		</div>';
	
		for($n=0; $n<$numLastDrinks; $n++) 
		{
			$user_big .= '<div class="main-body-top"></div>	
				<img src="images/orange_six.png" style="width:10px;height:10px;margin-right:2px;"/><a style="color:#000000; font-size:12px;" href="разгледай-напитка-'.$resultLastDrinks[$n]['id'].','.myTruncateToCyrilic($resultLastDrinks[$n]['title'],100,'_','') .'.html">'.myTruncate($resultLastDrinks[$n]['title'], 300, " ").'</a>
			<div class="main-body-bottom"></div>';
				
		}
		
$user_big .= '		
		<br style="clear:both;" />	
	</div>
		<br style="clear:both;" />	
		
		
	</td></tr>
	
	
	
	
	
	
	
	
	
	
	<tr><td valign="top">
		
	
	<div class="detailsDiv" style="float:left; width:310px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#FFFFFF; text-align:left;">
		<div class="postBig">
			<h4>
				<div style="margin-left:6px; height:22px; width:310px;color:#0099FF;font-weight:bold;" >Последни Описани Заболявания</div>		
			</h4>
			<br style="clear:both;" />
		</div>';
	
	
		for($n=0; $n<$numLastBolesti; $n++) 
		{
			$user_big .= '<div class="main-body-top"></div>	
				<img src="images/orange_six.png" style="width:10px;height:10px;margin-right:2px;"/><a style="color:#000000; font-size:12px;" href="разгледай-болест-'.$resultLastBolesti[$n]['bolestID'].','.myTruncateToCyrilic($resultLastBolesti[$n]['title'],100,'_','') .'.html">'.myTruncate($resultLastBolesti[$n]['title'], 300, " ").'</a>
			<div class="main-body-bottom"></div>';
			
		}
		
$user_big .= '		
		<br style="clear:both;" />	
	</div>		
		<br style="clear:both;" />	
		
	</td><td valign="top">
		
	
	
	<div class="detailsDiv" style="float:left; width:310px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#FFFFFF; text-align:left;">
		<div class="postBig">
			<h4>
				<div style="margin-left:6px; height:22px; width:310px;color:#0099FF;font-weight:bold;" >Последни Фрази/Афоризми</div>		
			</h4>
			<br style="clear:both;" />
		</div>';
	
		for($n=0; $n<$numLastAphorisms; $n++) 
		{
			$user_big .= '<div class="main-body-top"></div>	
				<img src="images/orange_six.png" style="width:10px;height:10px;margin-right:2px;"/><a style="color:#000000; font-size:12px;" href="прочети-афоризъм-'.$resultLastAphorisms[$n]['aphorismID'].','.myTruncateToCyrilic($resultLastAphorisms[$n]['body'],100,'_','') .'.html">'.myTruncate($resultLastAphorisms[$n]['body'], 300, " ").'</a>
			<div class="main-body-bottom"></div>';
				
		}
		
$user_big .= '		
		<br style="clear:both;" />	
	</div>
		<br style="clear:both;" />	
		
		
	</td></tr>
	
	
	
	
	
	
	
	
	
	
	<tr><td valign="top">
		
	
	<div class="detailsDiv" style="float:left; width:310px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#FFFFFF; text-align:center;">
		<div class="postBig">
			<h4>
				<div style="margin-left:6px; height:22px; width:310px;color:#0099FF;font-weight:bold;" >Снимки</div>		
			</h4>
			<br style="clear:both;" />
		</div>
	
			<ul id="thumbs_posts" style="float:left; width:310px; margin-left:30px;">';

		 //--------------------------- PICS ------------------------------------------
		
		$sql="SELECT * FROM user_pics WHERE userID='".$resultUserProfile[0]['userID']."'";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultPics=$conn->result;
		$numPics=$conn->numberrows;
	
		  for ($p=0;$p<$numPics;$p++)
		  { 

		  	$user_big .= '<li class="thumbDiv"><a href="pics/users/';
		  	if($numPics>0) $user_big .= $resultPics[$p]['url_big']; 
		  	else $user_big .= "no_photo_big.png";
		  	$user_big .= '" class="lightview" rel="gallery[myset]"><img width="60" height="60"  src="';
		  	if(is_file('pics/users/'.$resultPics[$p]['url_thumb'])) $user_big .= 'pics/users/'.$resultPics[$p]['url_thumb']; 
		  	else $user_big .= "pics/users/no_photo_thumb.png";
		  	$user_big .= '" /></a></li>';
		
		  }
$user_big .= '
		 </ul>
		<br style="clear:both;" />	
	</div>
		
		<br style="clear:both;" />	
		
		
	</td><td valign="top">
	
	
	
	
	<div class="detailsDiv" style="float:left; width:310px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#FFFFFF; text-align:left;">
		<div class="postBig">
			<h4>
				<div style="margin-left:6px; height:22px; width:310px;color:#0099FF;font-weight:bold;" >Последни Описания в Справочника</div>		
			</h4>
			<br style="clear:both;" />
		</div>';
	
		for($n=0; $n<$numLastGuides; $n++) 
		{
			$user_big .= '<div class="main-body-top"></div>	
				<img src="images/orange_six.png" style="width:10px;height:10px;margin-right:2px;"/><a style="color:#000000; font-size:12px;" href="разгледай-справочник-'.$resultLastGuides[$n]['id'].','.myTruncateToCyrilic($resultLastGuides[$n]['title'],200,'_','') .'.html">'.myTruncate($resultLastGuides[$n]['title'], 300, " ").'</a>
			<div class="main-body-bottom"></div>';
				
		} 

$user_big .= '		
		<br style="clear:both;" />	
	</div>
		<br style="clear:both;" />	
		
		
	
		
		
	</td></tr></table>
		
	
	</div>'	;


return $user_big;

?>