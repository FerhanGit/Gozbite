<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$survey_big = "";
   	
	$surveyID = $_REQUEST['surveyID'];

	if (isset($surveyID))
	{
		
		$sql="SELECT s.ID as 'surveyID', s.body as 'survey_body', s.start_date as 'start_date', s.end_date as 'end_date', s.active as 'active' FROM surveys s WHERE ID='".$surveyID."'";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultSurveysBig=$conn->result;	
		
		
		$sql="SELECT DISTINCT(ID) as 'anserID', survey_ID as 'survey_ID', cnt as 'cnt', anser as 'anser' FROM surveys_ansers WHERE survey_ID='".$surveyID."' ORDER BY ID";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultAnsers=$conn->result;	
		$numAnsers=$conn->numberrows;	
		
		$sql="SELECT SUM(cnt) as 'All_cnts' FROM surveys_ansers WHERE survey_ID='".$surveyID."' GROUP BY survey_ID";
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


//$survey_big .=print_r($aphorismBig,1);
		
$survey_big .= '
<div class="detailsDiv" style="float:left; width:660px;margin-bottom:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">

<div class="postBig">

<div style="float:left; margin-bottom:20px;" id="next_previousDIV"></div>';


$survey_big .= '<table><tr><td align="left" valign="top">';

 		if(count($resultSurveysBig)>0)
	    {
	    	  
	    	$survey_big .= '<div style="float:left; margin-left:0px; width:340px;">
		 			<div style="float:left; margin-left:0px; padding:0px; width:340px; font-size:12px;" align="justify">
            		  <table>
            		  	<tr>
            				<td width="5px" bgcolor="#E7E7E7">&nbsp;&nbsp;</td>
            				<td style="padding:5px;">
            			 		<div style="background-image:url(images/fon_header_ravno_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:320px; background-repeat:no-repeat; font-size:10px; color:#000000;">
            						<div style="float:left; margin-left:2px; width:150px;"><div style="float:left; color:#FFFFFF; "><i>От '.convert_Month_to_Cyr(date("j F Y",strtotime($resultSurveysBig['start_date']))) .'</i></div></div>
            						<div style="float:right; color:#000000; margin-right:2px;"><i>До '.convert_Month_to_Cyr(date("j F Y",strtotime($resultSurveysBig['end_date']))) .'</i></div>
            					</div>
            			  		<div id="commentDiv" style="margin-top:5px; width:300px; overflow:hidden; ">
                   		       		'.stripslashes($resultSurveysBig['survey_body']).'
            					</div>
	            				<div  style="margin-top:5px; width:330px; overflow:hidden; ">';
						       	
						       			for($sa=0;$sa<$numAnsers;$sa++)
						       			{
						       				$color = randColor();
						       		
						       			$survey_big .= '<div  style="margin-top:5px; width:310px;" align="left">	
						       				<div  style="float:left; width:240px; " align="left">	'.(($sa+1).' - '.$resultAnsers[$sa]['anser'].' (<font color = "'.$color.'">'.$resultAnsers[$sa]['cnt'].' гласа / '.round((100*$resultAnsers[$sa]['cnt']/$resultSumAnsers), 0).'%</font>)').'</div> <div align="left" style="float:left;background-color:'.$color.';height:10px;width:'.((100*($resultAnsers[$sa]['cnt']/$resultSumAnsers))>0?100*($resultAnsers[$sa]['cnt']/$resultSumAnsers):1).'px" > </div>
						       			</div>
						       			
									<br style="clear:left;"/>';
						       		}
						       	
	$survey_big .= '  		</div>
            		  </tr>
            		</table>
		 		 </div>		   
	    	  </div>';
	    	
                
	    	}    	   	
	    
	    	
	$survey_big .= '			
				<div  style="margin-top:5px;font-size:12px; width:240px;" align="left">	
				Общо гласували: '.$resultSumAnsers.'
				</div> 
				  

	
	 </td>
	 <td width="20">&nbsp;</td>
	 <td align="right" valign="top">';
$survey_big .= require("includes/modules/googleAdsense_300x250px.php"); // Pokazva GoogleAdsense   
$survey_big .= '</td></tr></table>

</div>
<br style="clear:left;"/></div>';


return $survey_big;

?>