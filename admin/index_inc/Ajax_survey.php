<?php
  
   require_once("../inc/dblogin.inc.php");
   

 $response ='';
  
if(isset($_REQUEST['anser_ID']))
{
	$sql="UPDATE surveys_ansers SET cnt = (cnt+1) WHERE ID = '".$_REQUEST['anser_ID']."'";
	$conn->setsql($sql);
	$conn->updateDB();

	
	
	$sql="SELECT s.ID as 'surveyID', s.body as 'survey_body', s.start_date as 'start_date', s.end_date as 'end_date', s.active as 'active' FROM surveys s WHERE ID=(SELECT survey_ID FROM surveys_ansers WHERE ID='".$_REQUEST['anser_ID']."') ORDER BY ID";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultSurveysBig=$conn->result;	
	
	
	$sql="SELECT DISTINCT(ID) as 'anserID', survey_ID as 'survey_ID', cnt as 'cnt', anser as 'anser' FROM surveys_ansers WHERE survey_ID='".$resultSurveysBig['surveyID']."' ORDER BY ID";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultAnsers=$conn->result;	
	$numAnsers=$conn->numberrows;	
	
	$sql="SELECT SUM(cnt) as 'All_cnts' FROM surveys_ansers WHERE survey_ID='".$resultSurveysBig['surveyID']."' GROUP BY survey_ID";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultSumAnsers=$conn->result['All_cnts'];
}


function randColor()
{
$letters = "1234567890ABCDEF";
for($i=0;$i<6;$i++)
{
$pos = rand(0,15);
$str .= $letters[$pos];
}
return "#".$str;
}

$response .='<div style="margin:10px;">Благодарим Ви!</div>';

		$response .='<div style="margin-top:5px;margin-left:5px; width:140px; overflow:hidden; ">';
        $response .= stripslashes($resultSurveysBig['survey_body']);
        $response .='</div>';
	    $response .='<div  style="margin-top:5px;margin-left:5px; width:140px; overflow:hidden; ">';
		for($sa=0;$sa<$numAnsers;$sa++)
		{ 
			$response .='<div  style="margin-top:5px; width:140px;" align="left">';
			$response .='<div  style="float:left; width:90px; " align="left">'.($sa+1).' - '.$resultAnsers[$sa]['anser'].' ('.$resultAnsers[$sa]['cnt'].')</div> <div align="left" style="float:left;background-color:'.randColor().';height:10px;width:'.((50*($resultAnsers[$sa]['cnt']/$resultSumAnsers))>0?50*($resultAnsers[$sa]['cnt']/$resultSumAnsers):1).'px" > </div>';
			$response .='</div>';
	    }
			$response .='</div>';
			       		  		
	$response .='<div  style="margin-top:5px;margin-left:5px;font-size:12px; width:130px;" align="left">';
	$response .='Общо гласували: '.$resultSumAnsers;
	$response .='</div>';		       		  		
			       		  		
	
	$response .='<div style="margin:10px;"><a href="surveys.php">Всички анкети</a></div>';
	
	
   print $response;
  ?>
 