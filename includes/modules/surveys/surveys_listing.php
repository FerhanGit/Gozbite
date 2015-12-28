<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/
	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	$surveys_listing = "";

	 

	
// --------------------Край на Survey --------------------------------	
	

	$and = '';		
	
	if ($_REQUEST['fromDate']!="")  $and .= " AND s.start_date > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
	if ($_REQUEST['toDate']!="")  $and .= " AND s.end_date < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i'),"; 
	if ($_REQUEST['search_survey_body']!="")  $and .= " AND s.body LIKE '%".$_REQUEST['search_survey_body']."%'";
	 		 	

	$sql="SELECT s.ID as 'surveyID', s.active as 'active', s.start_date as 'start_date', s.end_date as 'end_date', s.body as 'survey_body' FROM surveys s WHERE 1=1 $and ORDER BY s.start_date DESC";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultTotal=$conn->result;
	$total=$conn->numberrows;
	
			
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
	$sql="SELECT s.ID as 'surveyID', s.active as 'active', s.start_date as 'start_date', s.end_date as 'end_date', s.body as 'survey_body' FROM surveys s WHERE 1=1 $and ORDER BY s.start_date DESC LIMIT $limitvalue,$pp";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultSurveysMain=$conn->result;
	$numSurveysMain=$conn->numberrows;

for($s=0;$s<$numSurveysMain;$s++)
{
	$sql="SELECT sa.ID as 'anserID', sa.survey_ID as 'survey_ID', sa.anser as 'anser', sa.cnt as 'cnt' FROM surveys_ansers sa WHERE sa.anser<> '' AND sa.survey_ID='".$resultSurveysMain[$s]['surveyID']."' ORDER BY sa.ID";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultAnsersMain[$s]=$conn->result;
	$numAnsersMain[$s]=$conn->numberrows;
}




	$surveys_listing .= '<div class="postBig">';
	$surveys_listing .= require("includes/modules/googleAdsenseMain_468_60.php"); // Pokazva GoogleAdsense 
	$surveys_listing .= '<br style="clear:left;"/>';	
	$surveys_listing .= '<div class="post">';


if($numSurveysMain > 0)
{
	$surveys_listing .= ' <div class="date">Анкети </div>';
		
}	 
	       

if ((isset($_REQUEST['search_btn'])) or (isset($page)))
{	
	if ($numSurveysMain == 0) 
	{		
	
		$surveys_listing .= '<div class="date">Няма Анкети </div>';
			
	} 
	// ---- Paging START ------
else{ 
		   

$surveys_listing .= "<div class=\"paging\" style=\" width:300px;margin: 10px 50px 10px 100px;\" align='center'>";
//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
$surveys_listing .= per_page("анкети-survey_body=".$_REQUEST['survey_body']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",анкети_допитвания_по_актуални_теми.html", "2", $numofpages, $page);
	
$surveys_listing .= '</div>';  
	
	for ($i=0;$i<$numSurveysMain;$i++)
	{
	
$surveys_listing .= '<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #6DCA31; padding:5px; background-color:#F1F1F1;">
				    <div class="detailsDiv" style="float:left; width:650px;margin-bottom:20px; border-top:3px solid #6DCA31; padding:5px; background-color:#D7F3CE;">
							<div style=" float:left; margin-left:6px; width:250px;color:#6B9D09;font-weight:bold;" ><i>От '.convert_Month_to_Cyr(date("j F Y",strtotime($resultSurveysMain[$i]['start_date']))) .'</i></div>
							<div style=" float:right; margin-right:5px; font-weight:bold; color:#6B9D09;" ><i>До '.convert_Month_to_Cyr(date("j F Y",strtotime($resultSurveysMain[$i]['end_date'])))  .'</i></div>								
							<br style="clear:both;"/>	
					</div>
					<br style="clear:both;"/>	
						'.stripslashes(str_replace($_REQUEST['survey_body'],"<font color='red'><b>".$_REQUEST['survey_body']."</b></font>",substr($resultSurveysMain[$i]['survey_body'],0,200)))."...".'
		       		 	<div align="right"><a href="разгледай-анкета-'.$resultSurveysMain[$i]['surveyID'].',анкети_допитвания_по_актуални_теми.html">Виж цялата анкета</a></div>
		 		</div> ';  
       			
       			
     
   
	} 


$surveys_listing .= "<div class=\"paging\" style=\"float:left; width:340px;margin:10px 30px 20px 30px; padding:5px 0 5px 0; \" align='center'>";
//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
$surveys_listing .= per_page("анкети-survey_body=".$_REQUEST['survey_body']."&fromDate=".$_REQUEST['fromDate']."&toDate=".$_REQUEST['toDate'].",%page".($_REQUEST['limit']> 0 ? ','.$_REQUEST['limit']:'').",анкети_допитвания_по_актуални_теми.html", "2", $numofpages, $page);
$surveys_listing .= '</div> ';
	
	}
}


	$surveys_listing .= '</div>
	</div>	';
	
   

	return $surveys_listing;
  

?>

