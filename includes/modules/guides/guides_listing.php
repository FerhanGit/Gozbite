<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/
	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	$guides_listing = "";

	 


			if ($_REQUEST['tag']!="")  
			{
				$sql="SELECT gt.guideID as 'guideID' FROM guides g, guide_tags gt WHERE gt.guideID = g.id AND LOWER(gt.tags) LIKE LOWER('%".trim($_REQUEST['tag'])."%')";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numGuidesByTags    = $conn->numberrows;
				$resultGuidesByTags = $conn->result;
				for($n=0;$n<$numGuidesByTags;$n++)
				{
					$GuidesByTagsArr[]=$resultGuidesByTags[$n]['guideID'];
				}
				if(is_array($GuidesByTagsArr))
				$GuidesByTags = implode(',',$GuidesByTagsArr);
				else $GuidesByTags = '-1';
			}
			
			
						
	 		$and="";
	 		if ($_REQUEST['firmID'] != "")  $and .= " AND g.firm_id = '".$_REQUEST['firmID']."'";
	 		if ($_REQUEST['userID'] != "")  $and .= " AND g.user_id = '".$_REQUEST['userID']."'";
	 		if ($_REQUEST['title'] != "")  $and .= " AND (g.title LIKE '%".$_REQUEST['title']."%' OR g.info LIKE '%".$_REQUEST['title']."%')";
	 		if ($_REQUEST['letter'] != "")  $and .= " AND LOWER(g.title) LIKE LOWER('".$_REQUEST['letter']."%')";
	 		if ($GuidesByTags!="")  $and .= " AND g.id IN (".$GuidesByTags.")";
	 		
	 	
			
			
	 		
	 		
			$orderby = "";
			$orderby = 'g.active DESC, g.is_Gold DESC, g.is_Silver DESC';
			
			if ((isset($_REQUEST['orderby'])) && ($_REQUEST['orderby']!=""))
			{
				switch ($_REQUEST['orderby'])
				{
					case 'updated_on': $orderby .= ', g.updated_on DESC';
					break;
					
						case 'title': $orderby .= ', g.title';
					break;
																		
					default : $orderby .= ', g.updated_on DESC';
					break;
				}
			}
			else $orderby .= ', g.updated_on DESC';
			
	    



// ==================== ALL RESULTS =========================
   	$clauses = array();
	$clauses['where_clause'] = $and;
	$clauses['order_clause'] = ' ORDER BY '.$orderby;
	$clauses['limit_clause'] = '';
	$items_all = $this->getItemsList($clauses);
	$total = count($items_all);
//----------------- paging ----------------------
//$guides_listing .= print_r($this,1);


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
	$items = $this->getItemsList($clauses);
	


	$guides_listing .= '<div class="postBig">';
	$guides_listing .= require("includes/modules/googleAdsenseMain_468_60.php"); // Pokazva GoogleAdsense 
	$guides_listing .= '<br style="clear:left;"/>';	
	$guides_listing .= '<div class="post">';


		       

	if ((isset($_REQUEST['search_btn'])) or (isset($page)))
	{	

		if (!$items) 
		{		
			$guides_listing .= '<div class="date">Няма Справочни Описания, отговарящи на зададените критерии -  ';
			if(isset($_REQUEST['letter']) && sizeof($_REQUEST['letter']) == 1) {
				$guides_listing .= ', започващи с буквата <font color="#FF9900">'.$_REQUEST['letter'].'</font>';
			}
			if(isset($_REQUEST['tag']) && sizeof($_REQUEST['tag']) > 0)
			{ 
				$guides_listing .= ", съдържащи в себе си <font style='color:#0099FF;'>'".$_REQUEST['tag']."'</font>";
			} 
			
			if(isset($_REQUEST['firmID']) && $_REQUEST['firmID'] != '') {
				$guides_listing .= ' от заведение/фирма '.get_guide_firm_name_BY_firmID($_REQUEST['firmID']);
			}  
			elseif(isset($_REQUEST['userID']) && $_REQUEST['userID'] != '') {
				$guides_listing .= ' от потребител '.get_guide_user_name_BY_userID($_REQUEST['userID']);
			} 
			
		
			$guides_listing .= '</div>';	
		} 
		else
		{ 
			$guides_listing .= '<div class="date">Справочни Описания '; 
			if(isset($_REQUEST['letter']) && sizeof($_REQUEST['letter']) == 1) {
				$guides_listing .= ', започващи с буквата <font color="#FF9900">'.$_REQUEST['letter'].'</font>';
			}
			if(isset($_REQUEST['tag']) && sizeof($_REQUEST['tag']) > 0)
			{ 
				$guides_listing .= ", съдържащи в себе си <font style='color:#0099FF;'>'".$_REQUEST['tag']."'</font>";
			} 
			
			if(isset($_REQUEST['firmID']) && $_REQUEST['firmID'] != '') {
				$guides_listing .= ' от заведение/фирма '.get_guide_firm_name_BY_firmID($_REQUEST['firmID']);
			}  
			elseif(isset($_REQUEST['userID']) && $_REQUEST['userID'] != '') {
				$guides_listing .= ' от потребител '.get_guide_user_name_BY_userID($_REQUEST['userID']);
			} 
			$guides_listing .= '</div>';
			
			
			$guides_listing .=  '<div class="paging" style="float:left;  width:300px; margin:10px 180px 10px 180px;  padding:5px 0 5px 0;" align="center">';
			//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
			if(!empty($_REQUEST['tag'])){
				$guides_listing .= per_page("справочник-етикет-".$_REQUEST['tag'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['letter'])){
				$guides_listing .= per_page("справочник-буква-".$_REQUEST['letter'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html", "2", $numofpages, $page);
			}
			else{
				$guides_listing .= per_page("справочник-".($_REQUEST['firmID'] ? 'firmID='.$_REQUEST['firmID'] : ($_REQUEST['userID'] ? 'userID='.$_REQUEST['userID'] : '') ).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html", "2", $numofpages, $page);
			}
			$guides_listing .= '<div align="center" style="margin-top:10px;">';
		 	$guides_listing .= '	по
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
			foreach ($items as $guideID => $guideInfo)
			{
				//$picFile =  "image.php?i=pics/guides/".$guideInfo['resultPics']['url_thumb'][0]."&fh=&fv=&ed=&gr=&rw=140&rh=&sk=&sh=1&ct=&cf=1942.ttf&cs&cn=&r=5";
                $picFile =  "pics/guides/".$guideInfo['resultPics']['url_thumb'][0];
		
				$guides_listing .= '
								<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; padding-left:0px; background-color:#F1F1F1;">
									<table><tr><td>	
					 					<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; width:80px; overflow:hidden; " ><a href="разгледай-справочник-'.$guideInfo['guideID'].','.$page.','.myTruncateToCyrilic($guideInfo['title'],200,'_','') .'.html"  onmouseover="slideBody('.$i.');"><img width="80" src="';
										if(is_file('pics/guides/'.$guideInfo['resultPics']['url_thumb'][0])) {
											$guides_listing .= $picFile;
										} 
										else {
											$guides_listing .= "pics/guides/no_photo_thumb.png";
										}
										
						$guides_listing .= '"/></a></div>
							    	</td><td>		
					 					<h4 style="float:left;color:#FF8400;width:540px;">';
								 		if($guideInfo['active'] != 1) 
										{ 
											$guides_listing .= '<span style="color:#FF0000;" title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Неактивно Описание!] body=[&rarr; Описанието е деактивирано от страна на неговия автор или от администратора на портала.]\'> | Неактивно! </span>';
										}
							$guides_listing .= '
											<div style="float:left;margin-left:0px; width:350px; color:#0099FF; font-weight:bold;" ><a href="разгледай-справочник-'.$guideInfo['guideID'].','.$page.','.myTruncateToCyrilic($guideInfo['title'],200,'_','') .'.html" >'.$guideInfo['title'] .'</a></div>
										</h4>
										<div class="detailsDiv" style="float:left; width:550px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
												<div style="float:left; margin-right:2px; " >									
													<fb:like href="http://www.gozbite.com/разгледай-справочник-'.$guideInfo['guideID'].','.myTruncateToCyrilic(strip_tags($guideInfo['title']),100,'_','') .'.html" layout="button_count"	show_faces="false" width="50" height="30" action="like" colorscheme="light"></fb:like>								
												</div>';
												
												 
											if(($guideInfo['firm_id'] == $_SESSION['userID'] && $_SESSION['user_type'] == 'firm') OR ($guideInfo['user_id'] == $_SESSION['userID'] && $_SESSION['user_type'] == 'user') or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1) 
											{
												$guides_listing .= '<div style="float:right; margin-right:5px;" ><a href="редактирай-справочник-'.$guideInfo['guideID'].','.myTruncateToCyrilic($guideInfo['title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a>';
												if($guideInfo['gold'] == '1')
												{
													$guides_listing .= '<img style="margin-left:5px;" src="images/star_gold.gif">';
												} 
												elseif($guideInfo['silver'] == '1') 
												{
													$guides_listing .= '<img style="margin-left:5px;" src="images/star_grey.gif">';
												}
												$guides_listing .= '</div>';


										    } 
											else 
											{
													$guides_listing .= '<div style="float:right; margin-right:5px;" >';
													if($guideInfo['gold'] == '1') 
													{
														$guides_listing .= '<img style="margin-left:5px;" src="images/star_gold.gif">';
													} 
													elseif($guideInfo['silver'] == '1') 
													{ 
														$guides_listing .= '<img style="margin-left:5px;" src="images/star_grey.gif">';
													}
													$guides_listing .= '</div>';
											}
											if(($_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) 
											{	
												$guides_listing .= '<div style="float:right; margin-right:5px;" ><a onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}" href="изтрий-справочник-'.$guideInfo['guideID'].','.myTruncateToCyrilic($guideInfo['title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
											}	
										$guides_listing .= '		
											<br style="clear:both;"/>	
										</div>
											
									</td></tr></table>
								   	
					</div>';
					
					$i++;
	   
		 		} 
			}


		

		$guides_listing .=  "<div class='paging' style='float:left;  width:300px; margin:10px 30px 20px 100px; padding:5px 0 5px 0;' align='center'>";
		if(!empty($_REQUEST['tag'])){
				$guides_listing .= per_page("справочник-етикет-".$_REQUEST['tag'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['letter'])){
				$guides_listing .= per_page("справочник-буква-".$_REQUEST['letter'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html", "2", $numofpages, $page);
			}
			else{
				$guides_listing .= per_page("справочник-".($_REQUEST['firmID'] ? 'firmID='.$_REQUEST['firmID'] : ($_REQUEST['userID'] ? 'userID='.$_REQUEST['userID'] : '') ).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html", "2", $numofpages, $page);
			}
			$guides_listing .= '	</div> ';
				
	 }
	}
		$guides_listing .= '</div>
		</div>	';
	
	$guides_listing .= '<br style="clear:left;"/>';	

   

	return $guides_listing;
  

?>

