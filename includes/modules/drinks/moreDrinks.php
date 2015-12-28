<?php  

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	$more_drinks = "";
	
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
			
			
	 		$and="";
	 		if ($DrinksByCats != "")  $and .= " AND d.id IN (".$DrinksByCats.")";
	 		if(!empty($_REQUEST['drinkID'])) $and .= " AND d.id != '".$_REQUEST['drinkID']."'";
					

	 	$sql="SELECT d.id as 'id', d.title as 'title', d.registered_on as 'registered_on', d.info as 'info', d.has_pic as 'has_pic', d.is_Silver as 'silver', d.is_Gold as 'gold', d.firm_id as 'firm_id', d.user_id as 'user_id', d.youtube_video as 'youtube_video', d.active as 'active' FROM drinks d WHERE 1=1  $and  ORDER BY RAND() LIMIT 9";
		$conn->setsql($sql);
    	$conn->getTableRows();
    	$resultMore=$conn->result;   
        $numMore=$conn->numberrows;
    	
    	if ($numMore > 0)
	    {	
	    	$more_drinks .= '
	    	<div class="LastComments">
			<div class="titleLastComments" style="margin-bottom:10px"> Още '.$resultCatName.' </div>
	      	<div class="contentBoxLastComments">
      		
	    	<table style="margin:5px;">
	    	<tr>';
	    
	    	for ($i = 0,$cntr = 1; $i < $numMore; $i++,$cntr++)
	    	{
			
					$sql="SELECT dc.id as 'drink_category_id', dc.name as 'drink_category_name' FROM drinks d, drink_category dc, drinks_category_list dcl WHERE dcl.drink_id = d.id AND dcl.category_id = dc.id AND d.id = '".$resultMore[$i]['id']."' ";
					$conn->setsql($sql);
					$conn->getTableRows();
					$numDrinksCats[$i]  	= $conn->numberrows;
					$resultDrinksCats[$i]  = $conn->result;
				
			  $more_drinks .= '					
    			<td valign="top">	
					<td valign="top"><a href="разгледай-напитка-'.$resultMore[$i]['id'].','.myTruncateToCyrilic($resultMore[$i]['title'],200,'_','') .'.html"><div id="drinkMoreImgDiv_'.$resultMore[$i]['id'].'" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';" style="border:1px solid #CCCCCC; width:60px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="50"  src="'.((is_file("pics/drinks/".$resultMore[$i]['id']."_1_thumb.jpg"))?"pics/drinks/".$resultMore[$i]['id']."_1_thumb.jpg":"pics/drinks/no_photo_thumb.png").'" /></div></a>
					</td>
					<td width="130"  valign="top">
					<div class="detailsDiv" style="width:130px;cursor:pointer; margin-bottom:5px; border-top:3px solid #0099FF; padding:3px; background-color:#F1F1F1;">
					<a class="read_more_link" href="разгледай-напитка-'.$resultMore[$i]['id'].','.myTruncateToCyrilic($resultMore[$i]['title'],50,'_','') .'.html"  style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" onMouseover="document.getElementById(\'drinkMoreImgDiv_'.$resultMore[$i]['id'].'\').style.borderColor=\'#0099FF\';" onMouseout="document.getElementById(\'drinkMoreImgDiv_'.$resultMore[$i]['id'].'\').style.borderColor=\'#CCCCCC\';">
				
				    	'.$resultMore[$i]['title'].'<br />
				    	
			    		</a></div></td>   				
	    		</td> ';
	    	
		    	if($cntr % 3 == 0 && $cntr <> $numMore)
		    	{
		    		$more_drinks .= "</tr><tr>";
		    	}
	    	}
	    	
	    	$more_drinks .= '
	    	</tr>
	    	</table>

		</div>
		</div>';
	    	
    	}
    	
    	
return $more_drinks;    	

?>
   