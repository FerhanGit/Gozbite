<?php
$pageName = 'edit_lekarstva';
	
include_once("inc/dblogin.inc.php");
$page = $_REQUEST['page']; 
   
require_once("classes/Lekarstvo.class.php");

	
	
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
    	 
    	 	    
        $sql="INSERT INTO lekarstvo_comment SET lekarstvoID='".$_REQUEST['lekarstvoID']."',
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
        	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='edit_lekarstva.php?lekarstvoID=<?=$_REQUEST['lekarstvoID']?>';</script> 
        <?php 
    }
}
//================== Край на Вкарване на Коментари =======================================



	
// ------------------СТАРТ на Редактиране на Коментари -----------------------
   
//=========================================================
 if (isset($_REQUEST['edit_comment_btn']))
 {
     for ($n=0;$n<sizeof($_REQUEST['lekarstvoID']);$n++)
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
        	 
        	 	    
             $sql="UPDATE lekarstvo_comment SET  comment_body='".addslashes($_REQUEST['comment_body'][$n])."',
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
            	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='edit_lekarstva.php?lekarstvoID=<?=$_REQUEST['lekarstvoID'][$n]?>';</script> 
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
    	 
    	 	    
        $sql="DELETE FROM lekarstvo_comment WHERE commentID='".$_REQUEST['deleteComment']."'	 ";
    	$conn->setsql($sql);
    	$last_ID=$conn->updateDB();
    		 
?>
<script type="text/javascript">
       window.location.href='edit_lekarstva.php';
</script> 
	 	 	
<?php
  
}


// ------------------------- Край на коментарите --------------------------	





// -------------------------------------- EDIT ----------------------------------------------------
	 
		 
if (isset($_REQUEST['edit_btn']))
{
		
	
	 	$lekarstvo = new lekarstvo($conn);
	 	
	 	$editID=$_REQUEST['edit'];
		$lekarstvo->id = $editID;
		
		$lekarstvo->title 				= $_REQUEST['lekarstvo_title'];
		$lekarstvo->body 				= $_REQUEST['lekarstvo_body'];
		$lekarstvo->autor_type 			= $_SESSION['user_type'];
		$lekarstvo->autor 				= $_SESSION['userID'];
		$lekarstvo->source 				= $_REQUEST['lekarstvo_source'];
		$lekarstvo->lekarstvo_category	= $_REQUEST['lekarstvo_sub_category']?$_REQUEST['lekarstvo_sub_category']:$_REQUEST['lekarstvo_category'];
		$lekarstvo->lekarstvo_simptom	= $_REQUEST['lekarstvo_simptom'];
		$lekarstvo->has_pic 			= (is_array($_FILES["pics"]))?1:0;
		$lekarstvo->date				= 'NOW()';
	
	    if($lekarstvo->update($_FILES["pics"]))
	    $lekarstvoID = $lekarstvo->id;
	    $last_ID  = $lekarstvoID;
		
	 	
	 	 
	    
 ?>
<script type="text/javascript">
       window.location.href='edit_lekarstva.php?edit=<?=$last_ID?>';
</script> 
	 	 	
<?php
			
		  	 
// --------------------------------------------------------------------------------
	
} // krai na edit	




// ------------------------- INSERT lekarstvo -----------------------------------------

if ((isset($_REQUEST['insert_btn'])) && ($_REQUEST['lekarstvo_title']!="") && ($_REQUEST['lekarstvo_body']!="") && ($_REQUEST['lekarstvo_category']!="") )
{
	 	 	 	 	 	 	 	 	 	 	
	 
		$lekarstvo = new lekarstvo($conn);
		
		$lekarstvo->title 				= $_REQUEST['lekarstvo_title'];
		$lekarstvo->body 				= $_REQUEST['lekarstvo_body'];
		$lekarstvo->autor_type 			= $_SESSION['user_type'];
		$lekarstvo->autor 				= $_SESSION['userID'];
		$lekarstvo->source 				= $_REQUEST['lekarstvo_source'];
		$lekarstvo->lekarstvo_category	= $_REQUEST['lekarstvo_sub_category']?$_REQUEST['lekarstvo_sub_category']:$_REQUEST['lekarstvo_category'];
		$lekarstvo->lekarstvo_simptom	= $_REQUEST['lekarstvo_simptom'];
		$lekarstvo->has_pic 			= (is_array($_FILES["pics"]))?1:0;
		$lekarstvo->date				= 'NOW()';

		if($lekarstvo->create($_FILES["pics"]))
	    $lekarstvoID = $lekarstvo->id;
	    $last_ID  = $lekarstvoID;
 
	

?>
<script type="text/javascript">
       window.location.href='edit_lekarstva.php?edit=<?=$last_ID?>';
</script> 
	 	 	
<?php

}	
// --- Край на INSERT ----------------------
	 

	 


if (isset($_REQUEST['deletePic']))
{
	$lekarstvo = new lekarstvo($conn);
	
	$picParts = explode("_",$_REQUEST['deletePic']);
	$editID=$picParts[0];
	$lekarstvo->id = $editID;
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$lekarstvo->deletePic($matches[0][0]);	
	
	?>
	
	<script type="text/javascript">
       window.location.href='edit_lekarstva.php?edit=<?=$editID?>';
	</script> 
	
	<?php

	
}




if (isset($_REQUEST['delete']))
{
	$lekarstvo = new lekarstvo($conn);
	
	$deleteID=$_REQUEST['delete'];
	$lekarstvo->id = $deleteID; 	
    $lekarstvo->deletelekarstvo();	

    $sql=sprintf("UPDATE users SET cnt_lekarstva=cnt_lekarstva-1 WHERE userID= %d ",$_SESSION['userID']);
	$conn->setsql($sql);
	$conn->updateDB();
	
	$_SESSION['cnt_lekarstva']--;
	
	?>
	
	<script type="text/javascript">
       window.location.href='edit_lekarstva.php';
	</script> 
	
	<?php

	
}



    
// --------------------------- START SEARCH ------------------------------

	
if ((isset($_REQUEST['search_btn'])) or (isset($page)) or (!empty($_REQUEST['category'])))
{
		
		if(empty($_REQUEST['lekarstvo_category'])) $_REQUEST['lekarstvo_category'] = $_REQUEST['category'];
		$_REQUEST['lekarstvo_category'] = $_REQUEST['lekarstvo_sub_category']?$_REQUEST['lekarstvo_sub_category']:$_REQUEST['lekarstvo_category'];
	 		

		if ($_REQUEST['lekarstvo_category']!="")  
			{
				
				$sql="SELECT lcl.lekarstvo_id as 'lekarstvo_id' FROM lekarstva l, lekarstvo_category lc, lekarstva_category_list lcl WHERE lcl.lekarstvo_id = l.lekarstvoID AND lcl.category_id = lc.id AND (lcl.category_id = '".$_REQUEST['lekarstvo_category']."' OR lcl.category_id IN (SELECT id FROM lekarstvo_category WHERE parentID='".$_REQUEST['lekarstvo_category']."') )";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numlekarstvaByCats    = $conn->numberrows;
				$resultlekarstvaByCats = $conn->result;
				for($n=0;$n<$numlekarstvaByCats;$n++)
				{
					$lekarstvaByCatsArr[]=$resultlekarstvaByCats[$n]['lekarstvo_id'];
				}
				if(is_array($lekarstvaByCatsArr))
				$lekarstvaByCats = implode(',',$lekarstvaByCatsArr);
				else $lekarstvaByCats = -1;
			}
			
			
			
			if (is_array($_REQUEST['lekarstvo_simptom']) && count($_REQUEST['lekarstvo_simptom'])>0 ) 
			{
				$sql="SELECT lsl.lekarstvo_id as 'lekarstvo_id' FROM lekarstva l, lekarstvo_simptoms ls, lekarstva_simptoms_list lsl WHERE lsl.lekarstvo_id = l.lekarstvoID AND lsl.simptom_id = ls.id AND lsl.simptom_id IN (".implode(',',$_REQUEST['lekarstvo_simptom']).")";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numlekarstvaBySimptoms    = $conn->numberrows;
				$resultlekarstvaBySimptoms = $conn->result;
				for($n=0;$n<$numlekarstvaBySimptoms;$n++)
				{
					$lekarstvaBySimptomsArr[]=$resultlekarstvaBySimptoms[$n]['lekarstvo_id'];
				}
				if(is_array($lekarstvaBySimptomsArr))
				$lekarstvaBySimptoms = implode(',',$lekarstvaBySimptomsArr);
				else $lekarstvaBySimptoms = -1;
			}
			elseif (!is_array($_REQUEST['lekarstvo_simptom']) && $_REQUEST['lekarstvo_simptom']<>'') 
			{
				$sql="SELECT lsl.lekarstvo_id as 'lekarstvo_id' FROM lekarstva l, lekarstvo_simptoms ls, lekarstva_simptoms_list lsl WHERE lsl.lekarstvo_id = l.lekarstvoID AND lsl.simptom_id = ls.id AND lsl.simptom_id IN (".$_REQUEST['lekarstvo_simptom'].")";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numlekarstvaBySimptoms    = $conn->numberrows;
				$resultlekarstvaBySimptoms = $conn->result;
				for($n=0;$n<$numlekarstvaBySimptoms;$n++)
				{
					$lekarstvaBySimptomsArr[]=$resultlekarstvaBySimptoms[$n]['lekarstvo_id'];
				}
				if(is_array($lekarstvaBySimptomsArr))
				$lekarstvaBySimptoms = implode(',',$lekarstvaBySimptomsArr);
				else $lekarstvaBySimptoms = -1;
			}
			
			
			
			
	 		 $and="";
	 		if ($lekarstvaByCats!="")  $and .= " AND l.lekarstvoID IN (".$lekarstvaByCats.")";
	 		if ($lekarstvaBySimptoms!="")  $and .= " AND l.lekarstvoID IN (".$lekarstvaBySimptoms.")"; 		
	 		if ($_REQUEST['lekarstvo_title']!="")  $and .= " AND l.title LIKE '%".$_REQUEST['lekarstvo_title']."%'";
	 		if ($_REQUEST['lekarstvo_body']!="")  $and .= " AND l.body LIKE '%".$_REQUEST['lekarstvo_body']."%'";
	 		if ($_REQUEST['autor_type']!="")  $and .= " AND l.autor_type LIKE '%".$_REQUEST['autor_type']."%'"; 
	 		if ($_REQUEST['autor']!="")  $and .= " AND l.autor == '".$_REQUEST['autor']."'"; 
	 		if ($_REQUEST['lekarstvo_source']!="")  $and .= " AND l.source LIKE '%".$_REQUEST['lekarstvo_source']."%'"; 
	 		if ($_REQUEST['lekarstvo_autor']!="")  $and .= " AND l.autor LIKE '%".$_REQUEST['lekarstvo_autor']."%'"; 	 		
	 		if ($_REQUEST['fromDate']!="")  $and .= " AND l.date > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
	 		if ($_REQUEST['toDate']!="")  $and .= " AND l.date < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
	 		
	 		if ($_REQUEST['picCheck']!="")  $and .= " AND l.has_pic = '1' "; 
	 		
				
			
			
			if ((isset($_REQUEST['orderby'])) && ($_REQUEST['orderby']!=""))
			{
				switch ($_REQUEST['orderby'])
				{
					
					
					case 'date': $orderby = 'l.date DESC';
					break;
										
					case 'autor_type': $orderby = 'l.autor_type';
					break;
					
					case 'autor': $orderby = 'l.autor';
					break;
					
					case 'lekarstvo_source': $orderby = 'l.source';
					break;
					
					case 'lekarstvo_title': $orderby = 'l.title';
					break;
					
					case 'lekarstvo_body': $orderby = 'l.body';
					break;
					
					case 'lekarstvo_autor': $orderby = 'l.autor';
					break;
							
														
					default : $orderby = 'l.date DESC';
					break;
				}
			}
			else $orderby= 'l.date DESC';
			
	 	    
    $sql="SELECT l.lekarstvoID as 'lekarstvoID', l.date as 'date', l.title as 'title', l.body as 'body', l.has_pic as 'has_pic', l.autor_type as 'autor_type', l.autor as 'autor', l.source as 'source' FROM lekarstva l WHERE 1=1 $and ORDER BY $orderby";
	$conn->setsql($sql);
	$conn->getTableRows();
	$total=$conn->numberrows;
				
//----------------- paging ----------------------

	//$pp = "3"; 
	
	$pp = $_REQUEST['limit']!=""?$_REQUEST['limit']:3; 
	
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
	    
	$sql="SELECT l.lekarstvoID as 'lekarstvoID', l.date as 'date', l.title as 'title', l.body as 'body',l.has_pic as 'has_pic', l.autor_type as 'autor_type', l.autor as 'autor', l.source as 'source' FROM lekarstva l WHERE 1=1 $and ORDER BY $orderby LIMIT $limitvalue,$pp";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultlekarstva=$conn->result;
	$numlekarstva=$conn->numberrows;
	
	$sql="SELECT id, name FROM lekarstvo_category WHERE parentID = '".($_REQUEST['lekarstvo_category']?$_REQUEST['lekarstvo_category']:$_REQUEST['category'])."' ORDER BY name";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultChildCats=$conn->result;
	$numChildCats=$conn->numberrows;

	
} 

else 
{
	$and='';  
	  
	$sql="SELECT l.lekarstvoID as 'lekarstvoID', l.date as 'date', l.title as 'title', l.body as 'body', l.has_pic as 'has_pic', l.autor_type as 'autor_type', l.autor as 'autor', l.source as 'source' FROM lekarstva l WHERE 1=1 $and ORDER BY l.date DESC LIMIT 5";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultlekarstva=$conn->result;
	$numlekarstva=$conn->numberrows;

	$sql="SELECT id, name FROM lekarstvo_category WHERE parentID = '".($_REQUEST['lekarstvo_category']?$_REQUEST['lekarstvo_category']:$_REQUEST['category'])."' ORDER BY name";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultChildCats=$conn->result;
	$numChildCats=$conn->numberrows;
}


//-----------------------------------------------------------------
	for($i=0;$i<$numlekarstva;$i++)
	{
	
	// ============================= CATEGORIES =========================================

		$sql="SELECT lc.id as 'lekarstvo_category_id', lc.name as 'lekarstvo_category_name' FROM lekarstva l, lekarstvo_category lc, lekarstva_category_list lcl WHERE lcl.lekarstvo_id = l.lekarstvoID AND lcl.category_id = lc.id AND l.lekarstvoID = '".$resultlekarstva[$i]['lekarstvoID']."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numlekarstvoCats[$i]  	= $conn->numberrows;
		$resultlekarstvoCats[$i] 	= $conn->result;
		
		
	// =============================== SIMPTOMS ========================================	
	
		$sql="SELECT ls.id as 'lekarstvo_simptom_id', ls.name as 'lekarstvo_simptom_name' FROM lekarstva l, lekarstvo_simptoms ls, lekarstva_simptoms_list lsl WHERE lsl.lekarstvo_id = l.lekarstvoID AND lsl.simptom_id = ls.id AND l.lekarstvoID = '".$resultlekarstva[$i]['lekarstvoID']."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numlekarstvoSimptoms[$i]  	= $conn->numberrows;
		$resultlekarstvoSimptoms[$i]   = $conn->result;
	
	}
	
	


// ----------------- DEL PIC ---------------------------------------

if (isset($_REQUEST['deletePic']) && !empty($_REQUEST['deletePic']))
{ 
		
			$fileToDelete = "../pics/lekarstva/".$_REQUEST['deletePic'];
			$thumbToDelete = "../pics/lekarstva/".$_REQUEST['edit'].'_thumb.jpg';
			
			
				
 		
			$sql2="DELETE FROM lekarstva_pics WHERE url_big='".$_REQUEST['deletePic']."'";	
			$conn->setsql($sql2); 			
			$conn->updateDB();

			$sql2="SELECT * FROM lekarstva_pics WHERE lekarstvoID='".$_REQUEST['edit']."'";	
			$conn->setsql($sql2); 			
			$conn->getTableRows();
			if($conn->numberrows < 1)	
			{
				$sql2="UPDATE lekarstva SET has_pic=0 WHERE lekarstvoID='".$_REQUEST['edit']."'";	
				$conn->setsql($sql2); 			
				$conn->updateDB();
			}
 		
			
			
			
			unlink($fileToDelete);
			unlink($thumbToDelete);
		

?>
<script type="text/javascript">
       window.location.href='edit_lekarstva.php?edit=<?=$_REQUEST['edit']?>';
</script> 
	 	 	
<?php
} 
// --------------------- END DEL PIC --------------------------------------------------------




?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.:Фери:.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /><script type = "text/javascript" src = "js/marka_ajax.js"></script>

<script type = "text/javascript" src = "js/load_pic_ajax_js.js"></script>
<script type = "text/javascript" src = "js/quarters_ajax_js.js"></script>
<script type = "text/javascript" src = "js/vilages_ajax_js.js"></script>
<script type="text/javascript" src="js/functions.js"></script>

<script src="js/scriptaculous/lib/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous/src/scriptaculous.js" type="text/javascript"></script>

<script type = "text/javascript" src = "js/calendar.js"></script>
<script type = "text/javascript" src = "js/calendar_conf.js"></script>
<script type = "text/javascript">
     addCalendar("CalFDate", "Изберете дата", "fromDate", "itemform");
     addCalendar("CalTDate", "Изберете дата", "toDate", "itemform");
</script>


   <link rel="stylesheet" type="text/css" href="js/niftyCornersN.css">
   <link rel="stylesheet" type="text/css" href="js/niftyPrint.css" media="print">
   <script type="text/javascript" src="js/nifty.js"></script>
   
   
<script type="text/javascript" src="js/ajaxtals/ajaxtals.js"></script>
<link rel="stylesheet" type="text/css" href="js/ajaxtals/ajaxtals.css" />

<script type="text/javascript" src="js/javascripts/window.js"> </script>
<script type="text/javascript" src="js/javascripts/window_effects.js"> </script>
<script type="text/javascript" src="js/javascripts/tooltip.js"> </script>
<link href="themes/default.css" rel="stylesheet" type="text/css" ></link>	
<link href="themes/spread.css" rel="stylesheet" type="text/css" ></link>
<link href="themes/alphacube.css" rel="stylesheet" type="text/css" ></link>

<link href="css/style_red.css" rel="stylesheet" type="text/css" />
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
	function getSulcats(mainCat)
	{
		new Ajax.Updater('SulcatsDiv', 'lekarstva_inc/Ajax_sulcats.php?mainCat='+mainCat, {
		  method: 'get',onSuccess: function() {
	                       new Effect.Opacity('SulcatsDiv', {duration: 1.0, from:0.3, to:1.0});
						
	              }
		});
					
						
	}
</script>

</head>
<body>


<form name='searchform' action='' method='post' enctype='multipart/form-data' >


<script type="text/javascript">
window.onload=function(){
Nifty("div#left-2DIV","tr transparent");
//Rounded("div#orange_dqsno","tl","#FFF","#FFB12B");
Nifty("div#whiteDIV","top");
Nifty("div#Main_Top_Bottom");
//Rounded("div#BANER_KVADRAT_AND_NEWS","all","#FFF","#F9FFF9");
}
</script>

<script type="text/javascript">		
new Ajax.PeriodicalUpdater('user_info_test_div', 'test_Proto_Ajax.php', {
  method: 'get', frequency: 3, decay: 2
});
</script>




<script type="text/javascript">
function jumpBlank(selObj) {
  eval("document.location.href='?category="+selObj.options[selObj.selectedIndex].value+"'");
//  selObj.selectedIndex=0;
}
</script>





<div id="CONTAINER" style="margin:0px;width:auto; ">
	
  <div id="LEFT-1" style="float:left; width:160px;margin:0px;">
	  <?php include("lekarstva_inc/left-1.php");  ?>  
  </div>


  
  <div id="LEFT-2" style="float:left; width:150px;margin:0px;"> 
  	  <?php include("lekarstva_inc/left-2.php");  ?>  
  </div>
  
   <div id="HEADER" style="height:320px; background-image:url(images/header_bgr_red.gif);background-position:top; background-repeat:repeat-x;">          
         <div id="BANER_KVADRAT_AND_NEWS"style="float:left; width:650px; margin-left:10px; margin-top:15px;">
       <?php  include("lekarstva_inc/baner-kvadrat.inc.php");  ?>  
     </div>  
   </div>
     
  <div id="CENTER" style="float:left;margin-left:0px;width:660px;">
 	
     <div id="MAIN" style="float:left; width:500px; margin-top:0px;">
        <?php include("lekarstva_inc/main.php");  ?>  
     </div>
     <div id="RIGHT" style="float:left;margin-left:10px; width:150px;margin-top:20px;">
        <?php include("lekarstva_inc/right.php");  ?>  
     </div>      
  </div>
  
</div> <!-- END CONTAINER DIV -->
   
</form>

<div id="FOOTER" style=" float:left;width:auto; margin-top:20px;">
	 <?php include("inc/footer.inc.php");  ?>  
</div>

<script> 
  //TooltipManager.addHTML("COLLAPSE_BTN", "collapse_help");
   TooltipManager.addURL("question", "help/collapse_help.html", 200, 300);
</script>
</body>
</html>


<?php
// -------------------- funkcii -----------------------------------------



?>