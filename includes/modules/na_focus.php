<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/



	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
   	
   	
	$na_focus = "";
	$na_focus .= '<div class="boxRight" >
	<div class="title" style="margin-bottom:10px"  title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Бъди НА ФОКУС за 1 седмица] body=[&rarr; За да използваш услугата изпрати SMS с текст <span style="color:#FF6600;font-weight:bold;">izbran</span> на номер <span style="color:#FF6600;font-weight:bold;">1093</span> (цена с ДДС - 1.20лв.). След това влез в своя профил и въведи получения код. <br />* Важи само за регистрирани в разделите "Лекари" и "Здравни Заведения"]\'>На фокус</div>
      <div class="contentBox" style="height:340px;">
						<script type="text/javascript">


var countSlideFocus = 0;
function autoUpdateSlideFocus()
{
	var typeContentFocusArr = new Array(5);
	typeContentFocusArr[0]="#postsContentFocus";
	typeContentFocusArr[1]="#recipesContentFocus";
	typeContentFocusArr[2]="#drinksContentFocus";
	typeContentFocusArr[3]="#firmsContentFocus";
	typeContentFocusArr[4]="#guidesContentFocus";  
	
	var typeBoxFocusArr = new Array(5);
	typeBoxFocusArr[0]="#postsBoxFocus";
	typeBoxFocusArr[1]="#recipesBoxFocus";
	typeBoxFocusArr[2]="#drinksBoxFocus";
	typeBoxFocusArr[3]="#firmsBoxFocus";
	typeBoxFocusArr[4]="#guidesBoxFocus";  

	FocusTitleArr = new Array(5);
	FocusTitleArr[0] = "Статии";
	FocusTitleArr[1] = "Рецепти";
	FocusTitleArr[2] = "Напитки";
	FocusTitleArr[3] = "Заведения/Фирми";
	FocusTitleArr[4] = "Справочник";

	
	
	changeSRC(countSlideFocus);
	
	jQuery(".ContBoxFocus").hide(); 
	//Effect.Grow(typeContentFocusArr[countSlideFocus]); 
	jQuery(typeContentFocusArr[countSlideFocus]).show("slow");
	jQuery("#FocusTitle").html(FocusTitleArr[countSlideFocus]);
		
	countSlideFocus++; 
	if(countSlideFocus == 5) {countSlideFocus = 0;}
	
}

function changeSRC(cnt)
{
	var typeBoxFocusArr = new Array(5);
	typeBoxFocusArr[0]="#postsBoxFocus";
	typeBoxFocusArr[1]="#recipesBoxFocus";
	typeBoxFocusArr[2]="#drinksBoxFocus";
	typeBoxFocusArr[3]="#firmsBoxFocus";
	typeBoxFocusArr[4]="#guidesBoxFocus";  
	
	jQuery(typeBoxFocusArr[0]).attr("src", "images/orange_six.png");
	jQuery(typeBoxFocusArr[1]).attr("src", "images/orange_six.png");
	jQuery(typeBoxFocusArr[2]).attr("src", "images/orange_six.png");
	jQuery(typeBoxFocusArr[3]).attr("src", "images/orange_six.png");
	jQuery(typeBoxFocusArr[4]).attr("src", "images/orange_six.png");
	
	jQuery(typeBoxFocusArr[cnt]).attr("src", "images/blue_six.png");
	
}


jQuery(document).ready(function($) {
	   
	
	jQuery("#postsBoxFocus").click(function() {
	 	window.clearInterval(t3); t3=window.setInterval("autoUpdateSlideFocus()", 20000);  countSlideFocus = 1; changeSRC(0); jQuery(".ContBoxFocus").hide(); 
		jQuery("#FocusTitle").html(FocusTitleArr[0]); jQuery("#postsContentFocus").show("slow"); return false;
	});

	jQuery("#recipesBoxFocus").click(function() {
	 	window.clearInterval(t3); t3=window.setInterval("autoUpdateSlideFocus()", 20000);  countSlideFocus = 2; changeSRC(1); jQuery(".ContBoxFocus").hide(); 
		jQuery("#FocusTitle").html(FocusTitleArr[1]); jQuery("#recipesContentFocus").show("slow"); return false;
	});

	jQuery("#drinksBoxFocus").click(function() {
	 	window.clearInterval(t3); t3=window.setInterval("autoUpdateSlideFocus()", 20000);  countSlideFocus = 3; changeSRC(2); jQuery(".ContBoxFocus").hide(); 
		jQuery("#FocusTitle").html(FocusTitleArr[2]); jQuery("#drinksContentFocus").show("slow"); return false;
	});

	jQuery("#firmsBoxFocus").click(function() {
	 	window.clearInterval(t3); t3=window.setInterval("autoUpdateSlideFocus()", 20000);  countSlideFocus = 4; changeSRC(3); jQuery(".ContBoxFocus").hide(); 
		jQuery("#FocusTitle").html(FocusTitleArr[3]); jQuery("#firmsContentFocus").show("slow"); return false;
	});

	jQuery("#guidesBoxFocus").click(function() {
	 	window.clearInterval(t3); t3=window.setInterval("autoUpdateSlideFocus()", 20000);  countSlideFocus = 0; changeSRC(4); jQuery(".ContBoxFocus").hide(); 
		jQuery("#FocusTitle").html(FocusTitleArr[4]); jQuery("#guidesContentFocus").show("slow"); return false;
	});
	
	t3=window.setInterval("autoUpdateSlideFocus()", 20000);
	autoUpdateSlideFocus();
	
});
		
</script>



<div class="postBig">

	<div class="detailsDiv" style="width:250px; margin-bottom:20px; margin-left:20px;   border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
		<div id="newsButtons" class="newsButtons"  style=" width:240px; padding-left:10px;" align="center">
		 	<div id="FocusTitle">Статии</div>
				<img id="postsBoxFocus" style="margin:2px 5px 2px 0px;width:30px;height:30px;cursor:pointer;cursor:hand;" align="center"  src="images/orange_six.png" /> <span>&nbsp;</span> 
				<img id="recipesBoxFocus" style="margin:2px 5px 2px 0px;width:30px;height:30px;cursor:pointer;cursor:hand;" align="center"  src="images/orange_six.png" /> <span>&nbsp;</span> 
				<img id="drinksBoxFocus" style="margin:2px 5px 2px 0px;width:30px;height:30px;cursor:pointer;cursor:hand;" align="center"  src="images/orange_six.png" /> <span>&nbsp;</span> 
				<img id="firmsBoxFocus"  style="margin:2px 5px 2px 0px;width:30px;height:30px;cursor:pointer;cursor:hand;" align="center"  src="images/orange_six.png" /> <span>&nbsp;</span> 
				<img id="guidesBoxFocus"  style="margin:2px 5px 2px 0px;width:30px;height:30px;cursor:pointer;cursor:hand;" align="center"  src="images/orange_six.png" /> <span>&nbsp;</span> 
		</div> 
	</div> 
		
	
		<div id="postsContentFocus" class="ContBoxFocus">';		
						
				$sql="SELECT p.postID as 'postID', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category = pc.id  AND p.active = '1' ORDER BY RAND(), p.date DESC LIMIT 5 ";
				$conn->setsql($sql);
				$conn->getTableRows();
				$Itm  = $conn->result;	
				$numItms = $conn->numberrows;
			
				$row = 1;
				for($i=0;$i<$numItms;$i++)
				{
				   if(is_file('pics/posts/'.$Itm[$i]['picURL'])) $picFile= 'pics/posts/'.$Itm[$i]['picURL'];
	   				else $picFile = 'pics/posts/no_photo_thumb.png';
	   
	
									
	   	   			$bgcolor = ($row % 2 == 0) ? '#F7F7F9' : 'transparent';
				
				   	$na_focus .=	'<div style=" background-color:'.$bgcolor.'; float:left; padding-left:5px; width:300px; color:#333333; font-size:12px; font-family: \'Trebuchet MS\', Arial,sans-serif;cursor:pointer;cursor:hand;" onClick="javascript:document.location.href=\'прочети-статия-'.$Itm[$i]['postID'].','.myTruncateToCyrilic($Itm[$i]['title'],200,"_","").'.html\'" onMouseover="this.style.color=\'#FFFFFF\'; this.style.backgroundColor=\''.(($row % 2 == 0) ? '#0099FF' : '#0099FF').'\';" onMouseout="this.style.color=\'#333333\'; this.style.backgroundColor=\''.(($row % 2 == 0) ? '#F7F7F9' : 'transparent').'\';">';
				   	$na_focus .= '<table><tr>';
				   	$na_focus .= '<td valign="top">';
				   	$na_focus .= '<div onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';"  style="float:left; border:double; border-color:#333333; height:35px; width:35px;" ><a href="прочети-статия-'.$Itm[$i]['postID'].','.myTruncateToCyrilic($Itm[$i]['title'],200,"_","").'.html"><img width="35" height="35" src="'.$picFile.'" /></a></div>';
				   	$na_focus .= '<div style=" float:left; margin-left:10px; width:240px; font-weight:bold;" >'.myTruncate($Itm[$i]['title'], 90, " ").'</div>';
				  	// $na_focus .= '<div  style="float:left; background-image:url(images/floorer_48.gif); background-repeat:repeat-x; margin-left:10px; width:240px;" ><i>'.$Itm[$i]['category'].'</i></div>';
				         			
				   	$na_focus .= '</td></tr></table>';	            
				   	$na_focus .= '</div>';
				
					$row  ++ ;
	
				}	
				
				
				
$na_focus .= '</div>	
	
		
		<div id="recipesContentFocus" class="ContBoxFocus" style="display:none;">';
			
		$sql="SELECT r.id as 'id', r.title as 'title', r.has_pic as 'has_pic', r.registered_on as 'registered_on' FROM recipes r WHERE r.active = '1' ORDER BY RAND(), r.registered_on DESC LIMIT 5 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$Itm  = $conn->result;
	$numItms  = $conn->numberrows;
	
	
	$na_focus .= '<table style="margin:5px;">';
	    
	
	for($i=0;$i<$numItms;$i++)
	{
				
		if ($Itm[$i]['has_pic']=='1')
		{
			$sql="SELECT * FROM recipe_pics WHERE recipeID='".$Itm[$i]['id']."'";
			$conn->setsql($sql);
			$conn->getTableRows();
			$resultPics[$i]=$conn->result;
			$numPics[$i]=$conn->numberrows;
		}
		
	   if(is_file('pics/recipes/'.$resultPics[$i][0]['url_thumb'])) $picFile= 'pics/recipes/'.$resultPics[$i][0]['url_thumb'];
	   else $picFile = 'pics/recipes/no_photo_thumb.png';
	   	

	    list($width, $height, $type, $attr) = getimagesize($picFile);
		$pic_width_or_height = 40;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
		if (($height) && ($width))	
		{
			if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
			else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
		}
					
		
	    $na_focus .= '<tr>';
		$na_focus .= '<td>';
		
		$na_focus .= '<div class="postBig">';
		$na_focus .= '<div class="detailsDiv" style="float:left;cursor:pointer; width:225px;margin-bottom:10px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';
						
	    $na_focus .= '<h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a href="разгледай-рецепта-'.$Itm[$i]['id'].",".myTruncateToCyrilic($Itm[$i]['title'],200,' ','').'.html" style="font-size:12px; font-weight:bold;" >'.$Itm[$i]['title'].'</a></h3>';
	    $na_focus .= '<a href="разгледай-рецепта-'.$Itm[$i]['id'].",".myTruncateToCyrilic($Itm[$i]['title'],200,' ','').'.html" style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" >';				    		
	    $na_focus .= '</a>'; 
    	$na_focus .= '</div>'; 
    	$na_focus .= '</div>';
    	
    	$na_focus .= '</td>';
 		$na_focus .= '<td><a href="разгледай-рецепта-'.$Itm[$i]['id'].",".myTruncateToCyrilic($Itm[$i]['title'],200,' ','').'.html" ><div id="recipeFocusImgDiv_'.$Itm[$i]['id'].'"  onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';" style="border:1px solid #CCCCCC; width:50px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:40).'"  src="'.$picFile.'" /></div></a>';
		$na_focus .= '</td>';
		$na_focus .= '</tr>';  	
  		
	}	
				
				
$na_focus .= '</table></div>		
		
		
		
		



	<div id="drinksContentFocus" class="ContBoxFocus" style="display:none;">	';
			
	$sql="SELECT d.id as 'id', d.title as 'title', d.has_pic as 'has_pic', d.registered_on as 'registered_on' FROM drinks d WHERE d.active = '1' ORDER BY RAND(), d.registered_on DESC LIMIT 5 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$Itm  = $conn->result;
	$numItms  = $conn->numberrows;
	
	
	$na_focus .= '<table style="margin:5px;">';
	    
	
	for($i=0;$i<$numItms;$i++)
	{
				
		if ($Itm[$i]['has_pic']=='1')
		{
			$sql="SELECT * FROM drink_pics WHERE drinkID='".$Itm[$i]['id']."'";
			$conn->setsql($sql);
			$conn->getTableRows();
			$resultPics[$i]=$conn->result;
			$numPics[$i]=$conn->numberrows;
		}
		
	   if(is_file('pics/drinks/'.$resultPics[$i][0]['url_thumb'])) $picFile= 'pics/drinks/'.$resultPics[$i][0]['url_thumb'];
	   else $picFile = 'pics/drinks/no_photo_thumb.png';
	   	

	    list($width, $height, $type, $attr) = getimagesize($picFile);
		$pic_width_or_height = 40;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
		if (($height) && ($width))	
		{
			if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
			else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
		}
					
	
	  	
	    $na_focus .= '<tr>';
		$na_focus .= '<td>';
		
		$na_focus .= '<div class="postBig">';
		$na_focus .= '<div class="detailsDiv" style="float:left;cursor:pointer; width:225px;margin-bottom:10px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';
						
	    $na_focus .= '<h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a href="разгледай-напитка-'.$Itm[$i]['id'].",".myTruncateToCyrilic($Itm[$i]['title'],200,' ','').'.html" style="font-size:12px; font-weight:bold;" >'.$Itm[$i]['title'].'</a></h3>';
	    $na_focus .= '<a href="разгледай-напитка-'.$Itm[$i]['id'].",".myTruncateToCyrilic($Itm[$i]['title'],200,' ','').'.html" style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" >';				    		
	    $na_focus .= '</a>'; 
    	$na_focus .= '</div>'; 
    	$na_focus .= '</div>';
    	
    	$na_focus .= '</td>';
 		$na_focus .= '<td><a href="разгледай-напитка-'.$Itm[$i]['id'].",".myTruncateToCyrilic($Itm[$i]['title'],200,' ','').'.html" ><div id="drinkFocusImgDiv_'.$Itm[$i]['id'].'"  onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';" style="border:1px solid #CCCCCC; width:50px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:40).'"  src="'.$picFile.'" /></div></a>';
		$na_focus .= '</td>';
		$na_focus .= '</tr>';  	
  		
	}	
	$na_focus .= '</table></div>		
		
		
		
		
		
			
		
		<div id="firmsContentFocus" class="ContBoxFocus" style="display:none;">	';
			
							
			$sql="SELECT DISTINCT(f.id) as 'id', f.name as 'firm_name', f.manager as 'manager', f.phone as 'phone', f.address as 'address', f.email as 'email', f.web as 'web', l.name as 'location', lt.name as 'locType', f.registered_on as 'registered_on', f.description as 'description', f.has_pic as 'has_pic' FROM firms f, locations l, location_types lt WHERE f.is_Featured = '1' AND f.is_Featured_end > NOW() AND f.active = '1' AND f.location_id = l.id  AND l.loc_type_id = lt.id ORDER BY RAND(), f.registered_on DESC LIMIT 3 ";
			$conn->setsql($sql);
			$conn->getTableRows();
			$ItmFirms  = $conn->result;
			$numItmFirmss  = $conn->numberrows;

			$na_focus .= '<table style="margin:5px;">';
	        	
	    	for ($i=0;$i<$numItmFirmss;$i++)
	    	{					

	    	//------------- Categories ----------------------------------------------------
	
			$sql="SELECT fc.id as 'firm_category_id', fc.name as 'firm_category_name' FROM firms f, firm_category fc, firms_category_list fcl WHERE fcl.firm_id = f.id AND fcl.category_id = fc.id AND f.id = '".$ItmFirms[$i]['id']."' LIMIT 1 ";
			$conn->setsql($sql);
			$conn->getTableRow();
			$firmFeaturedCats  = $conn->result;
		
			
		   if(is_file("pics/firms/".$ItmFirms[$i]['id']."_logo.jpg")) $picFile= "pics/firms/".$ItmFirms[$i]['id']."_logo.jpg";
		   else $picFile = 'pics/firms/no_logo.png';
		   	
	    	list($width, $height, $type, $attr) = getimagesize($picFile);
			$pic_width_or_height = 80;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
			if (($height) && ($width))	
			{
				if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
				else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
			}

			
				$na_focus .= '<tr>';
				$na_focus .= '<td>';
				
				$na_focus .= '<div class="postBig">';
				$na_focus .= '<div class="detailsDiv" style="float:left;cursor:pointer; width:185px;margin-bottom:10px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';
								
			    $na_focus .= '<h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a href="разгледай-фирма-'.$ItmFirms[$i]['id'].",".myTruncateToCyrilic($ItmFirms[$i]['firm_name'],200,' ','').'.html" style="font-size:12px; font-weight:bold;" >'.$ItmFirms[$i]['firm_name'].'</a></h3>';
			    $na_focus .= '<a href="разгледай-фирма-'.$ItmFirms[$i]['id'].",".myTruncateToCyrilic($ItmFirms[$i]['firm_name'],200,' ','').'.html" style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" >';				    		
			    $na_focus .= '&rarr; '.$ItmFirms[$i]['locType'].' '.$ItmFirms[$i]['location'].' <br />'; 
				$na_focus .= '</a>'; 
		    	$na_focus .= '</div>'; 
		    	$na_focus .= '</div>';
		    	
		    	$na_focus .= '</td>';
    	 		$na_focus .= '<td><a href="разгледай-фирма-'.$ItmFirms[$i]['id'].",".myTruncateToCyrilic($ItmFirms[$i]['firm_name'],200,' ','').'.html" ><div style="border:1px solid #CCCCCC; width:90px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:80).'"  src="'.$picFile.'" /></div></a>';
				$na_focus .= '</td>';
				$na_focus .= '</tr>';  			
    			
		    	
	    	}
	    	
			$na_focus .= '								
			</table>				
		</div>	
		
		
		
		<div id="guidesContentFocus" class="ContBoxFocus" style="display:none;">	';
			
								
			$sql="SELECT g.id as 'id', g.title as 'title', g.has_pic as 'has_pic', g.registered_on as 'registered_on' FROM guides g WHERE g.active = '1' ORDER BY RAND(), g.registered_on DESC LIMIT 5 ";
			$conn->setsql($sql);
			$conn->getTableRows();
			$Itm  = $conn->result;
			$numItms  = $conn->numberrows;
			
			$na_focus .= '<table style="margin:5px;">';
			    
			
			for($i=0;$i<$numItms;$i++)
			{
						
				if ($Itm[$i]['has_pic']=='1')
				{
					$sql="SELECT * FROM guide_pics WHERE guideID='".$Itm[$i]['id']."'";
					$conn->setsql($sql);
					$conn->getTableRows();
					$resultPics[$i]=$conn->result;
					$numPics[$i]=$conn->numberrows;
				}
				
			   if(is_file('pics/guides/'.$resultPics[$i][0]['url_thumb'])) $picFile= 'pics/guides/'.$resultPics[$i][0]['url_thumb'];
			   else $picFile = 'pics/guides/no_photo_thumb.png';
			   	
		
			    list($width, $height, $type, $attr) = getimagesize($picFile);
				$pic_width_or_height = 40;		// tova e viso4inata ili 6iro4inata na snimkata , vzavisimost dali e horizontalna ili vertikalna
				if (($height) && ($width))	
				{
					if($width >= $height)	{$newheight = ($height/$width)*$pic_width_or_height; $newwidth	=	$pic_width_or_height;	}
					else					{$newwidth = ($width/$height)*$pic_width_or_height; $newheight	=	$pic_width_or_height;	}
				}
							
				
			  	   
			    $na_focus .= '<tr>';
				$na_focus .= '<td>';
				
				$na_focus .= '<div class="postBig">';
				$na_focus .= '<div class="detailsDiv" style="float:left;cursor:pointer; width:225px;margin-bottom:10px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">';
								
			    $na_focus .= '<h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; background: #F1F1F1 url(images/gradient_tile.png) repeat 0 -5px;"><a href="разгледай-справочник-'.$Itm[$i]['id'].",".myTruncateToCyrilic($Itm[$i]['title'],200,' ','').'.html" style="font-size:12px; font-weight:bold;" >'.$Itm[$i]['title'].'</a></h3>';
			    $na_focus .= '<a href="разгледай-справочник-'.$Itm[$i]['id'].",".myTruncateToCyrilic($Itm[$i]['title'],200,' ','').'.html" style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" >';				    		
			    $na_focus .= '</a>'; 
		    	$na_focus .= '</div>'; 
		    	$na_focus .= '</div>';
		    	
		    	$na_focus .= '</td>';
		 		$na_focus .= '<td><a href="разгледай-справочник-'.$Itm[$i]['id'].",".myTruncateToCyrilic($Itm[$i]['title'],200,' ','').'.html" ><div id="guideFocusImgDiv_'.$Itm[$i]['id'].'"  onMouseover="this.style.borderColor=\'#0099FF\';" onMouseout="this.style.borderColor=\'#CCCCCC\';" style="border:1px solid #CCCCCC; width:50px; padding:2px; background-color:#F9F9F9;" align="center" ><img width="'.($newwidth?$newwidth:40).'"  src="'.$picFile.'" /></div></a>';
				$na_focus .= '</td>';
				$na_focus .= '</tr>';  	
		  		
			}
			
			$na_focus .= '</table>';
				
			$na_focus .= '</div>		


		
		
			
		
			
		<br style="clear:both;"/>									
	</div>	
		<br style="clear:both;"/>	



						</div>	<br style="clear:both;"/>	
					</div>';
		
	return $na_focus;
	  
	?>