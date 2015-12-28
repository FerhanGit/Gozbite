<?php

function get_pic_name($val, $dest_dir, $offert_pic_name, $pic_width=300)				// Vra6ta ime na snimkata,koeto se vkarva v DB sled tova
{	
	$ime_pic		=	basename($val);								//originalno ime na snimkata
	$novo_ime		=	$offert_pic_name;								//novo ime(nomer na ofertata) + raz6irenieto na snimkata
	$new_name		=	$dest_dir.$novo_ime;												//promenq staroto ime na novoto
	@copy($val,$new_name);
	//unlink($new_place);
	//@rename($ime_pic,$novo_ime);		
	
	
	if ((getFileExtension($val)	==	"jpeg") or (getFileExtension($val)	==	"jpg") or (getFileExtension($val)	==	"JPEG") or (getFileExtension($val)=="JPG"))
	{
		@$src 		= imagecreatefromjpeg($val);
		@list($width,$height)	=	getimagesize($val);
	
		$newwidth	=	$pic_width;
		if (($height) && ($width))	
		{
			$newheight = ($height/$width)*$pic_width;	
		}
	
		@$tmp 		= imagecreatetruecolor($newwidth,$newheight);
		@imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
	
		$filename 	=	$new_name; 
		@imagejpeg($tmp,$filename,100);

		@imagedestroy($src);
		@imagedestroy($tmp);
		//@rename($ime_pic,$new_ime_pic);
	}
	
	if ((getFileExtension($val) == "GIF") or (getFileExtension($val) == "gif"))
	{
		@$src 		= imagecreatefromgif($val);
		@list($width,$height)	=	getimagesize($val);
	
		$newwidth 	= $pic_width;
		if (($height) && ($width))	
		{	
			$newheight = ($height/$width)*$pic_width;	
		}
		
		@$tmp 		= imagecreatetruecolor($newwidth,$newheight);
		@imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
	
		$filename 	= $new_name; 
		@imagegif($tmp,$filename,100);

		@imagedestroy($src);
		@imagedestroy($tmp);
	}	
	

	return $novo_ime;
	
}



function getSuccessors($locID){
   global $conn;

   $a1 = Array($locID);

   $sql = sprintf("select id from locations where parent_id = %d",$locID);
   $conn->setsql($sql);

   if($conn->getTableRows()){
      foreach($conn->result as $id_array) $a1 = array_merge($a1, getSuccessors($id_array["id"]));
      return $a1;
   }
   return $a1;
}



function log_card($cID){
global $conn;
	$sql = sprintf("insert into log_card set card_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $cID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}

function log_recipe($rID){
global $conn;
	$sql = sprintf("insert into log_recipe set recipe_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $rID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}


function log_drink($dID){
global $conn;
	$sql = sprintf("insert into log_drink set drink_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $dID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}

function log_guide($gID){
global $conn;
	$sql = sprintf("insert into log_guide set guide_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $gID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}



function log_post($pID){
global $conn;
	$sql = sprintf("insert into log_post set post_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $pID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}


function log_firm($fID){
global $conn;
	$sql = sprintf("insert into log_firm set firm_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $fID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}



function log_location($lID){
global $conn;
	$sql = sprintf("insert into log_location set location_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $lID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}


function log_question($qID){
global $conn;
	$sql = sprintf("insert into log_question set question_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $qID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}


function log_bolest($bID){
global $conn;
	$sql = sprintf("insert into log_bolest set bolest_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $bID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}


function log_search($type){
global $conn;
	$sql = sprintf("insert into log_search set type = '%s', cnt_search = 1,  date = now() on duplicate key update cnt_search = cnt_search + 1", $type);
	$conn->setSQL($sql);
	$conn->insertDB();

}


function get_location_nameBylocationID($lID)
{
	global $conn;				
	$sql = sprintf("SELECT name FROM locations WHERE id =%d LIMIT 1", $lID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];
}


function get_bolest_category($cID){
global $conn;
	$sql = sprintf("SELECT name FROM bolest_category WHERE id =%d", $cID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}




function get_bolest_simptom($sID){
global $conn;

	if(is_array($sID))
	{
		$sql = sprintf("SELECT name FROM bolest_simptoms WHERE id =%d", $sID[0]);
	}
	else 
	{
		$sql = sprintf("SELECT name FROM bolest_simptoms WHERE id =%d", $sID);
	}
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}


function get_bolest_nameByBolestID($bID){
global $conn;
	$sql = sprintf("SELECT title FROM bolesti WHERE bolestID = %d", $bID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['title'];
}



function get_bolest_simptomByID($bID){
global $conn;				

	$sql="SELECT bs.id as 'bolest_simptom_id', bs.name as 'name' FROM bolesti b, bolest_simptoms bs, bolesti_simptoms_list bsl WHERE bsl.bolest_id = b.bolestID AND bsl.simptom_id = bs.id AND b.active = '1' AND b.bolestID = '".$bID."' ORDER BY RAND() LIMIT 1 ";
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}


function get_bolest_categoryByID($bID){
global $conn;				
	$sql = sprintf("SELECT bc.name as 'name' FROM bolesti b , bolest_category bc, bolesti_category_list bcl WHERE b.bolestID = bcl.bolest_id AND bcl.category_id = bc.id AND bcl.bolest_id =%d  ORDER BY RAND() LIMIT 1", $bID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}


function get_location_type_and_nameBylocationID($lID)
{
	global $conn;				
	$sql = sprintf("SELECT CONCAT(lt.name,' ',l.name) as 'name' FROM locations l, location_types lt WHERE loc_type_id = lt.id AND l.id = %d LIMIT 1", $lID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];
}


function get_firm_category($cID){
global $conn;
	$sql = sprintf("SELECT name FROM firm_category WHERE id =%d", $cID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}



function get_card_category($cID){
global $conn;
	$sql = sprintf("SELECT name FROM card_category WHERE id =%d", $cID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}


function get_recipe_category($cID){
global $conn;
	$sql = sprintf("SELECT name FROM recipe_category WHERE id =%d", $cID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}


function get_recipe_firm_name_BY_firmID($fID){
global $conn;				
	$sql = sprintf("SELECT name FROM firms WHERE id =%d LIMIT 1", $fID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}



function get_recipe_user_name_BY_userID($uID){
global $conn;				
	$sql = sprintf("SELECT CONCAT(first_name,' ',last_name) as 'name' FROM users WHERE userID =%d LIMIT 1", $uID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}



function get_drink_category($dID){
global $conn;
	$sql = sprintf("SELECT name FROM drink_category WHERE id =%d", $dID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}

function get_drink_firm_name_BY_firmID($fID){
global $conn;				
	$sql = sprintf("SELECT name FROM firms WHERE id =%d LIMIT 1", $fID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}

function get_guide_firm_name_BY_firmID($fID){
global $conn;				
	$sql = sprintf("SELECT name FROM firms WHERE id =%d LIMIT 1", $fID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}



function get_drink_user_name_BY_userID($uID){
global $conn;				
	$sql = sprintf("SELECT CONCAT(first_name,' ',last_name) as 'name' FROM users WHERE userID =%d LIMIT 1", $uID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}



function get_guide_user_name_BY_userID($uID){
global $conn;				
	$sql = sprintf("SELECT CONCAT(first_name,' ',last_name) as 'name' FROM users WHERE userID =%d LIMIT 1", $uID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}

function get_firm_categoryByFirmID($fID){
global $conn;				
	$sql = sprintf("SELECT fc.name as 'name', fc.id as 'id' FROM firms f , firm_category fc, firms_category_list fcl WHERE f.id = fcl.firm_id AND fcl.category_id = fc.id AND fcl.firm_id =%d  ORDER BY RAND() LIMIT 1", $fID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['id'];

}


function get_card_categoryBycardID($cID){
global $conn;				
	$sql = sprintf("SELECT cc.name as 'name', cc.id as 'id' FROM cards c, card_category cc, cards_category_list ccl WHERE c.id = ccl.card_id AND ccl.category_id = cc.id AND ccl.card_id =%d  ORDER BY RAND() LIMIT 1", $cID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['id'];

}


function get_recipe_categoryByRecipeID($rID){
global $conn;				
	$sql = sprintf("SELECT rc.name as 'name', rc.id as 'id' FROM recipes r, recipe_category rc, recipes_category_list rcl WHERE r.id = rcl.recipe_id AND rcl.category_id = rc.id AND rcl.recipe_id =%d  ORDER BY RAND() LIMIT 1", $rID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['id'];

}



function get_user_nameByUserID($uID){
global $conn;
	$sql = sprintf("SELECT CONCAT(first_name,' ',last_name) as 'name' FROM users WHERE userID = %d", $uID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];
}


function get_drink_categoryByDrinkID($dID){
global $conn;				
	$sql = sprintf("SELECT dc.name as 'name', dc.id as 'id' FROM drinks d, drink_category dc, drinks_category_list dcl WHERE d.id = dcl.drink_id AND dcl.category_id = dc.id AND dcl.drink_id =%d  ORDER BY RAND() LIMIT 1", $dID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['id'];

}




function get_post_categoryByPostID($pID){
global $conn;
	$sql = sprintf("SELECT post_category FROM posts WHERE postID =%d", $pID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['post_category'];

}


function get_bolest_categoryByBolestID($bID){
global $conn;				
	$sql = sprintf("SELECT bc.name as 'name', bc.id as 'id' FROM bolesti b , bolest_category bc, bolesti_category_list bcl WHERE b.bolestID = bcl.bolest_id AND bcl.category_id = bc.id AND bcl.bolest_id =%d  ORDER BY RAND() LIMIT 1", $bID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['id'];

}



function get_post_category($cID){
global $conn;
	$sql = sprintf("SELECT name FROM post_category WHERE id =%d", $cID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}




function get_question_category($cID){
global $conn;
	$sql = sprintf("SELECT name FROM question_category WHERE id =%d", $cID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}




function per_page($link, $offset,$numofpages, $page) 
{
	$numofpages = round($numofpages);
	
	$pagesstart = round($page-$offset);
	$pagesend = round($page+$offset);
	
	$return = '';
	
	if ($page != "1" && round($numofpages) != "0") 
	{
		$return .= str_replace("%page", 1, '<a href="'.$link.'"><span style="border:thin; width:30px; padding:2px;">Първа</span></a> ');
	}
	
	if ($page != "1" && round($numofpages) != "0") 
	{
		$return .= str_replace("%page", round($page-1), '<a href="'.$link.'"><span style="border:thin; width:30px; padding:2px;">Назад</span></a> ');
	}
	
	for($i = 1; $i <= $numofpages; $i++) 
	{
		if ($pagesstart <= $i && $pagesend >= $i) 
		{
			if ($i == $page) {
				$return .= "<b>[$i]</b> ";
			}
			else 
			{
				$return .= str_replace("%page", "$i", '<a href="'.$link.'">'.$i.'</a> '); 
			}
		}
	}
	if (round($numofpages) == "0") 
	{
		$return .= "[$i]";
	}
	
	if ($page != round($numofpages) && round($numofpages) != "0") 
	{
		$return .= str_replace("%page", round($page+1), '<a href="'.$link.'"><span style="border:thin; width:30px; padding:2px;">Напред</span></a>');
	}
	
	if ($page != round($numofpages) && round($numofpages) != "0") 
	{
		$return .= str_replace("%page", $numofpages, '<a href="'.$link.'"><span style="border:thin; width:30px; padding:2px;">Последна</span></a>');
	}
	
	return $return;

}


function imageCardExists($id, $counter, $type) {
   $i = $counter;
   if($type == 1)
      $tmpImg = $id."_".$counter.".jpg";
   elseif($type == 2)
      $tmpImg = $id."_".$counter."_thumb.jpg";


   while(file_exists("pics/cards/".$tmpImg)) {
      $i++;
      if($type == 1)
         $tmpImg = $id."_".$i.".jpg";
      elseif($type == 2)
         $tmpImg = $id."_".$i."_thumb.jpg";
   }

   return substr($tmpImg, 0, strrpos($tmpImg,"."));
}



function imageRecipeExists($id, $counter, $type) {
   $i = $counter;
   if($type == 1)
      $tmpImg = $id."_".$counter.".jpg";
   elseif($type == 2)
      $tmpImg = $id."_".$counter."_thumb.jpg";


   while(file_exists("pics/recipes/".$tmpImg)) {
      $i++;
      if($type == 1)
         $tmpImg = $id."_".$i.".jpg";
      elseif($type == 2)
         $tmpImg = $id."_".$i."_thumb.jpg";
   }

   return substr($tmpImg, 0, strrpos($tmpImg,"."));
}




function imageDrinkExists($id, $counter, $type) {
   $i = $counter;
   if($type == 1)
      $tmpImg = $id."_".$counter.".jpg";
   elseif($type == 2)
      $tmpImg = $id."_".$counter."_thumb.jpg";


   while(file_exists("pics/drinks/".$tmpImg)) {
      $i++;
      if($type == 1)
         $tmpImg = $id."_".$i.".jpg";
      elseif($type == 2)
         $tmpImg = $id."_".$i."_thumb.jpg";
   }

   return substr($tmpImg, 0, strrpos($tmpImg,"."));
}




function imageGuideExists($id, $counter, $type) {
   $i = $counter;
   if($type == 1)
      $tmpImg = $id."_".$counter.".jpg";
   elseif($type == 2)
      $tmpImg = $id."_".$counter."_thumb.jpg";


   while(file_exists("pics/guides/".$tmpImg)) {
      $i++;
      if($type == 1)
         $tmpImg = $id."_".$i.".jpg";
      elseif($type == 2)
         $tmpImg = $id."_".$i."_thumb.jpg";
   }

   return substr($tmpImg, 0, strrpos($tmpImg,"."));
}



function imagefirmExists($id, $counter, $type) {
   $i = $counter;
   if($type == 1)
      $tmpImg = $id."_".$counter.".jpg";
   elseif($type == 2)
      $tmpImg = $id."_".$counter."_thumb.jpg";


   while(file_exists("pics/firms/".$tmpImg)) {
      $i++;
      if($type == 1)
         $tmpImg = $id."_".$i.".jpg";
      elseif($type == 2)
         $tmpImg = $id."_".$i."_thumb.jpg";
   }

   return substr($tmpImg, 0, strrpos($tmpImg,"."));
}






function imagelocationExists($id, $counter, $type) {
   $i = $counter;
   if($type == 1)
      $tmpImg = $id."_".$counter.".jpg";
   elseif($type == 2)
      $tmpImg = $id."_".$counter."_thumb.jpg";


   while(file_exists("pics/locations/".$tmpImg)) {
      $i++;
      if($type == 1)
         $tmpImg = $id."_".$i.".jpg";
      elseif($type == 2)
         $tmpImg = $id."_".$i."_thumb.jpg";
   }

   return substr($tmpImg, 0, strrpos($tmpImg,"."));
}





function imagePostExists($id, $type) {
  
   if($type == 1)
      $tmpImg = $id.".jpg";
   elseif($type == 2)
      $tmpImg = $id."_thumb.jpg";


   while(file_exists("pics/posts/".$tmpImg)) {
     
      if($type == 1)
         $tmpImg = $id.".jpg";
      elseif($type == 2)
         $tmpImg = $id."_thumb.jpg";
   }

   return substr($tmpImg, 0, strrpos($tmpImg,"."));
}




function imagePost_MoreExists($id, $counter, $type) {
   $i = $counter;
   if($type == 1)
      $tmpImg = $id."_".$counter.".jpg";
   elseif($type == 2)
      $tmpImg = $id."_".$counter."_thumb.jpg";


   while(file_exists("pics/posts/".$tmpImg)) {
      $i++;
      if($type == 1)
         $tmpImg = $id."_".$i.".jpg";
      elseif($type == 2)
         $tmpImg = $id."_".$i."_thumb.jpg";
   }

   return substr($tmpImg, 0, strrpos($tmpImg,"."));
}




function imageBolestExists($id, $counter, $type) {
   $i = $counter;
   if($type == 1)
      $tmpImg = $id."_".$counter.".jpg";
   elseif($type == 2)
      $tmpImg = $id."_".$counter."_thumb.jpg";


   while(file_exists("pics/bolesti/".$tmpImg)) {
      $i++;
      if($type == 1)
         $tmpImg = $id."_".$i.".jpg";
      elseif($type == 2)
         $tmpImg = $id."_".$i."_thumb.jpg";
   }

   return substr($tmpImg, 0, strrpos($tmpImg,"."));
}



function imageUser_MoreExists($id, $counter, $type) {
   $i = $counter;
   if($type == 1)
      $tmpImg = $id."_".$counter.".jpg";
   elseif($type == 2)
      $tmpImg = $id."_".$counter."_thumb.jpg";


   while(file_exists("pics/users/".$tmpImg)) {
      $i++;
      if($type == 1)
         $tmpImg = $id."_".$i.".jpg";
      elseif($type == 2)
         $tmpImg = $id."_".$i."_thumb.jpg";
   }

   return substr($tmpImg, 0, strrpos($tmpImg,"."));
}




 function errorMsg($err, $getUniqueViolated=0, $is_UniqueViolated=0) {
      if($err) {
         for(reset($err); $key = key($err); next($err)) {
            if($key == 1 && $getUniqueViolated)
               $is_UniqueViolated = 1;
            elseif($key == 'Потребителска грешка')
               $errMsq .= "&#149&nbsp; <b>$key : </b>".$err[$key]."<br>";
            else
               $errMsq .= "&#149&nbsp; <b>$key : </b>".$err[$key]." (<b>обадете се на телефона за поддръжка или изпратете e-mail</b>)<br>";
         }
      }
      return $errMsq;
   }

   
   
   
function getFileExtension($str)  // Vra6ta extension-a na snimkata ,kato mu se podade URL-a !
{

   $i = strrpos($str,".");
   if (!$i) { return ""; }

   $l = strlen($str) - $i;
   $ext = substr($str,$i+1,$l);

   return $ext;

}


function get_ParentfirmCat($pcID){
global $conn;
	$sql = sprintf("SELECT id,name FROM firm_category WHERE parentID = 0 AND id = (SELECT parentID FROM firm_category WHERE id=%d)", $pcID);
	$conn->setSQL($sql);
	$conn->getTableRows();
	return $conn->result[0]['id'];

}


function get_ParentRecipeCat($pcID){
global $conn;
	$sql = sprintf("SELECT id,name FROM recipe_category WHERE parentID = 0 AND id = (SELECT parentID FROM recipe_category WHERE id=%d)", $pcID);
	$conn->setSQL($sql);
	$conn->getTableRows();
	return $conn->result[0]['id'];

}



function get_ParentDrinkCat($pcID){
global $conn;
	$sql = sprintf("SELECT id,name FROM drink_category WHERE parentID = 0 AND id = (SELECT parentID FROM drink_category WHERE id=%d)", $pcID);
	$conn->setSQL($sql);
	$conn->getTableRows();
	return $conn->result[0]['id'];

}




function get_ParentPostCat($pcID){
global $conn;
	$sql = sprintf("SELECT id,name FROM post_category WHERE parentID = 0 AND id = (SELECT parentID FROM post_category WHERE id=%d)", $pcID);
	$conn->setSQL($sql);
	$conn->getTableRows();
	return $conn->result[0]['id'];

}


function get_ParentBolestCat($pcID){
global $conn;
	$sql = sprintf("SELECT id,name FROM bolest_category WHERE parentID = 0 AND id = (SELECT parentID FROM bolest_category WHERE id=%d)", $pcID);
	$conn->setSQL($sql);
	$conn->getTableRows();
	return $conn->result[0]['id'];

}


function get_question_parentID($qID){
global $conn;
	$sql = sprintf("SELECT questionID FROM questions WHERE parentID = 0 AND questionID = (SELECT parentID FROM questions WHERE questionID=%d)", $qID);
	$conn->setSQL($sql);
	$conn->getTableRows();
	return ($conn->result[0]['questionID'] ? $conn->result[0]['questionID'] : $qID);

}

function get_question_titleByQuestionID($qID){
global $conn;				
	$sql = sprintf("SELECT question_title FROM questions WHERE questionID =%d  ORDER BY RAND() LIMIT 1", $qID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['question_title'];

}


function get_kuhnq_nameByKuhnqID($kID){
global $conn;				
	$sql = sprintf("SELECT name FROM kuhni WHERE id =%d  ORDER BY RAND() LIMIT 1", $kID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}


function get_card_nameByCardID($cID){
global $conn;				
	$sql = sprintf("SELECT title FROM cards WHERE id =%d  ORDER BY RAND() LIMIT 1", $cID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['title'];

}



function get_recipe_nameByRecipeID($rID){
global $conn;				
	$sql = sprintf("SELECT title FROM recipes WHERE id =%d  ORDER BY RAND() LIMIT 1", $rID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['title'];

}


function get_drink_nameByDrinkID($dID){
global $conn;				
	$sql = sprintf("SELECT title FROM drinks WHERE id =%d  ORDER BY RAND() LIMIT 1", $dID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['title'];

}


function get_guide_nameByGuideID($gID){
global $conn;				
	$sql = sprintf("SELECT title FROM guides WHERE id =%d  ORDER BY RAND() LIMIT 1", $gID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['title'];

}



function get_firm_nameByFirmID($fID){
global $conn;				
	$sql = sprintf("SELECT name FROM firms WHERE id =%d  ORDER BY RAND() LIMIT 1", $fID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}



function get_post_nameByPostID($pID){
global $conn;				
	$sql = sprintf("SELECT title FROM posts WHERE postID = %d  ORDER BY RAND() LIMIT 1", $pID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['title'];

}



function get_aphorism_nameByAphorismID($aID){
global $conn;
	$sql = sprintf("SELECT body FROM aphorisms WHERE aphorismID = %d", $aID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['body'];
}


function get_survey_nameBySurveyID($sID){
global $conn;
	$sql = sprintf("SELECT body FROM surveys WHERE ID = %d", $sID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['body'];
}


function isVIP($ID){
global $conn;
	$sql = sprintf("SELECT is_VIP FROM packages WHERE id = %d", $ID);
	$conn->setSQL($sql);
	$conn->getTableRows();
	return $conn->result[0]['is_VIP'];
}


function isGold($ID){
global $conn;
	$sql = sprintf("SELECT is_Gold FROM packages WHERE id = %d", $ID);
	$conn->setSQL($sql);
	$conn->getTableRows();
	return $conn->result[0]['is_Gold'];
}


function isSilver($ID){
global $conn;
	$sql = sprintf("SELECT is_Silver FROM packages WHERE id = %d", $ID);
	$conn->setSQL($sql);
	$conn->getTableRows();
	return $conn->result[0]['is_Silver'];
}


function isFeatured($ID){
global $conn;
	$sql = sprintf("SELECT is_Featured FROM packages WHERE id = %d", $ID);
	$conn->setSQL($sql);
	$conn->getTableRows();
	return $conn->result[0]['is_Featured'];
}




function hasPromoRecipeORDrink($userID){
global $conn;

	$sql = sprintf("SELECT pp.id as 'package_id', p.is_Promo_cnt as 'allowed_Promo_cnt' FROM packages p, purchased_packages pp WHERE p.id = pp.package_id AND pp.active = '1' AND %s = '%d'", (($_SESSION['user_type']=='firm')?'pp.firm_id':'pp.user_id'), $userID);
	$conn->setSQL($sql);
	$conn->getTableRows();
	if($conn->numberrows > 0 )
	{
		$cntAllowedPromo = $conn->result[0]['allowed_Promo_cnt'];
		
		$sql = sprintf("SELECT COUNT(IF(r.is_Promo='1',1,null)) as 'used_Promo_Recipes' FROM recipes r WHERE r.active = '1' AND %s = '%d'", (($_SESSION['user_type']=='firm')?'r.firm_id':'r.user_id'), $userID);
		$conn->setSQL($sql);
		$conn->getTableRow();
		if(!empty($conn->result['used_Promo_Recipes']))
		{
			$cntUsedPromoRecipes = $conn->result['used_Promo_Recipes'];
						
		}
		
		
		$sql = sprintf("SELECT COUNT(IF(d.is_Promo='1',1,null)) as 'used_Promo_Drinks' FROM drinks d WHERE d.active = '1' AND %s = '%d'", (($_SESSION['user_type']=='firm')?'d.firm_id':'d.user_id'), $userID);
		$conn->setSQL($sql);
		$conn->getTableRow();
		if(!empty($conn->result['used_Promo_Drinks']))
		{
			$cntUsedPromoTrips = $conn->result['used_Promo_Drinks'];
			
		}
		
		
		if(($cntAllowedPromo - ($cntUsedPromoRecipes + $cntUsedPromoDrinks)) > 0)
		{
			return 1; // allowed more Promo recipes or trips
		}
		else 
		{
			return 0;
		}
	}
	else return 0;

}




function convert_Month_to_Cyr($latinDate){

	 $latinDate = str_replace('January', 'Януари', $latinDate);	
	  $latinDate = str_replace('February', 'Февруари', $latinDate);	
	   $latinDate = str_replace('March', 'Март', $latinDate);	
	    $latinDate = str_replace('April', 'Април', $latinDate);	
	     $latinDate = str_replace('May', 'Май', $latinDate);	
	      $latinDate = str_replace('June', 'Юни', $latinDate);	
	       $latinDate = str_replace('July', 'Юли', $latinDate);	
	        $latinDate = str_replace('August', 'Август', $latinDate);	
	         $latinDate = str_replace('September', 'Септември', $latinDate);	
	          $latinDate = str_replace('October', 'Октомври', $latinDate);
	           $latinDate = str_replace('November', 'Ноември', $latinDate);
	            $latinDate = str_replace('December', 'Декември', $latinDate);
	             $latinDate = str_replace('Monday', 'Понеделник', $latinDate);
	              $latinDate = str_replace('Tuesday', 'Вторник', $latinDate);
	               $latinDate = str_replace('Wednesday', 'Сряда', $latinDate);
	                $latinDate = str_replace('Thursday', 'Четвъртък', $latinDate);	
	          	     $latinDate = str_replace('Friday', 'Петък', $latinDate);	
	          	      $latinDate = str_replace('Saturday', 'Събота', $latinDate);	
	          	       $latinDate = str_replace('Sunday', 'Неделя', $latinDate);	
	          	          

	
	 return $latinDate;
}


function CyrToLatin($name)
{
	 $cyr 	= array('а','б','в','г','д','e','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ь','ю','я','А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь','Ю','Я');
	 $latin = array('a','b','v','g','d','e','dz','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sht','a','y','yu','ya','A','B','V','G','D','E','Dz','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','H','C','Ch','Sh','Sht','A','Y','Yu','Ya');
	 
	 $new_name = $grad_selo = str_replace($cyr, $latin, $name);	
	 return $new_name;
}

 
 function getMonthNum($month_name) 
 { 
 	$MN['January']='01';
 	$MN['February']='02';
 	$MN['March']='03';
 	$MN['April']='04';
 	$MN['May']='05';
 	$MN['June']='06';
 	$MN['July']='07';
 	$MN['August']='08';
 	$MN['September']='09';
 	$MN['October']='10';
 	$MN['November']='11';
 	$MN['December']='12';
 	
 	
 	  return $MN[$month_name]; 
 }

 
 
 function getMonthCyrName($month_name) 
 { 
 	$MN['January']='Януари';
 	$MN['February']='Февруари';
 	$MN['March']='Март';
 	$MN['April']='Април';
 	$MN['May']='Май';
 	$MN['June']='Юни';
 	$MN['July']='Юли';
 	$MN['August']='Август';
 	$MN['September']='Септември';
 	$MN['October']='Октомври';
 	$MN['November']='Ноември';
 	$MN['December']='Декември';
 	
 	
 	  return $MN[$month_name]; 
 }


function BigToSmall($name)
{
	 $cyr 	= array('а','б','в','г','д','e','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ь','ю','я','А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь','Ю','Я');
	 $latin = array('а','б','в','г','д','e','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ь','ю','я','а','б','в','г','д','e','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ь','ю','я');
	 
	 $new_name = $grad_selo = str_replace($cyr, $latin, $name);	
	 return $new_name;
}




 function myTruncate($string, $limit, $break=".", $pad="...") 
 { 
 	// return with no change if string is shorter than $limit 
 	 if(strlen($string) <= $limit) 
 	 return $string;
 	  $string = substr($string, 0, $limit);
 	  if(false !== ($breakpoint = strrpos($string, $break)))
 	 { $string = substr($string, 0, $breakpoint); }
 	  return $string . $pad; 
 }
 
 

 function myTruncateMy($stringGolqm, $promenliva, $break="&") 
 { 
 	// return with no change if string is shorter than $limit 

 	 $string = substr($stringGolqm, strpos($stringGolqm, $promenliva));
 	 if(false !== ($breakpoint = strpos($string, $break)))
 	 { $string = substr($string, (strlen($string)-1), $breakpoint); }
 	  return $string; 
 }
 
 function redirect($url){
    if (!headers_sent()){    //If headers not sent yet... then do php redirect
        header('Location: '.$url); exit;
    }else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}//==== End -- Redirect

function getPageContent($abriviature)
{
	global $conn;
	$conn->setSQL(sprintf("select * from pages where abriviature='%s'",$abriviature));
	$conn->getTableRow();
	return ($conn->numberrows>0) ? $conn->result : false;
}


function getPageTitle($abriviature)
{
	global $conn;
	$conn->setSQL(sprintf("select title from pages where abriviature='%s'",$abriviature));
	$conn->getTableRow();
	return ($conn->numberrows>0) ? $conn->result['title'] : false;
}


function getmicrotime(){
list($usec, $sec) = explode(" ",microtime());
return ((float)$usec + (float)$sec);
} 


function detect_i_explorer()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
}



/* Remve unnecessery tags from given text and return formated text */
function removeBadTags($text)
{
		$text = eregi_replace("<div[^>]*>","", $text);	
     	$text = eregi_replace("</div>","", $text);	
     	$text = eregi_replace("<a[^>]*>","", $text);	
     	$text = eregi_replace("</a>","", $text);	
     	$text = eregi_replace("<span[^>]*>","", $text);	
     	$text = eregi_replace("</span>","", $text);		
     	$text = eregi_replace("<h2[^>]*>","", $text);	
     	$text = eregi_replace("</h2>","", $text);
     	$text = eregi_replace("<p[^>]*>","<p>", $text);
     	$text = eregi_replace("<script[^>]*>","<p>", $text);
     	$text = eregi_replace("</script>","<p>", $text);
     	//$text = eregi_replace("<strong[^>]*>","", $text);	
     	//$text = eregi_replace("</strong>","", $text);	
     	return $text;	
}


function locationTracker($locID=0) {
      global $conn;

      if($locID == 0)
         return '';

      $sql = sprintf("SELECT concat(lt.name,' ', l.name), l.parent_id
                      FROM locations l, location_types lt
                      WHERE l.loc_type_id = lt.id AND l.id = %d", $locID);
      $conn->setsql($sql);
      $conn->getTableRow();
      list($tempLoc, $parent_id) = $conn->result;

      if($parent_id == 0)
         return $tempLoc;

      return locationTracker($parent_id).", ".$tempLoc;
   }

   function advancedLocationTracker($locID=0){
      global $conn, $LocationID, $parentLevel;

      if($locID == 0)
         return '';

      $sql = sprintf("SELECT lt.name, l.parent_id
                      FROM locations l, location_types lt
                      WHERE l.loc_type_id = lt.id AND l.id = %d", $locID);
      $conn->setsql($sql);
      $conn->getTableRow();

      if(!list($loctypeName, $parentLoc_id) = $conn->result)
         return '';

      $sql = sprintf("SELECT id, name FROM locations WHERE parent_id = %d", $parentLoc_id);

      if(isset($LocationID) && ((int)$LocationID > 0))
         $sql .= sprintf(" AND id <> %d", $LocationID);
      $conn->setsql($sql);
      $tempStr = sprintf("<td width=\"5\">%s<br>\n", $loctypeName);
      $tempStr .= sprintf("  <select name = \"loc%d\" onchange = \"parent_id.value=this.value; submitButton.click()\">\n", $locID);
      $tempStr .= sprintf("     <option value = \"0\">Изберете %s</option>\n", $loctypeName);
      while ($conn->fetch()){
         $tempStr .= sprintf("<option value = \"%d\"%s>%s</option>\n", $conn->result["id"], (($conn->result["id"] == $locID) ? " selected" : ""), $conn->result["name"]);
      }
      $tempStr .= "  </select>\n";
      $tempStr .= "</td>\n";

      if($parentLoc_id == 0) { //stignali sme do niwo oblast
         return $tempStr;
      }

      return advancedLocationTracker($parentLoc_id).$tempStr;
   }

   //------------------------------------------------------------
   // връща ID-to na grada/oblastta za wyprosnata lokacia (ako e oblast ili grad wryshta syshtoto ID
   function getCityID($locID) {
      global $conn;

      if(!$locID)
         return 1; //Sofia, iawno ima niakakyw problem, wryshtame SOfia po Default ako wyznikne!!

      $sql = sprintf("SELECT parent_id, loc_type_id FROM locations WHERE id = %d", $locID);
      $conn->setsql($sql);
      $conn->getTableRow();

      if(list($parent_id, $loc_type_id) = $conn->result){
         if((int)$loc_type_id <= 2)
            $result = $locID;
         else
            $result = getCityID($parent_id);
      } else
         $result = 0;

      return $result;
   }

   
   
     
   
   
	function checkForActivePackageBy_firmID_or_userID($fuID, $firm_or_user)
	{
		global $conn;				
		
		$sql = sprintf("SELECT id FROM purchased_packages WHERE %s = %d AND active = '1' ", ($firm_or_user=='firm' ? 'firm_id' : 'user_id'), $fuID);
		$conn->setSQL($sql);
		$conn->getTableRows();
		if($conn->numberrows > 0) return true;
		else return false;
	
	}
	
	
	
	function updateSearchRate($location_id)
	{
		global $conn;
		
		$sql="UPDATE locations SET searchRate = (searchRate + 1) WHERE id = '".$location_id."'";
		$conn->setsql($sql);
		$conn->updateDB();
	}
	
	
	
	

function getPostAutorName($autor_type, $autorID)
{
	global $conn;				
	$sql = sprintf("SELECT %s  as 'name' FROM %s WHERE %s =%d  ORDER BY RAND() LIMIT 1", (($autor_type == "firm")? "name" : "CONCAT(first_name,' ', last_name)"), ($autor_type == "firm" ? "firms" : "users"),($autor_type == "user" ? "userID" : "id"), $autorID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	print $conn->result['name'];
}



   
   
function myTruncateToCyrilic($string, $limit, $break=".", $pad="...")
{
 
	$cyr 	= array('ч','ш','щ','ю','я','а','б','в','г','д','e','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ъ','ь','А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь','Ю','Я');
    $latin = array('ch','sh','sht','yu','ya','a','b','v','g','d','e','dz','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','a','y','A','B','V','G','D','E','Dz','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','H','C','Ch','Sh','Sht','A','Y','Yu','Ya');

	 $new_name = str_replace($latin, $cyr, $string);	
	 $new_name = str_replace(" ","_", $new_name);
	 $new_name = str_replace("%20","_", $new_name);
	 $new_name = str_replace(",","_", $new_name);	
	 $new_name = str_replace("?","_", $new_name);	
	 $new_name = str_replace("!","_", $new_name);	
	 $new_name = str_replace("%","_", $new_name);	
	 $new_name = str_replace("&","_", $new_name);
	 $new_name = str_replace("-","_", $new_name);	
	 $new_name = str_replace("(","_", $new_name);	
	 $new_name = str_replace(")","_", $new_name);	
	 $new_name = str_replace("\\/","_", $new_name);	
	 $new_name = str_replace("/","_", $new_name);	
	 $new_name = str_replace("\\","_", $new_name);
	 $new_name = str_replace("\"","_", $new_name);
	 
	 // return with no change if string is shorter than $limit 
 	 if(strlen($new_name) <= $limit) 
 	 return $new_name;
 	  $new_name = substr($new_name, 0, $limit);
 	  if(false !== ($breakpoint = strrpos($new_name, $break)))
 	 { $new_name = substr($new_name, 0, $breakpoint); }
 	  return $new_name . $pad; 
}


/**
 * ****************************************************************
 *
 * @param string $text
 * @return string - връща текста, но с добавената рекламка към съответните думи.
 * Всяка дума се замества от прилежащата и картинка/банер - това е описано в масива $addwords
 */
function insertADV($text)
{
	/*
	$banner1 = '<img src="pics/inTextAdds/intextImg.png" width="180"/>';
	$banner2 = '<img src="pics/inTextAdds/intextImg.png" width="180"/>';
	$banner3 = '<img src="pics/inTextAdds/intextImg.png" width="180"/>';
	$banner4 = '<img src="pics/inTextAdds/intextImg.png" width="180"/>';
	$banner5 = '<img src="pics/inTextAdds/intextImg.png" width="180"/>';
	$banner6 = '<img src="pics/inTextAdds/intextImg.png" width="180"/>';
	$banner7 = '<img src="pics/inTextAdds/intextImg.png" width="180"/>';
	$banner8 = '<img src="pics/inTextAdds/intextImg.png" width="180"/>';
	$banner9 = '<img src="pics/inTextAdds/intextImg.png" width="180"/>';
	$banner10= '<img src="pics/inTextAdds/intextImg.png" width="180"/>';
	
	$title1 = 'Място за Вашата реклама';
	$title2 = 'Място за Вашата реклама';
	$title3 = 'Място за Вашата реклама';
	$title4 = 'Място за Вашата реклама';
	$title5 = 'Място за Вашата реклама';
	$title6 = 'Място за Вашата реклама';
	$title7 = 'Място за Вашата реклама';
	$title8 = 'Място за Вашата реклама';
	$title9 = 'Място за Вашата реклама';
	$title10= 'Място за Вашата реклама';
	
	$text1 = '';
	$text2 = '';
	$text3 = '';
	$text4 = '';
	$text5 = '';
	$text6 = '';
	$text7 = '';
	$text8 = '';
	$text9 = '';
	$text10 = '';
	
	
	
	$addwords['пече'] 		= array($banner1,$title1,$text1);
	$addwords['Пече'] 		= array($banner1,$title1,$text1);
	$addwords['риба'] 		= array($banner2,$title2,$text2);
	$addwords['Риба'] 		= array($banner2,$title2,$text2);
	$addwords['месо'] 		= array($banner3,$title3,$text3);
	$addwords['Месо'] 		= array($banner3,$title3,$text3);
	$addwords['дивеч'] 		= array($banner4,$title4,$text4);
	$addwords['Дивеч'] 		= array($banner4,$title4,$text4);
	$addwords['ананас'] 	= array($banner5,$title5,$text5);
	$addwords['Ананас'] 	= array($banner5,$title5,$text5);
	$addwords['сладко'] 	= array($banner6,$title6,$text6);
	$addwords['Сладко'] 	= array($banner6,$title6,$text6);
	$addwords['десерт'] 	= array($banner7,$title7,$text7);
	$addwords['Десерт'] 	= array($banner7,$title7,$text7);
	$addwords['джинджифил'] = array($banner8,$title8,$text8);
	$addwords['Джинджифил'] = array($banner8,$title8,$text8);
	$addwords['кимион'] 	= array($banner9,$title9,$text9);
	$addwords['Кимион'] 	= array($banner9,$title9,$text9);
	$addwords['подправк'] 	= array($banner10,$title10,$text10);
	$addwords['Подправк'] 	= array($banner10,$title10,$text10);
	
	     
   
	foreach ($addwords as $addword => $addcontent)
	{
	 	$replace = '<a class="read_more_link" href="javascript:void(0);" title=\'offsetx=[25] offsety=[25] windowlock=[on] cssbody=[dvbdy1Fashion] cssheader=[dvhdr1Fashion] header=[<img src="images/boxover_strelka.png" style="position: relative; top: -10px; left: -10px;" alt="upArrow" />'.$addcontent[1].'] body=['.$addcontent[0].'<br />'.$addcontent[2].']\' style="color:#0099FF; font-weight:bold; border-bottom: 2px groove #0099FF;">'.$addword.'</a>';
		$text = str_ireplace($addword, $replace, $text);	
	}

 	return $text; 
	*/
	
	global $conn;
	
	$sql="SELECT id, word, title, text, image, link, start_date, end_date, active, date_updated FROM in_text_ads WHERE active=1";
	$conn->setsql($sql);
	$conn->getTableRows();
	$inTexAdsCount 	= $conn->numberrows;
	$resultinTexAds	= $conn->result;	
	foreach($resultinTexAds as $inTextAd)
	{
		$replace = '<a class="read_more_link" href="'.$inTextAd['link'].'" title=\'offsetx=[25] offsety=[25] windowlock=[on] cssbody=[dvbdy1Fashion] cssheader=[dvhdr1Fashion] header=[<img src="images/boxover_strelka.png" style="position: relative; top: -10px; left: -10px;" alt="upArrow" />'.$inTextAd['title'].'] body=['.$inTextAd['image'].'<br />'.$inTextAd['text'].']\' style="color:#0099FF; font-weight:bold; border-bottom: 2px groove #0099FF;">'.$inTextAd['word'].'</a>';
		$text = str_ireplace($inTextAd['word'], $replace, $text);	
	}
 	return $text; 
}






/**
 * Checks if class implements given methods and/or properties from a class used as interface.
 *
 * @param string class name
 * @param string interface class name
 * @param bool   check properties
 */
function checkInterface($class, $interface, $property = FALSE)
{
	$methods = get_class_methods($interface);
	$class_methods = get_class_methods($class);
	$implemented_methods = array_intersect($class_methods, $methods);

	sort($methods);
	sort($implemented_methods);

	if ($methods != $implemented_methods)
		return FALSE;

	if ($property)
	{
		$props = array_keys(get_class_vars($interface));
		$class_props = array_keys(get_class_vars($class));
		$implemented_props = array_intersect($class_props, $props);

		sort($props);
		sort($implemented_props);

		if ($props != $implemented_props)
			return FALSE;
	}
	return TRUE;
}


//// Finalizes the page and makes the output
// Params:
//		$body (string): the page contents to pe displayed
//		&$Site (object): the CGenericSite Object
//		$show (boolean): show the page footer
// Returns:
//		NA
function footer($body, $options = array())
{
	global $site;

	// check to see if it should display the footer
	if (is_array($options)){
		
		$body .= '';
	}

	// Finalize the output
	ob_start();	
	$site->start();
	// Print the page
	$contentos1 = ob_get_contents();
	ob_end_clean();		
	$contentos1 .= $body;
	
	ob_start();
	$site->finish();
	$contentos2 = ob_get_contents();
	ob_end_clean();
				
	$body = $contentos1.$contentos2;
	echo $body;
	// stop the remaining script
	exit;
}




function getFirmIDsByCat($firm_category_or_array)
{
	global $conn;
	$FirmsByCatsArr = null;
	
	if(is_array($firm_category_or_array))	
	{
		foreach($firm_category_or_array as $firm_category)
		{			
			$sql="SELECT fcl.firm_id as 'firm_id' FROM firms f, firm_category fc, firms_category_list fcl WHERE fcl.firm_id = f.id AND fcl.category_id = fc.id  AND (fcl.category_id = '".$firm_category['firm_category_id']."' OR fcl.category_id IN (SELECT id FROM firm_category WHERE parentID='".$firm_category['firm_category_id']."') )";
			$conn->setsql($sql);
			$conn->getTableRows();
			$numFirmsByCats    = $conn->numberrows;
			$resultFirmsByCats = $conn->result;
			for($n=0;$n<$numFirmsByCats;$n++)
			{
				$FirmsByCatsArr[]=$resultFirmsByCats[$n]['firm_id'];
			}
		}
	}
	elseif(!is_array($firm_category_or_array))	
	{					
		$sql="SELECT fcl.firm_id as 'firm_id' FROM firms f, firm_category fc, firms_category_list fcl WHERE fcl.firm_id = f.id AND fcl.category_id = fc.id  AND (fcl.category_id = '".$firm_category_or_array."' OR fcl.category_id IN (SELECT id FROM firm_category WHERE parentID='".$firm_category_or_array."') )";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numFirmsByCats    = $conn->numberrows;
		$resultFirmsByCats = $conn->result;
		for($n=0;$n<$numFirmsByCats;$n++)
		{
			$FirmsByCatsArr[]=$resultFirmsByCats[$n]['firm_id'];
		}		
	}
	
			
	return (is_array($FirmsByCatsArr)) ? $FirmsByCatsArr : false;
}



function get_post_tagsByPostID($pID)
{
	global $conn;
	
	//--------------------------- TAGS ------------------------------------------

	$sql="SELECT * FROM post_tags WHERE postID='".$pID."'";
	$conn->setsql($sql);
	$conn->getTableRows();
	$tagsCount 			= $conn->numberrows;
	$resultTags	= $conn->result;	
		
	
	return $resultTags[0]['tags'].',';
					
					
}





function get_recipe_tagsByRecipeID($rID)
{
	global $conn;
	
	//--------------------------- TAGS ------------------------------------------

	$sql="SELECT * FROM recipe_tags WHERE recipeID='".$rID."'";
	$conn->setsql($sql);
	$conn->getTableRows();
	$tagsCount 			= $conn->numberrows;
	$resultTags	= $conn->result;	
		
	
	return $resultTags[0]['tags'].',';
					
					
}






function get_drink_tagsByDrinkID($dID)
{
	global $conn;
	
	//--------------------------- TAGS ------------------------------------------

	$sql="SELECT * FROM drink_tags WHERE drinkID='".$dID."'";
	$conn->setsql($sql);
	$conn->getTableRows();
	$tagsCount 			= $conn->numberrows;
	$resultTags	= $conn->result;	
		
	
	return $resultTags[0]['tags'].',';
					
					
}





function get_guide_tagsByGuideID($gID)
{
	global $conn;
	
	//--------------------------- TAGS ------------------------------------------

	$sql="SELECT * FROM guide_tags WHERE guideID='".$gID."'";
	$conn->setsql($sql);
	$conn->getTableRows();
	$tagsCount 			= $conn->numberrows;
	$resultTags	= $conn->result;	
		
	
	return $resultTags[0]['tags'].',';
					
					
}




function get_firm_tagsByFirmID($fID)
{
	global $conn;
	
	//--------------------------- TAGS ------------------------------------------

	$sql="SELECT * FROM firm_tags WHERE firmID='".$fID."'";
	$conn->setsql($sql);
	$conn->getTableRows();
	$tagsCount 			= $conn->numberrows;
	$resultTags	= $conn->result;	
		
	
	return $resultTags[0]['tags'].',';
					
					
}




function get_bolest_tagsByBolestID($bID)
{
	global $conn;
	
	//--------------------------- TAGS ------------------------------------------

	$sql="SELECT * FROM bolest_tags WHERE bolestID='".$bID."'";
	$conn->setsql($sql);
	$conn->getTableRows();
	$tagsCount 			= $conn->numberrows;
	$resultTags	= $conn->result;	
		
	
	return $resultTags[0]['tags'].',';
					
					
}




function get_drink_product($pID){
global $conn;

	if(is_array($sID))
	{
		$sql = sprintf("SELECT product FROM drinks_products WHERE id =%d", $pID[0]);
	}
	else 
	{
		$sql = sprintf("SELECT product FROM drinks_products WHERE id =%d", $pID);
	}
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['product'];

}


function get_drink_productByID($dID){
global $conn;				

	$sql="SELECT dp.id as 'drink_product_id', dp.product as 'drink_product_name' FROM drinks d, drinks_products dp WHERE dp.drink_id= d.id AND d.id = '".$dID."' ORDER BY RAND() LIMIT 1";
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['drink_product_name'];

}






function get_recipe_product($pID){
global $conn;

	if(is_array($sID))
	{
		$sql = sprintf("SELECT product FROM recipes_products WHERE id =%d", $pID[0]);
	}
	else 
	{
		$sql = sprintf("SELECT product FROM recipes_products WHERE id =%d", $pID);
	}
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['product'];

}



function get_recipe_productByID($rID){
global $conn;				

	$sql="SELECT rp.id as 'recipe_product_id', rp.product as 'recipe_product_name' FROM recipes r, recipes_products rp WHERE rp.recipe_id= r.id AND r.id = '".$rID."' ORDER BY RAND() LIMIT 1";
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['recipe_product_name'];

}


function proceed_citate($text)
{
	 $return_text = $text;
	
	$return_text = str_replace('&lt;цитат&gt;', '<div style="border:1px solid #999999;">', $return_text);	
	$return_text = str_replace('&lt;край на цитата&gt;', '</div><br /><br />', $return_text);	
	
	return $return_text;
}


?>