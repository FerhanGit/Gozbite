<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$shopping_preview_adv = "";
   	
$shopping_preview_adv .='<div style="width:660px;">
<input type="hidden" name="buy_package" id="buy_package" value="" />
<input type="hidden" name="package_name" id="package_name" value=""/>
<input type="hidden" name="price" id="price" value="" />
<input type="hidden" name="credits" id="credits" value="" />
<input type="hidden" name="time" id="time" value="" />

   <fieldset style = "width: 650px;">
      <legend style="color:#3399CC;">&nbsp;ПАКЕТИ от УСЛУГИ&nbsp;</legend>
     
          <br /> '; 

		// ne pozvolqvame da se izpolzva vsqkakvi krediti, a samo ot bolesti, lekarstva, statii i novini
 		
		$totalCredits = ($_SESSION['cnt_bolest'] + $_SESSION['cnt_post'] + $_SESSION['cnt_news'] + $_SESSION['cnt_lekarstvo'] - $_SESSION['used_credits']);

 		$sql = "SELECT * FROM purchased_packages WHERE company_id='".(($_SESSION['user_type']=='hospital')?trim($_SESSION['userID']):0)."' AND doctor_id='".(($_SESSION['user_type']=='doctor')?trim($_SESSION['userID']):0)."' AND (NOW() BETWEEN start_date AND end_date)";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultOldPackages = $conn->result;
		$numOldPackages=$conn->numberrows;
			

	if(!empty($_REQUEST['buy_package']))
	{
		$shopping_preview_adv .= '<div align="center" style="width:650px;float:left;height:25px;margin:10px 10px 10px 10px;padding:5px;background-color:#3399CC;font-weight:900;color:#FFFFFF"">Благодарим Ви за успешната покупка!</div>';		
	}

               $sql = "SELECT DISTINCT(name) FROM packages";
			   $conn->setsql($sql);
			   $conn->getTableRows();
			   $resultOffersLimit=$conn->result;
			   $numOffersLimit = $conn->numberrows;
			  
             if($numOffersLimit > 0) 
             {
                 
				 $row=1;
				 $shopping_preview_adv .= "<div style=\"width:300px;\">";
				
                for ($i=0;$i<$numOffersLimit;$i++) 
                {
                 					   
$shopping_preview_adv .= '		
 <div style="width:650px;float:left; ">
     <div style="float:left;width:200px;margin:2px 2px 2px 2px;padding:5px;background-color:#3399CC;font-weight:900;"><a style="color:#FFF; text-decoration:underline;" href=javascript:void(0); onclick="new Effect.toggle($(\'package_details'.$i.'\'),\'Appear\');">'.$resultOffersLimit[$i]['name'].'</a></div>
    <br style="clear:both;" />         
	<div id="package_details'.$i.'" style="margin:0px 0px 30px 0px; padding:0px; float:left; ">
	<fieldset>
	<legend>Информация за пакет '.$resultOffersLimit[$i]['name'].'</legend>';          
	      
	          				
	        $sql = "SELECT * FROM packages WHERE name='".$resultOffersLimit[$i]['name']."'";
			$conn->setsql($sql);
			$conn->getTableRows();
			$resultPackages = $conn->result;
			$numPackages = $conn->numberrows;
			      
	      if($numPackages>0) 
	      {
	        	$shopping_preview_adv .= "<table style=\"float:left\"><tr align='center' style='padding:10px;font-weight:900;color:#FFFFFF;' bgcolor='#3399CC'><td>За брой месеци</td><td>Обща цена</td><td>Цена в кредити</td><td>Спестявате</td><td>Купи</td><td>С кредити</td><td></td></tr>";
				$row=1;
				
		      for ($p=0;$p<$numPackages;$p++)
		      {
		        if($row == 1)
				{$bgcolor = '#F9FBFF'; $row = 2; }
			 	else {$bgcolor = 'lightblue';  $row=1;}

			 	$shopping_preview_adv .= sprintf("<tr align='center' style='padding:10px;' bgcolor='%s'><td style='padding:5px;'>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href=\"javascript:void(0);\" ><img src=\"images/buy_package_btn.png\" /></a></td><td><a href=\"javascript:void(0);\" ><img src=\"images/buy_package_with_credits_btn.png\" /></a></td><td> <a href=\"javascript:void(0);\" id=\"creditsHelp_$i$p\" style=\"z-index:1000;\"><img src=\"images/help.png\" /></a></td></tr>",$bgcolor, $resultPackages[$p]['months'], $resultPackages[$p]['total_price'].'лв.', $resultPackages[$p]['credit_cost'].' кредита', (($resultPackages[$p]['concession']>0)?($resultPackages[$p]['concession'].'лв.'):'-'));
				        
		       }
	                
	              $shopping_preview_adv .= "</table>";
	            
   	  		       
	$shopping_preview_adv .= '
	  <div style="width:650px;float:left; margin: 0px 0px 0px 0px;">
	    	<div style="width:480px; float:left; margin: 10px 0px 0px 0px;">	
				<div align="center" style="width:480px;height:25px;margin:2px 0px 2px 2px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">VIP клиент (визуализира се на първа страница)</div>
				<div align="center" style="width:480px;height:25px;margin:2px 0px 2px 2px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">Видео представяне (видео, разказващо за Вас)</div>
				<div align="center" style="width:480px;height:25px;margin:2px 0px 2px 2px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">Сребърен клиент (при търсене излиза след златните)</div>
				<div align="center" style="width:480px;height:25px;margin:2px 0px 2px 2px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">Златен клиент (при търсене излиза най-отгоре)</div>
				<div align="center" style="width:480px;height:25px;margin:2px 0px 2px 2px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">Избран клиент (излиза в секция "НА ФОКУС")</div>
				<div align="center" style="width:480px;height:25px;margin:2px 0px 2px 2px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">PR материал/Статия (кратка рекламна статия)</div>
			</div>
			<div style="width:150px; float:left; margin: 10px 0px 0px 0px;">	
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 0px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">'.(($resultPackages[0]['is_VIP']==1?'<img src="images/green_tick_btn.png" />':'<img src="images/red_x_btn.png" />')).'</div>
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 0px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">'.(($resultPackages[0]['has_video']==1?'<img src="images/green_tick_btn.png" />':'<img src="images/red_x_btn.png" />')).'</div>
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 0px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">'.(($resultPackages[0]['is_Silver']==1?'<img src="images/green_tick_btn.png" />':'<img src="images/red_x_btn.png" />')).'</div>
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 0px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">'.(($resultPackages[0]['is_Gold']==1?'<img src="images/green_tick_btn.png" />':'<img src="images/red_x_btn.png" />')).'</div>				
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 0px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">'.(($resultPackages[0]['is_Featured']==1?'<img src="images/green_tick_btn.png" />':'<img src="images/red_x_btn.png" />')).'</div>
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 0px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">'.(($resultPackages[0]['pr_Stuff']==1?'<img src="images/green_tick_btn.png" />':'<img src="images/red_x_btn.png" />')).'</div>				
			</div>	
	</div>';	
	    		
	
	              	
	     }
	    
	     
	  $shopping_preview_adv .= '
	     </fieldset>
	</div>
     
	     
	</div>';


       
                }
                 
                 $shopping_preview_adv .= "</div>";
              } 
         
  
$shopping_preview_adv .= '	
<br style="clear:left;"/>

   </fieldset>

	*За въпроси и/или коментари Ви молим да се свържете с нас!
</div>
<br style="clear:both;"/>';



$shopping_preview_adv .= '<script>';
for ($i=0; $i<$numOffersLimit; $i++) 
{
	for ($p=0; $p<$numPackages; $p++)
	{ 		
		$shopping_preview_adv .= 'TooltipManager.addURL("creditsHelp_'.$i.$p.'", "help/credits.html", 300, 300);';
	} 
} 
$shopping_preview_adv .= '</script>'; 


return $shopping_preview_adv;

?>