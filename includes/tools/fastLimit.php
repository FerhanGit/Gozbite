<?php

	require_once 'includes/header.inc.php';

	$pg_current = Pages::setPageToLoad();
  if($pg_current == 'posts')
  {
	if(!empty($_REQUEST['post_body']) && (!empty($_REQUEST['post_category']) OR !empty($_REQUEST['category']))){
		$url = "'статии-етикет-категория-".$_REQUEST['post_body'].",".$_REQUEST['page'].",".($_REQUEST['post_category']?$_REQUEST['post_category']:$_REQUEST['category']).",".('\'+selObj.options[selObj.selectedIndex].value+\'').",интересни_статии_за_здравето.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php		
	}
	elseif(!empty($_REQUEST['post_body'])){
			$url = "'статии-етикет-".$_REQUEST['post_body'].",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",интересни_статии_за_здравето.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php			
		}
		elseif(!empty($_REQUEST['post_category']) OR !empty($_REQUEST['category'])){
			$url = "'статии-категория-".($_REQUEST['post_category']?$_REQUEST['post_category']:$_REQUEST['category']).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",интересни_статии_за_здравето.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
		}
		else{
			$url = "'статии-".((isset($_REQUEST['post_autor_type']) && $_REQUEST['post_autor_type'] == 'doctor' && isset($_REQUEST['post_autor'])) ? 'post_autor_type=doctor&post_autor='.$_REQUEST['post_autor'] : ((isset($_REQUEST['post_autor_type']) && $_REQUEST['post_autor_type'] == 'hospital' && isset($_REQUEST['post_autor'])) ? 'post_autor_type=hospital&post_autor='.$_REQUEST['post_autor'] : ((isset($_REQUEST['post_autor_type']) && $_REQUEST['post_autor_type'] == 'user' && isset($_REQUEST['post_autor'])) ? 'post_autor_type=user&post_autor='.$_REQUEST['post_autor'] : '') ) ).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",интересни_статии_за_здравето.html'";			
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
		}	
  }
  elseif($pg_current == 'drinks')
  {		
		if(!empty($_REQUEST['specialiteti']))
		{
			$url = "'напитки-специалитети,".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php		
		}
		elseif(!empty($_REQUEST['tag']) && (!empty($_REQUEST['drink_category']) OR !empty($_REQUEST['category'])))
		{
			$url = "'напитки-етикет-категория-".$_REQUEST['tag'].",".$_REQUEST['page'].",".($_REQUEST['drink_category']?$_REQUEST['drink_category']:$_REQUEST['category']).",".('\'+selObj.options[selObj.selectedIndex].value+\'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php		
		}
		elseif(!empty($_REQUEST['tag'])){
			$url = "'напитки-етикет-".$_REQUEST['tag'].",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php			
		}
		elseif(!empty($_REQUEST['title'])){
			$url = "'напитки-title=".$_REQUEST['title'].",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php			
		}			
		elseif(!empty($_REQUEST['drink_category']) OR !empty($_REQUEST['category'])){
			$url = "'напитки-категория-".($_REQUEST['drink_category']?$_REQUEST['drink_category']:$_REQUEST['category']).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
		}
		else{
			$url = "'напитки-".($_REQUEST['firmID'] ? 'firmID='.$_REQUEST['firmID'] : ($_REQUEST['userID'] ? 'userID='.$_REQUEST['userID'] : '') ).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";			
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
		}		
		
	
  }
  elseif($pg_current == 'firms')
  {
		
		if(!empty($_REQUEST['tag'])){
			$url = "'фирми-етикет-".$_REQUEST['tag'].",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php			
		}
		elseif(!empty($_REQUEST['title'])){
			$url = "'фирми-title=".$_REQUEST['title'].",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php			
		}			
		elseif(!empty($_REQUEST['firm_category']) OR !empty($_REQUEST['category'])){
			$url = "'фирми-категория-".($_REQUEST['firm_category']?$_REQUEST['firm_category']:$_REQUEST['category']).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
		}
		else{
			$url = "'фирми-".($_REQUEST['firmID'] ? 'firmID='.$_REQUEST['firmID'] : '' ).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html'";			
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
		}		
	
	 	
  }
  elseif($pg_current == 'recipes')
  {	
	
	if(!empty($_REQUEST['specialiteti']))
		{
			$url = "'рецепти-специалитети,".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php		
		}
		elseif(!empty($_REQUEST['tag'])){
			$url = "'рецепти-етикет-".$_REQUEST['tag'].",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php			
		}
		elseif(!empty($_REQUEST['kuhnq'])){
			$url = "'рецепти-кухня-".$_REQUEST['kuhnq'].",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
		}
		elseif(!empty($_REQUEST['title'])){
			$url = "'рецепти-title=".$_REQUEST['title'].",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php			
		}
		elseif(!empty($_REQUEST['recipe_category']) OR !empty($_REQUEST['category'])){
			$url = "'рецепти-категория-".($_REQUEST['recipe_category']?$_REQUEST['recipe_category']:$_REQUEST['category']).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
		}
		else{
			$url = "'рецепти-".($_REQUEST['firmID'] ? 'firmID='.$_REQUEST['firmID'] : ($_REQUEST['userID'] ? 'userID='.$_REQUEST['userID'] : '') ).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";			
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
		}	
	
  }
  elseif($pg_current == 'guides')
  {	
	
		if(!empty($_REQUEST['tag'])){
			$url = "'справочник-етикет-".$_REQUEST['tag'].",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php			
		}
		elseif(!empty($_REQUEST['letter'])){
			$url = "'справочник-буква-".$_REQUEST['letter'].",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php			
		}
		else{
			$url = "'справочник-".($_REQUEST['firmID'] ? 'firmID='.$_REQUEST['firmID'] : ($_REQUEST['userID'] ? 'userID='.$_REQUEST['userID'] : '') ).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html'";			
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
		}		
	
	
  }
  elseif($pg_current == 'bolesti')
  {	
	
	if(!empty($_REQUEST['bolest_body']) && (!empty($_REQUEST['bolest_category']) OR !empty($_REQUEST['category']))){
		$url = "'болести-етикет-категория-".$_REQUEST['bolest_body'].",".$_REQUEST['page'].",".($_REQUEST['bolest_category']?$_REQUEST['bolest_category']:$_REQUEST['category']).",".('\'+selObj.options[selObj.selectedIndex].value+\'').",симптоми_лечение_и_описания_на_заболявания.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php		
	}
	elseif(!empty($_REQUEST['bolest_simptom'])){
			$url = "'болести-bolest_simptom=".$_REQUEST['bolest_simptom'].",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",симптоми_лечение_и_описания_на_заболявания.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php			
	}
	elseif(!empty($_REQUEST['bolest_body'])){
			$url = "'болести-етикет-".$_REQUEST['bolest_body'].",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",симптоми_лечение_и_описания_на_заболявания.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php			
		}
		elseif(!empty($_REQUEST['bolest_category']) OR !empty($_REQUEST['category'])){
			$url = "'болести-категория-".($_REQUEST['bolest_category']?$_REQUEST['bolest_category']:$_REQUEST['category']).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",симптоми_лечение_и_описания_на_заболявания.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
		}
		else{
			$url = "'болести-".((isset($_REQUEST['bolest_autor_type']) && $_REQUEST['bolest_autor_type'] == 'doctor' && isset($_REQUEST['bolest_autor'])) ? 'bolest_autor_type=doctor&bolest_autor='.$_REQUEST['bolest_autor'] : ((isset($_REQUEST['bolest_autor_type']) && $_REQUEST['bolest_autor_type'] == 'firm' && isset($_REQUEST['bolest_autor'])) ? 'bolest_autor_type=firm&bolest_autor='.$_REQUEST['bolest_autor'] : ((isset($_REQUEST['bolest_autor_type']) && $_REQUEST['bolest_autor_type'] == 'user' && isset($_REQUEST['bolest_autor'])) ? 'bolest_autor_type=user&bolest_autor='.$_REQUEST['bolest_autor'] : '') ) ).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",симптоми_лечение_и_описания_на_заболявания.html'";			
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
		}	
	
	}
	elseif($pg_current == 'aphorisms')
	{	
		if(!empty($_REQUEST['aphorism_body']) OR (!empty($_REQUEST['fromDate']) OR !empty($_REQUEST['toDate']))){
			$url = "'афоризми-архив-етикет-".$_REQUEST['aphorism_body'].",".$_REQUEST['fromDate'].",".$_REQUEST['toDate'].",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",интересни_забавни_поучителни_афоризми.html'";			
		?> 
			eval("document.location.href=<?=$url?>");
		<?php	
		}
		else{
			$url = "'афоризми-".((isset($_REQUEST['aphorism_autor_type']) && $_REQUEST['aphorism_autor_type'] == 'doctor' && isset($_REQUEST['aphorism_autor'])) ? 'aphorism_autor_type=doctor&aphorism_autor='.$_REQUEST['aphorism_autor'] : ((isset($_REQUEST['aphorism_autor_type']) && $_REQUEST['aphorism_autor_type'] == 'hospital' && isset($_REQUEST['aphorism_autor'])) ? 'aphorism_autor_type=hospital&aphorism_autor='.$_REQUEST['aphorism_autor'] : ((isset($_REQUEST['aphorism_autor_type']) && $_REQUEST['aphorism_autor_type'] == 'user' && isset($_REQUEST['aphorism_autor'])) ? 'aphorism_autor_type=user&aphorism_autor='.$_REQUEST['aphorism_autor'] : '') ) ).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",интересни_забавни_поучителни_афоризми.html'";			
		?> 
			eval("document.location.href=<?=$url?>");
		<?php	
		}

	}
  elseif($pg_current == 'forums')
  {
	if(!empty($_REQUEST['question_body']) && (!empty($_REQUEST['question_category']) OR !empty($_REQUEST['category']))){
		$url = "'форум-етикет-категория-".$_REQUEST['question_body'].",".$_REQUEST['page'].",".($_REQUEST['question_category']?$_REQUEST['question_category']:$_REQUEST['category']).",".('\'+selObj.options[selObj.selectedIndex].value+\'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php		
	}
	elseif(!empty($_REQUEST['question_body'])){
			$url = "'форум-етикет-".$_REQUEST['question_body'].",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php			
		}
	elseif(!empty($_REQUEST['question_category']) OR !empty($_REQUEST['category'])){
			$url = "'форум-категория-".($_REQUEST['question_category']?$_REQUEST['question_category']:$_REQUEST['category']).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
	}
	elseif(!empty($_REQUEST['questionID'])){
			$url = "'разгледай-форум-тема-".get_question_parentID($_REQUEST['questionID']).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",".myTruncateToCyrilic(get_question_titleByQuestionID($_REQUEST['questionID']),200,'_','').".html#question_".$_REQUEST['questionID']."'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
	}else{
			$url = "'форум-".(((isset($_REQUEST['autor_type']) && $_REQUEST['autor_type'] == 'firm' && isset($_REQUEST['autor'])) ? 'autor_type=firm&autor='.$_REQUEST['autor'] : ((isset($_REQUEST['autor_type']) && $_REQUEST['autor_type'] == 'user' && isset($_REQUEST['autor'])) ? 'autor_type=user&autor='.$_REQUEST['autor'] : '') )).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",интересни_статии_за_здравето.html'";			
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
		}	
  }
  elseif($pg_current == 'cards')
  {	
	
	if(!empty($_REQUEST['title'])){
			$url = "'картички-title=".$_REQUEST['title'].",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",покани_картички_вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php			
		}
		elseif(!empty($_REQUEST['card_category']) OR !empty($_REQUEST['category'])){
			$url = "'картички-категория-".($_REQUEST['card_category']?$_REQUEST['card_category']:$_REQUEST['category']).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",покани_картички_вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
		}
		else{
			$url = "'картички-".($_REQUEST['firmID'] ? 'firmID='.$_REQUEST['firmID'] : ($_REQUEST['userID'] ? 'userID='.$_REQUEST['userID'] : '') ).",".$_REQUEST['page'].",".('\'+selObj.options[selObj.selectedIndex].value+\'').",покани_картички_вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html'";			
	?> 
			eval("document.location.href=<?=$url?>");
	<?php	
		}		
	
  }
  
?>