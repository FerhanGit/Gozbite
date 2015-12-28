<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/
	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	$drinks_listing = "";

			if(empty($_REQUEST['drink_category'])) $_REQUEST['drink_category'] = $_REQUEST['category']; 
		 	$_REQUEST['drink_category'] = $_REQUEST['drink_sub_category']?$_REQUEST['drink_sub_category']:$_REQUEST['drink_category'];
		 	
			
	 		if ($_REQUEST['drink_category']!="")  
			{
				$sql="SELECT dcl.drink_id as 'drink_id' FROM drinks d, drink_category dc, drinks_category_list dcl WHERE dcl.drink_id = d.id AND dcl.category_id = dc.id  AND (dcl.category_id = '".$_REQUEST['drink_category']."' OR dcl.category_id IN (SELECT id FROM drink_category WHERE parentID='".$_REQUEST['drink_category']."') )";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numDrinksByCats    = $conn->numberrows;
				$resultDrinksByCats = $conn->result;
				for($n=0;$n<$numDrinksByCats;$n++)
				{
					$DrinksByCatsArr[]=$resultDrinksByCats[$n]['drink_id'];
				}
				if(is_array($DrinksByCatsArr))
				$DrinksByCats = implode(',',$DrinksByCatsArr);
				else $DrinksByCats = '-1';
			}
			
			
			
			if ($_REQUEST['tag']!="")  
			{
				$sql="SELECT pr.drink_id as 'drink_id' FROM drinks d, drinks_products pr  WHERE pr.drink_id = d.id AND LOWER(pr.product) LIKE LOWER('%".trim($_REQUEST['tag'])."%')";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numDrinksByTags    = $conn->numberrows;
				$resultDrinksByTags = $conn->result;
				for($n=0;$n<$numDrinksByTags;$n++)
				{
					$DrinksByTagsArr[]=$resultDrinksByTags[$n]['drink_id'];
				}
				if(is_array($DrinksByTagsArr))
				$DrinksByTags = implode(',',$DrinksByTagsArr);
				else $DrinksByTags = '-1';
			}
			
			
						
	 		$and="";
	 		if ($DrinksByCats != "")  $and .= " AND d.id IN (".$DrinksByCats.")";
	 		if ($_REQUEST['firmID'] != "")  $and .= " AND d.firm_id = '".$_REQUEST['firmID']."'";
	 		if ($_REQUEST['userID'] != "")  $and .= " AND d.user_id = '".$_REQUEST['userID']."'";
	 		if ($_REQUEST['title'] != "")  $and .= " AND (d.title LIKE '%".$_REQUEST['title']."%' OR d.info LIKE '%".$_REQUEST['title']."%')";
	 		if ($DrinksByTags!="")  $and .= " AND d.id IN (".$DrinksByTags.")";
	 		if ($_REQUEST['fromDate']!="")  $and .= " AND d.updated_on > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %f.%i')";
	 		if ($_REQUEST['toDate']!="")  $and .= " AND d.updated_on < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %f.%i')"; 
	 		
	 	
			if ($_REQUEST['specialiteti'] == 1)  $and .= " AND d.is_Featured = '1' AND d.is_Featured_end > NOW() ";
	 		
			
	 		
			$orderbyCond = "";
			$orderbyCond = 'd.active DESC, d.is_Gold DESC, d.is_Silver DESC';
			
			if ((isset($_REQUEST['orderby'])) && ($_REQUEST['orderby']!=""))
			{
				switch ($_REQUEST['orderby'])
				{
					case 'updated_on': $orderbyCond .= ', d.updated_on DESC';
					break;
					
						case 'title': $orderbyCond .= ', d.title';
					break;
																		
					default : $orderbyCond .= ', d.updated_on DESC';
					break;
				}
			}
			else $orderbyCond .= ', d.updated_on DESC';
			
	 	    

	// ==================== ALL RESULTS =========================
	   	$clauses = array();
		$clauses['where_clause'] = $and;
		$clauses['order_clause'] = ' ORDER BY '.$orderbyCond;
		$clauses['limit_clause'] = '';
		$items_all = $this->getItemsList($clauses);
		$total = count($items_all);

		
	
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

	//	$drinks_listing .= print_r($this,1);

	$drinks_listing .= '<div class="postBig">';
	$drinks_listing .= require("includes/modules/googleAdsenseMain_468_60.php"); // Pokazva GoogleAdsense 
	$drinks_listing .= '<br style="clear:left;"/>';	
	$drinks_listing .= '<div class="post">';



			       

	if ((isset($_REQUEST['search_btn'])) or (isset($page)) or isset($_REQUEST['category']))
	{	

		if (!$items) 
		{		
			$drinks_listing .= '<div class="date">Няма Напитки, отговарящи на зададените критерии - ';
			if(isset($_REQUEST['specialiteti']) && $_REQUEST['specialiteti'] == 1) {
				$drinks_listing .= ' <font style=\'color:#0099FF;\'> - специалитети</font>';
			}
			if(isset($_REQUEST['drink_category']) or isset($_REQUEST['category'])) {
				$drinks_listing .= ' от категория <font style=\'color:#0099FF;\'>'.get_drink_category($_REQUEST['drink_category']?$_REQUEST['drink_category']:$_REQUEST['category'])."</font>";
			}
			if(isset($_REQUEST['tag']) && $_REQUEST['tag'] <> "")
			{ 
				$drinks_listing .= ", съдържащи в себе си продукт/и <font style='color:#0099FF;'>".$_REQUEST['tag']."</font>";
			} 
			if(isset($_REQUEST['title']) && $_REQUEST['title'] <> "")
			{ 
				$drinks_listing .= ", съдържащи в себе си <font style='color:#0099FF;'>".$_REQUEST['title']."</font>";
			} 
			if(isset($_REQUEST['firmID'])) {
				$drinks_listing .= ' от заведение/фирма '.get_drink_firm_name_BY_firmID($_REQUEST['firmID'])."</font>";
			}   
			elseif(isset($_REQUEST['userID'])) {
				$drinks_listing .= ' от потребител <font style=\'color:#0099FF;\'>'.get_drink_user_name_BY_userID($_REQUEST['userID'])."</font>";
			} 
			$drinks_listing .= '</div>';	
		} 
		else
		{ 
		
			$drinks_listing .= '<div class="date">Напитки '; 
			if(isset($_REQUEST['specialiteti']) && $_REQUEST['specialiteti'] == 1) {
				$drinks_listing .= ' <font style=\'color:#0099FF;\'> - специалитети</font>';
			}
			if(isset($_REQUEST['drink_category']) or isset($_REQUEST['category'])) {
				$drinks_listing .= ' от категория <font style=\'color:#0099FF;\'>'.get_drink_category($_REQUEST['drink_category']?$_REQUEST['drink_category']:$_REQUEST['category'])."</font>";
			}
			if(isset($_REQUEST['tag']) && $_REQUEST['tag'] <> "")
			{ 
				$drinks_listing .= ", съдържащи в себе си продукт/и <font style='color:#0099FF;'>".$_REQUEST['tag']."</font>";
			} 
			if(isset($_REQUEST['title']) && $_REQUEST['title'] <> "")
			{ 
				$drinks_listing .= ", съдържащи в себе си <font style='color:#0099FF;'>".$_REQUEST['title']."</font>";
			} 
			if(isset($_REQUEST['firmID'])) {
				$drinks_listing .= ' от заведение/фирма '.get_drink_firm_name_BY_firmID($_REQUEST['firmID'])."</font>";
			}   
			elseif(isset($_REQUEST['userID'])) {
				$drinks_listing .= ' от потребител <font style=\'color:#0099FF;\'>'.get_drink_user_name_BY_userID($_REQUEST['userID'])."</font>";
			} 
			elseif(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '' && isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
				$drinks_listing .= ', публикувани след '.$_REQUEST['fromDate'].' и преди '.$_REQUEST['toDate'];
			} 
			elseif(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '') {
				$drinks_listing .= ', публикувани след '.$_REQUEST['fromDate'];
			} 
			elseif(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
				$drinks_listing .= ', публикувани преди '.$_REQUEST['toDate'];
			} 
			$drinks_listing .= '</div>';
				
			
			
		
			$drinks_listing .=  '<div class="paging" style="float:left;  width:300px; margin:10px 180px 10px 180px;  padding:5px 0 5px 0;" align="center">';
			//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
			if(isset($_REQUEST['specialiteti']) && $_REQUEST['specialiteti'] == 1) {
				$drinks_listing .= per_page("напитки-специалитети,%page,".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['tag']) && (!empty($_REQUEST['drink_category']) OR !empty($_REQUEST['category']))){
				$drinks_listing .= per_page("напитки-етикет-категория-".$_REQUEST['tag'].",%page,".($_REQUEST['drink_category']?$_REQUEST['drink_category']:$_REQUEST['category']).($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['tag'])){
				$drinks_listing .= per_page("напитки-етикет-".$_REQUEST['tag'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['title'])){
				$drinks_listing .= per_page("напитки-title=".$_REQUEST['title'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['drink_category']) OR !empty($_REQUEST['category'])){
				$drinks_listing .= per_page("напитки-категория-".($_REQUEST['drink_category']?$_REQUEST['drink_category']:$_REQUEST['category']).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			else{
				$drinks_listing .= per_page("напитки-".($_REQUEST['firmID'] ? 'firmID='.$_REQUEST['firmID'] : ($_REQUEST['userID'] ? 'userID='.$_REQUEST['userID'] : '') ).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
			}
			$drinks_listing .= '<div align="center" style="margin-top:10px;">';
		 	$drinks_listing .= '	по
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
			foreach ($items as $drinkID => $drinkInfo)
			{
				$randDrinkCat = rand( 0 , (count($drinkInfo['Cats'])-1) );
					
				//$picFile =  "image.php?i=pics/drinks/".$drinkInfo['resultPics']['url_thumb'][0]."&fh=&fv=&ed=&gr=&rw=140&rh=&sk=&sh=1&ct=&cf=1942.ttf&cs&cn=&r=5";
                $picFile =  "pics/drinks/".$drinkInfo['resultPics']['url_thumb'][0];
		
				$drinks_listing .= '	<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
					<table><tr><td>
						<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; width:80px; overflow:hidden;" ><a href="разгледай-напитка-'.$drinkInfo['drinkID'].','.$page.','.myTruncateToCyrilic($drinkInfo['title'],200,'_','') .'.html" onmouseover="slideBody('.$i.');"><img  width="80" src="';
						if(is_file('pics/drinks/'.$drinkInfo['resultPics']['url_thumb'][0])) {
							$drinks_listing .= $picFile;
						} 
						else {
							$drinks_listing .= "pics/drinks/no_photo_thumb.png";
						}
				$drinks_listing .= '"  /></a></div>
					</td><td>
						<h4 style="float:left;color:#FF8400;width:540px;">
							<div style="float:left;margin-left:0px; width:350px; color:#0099FF; font-weight:bold;" >';
							if($drinkInfo['active'] != 1) 
							{ 
								$drinks_listing .= '<span style="color:#FF0000;" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Неактивна Напитка!] body=[&rarr; Напитката е деактивирана от страна на нейния автор или от администратора на портала.]\'> | Неактивно! </span>';
							}
							
						$drinks_listing .= '<a href="разгледай-напитка-'.$drinkInfo['drinkID'].','.$page.','.myTruncateToCyrilic($drinkInfo['title'],200,'_','') .'.html"  onmouseover="slideBody('.$i.');">'.$drinkInfo['title'] .'</a></div>';
						$drinks_listing .= '</h4>';						
						$drinks_listing .= '<div class="detailsDiv" style="float:left; width:550px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
								<div style=" float:left; margin-left:6px; width:250px;color:#0099FF;  font-size:12px; font-weight:bold;" >
									<div style="float:left; margin-right:2px; " >									
										<fb:like href="http://www.gozbite.com/разгледай-напитка-'.$drinkInfo['drinkID'].','.myTruncateToCyrilic(strip_tags($drinkInfo['title']),200,'_','') .'.html" layout="button_count"	show_faces="false" width="50" height="30" action="like" colorscheme="light"></fb:like>								
									</div>
								</div>
								<div style=" float:right; margin-right:5px; font-weight:bold; color:#0099FF;" ><h3 align="left"><a style=" font-size:14px; font-weight:bold; color:#FFFFFF;" href="напитки-категория-'.$drinkInfo['Cats'][$randDrinkCat]['drink_category_id'].','.$page.','.myTruncateToCyrilic($drinkInfo['Cats'][$randDrinkCat]['drink_category_name'],200,'_','') .'.html"  onmouseover="slideBody('.$i.');">'.$drinkInfo['Cats'][$randDrinkCat]['drink_category_name'].'</a></h3></div>';								
								if($drinkInfo['has_video'] == 1) {	
									$drinks_listing .= '<div style="float:right; margin-right:5px;" ><img style="margin-left:5px;" src="images/video.png" width="14" height="14"></div>';
								}
								
								
								if(($drinkInfo['firm_id'] == $_SESSION['userID'] && $_SESSION['user_type'] == 'firm') OR ($drinkInfo['user_id'] == $_SESSION['userID'] && $_SESSION['user_type'] == 'user') or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1) 
								{	
									$drinks_listing .= '<div style="float:right; margin-right:5px;" ><a href="редактирай-напитка-'.$drinkInfo['drinkID'].','.myTruncateToCyrilic($drinkInfo['title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a>';
									if($drinkInfo['gold'] == '1')
									{
										$drinks_listing .= '<img style="margin-left:5px;" src="images/star_gold.gif">';
									} 
									elseif($drinkInfo['silver'] == '1') 
									{
										$drinks_listing .= '<img style="margin-left:5px;" src="images/star_grey.gif">';
									}
									if($drinkInfo['is_Featured'] == '1' && strtotime($drinkInfo['is_Featured_end']) > time()) 
									{ 
										$drinks_listing .= '<img style="margin-left:5px;"  height="20" src="images/specialitet.png" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Специалитет!] body=[&rarr; Тази напитка е със статут на <span style="color:#FF6600;font-weight:bold;">специалитет</span>. Ако желаете и Вашата готварска рецепта или напита да бъде <span style="color:#FF6600;font-weight:bold;">специалитет на сайта</span> вижте поясненията при редактиране на описанието и.] \'>';
									} 
									$drinks_listing .= '</div>';
								}
								else 
								{ 
									$drinks_listing .= '<div style="float:right; margin-right:5px;" >';
									if($drinkInfo['gold'] == '1') 
									{ 
										$drinks_listing .= '<img style="margin-left:5px;" src="images/star_gold.gif">';
									} 
									elseif($drinkInfo['silver'] == '1') 
									{
										$drinks_listing .= '<img style="margin-left:5px;" src="images/star_grey.gif">';
									}
									if($drinkInfo['is_Featured'] == '1' && strtotime($drinkInfo['is_Featured_end']) > time()) 
									{ 
										$drinks_listing .= '<img style="margin-left:5px;"  height="20" src="images/specialitet.png" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Специалитет!] body=[&rarr; Тази напитка е със статут на <span style="color:#FF6600;font-weight:bold;">специалитет</span>. Ако желаете и Вашата готварска рецепта или напита да бъде <span style="color:#FF6600;font-weight:bold;">специалитет на сайта</span> вижте поясненията при редактиране на описанието и.] \'>';
									} 
									 
									$drinks_listing .= '</div>';
								
								} 

							
								
								if((($_SESSION['user_kind'] == 2) or $_SESSION['userID']==1)) {	
									$drinks_listing .= '<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}"  href="изтрий-напитка-'.$drinkInfo['drinkID'].','.myTruncateToCyrilic($drinkInfo['title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
								}
									
					$drinks_listing .= '<br style="clear:both;"/>	
						</div>
					</td></tr></table>';
							
					$drinks_listing .= '<div class="textBody" id="textBody_'.$i.'" style="display:none; clear:left;">					
			    		<br style="clear:both;"/>
						<div align="right"><a href="разгледай-напитка-'.$drinkInfo['drinkID'].','.$page.','.myTruncateToCyrilic($drinkInfo['title'],200,'_','') .'.html"><u>Виж напитката</u></a></div>
		  			</div>
							       
	       		</div>  ';  
					
				$i++;
	   
		 		} 
			}


		

		$drinks_listing .=  "<div class='paging' style='float:left;  width:300px; margin:10px 30px 20px 100px; padding:5px 0 5px 0;' align='center'>";
		if(isset($_REQUEST['specialiteti']) && $_REQUEST['specialiteti'] == 1) {
			$drinks_listing .= per_page("напитки-специалитети,%page,".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['tag']) && (!empty($_REQUEST['drink_category']) OR !empty($_REQUEST['category']))){
			$drinks_listing .= per_page("напитки-етикет-категория-".$_REQUEST['tag'].",%page,".($_REQUEST['drink_category']?$_REQUEST['drink_category']:$_REQUEST['category']).($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['tag'])){
			$drinks_listing .= per_page("напитки-етикет-".$_REQUEST['tag'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['title'])){
			$drinks_listing .= per_page("напитки-title=".$_REQUEST['title'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['drink_category']) OR !empty($_REQUEST['category'])){
			$drinks_listing .= per_page("напитки-категория-".($_REQUEST['drink_category']?$_REQUEST['drink_category']:$_REQUEST['category']).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		else{
			$drinks_listing .= per_page("напитки-".($_REQUEST['firmID'] ? 'firmID='.$_REQUEST['firmID'] : ($_REQUEST['userID'] ? 'userID='.$_REQUEST['userID'] : '') ).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html", "2", $numofpages, $page);
		}
		$drinks_listing .= '	</div> ';
				
	 }
	}
		$drinks_listing .= '</div>
		</div>	';
	

	$drinks_listing .= '<br style="clear:left;"/>';	
	
	

	return $drinks_listing;
  

?>
