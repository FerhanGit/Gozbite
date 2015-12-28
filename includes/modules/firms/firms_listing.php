<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/
	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	$firms_listing = "";

	
			if(empty($_REQUEST['firm_category'])) $_REQUEST['firm_category'] = $_REQUEST['category'];
			$_REQUEST['firm_category'] = $_REQUEST['firm_sub_category']?$_REQUEST['firm_sub_category']:$_REQUEST['firm_category'];
		 
			
			if ($_REQUEST['firm_category'] != "")  
			{
				// ===================== Vzemame kategoriqta na gornata bolnica i pokazvame o6te bolnici ot tazi kategoriq ==========//
				    $Firms_By_Cats = "";
			  		$ItmsRelatedByCat = getFirmIDsByCat($_REQUEST['firm_category']);	
				    if(is_array($ItmsRelatedByCat))
				    {
				    	if(count($ItmsRelatedByCat) > 0)
					    {
					    	$Firms_By_Cats = " AND f.id IN (".implode(',',$ItmsRelatedByCat).")";
					    }
				    }	
				    // Ako nqmame bolnici ot tazi kategoriq pokazvame nai-novite bolnici		   
				// =============================================================================================================//
		  	}
	
	 		$and="";
	 		if ($_REQUEST['firm_name'] != "")  $and .= " AND f.name LIKE '%".$_REQUEST['firm_name']."%'";
	 		if ($_REQUEST['address'] != "")  $and .= " AND f.address LIKE '%".$_REQUEST['address']."%'";
	 		if ($Firms_By_Cats != "")  $and .= $Firms_By_Cats;
	 		if ($_REQUEST['manager'] != "")  $and .= " AND f.manager LIKE '%".$_REQUEST['manager']."%'";
	 		if ($_REQUEST['phone'] != "")  $and .= " AND f.phone LIKE '%".$_REQUEST['phone']."%'";
	 		if ($_REQUEST['email'] != "")  $and .= " AND f.email LIKE '%".$_REQUEST['email']."%'";
	 		if ($_REQUEST['description'] != "")  $and .= " AND (f.name LIKE '%".$_REQUEST['description']."%' OR f.description LIKE '%".$_REQUEST['description']."%')"; // Това е за Таговете и за Търсачката 
			if(is_array($_REQUEST['cityName']))$locations = implode(',',$_REQUEST['cityName']);
	 		else $locations = $_REQUEST['cityName'];
			if (($_REQUEST['cityName']!="") && ($_REQUEST['cityName']!="-1")) $and .= " AND f.location_id IN (".implode(',',getSuccessors($locations)).")";
			if ($_REQUEST['fromDate']!="")  $and .= " AND f.registered_on > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
	 		if ($_REQUEST['toDate']!="")  $and .= " AND f.registered_on < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
	 		
		
			
			$orderby = 'f.is_Gold DESC, f.is_Silver DESC';
			if ((isset($_REQUEST['orderby'])) && ($_REQUEST['orderby']!=""))
			{
				switch ($_REQUEST['orderby'])
				{
					case 'registered_on': $orderby .= ', f.registered_on DESC';
					break;
					
					case 'cityName': $orderby .= ', l.name';
					break;
					
					case 'email': $orderby .= ', f.email';
					break;
					
					case 'phone': $orderby .= ', f.phone';
					break;
					
					case 'address': $orderby .= ', f.address';
					break;
														
					case 'firm_name': $orderby .= ', f.name';
					break;
					
					case 'manager': $orderby .= ', f.manager';
					break;
														
					default : $orderby .= ', f.updated_on DESC';
					break;
				}
			}
			else $orderby .= ', f.updated_on DESC';
		
	    



	// ==================== ALL RESULTS =========================
	   	$clauses = array();
		$clauses['where_clause'] = $and;
		$clauses['order_clause'] = ' ORDER BY '.$orderby;
		$clauses['limit_clause'] = '';
		$items_all = FIRMS::getItemsList($clauses);
		$total = count($items_all);
	// ==========================================================	
		
	if(isset($_REQUEST['cityName']) && $total <= 0) // TOVA E ZA BANERA S FLASH KARTATA NA BG (doctors.php->firms.php->index.php)
	{
        $firms_listing .= "<script type='text/javascript'>window.location.href='начална-страница,сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html';</script>";
	}
		
		
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
	$clauses['where_clause'] = $and;
	$clauses['order_clause'] = ' ORDER BY '.$orderby;
	$clauses['limit_clause'] = ' LIMIT '.$limitvalue.' , '.$pp;
	$items = FIRMS::getItemsList($clauses);
	
	$firms_listing .= '<div class="postBig">';
	
	$firms_listing .= require("includes/modules/googleAdsenseMain_468_60.php"); // Pokazva GoogleAdsense 
	$firms_listing .= '<br style="clear:left;"/>';	
	$firms_listing .= '<div class="post">';



	if ((isset($_REQUEST['search_btn'])) or (isset($page)) or isset($_REQUEST['category']))
	{	

		if (!$items) 
		{		
			$firms_listing .= '<div class="date">Няма Заведения/Фирми ';
			if(isset($_REQUEST['firm_category']) or isset($_REQUEST['category'])) {
				$firms_listing .= ' от категория '.get_firm_category($_REQUEST['firm_category']?$_REQUEST['firm_category']:$_REQUEST['category']);
			}
			if(isset($_REQUEST['cityName'])) {
				$firms_listing .= ', намиращи се в '.get_location_type_and_nameBylocationID($_REQUEST['cityName']);
			}
			if(isset($_REQUEST['description']) && $_REQUEST['description'] <> "")
			{ 
				$firms_listing .= ", съдържащи в описанието за себе си <font style='color:#0099FF;'>'".$_REQUEST['description']."'</font>";
			} 			
			if(!isset($_REQUEST['description']) && !(isset($_REQUEST['firm_category']) or isset($_REQUEST['category'])))
			{
				$firms_listing .= ", отговарящи на зададените критерии";
			}
			$firms_listing .= '</div>';	
		} 
		else
		{ 
					
			$firms_listing .= '<div class="date">Заведения/Фирми '; 
			if(isset($_REQUEST['firm_category']) or isset($_REQUEST['category'])) {
				$firms_listing .= ' от категория '.get_firm_category($_REQUEST['firm_category']?$_REQUEST['firm_category']:$_REQUEST['category']);
			}
			if(isset($_REQUEST['cityName'])) {
					$firms_listing .= ', намиращи се в '.get_location_type_and_nameBylocationID($_REQUEST['cityName']);
			}
			if(isset($_REQUEST['description']) && $_REQUEST['description'] <> "") { 
				$firms_listing .= ", съдържащи в описанието за себе си <font style='color:#0099FF;'>'".$_REQUEST['description']."'</font>";
			} 
			$firms_listing .= '</div>';
				
				
				
		
			$firms_listing .=  '<div class="paging" style="float:left;  width:300px; margin:10px 180px 10px 180px;  padding:5px 0 5px 0;" align="center">';
			
			if(!empty($_REQUEST['description']) && (!empty($_REQUEST['firm_category']) OR !empty($_REQUEST['category']))){
				$firms_listing .= per_page("фирми-етикет-категория-".$_REQUEST['description'].",%page,".($_REQUEST['firm_category']?$_REQUEST['firm_category']:$_REQUEST['category']).($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['description'])){
				$firms_listing .= per_page("фирми-етикет-".$_REQUEST['description'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['firm_category']) OR !empty($_REQUEST['category'])){
				$firms_listing .= per_page("фирми-категория-".($_REQUEST['firm_category']?$_REQUEST['firm_category']:$_REQUEST['category']).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html", "2", $numofpages, $page);
			}
			else{
				$firms_listing .= per_page("фирми-".($_REQUEST['cityName'] > 0 ? 'cityName='.$_REQUEST['cityName']:'').",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html", "2", $numofpages, $page);
			}
			$firms_listing .= '<div align="center" style="margin-top:10px;">';
		 	$firms_listing .= '	по
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
			foreach ($items as $firmID => $firmInfo)
			{
				$randFirmCat = rand( 0 , (count($firmInfo['Cats'])-1) );
				
				//$firmLogo = "image.php?i=pics/firms/".$firmInfo['firmID']."_logo.jpg&fh=&fv=&ed=&gr=&rw=160&rh=&sk=&sh=1&ct=&cf=1942.ttf&cs&cn=&r=5";
				$firmLogo = "pics/firms/".$firmInfo['firmID']."_logo.jpg";
				
				list($width, $height, $type, $attr) = getimagesize($firmLogo);
				$pic_width_or_height = 100;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
				if (($height) && ($width))	
				{
					if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
					else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
				}   
					
				$firms_listing .= '	<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';
				$firms_listing .= '<table><tr><td>		
	 					<div style="float:left;"><div style=" border:double; border-color:#666666; margin-left:0px;margin-right:10px;  vertical-align:middle; display:table-cell; width:100px; height:100px; overflow:hidden; " ><a href="разгледай-фирма-'.$firmInfo['firmID'].','.$page.','.myTruncateToCyrilic($firmInfo['name'],200,'_','') .'.html" onmouseover="slideBody('.$i.');"><img width="'.($newwidth?$newwidth:100).'" src="';
					if(is_file('pics/firms/'.$firmInfo['firmID'].'_logo.jpg')) 
					{
					 	$firms_listing .= $firmLogo; 
					}
					else $firms_listing .= "pics/firms/no_logo.png";
					$firms_listing .= '"/></a></div></div>
			    	</td><td>			
						<h4 style="color:#FF8400"><a href="разгледай-фирма-'.$firmInfo['firmID'].','.$page.','.myTruncateToCyrilic($firmInfo['name'],200,'_','') .'.html" onmouseover="slideBody('.$i.');">'.$firmInfo['name'].'</a></h4>
						<div class="detailsDiv" style="float:left; width:530px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
							<div style=" float:left; margin-left:6px; width:150px; color:#FFF; font-weight:bold;" ><h3 align="left"><a style="font-size:14px; color:#FFF; font-weight:bold;" href="разгледай-дестинация-'.$firmInfo['location_id'].','.$page.','.myTruncateToCyrilic(locationTracker($firmInfo['location_id']),100,"_","").'_описание_на_градове_села_курорти_дестинации_от_цял_свят.html" onmouseover="slideBody('.$i.');">'.get_location_type_and_nameBylocationID($firmInfo['location_id']).'</a></h3></div>
							<div style=" float:right; margin-right:5px; font-weight:bold; color:#FFFFFF;" ><h3 align="left"><a style="font-size:14px; color:#FFFFFF; font-weight:bold;" href="фирми-категория-'.$firmInfo['Cats'][$randFirmCat]['firm_category_id'] .','.$page.','.myTruncateToCyrilic($firmInfo['Cats'][$randFirmCat]['firm_category_name'],200,'_','') .'.html" onmouseover="slideBody('.$i.');">'.$firmInfo['Cats'][$randFirmCat]['firm_category_name'] .'</a></h3></div>								
							<div style="float:left; margin-right:2px; " >									
								<fb:like href="http://www.gozbite.com/разгледай-фирма-'.$firmInfo['firmID'].','.myTruncateToCyrilic(strip_tags($firmInfo['name']),200,'_','') .'.html" layout="button_count"	show_faces="false" width="50" height="30" action="like" colorscheme="light"></fb:like>																
							</div>';
								
							 if(($firmInfo['firmID'] == $_SESSION['userID'] && $_SESSION['user_type'] == 'firm') or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1) 
							 {	
								$firms_listing .= '<div style="float:right; margin-right:5px;" ><a href="редактирай-фирма-'.$firmInfo['firmID'].','.myTruncateToCyrilic($firmInfo['name'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a>';
								if($firmInfo['gold'] == '1')
								{
									$firms_listing .= '<img style="margin-left:5px;" src="images/star.gif" width="14" height="14">';
								} 
								elseif($firmInfo['silver'] == '1') 
								{ 
									$firms_listing .= '<img style="margin-left:5px;" src="images/star_grey.gif" width="14" height="14">';
								}
								$firms_listing .= '</div>';

							 } 
							 else
							 { 	
							 	$firms_listing .= '<div style="float:right; margin-right:5px;" >';
							 	if($firmInfo['gold'] == '1') 
							 	{ 
							 		$firms_listing .= '<img style="margin-left:5px;" src="images/star.gif" width="14" height="14">';
							 	} 
							 	elseif($firmInfo['silver'] == '1') 
							 	{ 
							 		$firms_listing .= '<img style="margin-left:5px;" src="images/star_grey.gif" width="14" height="14">';
							 	} 
							 	$firms_listing .= '</div>';
							 } 
							
							 if(($_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) 
							 {	
								$firms_listing .= '<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}"  href="изтрий-фирма-'.$firmInfo['firmID'].','.$page.','.myTruncateToCyrilic($firmInfo['name'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
							 }	
								
							$firms_listing .= '<br style="clear:both;"/>	
						</div>
							
						</td></tr></table>';
											 
						
						
					
					$firms_listing .= '<div class="textBody" id="textBody_'.$i.'" style="display:none; clear:left;">';	
					$firms_listing .= '<table>';
					$firms_listing .= "<tr><td style='color:#666666; font-weight:bold; width:110px;'>Адрес </td><td style='color:#666666; font-weight:bold;'> &rarr;</td><td> ".$firmInfo['address']."</td></tr>"; 
					$firms_listing .= "<tr><td style='color:#666666; font-weight:bold; width:110px;'>Телефон </td><td style='color:#666666; font-weight:bold;'> &rarr;</td> <td>".$firmInfo['phone']."</td></tr>"; 
					$firms_listing .= "<tr><td style='color:#666666; font-weight:bold; width:110px;'>Е-мейл </td><td style='color:#666666; font-weight:bold;'> &rarr;</td><td> ".$firmInfo['email']."</td></tr>"; 
					$firms_listing .= "<tr><td style='color:#666666; font-weight:bold; width:110px;'>Управител </td><td style='color:#666666; font-weight:bold;'> &rarr;</td><td> ".$firmInfo['manager']."</td></tr>"; 
					$firms_listing .= '</table>							
									<div align="right"><a href="разгледай-фирма-'.$firmInfo['firmID'].','.$page.','.myTruncateToCyrilic($firmInfo['name'],200,'_','') .'.html"><u>Виж профила</u></a></div>
						</div>
							       
	       		</div>  ';  
					$firms_listing .= '<br style="clear:both;"/>';	
				$i++;
	   
		 		} 
			}


		

		$firms_listing .=  "<div class='paging' style='float:left;  width:300px; margin:10px 30px 20px 100px; padding:5px 0 5px 0;' align='center'>";
		if(!empty($_REQUEST['description']) && (!empty($_REQUEST['firm_category']) OR !empty($_REQUEST['category']))){
			$firms_listing .= per_page("фирми-етикет-категория-".$_REQUEST['description'].",%page,".($_REQUEST['firm_category']?$_REQUEST['firm_category']:$_REQUEST['category']).($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['description'])){
			$firms_listing .= per_page("фирми-етикет-".$_REQUEST['description'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['firm_category']) OR !empty($_REQUEST['category'])){
			$firms_listing .= per_page("фирми-категория-".($_REQUEST['firm_category']?$_REQUEST['firm_category']:$_REQUEST['category']).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html", "2", $numofpages, $page);
		}
		else{
			$firms_listing .= per_page("фирми-".($_REQUEST['cityName'] > 0 ? 'cityName='.$_REQUEST['cityName']:'').",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html", "2", $numofpages, $page);
		}
		$firms_listing .= '	</div> ';
				
	 }
	}
		$firms_listing .= '</div>
		</div>	';
	
	$firms_listing .= '<br style="clear:both;"/>';	
	
	

	return $firms_listing;
  

?>
