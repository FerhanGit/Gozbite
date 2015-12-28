<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$header_links = "";
	$header_links .='<div id="headerInfoDiv" align="left" style="float:left; width:1000px; "  >
				<div style="float:left;"><a href="начална-страница,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" target="_self"><img style="z-index:999; margin-top:0px;" src="images/logce.png" /></a></div>

<table><tr><td style="width:250px;  border-right:1px dotted #690; padding-right:10px; font-size:12px; color:#FFFFFF;  font-weight:bold;">
</td><td align="left" style=" padding-left:8px; ">';
 

 $header_links .= '<g:plusone></g:plusone>';
	
	if(isset($_SESSION['valid_user']) && $_SESSION['user_kind'] == 2 && $_SESSION['userID'] != 7) 
	{ 
		$header_links .=' <a style="color:#FFFFFF; font-weight:bold; "  href="admin/index.php" target="_self" '.($params['page_name']=='admin_home'?'class="active"':'').'>АДМИН</a> | ';
	
	}
	
	if (isset($_SESSION['valid_user']))
	{	
		$header_links .=' <a style="color:#FFFFFF; font-weight:bold; "  href="изход,изход_от_системата_на_GoZbiTe_Com.html" target="_self" '.($params['page_name']=='logout'?'class="active"':'').'>ИЗХОД</a>
		 | <a style="color:#FFFFFF; font-weight:bold; "  href="редактирай-профил,изгради_социални_контакти_с_други_потребители.html" target="_self" '.($params['page_name']=='profile'?'class="active"':'').'>ПРОФИЛ</a>';
	
	}
	else 
	{
		$header_links .='<a style="color:#FFFFFF; font-weight:bold; " href="вход,вход_в_системата_на_GoZbiTe_Com.html" target="_self" '.($params['page_name']=='login'?'class="active"':'').'>ВХОД</a>
		| <a style="color:#FFFFFF; font-weight:bold; " href="регистрация,регистрация_в_системата_на_GoZbiTe_Com.html" target="_self" '.($params['page_name']=='register_user'?'class="active"':'').'>РЕГИСТРАЦИЯ</a>';
	
	}
		$header_links .='| <a style="color:#FFFFFF; font-weight:bold; " href="разгледай-страница-terms,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" >Условия за ползване</a>
		| <a style="color:#FFFFFF; font-weight:bold; " href="разгледай-рекламни-оферти,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" >Реклама</a>';
	

	$header_links .='</td></tr></table>';
				   
		$header_links .='</div> <br /> ';
	
		return $header_links;
	  
	?>
