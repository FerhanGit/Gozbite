<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();

	   	
   	$shopping_preview_buy = "";
   	
$shopping_preview_buy .='<div style="width:660px;">
<input type="hidden" name="buy_package" id="buy_package" value="" />
<input type="hidden" name="package_name" id="package_name" value=""/>
<input type="hidden" name="price" id="price" value="" />
<input type="hidden" name="credits" id="credits" value="" />
<input type="hidden" name="time" id="time" value="" />

   <fieldset style = "width: 660px;">
      <legend style="color:#3399CC;">&nbsp;ПАКЕТИ от УСЛУГИ&nbsp;</legend>
     
      <br />';  
      
      

		// ne pozvolqvame da se izpolzva vsqkakvi krediti, a samo ot Destinacii, statii i novini
 		
		$totalCredits = ($_SESSION['cnt_bolest'] + $_SESSION['cnt_post'] + $_SESSION['cnt_news'] + $_SESSION['cnt_lekarstvo'] - $_SESSION['used_credits']);

 		$sql = "SELECT * FROM purchased_packages WHERE company_id='".(($_SESSION['user_type']=='hospital')?trim($_SESSION['userID']):0)."' AND doctor_id='".(($_SESSION['user_type']=='doctor')?trim($_SESSION['userID']):0)."' AND (NOW() BETWEEN start_date AND end_date)";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultOldPackages = $conn->result;
		$numOldPackages=$conn->numberrows;
			

	if(!empty($_REQUEST['buy_package']))
	{
	
$shopping_preview_buy .= '	
	<div align="left" style="width:600px;float:left;margin:10px 10px 10px 10px;padding:5px;background-color:#3399CC;font-weight:900;color:#FFFFFF"">Благодарим Ви за успешната покупка!
			
		<br /><br />
		Вашият продукт ще бъде активиран незабавно'.($_REQUEST['credits'] == 0?', щом бъде заплатена себестойността му ('.$_REQUEST['price'].' лв.). Може да направите Вашето плащане по <font color=\'#FF6600\'>Банков Път</font> или чрез сайта за електронни разплащания <font color=\'#FF6600\'>ePay.BG</font>. Ако сте избрали втория вариант, моля попълнете формата за <font color=\'#FF6600\'>ePay-плащане</font>, намираща се в долната част на тази страница.':'').'!<br /><br />
	    Сметка за банков превод - <br /> 
		IBAN: BG45 CECB 9790 1078 9489 00<br />  
		BIC: CECBBGSF<br />
		Централна Кооперативна Банка<br /><br />

    	За повече информация или въпроси Ви молим да се свържете с екипа на <a href=\'http://ohboli.bg/разгледай-страница-feedback,задайте_въпрос_напишете_коментар_препоръка_или_мнение.html\'>oHBoli.Bg</a>.
	   		 			
	</div>	';			

	
			
	}


               $sql = "SELECT DISTINCT(name) FROM packages";
			   $conn->setsql($sql);
			   $conn->getTableRows();
			   $resultOffersLimit=$conn->result;
			   $numOffersLimit = $conn->numberrows;
			  
             if($numOffersLimit > 0) 
             {
                 
				 $row=1;
				 $shopping_preview_buy .= "<div style=\"width:300px;\">";
				
                for ($i=0;$i<$numOffersLimit;$i++) 
                {
                 					   
	$shopping_preview_buy .='	
 <div style="width:640px; float:left;">
     <div style="float:left; width:200px; margin:2px 2px 2px 2px; padding:5px; background-color:#3399CC;"><a style="color:#FFF;" href=javascript:void(0); onclick="new Effect.toggle($(\'package_details'.$i.'\'),\'Appear\'); ">'.$resultOffersLimit[$i]['name'].'</a></div>
    <br style="clear:both;" />         
	<div id="package_details'.$i.'" style="margin:0px 0px 30px 0px; padding:0px; float:left;">
	<fieldset>
	<legend>Информация за пакет '.$resultOffersLimit[$i]['name'].'</legend> 
	
	 <br />';    
	          
  				
	        $sql = "SELECT * FROM packages WHERE name='".$resultOffersLimit[$i]['name']."'";
			$conn->setsql($sql);
			$conn->getTableRows();
			$resultPackages = $conn->result;
			$numPackages = $conn->numberrows;
			      
	      if($numPackages>0) 
	      {
	        	$shopping_preview_buy .= "<table style=\"float:left;\"><tr align='center' style='padding:10px;color:#FFFFFF;' bgcolor='#3399CC'><td style='padding:3px;'>За брой месеци</td><td style='padding:3px;'>Обща цена</td><td style='padding:3px;'>Цена в кредити</td><td style='padding:3px;'>Спестявате</td><td style='padding:3px;'>Купи</td><td style='padding:3px;'>Вземи с кредити</td><td></td></tr>";
				$row=1;
				
		      for ($p=0;$p<$numPackages;$p++)
		      {
		        if($row == 1)
				{$bgcolor = '#F9FBFF'; $row = 2; }
			 	else {$bgcolor = 'lightblue';  $row=1;}

			 	$session_userID = $_SESSION['userID']?$_SESSION['userID']:0;
			 	
			 	$shopping_preview_buy .= sprintf("<tr align='center' style='padding:10px;' bgcolor='%s'><td style='padding:5px;'>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href='javascript:document.searchform.submit();' onclick=\"if($session_userID>0) {if($numOldPackages==0) {if(confirm('Сигурни ли сте?')) { $('buy_package').setValue(%d); $('package_name').setValue('%s'); $('price').setValue('%s'); $('time').setValue('%s'); } else{ return false;}} else{alert('Вие вече имате закупен пакет, не може да продължите преди неговото изтичане!');return false;} } else{alert('Съжалявам, необходимо е да влезете в системата за да поръчате пакет от услуги.');return false;} \" ><img src=\"images/buy_package_btn.png\" /></a></td><td><a href='javascript:document.searchform.submit();' onclick=\"if($session_userID>0) {if($numOldPackages==0) {if(confirm('Сигурни ли сте?')) {if(".$totalCredits." >= ".$resultPackages[$p]['credit_cost'].") { $('buy_package').setValue(%d); $('package_name').setValue('%s'); $('price').setValue('%s'); $('credits').setValue(%d); $('time').setValue('%s');} else {alert('Вие нямате достатъчно кредити за да закупити този пакет!');return false;}} else{ return false;}} else{alert('Вие вече имате закупен пакет, не може да продължите преди неговото изтичане!');return false;} } else{alert('Съжалявам, необходимо е да влезете в системата за да поръчате пакет от услуги.');return false;}\" ><img src=\"images/buy_package_with_credits_btn.png\" /></a></td><td> <a href=\"javascript:void(0);\" id=\"creditsHelp_$i$p\" style=\"z-index:1000;\"><img src=\"images/help.png\" /></a></td></tr>",$bgcolor, $resultPackages[$p]['months'], $resultPackages[$p]['total_price'].'лв.', $resultPackages[$p]['credit_cost'].' кредита', (($resultPackages[$p]['concession']>0)?($resultPackages[$p]['concession'].'лв.'):'-'), $resultPackages[$p]['id'], $resultPackages[$p]['name'], $resultPackages[$p]['total_price'], $resultPackages[$p]['months'], $resultPackages[$p]['id'], $resultPackages[$p]['name'], $resultPackages[$p]['total_price'], $resultPackages[$p]['credit_cost'], $resultPackages[$p]['months']);
				        
		       }
	                
	              $shopping_preview_buy .= "</table>";
	            
   	  		       
$shopping_preview_buy .='
	  <div style="width:640px; float:left; margin: 0px 0px 0px 0px;">
	    	<div style="width:530px; float:left; margin: 10px 0px 0px 0px;">	
				<div align="center" style="width:530px;height:25px;margin:2px 0px 2px 2px;padding:2px;background-color:#F9FBFF;color:#FF6600">VIP клиент (визуализира се на първа страница)</div>
				<div align="center" style="width:530px;height:25px;margin:2px 0px 2px 2px;padding:2px;background-color:#F9FBFF;color:#FF6600">Видео представяне (публикуване на Ваше видео)</div>
				<div align="center" style="width:530px;height:25px;margin:2px 0px 2px 2px;padding:2px;background-color:#F9FBFF;color:#FF6600">Сребърен клиент (при търсене излиза след златните)</div>
				<div align="center" style="width:530px;height:25px;margin:2px 0px 2px 2px;padding:2px;background-color:#F9FBFF;color:#FF6600">Златен клиент (при търсене излиза най-отгоре)</div>
				<div align="center" style="width:530px;height:25px;margin:2px 0px 2px 2px;padding:2px;background-color:#F9FBFF;color:#FF6600">Избран клиент (излиза в секция "НА ФОКУС" на всички страници)</div>
				<div align="center" style="width:530px;height:25px;margin:2px 0px 2px 2px;padding:2px;background-color:#F9FBFF;color:#FF6600">PR материал/Статия (кратка рекламна статия на всички страници)</div>
			</div>
			<div style="width:100px; float:left; margin: 10px 0px 0px 0px;">	
				<div align="center" style="width:100px;height:25px;margin:2px 0px 2px 0px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">'.(($resultPackages[0]['is_VIP']==1?'<img src="images/green_tick_btn.png" />':'<img src="images/red_x_btn.png" />')).'</div>
				<div align="center" style="width:100px;height:25px;margin:2px 0px 2px 0px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">'.(($resultPackages[0]['has_video']==1?'<img src="images/green_tick_btn.png" />':'<img src="images/red_x_btn.png" />')).'</div>
				<div align="center" style="width:100px;height:25px;margin:2px 0px 2px 0px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">'.(($resultPackages[0]['is_Silver']==1?'<img src="images/green_tick_btn.png" />':'<img src="images/red_x_btn.png" />')).'</div>
				<div align="center" style="width:100px;height:25px;margin:2px 0px 2px 0px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">'.(($resultPackages[0]['is_Gold']==1?'<img src="images/green_tick_btn.png" />':'<img src="images/red_x_btn.png" />')).'</div>				
				<div align="center" style="width:100px;height:25px;margin:2px 0px 2px 0px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">'.(($resultPackages[0]['is_Featured']==1?'<img src="images/green_tick_btn.png" />':'<img src="images/red_x_btn.png" />')).'</div>
				<div align="center" style="width:100px;height:25px;margin:2px 0px 2px 0px;padding:2px;background-color:#F9FBFF;font-weight:900;color:#FF6600">'.(($resultPackages[0]['pr_Stuff']==1?'<img src="images/green_tick_btn.png" />':'<img src="images/red_x_btn.png" />')).'</div>				
			</div>	
			
	</div>';	
	    		
		
	              	
	     }
	    
	     
$shopping_preview_buy .='
	     </fieldset>
	</div>
     
	     </div>';



                }
                 
                 $shopping_preview_buy .= "</div>";
              } 
       
  


$shopping_preview_buy .='
    
	<!--<div style="width:510px; float:left; margin: 50px 0px 0px 0px;">	
				<div align="center" style="float:left;height:25px;margin:2px 2px 2px 2px;padding:5px;background-color:#3399CC;font-weight:900;color:#FFFFFF"">Данните за Вашата фактура:</div>				
	</div>
	<div style="width:200px; float:left; margin: 10px 0px 0px 0px;">	
				<div align="center" style="width:180px;height:25px;margin:2px 0px 2px 2px;padding:5px;background-color:#B8F08E;font-weight:900;color:#FF6600">Име на Фирмата:</div>
				<div align="center" style="width:180px;height:25px;margin:2px 0px 2px 2px;padding:5px;background-color:#B8F08E;font-weight:900;color:#FF6600">Адрес по Регистрация:</div>
				<div align="center" style="width:180px;height:25px;margin:2px 0px 2px 2px;padding:5px;background-color:#B8F08E;font-weight:900;color:#FF6600">Булстат:</div>
				<div align="center" style="width:180px;height:25px;margin:2px 0px 2px 2px;padding:5px;background-color:#B8F08E;font-weight:900;color:#FF6600">МОЛ:</div>
	</div>
	<div style="width:220px; float:left; margin: 10px 0px 0px 0px;">	
				<div align="center" style="width:250px;height:25px;margin:2px 2px 2px 0px;padding:5px;background-color:#F4FED8;font-weight:900;color:#FF6600"><input type="text" style="width:240px" name="firm_name" value="'.($_SESSION['name']).'"/></div>
				<div align="center" style="width:250px;height:25px;margin:2px 2px 2px 0px;padding:5px;background-color:#F4FED8;font-weight:900;color:#FF6600"><input type="text" style="width:240px" name="address" value="'.($_REQUEST['address']?$_REQUEST['address']:$_SESSION['address']).'>"/></div>
				<div align="center" style="width:250px;height:25px;margin:2px 2px 2px 0px;padding:5px;background-color:#F4FED8;font-weight:900;color:#FF6600"><input type="text" style="width:240px" name="bulstat" value="'.($_REQUEST['bulstat']?$_REQUEST['bulstat']:$_SESSION['bulstat']).'"/></div>
				<div align="center" style="width:250px;height:25px;margin:2px 2px 2px 0px;padding:5px;background-color:#F4FED8;font-weight:900;color:#FF6600"><input type="text" style="width:240px" name="mol" value="'.($_REQUEST['mol']?$_REQUEST['mol']:$_SESSION['mol']).'" /></div>
	</div>
	-->
	
	
	
	
<br style="clear:left;"/>

<style>

A.epay-button             { border: solid  1px #FFF; background-color: Maroon; padding: 6px; color: #FFF; background-image: none; font-weight: normal; padding-left: 20px; padding-right: 20px; }
A.epay-button:hover       { border: solid  1px #ABC; background-color: Maroon; padding: 6px; color: #FFF; background-image: none; font-weight: normal; padding-left: 20px; padding-right: 20px; }

A.epay                    { text-decoration: none; border-bottom: dotted 1px Maroon; color: Maroon; font-weight: bold; }
A.epay:hover              { text-decoration: none; border-bottom: solid  1px Maroon; color: Maroon; font-weight: bold; }

TABLE.epay-view    { white-space: nowrap; background-color: #CCC; }

/********** VIEWES **********************************************************/

TD.epay-view            { width: 100%; text-align: center; background-color: #DDD; }
TD.epay-view-header     {                                  background-color: Maroon; color: #FFF; height: 30px; }
TD.epay-view-name       { width:  25%; text-align: right;  background-color: #E9E9F9; border-bottom: none;  height: 30px; }
TD.epay-view-value      { width:  75%; text-align: left;   background-color: #E9E9F9; border-bottom: none; white-space: normal; }

INPUT.epay-button         { border: solid  1px #FFF; background-color: Maroon; padding: 4px; color: #FFF; background-image: none; padding-left: 20px; padding-right: 20px; }
INPUT.epay-button:hover   { border: solid  1px #ABC; background-color: Maroon; padding: 4px; color: #FFF; background-image: none; padding-left: 20px; padding-right: 20px; }

</style>

</form>
<form action="https://www.epay.bg/" method=post>
<table class=epay-view cellspacing=1 cellpadding=4 width=500>
<tr>
<td class=epay-view-header align=center>Описание</td>
<td class=epay-view-header align=center>Сума</td>
</tr>
<tr>
<td class=epay-view-value><b>Заплатете Услугата on-line</b></td>
<td class=epay-view-name><input type=text name=TOTAL value="" id="TOTAL" size=5> BGN</td>
</tr>
<tr>
<td colspan=2 class=epay-view-name>
<input class=epay-button type=submit name=BUTTON:EPAYNOW value="   Плащане on-line   " onclick="if(document.getElementById(\'TOTAL\').value > 0) { sendMailWhenEpayBg(document.getElementById(\'TOTAL\').value) }">
</td>
</tr>
<tr>
<td colspan=2 class=epay-view-name style="white-space: normal; font-size: 10">
Плащането се осъществява чрез <a class=epay href="https://www.epay.bg/">ePay.bg</a> - Интернет системата за плащане с банкови карти и микросметки
</td>
</tr>
</table>
<input type=hidden name=PAGE value="paylogin">
<input type=hidden name=MIN value="6042735676">
<input type=hidden name=INVOICE value="">
<input type=hidden name=DESCR value="Zaplatete Vashiq Paket on-line">
<input type=hidden name=URL_OK value="http://www.ohboli.bg">
<input type=hidden name=URL_CANCEL value="http://www.ohboli.bg">
</form>
                    
<form>

    
   </fieldset>

	*За въпроси и/или коментари Ви молим да се свържете с екипа на <a href=\'http://ohboli.bg/разгледай-страница-feedback,задайте_въпрос_напишете_коментар_препоръка_или_мнение.html\'>oHBoli.Bg</a>!
</div>

<br style="clear:left;"/>';



$shopping_preview_buy .= '<script>';	
for ($i=0; $i<$numOffersLimit; $i++) 
{
	for ($p=0; $p<$numPackages; $p++)
	{ 		
		$shopping_preview_buy .= 'TooltipManager.addURL("creditsHelp_'.$i.$p.'", "help/credits.html", 300, 300);';
	} 
} 
$shopping_preview_buy .= '</script>'; 

return $shopping_preview_buy;

?>