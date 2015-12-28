<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/
	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	$recipes_listing = "";

			if(empty($_REQUEST['recipe_category'])) $_REQUEST['recipe_category'] = $_REQUEST['category']; 
		 	$_REQUEST['recipe_category'] = $_REQUEST['recipe_sub_category']?$_REQUEST['recipe_sub_category']:$_REQUEST['recipe_category'];
		 	
			
	 		if ($_REQUEST['recipe_category']!="")  
			{
				$sql="SELECT rcl.recipe_id as 'recipe_id' FROM recipes r, recipe_category rc, recipes_category_list rcl WHERE rcl.recipe_id = r.id AND rcl.category_id = rc.id  AND (rcl.category_id = '".$_REQUEST['recipe_category']."' OR rcl.category_id IN (SELECT id FROM recipe_category WHERE parentID='".$_REQUEST['recipe_category']."') )";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numRecipesByCats    = $conn->numberrows;
				$resultRecipesByCats = $conn->result;
				for($n=0;$n<$numRecipesByCats;$n++)
				{
					$RecipesByCatsArr[]=$resultRecipesByCats[$n]['recipe_id'];
				}
				if(is_array($RecipesByCatsArr))
				$RecipesByCats = implode(',',$RecipesByCatsArr);
				else $RecipesByCats = '-1';
			}
			
			if ($_REQUEST['kuhnq'] != "")  
			{
				$sql="SELECT kl.recipe_id as 'recipe_id', k.name as 'kuhnq', kl.kuhnq_id as 'kuhnq_id'  FROM recipes r, kuhni k, kuhni_list kl WHERE kl.recipe_id = r.id AND kl.kuhnq_id = k.id  AND k.id = '".$_REQUEST['kuhnq']."'";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numRecipesByKuhnq    = $conn->numberrows;
				$resultRecipesByKuhnq = $conn->result;
				for($n=0;$n<$numRecipesByKuhnq;$n++)
				{
					$RecipesByKuhnqArr[]=$resultRecipesByKuhnq[$n]['recipe_id'];
				}
				if(is_array($RecipesByKuhnqArr))
				$RecipesByKuhnq = implode(',',$RecipesByKuhnqArr);
				else $RecipesByKuhnq = '-1';
			}
			
			
			
			if ($_REQUEST['tag']!="")  // Pri recepti i napitki "TAG" tarsi samo v produktite, dokato pri ostanalite razdeli tarsi v opisanieto i naimenovanieto
			{
				$sql="SELECT pr.recipe_id as 'recipe_id' FROM recipes r, recipes_products pr  WHERE pr.recipe_id = r.id AND LOWER(pr.product) LIKE LOWER('%".trim($_REQUEST['tag'])."%')";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numRecipesByTags    = $conn->numberrows;
				$resultRecipesByTags = $conn->result;
				for($n=0;$n<$numRecipesByTags;$n++)
				{
					$RecipesByTagsArr[]=$resultRecipesByTags[$n]['recipe_id'];
				}
				if(is_array($RecipesByTagsArr))
				$RecipesByTags = implode(',',$RecipesByTagsArr);
				else $RecipesByTags = '-1';
			}
			
			
						
	 		$and="";
	 		if ($RecipesByCats != "")  $and .= " AND r.id IN (".$RecipesByCats.")";
	 		if ($RecipesByKuhnq != "")  $and .= " AND r.id IN (".$RecipesByKuhnq.")";
	 		if ($_REQUEST['firmID'] != "")  $and .= " AND r.firm_id = '".$_REQUEST['firmID']."'";
	 		if ($_REQUEST['userID'] != "")  $and .= " AND r.user_id = '".$_REQUEST['userID']."'";
	 		if ($_REQUEST['title'] != "")  $and .= " AND (r.title LIKE '%".$_REQUEST['title']."%' OR r.info LIKE '%".$_REQUEST['title']."%')";
	 		if ($RecipesByTags!="")  $and .= " AND r.id IN (".$RecipesByTags.")";
	 		if ($_REQUEST['fromDate']!="")  $and .= " AND r.updated_on > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %f.%i')";
	 		if ($_REQUEST['toDate']!="")  $and .= " AND r.updated_on < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %f.%i')"; 
	 		
	 	
			if ($_REQUEST['specialiteti'] == 1)  $and .= " AND r.is_Featured = '1' AND r.is_Featured_end > NOW() ";
	 		
			
	 		
			$orderbyCond = "";
			$orderbyCond = 'r.active DESC, r.is_Gold DESC, r.is_Silver DESC';
			
			if ((isset($_REQUEST['orderby'])) && ($_REQUEST['orderby']!=""))
			{
				switch ($_REQUEST['orderby'])
				{
					case 'updated_on': $orderbyCond .= ', r.updated_on DESC';
					break;
					
						case 'title': $orderbyCond .= ', r.title';
					break;
																		
					default : $orderbyCond .= ', r.updated_on DESC';
					break;
				}
			}
			else $orderbyCond .= ', if(rand()<0.5,r.registered_on,RAND()) DESC';
			
	 	    

	// ==================== ALL RESULTS =========================
	   	$clauses = array();
		$clauses['where_clause'] = $and;
		$clauses['order_clause'] = ' ORDER BY '.$orderbyCond;
		$clauses['limit_clause'] = '';
		$items_all = $this->getItemsList($clauses);
		$total = count($items_all);
		
		//$recipes_listing .= print_r($items_all,1);
		
	
	//----------------- paging ----------------------
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
	// -----------------------------------------------  y
   	
   	
   	
	// =================== PER PAGE LISTING =====================
	$clauses = array();
	$clauses['where_clause'] = $and;
	$clauses['order_clause'] = ' ORDER BY '.$orderbyCond;
	$clauses['limit_clause'] = ' LIMIT '.$limitvalue.' , '.$pp;
	$items = $this->getItemsList($clauses);

		//$recipes_listing .= print_r($this,1);

	$recipes_listing .= '<div class="postBig">';
	$recipes_listing .= require("includes/modules/googleAdsenseMain_468_60.php"); // Pokazva GoogleAdsense 
	$recipes_listing .= '<br style="clear:left;"/>';	
	$recipes_listing .= '<div class="post">';


	       

	if ((isset($_REQUEST['search_btn'])) or (isset($page)) or isset($_REQUEST['category']))
	{	

		if (!$items) 
		{		
			$recipes_listing .= '<div class="date">Няма Рецепти, отговарящи на зададените критерии -  ';
			if(isset($_REQUEST['specialiteti']) && $_REQUEST['specialiteti'] == 1) {
				$recipes_listing .= ' <font style=\'color:#0099FF;\'> - специалитети</font>';
			}
			if(isset($_REQUEST['recipe_category']) or isset($_REQUEST['category'])) {
				$recipes_listing .= ' от категория <font style=\'color:#0099FF;\'>'.get_recipe_category($_REQUEST['recipe_category']?$_REQUEST['recipe_category']:$_REQUEST['category'])."</font>";
			}
			if(isset($_REQUEST['tag']) && $_REQUEST['tag'] <> "")
			{ 
				$recipes_listing .= ", съдържащи в себе си <font style='color:#0099FF;'>".$_REQUEST['tag']."</font>";
			} 
			if(isset($_REQUEST['title']) && $_REQUEST['title'] <> "")
			{ 
				$recipes_listing .= ", съдържащи в себе си <font style='color:#0099FF;'>".$_REQUEST['title']."</font>";
			} 
			
			if(isset($_REQUEST['kuhnq']) && $_REQUEST['kuhnq'] <> "")
			{ 
				$recipes_listing .= ", част от <font style='color:#0099FF;'>".get_kuhnq_nameByKuhnqID($_REQUEST['kuhnq'])." кухня</font>";
			} 
			
			if(isset($_REQUEST['firmID'])) {
				$recipes_listing .= ' публикувани от заведение/фирма '.get_recipe_firm_name_BY_firmID($_REQUEST['firmID'])."</font>";
			}   
			elseif(isset($_REQUEST['userID'])) {
				$recipes_listing .= ' публикувани от потребител <font style=\'color:#0099FF;\'>'.get_recipe_user_name_BY_userID($_REQUEST['userID'])."</font>";
			} 
			
			$recipes_listing .= '</div>';	
		} 
		else
		{ 
			$recipes_listing .= '<div class="date">Рецепти '; 
			if(isset($_REQUEST['specialiteti']) && $_REQUEST['specialiteti'] == 1) {
				$recipes_listing .= ' <font style=\'color:#0099FF;\'> - специалитети</font>';
			}
			if(isset($_REQUEST['recipe_category']) or isset($_REQUEST['category'])) {
				$recipes_listing .= ' от категория <font style=\'color:#0099FF;\'>'.get_recipe_category($_REQUEST['recipe_category']?$_REQUEST['recipe_category']:$_REQUEST['category'])."</font>";
			}
			if(isset($_REQUEST['tag']) && $_REQUEST['tag'] <> "")
			{ 
				$recipes_listing .= ", съдържащи в себе си <font style='color:#0099FF;'>".$_REQUEST['tag']."</font>";
			} 
			if(isset($_REQUEST['title']) && $_REQUEST['title'] <> "")
			{ 
				$recipes_listing .= ", съдържащи в себе си <font style='color:#0099FF;'>".$_REQUEST['title']."</font>";
			} 
			if(isset($_REQUEST['kuhnq']) && $_REQUEST['kuhnq'] <> "")
			{ 
				$recipes_listing .= ", част от <font style='color:#0099FF;'>".get_kuhnq_nameByKuhnqID($_REQUEST['kuhnq'])." кухня</font>";
			} 
				
			if(isset($_REQUEST['firmID'])) {
				$recipes_listing .= ' публикувани от заведение/фирма '.get_recipe_firm_name_BY_firmID($_REQUEST['firmID'])."</font>";
			}   
			elseif(isset($_REQUEST['userID'])) {
				$recipes_listing .= ' публикувани от потребител <font style=\'color:#0099FF;\'>'.get_recipe_user_name_BY_userID($_REQUEST['userID'])."</font>";
			} 
			elseif(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '' && isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
				$recipes_listing .= ', публикувани след '.$_REQUEST['fromDate'].' и преди '.$_REQUEST['toDate'];
			} 
			elseif(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '') {
				$recipes_listing .= ', публикувани след '.$_REQUEST['fromDate'];
			} 
			elseif(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
				$recipes_listing .= ', публикувани преди '.$_REQUEST['toDate'];
			} 
			$recipes_listing .= '</div>';
			
			
			$recipes_listing .=  '<div class="paging" style="float:left;  width:300px; margin:10px 180px 10px 180px;  padding:5px 0 5px 0;" align="center">';
			//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
			if(isset($_REQUEST['specialiteti']) && $_REQUEST['specialiteti'] == 1) {
				$recipes_listing .= per_page("рецепти-специалитети,%page,".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['tag']) && (!empty($_REQUEST['recipe_category']) OR !empty($_REQUEST['category']))){
				$recipes_listing .= per_page("рецепти-етикет-категория-".$_REQUEST['tag'].",%page,".($_REQUEST['recipe_category']?$_REQUEST['recipe_category']:$_REQUEST['category']).($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['tag'])){
				$recipes_listing .= per_page("рецепти-етикет-".$_REQUEST['tag'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['title'])){
				$recipes_listing .= per_page("рецепти-title=".$_REQUEST['title'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['recipe_category']) OR !empty($_REQUEST['category'])){
				$recipes_listing .= per_page("рецепти-категория-".($_REQUEST['recipe_category']?$_REQUEST['recipe_category']:$_REQUEST['category']).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['kuhnq'])){
				$recipes_listing .= per_page("рецепти-кухня-".$_REQUEST['kuhnq'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			else{
				$recipes_listing .= per_page("рецепти-".($_REQUEST['firmID'] ? 'firmID='.$_REQUEST['firmID'] : ($_REQUEST['userID'] ? 'userID='.$_REQUEST['userID'] : '') ).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			$recipes_listing .= '<div align="center" style="margin-top:10px;">';
		 	$recipes_listing .= '	по
			 		<select style="width:50px;" name="limit_fast" id="limit_fast"  onchange="fastLimit(this);">
			  			<option value="5"  '.(($_REQUEST['limit'] == 5)?"selected":"").'>5</option>
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
			foreach ($items as $recipeID => $recipeInfo)
			{
				$randRecipeCat = rand( 0 , (count($recipeInfo['Cats'])-1) );
					
				//$picFile =  "image.php?i=pics/recipes/".$recipeInfo['resultPics']['url_thumb'][0]."&fh=&fv=&ed=&gr=&rw=140&rh=&sk=&sh=1&ct=&cf=1942.ttf&cs&cn=&r=5";
                $picFile =  "pics/recipes/".$recipeInfo['resultPics']['url_thumb'][0];
		
				$recipes_listing .= '	<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
					<table><tr><td>
						<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; width:80px; overflow:hidden;" ><a href="разгледай-рецепта-'.$recipeInfo['recipeID'].','.$page.','.myTruncateToCyrilic($recipeInfo['title'],200,'_','') .'.html" onmouseover="slideBody('.$i.');"><img  width="80" src="';
						if(is_file('pics/recipes/'.$recipeInfo['resultPics']['url_thumb'][0])) {
							$recipes_listing .= $picFile;
						} 
						else {
							$recipes_listing .= "pics/recipes/no_photo_thumb.png";
						}
				$recipes_listing .= '"  /></a></div>
					</td><td>
					
					
					
					<h4 style="float:left;color:#FF8400;width:540px;">
							<div style="float:left;margin-left:0px; width:350px; color:#0099FF; font-weight:bold;" >';
							if($recipeInfo['active'] != 1) 
							{ 
								$recipes_listing .= '<span style="color:#FF0000;" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Неактивна Рецепта!] body=[&rarr; Рецептата е деактивирана от страна на нейния автор или от администратора на портала.]\'> | Неактивно! </span>';
							}


							$recipes_listing .= '<a href="разгледай-рецепта-'.$recipeInfo['recipeID'].','.$page.','.myTruncateToCyrilic($recipeInfo['title'],100,'_','') .'.html"  onmouseover="slideBody('.$i.');">'.$recipeInfo['title'] .'</a></div>';
	$recipes_listing .= '
						</h4>
						<div class="detailsDiv" style="float:left; width:550px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
							<div style=" float:left; margin-left:5px; width:250px;font-weight:bold; color:#FFF;" ><h3 align="left"><a style="font-size:14px; font-weight:bold; color:#FFF;" href="рецепти-категория-'.$recipeInfo['Cats'][$randRecipeCat]['recipe_category_id'] .','.myTruncateToCyrilic($recipeInfo['Cats'][$randRecipeCat]['recipe_category_name'],100,'_','') .'.html"  onmouseover="slideBody('.$i.');">'.$recipeInfo['Cats'][$randRecipeCat]['recipe_category_name'] .'</a></h3></div>								
							<div style="float:left; margin-right:2px; " >									
								<fb:like href="http://www.gozbite.com/разгледай-рецепта-'.$recipeInfo['recipeID'].','.myTruncateToCyrilic(strip_tags($recipeInfo['title']),100,'_','') .'.html" layout="button_count"	show_faces="false" width="50" height="30" action="like" colorscheme="light"></fb:like>								
							</div>
							<div style=" float:right; margin-right:5px; font-weight:bold; color:#FFF;" ><h3 align="left"><a style="font-size:14px; font-weight:bold; color:#FFF;" href="разгледай-кухня-'.$recipeInfo['Kuhnq']['kuhnq_id'].','.myTruncateToCyrilic($recipeInfo['Kuhnq']['kuhnq'],100,'_','') .'.html"  onmouseover="slideBody('.$i.');">'.$recipeInfo['Kuhnq']['kuhnq'] .' кухня</a></h3></div>';								
							
							 
							if(($recipeInfo['firm_id'] == $_SESSION['userID'] && $_SESSION['user_type'] == 'firm') OR ($recipeInfo['user_id'] == $_SESSION['userID'] && $_SESSION['user_type'] == 'user') or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1) 
							{
								$recipes_listing .= '<div style="float:right; margin-right:5px;" ><a href="редактирай-рецепта-'.$recipeInfo['recipeID'].','.myTruncateToCyrilic($recipeInfo['title'],100,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a>';
								if($recipeInfo['gold'] == '1')
								{
									$recipes_listing .= '<img style="margin-left:5px;" src="images/star_gold.gif">';
								} 
								elseif($recipeInfo['silver'] == '1') 
								{ 
									$recipes_listing .= '<img style="margin-left:5px;" src="images/star_grey.gif">';
								} 
								if($recipeInfo['is_Featured'] == '1' && strtotime($recipeInfo['is_Featured_end']) > time()) 
								{ 
									$recipes_listing .= '<img style="margin-left:5px;"  height="20" src="images/specialitet.png" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Специалитет!] body=[&rarr; Тази рецепта е със статут на <span style="color:#FF6600;font-weight:bold;">специалитет</span>. Ако желаете и Вашата готварска рецепта или напита да бъде <span style="color:#FF6600;font-weight:bold;">специалитет на сайта</span> вижте поясненията при редактиране на описанието и.] \'>';
								} 
								$recipes_listing .= '</div>';
							} 
							else 
							{
									$recipes_listing .= '<div style="float:right; margin-right:5px;" >';
									if($recipeInfo['gold'] == '1') 
									{ 
										$recipes_listing .= '<img style="margin-left:5px;" src="images/star_gold.gif">';
									} 
									elseif($recipeInfo['silver'] == '1') 
									{ 
										$recipes_listing .= '<img style="margin-left:5px;" src="images/star_grey.gif">';
									} 
									if($recipeInfo['is_Featured'] == '1' && strtotime($recipeInfo['is_Featured_end']) > time()) 
									{ 
										$recipes_listing .= '<img style="margin-left:5px;"  height="20" src="images/specialitet.png" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Специалитет!] body=[&rarr; Тази рецепта е със статут на <span style="color:#FF6600;font-weight:bold;">специалитет</span>. Ако желаете и Вашата готварска рецепта или напита да бъде <span style="color:#FF6600;font-weight:bold;">специалитет на сайта</span> вижте поясненията при редактиране на описанието и.] \'>';
									} 
									$recipes_listing .= '</div>';
							 } 
							 if(($_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) 
							 {	
								$recipes_listing .= '<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-рецепта-'.$recipeInfo['recipeID'].','.myTruncateToCyrilic($recipeInfo['title'],100,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
							 }
$recipes_listing .= '<br style="clear:both;"/>	
						</div>
						
					</td></tr></table>';
							
					$recipes_listing .= '<div class="textBody" id="textBody_'.$i.'" style="display:none; clear:left;">					
			    		<br style="clear:both;"/>
						<div align="right"><a href="разгледай-рецепта-'.$recipeInfo['recipeID'].','.$page.','.myTruncateToCyrilic($recipeInfo['title'],200,'_','') .'.html"><u>Виж рецептата</u></a></div>
		  			</div>
							       
	       		</div>  ';  
					
				$i++;
	   
		 		} 
			}


		

		$recipes_listing .=  "<div class='paging' style='float:left;  width:300px; margin:10px 30px 20px 100px; padding:5px 0 5px 0;' align='center'>";
		if(isset($_REQUEST['specialiteti']) && $_REQUEST['specialiteti'] == 1) {
			$recipes_listing .= per_page("рецепти-специалитети,%page,".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['tag']) && (!empty($_REQUEST['recipe_category']) OR !empty($_REQUEST['category']))){
			$recipes_listing .= per_page("рецепти-етикет-категория-".$_REQUEST['tag'].",%page,".($_REQUEST['recipe_category']?$_REQUEST['recipe_category']:$_REQUEST['category']).($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['tag'])){
			$recipes_listing .= per_page("рецепти-етикет-".$_REQUEST['tag'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['title'])){
			$recipes_listing .= per_page("рецепти-title=".$_REQUEST['title'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['recipe_category']) OR !empty($_REQUEST['category'])){
			$recipes_listing .= per_page("рецепти-категория-".($_REQUEST['recipe_category']?$_REQUEST['recipe_category']:$_REQUEST['category']).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['kuhnq'])){
			$recipes_listing .= per_page("рецепти-кухня-".$_REQUEST['kuhnq'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		else{
			$recipes_listing .= per_page("рецепти-".($_REQUEST['firmID'] ? 'firmID='.$_REQUEST['firmID'] : ($_REQUEST['userID'] ? 'userID='.$_REQUEST['userID'] : '') ).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		$recipes_listing .= '	</div> ';
				
	 }
	}
		$recipes_listing .= '</div>
		</div>	';
	

	$recipes_listing .= '<br style="clear:left;"/>';	
	
   

	return $recipes_listing;
  

?>