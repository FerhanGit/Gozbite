<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/
	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	$aphorisms_listing = "";

	
	$and="";
	if ($_REQUEST['aphorism_body'] != "")  $and .= " AND (a.title LIKE '%".$_REQUEST['aphorism_body']."%' OR a.body LIKE '%".$_REQUEST['aphorism_body']."%')"; // Това е за Таговете и за Търсачката 
	if ($_REQUEST['aphorism_autor']!="")  $and .= " AND a.autor LIKE '%".$_REQUEST['aphorism_autor']."%'"; 
	if ($_REQUEST['aphorism_autor_type']!="")  $and .= " AND a.autor_type LIKE '%".$_REQUEST['aphorism_autor_type']."%'"; 
	if ($_REQUEST['fromDate']!="")  $and .= " AND a.date > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
	if ($_REQUEST['toDate']!="")  $and .= " AND a.date < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
		

	
	
	if ((isset($_REQUEST['orderby'])) && ($_REQUEST['orderby']!=""))
	{
		switch ($_REQUEST['orderby'])
		{
			
			
			case 'date': $orderby = 'a.date DESC';
			break;
								
			case 'aphorism_title': $orderby = 'a.title';
			break;
			
			case 'aphorism_body': $orderby = 'a.body';
			break;
			
			case 'aphorism_autor': $orderby = 'a.autor';
			break;				
												
			default : $orderby = 'a.date DESC';
			break;
		}
	}
	else $orderby= 'RAND()'; //$orderby= 'a.date DESC';

	    



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
	

	$aphorisms_listing .= '<div class="postBig">';
	$aphorisms_listing .= require("includes/modules/googleAdsenseMain_468_60.php"); // Pokazva GoogleAdsense 
	$aphorisms_listing .= '<br style="clear:left;"/>';	
	$aphorisms_listing .= '<div class="post">';


		       

	if ((isset($_REQUEST['search_btn'])) or (isset($page)) or isset($_REQUEST['aphorism_autor'])or sizeof($_REQUEST['aphorism_body']) > 0)
	{	

		if (!$items) 
		{		
			$aphorisms_listing .= '<div class="date">Няма Афоризми ';
			if(isset($_REQUEST['aphorism_body']) && $_REQUEST['aphorism_body'] <> "")
			{ 
				$aphorisms_listing .= ", съдържащи в себе си <font style='color:#0099FF;'>'".$_REQUEST['aphorism_body']."'</font>";
			} 
			if(isset($_REQUEST['aphorism_autor_type']) && $_REQUEST['aphorism_autor_type'] == 'firm' && isset($_REQUEST['aphorism_autor'])) {
				$aphorisms_listing .= ' от заведение/фирма '.get_firm_nameByFirmID($_REQUEST['aphorism_autor']);
			}  
			elseif(isset($_REQUEST['aphorism_autor_type']) && $_REQUEST['aphorism_autor_type'] == 'user' && isset($_REQUEST['aphorism_autor'])) {
				$aphorisms_listing .= ' от потребител '.get_user_nameByUserID($_REQUEST['aphorism_autor']);
			} 
			elseif(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '' && isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
				$aphorisms_listing .= ', публикувани след '.$_REQUEST['fromDate'].' и преди '.$_REQUEST['toDate'];
			} 
			elseif(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '') {
				$aphorisms_listing .= ', публикувани след '.$_REQUEST['fromDate'];
			} 
			else {
				$aphorisms_listing .= ", отговарящи на зададените критерии";
			}
			$aphorisms_listing .= '</div>';	
		} 
		else
		{ 
			
			$aphorisms_listing .= '<div class="date">Афоризми '; 		
			if(isset($_REQUEST['aphorism_body']) && $_REQUEST['aphorism_body'] <> "") { 
				$aphorisms_listing .= ", съдържащи в себе си <font style='color:#0099FF;'>'".$_REQUEST['aphorism_body']."'</font>";
			} 
			if(isset($_REQUEST['aphorism_autor_type']) && $_REQUEST['aphorism_autor_type'] == 'firm' && isset($_REQUEST['aphorism_autor'])) {
				$aphorisms_listing .= ' от заведение/фирма '.get_firm_nameByFirmID($_REQUEST['aphorism_autor']);
			}   
			elseif(isset($_REQUEST['aphorism_autor_type']) && $_REQUEST['aphorism_autor_type'] == 'user' && isset($_REQUEST['aphorism_autor'])) {
				$aphorisms_listing .= ' от потребител '.get_user_nameByUserID($_REQUEST['aphorism_autor']);
			} 
			elseif(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '' && isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
				$aphorisms_listing .= ', публикувани след '.$_REQUEST['fromDate'].' и преди '.$_REQUEST['toDate'];
			} 
			elseif(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '') {
				$aphorisms_listing .= ', публикувани след '.$_REQUEST['fromDate'];
			} 
			$aphorisms_listing .= '</div>';	
			
			
			$aphorisms_listing .=  '<div class="paging" style="float:left;  width:300px; margin:10px 180px 10px 180px;  padding:5px 0 5px 0;" align="center">';
			//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
			if(!empty($_REQUEST['aphorism_body']) OR (!empty($_REQUEST['fromDate']) OR !empty($_REQUEST['toDate']))){
				$aphorisms_listing .= per_page("афоризми-архив-етикет-".$_REQUEST['aphorism_body'].",".$_REQUEST['fromDate'].",".$_REQUEST['toDate'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",интересни_забавни_поучителни_афоризми.html", "2", $numofpages, $page);
			}
			else{
				$aphorisms_listing .= per_page("афоризми-".((isset($_REQUEST['aphorism_autor_type']) && $_REQUEST['aphorism_autor_type'] == 'firm' && isset($_REQUEST['aphorism_autor'])) ? 'aphorism_autor_type=firm&aphorism_autor='.$_REQUEST['aphorism_autor'] : ((isset($_REQUEST['aphorism_autor_type']) && $_REQUEST['aphorism_autor_type'] == 'user' && isset($_REQUEST['aphorism_autor'])) ? 'aphorism_autor_type=user&aphorism_autor='.$_REQUEST['aphorism_autor'] : '') ).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",интересни_забавни_поучителни_афоризми.html", "2", $numofpages, $page);
			}
			$aphorisms_listing .= '<div align="center" style="margin-top:10px;">';
		 	$aphorisms_listing .= '	по
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
			
			foreach ($items as $aphorismID => $aphorismInfo)
			{
				
				$picFile =  "image.php?i=pics/aphorisms/".$aphorismInfo['picURL']."&fh=&fv=&ed=&gr=&rw=140&rh=&sk=&sh=1&ct=&cf=1942.ttf&cs&cn=&r=5";
		
							
				$aphorisms_listing .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
					<table><tr><td>
					<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; width:80px; overflow:hidden;" ><a href="прочети-афоризъм-'.$aphorismInfo['aphorismID'].','.myTruncateToCyrilic($aphorismInfo['body'],100,'_','') .'.html" >
					<img  width="80" src="';
						if(is_file('pics/aphorisms/'.$aphorismInfo['picURL'])) {
							$aphorisms_listing .= $picFile;
						} 
						else {
							$aphorisms_listing .= "pics/aphorisms/no_photo_thumb.png";
						}
				$aphorisms_listing .= '"  /></a></div>';
					$aphorisms_listing .= '</td><td>	
						<h4 style="color:#FF8400; font-weight:normal; background:transparent;"> <a href="прочети-афоризъм-'.$aphorismInfo['aphorismID'].','.myTruncateToCyrilic($aphorismInfo['body'],100,'_','') .'.html">'.str_replace($_REQUEST['[aphorism_body'],"<font color='red'><b>".$_REQUEST['aphorism_body']."</b></font>",myTruncate(strip_tags($aphorismInfo['body']), 300, " ")).'</a> </h4>
						<div class="detailsDiv" style="float:left; width:550px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#39C6EE;">
								<div style=" float:left; margin-left:6px; width:200px;color:#FFF;  font-size:12px; font-weight:bold;" >
								
								<div style="float:left; margin-right:2px; " >
									
									<fb:like href="http://www.GoZBiTe.Com/прочети-афоризъм-'.$aphorismInfo['aphorismID'].','.myTruncateToCyrilic(strip_tags($aphorismInfo['body']),100,'_','') .'.html" layout="button_count"	show_faces="false" width="50" height="30" action="like" colorscheme="light"></fb:like>
								
								</div>
								
								</div>';
								if($aphorismInfo['title'] == 'GoZbiTe.Com'){ 
									$aphorisms_listing .= '<div style=" float:right;  margin-right:5px; font-weight:bold; color:#FFFFFF; background:transparent;" ><h3><a style="font-size:14px; color:#FFF; font-weight:bold;" target="_blank" href="http://gozbite.com">'.$aphorismInfo['title'].'</a></h3></div>';								
								}
								else { 
									$aphorisms_listing .= '<div style=" float:right;  margin-right:5px; font-weight:bold; color:#FFFFFF; background:transparent;" >'.$aphorismInfo['title'] .'</div>';
								} 
								
								if((($aphorismInfo['autor'] == $_SESSION['userID'] && $_SESSION['user_type']==$aphorismInfo['autor_type']) or $_SESSION['user_kind'] == 2 or $_SESSION['userID']==1)) {	
									$aphorisms_listing .= '<div style="float:right; margin-right:5px;" ><a href="редактирай-афоризъм-'.$aphorismInfo['aphorismID'].','.myTruncateToCyrilic($aphorismInfo['body'],100,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_edit.png" width="14" height="14"></a></div>';
								}
								if((($_SESSION['user_kind'] == 2) or $_SESSION['userID']==1)) {	
									$aphorisms_listing .= '<div style="float:right; margin-right:5px;" ><a  onclick="if(!confirm(\'Сигурни ли сте?\')){return false;}"  href="изтрий-афоризъм-'.$aphorismInfo['aphorismID'].','.myTruncateToCyrilic($aphorismInfo['body'],100,'_','') .'.html"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></div>';
								}
									
								$aphorisms_listing .='<br style="clear:both;"/>	
						</div>
						</td></tr></table>
	       				
	       				
	       		</div> ';   
	   
	       		
	       		
	   
		 		} 
			}


		

		$aphorisms_listing .=  "<div class='paging' style='float:left;  width:300px; margin:10px 30px 20px 100px; padding:5px 0 5px 0;' align='center'>";
		if(!empty($_REQUEST['aphorism_body']) OR (!empty($_REQUEST['fromDate']) OR !empty($_REQUEST['toDate']))){
				$aphorisms_listing .= per_page("афоризми-архив-етикет-".$_REQUEST['aphorism_body'].",".$_REQUEST['fromDate'].",".$_REQUEST['toDate'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",интересни_забавни_поучителни_афоризми.html", "2", $numofpages, $page);
		}
		else{
			$aphorisms_listing .= per_page("афоризми-".((isset($_REQUEST['aphorism_autor_type']) && $_REQUEST['aphorism_autor_type'] == 'firm' && isset($_REQUEST['aphorism_autor'])) ? 'aphorism_autor_type=firm&aphorism_autor='.$_REQUEST['aphorism_autor'] : ((isset($_REQUEST['aphorism_autor_type']) && $_REQUEST['aphorism_autor_type'] == 'user' && isset($_REQUEST['aphorism_autor'])) ? 'aphorism_autor_type=user&aphorism_autor='.$_REQUEST['aphorism_autor'] : '') ).",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",интересни_забавни_поучителни_афоризми.html", "2", $numofpages, $page);
		}
		$aphorisms_listing .= '	</div> ';
				
	 }
	}
		$aphorisms_listing .= '</div>
		</div>	';
	

	$aphorisms_listing .= "<script type='text/javascript'>
	jQuery(document).ready(function($) {	   
	getFastSearchAphorisms(document.getElementById('aphorism_body').value, document.getElementById('fromDate').value, document.getElementById('toDate').value);
	}
	);
	</script>";

   

	return $aphorisms_listing;
  

?>
