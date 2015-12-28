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




function log_news($nID){
global $conn;
	$sql = sprintf("insert into log_news set news_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $nID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}


function log_post($pID){
global $conn;
	$sql = sprintf("insert into log_posts set post_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $pID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}

function log_bolest($bID){
global $conn;
	$sql = sprintf("insert into log_bolest set bolest_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $bID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}


function log_doktor($dID){
global $conn;
	$sql = sprintf("insert into log_doktor set doktor_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $dID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}




function log_hospitals($hID){
global $conn;
	$sql = sprintf("insert into log_hospitals set hospital_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $hID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}


function log_autohous($ahID){
global $conn;
	$sql = sprintf("insert into log_autohous set autohous_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $ahID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}

function log_autoshop($asID){
global $conn;
	$sql = sprintf("insert into log_autoshop set autoshop_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $asID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}

function log_cars($cID){
global $conn;
	$sql = sprintf("insert into log_cars set car_id=%d, remote_addr='%s', remote_host='%s', date = now(), cnt = 1 on duplicate key update cnt=cnt+1", $cID, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$conn->setSQL($sql);
	$conn->insertDB();

}




function get_hospital_category($cID){
global $conn;
	$sql = sprintf("SELECT name FROM hospital_category WHERE id =%d", $cID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

}

function get_doctor_category($cID){
global $conn;
	$sql = sprintf("SELECT name FROM doctor_category WHERE id =%d", $cID);
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

function get_news_category($cID){
global $conn;
	$sql = sprintf("SELECT name FROM news_category WHERE id =%d", $cID);
	$conn->setSQL($sql);
	$conn->getTableRow();
	return $conn->result['name'];

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



function per_page($link, $offset) {
global $numofpages, $page;
$numofpages = round($numofpages);

$pagesstart = round($page-$offset);
$pagesend = round($page+$offset);


if ($page != "1" && round($numofpages) != "0") {
echo str_replace("%page", 1, '<a href="'.$link.'"><span style="border:thin; width:30px; padding:2px;">Първа</span></a> ');
}

if ($page != "1" && round($numofpages) != "0") {
echo str_replace("%page", round($page-1), '<a href="'.$link.'"><span style="border:thin; width:30px; padding:2px;">Назад</span></a> ');
}

for($i = 1; $i <= $numofpages; $i++) {
if ($pagesstart <= $i && $pagesend >= $i) {
if ($i == $page) {
echo "<b>[$i]</b> ";
}
else {
echo str_replace("%page", "$i", '<a href="'.$link.'">'.$i.'</a> '); 
}
}
}
if (round($numofpages) == "0") {
echo "[$i]";
}

if ($page != round($numofpages) && round($numofpages) != "0") {
echo str_replace("%page", round($page+1), '<a href="'.$link.'"><span style="border:thin; width:30px; padding:2px;">Напред</span></a>');
}

if ($page != round($numofpages) && round($numofpages) != "0") {
echo str_replace("%page", $numofpages, '<a href="'.$link.'"><span style="border:thin; width:30px; padding:2px;">Последна</span></a>');
}

}






function imageDoctorExists($id, $counter, $type) {
   $i = $counter;
   if($type == 1)
      $tmpImg = $id."_".$counter.".jpg";
   elseif($type == 2)
      $tmpImg = $id."_".$counter."_thumb.jpg";


   while(file_exists("../pics/doctors/".$tmpImg)) {
      $i++;
      if($type == 1)
         $tmpImg = $id."_".$i.".jpg";
      elseif($type == 2)
         $tmpImg = $id."_".$i."_thumb.jpg";
   }

   return substr($tmpImg, 0, strrpos($tmpImg,"."));
}



function imageHospitalExists($id, $counter, $type) {
   $i = $counter;
   if($type == 1)
      $tmpImg = $id."_".$counter.".jpg";
   elseif($type == 2)
      $tmpImg = $id."_".$counter."_thumb.jpg";


   while(file_exists("../pics/firms/".$tmpImg)) {
      $i++;
      if($type == 1)
         $tmpImg = $id."_".$i.".jpg";
      elseif($type == 2)
         $tmpImg = $id."_".$i."_thumb.jpg";
   }

   return substr($tmpImg, 0, strrpos($tmpImg,"."));
}



function imageNewsExists($id,  $type) {
   
	if($type == 1)
      $tmpImg = $id.".jpg";
   elseif($type == 2)
      $tmpImg = $id."_thumb.jpg";


   while(file_exists("../pics/news/".$tmpImg)) {
     
      if($type == 1)
         $tmpImg = $id.".jpg";
      elseif($type == 2)
         $tmpImg = $id."_thumb.jpg";
   }

   return substr($tmpImg, 0, strrpos($tmpImg,"."));
}



function imagePostExists($id,  $type) {
  
   if($type == 1)
      $tmpImg = $id.".jpg";
   elseif($type == 2)
      $tmpImg = $id."_thumb.jpg";


   while(file_exists("../pics/posts/".$tmpImg)) {
    
      if($type == 1)
         $tmpImg = $id.".jpg";
      elseif($type == 2)
         $tmpImg = $id."_thumb.jpg";
   }

   return substr($tmpImg, 0, strrpos($tmpImg,"."));
}



function imageBolestExists($id, $counter, $type) {
   $i = $counter;
   if($type == 1)
      $tmpImg = $id."_".$counter.".jpg";
   elseif($type == 2)
      $tmpImg = $id."_".$counter."_thumb.jpg";


   while(file_exists("../pics/bolesti/".$tmpImg)) {
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


function get_ParentHospitalCat($pcID){
global $conn;
	$sql = sprintf("SELECT id,name FROM hospital_category WHERE parentID = 0 AND id = (SELECT parentID FROM hospital_category WHERE id=%d)", $pcID);
	$conn->setSQL($sql);
	$conn->getTableRows();
	return $conn->result[0]['id'];

}

function get_ParentDoctorCat($pcID){
global $conn;
	$sql = sprintf("SELECT id,name FROM doctor_category WHERE parentID = 0 AND id = (SELECT parentID FROM doctor_category WHERE id=%d)", $pcID);
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


function get_ParentNewsCat($pcID){
global $conn;
	$sql = sprintf("SELECT id,name FROM news_category WHERE parentID = 0 AND id = (SELECT parentID FROM news_category WHERE id=%d)", $pcID);
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


function convert_Month_to_Cyr($latinDate){

	 $latinDate = str_replace('January', 'Януари', $latinDate);	
	  $latinDate = str_replace('February', 'Февруари', $latinDate);	
	   $latinDate = str_replace('March', 'Март', $latinDate);	
	    $latinDate = str_replace('April', 'Април', $latinDate);	
	     $latinDate = str_replace('May', 'Май', $latinDate);	
	      $latinDate = str_replace('Juny', 'Юни', $latinDate);	
	       $latinDate = str_replace('July', 'Юли', $latinDate);	
	        $latinDate = str_replace('August', 'Август', $latinDate);	
	         $latinDate = str_replace('September', 'Септември', $latinDate);	
	          $latinDate = str_replace('Octomber', 'Октомври', $latinDate);
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
?>