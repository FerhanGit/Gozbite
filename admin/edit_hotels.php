<?php
$pageName = 'edit_doctors';
include_once("inc/dblogin.inc.php");
require_once("classes/Doctor.class.php");

	$page = $_REQUEST['page']; 
	
  
//=========================================================

if (!isset($_SESSION['valid_user']) && $_SESSION['user_kind']!=2) 
{
?>
	<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href='../login.php';</script> 
<?php 
exit;
}


//==========================================================


	
// ------------------СТАРТ на Вкарване на Коментари -----------------------
   
//=========================================================
 if (isset($_REQUEST['insert_comment_btn']))
 {
     
     if ((!empty($_REQUEST['sender_name'])) && (!empty($_REQUEST['sender_email'])) && (!empty($_REQUEST['comment_body'])))
     {
     		 
        if (!isset($_SESSION['valid_user'])) 
        {
        ?>
        	<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href='../login.php';</script> 
        <?php 
        exit;
        }
    	 
    	 	    
        $sql="INSERT INTO doctor_comment SET doctorID='".$_REQUEST['doctorID']."',
        							 	comment_body='".addslashes($_REQUEST['comment_body'])."',
        							 	sender_name='".$_REQUEST['sender_name']."',
        							 	sender_email='".$_REQUEST['sender_email']."',
        								created_on=NOW()    									 							
        	 							";
    	$conn->setsql($sql);
    	$last_ID=$conn->insertDB();
    		 
    		 
    
    	
    	
    }
    else 
    {
        ?>
        	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='edit_doctors.php?doctorID=<?=$_REQUEST['doctorID']?>';</script> 
        <?php 
    }
}
//================== Край на Вкарване на Коментари =======================================


	

	
// ------------------СТАРТ на Редактиране на Коментари -----------------------
   
//=========================================================
 if (isset($_REQUEST['edit_comment_btn']))
 {
     for ($n=0;$n<sizeof($_REQUEST['doctorID']);$n++)
     {
         if ((!empty($_REQUEST['sender_name'][$n])) && (!empty($_REQUEST['sender_email'][$n])) && (!empty($_REQUEST['comment_body'][$n])))
         {
         		 
            if (!isset($_SESSION['valid_user'])) 
            {
            ?>
            	<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href='../login.php';</script> 
            <?php 
            exit;
            }
        	 
        	 	    
             $sql="UPDATE doctor_comment SET  comment_body='".addslashes($_REQUEST['comment_body'][$n])."',
            							 	sender_name='".$_REQUEST['sender_name'][$n]."',
            							 	sender_email='".$_REQUEST['sender_email'][$n]."',
            								created_on=NOW()    	
            								WHERE commentID='".$_REQUEST['commentID'][$n]."'								 							
            	 							";
        	$conn->setsql($sql);
        	$last_ID=$conn->updateDB();
        		 
        		 
        
        	
        	
        }
        else 
        {
            ?>
            	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='edit_doctors.php?doctorID=<?=$_REQUEST['doctorID'][$n]?>';</script> 
            <?php 
        }
    }
}

//=================== Край на Редактиране на Коментари ====================


// ------------------СТАРТ на Итриване на Коментар -----------------------
   
//=========================================================
 if (isset($_REQUEST['deleteComment']))
 {
     
    	 
        if (!isset($_SESSION['valid_user'])) 
        {
        ?>
        	<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href='../login.php';</script> 
        <?php 
        exit;
        }
    	 
    	 	    
        $sql="DELETE FROM doctor_comment WHERE commentID='".$_REQUEST['deleteComment']."'	 ";
    	$conn->setsql($sql);
    	$last_ID=$conn->updateDB();
    		 
?>
<script type="text/javascript">
       window.location.href='edit_doctors.php';
</script> 
	 	 	
<?php
  
}


// ------------------------- Край на коментарите --------------------------	




// -------------------------------------- EDIT ----------------------------------------------------
	
	 
	
	 
if (isset($_REQUEST['edit_btn']))
{
	 
	 	$Doctor = new Doctor($conn);
	 	
	 	$editID=$_REQUEST['edit'];
		$Doctor->id = $editID;
		
		$Doctor->first_name 		= $_REQUEST['first_name'];
		$Doctor->last_name 			= $_REQUEST['last_name'];
		$Doctor->doctor_category	= $_REQUEST['doctor_sub_category']?$_REQUEST['doctor_sub_category']:$_REQUEST['doctor_category'];
		$Doctor->location_id 		= $_REQUEST['cityName'];
		$Doctor->latitude 			= $_REQUEST['latitude'];
		$Doctor->longitude 			= $_REQUEST['longitude'];
		$Doctor->email 				= $_REQUEST['email'];
		$Doctor->addr 				= $_REQUEST['address'];
		$Doctor->phone 				= $_REQUEST['phone'];
		$Doctor->web 				= $_REQUEST['web'];
		$Doctor->related_hospital 	= $_REQUEST['related_hospital'];
		$Doctor->info 				= $_REQUEST['info'];
		$Doctor->has_pic 			= (is_array($_FILES["pics"]))?1:0;
		$Doctor->updated_by			= $_SESSION['userID'];
		$Doctor->updated_on			= 'NOW()';
			
	    if($Doctor->update($_FILES["pics"]))
	   
		//print_r($_FILES);exit;
	
?>
<script type="text/javascript">
       window.location.href='edit_doctors.php?edit='.<?=$_REQUEST['edit']?>;
</script> 
	 	 	
<?php
    
	    
 			
		  	 
// --------------------------------------------------------------------------------
	
} // krai na edit	




// ------------------------- INSERT DOCTOR -----------------------------------------

if ((isset($_REQUEST['insert_btn'])) && ($_REQUEST['first_name']!="") && ($_REQUEST['last_name']!="") && ($_REQUEST['doctor_category']!="") && ($_REQUEST['cityName']!=""))
{
	 	 	 	 	 	 	 	 	 	 	
	 
		$Doctor = new Doctor($conn);
		
		$Doctor->first_name 		= $_REQUEST['first_name'];
		$Doctor->last_name 			= $_REQUEST['last_name'];
		$Doctor->doctor_category	= $_REQUEST['doctor_sub_category']?$_REQUEST['doctor_sub_category']:$_REQUEST['doctor_category'];
		$Doctor->location_id 		= $_REQUEST['cityName'];
		$Doctor->latitude 			= $_REQUEST['latitude'];
		$Doctor->longitude 			= $_REQUEST['longitude'];
		$Doctor->email 				= $_REQUEST['email'];
		$Doctor->addr 				= $_REQUEST['address'];
		$Doctor->phone 				= $_REQUEST['phone'];
		$Doctor->web 				= $_REQUEST['web'];
		$Doctor->related_hospital 	= $_REQUEST['related_hospital'];
		$Doctor->info 				= $_REQUEST['info'];
		$Doctor->has_pic 			= $_REQUEST['has_pic'];
		$Doctor->updated_by			= $_SESSION['userID'];
		$Doctor->updated_on			= 'NOW()';
		$Doctor->registered_on 		= 'NOW()';
			
	    if($Doctor->create($_FILES["pics"]))
	    $doctorID = $Doctor->id;
	    $last_ID = $doctorID;
	    
	   
	    $sql=sprintf("UPDATE users SET cnt_doctor=cnt_doctor+1 WHERE userID= %d ",$_SESSION['userID']);
		$conn->setsql($sql);
		$conn->updateDB();
		
		$_SESSION['cnt_doctor']++;
		 
		 

?>
<script type="text/javascript">
       window.location.href='edit_doctors.php';
</script> 
	 	 	
<?php

}	
// --- Край на INSERT ----------------------
	 

	 


if (isset($_REQUEST['deletePic']))
{
	$Doctor = new Doctor($conn);
	
	$picParts = explode("_",$_REQUEST['deletePic']);
	$editID=$picParts[0];
	$Doctor->id = $editID;
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$Doctor->deletePic($matches[0][0]);	
	
	?>
	
	<script type="text/javascript">
       window.location.href='edit_doctors.php?edit=<?=$editID?>';
	</script> 
	
	<?php

	
}




if (isset($_REQUEST['delete']))
{
	$Doctor = new Doctor($conn);
	
	$deleteID=$_REQUEST['delete'];
	$Doctor->id = $deleteID; 	
    $Doctor->deleteDoctor();	

    $sql=sprintf("UPDATE users SET cnt_doctor=cnt_doctor-1 WHERE userID= %d ",$_SESSION['userID']);
	$conn->setsql($sql);
	$conn->updateDB();
		
	$_SESSION['cnt_doctor']--;
	
	?>
	
	<script type="text/javascript">
       window.location.href='edit_doctors.php';
	</script> 
	
	<?php

	
}



if (isset($_REQUEST['deleteVideo']))
{
	$Doctor = new Doctor($conn);
	$editID=$_REQUEST['deleteVideo'];
	$Doctor->id = $editID;
		
	$Doctor->deleteVideo();	
	
	?>
	
	<script type="text/javascript">
       window.location.href='edit_doctors.php?edit=<?=$editID?>';
	</script> 
	
	<?php

	
}
    
    
// --------------------------- START SEARCH ------------------------------
	
	 if ((isset($_REQUEST['search_btn'])) or (isset($page)) or !empty($_REQUEST['category']))
	 {
	 	
	 		
			if(empty($_REQUEST['doctor_category'])) $_REQUEST['doctor_category'] = $_REQUEST['category']; 
	 		$_REQUEST['doctor_category'] = $_REQUEST['doctor_sub_category']?$_REQUEST['doctor_sub_category']:$_REQUEST['doctor_category'];
	 		
	 		if ($_REQUEST['doctor_category']!="")  
			{
				$sql="SELECT dcl.doctor_id as 'doctor_id' FROM doctors d, doctor_category dc, doctors_category_list dcl WHERE dcl.doctor_id = d.id AND dcl.category_id = dc.id AND (dcl.category_id = '".$_REQUEST['doctor_category']."' OR dcl.category_id IN (SELECT id FROM doctor_category WHERE parentID='".$_REQUEST['doctor_category']."') )";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numDoctorsByCats    = $conn->numberrows;
				$resultDoctorsByCats = $conn->result;
				for($n=0;$n<$numDoctorsByCats;$n++)
				{
					$DoctorsByCatsArr[]=$resultDoctorsByCats[$n]['doctor_id'];
				}
				if(is_array($DoctorsByCatsArr))
				$DoctorsByCats = implode(',',$DoctorsByCatsArr);
				else $DoctorsByCats = '-1';
			}
			
			
	 		$and="";
	 		if ($DoctorsByCats!="")  $and .= " AND d.id IN (".$DoctorsByCats.")";
	 		if ($_REQUEST['first_name']!="")  $and .= " AND d.name='".$_REQUEST['first_name']."'";
	 		if ($_REQUEST['address']!="")  $and .= " AND d.addr='".$_REQUEST['address']."'";
	 		if ($_REQUEST['related_hospital']!="")  $and .= " AND d.related_hospital='".$_REQUEST['related_hospital']."'";
	 		if ($_REQUEST['phone']!="")  $and .= " AND d.phone='".$_REQUEST['phone']."'";
	 		if ($_REQUEST['email']!="")  $and .= " AND d.email='".$_REQUEST['email']."'";
	 		if ($_REQUEST['info']!="")  $and .= " AND d.info LIKE '%".$_REQUEST['info']."%'";
	 		if(is_array($_REQUEST['cityName']))$locations = implode(',',$_REQUEST['cityName']);
	 		else $locations = $_REQUEST['cityName'];
			if (($_REQUEST['cityName']!="") && ($_REQUEST['cityName']!="-1")) $and .= " AND d.location_id IN (".$locations.")";
			if ($_REQUEST['fromDate']!="")  $and .= " AND d.registered_on > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
	 		if ($_REQUEST['toDate']!="")  $and .= " AND d.registered_on < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
	 		
		
			
			
			if ((isset($_REQUEST['orderby'])) && ($_REQUEST['orderby']!=""))
			{
				switch ($_REQUEST['orderby'])
				{
					case 'registered_on': $orderby = 'd.registered_on DESC';
					break;
					
					case 'cityName': $orderby = 'l.name';
					break;
					
					case 'email': $orderby = 'd.email';
					break;
					
					case 'phone': $orderby = 'd.phone';
					break;
					
					case 'address': $orderby = 'd.addr';
					break;
														
					case 'first_name': $orderby = 'd.name';
					break;
					
					case 'related_hospital': $orderby = 'd.related_hospital';
					break;
														
					default : $orderby = 'd.registered_on DESC';
					break;
				}
			}
			else $orderby= 'd.registered_on DESC';
			
	 	    
    $sql="SELECT DISTINCT(d.id) as 'id', d.first_name as 'first_name', d.last_name as 'last_name', d.phone as 'phone', d.addr as 'address', d.email as 'email', d.web as 'web', d.related_hospital as 'related_hospital', l.name as 'location', lt.name as 'locType', d.registered_on as 'registered_on', d.info as 'info', d.has_pic as 'has_pic' FROM doctors d, locations l, location_types lt WHERE  d.location_id = l.id  AND l.loc_type_id = lt.id $and ORDER BY $orderby ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$total=$conn->numberrows;
//----------------- paging ----------------------

	//$pp = "3"; 
	
	$pp = $_REQUEST['limit']!=""?$_REQUEST['limit']:5; 
	
	$numofpages = ceil($total / $pp);
		if ((!isset($_REQUEST['page']) or ($_REQUEST['page']=="")) or (isset($_REQUEST['search_btn']))) 
		{
			$page = 1;
		}
		else
		{
			$page = $_REQUEST['page'];
		}
		$limitvalue = $page * $pp - ($pp);
// -----------------------------------------------      	
	    
	
	$sql="SELECT DISTINCT(d.id) as 'id', d.first_name as 'first_name', d.last_name as 'last_name', d.phone as 'phone', d.addr as 'address', d.email as 'email', d.web as 'web', d.related_hospital as 'related_hospital', l.name as 'location', lt.name as 'locType', d.registered_on as 'registered_on', d.info as 'info', d.has_pic as 'has_pic' FROM doctors d, locations l, location_types lt WHERE  d.location_id = l.id  AND l.loc_type_id = lt.id $and ORDER BY $orderby  LIMIT $limitvalue, $pp";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultDoctors=$conn->result;
	$numDoctors=$conn->numberrows;
	
//------------- Categories ----------------------------------------------------

	for($i=0;$i<$numDoctors;$i++)
	{
		$sql="SELECT dc.id as 'doctor_category_id', dc.name as 'doctor_category_name' FROM doctors d, doctor_category dc, doctors_category_list dcl WHERE dcl.doctor_id = d.id AND dcl.category_id = dc.id AND d.id = '".$resultDoctors[$i]['id']."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numDoctorsCats[$i]  	= $conn->numberrows;
		$resultDoctorsCats[$i]  = $conn->result;
			
	}
	
		$sql="SELECT id, name FROM doctor_category WHERE parentID = '".($_REQUEST['doctor_category']?$_REQUEST['doctor_category']:$_REQUEST['category'])."' ORDER BY name";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultChildCats=$conn->result;
		$numChildCats=$conn->numberrows;
	
} 



else 
{	
	 	    
    $sql="SELECT DISTINCT(d.id) as 'id', d.first_name as 'first_name', d.last_name as 'last_name', d.phone as 'phone', d.addr as 'address', d.email as 'email', d.web as 'web', d.related_hospital as 'related_hospital', l.name as 'location', lt.name as 'locType', d.registered_on as 'registered_on', d.info as 'info', d.has_pic as 'has_pic' FROM doctors d, locations l, location_types lt WHERE  d.location_id = l.id  AND l.loc_type_id = lt.id ORDER BY  d.registered_on DESC";
	$conn->setsql($sql);
	$conn->getTableRows();
	$total=$conn->numberrows;
//----------------- paging ----------------------

	//$pp = "3"; 
	
	$pp = $_REQUEST['limit']!=""?$_REQUEST['limit']:5; 
	
	$numofpages = ceil($total / $pp);
	
		if ((!isset($_REQUEST['page']) or ($_REQUEST['page']=="")) or (isset($_REQUEST['search_btn']))) 
		{
			$page = 1;
		}
		else
		{
			$page = $_REQUEST['page'];
		}
		$limitvalue = $page * $pp - ($pp);
// -----------------------------------------------      	
	    
	
	$sql="SELECT DISTINCT(d.id) as 'id', d.first_name as 'first_name', d.last_name as 'last_name', d.phone as 'phone', d.addr as 'address', d.email as 'email', d.web as 'web', d.related_hospital as 'related_hospital', l.name as 'location', lt.name as 'locType', d.registered_on as 'registered_on', d.info as 'info', d.has_pic as 'has_pic' FROM doctors d, locations l, location_types lt WHERE  d.location_id = l.id  AND l.loc_type_id = lt.id  ORDER BY  d.registered_on DESC LIMIT $limitvalue, $pp";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultDoctors=$conn->result;
	$numDoctors=$conn->numberrows;

//------------- Categories ----------------------------------------------------

	for($i=0;$i<$numDoctors;$i++)
	{
		$sql="SELECT dc.id as 'doctor_category_id', dc.name as 'doctor_category_name' FROM doctors d, doctor_category dc, doctors_category_list dcl WHERE dcl.doctor_id = d.id AND dcl.category_id = dc.id AND d.id = '".$resultDoctors[$i]['id']."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numDoctorsCats[$i]  	= $conn->numberrows;
		$resultDoctorsCats[$i]  = $conn->result;
	}

	
	$sql="SELECT id, name FROM doctor_category WHERE parentID = '".($_REQUEST['doctor_category']?$_REQUEST['doctor_category']:$_REQUEST['category'])."' ORDER BY name";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultChildCats=$conn->result;
	$numChildCats=$conn->numberrows;
	
		
}




?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.:Фери:.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
<script type = "text/javascript" src = "js/marka_ajax.js"></script>
<script type = "text/javascript" src = "js/load_pic_ajax_js.js"></script>
<script type = "text/javascript" src = "js/quarters_ajax_js.js"></script>
<script type = "text/javascript" src = "js/vilages_ajax_js.js"></script>
<script type="text/javascript" src="js/ajaxtabs/ajaxtabs.js"></script>
<link rel="stylesheet" type="text/css" href="js/ajaxtabs/ajaxtabs.css" />
<script type="text/javascript" src="js/functions.js"></script>
<script type = "text/javascript" src = "js/calendar.js"></script>
<script type = "text/javascript" src = "js/calendar_conf.js"></script>

<script src="js/scriptaculous/lib/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous/src/scriptaculous.js" type="text/javascript"></script>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAx_W5ztkhhP0ZnBVvqHy4LhR-oTfWmfyLNOjaVMqwKUYZqLqFwBTalZGPqNiFVYi0ZJW2QPr7Tf1CGA" type="text/javascript"></script>

<script type = "text/javascript" src = "../flash_flv_player/ufo.js"></script>

<script type="text/javascript" src="js/javascripts/effects.js"> </script>
<script type="text/javascript" src="js/javascripts/window.js"> </script>
<script type="text/javascript" src="js/javascripts/window_effects.js"> </script>
<script type="text/javascript" src="js/javascripts/tooltip.js"> </script>

<script type = "text/javascript">
     addCalendar("CalFDate", "Изберете дата", "fromDate", "searchform");
     addCalendar("CalTDate", "Изберете дата", "toDate", "searchform");
</script>


   <link rel="stylesheet" type="text/css" href="js/niftyCornersN.css">
   <link rel="stylesheet" type="text/css" href="js/niftyPrint.css" media="print">
   <script type="text/javascript" src="js/nifty.js"></script>

<link href="themes/default.css" rel="stylesheet" type="text/css" ></link>	
<link href="themes/spread.css" rel="stylesheet" type="text/css" ></link>
<link href="themes/alphacube.css" rel="stylesheet" type="text/css" ></link>
<link href="css/style_green.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 1px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

<script type="text/javascript">
	function getSubCats(mainCat)
	{
		new Ajax.Updater('SubCatsDiv', 'doctors_inc/Ajax_subCats.php?mainCat='+mainCat, {
		  method: 'get',onSuccess: function() {
	                       new Effect.Opacity('SubCatsDiv', {duration: 1.0, from:0.3, to:1.0});
						
	              }
		});
					
						
	}
</script>

</head>
<body style="color:#009900;">

<form name='searchform' action='edit_doctors.php' method='post' enctype='multipart/form-data' >


<script type="text/javascript">
window.onload=function(){
loadMap(42.693516, 23.33246);
if(!NiftyCheck()) 
    return;
Nifty("div#left-2DIV","tr transparent");
//Rounded("div#orange_dqsno","tl","#FFF","#FFB12B");
//Nifty("div#whiteDIV","top");
//Nifty("div#Main_Top_Bottom");
//Rounded("div#BANER_KVADRAT_AND_NEWS","all","#FFF","#F9FFF9");

}
</script>


<script type="text/javascript">

function jumpBlank(selObj) {
  eval("document.location.href='?category="+selObj.options[selObj.selectedIndex].value+"'");
 // selObj.selectedIndex=0;
}


</script>


<div id="CONTAINER" style="margin:0px;">

<div id="LEFT-1" style="float:left; width:160px;margin:0px;">
	  <?php include("doctors_inc/left-1.php");  ?>  
  </div>


  
  <div id="LEFT-2" style="float:left; width:150px;margin:0px;"> 
  	  <?php include("doctors_inc/left-2.php");  ?>  
  </div>
   
   <div id="HEADER" style="height:320px; background-image:url(images/header_bgr_green.gif);background-position:top; background-repeat:repeat-x;">          
        <div id="BANER_KVADRAT_AND_NEWS"style="float:left; width:650px; margin-left:10px; margin-top:15px;">
       <?php  include("doctors_inc/baner-kvadrat.inc.php");  ?>  
     </div>    
   </div>
     
  <div id="CENTER" style="float:left;margin-left:0px;width:660px;">
 	 <div id="MAIN" style="float:left; width:500px; margin-top:0px;">
 	  <div style = "float:left;margin: 10px 10px 10px 10px;width:400px;">
            <label><br /><br />.:: Карта ::.</label><br /><br />
            <?php
		$edit = $_REQUEST['edit'];	
		if (isset($edit))
		{
			$editID=$edit;
			
			$sql="SELECT * FROM doctors WHERE id='".$edit."'";
			$conn->setsql($sql);
			$conn->getTableRow();
			$resultEdit=$conn->result;
			
			$sql="SELECT dc.id as 'doctor_category_id', dc.name as 'doctor_category_name' FROM doctors d, doctor_category dc, doctors_category_list dcl WHERE dcl.doctor_id = d.id AND dcl.category_id = dc.id AND d.id = '".$edit."' ";
			$conn->setsql($sql);
			$conn->getTableRows();
			$numEditCats  	= $conn->numberrows;
			$resultEditCats = $conn->result;
			for($i=0;$i<$numEditCats;$i++)
			{
				$resultEdtCat[] = $resultEditCats[$i]['doctor_category_id'];
			}
			
			
			
		    if ($resultEdit['has_pic']=='1')
			{
				$sql="SELECT * FROM doctor_pics WHERE doctorID='".$edit."'";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultPics=$conn->result;
				$numPics=$conn->numberrows;
			}
			
		}


						$pushpinIcon = "http://largo.bg/img/icon_firmi.gif";
		                $baloonHTML = $resultEdit["first_name"]." ".$resultEdit["last_name"]."<br />".$resultEdit["location"]."<br />".$resultEdit["addr"]."<br />".$resultEdit["phone"]."<br />".$resultEdit["info"];
						require("map_edit_doctors.php");
						
					?>
			   </div>
			   
		 <?php
		 printf("<input type = \"hidden\" name = \"latitude\" id = \"latitude\" value = \"%0.20f\">\n", $resultEdit['latitude']);
		 printf("<input type = \"hidden\" name = \"longitude\" id = \"longitude\" value = \"%0.20f\">\n", $resultEdit['longitude']);
		?>
        <?php  include("doctors_inc/main.php");  ?>  
     </div>
     <div id="RIGHT" style="float:left;margin-left:10px; width:150px;margin-top:20px;">
        <?php include("doctors_inc/right.php");  ?>  
     </div>      
  </div>
  
</div> <!-- END CONTAINER DIV -->


<div id="FOOTER" style=" float:left;width:auto; margin-top:20px;">
	 <?php include("inc/footer.inc.php");  ?>  
</div>

<script> 
  //TooltipManager.addHTML("COLLAPSE_BTN", "collapse_help");
   TooltipManager.addURL("question", "help/collapse_help.html", 200, 300);
</script>   

</form>
</body>
</html>


<?php
// -------------------- funkcii -----------------------------------------



?>