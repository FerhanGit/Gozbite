<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/
	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	$bolesti_listing = "";


			if(empty($_REQUEST['bolest_category'])) $_REQUEST['bolest_category'] = $_REQUEST['category'];
			$_REQUEST['bolest_category'] = $_REQUEST['bolest_sub_category']?$_REQUEST['bolest_sub_category']:$_REQUEST['bolest_category'];
		 	

			if ($_REQUEST['bolest_category']!="")  
			{
				$sql="SELECT bcl.bolest_id as 'bolest_id' FROM bolesti b, bolest_category bc, bolesti_category_list bcl WHERE bcl.bolest_id = b.bolestID AND bcl.category_id = bc.id AND (bcl.category_id = '".$_REQUEST['bolest_category']."' OR bcl.category_id IN (SELECT id FROM bolest_category WHERE parentID='".$_REQUEST['bolest_category']."') )";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numBolestiByCats    = $conn->numberrows;
				$resultBolestiByCats = $conn->result;
				for($n=0;$n<$numBolestiByCats;$n++)
				{
					$bolestiByCatsArr[]=$resultBolestiByCats[$n]['bolest_id'];
				}
				if(is_array($bolestiByCatsArr))
				$bolestiByCats = implode(',',$bolestiByCatsArr);
				else $bolestiByCats = -1;
			}
			
		
			
			
			
			if (is_array($_REQUEST['bolest_simptom']) && count($_REQUEST['bolest_simptom'])>0 ) 
			{
				$sql="SELECT bsl.bolest_id as 'bolest_id' FROM bolesti b, bolest_simptoms bs, bolesti_simptoms_list bsl WHERE bsl.bolest_id = b.bolestID AND bsl.simptom_id = bs.id AND bsl.simptom_id IN (".implode(',',$_REQUEST['bolest_simptom']).")";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numBolestiBySimptoms    = $conn->numberrows;
				$resultBolestiBySimptoms = $conn->result;
				for($n=0;$n<$numBolestiBySimptoms;$n++)
				{
					$bolestiBySimptomsArr[]=$resultBolestiBySimptoms[$n]['bolest_id'];
				}
				if(is_array($bolestiBySimptomsArr))
				$bolestiBySimptoms = implode(',',$bolestiBySimptomsArr);
				else $bolestiBySimptoms = -1;
			}
			elseif (!is_array($_REQUEST['bolest_simptom']) && $_REQUEST['bolest_simptom']<>'') 
			{
				$sql="SELECT bsl.bolest_id as 'bolest_id' FROM bolesti b, bolest_simptoms bs, bolesti_simptoms_list bsl WHERE bsl.bolest_id = b.bolestID AND bsl.simptom_id = bs.id AND bsl.simptom_id IN (".$_REQUEST['bolest_simptom'].")";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numBolestiBySimptoms    = $conn->numberrows;
				$resultBolestiBySimptoms = $conn->result;
				for($n=0;$n<$numBolestiBySimptoms;$n++)
				{
					$bolestiBySimptomsArr[]=$resultBolestiBySimptoms[$n]['bolest_id'];
				}
				if(is_array($bolestiBySimptomsArr))
				$bolestiBySimptoms = implode(',',$bolestiBySimptomsArr);
				else $bolestiBySimptoms = -1;
			}
			
			
			
			
			
			
	 		 $and="";
	 		if ($bolestiByCats!="")  $and .= " AND b.bolestID IN (".$bolestiByCats.")";
	 		if ($bolestiBySimptoms!="")  $and .= " AND b.bolestID IN (".$bolestiBySimptoms.")"; 		
	 		
	 		if ($_REQUEST['bolest_body'] != "")  $and .= " AND (b.title LIKE '%".$_REQUEST['bolest_body']."%' OR b.body LIKE '%".$_REQUEST['bolest_body']."%')"; // Това е за Таговете и за Търсачката 
	 		if ($_REQUEST['autor_type']!="")  $and .= " AND b.autor_type LIKE '%".$_REQUEST['autor_type']."%'"; 
	 		if ($_REQUEST['autor']!="")  $and .= " AND b.autor = '".$_REQUEST['autor']."'"; 
	 		if ($_REQUEST['bolest_source']!="")  $and .= " AND b.source LIKE '%".$_REQUEST['bolest_source']."%'"; 
	 		if ($_REQUEST['bolest_autor']!="")  $and .= " AND b.autor LIKE '%".$_REQUEST['bolest_autor']."%'"; 	 		
	 		if ($_REQUEST['fromDate']!="")  $and .= " AND b.date > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
	 		if ($_REQUEST['toDate']!="")  $and .= " AND b.date < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
	 		
	 					
			
			if ((isset($_REQUEST['orderby'])) && ($_REQUEST['orderby']!=""))
			{
				switch ($_REQUEST['orderby'])
				{
					
					
					case 'date': $orderby = 'b.date DESC';
					break;
										
					case 'autor_type': $orderby = 'b.autor_type';
					break;
					
					case 'autor': $orderby = 'b.autor';
					break;
					
					case 'bolest_source': $orderby = 'b.source';
					break;
					
					case 'bolest_title': $orderby = 'b.title';
					break;
					
					case 'bolest_body': $orderby = 'b.body';
					break;
					
					case 'bolest_autor': $orderby = 'b.autor';
					break;
							
														
					default : $orderby = 'b.date DESC';
					break;
				}
			}
			else $orderby= 'b.date DESC';
			
			

	// ==================== ALL RESULTS =========================
	   	$clauses = array();
		$clauses['where_clause'] = $and;
		$clauses['order_clause'] = ' ORDER BY '.$orderby;
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
	$clauses['order_clause'] = ' ORDER BY '.$orderby;
	$clauses['limit_clause'] = ' LIMIT '.$limitvalue.' , '.$pp;
	$items = $this->getItemsList($clauses);
	


	$bolesti_listing .= '<div class="postBig">';
	$bolesti_listing .= require("includes/modules/googleAdsenseMain_468_60.php"); // Pokazva GoogleAdsense 
	$bolesti_listing .= '<br style="clear:left;"/>';	
	$bolesti_listing .= '<div class="post">';


	       

	if ((isset($_REQUEST['search_btn'])) or (isset($page)) or isset($_REQUEST['category']))
	{	

		if (!$items) 
		{		
			$bolesti_listing .= '<div class="date">Няма Заболявания ';
			if(isset($_REQUEST['bolest_category']) or isset($_REQUEST['category'])) {
				$bolesti_listing .= ' от категория <font style=\'color:#0099FF;\'>'.get_bolest_category($_REQUEST['bolest_category']?$_REQUEST['bolest_category']:$_REQUEST['category'])."</font>";
			}
			if(isset($_REQUEST['bolest_simptom'])) {
				$bolesti_listing .= ' със симптом/и <font style=\'color:#0099FF;\'>'.get_bolest_simptom($_REQUEST['bolest_simptom'])."</font>";
			}
			if(isset($_REQUEST['bolest_body']) && $_REQUEST['bolest_body'] <> "")
			{ 
				$bolesti_listing .= ", съдържащи в себе си <font style='color:#0099FF;'>".$_REQUEST['bolest_body']."</font>";
			} 
			if(isset($_REQUEST['bolest_autor_type']) && $_REQUEST['bolest_autor_type'] == 'user' && isset($_REQUEST['bolest_autor'])) {
				$bolesti_listing .= ' от потребител <font style=\'color:#0099FF;\'>'.get_user_nameByUserID($_REQUEST['bolest_autor'])."</font>";
			} 
			else {
				$bolesti_listing .= ", отговарящи на зададените критерии";
			}
			$bolesti_listing .= '</div>';	
		} 
		else
		{ 
				
			$bolesti_listing .= '<div class="date">Заболявания '; 
			if(isset($_REQUEST['bolest_category']) or isset($_REQUEST['category'])) {
				$bolesti_listing .= ' от категория '.get_bolest_category($_REQUEST['bolest_category']?$_REQUEST['bolest_category']:$_REQUEST['category']);
			}
			if(isset($_REQUEST['bolest_simptom'])) {
				$bolesti_listing .= ' със симптом/и '.get_bolest_simptom($_REQUEST['bolest_simptom']);
			}
			if(isset($_REQUEST['bolest_body']) && $_REQUEST['bolest_body'] <> "") { 
				$bolesti_listing .= ", съдържащи в себе си <font style='color:#0099FF;'>".$_REQUEST['bolest_body']."</font>";
			} 
			elseif(isset($_REQUEST['bolest_autor_type']) && $_REQUEST['bolest_autor_type'] == 'user' && isset($_REQUEST['bolest_autor'])) {
				$bolesti_listing .= ' от потребител '.get_user_nameByUserID($_REQUEST['bolest_autor']);
			} 
			elseif(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '' && isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
				$bolesti_listing .= ', публикувани след '.$_REQUEST['fromDate'].' и преди '.$_REQUEST['toDate'];
			} 
			elseif(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '') {
				$bolesti_listing .= ', публикувани след '.$_REQUEST['fromDate'];
			} 
			elseif(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
				$bolesti_listing .= ', публикувани преди '.$_REQUEST['toDate'];
			} 
			$bolesti_listing .= '</div>';
		
		
			$bolesti_listing .=  '<div class="paging" style="float:left;  width:300px; margin:10px 180px 10px 180px;  padding:5px 0 5px 0;" align="center">';
			//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
			if(!empty($_REQUEST['bolest_body']) && (!empty($_REQUEST['bolest_category']) OR !empty($_REQUEST['category']))){
				$bolesti_listing .= per_page("болести-етикет-категория-".$_REQUEST['bolest_body'].",%page,".($_REQUEST['bolest_category']?$_REQUEST['bolest_category']:$_REQUEST['category']).($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",симптоми_лечение_и_описания_на_заболявания.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['bolest_simptom'])){
				per_page("болести-bolest_simptom=".$_REQUEST['bolest_simptom'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",симптоми_лечение_и_описания_на_заболявания.html", "2");
			}
			elseif(!empty($_REQUEST['bolest_body'])){
				$bolesti_listing .= per_page("болести-етикет-".$_REQUEST['bolest_body'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",симптоми_лечение_и_описания_на_заболявания.html", "2", $numofpages, $page);
			}
			elseif(!empty($_REQUEST['bolest_category']) OR !empty($_REQUEST['category'])){
				$bolesti_listing .= per_page("болести-категория-".($_REQUEST['bolest_category']?$_REQUEST['bolest_category']:$_REQUEST['category']).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",симптоми_лечение_и_описания_на_заболявания.html", "2", $numofpages, $page);
			}
			else{
				$bolesti_listing .= per_page("болести-".((isset($_REQUEST['bolest_autor_type']) && $_REQUEST['bolest_autor_type'] == 'user' && isset($_REQUEST['bolest_autor'])) ? 'bolest_autor_type=user&bolest_autor='.$_REQUEST['bolest_autor'] : '').",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",симптоми_лечение_и_описания_на_заболявания.html", "2", $numofpages, $page);
			}
			$bolesti_listing .= '<div align="center" style="margin-top:10px;">';
		 	$bolesti_listing .= '	по
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
			foreach ($items as $bolestID => $bolestInfo)
			{
				$randBolestCat = rand( 0 , (count($bolestInfo['Cats'])-1) );
					
				//$picFile =  "image.php?i=pics/bolesti/".$bolestInfo['resultPics']['url_thumb'][0]."&fh=&fv=&ed=&gr=&rw=140&rh=&sk=&sh=1&ct=&cf=1942.ttf&cs&cn=&r=5";
                $picFile =  "pics/bolesti/".$bolestInfo['resultPics']['url_thumb'][0];
		
				$bolesti_listing .= '	<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
					<table><tr><td>
						<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; width:80px; overflow:hidden;" ><a href="разгледай-болест-'.$bolestInfo['bolestID'].','.$page.','.myTruncateToCyrilic($bolestInfo['title'],200,'_','') .'.html" onmouseover="slideBody('.$i.');"><img  width="80" src="';
						if(is_file('pics/bolesti/'.$bolestInfo['resultPics']['url_thumb'][0])) {
							$bolesti_listing .= $picFile;
						} 
						else {
							$bolesti_listing .= "pics/bolesti/no_photo_thumb.png";
						}
				$bolesti_listing .= '"  /></a></div>
					</td><td>
						<h4 style="color:#FF8400"><a href="разгледай-болест-'.$bolestInfo['bolestID'].','.$page.','.myTruncateToCyrilic($bolestInfo['title'],200,'_','') .'.html" onmouseover="slideBody('.$i.');">'.$bolestInfo['title'] .'</a></h4>
						<div class="detailsDiv" style="float:left; width:550px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
								<div style=" float:left; margin-left:6px; width:250px;color:#FFFFFF;  font-size:12px; font-weight:bold;" >
									<div style="float:left; margin-right:2px; " >									
										<fb:like href="http://www.gozbite.com/разгледай-описание-болест-'.$bolestInfo['bolestID'].','.myTruncateToCyrilic(strip_tags($bolestInfo['title']),200,'_','') .'.html" layout="button_count"	show_faces="false" width="50" height="30" action="like" colorscheme="light"></fb:like>								
									</div>
								</div>
								<div style=" float:right; margin-right:5px; font-weight:bold; color:#FFFFFF;" ><h3 align="left"><a style=" font-size:14px; font-weight:bold;color:#FFFFFF;" href="болести-категория-'.$bolestInfo['Cats'][$randBolestCat]['bolest_category_id'].','.$page.','.myTruncateToCyrilic($bolestInfo['Cats'][$randBolestCat]['bolest_category_name'],200,'_','') .'.html"  onmouseover="slideBody('.$i.');">'.$bolestInfo['Cats'][$randBolestCat]['bolest_category_name'].'</a></h3></div>';								
								if($bolestInfo['has_video'] == 1) {	
									$bolesti_listing .= '<div style="float:right; margin-right:5px;" ><img style="margin-left:5px;" src="images/video.png" width="14" height="14"></div>';
								}
								if((($bolestInfo['autor'] == $_SESSION['userID'] && $_SESSION['user_type']==$bolestInfo['autor_type']) or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) {	
									$bolesti_listing .= '<div style="float:right; margin-right:5px;" ><a href="редактирай-описание-болест-'.$bolestInfo['bolestID'].','.myTruncateToCyrilic($bolestInfo['title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>';
								}
								if((($_SESSION['user_kind'] == 2) or $_SESSION['userID']==1)) {	
									$bolesti_listing .= '<div style="float:right; margin-right:5px;" ><a  onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}"  href="изтрий-болест-'.$bolestInfo['bolestID'].','.myTruncateToCyrilic($bolestInfo['title'],200,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
								}
									
					$bolesti_listing .= '<br style="clear:both;"/>	
						</div>
					</td></tr></table>';
							
					$bolesti_listing .= '<div class="textBody" id="textBody_'.$i.'" style="display:none; clear:left;">';		
							$bolesti_listing .= '<table>';		       				
						
								
								if (count($bolestInfo['Cats']) > 0) 
								{
									$bolesti_listing .= " <tr> <td style='color:#666666; font-weight:bold; width:110px;'>Категории</td> <td style='color:#666666; font-weight:bold;'> &rarr;</td> <td>"; 
								
									foreach ($bolestInfo['Cats'] as $resultBolestiCat)
									{
										$bolesti_listing .= '<a class="read_more_link" style="font-size:14px;" href="болести-bolest_category='.$resultBolestiCat['bolest_category_id'].',болести_категория_'.myTruncateToCyrilic($resultBolestiCat['bolest_category_name'],200,'_','').'.html" >';
										$bolesti_listing .= $resultBolestiCat['bolest_category_name']."</a>; "; 
										
									}
									$bolesti_listing .= "</td></tr>";
								}
								
								
								if (count($bolestInfo['Simptoms']) > 0) 
								{
									$bolesti_listing .= " <tr> <td style='color:#666666; font-weight:bold; width:77px;'>Симптоми</td> <td style='color:#666666; font-weight:bold;'> &rarr;</td> <td>"; 
								
									foreach ($bolestInfo['Simptoms'] as $resultBolestiSimptom)
									{
										$bolesti_listing .= '<a class="read_more_link" style="font-size:14px;" href="болести-bolest_simptom='.$resultBolestiSimptom['bolest_simptom_id'].',характерен_симптом_'.myTruncateToCyrilic($resultBolestiSimptom['bolest_simptom_name'],200,'_','').'.html" >';
										$bolesti_listing .= $resultBolestiSimptom['bolest_simptom_name']."</a>; "; 
										
									}
									$bolesti_listing .= "</td></tr>";
								}
								
								
								$bolesti_listing .= "</table>";
								$bolesti_listing .= "<span style='color: #666666; font-weight:bold;'>&nbsp;Подробности &rarr;</span> ";
							
			       			$bolesti_listing .= str_replace('</div>','',str_replace('<div>','',(str_replace($_REQUEST['[bolest_body'],"<font color='red'><b>".$_REQUEST['bolest_body']."</b></font>",strip_tags(myTruncate($bolestInfo['body'], 500, " ")))))).'
							<div align="right"><a href="разгледай-болест-'.$bolestInfo['bolestID'].','.$page.','.myTruncateToCyrilic($bolestInfo['title'],200,'_','') .'.html"><u>Прочети цялата</u></a></div>
						</div>
							       
	       		</div>  ';  
					
				$i++;
	   
		 		} 
			}


		

		$bolesti_listing .=  "<div class='paging' style='float:left;  width:300px; margin:10px 30px 20px 100px; padding:5px 0 5px 0;' align='center'>";
		if(!empty($_REQUEST['bolest_body']) && (!empty($_REQUEST['bolest_category']) OR !empty($_REQUEST['category']))){
			$bolesti_listing .= per_page("болести-етикет-категория-".$_REQUEST['bolest_body'].",%page,".($_REQUEST['bolest_category']?$_REQUEST['bolest_category']:$_REQUEST['category']).($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",симптоми_лечение_и_описания_на_заболявания.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['bolest_simptom'])){
			per_page("болести-bolest_simptom=".$_REQUEST['bolest_simptom'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",симптоми_лечение_и_описания_на_заболявания.html", "2");
		}
		elseif(!empty($_REQUEST['bolest_body'])){
			$bolesti_listing .= per_page("болести-етикет-".$_REQUEST['bolest_body'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",симптоми_лечение_и_описания_на_заболявания.html", "2", $numofpages, $page);
		}
		elseif(!empty($_REQUEST['bolest_category']) OR !empty($_REQUEST['category'])){
			$bolesti_listing .= per_page("болести-категория-".($_REQUEST['bolest_category']?$_REQUEST['bolest_category']:$_REQUEST['category']).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",симптоми_лечение_и_описания_на_заболявания.html", "2", $numofpages, $page);
		}
		else{
			$bolesti_listing .= per_page("болести-".((isset($_REQUEST['bolest_autor_type']) && $_REQUEST['bolest_autor_type'] == 'user' && isset($_REQUEST['bolest_autor'])) ? 'bolest_autor_type=user&bolest_autor='.$_REQUEST['bolest_autor'] : '').",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",симптоми_лечение_и_описания_на_заболявания.html", "2", $numofpages, $page);
		}
		$bolesti_listing .= '	</div> ';
				
	 }
	}
		$bolesti_listing .= '</div>
		</div>	';
	

	$bolesti_listing .= '<br style="clear:left;"/>';	
	
	

	return $bolesti_listing;
  

?>
