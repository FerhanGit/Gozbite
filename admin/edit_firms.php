<?php
  error_reporting(E_ALL);
	ini_set('display_errors', 1);
$pageName = 'edit_hospital';
include_once("inc/dblogin.inc.php");
require_once("classes/Hospital.class.php");

	$page = $_REQUEST['page']; 
	

	
//=========================================================

if (!isset($_SESSION['valid_user'])) 
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
    	 
    	 	    
        $sql="INSERT INTO hospital_comment SET firmID='".$_REQUEST['firmID']."',
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
        	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='edit_hospitals.php?firmID=<?=$_REQUEST['firmID']?>';</script> 
        <?php 
    }
}
//================== Край на Вкарване на Коментари =======================================



	
// ------------------СТАРТ на Редактиране на Коментари -----------------------
   
//=========================================================
 if (isset($_REQUEST['edit_comment_btn']))
 {
     for ($n=0;$n<sizeof($_REQUEST['firmID']);$n++)
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
        	 
        	 	    
             $sql="UPDATE hospital_comment SET  comment_body='".addslashes($_REQUEST['comment_body'][$n])."',
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
            	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='edit_hospitals.php?firmID=<?=$_REQUEST['firmID'][$n]?>';</script> 
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
    	 
    	 	    
        $sql="DELETE FROM hospital_comment WHERE commentID='".$_REQUEST['deleteComment']."'	 ";
    	$conn->setsql($sql);
    	$last_ID=$conn->updateDB();
    		 
?>
<script type="text/javascript">
       window.location.href='edit_hospitals.php';
</script> 
	 	 	
<?php
  
}


// ------------------------- Край на коментарите --------------------------	





// -------------------------------------- EDIT ----------------------------------------------------
	 
	 
if (isset($_REQUEST['edit_btn']))
{
 		
	 	$hospital = new Hospital($conn);
	 	
	 	$editID=$_REQUEST['edit'];
		$hospital->id = $editID;
		
		$hospital->username				= $_REQUEST['username'];
		$hospital->password				= md5($_REQUEST['password']);		
		$hospital->name 				= $_REQUEST['firm_name'];
		$hospital->manager 				= $_REQUEST['manager'];
		$hospital->hospital_category	= $_REQUEST['hospital_sub_category']?$_REQUEST['hospital_sub_category']:$_REQUEST['hospital_category'];
		$hospital->location_id 			= $_REQUEST['cityName']?$_REQUEST['cityName']:246;
		$hospital->email 				= $_REQUEST['email'];
		$hospital->address 				= $_REQUEST['address'];
		$hospital->phone 				= $_REQUEST['phone'];
		$hospital->web 					= $_REQUEST['web'];
		$hospital->description			= $_REQUEST['description'];
		$hospital->has_pic 				= (is_array($_FILES["pics"]))?1:0;
		$hospital->updated_by			= $_SESSION['userID'];
		$hospital->updated_on			= 'NOW()';
		$hospital->logo					= $_FILES['pic_logo'];
			
	    if($hospital->update($_FILES["pics"]))
	    $firmID = $hospital->id;
	    $last_ID = $firmID;
		
	   
?>
<script type="text/javascript">
       window.location.href='edit_hospitals.php?edit=<?=$editID?>';
</script> 
	 	 	
<?php	
		  	 
// --------------------------------------------------------------------------------
	
} // krai na edit	




// ------------------------- INSERT hospital -----------------------------------------

if ((isset($_REQUEST['insert_btn'])) && ($_REQUEST['firm_name']!="") && ($_REQUEST['manager']!="") && ($_REQUEST['hospital_category']!="") && ($_REQUEST['cityName']!=""))
{
	 	 	 	 	 	 	 	 	 	 	
	 
		$hospital = new Hospital($conn);
		
		$hospital->name 				= $_REQUEST['firm_name'];
		$hospital->manager 				= $_REQUEST['manager'];
		$hospital->hospital_category	= $_REQUEST['hospital_sub_category']?$_REQUEST['hospital_sub_category']:$_REQUEST['hospital_category'];
		$hospital->location_id 			= $_REQUEST['cityName']?$_REQUEST['cityName']:246;
		$hospital->email 				= $_REQUEST['email'];
		$hospital->address 				= $_REQUEST['address'];
		$hospital->phone 				= $_REQUEST['phone'];
		$hospital->web 					= $_REQUEST['web'];
		$hospital->description			= $_REQUEST['description'];
		$hospital->has_pic 				= (is_array($_FILES["pics"]))?1:0;
		$hospital->updated_by			= $_SESSION['userID'];
		$hospital->updated_on			= 'NOW()';
		$hospital->registered_on 		= 'NOW()';
		$hospital->logo					= $_FILES['pic_logo'];
			
	    if($hospital->create($_FILES["pics"]))
	    $firmID = $hospital->id;
	    $last_ID = $firmID;
	    
	   
	    $sql=sprintf("UPDATE users SET cnt_hospital=cnt_hospital+1 WHERE userID= %d ",$_SESSION['userID']);
		$conn->setsql($sql);
		$conn->updateDB();
	
		$_SESSION['cnt_hospital']++;
		 
		 

?>
<script type="text/javascript">
       window.location.href='edit_hospitals.php';
</script> 
	 	 	
<?php

}	
// --- Край на INSERT ----------------------
	 

	 


if (isset($_REQUEST['deletePic']))
{
	$hospital = new Hospital($conn);
	
	$picParts = explode("_",$_REQUEST['deletePic']);
	$editID=$picParts[0];
	$hospital->id = $editID;
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$hospital->deletePic($matches[0][0]);	
	
	?>
	
	<script type="text/javascript">
       window.location.href='edit_hospitals.php?edit=<?=$editID?>';
	</script> 
	
	<?php

	
}




if (isset($_REQUEST['deleteLogo']))
{
	$hospital = new Hospital($conn);
	
	$hospital->deleteLogo($_REQUEST['deleteLogo']);	
	
	?>
	
	<script type="text/javascript">
       window.location.href='edit_hospitals.php?edit=<?=$editID?>';
	</script> 
	
	<?php

	
}




if (isset($_REQUEST['delete']))
{
	$hospital = new Hospital($conn);
	
	$deleteID=$_REQUEST['delete'];
	$hospital->id = $deleteID; 	
    $hospital->deletehospital();	

    $sql=sprintf("UPDATE users SET cnt_hospital=cnt_hospital-1 WHERE userID= %d ",$_SESSION['userID']);
	$conn->setsql($sql);
	$conn->updateDB();
	
	$_SESSION['cnt_hospital']--;
	
	?>
	
	<script type="text/javascript">
       window.location.href='edit_hospitals.php';
	</script> 
	
	<?php

	
}


    
// --------------------------- START SEARCH ------------------------------

if ((isset($_REQUEST['search_btn'])) or (isset($page)) or !empty($_REQUEST['category']))
{
	
			if(empty($_REQUEST['hospital_category'])) $_REQUEST['hospital_category'] = $_REQUEST['category'];
			$_REQUEST['hospital_category'] = $_REQUEST['hospital_sub_category']?$_REQUEST['hospital_sub_category']:$_REQUEST['hospital_category'];
	 	
			
			if ($_REQUEST['hospital_category']!="")  
			{
				$sql="SELECT h.id as 'hospital_id' FROM hospitals h, hospital_category hc, hospitals_category_list hcl WHERE hcl.hospital_id = h.id AND hcl.category_id = hc.id  AND (hcl.category_id = '".$_REQUEST['hospital_category']."' OR hcl.category_id IN (SELECT id FROM hospital_category WHERE parentID='".$_REQUEST['hospital_category']."') )";
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
	
	 		$and="";
	 		if ($_REQUEST['firm_name']!="")  $and .= " AND h.name='".$_REQUEST['firm_name']."'";
	 		if ($_REQUEST['address']!="")  $and .= " AND h.address='".$_REQUEST['address']."'";
	 		if ($hospitalsByCats!="")  $and .= " AND h.id IN (".$hospitalsByCats.")";
	 		if ($_REQUEST['manager']!="")  $and .= " AND h.manager='".$_REQUEST['manager']."'";
	 		if ($_REQUEST['phone']!="")  $and .= " AND h.phone='".$_REQUEST['phone']."'";
	 		if ($_REQUEST['email']!="")  $and .= " AND h.email='".$_REQUEST['email']."'";
	 		if ($_REQUEST['description']!="")  $and .= " AND h.description LIKE '%".$_REQUEST['description']."%'";
	 		if(is_array($_REQUEST['cityName']))$locations = implode(',',$_REQUEST['cityName']);
	 		else $locations = $_REQUEST['cityName'];
			if (($_REQUEST['cityName']!="") && ($_REQUEST['cityName']!="-1")) $and .= " AND h.location_id IN (".$locations.")";
			if ($_REQUEST['fromDate']!="")  $and .= " AND h.registered_on > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
	 		if ($_REQUEST['toDate']!="")  $and .= " AND h.registered_on < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
	 		
		
			
			
			if ((isset($_REQUEST['orderby'])) && ($_REQUEST['orderby']!=""))
			{
				switch ($_REQUEST['orderby'])
				{
					case 'registered_on': $orderby = 'h.registered_on DESC';
					break;
					
					case 'cityName': $orderby = 'l.name';
					break;
					
					case 'email': $orderby = 'h.email';
					break;
					
					case 'phone': $orderby = 'h.phone';
					break;
					
					case 'address': $orderby = 'h.address';
					break;
														
					case 'firm_name': $orderby = 'h.name';
					break;
					
					case 'manager': $orderby = 'h.manager';
					break;
														
					default : $orderby = 'h.registered_on DESC';
					break;
				}
			}
			else $orderby= 'h.registered_on DESC';
			
	 	    
    $sql="SELECT h.id as 'id', h.name as 'firm_name', h.phone as 'phone', h.address as 'address', h.email as 'email', h.manager as 'manager', l.name as 'location', lt.name as 'locType', h.registered_on as 'registered_on', h.description as 'description', h.has_pic as 'has_pic' FROM hospitals h, locations l, location_types lt WHERE h.location_id = l.id  AND l.loc_type_id = lt.id $and ORDER BY $orderby ";
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
	    
	
	$sql="SELECT h.id as 'id', h.name as 'firm_name', h.phone as 'phone', h.address as 'address', h.email as 'email', h.manager as 'manager', l.name as 'location', lt.name as 'locType', h.registered_on as 'registered_on', h.description as 'description', h.has_pic as 'has_pic' FROM hospitals h, locations l, location_types lt WHERE  h.location_id = l.id  AND l.loc_type_id = lt.id $and ORDER BY $orderby  LIMIT $limitvalue, $pp";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultHospital=$conn->result;
	$numHospital=$conn->numberrows;

	
	//------------- Categories ----------------------------------------------------
	for($i=0;$i<$numHospital;$i++)
	{
		$sql="SELECT hc.id as 'hospital_category_id', hc.name as 'hospital_category_name' FROM hospitals h, hospital_category hc, hospitals_category_list hcl WHERE hcl.hospital_id = h.id AND hcl.category_id = hc.id AND h.id = '".$resultHospital[$i]['id']."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numHospitalCats[$i]  	= $conn->numberrows;
		$resultHospitalCats[$i] = $conn->result;
	}
	
	
	$sql="SELECT id, name FROM hospital_category WHERE parentID = '".($_REQUEST['hospital_category']?$_REQUEST['hospital_category']:$_REQUEST['category'])."' ORDER BY name";
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


<link rel="stylesheet" type="text/css" href="css/lightview.css" />
<script type='text/javascript' src='js/lightview.js'></script>
<script type='text/javascript' src='js/starbox.js'></script>
<link rel="stylesheet" type="text/css" href="css/starbox.css" />

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
		new Ajax.Updater('SubCatsDiv', 'hospitals_inc/Ajax_subCats.php?mainCat='+mainCat, {
		  method: 'get',onSuccess: function() {
	                       new Effect.Opacity('SubCatsDiv', {duration: 1.0, from:0.3, to:1.0});
						
	              }
		});
					
						
	}
</script>

</head>
<body style="color:#009900;">

<form name='searchform' action='edit_hospitals.php' method='post' enctype='multipart/form-data' >


<script type="text/javascript">
window.onload=function(){
if(!NiftyCheck()) 
    return;
Rounded("div#left-2DIV","tr","#E0E0E0","#FFB12B");
//Rounded("div#orange_dqsno","tl","#FFF","#FFB12B");
//Rounded("div#whiteDIV","top","#FFF","#F5F5F5");
//Rounded("div#Main_Top_Bottom","bottom","#FFF","#F5F5F5");
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
	  <?php include("hospitals_inc/left-1.php");  ?>  
  </div>


  
  <div id="LEFT-2" style="float:left; width:150px;margin:0px;"> 
  	  <?php include("hospitals_inc/left-2.php");  ?>  
  </div>
   
 <div id="HEADER" style="height:320px; background-image:url(images/header_bgr_<?=$theme_color?>.gif);background-position:top; background-repeat:repeat-x;">          
          <div id="BANER_KVADRAT_AND_NEWS"style="float:left; width:650px; margin-left:10px; margin-top:15px;">
       <?php  include("hospitals_inc/baner-kvadrat.inc.php");  ?>  
     </div>
  </div>
    
   <div id="CENTER" style="float:left;margin-left:0px;width:660px;"> 	
     <div id="MAIN" style="float:left; width:500px; margin-top:0px;">
        <?php  include("hospitals_inc/main.php");  ?>  
     </div>
     <div id="RIGHT" style="float:left;margin-left:10px; width:150px;margin-top:20px;">
        <?php include("hospitals_inc/right.php");  ?>  
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