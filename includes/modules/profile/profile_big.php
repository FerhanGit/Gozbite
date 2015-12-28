<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$profile_big = "";
   	
			
   	
if($_SESSION['user_type'] == 'firm') 
{	
	$profile_big .= '<script type="text/javascript">
	       window.location.href="редактирай-фирма-'.$_SESSION['userID'].',сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html";
	</script>'; 
		 	 	
	die();
}

else 
{
	
	




$sql="SELECT * FROM users WHERE userID = '".$_SESSION['userID']."' LIMIT 1";
$conn->setsql($sql);
$conn->getTableRows();
$resultUserProfile = $conn->result;
$numUserProfile    = $conn->numberrows;



//--------------------------- PICS ------------------------------------------
	
$sql="SELECT * FROM user_pics WHERE userID='".$_SESSION['userID']."'";
$conn->setsql($sql);
$conn->getTableRows();
$resultPics=$conn->result;
$numPics=$conn->numberrows;
	
	
				    	
$profile_big .= '<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
<div class="postBig">';

				    	
$profile_big .= '<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';

  			  if (isset($_SESSION['valid_user']))
		  	  {
		  	  	$profile_big .= "<font color='#467B99'>".$_SESSION['name']."</font>, Вашият принос в кулинарията е: ";		  	  
		  	  	
		  	  	$profile_big .= "<font color='#467B99'>".($_SESSION['cnt_post']>0 ? $_SESSION['cnt_post'] : 0)."</font> Статии | ";
		  	   	
		  	  	$profile_big .= "<font color='#467B99'>".($_SESSION['cnt_recipe']>0 ? $_SESSION['cnt_recipe'] : 0)."</font> Рецепти | ";
		  	   	
		  	  	$profile_big .= "<font color='#467B99'>".($_SESSION['cnt_drink']>0 ? $_SESSION['cnt_drink'] : 0)."</font> Напитки |  ";
		  	   	
		  	  	$profile_big .= "<font color='#467B99'>".($_SESSION['cnt_guide']>0 ? $_SESSION['cnt_guide'] : 0)."</font> Справочни описания |  ";
		  	   	
		  	  	$profile_big .= "<font color='#467B99'>".($_SESSION['cnt_bolest']>0 ? $_SESSION['cnt_bolest'] : 0)."</font> Описани Заболявания |  ";
		  	   	
		  	  	$profile_big .= "<font color='#467B99'>".($_SESSION['cnt_comment']>0 ? $_SESSION['cnt_comment'] : 0)."</font> Коментари<hr> ";
		  	   	
		  	  	$profile_big .= "Имате <font color='#467B99'>".($_SESSION['cnt_post'] + $_SESSION['cnt_recipe'] + $_SESSION['cnt_drink'] + $_SESSION['cnt_guide'] - $_SESSION['used_credits'])."</font> налични кредита ";
		  	   	
		  	   if($_SESSION['user_kind'] == 2)
		  	   {		
		  	   		$sql="SELECT COUNT(username) as cntNewUsers FROM users WHERE active=0 ";
					$conn->setsql($sql);
					$conn->getTableRow();
					$cntNewUsers = $conn->result['cntNewUsers'];
					
					$sql="SELECT COUNT(postID) as cntNewPosts FROM posts WHERE active=0 ";
					$conn->setsql($sql);
					$conn->getTableRow();
					$cntNewPosts = $conn->result['cntNewPosts'];
											
					$sql="SELECT COUNT(newsID) as cntNewQuestions FROM questions WHERE active=0 ";
					$conn->setsql($sql);
					$conn->getTableRow();
					$cntNewQuestions = $conn->result['cntNewQuestions'];
					
					$newString = ""; 
					if($cntNewUsers>0) $newString .= " Потребители:".$cntNewUsers;
					if($cntNewPosts>0)$newString.= " Статии:".$cntNewPosts;
					if($cntNewNews>0) $newString .= " Новини:".$cntNewNews;
					
					if($newString !="") $profile_big .= "Има нови $newString";
					
					
		  	   }
					
		  	    $package_info = '';
															
				if ($_SESSION['user_type'] == 'firm')	  	$companyOrdoctor = "pp.company_id = '".$_SESSION['userID']."'";
				if ($_SESSION['user_type'] == 'firm')
				{
					$sql="SELECT p.name as 'package', p.id as 'package_id', pp.is_payed as 'is_payed', pp.start_date as 'start_date', pp.end_date as 'end_date', p.has_video as 'has_video', p.is_VIP as 'is_VIP', p.is_Silver as 'is_Silver', p.is_Gold as 'is_Gold', p.is_Featured as 'is_Featured', p.pr_Stuff as 'ps_Stuff', pp.active as 'active' FROM purchased_packages pp, packages p WHERE pp.package_id = p.id AND (NOW() BETWEEN pp.start_date AND pp.end_date) AND $companyOrdoctor";
					$conn->setsql($sql);
					$conn->getTableRow(); 

					$numUserPackage 	= $conn->numberrows;	 
					$resultUserPackage 	= $conn->result;
						
						if($numUserPackage == 1)
						{
							$package_info .= " | Имате пакет: <font color='#467B99'>".$resultUserPackage['package']."</font>";
							$package_info .= " | Активен: <font color='#467B99'>".($resultUserPackage['active']==1?'Да':'Не')."</font>";
							$package_info .= " | Платен: <font color='#467B99'>".($resultUserPackage['is_payed']==1?'Да':'Не')."</font>";
							$package_info .= " | Стартиран на: <font color='#467B99'>".$resultUserPackage['start_date']."</font>";
							$package_info .= " | Валиден до: <font color='#467B99'>".$resultUserPackage['end_date']."</font>";
						}
						else $package_info .= 'Нямате закупен пакет.';
				}
				$profile_big .= $package_info;
					//print "<hr>Последно сте били с нас на <font color='#467B99'>".$_SESSION['last_login']."</font> ч.";
				
		  	  }
$profile_big .= '
</div>';  	

 
    if (isset($_SESSION['valid_user']))
  	{	
			
	//========================= Проверяваме дали участника има ЧАКАЩИ приетели ===================================
			
    	$sql="SELECT * FROM friendships WHERE (sender = '".$resultUserProfile[0]['userID']."' OR recipient = '".$resultUserProfile[0]['userID']."') AND friendship_accepted = '0' ";
    	$conn->setsql($sql);
    	$conn->getTableRows();
		$numFriends = $conn->numberrows;
    	$resultFriends = $conn->result;
    	
	//==================================================================================================
	    	
$profile_big .= '<div class="detailsDiv" style="float:left; width:640px; margin-bottom:20px; border-top:3px solid #0099FF; padding:5px;  margin-left:6px; background-color:#FFFFFF;">
	<div class="postBig">
		<h4>
			<div style="margin-left:6px;  height:22px; width:640px; color:#0099FF; font-weight:bold;" >Чакаши приятелства</div>		
		</h4>
		<br style="clear:both;"/>
	</div>';
		
	for($n=0; $n<$numFriends; $n++) 
	{	

	 	$sql="SELECT * FROM users WHERE userID = '".($resultFriends[$n]['sender'] == $_SESSION['userID'] ? $resultFriends[$n]['recipient'] : $resultFriends[$n]['sender'])."' LIMIT 1";
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
	
$profile_big .= '<table style="float:left;"><tr><td valign="top">
			<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
				'.('<a href="разгледай-потребител-'.$resultFriendDetails['userID'].','.myTruncateToCyrilic($FriendName,100,"_","") .'.html">'.$FriendName).' 
			</div>
			<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
				<h3><a style="color:#0099FF; font-size:10px;" target="_blank" href="http://gozbite.com/разгледай-дестинация-'.$resultFriendDetails['location_id'].','.myTruncateToCyrilic(get_location_type_and_nameBylocationID($resultFriendDetails['location_id']),100,"_","").'_описание_на_градове_села_курорти_дестинации_от_цял_свят.html">'.locationTracker($resultFriendDetails['location_id']).'</a></h3>
			</div>
		        
			<div style="border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" ><img width="'.$newwidth.'" height="'.$newheight.'" src="'.$picFile.'" /></div></a>
			
			<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
				'.(($resultAutorOnLine == 1)?'<font color="green">Он-лайн</font>':'<font color="red">Оф-лайн</font>').'
			</div>';
			
			if($_SESSION['userID'] > 0 ) {
			$profile_big .= '<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
				<a style="font-size:10px; " href="index.php?pg=users&from_profile=1&friend_type=user&accept_friend='.$resultFriendDetails['userID'].'&userID='.$resultUserProfile[0]['userID'] .'" onclick="if(!confirm(\'Сигурни ли сте, че искате да го добавите за Ваш приятел?\')) return false;">Приеми приятелство</a>
			</div>	';
		 	}	
					
$profile_big .= '</td>
		</tr>
		</table>';
		}
$profile_big .= '<br style="clear:both;" />	
	</div>';
		
		





		
	//========================= Проверяваме дали участника има Съществуващи приетели ===================================
			
    	$sql="SELECT * FROM friendships WHERE (sender = '".$resultUserProfile[0]['userID']."' OR recipient = '".$resultUserProfile[0]['userID']."') AND friendship_accepted = '1'  ";
    	$conn->setsql($sql);
    	$conn->getTableRows();
		$numFriends = $conn->numberrows;
    	$resultFriends = $conn->result;
    	
	//==================================================================================================
	    	
$profile_big .= '
<div class="detailsDiv" style="float:left; width:640px; margin-bottom:20px; border-top:3px solid #0099FF; padding:5px;  margin-left:6px; background-color:#FFFFFF;">
	<div class="postBig">
		<h4>
			<div style="margin-left:6px;  height:22px; width:640px; color:#0099FF; font-weight:bold;" >Всички Приятели</div>		
		</h4>
		<br style="clear:both;"/>
	</div>';
		
	for($n=0; $n<$numFriends; $n++) 
	{	

	 	$sql="SELECT * FROM users WHERE userID = '".($resultFriends[$n]['sender'] == $_SESSION['userID'] ? $resultFriends[$n]['recipient'] : $resultFriends[$n]['sender'])."' LIMIT 1";
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
	
$profile_big .= '
		<table style="float:left;"><tr><td valign="top">
			<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
				'.'<a href="разгледай-потребител-'.$resultFriendDetails['userID'].','.myTruncateToCyrilic($FriendName,100,"_","") .'.html">'.$FriendName .'
			</div>
			<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
				<h3><a style="color:#0099FF; font-size:10px;" target="_blank" href="http://gozbite.com/разгледай-дестинация-'.$resultFriendDetails['location_id'] .','.myTruncateToCyrilic(get_location_type_and_nameBylocationID($resultFriendDetails['location_id']),100,"_","").'_описание_на_градове_села_курорти_дестинации_от_цял_свят.html">'.locationTracker($resultFriendDetails['location_id']).'</a></h3>
			</div>
		        
			<div style="border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" ><img width="'.$newwidth.'" height="'.$newheight.'" src="'.$picFile.'" /></div></a>
			
			<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
				'.((($resultAutorOnLine == 1)?'<font color="green">Он-лайн</font>':'<font color="red">Оф-лайн</font>').'').'
			</div>';
			
			if($_SESSION['userID'] > 0 ) {
			$profile_big .= '<div style="font-size:10px; border:1px solid #CCCCCC; width:110px; padding:5px; background-color:#F9F9F9;" align="center" >
				<a style="font-size:10px; " href="index.php?pg=users&from_profile=1&friend_type=user&remove_friend='.$resultFriendDetails['userID'].'&userID='.$resultUserProfile[0]['userID'] .'" onclick="if(!confirm(\'Сигурни ли сте, че искате да го спрете приятелството между Вас?\')) return false;">Откажи приятелство</a>
			</div>';	
			 }
					
$profile_big .= '</td>
		</tr>
		</table>';
		 } 
$profile_big .= '<br style="clear:both;" />	
	</div>';
	
  	}






$profile_big .= '<br style="clear:both;" />	
<div class="postBig">
	<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
		<h4 style="margin: 10px 0px 0px 0px; padding-left:5px; color: #0099FF; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;">';
			
		    	if (isset($_SESSION['valid_user']))
		  		{	
		  
				$profile_big .= '<div style="margin-left:6px; height:22px; width:450px;color:#0099FF;font-weight:bold;" >Редактиране на Профил - '.$resultUserProfile[0]['first_name'].' '.$resultUserProfile[0]['last_name'].'</div>';
			 	}
				else 
				{
			
				$profile_big .= '<div style="margin-left:6px; height:22px; width:450px;color:#0099FF;font-weight:bold;" >Регистриране на Потребител </div>';

		  		}
$profile_big .= '		  			
		</h4>
	</div>
</div>
	
		 	<br /><br />
		 	
				<input type="hidden" name="userID" value="'.$resultUserProfile[0]['userID'].'" />  
				
		 		<table width=\'500\' border=\'0\' align="left">
		 		
		 		 	<tr>
				      	<td width="200"></td>
				      	<td><br />
				        	<div style="margin-bottom:20px; width:100px;">';
					
							     
							    	if (isset($_SESSION['valid_user']))
							  		{	
							  	
							  		$profile_big .= '<input type="submit" value="Редактирай" id="edit_userBtn" name="edit_userBtn" onclick="return checkForCorrectData(\'user\');">';
							  	
							  
							  		}
							  	
							  		if (!isset($_SESSION['valid_user']))
							  		{	
							  	
							  		$profile_big .= '<input type="submit" value="Регистрирай" id="insert_userBtn"  name="insert_userBtn" onclick="return checkForCorrectData(\'user\');">';
								
							  
							  		}
							  	
			$profile_big .= '</div>						  
					  </tr>
					  
				    <tr>
				      <td width="200" align="right"><label>Име* </label></td>
				      <td ><input type=\'text\' name=\'fname\' value="'.$resultUserProfile[0]['first_name'].'"/></td>
				    </tr>
				    <tr>
				      <td width="200" align="right">Фамилия*</td>
				      <td><input type=\'text\' name=\'lname\' value="'.$resultUserProfile[0]['last_name'].'"/></td>
				    </tr>
				    <tr>
				      <td width="200" align="right"><label>Потребителско Име*</label></td>
				      <td><input type=\'text\' name=\'username\' value="'.$resultUserProfile[0]['username'].'"/></td>
				    </tr>
				    <tr>
				      <td width="200" align="right"><label>Парола*</label></td>
				      <td><input type=\'password\' name=\'password\' value="'.$resultUserProfile[0]['password'].'"/></td>
				    </tr>
				    <tr>
				      <td width="200" align="right"><label>Повтори паролата*</label></td>
				      <td><input type=\'password\' name=\'password2\' value="'.$resultUserProfile[0]['password'].'"/></td>
				    </tr>
				    <tr>
				      <td width="200" align="right">E-mail*</td>
				      <td><input type=\'text\' name=\'email\' value="'.$resultUserProfile[0]['email'].'"/></td>
				    </tr>
				    <tr>
				      <td width="200" align="right">Телефон</td>
				      <td><input type=\'text\' name=\'phone\' value="'.$resultUserProfile[0]['phone'].'"/></td>
				    </tr>
				    <tr>
				     	<td width="200"  align="right">Населено място*  </td>
				    	<td>
				    	
				    	  <fieldset style="width:200px;">                                                    
                           		
                           		<!--  TARSACHKATA -->
								<div>
									<input type="text" size="30" id="inputString" name="inputString" AUTOCOMPLETE=OFF  onkeyup="if(this.value.length > 2 ) { lookupLocation(this.value);}" value="Населеното място..." onfocus="if(this.value!=\'Населеното място...\'){this.value=this.value;} else {this.value=\'\';}" onblur="if(this.value==\'\'){this.value = \'Населеното място...\';} else {this.value = this.value;}" >
								</div>
								
								<div class="suggestionsBox" id="suggestions"  style="display: none; z-index: 1000; position: relative; left: 0px; -moz-border-radius:7px; -webkit-border-radius:7px;" onclick=" hidemsgArea();">
									<img src="images/top_arrow.gif" style="position: relative; top: -12px; left: 50px;" alt="upArrow" />
									<div class="suggestionList" id="autoSuggestionsList" style="color:#FFFFFF; "></div>
								</div>				
								<!-- KRAI NA TARSACHKATA -->
								<label class = "txt12"><a href="javascript:void(0);" title = "Въведете първите няколко символа и изберете от предложения списък.">Подсказка за населеното място <a href=\'#\' id=\'destinaciq\' style=\'z-index:1000;\'><img src=\'images/help.png\' /></a></label>&nbsp;<br /><br />';
                            		
								
								                           
                             
					               $profile_big .= "     <select name = \"cityName\" id = \"cityName\" size = \"15\" align = \"left\" style = \"float:left;width:280px;margin-right: 10px;\" >";
					               $profile_big .= "        <option value = \"-1\" style = \"color: #ca0000;\">избор...</option>\n";
					               //printf(" <option value = \"14880\" %s>&nbsp; Обиколен маршрут </option>",((14880 == $resultEdit['location_id']) ? " selected" : ""));
               					    require_once("includes/classes/FirmLocationsListEdit.class.php");
					               $CCList = new FirmLocationsList($conn);
					              if($CCList->load())
					                 $profile_big .= $CCList->showselectlist(0, "", $resultUserProfile[0]['location_id']?$resultUserProfile[0]['location_id']:0);
					               $profile_big .= "     </select>\n";
					           
                           		
       $profile_big .= '</fieldset>	
                            
	                    </td>                           			     
				    </tr>
				    <tr>
				      <td width="200" align="right">Адрес</td>
				      <td><input type=\'text\' name=\'address\' value="'.$resultUserProfile[0]['address'].'"/></td>
				    </tr>
				    <tr>
				      <td width="200" align="right">Снимка/Аватар</td>
				      <td>
				      	<br /><br />
				      		<input type = "file" name = "avatar">	
				      	<br />';	
				      	
				      	 if($resultUserProfile[0]['userID'] > 0) { 
				      	$profile_big .= '<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; width:100px; overflow:hidden; cursor:pointer;" ><img width="100" src="'.((is_file("pics/users/".$resultUserProfile[0]['userID']."_avatar.jpg"))?("pics/users/".$resultUserProfile[0]['userID']."_avatar.jpg"):("pics/users/no_photo_thumb.png")).'" /></div>
		       			<div style="float:left;cursor:pointer;" >
		       				<a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-аватар-на-потребител-'.$resultUserProfile[0]['userID']."_avatar.jpg".',изтрий_профилна_снимка_на_'.myTruncateToCyrilic($resultUserProfile[0]['first_name'].' '.$resultUserProfile[0]['last_name'],100,"_","").'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
		       			</div>';
	       			  } 
	       			                		
$profile_big .= '</td>
				    </tr>
				    
				     <tr><td colspan="2"> 
					     <div class="postBig">
							<div class="detailsDiv" style="float:left; width:640px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
								<h4 style=\'margin: 10px 0px 0px 0px; padding-left:5px; color: #0099FF; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;\'>
									<div style="margin-left:6px; height:22px; width:450px;color:#0099FF;font-weight:bold;" >Още Снимки</div>		
								</h4>
							</div>
						</div>
					</td></tr>
					
                  	<tr><td valign="top">
                  	
		                  	<div style="float:left;margin:10px;margin-left:0px;width:220px;"> 
							 Прикачи Снимки:
									<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
			                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
			                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
			                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
			                  		<input type = "file" name = "pics[]" style="margin:10px;float:left;width:200px;">
		                  	
		                  	</div>
           		 			
   		 			   
         	
           		 	</td><td valign="top">';
	           		 
							    $profile_big .= "<div style=\'float:left; margin-left:20px; width:380px;\' >";
							    
								  for ($p=0;$p<$numPics;$p++)
								  { 
						   			
					       			$profile_big .= '<div style="float:left; border:double; border-color:#666666;margin-left:10px; margin-bottom:5px; height:60px; width:60px; overflow:hidden; cursor:pointer;" ><img width="60" height="60" src="pics/users/';
					       			 if(is_file('pics/users/'.$resultPics[$p]['url_thumb'])) $profile_big .= $resultPics[$p]['url_thumb']; 
					       			 else $profile_big .= "no_photo_thumb.png";
					       			 $profile_big .= '" />
					       			</div>
					       			<div style="float:left;cursor:pointer;" >
					       			<a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-друга-снимка-на-потребител-'.$resultPics[$p]['url_big'].',изтрий_профилна_снимка_на_'.(myTruncateToCyrilic($resultUserProfile[0]['first_name'].' '.$resultUserProfile[0]['last_name'],100,"_","")).'.html"><img style="margin-left:1px;" src="images/page_white_delete.png" width="14" height="14"></a>
					       			</div>';
					   
								  }
								  $profile_big .= "</div>";
							
				                  
			         
$profile_big .= '	   </td></tr>
			         
			  
				    
		       <tr><td colspan="2"> <br /> <hr style="background-color:#0099FF;"> <br /></td></tr>';                  
				     if(!isset($_SESSION['userID'])) { 
						  $profile_big .= '<tr><td colspan="2">&nbsp;&nbsp;<input type="checkbox" name="subscribe_bulletin" id="subscribe_bulletin" CHECKED />&nbsp; Абонирай се за Информационния Бюлетин на GoZbiTe.Com </td></tr>';
				   	} 
		      	$profile_big .= '<tr><td colspan="2"> <br /> <hr style="background-color:#0099FF;"> <br /></td></tr>
               
		           <tr>
					 <td width="200" align="right"><fieldset style="width:100px;"><img src="verificationimage/picture.php" /></fieldset></td>
					 <td>	 
						<br /><input type="text" name="verificationcode" value="" /><br />
						В полето въведете кода показан на картинката*		
					 </td>
				   </tr>
				   
				   <tr>
				      <td width="200"></td>
				      <td><br />
				        	<div style="margin:0px; width:100px;">';
					
							     
							    	if (isset($_SESSION['valid_user']))
							  		{	
							  	
							  		$profile_big .= '<input type="submit" value="Редактирай" id="edit_userBtn" name="edit_userBtn" onclick="return checkForCorrectData(\'user\');">';
							  	
							  
							  		}
							  	
							  	
							  
							  		if (!isset($_SESSION['valid_user']))
							  		{	
							  	
							  		$profile_big .= '<input type="submit" value="Регистрирай" id="insert_userBtn"  name="insert_userBtn" onclick="return checkForCorrectData(\'user\');">';
								
							  
							  		}
							  
$profile_big .= '</div>
					  </tr>
				  </table>
				Полетата, отбелязани с "*" са задължителни.';
				
				

$profile_big .= '</div></div>';

return $profile_big;
}
?>