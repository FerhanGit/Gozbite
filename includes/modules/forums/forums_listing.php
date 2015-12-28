<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/
	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	$forums_listing = "";

	 


	$and = '';		
	if(empty($_REQUEST['question_category'])) $_REQUEST['question_category'] = $_REQUEST['category'];		
	
	if ($_REQUEST['fromDate']!="")  $and .= " AND q.created_on > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
	if ($_REQUEST['toDate']!="")  $and .= " AND q.created_on < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
	if ($_REQUEST['question_category']!="")  $and .= " AND q.category='".$_REQUEST['question_category']."'";
	if ($_REQUEST['question_body'] != "")  $and .= " AND (q.question_title LIKE '%".$_REQUEST['question_body']."%' OR q.question_body LIKE '%".$_REQUEST['question_body']."%')"; // Това е за Таговете и за Търсачката 
	if ($_REQUEST['autor']!="")  $and .= " AND q.autor = '".$_REQUEST['autor']."'"; 
	if ($_REQUEST['autor_type']!="")  $and .= " AND q.autor_type = '".$_REQUEST['autor_type']."'"; 
	 		
	$orderby= 'q.created_on DESC';

	    


// ==================== ALL RESULTS =========================
   	$clauses = array();
	if(!isset($_REQUEST['search_btn']) && !isset($_REQUEST['autor']))
	{
		$clauses['where_clause'] = $and  ." AND q.parentID = '0'";
	}
	else
	{
		$clauses['where_clause'] = $and; // pri tarsene trqbva da pokajim i da6ternite mneniq
	}
	$clauses['order_clause'] = ' ORDER BY '.$orderby;
	$clauses['limit_clause'] = '';
	$items_all = $this->getItemsList($clauses);
	$total = count($items_all);
//----------------- paging ----------------------



	//$pp = "3"; 


		$pp = $_REQUEST['limit']!=""?$_REQUEST['limit']:10; 

	if(isset($_REQUEST['page']) && $_REQUEST['page'] > 1 && isset($_REQUEST['limit']) && $_REQUEST['limit'] > $total) // Za da izbegnem buga, kogato ob6tiq broi rezultati e po-malak ot limita
	{
		$_REQUEST['page'] = 1;
	}
   	
	
		$numofpages = ceil($total / $pp);
		if ((!isset($_REQUEST['page']) or ($_REQUEST['page']=="")) or (isset($_REQUEST['search_btn']))) 
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
	if(!isset($_REQUEST['search_btn']) && !isset($_REQUEST['autor']))
	{
		$clauses['where_clause'] = $and  ." AND q.parentID = '0'";
	}
	else
	{
		$clauses['where_clause'] = $and; // pri tarsene trqbva da pokajim i da6ternite mneniq
	}
	$clauses['order_clause'] = ' ORDER BY '.$orderby;
	$clauses['limit_clause'] = ' LIMIT '.$limitvalue.' , '.$pp;
	$items = $this->getItemsList($clauses);
	

	$forums_listing .= '<div class="postBig">';
	$forums_listing .= require("includes/modules/googleAdsenseMain_468_60.php"); // Pokazva GoogleAdsense 
	$forums_listing .= '<br style="clear:left;"/>';	
	$forums_listing .= '<div class="post">';


		       

	if ((isset($_REQUEST['search_btn'])) or (isset($page)) or isset($_REQUEST['category']))
	{	

		if (!$items) 
		{		
			$forums_listing .= '<div class="date">Няма Теми, отговарящи на зададените критери: ';
			if(isset($_REQUEST['question_category']) or isset($_REQUEST['category'])) {
				$forums_listing .= ' от категория <font style=\'color:#0099FF;\'>'.get_question_category($_REQUEST['question_category']?$_REQUEST['question_category']:$_REQUEST['category']).'</font>';
			}
			if(isset($_REQUEST['question_body']) && $_REQUEST['question_body'] <> "") { 
				$forums_listing .= ", съдържащи в себе си <font style='color:#0099FF;'>'".$_REQUEST['question_body']."'</font>";
			} 
			if(isset($_REQUEST['autor_type']) && $_REQUEST['autor_type'] == 'firm' && isset($_REQUEST['autor'])) {
				$forums_listing .= ' от заведение/фирма <font style=\'color:#0099FF;\'>'.get_firm_nameByFirmID($_REQUEST['autor']).'</font>';
			}  
			if(isset($_REQUEST['autor_type']) && $_REQUEST['autor_type'] == 'user' && isset($_REQUEST['autor'])) {
				$forums_listing .= ' от потребител <font style=\'color:#0099FF;\'>'.get_user_nameByUserID($_REQUEST['autor']).'</font>';
			}			
			
			$forums_listing .= '</div>';	
		} 
		else
		{ 
			$forums_listing .= '<div class="date">Теми '; 
			if(isset($_REQUEST['question_category']) or isset($_REQUEST['category'])) {
				$forums_listing .= ' от категория <font style=\'color:#0099FF;\'>'.get_question_category($_REQUEST['question_category']?$_REQUEST['question_category']:$_REQUEST['category']).'</font>';
			}
			if(isset($_REQUEST['question_body']) && $_REQUEST['question_body'] <> "") { 
				$forums_listing .= ", съдържащи в себе си <font style='color:#0099FF;'>'".$_REQUEST['question_body']."'</font>";
			} 
			if(isset($_REQUEST['autor_type']) && $_REQUEST['autor_type'] == 'firm' && isset($_REQUEST['autor'])) {
				$forums_listing .= ' от заведение/фирма <font style=\'color:#0099FF;\'>'.get_firm_nameByFirmID($_REQUEST['autor']).'</font>';
			}  
			elseif(isset($_REQUEST['autor_type']) && $_REQUEST['autor_type'] == 'user' && isset($_REQUEST['autor'])) {
				$forums_listing .= ' от потребител <font style=\'color:#0099FF;\'>'.get_user_nameByUserID($_REQUEST['autor']).'</font>';
			} 
			elseif(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '' && isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
				$forums_listing .= ', публикувани след <font style=\'color:#0099FF;\'>'.$_REQUEST['fromDate'].'</font> и преди <font style=\'color:#0099FF;\'>'.$_REQUEST['toDate'].'</font>';
			} 
			elseif(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '') {
				$forums_listing .= ', публикувани след <font style=\'color:#0099FF;\'>'.$_REQUEST['fromDate'].'</font>';
			} 
			elseif(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
				$forums_listing .= ', публикувани преди <font style=\'color:#0099FF;\'>'.$_REQUEST['toDate'].'</font>';
			} 
			$forums_listing .= '</div>';
			
		
			$forums_listing .=  '<div class="paging" style="float:left;  width:300px; margin:10px 180px 10px 180px;  padding:5px 0 5px 0;" align="center">';
			//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
			if(!empty($_REQUEST['question_body']) && (!empty($_REQUEST['question_category']) OR !empty($_REQUEST['category']))){
				$posts_listing .= per_page("форум-етикет-категория-".$_REQUEST['question_body'].",%page,".($_REQUEST['question_category']?$_REQUEST['question_category']:$_REQUEST['category']).($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['question_body'])){
				$posts_listing .= per_page("форум-етикет-".$_REQUEST['question_body'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['question_category']) OR !empty($_REQUEST['category'])){
				$posts_listing .= per_page("форум-категория-".($_REQUEST['question_category']?$_REQUEST['question_category']:$_REQUEST['category']).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			else{
				$forums_listing .= per_page("форум-".((isset($_REQUEST['autor_type']) && $_REQUEST['autor_type'] == 'firm' && isset($_REQUEST['autor'])) ? 'autor_type=firm&autor='.$_REQUEST['autor'] : ((isset($_REQUEST['autor_type']) && $_REQUEST['autor_type'] == 'user' && isset($_REQUEST['autor'])) ? 'autor_type=user&autor='.$_REQUEST['autor'] : '') ).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			$forums_listing .= '<div align="center" style="margin-top:10px;">';
		 	$forums_listing .= '	по
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
		 	
		 	
	  	if ($items) 
		{
			$i=0;
			foreach ($items as $questionID => $forumInfo)
			{
				
				$sql="SELECT ".(($forumInfo['autor_type']=='user')?" CONCAT(first_name, ' ', last_name)":'name')." as 'autor_name', username as 'autor_username', location_id as 'location_id' FROM ".(($forumInfo['autor_type']=='user')?'users':'firms')." WHERE ".(($forumInfo['autor_type']=='user')?'userID':'id')." = '".$forumInfo['autor']."' LIMIT 1";
				$conn->setsql($sql);
				$conn->getTableRow();
				$resultMneniqAvtor = $conn->result['autor_name'];	
				$resultQuestionAvtorUsername = $conn->result['autor_username'];
				$resultMneniqAvtorLocation = $conn->result['location_id'];
				
				if($forumInfo['autor'] == 1 && $forumInfo['autor_type'] == 'user')
				{
					$resultMneniqAvtor = 'Админ';
				}
		
				$forums_listing .= '<div class="detailsDiv" id="question_'.$forumInfo['questionID'].'" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
					<h4 style="color:#FF8400"><a href="разгледай-форум-тема-'.get_question_parentID($forumInfo['questionID']).','.$_REQUEST['page'].','.myTruncateToCyrilic($forumInfo['question_title'],200,'_','') .'.html#question_'.$forumInfo['questionID'].'">';
					$forums_listing .= stripslashes(str_replace($_REQUEST['question_body'],"<font color='red'><b>".$_REQUEST['question_body']."</b></font>",$forumInfo['question_title']));
					$forums_listing .= '</a></h4>';
					$forums_listing .= '
					<div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
						<div style=" float:left; margin-right:5px;  font-size:12px;  font-weight:bold; color:#FFF; width:160px;" >
							<a href="разгледай-форум-тема-'.get_question_parentID($forumInfo['questionID']).','.$_REQUEST['page'].','.myTruncateToCyrilic($forumInfo['question_title'],200,'_','') .'.html#question_'.$forumInfo['questionID'].'"><img src="images/forum_vij_oshte.png" /></а>
							
						</div>
						<div style="float:right; background-image:url(images/comment.png); background-position:top; background-repeat:no-repeat; width:25px; height:25px; text-align:center; font-size:8px; color:#FF6600;">'.($forumInfo['numQuestionAnsers']?$forumInfo['numQuestionAnsers']:0).'</div>
						<div style=" float:right; margin-right:5px; color:#FFF; font-size:12px; font-weight:bold;" ><i>'.convert_Month_to_Cyr(date("j F Y,H:i:s",strtotime($forumInfo['created_on']))).'</i></div>
						<div style=" float:right; margin-right:5px;  font-size:12px;  font-weight:bold; color:#FFF;" ><h3 align="left"><a style=" font-size:12px; color:#FFF;" href="форум-категория-'.$forumInfo['category_id'].','.myTruncateToCyrilic($forumInfo['category'],200,'_','') .'.html">'.$forumInfo['category'].'</a> | </h3></div>
						<div style=" float:right; margin-right:5px;  font-size:12px;  font-weight:bold; color:#FFF;" ><h3 align="left">'.(($forumInfo['autor_type'] == 'user') ? '<a style=" font-size:12px; color:#FFF;" href="разгледай-потребител-'.$forumInfo['autor'].',сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html">'.$resultMneniqAvtor : (($forumInfo['autor_type'] == 'firm')? '<a style=" font-size:12px; color:#FFF;" href="разгледай-фирма-'.$forumInfo['autor'].',сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html">'.$resultMneniqAvtor :''))  .'</a> | </h3></div>';
						
						if(($_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) 
						{
							$forums_listing .= '<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm(\'Сигурни ли сте?\')) {return false;}" href="изтрий-форум-тема-'.$forumInfo['questionID'].','.myTruncateToCyrilic($forumInfo['question_title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
						}				
						$forums_listing .= '<br style="clear:both;"/>
						</div><br style="clear:both;"/></div>';  
					
				$i++;
	   
		 		} 
			}

			
		

		$forums_listing .=  "<br style='clear:both;'/><div class='paging' style='float:left;  width:300px; margin:10px 30px 20px 100px; padding:5px 0 5px 0;' align='center'>";
		if(!empty($_REQUEST['question_body']) && (!empty($_REQUEST['question_category']) OR !empty($_REQUEST['category']))){
			$posts_listing .= per_page("форум-етикет-категория-".$_REQUEST['question_body'].",%page,".($_REQUEST['question_category']?$_REQUEST['question_category']:$_REQUEST['category']).($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['question_body'])){
			$posts_listing .= per_page("форум-етикет-".$_REQUEST['question_body'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['question_category']) OR !empty($_REQUEST['category'])){
			$posts_listing .= per_page("форум-категория-".($_REQUEST['question_category']?$_REQUEST['question_category']:$_REQUEST['category']).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		else{
			$forums_listing .= per_page("форум-".((isset($_REQUEST['autor_type']) && $_REQUEST['autor_type'] == 'firm' && isset($_REQUEST['autor'])) ? 'autor_type=firm&autor='.$_REQUEST['autor'] : ((isset($_REQUEST['autor_type']) && $_REQUEST['autor_type'] == 'user' && isset($_REQUEST['autor'])) ? 'autor_type=user&autor='.$_REQUEST['autor'] : '') ).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		$forums_listing .= '</div>';
				
	 }
	}
	$forums_listing .= '</div></div> ';	
	
	
	$forums_listing .= "<script type='text/javascript'>
	Event.observe(window, 'load', function() { 	   
	getFastSearchQuestions(document.getElementById('question_category').value, document.getElementById('question_body').value, document.getElementById('fromDate').value, document.getElementById('toDate').value)
	}
	);
	</script>";

   

	return $forums_listing;
  

?>

