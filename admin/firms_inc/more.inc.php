<?php  
include_once("inc/dblogin.inc.php");

		if(empty($_REQUEST['hospital_category'])) $_REQUEST['hospital_category'] = $_REQUEST['category'];
	
		if ($_REQUEST['hospital_category']!="")  
		{
			$sql="SELECT h.id as 'hospital_id' FROM hospitals h, hospital_category hc, hospitals_category_list hcl WHERE hcl.hospital_id = h.id AND hcl.category_id = hc.id AND hcl.category_id = '".$_REQUEST['hospital_category']."' ";
			$conn->setsql($sql);
			$conn->getTableRows();
			$numHospitalByCats    = $conn->numberrows;
			$resultHospitalByCats = $conn->result;
			for($n=0;$n<$numHospitalByCats;$n++)
			{
				$hospitalsByCatsArr[]=$resultHospitalByCats[$n]['hospital_id'];
			}
			if(is_array($hospitalsByCatsArr))
			$hospitalsByCats = implode(',',$hospitalsByCatsArr);
			else $hospitalsByCats = '-1';
		}
				
		
		if ($hospitalsByCats!="")  $and .= " AND h.id IN (".$hospitalsByCats.")";
	 					

	 	$sql="SELECT DISTINCT(h.name) as 'firm', h.id as 'id', l.name as 'location', lt.name as 'locType', h.address as 'address', hc.name as 'category', h.manager as 'manager', h.description as 'description', h.phone as 'phone', h.has_pic as 'has_pic' FROM target_links_hospitals tl, locations l, location_types lt , hospitals h, hospital_category hc WHERE hc.id IN (tl.category) AND tl.firm_id=h.id AND tl.loc_id=l.id AND l.loc_type_id = lt.id $and ORDER BY tl.toD DESC"; 
		$conn->setsql($sql);
    	$conn->getTableRows();
    	$resultMore=$conn->result;   
        $numMore=$conn->numberrows;
    	
    	if ($numMore>0)
	    {	
	    	for ($i=0;$i<$numMore;$i++)
	    	{
	    		$numberPics=0;
	    		if ($resultMore[$i]['has_pic']=='1')
				{
					$sql="SELECT * FROM hospital_pics WHERE hospitalID='".$resultMore[$i]['id']."'";
					$conn->setsql($sql);
					$conn->getTableRows();
					$resultatPics=$conn->result; 
					$numberPics=$conn->numberrows;
				}	
				if($numberPics>0 && is_file('pics/firms/'.$resultatPics[0]['url_thumb'])) $picFile= 'pics/firms/'.$resultatPics[0]['url_thumb'];
   				else $picFile = 'pics/firms/no_photo_thumb.png';
    				
	    		?>
	    			
	    		<a href="?firmID=<?=$resultMore[$i]['id']?>" >
					
					<div style="margin-right:10px;margin-top:30px; border:double; border-color:#666666; height:80px; width:80px;" ><img width="80" height="80" src="<?=$picFile?>" /></div>
				
				<?php
			    	print $resultMore[$i]['firm']."<br />";
			    	print $resultMore[$i]['locType']." ".$resultMore[$i]['location']."<br />";			    				    	
			    	print $resultMore[$i]['category']."<br />";		
		    	?>
		    		    				
    			</a>
		    	<?php
	    	}
    	}
   