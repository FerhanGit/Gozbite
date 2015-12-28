<?php
  
	require_once("../functions.php");
	require_once("../config.inc.php");
	require_once("../bootstrap.inc.php");
   
   	$conn = new mysqldb();
    

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


		$response .='<div class="detailsDiv" style=" margin-bottom:20px; margin-left:10px; border-top:3px solid #6DCA31; padding:5px; background-color:#F1F1F1;">';
        $response .= stripslashes($resultSurveysBig['survey_body']);
        $response .='</div>';
	    $response .='<div  style="margin-top:5px;margin-left:5px; width:290px; overflow:hidden; ">';
		for($sa=0;$sa<$numAnsers;$sa++)
		{ 
			$color = randColor();
			$response .='<div  style="margin-top:5px;float:left;  width:280px; background-color:'.(($sa%2==0)?'#F1F1F1':'#F7F7F7').'" align="left">';
			$response .='<div style="float:left; width:220px;" align="left">'.$resultAnsers[$sa]['anser'].' (<font color="'.$color.'">'.$resultAnsers[$sa]['cnt'].'</font>)</div> <div align="left" style="float:left;background-color:'.$color.';height:20px;width:'.((50*($resultAnsers[$sa]['cnt']/$resultSumAnsers))>0?50*($resultAnsers[$sa]['cnt']/$resultSumAnsers):1).'px" > </div>';
			$response .='</div>';
	    }
			$response .='</div>';
			       		  		
	$response .='<div  style="margin-top:5px;margin-left:5px;font-size:12px; width:260px;" align="left">';
	$response .='Общо гласували: '.$resultSumAnsers;
	$response .='</div>';		       		  		
			       		  		
	
	$response .='<div style="margin:10px;"><a href="анкети-,разгледай_анкети_проучвания.html">Всички анкети</a></div>';
	
	
   print $response;
  ?>
 