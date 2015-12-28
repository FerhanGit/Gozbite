<?php  include_once("dblogin.inc.php"); 

				
		$and="";
	 	if ((isset($_POST['cityName']))&&(!empty($_POST['cityName'])))
	 	{
	 		if (count($_POST['cityName'])>1)  $and .= " AND tl.loc_id IN (".implode(',',$_POST['cityName']).")";
	 		else $and .= " AND tl.loc_id ='".$_POST['cityName'][0]."'";
	 	}	 	
	 	if (($_POST['marka']!="") && ($_POST['marka']!="-1")) $and .= " AND tl.marka='".$_POST['marka']."'";
	 	if ($_POST['search_btn']!="")  $and .= " AND tl.action_type='1'";
	 	if (($_POST['insert_btn']!="") or ($_POST['edit_btn']!="") )  $and .= " AND tl.action_type='2'";
	 	if (!empty($_POST['details'])) $and .= " AND tl.detail IN (".implode(',',$_POST['details']).")";
	 				

	 	$sql="SELECT DISTINCT(ah.name) as 'firm', l.name as 'location', ah.address as 'address', ah.manager as 'manager', ah.description as 'description', ah.phone as 'phone' FROM target_links tl, locations l, auto_houses ah WHERE tl.firm_id=ah.id AND tl.loc_id=l.id $and "; 
		$conn->setsql($sql);
    	$conn->getTableRows();
    	$resultTarget=$conn->result;   
        $numTarget=$conn->numberrows;
    	
    	if ($numTarget>0)
	    {	
	    	for ($i=0;$i<$numTarget;$i++)
	    	{
	    		?>
	    			
	    			<div id="TARGET_LINKS" style=" width:150px; margin-bottom:10px;background-color:#F3F3F3;">
					<img src="images/vulna_gorna.png"></img>
					<div id="TITLE_TARGET_LINKS" style="background-image:url(images/title_fon_green.png); margin-left:0px;margin-top:6px;margin-bottom:10px; height:30px; width:145px; background-repeat:no-repeat; font-size:12px;"></div>
				<a href="" >
				<?php
			    	print "Име: ".$resultTarget[$i]['firm']."<br />";
			    	print "Местоположение: ".$resultTarget[$i]['location']."<br />";
			    	print "Адрес: ".$resultTarget[$i]['address']."<br />";
			    	print "Телефон: ".$resultTarget[$i]['phone']."<br />";
			    	print "Менажер: ".$resultTarget[$i]['manager']."<br />";
			    	print "За фирмата: ".$resultTarget[$i]['description']."<br />";
			    	
		    	?>
		    		<img src="images/vulna_dolna.png"></img>
    				</div>
    				</a>
		    	<?php
	    	}
    	}
    	else 
    	{
    		?>
    				<a href="" >
	    			<div id="TARGET_LINKS" style=" width:150px; margin-bottom:10px;background-color:#F3F3F3;">
					<img src="images/vulna_gorna.png"></img>
			<?php
    		
					print "Място за Вашата фирма!";
			?>
					<img src="images/vulna_dolna.png"></img>
    				</div>
    				</a>
		   	<?php
    	}
?>