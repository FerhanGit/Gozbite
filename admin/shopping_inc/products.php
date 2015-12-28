<div style="float:left;width:460px;">
<input type="hidden" name="buy_package" id="buy_package" value="" />
<input type="hidden" name="package_name" id="package_name" value=""/>
<input type="hidden" name="price" id="price" value="" />
<input type="hidden" name="time" id="time" value="" />

   <fieldset style = "width: auto;">
      <legend style="color:#3399CC;">&nbsp;ПАКЕТИ&nbsp;</legend>
     
      
      
<?php

 		$sql = "SELECT * FROM purchased_packages WHERE company_id='".(($_SESSION['user_type']=='hospital')?trim($_SESSION['userID']):0)."' AND doctor_id='".(($_SESSION['user_type']=='doctor')?trim($_SESSION['userID']):0)."' AND (NOW() BETWEEN start_date AND end_date)";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultOldPackages = $conn->result;
		$numOldPackages=$conn->numberrows;
			

if(!empty($_REQUEST['buy_package']))
	{?>
	
	
	<div align="center" style="width:420px;float:left;height:25px;margin:10px 10px 10px 10px;padding:5px;background-color:#3399CC;font-weight:900;color:#FFFFFF"">Благодарим Ви за успешната покупка!</div>				

	
	<?php		
	}
?>
		<?php
               $sql = "SELECT DISTINCT(name) FROM packages";
			   $conn->setsql($sql);
			   $conn->getTableRows();
			   $resultOffersLimit=$conn->result;
			   $numOffersLimit=$conn->numberrows;
			  
             if($numOffersLimit > 0) {
                 
				 $row=1;
				 print "<div style=\"width:300px;\">";
				
                for ($i=0;$i<$numOffersLimit;$i++) 
                {
                 					   
		?>		
 <div style="width:440px; float:left;">
     <div style="float:left;width:200px;margin:2px 2px 2px 2px;padding:5px;background-color:#3399CC;font-weight:900;"><a style="color:#000000; text-decoration:none;" href=javascript:void(0); onclick="new Effect.toggle($('package_details<?=$i?>'),'Appear');"><?=$resultOffersLimit[$i]['name']?></a></div>
    <br style="clear:both;" />         
	<div id="package_details<?=$i?>" style="margin:0px 0px 30px 0px; padding:0px; float:left;display:none;">
	<fieldset>
	<legend>Информация за пакет <?=$resultOffersLimit[$i]['name']?></legend>          
	            <?php
	          				
	        $sql = "SELECT * FROM packages WHERE name='".$resultOffersLimit[$i]['name']."'";
			$conn->setsql($sql);
			$conn->getTableRows();
			$resultPackages=$conn->result;
			$numPackages=$conn->numberrows;
			      
	      if($numPackages>0) 
	      {
	        	print "<table style=\"float:left\"><tr align='center' style='padding:10px;font-weight:900;color:#FFFFFF;' bgcolor='#3399CC'><td>За брой месеци</td><td>Обща цена</td><td>Спестявате</td><td>Купи</td></tr>";
				$row=1;
				
		      for ($p=0;$p<$numPackages;$p++)
		      {
		        if($row == 1)
				{$bgcolor = '#F9FBFF'; $row = 2; }
			 	else {$bgcolor = 'lightblue';  $row=1;}

			 	printf("<tr align='center' style='padding:10px;' bgcolor='%s'><td style='padding:5px;'>%s</td><td>%s</td><td>%s</td><td><a href='javascript:document.searchform.submit();' onclick=\"if($numOldPackages==0) {if(confirm('Сигурни ли сте?')) { $('buy_package').setValue(%d); $('package_name').setValue('%s'); $('price').setValue('%s'); $('time').setValue('%s'); } else{ return false;}} else{alert('Вие вече имате закупен пакет, не може да продължите преди неговото изтичане!');return false;}\" >Вземам го</a></td></tr>",$bgcolor, $resultPackages[$p]['months'], $resultPackages[$p]['total_price'].'лв.', (($resultPackages[$p]['concession']>0)?($resultPackages[$p]['concession'].'лв.'):'-'), $resultPackages[$p]['id'], $resultPackages[$p]['name'], $resultPackages[$p]['total_price'], $resultPackages[$p]['months']);
				        
		       }
	                
	              print "</table>";
	              
   	  		       
	  ?>
	  <div style="width:410px; float:left; margin: 0px 0px 0px 0px;">
	    	<div style="width:150px; float:left; margin: 10px 0px 0px 0px;">	
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 2px;padding:5px;background-color:lightblue;font-weight:900;color:#FFFFFF">VIP клиент</div>
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 2px;padding:5px;background-color:lightblue;font-weight:900;color:#FFFFFF">Видео представяне</div>
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 2px;padding:5px;background-color:lightblue;font-weight:900;color:#FFFFFF">Сребърен клиент</div>
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 2px;padding:5px;background-color:lightblue;font-weight:900;color:#FFFFFF">Златен клиент</div>
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 2px;padding:5px;background-color:lightblue;font-weight:900;color:#FFFFFF">Избран клиент</div>
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 2px;padding:5px;background-color:lightblue;font-weight:900;color:#FFFFFF">PR материал/Статия</div>
			</div>
			<div style="width:110px; float:left; margin: 10px 0px 0px 0px;">	
				<div align="center" style="width:115px;height:25px;margin:2px 2px 2px 0px;padding:5px;background-color:#F9FBFF;font-weight:900;color:#FF6600"><?=$resultPackages[0]['is_VIP']==1?'Да':'Не'?></div>
				<div align="center" style="width:115px;height:25px;margin:2px 2px 2px 0px;padding:5px;background-color:#F9FBFF;font-weight:900;color:#FF6600"><?=$resultPackages[0]['has_video']==1?'Да':'Не'?></div>
				<div align="center" style="width:115px;height:25px;margin:2px 2px 2px 0px;padding:5px;background-color:#F9FBFF;font-weight:900;color:#FF6600"><?=$resultPackages[0]['is_Silver']==1?'Да':'Не'?></div>
				<div align="center" style="width:115px;height:25px;margin:2px 2px 2px 0px;padding:5px;background-color:#F9FBFF;font-weight:900;color:#FF6600"><?=$resultPackages[0]['is_Gold']==1?'Да':'Не'?></div>				
				<div align="center" style="width:115px;height:25px;margin:2px 2px 2px 0px;padding:5px;background-color:#F9FBFF;font-weight:900;color:#FF6600"><?=$resultPackages[0]['is_Futured']==1?'Да':'Не'?></div>
				<div align="center" style="width:115px;height:25px;margin:2px 2px 2px 0px;padding:5px;background-color:#F9FBFF;font-weight:900;color:#FF6600"><?=$resultPackages[0]['pr_Stuff']==1?'Да':'Не'?></div>				
			</div>	
	</div>	
	    		
	<?php	
	              	
	     }
	    
	    	     	                
	   ?>
	     </fieldset>
	</div>
     
	     



        <?php
                }
                 
                 print "</div>";
              } 
            ?>
  
</div>



    
	<div style="width:410px; float:left; margin: 50px 0px 0px 0px;">	
				<div align="center" style="float:left;height:25px;margin:2px 2px 2px 2px;padding:5px;background-color:#3399CC;font-weight:900;color:#FFFFFF"">Данните за Вашата фактура:</div>				
	</div>
	<div style="width:150px; float:left; margin: 10px 0px 0px 0px;">	
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 2px;padding:5px;background-color:#B8F08E;font-weight:900;color:#FF6600">Име на Фирмата:</div>
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 2px;padding:5px;background-color:#B8F08E;font-weight:900;color:#FF6600">Адрес по Регистрация:</div>
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 2px;padding:5px;background-color:#B8F08E;font-weight:900;color:#FF6600">Булстат:</div>
				<div align="center" style="width:150px;height:25px;margin:2px 0px 2px 2px;padding:5px;background-color:#B8F08E;font-weight:900;color:#FF6600">МОЛ:</div>
	</div>
	<div style="width:250px; float:left; margin: 10px 0px 0px 0px;">	
				<div align="center" style="width:250px;height:25px;margin:2px 2px 2px 0px;padding:5px;background-color:#F4FED8;font-weight:900;color:#FF6600"><input type="text" style="width:240px" name="firm_name" value="<?=$_SESSION['name']?>"/></div>
				<div align="center" style="width:250px;height:25px;margin:2px 2px 2px 0px;padding:5px;background-color:#F4FED8;font-weight:900;color:#FF6600"><input type="text" style="width:240px" name="address" value="<?=$_REQUEST['address']?$_REQUEST['address']:$_SESSION['address']?>"/></div>
				<div align="center" style="width:250px;height:25px;margin:2px 2px 2px 0px;padding:5px;background-color:#F4FED8;font-weight:900;color:#FF6600"><input type="text" style="width:240px" name="bulstat" value="<?=$_REQUEST['bulstat']?$_REQUEST['bulstat']:$_SESSION['bulstat']?>"/></div>
				<div align="center" style="width:250px;height:25px;margin:2px 2px 2px 0px;padding:5px;background-color:#F4FED8;font-weight:900;color:#FF6600"><input type="text" style="width:240px" name="mol" value="<?=$_REQUEST['mol']?$_REQUEST['mol']:$_SESSION['mol']?>" /></div>
	</div>
	
   </fieldset>




</div>