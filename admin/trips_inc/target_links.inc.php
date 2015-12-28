<?php  
include_once("inc/dblogin.inc.php");

				
		$and=" AND ";
		unset($andArr);
		$categoriata = ($_REQUEST['category'] != '' )?$_REQUEST['category']:$_REQUEST['bolest_category'];
	 	
	 //	if ($_POST['search_btn']!="")  $and .= " tl.action_type='1'";
	 //	if (($_POST['insert_btn']!="") or ($_POST['edit_btn']!="") )  $and .= " tl.action_type='2'";
	 	if (!empty($categoriata)) $andArr[]= $categoriata." IN (tl.category)";
	 	
	 	if (!empty($_POST['simptom']) && is_array($_POST['simptom'])) $andArr[]= " tl.simptom IN (".implode(',',$_POST['simptom']).")";
	 	
	 	$and .=(is_array($andArr))?(implode(' OR ',$andArr)):('1=1');				
			

	 	$sql="SELECT b.title as 'bolest', b.bolestID as 'id', bc.name as 'category', b.body as 'body', b.has_pic as 'has_pic' FROM target_links_bolesti tl, bolesti b, bolest_category bc, bolest_simptoms bs WHERE bs.id IN (tl.simptom) AND bc.id IN (tl.category) AND tl.bolest_id=b.bolestID $and ORDER BY tl.toD DESC"; 
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
					$sql="SELECT * FROM bolesti_pics WHERE bolestID='".$resultTarget[$i]['id']."'";
					$conn->setsql($sql);
					$conn->getTableRows();
					$resultatPics=$conn->result; 
					$numberPics=$conn->numberrows;
				}	
				if($numberPics>0 && is_file('pics/bolesti/'.$resultatPics[0]['url_thumb'])) $picFile= 'pics/bolesti/'.$resultatPics[0]['url_thumb'];
   				else $picFile = 'pics/bolesti/no_photo_thumb.png';
    						
	    		?>
	    			
	    			<div id="TARGET_LINKS" style=" width:150px; margin-bottom:10px;background-color:#F3F3F3;">
					<div><img src="images/vulna_gorna.png"></img></div>
					<div id="TITLE_TARGET_LINKS" style="background-image:url(images/title_fon_green.png); margin-left:0px;margin-top:6px;margin-bottom:10px; height:30px; width:145px; background-repeat:no-repeat; font-size:12px;"></div>
					<a href="?bolestID=<?=$resultTarget[$i]['id']?>" >
					
					<div style="margin-right:10px; border:double; border-color:#666666; height:80px; width:80px;" ><img width="80" height="80" src="<?=$picFile?>" /></div>
				<?php
			    	print $resultTarget[$i]['bolest']."<br />";
			    	print $resultTarget[$i]['category']."<br />";		    	
			    	print $resultTarget[$i]['simptom']."<br />";		    	
			    	
		    	?>
		    		<div><img src="images/vulna_dolna.png"></img></div>
    				</div>
    				</a>
		    	<?php
	    	}
    	}
    	else 
    	{
    		?>
    				<a href="?bolestID=<?=$resultTarget[$i]['id']?>" >
	    			<div id="TARGET_LINKS" style=" width:150px; margin-bottom:10px;background-color:#F3F3F3;">
					<div><img src="images/vulna_gorna.png"></img></div>
			<?php
    		
					print "Място за Вашата фирма!";
			?>
					<div><img src="images/vulna_dolna.png"></img></div>
    				</div>
    				</a>
		   	<?php
    	}
?>