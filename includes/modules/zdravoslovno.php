<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/
						
	$response = '';
  	$response .= '<div class="boxRight main_same_height_first_line">
		<div class="title" style="margin-bottom:20px">Наздраве</div>
		 <div class="contentBox_first_line">
	    	<p>';
  
  
    $xml = simplexml_load_file("http://ohboli.bg/includes/tools/posts.xml", null, LIBXML_NOCDATA);
   
    $x=0;
    foreach($xml->post as $Itm)
	{
		
	  $picFileZdravoslovno= $Itm->image;
	   		 
	  	   		 
		 	list($widthZdravoslovno, $heightZdravoslovno, $typeZdravoslovno, $attrZdravoslovno) = getimagesize($picFileZdravoslovno);
			$pic_width_or_heightZdravoslovno = 50;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
			if (($heightZdravoslovno) && ($widthZdravoslovno))	
			{
				if($widthZdravoslovno >= $heightZdravoslovno)	{$newheightZdravoslovno = ($heightZdravoslovno/$widthZdravoslovno)*$pic_width_or_heightZdravoslovno; $newwidthZdravoslovno	=	$pic_width_or_heightZdravoslovno;	}
				else					{$newwidthZdravoslovno = ($widthZdravoslovno/$heightZdravoslovno)*$pic_width_or_heightZdravoslovno; $newheightZdravoslovno	=	$pic_width_or_heightZdravoslovno;	}
			}
		
		   $response .=	'<div id=\'tabs_inside\' style=" margin-bottom:10px;width:290px; font-size:12px; font-family: \'Trebuchet MS\', Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\''.$Itm->link.'\'" onMouseover="this.style.backgroundColor=\'#F7F7F9\'; document.getElementById(\'postImgZdravoslovnoDiv_'.$x.'\').style.borderColor=\'#0099FF\';" onMouseout="this.style.backgroundColor=\'transparent\';  document.getElementById(\'postImgZdravoslovnoDiv_'.$x.'\').style.borderColor=\'#CCCCCC\';">';
		   $response .= '<table><tr>';
		   $response .= '<td valign="top">';
		   $response .= '<a href="'.$Itm->link.'" target="_blank"><div  id="postImgZdravoslovnoDiv_'.$x.'" onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="border:1px solid #CCCCCC; width:60px; padding:2px; background-color:#F9F9F9;" align="center" ><img style="border:none;" width="'.($newwidthZdravoslovno?$newwidthZdravoslovno:50).'"  src="'.$picFileZdravoslovno.'" /></div></a>';
		   $response .= '</td><td valign="top"><div style="margin-left:5px; width:215px;  font-size:12px;" ><a target="_blank" href="'.$Itm->link.'" target="_blank" style="color:#666666;" >'.myTruncate($Itm->story_title, 90, " ").'</a></div>';
		   $response .= '</td></tr></table>';	            
		   $response .= '</div>';
		   
		   $x++;
		   
	}
	
	
$response .= '</p></div>
		</div>';
		
	return $response;
	  
	?>
