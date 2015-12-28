<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/
	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	$posts_listing = "";

	 


	if(empty($_REQUEST['post_category'])) $_REQUEST['post_category'] = $_REQUEST['category'];
	$_REQUEST['post_category'] = $_REQUEST['post_sub_category']?$_REQUEST['post_sub_category']:$_REQUEST['post_category'];


	$and="";
	if ($_REQUEST['post_body'] != "")  $and .= " AND (p.title LIKE '%".$_REQUEST['post_body']."%' OR p.body LIKE '%".$_REQUEST['post_body']."%')"; // Това е за Таговете и за Търсачката 
	if ($_REQUEST['post_category']!="")  $and .= " AND (p.post_category='".$_REQUEST['post_category']."' OR p.post_category IN (SELECT id FROM post_category WHERE parentID = '".$_REQUEST['post_category']."') )";
	if ($_REQUEST['post_source']!="")  $and .= " AND p.source LIKE '%".$_REQUEST['post_source']."%'"; 
	if ($_REQUEST['post_autor']!="")  $and .= " AND p.autor = '".$_REQUEST['post_autor']."'"; 
	if ($_REQUEST['fromDate']!="")  $and .= " AND p.date > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
	if ($_REQUEST['toDate']!="")  $and .= " AND p.date < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
	
			
	
	
	if ((isset($_REQUEST['orderby'])) && ($_REQUEST['orderby']!=""))
	{
		switch ($_REQUEST['orderby'])
		{
			
			
			case 'date': $orderby = 'p.date DESC';
			break;
			
			case 'post_category': $orderby = 'pc.name';
			break;
			
			case 'post_title': $orderby = 'p.title';
			break;
			
			case 'post_body': $orderby = 'p.body';
			break;
																	
			default : $orderby = 'p.date DESC';
			break;
		}
	}
	else $orderby= 'p.date DESC';

	    



// ==================== ALL RESULTS =========================
   	$clauses = array();
	$clauses['where_clause'] = $and;
	$clauses['order_clause'] = ' ORDER BY '.$orderby;
	$clauses['limit_clause'] = '';
	$items_all = $this->getItemsList($clauses);
	$total = count($items_all);
//----------------- paging ----------------------



	//$pp = "3"; 


		$pp = $_REQUEST['limit']!=""?$_REQUEST['limit']:10; 


	
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
	


	$posts_listing .= '<div class="postBig">';
	$posts_listing .= require("includes/modules/googleAdsenseMain_468_60.php"); // Pokazva GoogleAdsense 
	$posts_listing .= '<br style="clear:left;"/>';	
	$posts_listing .= '<div class="post">';



	if($items && $_REQUEST['search']<>1)
	{
		$posts_listing .= '<div class="date">Статии '; 
		if(isset($_REQUEST['post_category']) or isset($_REQUEST['category'])) {
			$posts_listing .= ' от категория '.get_post_category($_REQUEST['post_category']?$_REQUEST['post_category']:$_REQUEST['category']);
		}
		if(isset($_REQUEST['post_body']) && $_REQUEST['post_body'] <> "") { 
			$posts_listing .= ", съдържащи в себе си <font style='color:#6DCA31;'>'".$_REQUEST['post_body']."'</font>";
		} 
		if(isset($_REQUEST['post_autor_type']) && $_REQUEST['post_autor_type'] == 'doctor' && isset($_REQUEST['post_autor'])) {
			$posts_listing .= ' от лекар/терапевт '.get_doctor_nameByDoctorID($_REQUEST['post_autor']);
		}   
		elseif(isset($_REQUEST['post_autor_type']) && $_REQUEST['post_autor_type'] == 'hospital' && isset($_REQUEST['post_autor'])) {
			$posts_listing .= ' от здравно заведение '.get_hospital_nameByHospitalID($_REQUEST['post_autor']);
		}  
		elseif(isset($_REQUEST['post_autor_type']) && $_REQUEST['post_autor_type'] == 'user' && isset($_REQUEST['post_autor'])) {
			$posts_listing .= ' от потребител '.get_user_nameByUserID($_REQUEST['post_autor']);
		} 
		$posts_listing .= '</div>';
			
	}	 

			       

	if ((isset($_REQUEST['search_btn'])) or (isset($page)) or isset($_REQUEST['category']))
	{	

		if (!$items) 
		{		
			$posts_listing .= '<div class="date">Няма Статии ';
			if(isset($_REQUEST['post_category']) or isset($_REQUEST['category'])) {
				$posts_listing .= ' от категория '.get_post_category($_REQUEST['post_category']?$_REQUEST['post_category']:$_REQUEST['category']);
			}
			if(isset($_REQUEST['post_body']) && $_REQUEST['post_body'] <> "")
			{ 
				$posts_listing .= ", съдържащи в себе си <font style='color:#6DCA31;'>'".$_REQUEST['post_body']."'</font>";
			} 
			if(isset($_REQUEST['post_autor_type']) && $_REQUEST['post_autor_type'] == 'doctor' && isset($_REQUEST['post_autor'])) {
				$posts_listing .= ' от лекар/терапевт '.get_doctor_nameByDoctorID($_REQUEST['post_autor']);
			}   
			elseif(isset($_REQUEST['post_autor_type']) && $_REQUEST['post_autor_type'] == 'hospital' && isset($_REQUEST['post_autor'])) {
				$posts_listing .= ' от здравно заведение '.get_hospital_nameByHospitalID($_REQUEST['post_autor']);
			}  
			elseif(isset($_REQUEST['post_autor_type']) && $_REQUEST['post_autor_type'] == 'user' && isset($_REQUEST['post_autor'])) {
				$posts_listing .= ' от потребител '.get_user_nameByUserID($_REQUEST['post_autor']);
			} 
			else {
				$posts_listing .= ", отговарящи на зададените критерии";
			}
			$posts_listing .= '</div>';	
		} 
		else
		{ 
			$posts_listing .=  '<div class="paging" style="float:left;  width:300px; margin:10px 180px 10px 180px;  padding:5px 0 5px 0;" align="center">';
			//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
			if(!empty($_REQUEST['post_body']) && (!empty($_REQUEST['post_category']) OR !empty($_REQUEST['category']))){
				$posts_listing .= per_page("статии-етикет-категория-".$_REQUEST['post_body'].",%page,".($_REQUEST['post_category']?$_REQUEST['post_category']:$_REQUEST['category']).($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",интересни_статии_за_здравето.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['post_body'])){
				$posts_listing .= per_page("статии-етикет-".$_REQUEST['post_body'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",интересни_статии_за_здравето.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['post_category']) OR !empty($_REQUEST['category'])){
				$posts_listing .= per_page("статии-категория-".($_REQUEST['post_category']?$_REQUEST['post_category']:$_REQUEST['category']).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",интересни_статии_за_здравето.html", "2", $numofpages, $page);
			}
			else{
				$posts_listing .= per_page("статии-".((isset($_REQUEST['post_autor_type']) && $_REQUEST['post_autor_type'] == 'doctor' && isset($_REQUEST['post_autor'])) ? 'post_autor_type=doctor&post_autor='.$_REQUEST['post_autor'] : ((isset($_REQUEST['post_autor_type']) && $_REQUEST['post_autor_type'] == 'hospital' && isset($_REQUEST['post_autor'])) ? 'post_autor_type=hospital&post_autor='.$_REQUEST['post_autor'] : ((isset($_REQUEST['post_autor_type']) && $_REQUEST['post_autor_type'] == 'user' && isset($_REQUEST['post_autor'])) ? 'post_autor_type=user&post_autor='.$_REQUEST['post_autor'] : '') ) ).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",интересни_статии_за_здравето.html", "2", $numofpages, $page);
			}
			$posts_listing .= '<div align="center" style="margin-top:10px;">';
		 	$posts_listing .= '	по
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
			foreach ($items as $postID => $postInfo)
			{
				
				$picFile =  "image.php?i=pics/posts/".$postInfo['picURL']."&fh=&fv=&ed=&gr=&rw=140&rh=&sk=&sh=1&ct=&cf=1942.ttf&cs&cn=&r=5";
		
				$posts_listing .= '	<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #6DCA31; padding:5px; background-color:#F1F1F1;">
					<table><tr><td>
						<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; width:80px; overflow:hidden;" ><a href="прочети-статия-'.$postInfo['postID'].','.$page.','.myTruncateToCyrilic($postInfo['title'],50,'_','') .'.html" onmouseover="slideBody('.$i.');"><img  width="80" src="';
						if(is_file('pics/posts/'.$postInfo['picURL'])) {
							$posts_listing .= $picFile;
						} 
						else {
							$posts_listing .= "pics/posts/no_photo_thumb.png";
						}
				$posts_listing .= '"  /></a></div>
					</td><td>
						<h4 style="color:#FF8400"><a href="прочети-статия-'.$postInfo['postID'].','.$page.','.myTruncateToCyrilic($postInfo['title'],50,'_','') .'.html" onmouseover="slideBody('.$i.');">'.$postInfo['title'] .'</a></h4>
						<div class="detailsDiv" style="float:left; width:550px;margin-bottom:20px; border-top:3px solid #6DCA31; padding:5px; background-color:#D7F3CE;">
								<div style=" float:left; margin-left:6px; width:250px;color:#6B9D09;  font-size:12px; font-weight:bold;" >
									<div style="float:left; margin-right:2px; " >									
										<fb:like href="http://www.ohboli.bg/прочети-статия-'.$postInfo['postID'].','.myTruncateToCyrilic(strip_tags($postInfo['title']),100,'_','') .'.html" layout="button_count"	show_faces="false" width="50" height="30" action="like" colorscheme="light"></fb:like>								
									</div>
								</div>
								<div style=" float:right; margin-right:5px; font-weight:bold; color:#6B9D09;" ><h3 align="left"><a style=" font-size:14px; color:#6B9D09;" href="статии-категория-'.$postInfo['category_id'].','.$page.','.myTruncateToCyrilic($postInfo['category_name'],50,'_','') .'.html"  onmouseover="slideBody('.$i.');">'.$postInfo['category_name'].'</a></h3></div>';								
								if($postInfo['has_video'] == 1) {	
									$posts_listing .= '<div style="float:right; margin-right:5px;" ><img style="margin-left:5px;" src="images/video.png" width="14" height="14"></div>';
								}
								if((($postInfo['autor'] == $_SESSION['userID'] && $_SESSION['user_type']==$postInfo['autor_type']) or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) {	
									$posts_listing .= '<div style="float:right; margin-right:5px;" ><a href="редактирай-статия-'.$postInfo['postID'].','.myTruncateToCyrilic($postInfo['title'],50,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>';
								}
								if((($_SESSION['user_kind'] == 2) or $_SESSION['userID']==1)) {	
									$posts_listing .= '<div style="float:right; margin-right:5px;" ><a href="изтрий-статия-'.$postInfo['postID'].','.myTruncateToCyrilic($postInfo['title'],50,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
								}
									
					$posts_listing .= '<br style="clear:both;"/>	
						</div>
					</td></tr></table>';
					
					$posts_listing .= '<div class="textBody" id="textBody_'.$i.'" style="display:none; clear:left;">				
			       			'.str_replace('</div>','',str_replace('<div>','',(str_replace($_REQUEST['[post_body'],"<font color='red'><b>".$_REQUEST['post_body']."</b></font>",myTruncate($postInfo['body'], 500, " "))))).'
							<div align="right"><a href="прочети-статия-'.$postInfo['postID'].','.$page.','.myTruncateToCyrilic($postInfo['title'],50,'_','') .'.html"><u>Прочети цялата</u></a></div>
						</div>
							       
	       		</div>  ';  
					
				$i++;
	   
		 		} 
			}


		

		$posts_listing .=  "<div class='paging' style='float:left;  width:300px; margin:10px 30px 20px 100px; padding:5px 0 5px 0;' align='center'>";
		if(!empty($_REQUEST['post_body']) && (!empty($_REQUEST['post_category']) OR !empty($_REQUEST['category']))){
			$posts_listing .= per_page("статии-етикет-категория-".$_REQUEST['post_body'].",%page,".($_REQUEST['post_category']?$_REQUEST['post_category']:$_REQUEST['category']).($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",интересни_статии_за_здравето.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['post_body'])){
			$posts_listing .= per_page("статии-етикет-".$_REQUEST['post_body'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",интересни_статии_за_здравето.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['post_category']) OR !empty($_REQUEST['category'])){
			$posts_listing .= per_page("статии-категория-".($_REQUEST['post_category']?$_REQUEST['post_category']:$_REQUEST['category']).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",интересни_статии_за_здравето.html", "2", $numofpages, $page);
		}
		else{
			$posts_listing .= per_page("статии-".((isset($_REQUEST['post_autor_type']) && $_REQUEST['post_autor_type'] == 'doctor' && isset($_REQUEST['post_autor'])) ? 'post_autor_type=doctor&post_autor='.$_REQUEST['post_autor'] : ((isset($_REQUEST['post_autor_type']) && $_REQUEST['post_autor_type'] == 'hospital' && isset($_REQUEST['post_autor'])) ? 'post_autor_type=hospital&post_autor='.$_REQUEST['post_autor'] : ((isset($_REQUEST['post_autor_type']) && $_REQUEST['post_autor_type'] == 'user' && isset($_REQUEST['post_autor'])) ? 'post_autor_type=user&post_autor='.$_REQUEST['post_autor'] : '') ) ).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",интересни_статии_за_здравето.html", "2", $numofpages, $page);
		}
		$posts_listing .= '	</div> ';
				
	 }
	}
		$posts_listing .= '</div>
		</div>	';
	

	$posts_listing .= "<script type='text/javascript'>
	Event.observe(window, 'load', function() { 	   
	getFastSearchPosts(document.getElementById('post_category').value, document.getElementById('post_body').value, document.getElementById('fromDate').value, document.getElementById('toDate').value)
	}
	);
	</script>";

   

	return $posts_listing;
  

?>

