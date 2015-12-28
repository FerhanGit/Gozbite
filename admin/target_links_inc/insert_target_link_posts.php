<?php
	
	
	include("../inc/dblogin.inc.php");
	
?>	



<form name='itemform' action="" method='post' enctype = 'multipart/form-data'>

<div id = "content" style="width:400px">
   <fieldset style="width:400px">
      <legend>&nbsp;Таргетирани връзки&nbsp;</legend>
      <div style = "padding: 15px;">Административен инструмент за автоматизирано управление на таргетирани връзки.<br /><br /></div>
   
 <?php     
printf("    от <input type = \"text\" id = \"fromDate\" name = \"fromDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalFDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете начална дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $fromDate);
printf("    до <input type = \"text\" id = \"toDate\" name = \"toDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalTDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете крайна дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)", $toDate);
 ?>      
		 
 
      <div style = "margin: 10px 10px 10px 10px;">
           Избери новина:  <select name="news_id" id="news_id" style="width:300px;">
	
				<option value ="">избери</option>
               <?php
                 		$sql="SELECT newsID,title FROM news ORDER BY title";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultAllNews=$conn->result;
						$numAllNews=$conn->numberrows;
						for ($i=0;$i<$numAllNews;$i++)
               {?>      
			 	  <option value = "<?=$resultAllNews[$i]['newsID']?>" ><?=$resultAllNews[$i]['title']?></option> 
                             
               <?php } ?>
				  </select>
         </div>
         
          <div style = "vertical-align: bottom; margin: 0px 0px 10px 7px; text-align: left;">
		<label class = "txt12" style = "vertical-align: bottom;">Раздел:</label>&nbsp;&nbsp;
           <select name="post_category" id="post_category">	
				<option value ="">избери</option>
               <?php
                 		$sql="SELECT * FROM post_category";
						$conn->setsql($sql);
						$conn->getTableRows();
						$resultCat=$conn->result;
						$numCat=$conn->numberrows;
						for ($i=0;$i<$numCat;$i++)
               {?>      
			 	  <option value = "<?=$resultCat[$i]['id']?>"><?=$resultCat[$i]['name']?></option> 
                             
               <?php } ?>
				  </select>
				  <br /> <br />
           </div>                   
                 
                    
 			 			
 			
      <?php 
	
		
if ((!isset($_POST['companyID']))&&(!isset($_POST['start_date']))&&(!isset($_POST['end_date'])))
{   
		
	$sql="SELECT DISTINCT(tl.id) as 'id', n.title as 'title', tl.post_category as 'news_category', tl.fromD as 'fromD', tl.toD as 'toD'  FROM target_links_news tl, news n, news_category_list ncl  ORDER BY toD"; 
	$conn->setsql($sql);
    $conn->getTableRows();
    $result=$conn->result;
    $num=$conn->numberrows;
  
    print '<div style="overflow:auto; height:400px;width:420px;"><table border="1"><tr bgcolor="#999999"><td><b>Номер</b></td><td><b>Новина</b></td><td><b>Категории</b></td><td><b>Стартова Дата</b></td><td><b>Крайна Дата</b></td></tr>';
    for ($i=0;$i<$num;$i++)
    {
    
    // -------------------------------- Zaqvkite -----------------------------------------

 		$sql="SELECT id,name FROM news_category WHERE id IN (".$result[$i]['news_category'].")"; 
		$conn->setsql($sql);
   		$conn->getTableRows();
   		$resultCategory=$conn->result; 
   		$numCategory=$conn->numberrows;
   		  		
   		   		   		    	
    // ------------------------------------------------------------------------------------
    	if ($i%2==0)  $bgcolor='#ccff66';
    	else $bgcolor='#ffebd7';
    	?>
    	<tr bgcolor="<?=$bgcolor?>"><td><?php print $i+1;?><a onclick="if(!confirm('Сигурни ли сте?')) {return false;}" href="?delete=<?=$result[$i]['id']?>"><img style="margin-left:5px;" src="images/page_white_delete.png" width="14" height="14"></a></td><td><?=$result[$i]['title']?></td><td>

 <?php
    	for ($p=0;$p<$numCategory;$p++)
    	{	
   			print $resultCategory[$p]['title']."<br />";
    	} 
    	print "</td><td>".$result[$i]['fromD']."</td><td>".$result[$i]['toD']."</td></tr>";
    	
    }
    print '</table></div>';
    print "<br /><input type='submit' name='vavedi' value='Запиши' />";
	
}
?>
      
   </fieldset>
</div>
</form>
