<?php  
include_once("inc/dblogin.inc.php");

				
		$and=" AND ";
		unset($andArr);
		$categoriata = ($_REQUEST['category'] != '' )?$_REQUEST['category']:$_REQUEST['hospital_category'];
	 	
	 	if ((isset($_POST['cityName']))&&(!empty($_POST['cityName'])))
	 	{
	 		if (count($_POST['cityName'])>1)  $andArr[]= "  tl.loc_id IN (".implode(',',$_POST['cityName']).")";
	 		else $andArr[]= "  tl.loc_id ='".$_POST['cityName']."'";
	 	}	 	
	 //	if ($_POST['search_btn']!="")  $andArr[]= "  tl.action_type='1'";
	 //	if (($_POST['insert_btn']!="") or ($_POST['edit_btn']!="") )  $andArr[]= "  tl.action_type='2'";
	 	if (!empty($categoriata)) $andArr[]= " ".$categoriata." IN (tl.category)";
	 	
	 	$and .=(is_array($andArr))?(implode(' OR ',$andArr)):('1=1');				
					

	 	$sql="SELECT DISTINCT(h.name) as 'firm', h.id as 'id', l.name as 'location', lt.name as 'locType', h.address as 'address', hc.name as 'category', h.manager as 'manager', h.description as 'description', h.phone as 'phone', h.has_pic as 'has_pic' FROM target_links_hospitals tl, locations l, location_types lt , hospitals h, hospital_category hc WHERE hc.id IN (tl.category) AND tl.firm_id=h.id AND tl.loc_id=l.id AND l.loc_type_id = lt.id $and ORDER BY tl.toD DESC"; 
		$conn->setsql($sql);
    	$conn->getTableRows();
    	$resultTarget=$conn->result;   
        $numTarget=$conn->numberrows;
    	
    	if ($numTarget>0)
	    {	
	    	for ($i=0;$i<$numTarget;$i++)
	    	{
	    		$numberPics=0;
	    		if ($resultTarget[$i]['has_pic']=='1')
				{
					$sql="SELECT * FROM hospital_pics WHERE hospitalID='".$resultTarget[$i]['id']."'";
					$conn->setsql($sql);
					$conn->getTableRows();
					$resultatPics=$conn->result; 
					$numberPics=$conn->numberrows;
				}	
				if($numberPics>0 && is_file('pics/firms/'.$resultatPics[0]['url_thumb'])) $picFile= 'pics/firms/'.$resultatPics[0]['url_thumb'];
   				else $picFile = 'pics/firms/no_photo_thumb.png';
    				
	    		?>
	    			
	    			<div id="TARGET_LINKS" style=" width:150px; margin-bottom:10px;background-color:#F3F3F3;">
					<img src="images/vulna_gorna.png"></img>
					<div id="TITLE_TARGET_LINKS" style="background-image:url(images/title_fon_green.png); margin-left:0px;margin-top:6px;margin-bottom:10px; height:30px; width:145px; background-repeat:no-repeat; font-size:12px;"></div>
					<a href="?firmID=<?=$resultTarget[$i]['id']?>" >
					
					<div style="margin-right:2px; border:double; border-color:#666666; width:120px;" ><img width="120" src="<?=(is_file("pics/firms/".$resultTarget[$i]['id']."_logo.jpg"))?"pics/firms/".$resultTarget[$i]['id']."_logo.jpg":"pics/firms/no_logo.png"?>" /></div>
				
				<?php
			    	print $resultTarget[$i]['firm']."<br />";
			    	print $resultTarget[$i]['locType']." ".$resultTarget[$i]['location']."<br />";			    				    	
			    	print $resultTarget[$i]['category']."<br />";		
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
    				<a href="?firmID=<?=$resultTarget[$i]['id']?>" >
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