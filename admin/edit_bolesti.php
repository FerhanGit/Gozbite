<?php
$pageName = 'edit_bolesti';
	
include_once("inc/dblogin.inc.php");
$page = $_REQUEST['page']; 
   
require_once("classes/Bolest.class.php");

	
	
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
    	 
    	 	    
        $sql="INSERT INTO bolest_comment SET bolestID='".$_REQUEST['bolestID']."',
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
        	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='edit_bolesti.php?bolestID=<?=$_REQUEST['bolestID']?>';</script> 
        <?php 
    }
}
//================== Край на Вкарване на Коментари =======================================



	
// ------------------СТАРТ на Редактиране на Коментари -----------------------
   
//=========================================================
 if (isset($_REQUEST['edit_comment_btn']))
 {
     for ($n=0;$n<sizeof($_REQUEST['bolestID']);$n++)
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
        	 
        	 	    
             $sql="UPDATE bolest_comment SET  comment_body='".addslashes($_REQUEST['comment_body'][$n])."',
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
            	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='edit_bolesti.php?bolestID=<?=$_REQUEST['bolestID'][$n]?>';</script> 
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
    	 
    	 	    
        $sql="DELETE FROM bolest_comment WHERE commentID='".$_REQUEST['deleteComment']."'	 ";
    	$conn->setsql($sql);
    	$last_ID=$conn->updateDB();
    		 
?>
<script type="text/javascript">
       window.location.href='edit_bolesti.php';
</script> 
	 	 	
<?php
  
}


// ------------------------- Край на коментарите --------------------------	





// -------------------------------------- EDIT ----------------------------------------------------
	 
		 
if (isset($_REQUEST['edit_btn']))
{
		
	
	 	$bolest = new Bolest($conn);
	 	
	 	$editID=$_REQUEST['edit'];
		$bolest->id = $editID;
		
		$bolest->title 				= $_REQUEST['bolest_title'];
		$bolest->body 				= $_REQUEST['bolest_body'];
		$bolest->autor_type 		= $_SESSION['user_type'];
		$bolest->autor 				= $_SESSION['userID'];
		$bolest->source 			= $_REQUEST['bolest_source'];
		$bolest->bolest_category	= $_REQUEST['bolest_sub_category']?$_REQUEST['bolest_sub_category']:$_REQUEST['bolest_category'];
		$bolest->bolest_simptom		= $_REQUEST['bolest_simptom'];
		$bolest->has_pic 			= (is_array($_FILES["pics"]))?1:0;
		$bolest->date				= 'NOW()';
	
	    if($bolest->update($_FILES["pics"]))
	    $bolestID = $bolest->id;
	    $last_ID  = $bolestID;
		
	 	
	 	 
	    
 ?>
<script type="text/javascript">
       window.location.href='edit_bolesti.php?edit=<?=$last_ID?>';
</script> 
	 	 	
<?php
			
		  	 
// --------------------------------------------------------------------------------
	
} // krai na edit	




// ------------------------- INSERT BOLEST -----------------------------------------

if ((isset($_REQUEST['insert_btn'])) && ($_REQUEST['bolest_title']!="") && ($_REQUEST['bolest_body']!="") && ($_REQUEST['bolest_category']!="") )
{
	 	 	 	 	 	 	 	 	 	 	
	 
		$bolest = new Bolest($conn);
		
		$bolest->title 				= $_REQUEST['bolest_title'];
		$bolest->body 				= $_REQUEST['bolest_body'];
		$bolest->autor_type 		= $_SESSION['user_type'];
		$bolest->autor 				= $_SESSION['userID'];
		$bolest->source 			= $_REQUEST['bolest_source'];
		$bolest->bolest_category	= $_REQUEST['bolest_sub_category']?$_REQUEST['bolest_sub_category']:$_REQUEST['bolest_category'];
		$bolest->bolest_simptom		= $_REQUEST['bolest_simptom'];
		$bolest->has_pic 			= (is_array($_FILES["pics"]))?1:0;
		$bolest->date				= 'NOW()';

		if($bolest->create($_FILES["pics"]))
	    $bolestID = $bolest->id;
	    $last_ID  = $bolestID;
 
	

?>
<script type="text/javascript">
       window.location.href='edit_bolesti.php?edit=<?=$last_ID?>';
</script> 
	 	 	
<?php

}	
// --- Край на INSERT ----------------------
	 

	 


if (isset($_REQUEST['deletePic']))
{
	$bolest = new Bolest($conn);
	
	$picParts = explode("_",$_REQUEST['deletePic']);
	$editID=$picParts[0];
	$bolest->id = $editID;
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$bolest->deletePic($matches[0][0]);	
	
	?>
	
	<script type="text/javascript">
       window.location.href='edit_bolesti.php?edit=<?=$editID?>';
	</script> 
	
	<?php

	
}




if (isset($_REQUEST['delete']))
{
	$bolest = new Bolest($conn);
	
	$deleteID=$_REQUEST['delete'];
	$bolest->id = $deleteID; 	
    $bolest->deletebolest();	

    $sql=sprintf("UPDATE users SET cnt_bolesti=cnt_bolesti-1 WHERE userID= %d ",$_SESSION['userID']);
	$conn->setsql($sql);
	$conn->updateDB();
	
	$_SESSION['cnt_bolesti']--;
	
	?>
	
	<script type="text/javascript">
       window.location.href='edit_bolesti.php';
	</script> 
	
	<?php

	
}



    
// --------------------------- START SEARCH ------------------------------

	
if ((isset($_REQUEST['search_btn'])) or (isset($page)) or (!empty($_REQUEST['category'])))
{
		
		if(empty($_REQUEST['bolest_category'])) $_REQUEST['bolest_category'] = $_REQUEST['category'];
		$_REQUEST['bolest_category'] = $_REQUEST['bolest_sub_category']?$_REQUEST['bolest_sub_category']:$_REQUEST['bolest_category'];
	 		

		if ($_REQUEST['bolest_category']!="")  
			{
				
				$sql="SELECT bcl.bolest_id as 'bolest_id' FROM bolesti b, bolest_category bc, bolesti_category_list bcl WHERE bcl.bolest_id = b.bolestID AND bcl.category_id = bc.id AND (bcl.category_id = '".$_REQUEST['bolest_category']."' OR bcl.category_id IN (SELECT id FROM bolest_category WHERE parentID='".$_REQUEST['bolest_category']."') )";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numBolestiByCats    = $conn->numberrows;
				$resultBolestiByCats = $conn->result;
				for($n=0;$n<$numBolestiByCats;$n++)
				{
					$bolestiByCatsArr[]=$resultBolestiByCats[$n]['bolest_id'];
				}
				if(is_array($bolestiByCatsArr))
				$bolestiByCats = implode(',',$bolestiByCatsArr);
				else $bolestiByCats = -1;
			}
			
			
			
			if (is_array($_REQUEST['bolest_simptom']) && count($_REQUEST['bolest_simptom'])>0 ) 
			{
				$sql="SELECT bsl.bolest_id as 'bolest_id' FROM bolesti b, bolest_simptoms bs, bolesti_simptoms_list bsl WHERE bsl.bolest_id = b.bolestID AND bsl.simptom_id = bs.id AND bsl.simptom_id IN (".implode(',',$_REQUEST['bolest_simptom']).")";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numBolestiBySimptoms    = $conn->numberrows;
				$resultBolestiBySimptoms = $conn->result;
				for($n=0;$n<$numBolestiBySimptoms;$n++)
				{
					$bolestiBySimptomsArr[]=$resultBolestiBySimptoms[$n]['bolest_id'];
				}
				if(is_array($bolestiBySimptomsArr))
				$bolestiBySimptoms = implode(',',$bolestiBySimptomsArr);
				else $bolestiBySimptoms = -1;
			}
			elseif (!is_array($_REQUEST['bolest_simptom']) && $_REQUEST['bolest_simptom']<>'') 
			{
				$sql="SELECT bsl.bolest_id as 'bolest_id' FROM bolesti b, bolest_simptoms bs, bolesti_simptoms_list bsl WHERE bsl.bolest_id = b.bolestID AND bsl.simptom_id = bs.id AND bsl.simptom_id IN (".$_REQUEST['bolest_simptom'].")";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numBolestiBySimptoms    = $conn->numberrows;
				$resultBolestiBySimptoms = $conn->result;
				for($n=0;$n<$numBolestiBySimptoms;$n++)
				{
					$bolestiBySimptomsArr[]=$resultBolestiBySimptoms[$n]['bolest_id'];
				}
				if(is_array($bolestiBySimptomsArr))
				$bolestiBySimptoms = implode(',',$bolestiBySimptomsArr);
				else $bolestiBySimptoms = -1;
			}
			
			
			
			
	 		 $and="";
	 		if ($bolestiByCats!="")  $and .= " AND b.bolestID IN (".$bolestiByCats.")";
	 		if ($bolestiBySimptoms!="")  $and .= " AND b.bolestID IN (".$bolestiBySimptoms.")"; 		
	 		if ($_REQUEST['bolest_title']!="")  $and .= " AND b.title LIKE '%".$_REQUEST['bolest_title']."%'";
	 		if ($_REQUEST['bolest_body']!="")  $and .= " AND b.body LIKE '%".$_REQUEST['bolest_body']."%'";
	 		if ($_REQUEST['autor_type']!="")  $and .= " AND b.autor_type LIKE '%".$_REQUEST['autor_type']."%'"; 
	 		if ($_REQUEST['autor']!="")  $and .= " AND b.autor == '".$_REQUEST['autor']."'"; 
	 		if ($_REQUEST['bolest_source']!="")  $and .= " AND b.source LIKE '%".$_REQUEST['bolest_source']."%'"; 
	 		if ($_REQUEST['bolest_autor']!="")  $and .= " AND b.autor LIKE '%".$_REQUEST['bolest_autor']."%'"; 	 		
	 		if ($_REQUEST['fromDate']!="")  $and .= " AND b.date > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
	 		if ($_REQUEST['toDate']!="")  $and .= " AND b.date < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
	 		
	 		if ($_REQUEST['picCheck']!="")  $and .= " AND b.has_pic = '1' "; 
	 		
				
			
			
			if ((isset($_REQUEST['orderby'])) && ($_REQUEST['orderby']!=""))
			{
				switch ($_REQUEST['orderby'])
				{
					
					
					case 'date': $orderby = 'b.date DESC';
					break;
										
					case 'autor_type': $orderby = 'b.autor_type';
					break;
					
					case 'autor': $orderby = 'b.autor';
					break;
					
					case 'bolest_source': $orderby = 'b.source';
					break;
					
					case 'bolest_title': $orderby = 'b.title';
					break;
					
					case 'bolest_body': $orderby = 'b.body';
					break;
					
					case 'bolest_autor': $orderby = 'b.autor';
					break;
							
														
					default : $orderby = 'b.date DESC';
					break;
				}
			}
			else $orderby= 'b.date DESC';
			
	 	    
    $sql="SELECT b.bolestID as 'bolestID', b.date as 'date', b.title as 'title', b.body as 'body', b.has_pic as 'has_pic', b.autor_type as 'autor_type', b.autor as 'autor', b.source as 'source' FROM bolesti b WHERE 1=1 $and ORDER BY $orderby";
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
	    
	$sql="SELECT b.bolestID as 'bolestID', b.date as 'date', b.title as 'title', b.body as 'body',b.has_pic as 'has_pic', b.autor_type as 'autor_type', b.autor as 'autor', b.source as 'source' FROM bolesti b WHERE 1=1 $and ORDER BY $orderby LIMIT $limitvalue,$pp";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultBolesti=$conn->result;
	$numBolesti=$conn->numberrows;
	
	$sql="SELECT id, name FROM bolest_category WHERE parentID = '".($_REQUEST['bolest_category']?$_REQUEST['bolest_category']:$_REQUEST['category'])."' ORDER BY name";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultChildCats=$conn->result;
	$numChildCats=$conn->numberrows;

	
} 

else 
{
	$and='';  
	  
	$sql="SELECT b.bolestID as 'bolestID', b.date as 'date', b.title as 'title', b.body as 'body', b.has_pic as 'has_pic', b.autor_type as 'autor_type', b.autor as 'autor', b.source as 'source' FROM bolesti b WHERE 1=1 $and ORDER BY b.date DESC LIMIT 5";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultBolesti=$conn->result;
	$numBolesti=$conn->numberrows;

	$sql="SELECT id, name FROM bolest_category WHERE parentID = '".($_REQUEST['bolest_category']?$_REQUEST['bolest_category']:$_REQUEST['category'])."' ORDER BY name";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultChildCats=$conn->result;
	$numChildCats=$conn->numberrows;
}


//-----------------------------------------------------------------
	for($i=0;$i<$numBolesti;$i++)
	{
	
	// ============================= CATEGORIES =========================================

		$sql="SELECT bc.id as 'bolest_category_id', bc.name as 'bolest_category_name' FROM bolesti b, bolest_category bc, bolesti_category_list bcl WHERE bcl.bolest_id = b.bolestID AND bcl.category_id = bc.id AND b.bolestID = '".$resultBolesti[$i]['bolestID']."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numBolestCats[$i]  	= $conn->numberrows;
		$resultBolestCats[$i] 	= $conn->result;
		
		
	// =============================== SIMPTOMS ========================================	
	
		$sql="SELECT bs.id as 'bolest_simptom_id', bs.name as 'bolest_simptom_name' FROM bolesti b, bolest_simptoms bs, bolesti_simptoms_list bsl WHERE bsl.bolest_id = b.bolestID AND bsl.simptom_id = bs.id AND b.bolestID = '".$resultBolesti[$i]['bolestID']."' ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numBolestSimptoms[$i]  	= $conn->numberrows;
		$resultBolestSimptoms[$i]   = $conn->result;
	
	}
	
	


// ----------------- DEL PIC ---------------------------------------

if (isset($_REQUEST['deletePic']) && !empty($_REQUEST['deletePic']))
{ 
		
			$fileToDelete = "../pics/bolesti/".$_REQUEST['deletePic'];
			$thumbToDelete = "../pics/bolesti/".$_REQUEST['edit'].'_thumb.jpg';
			
			
				
 		
			$sql2="DELETE FROM bolesti_pics WHERE url_big='".$_REQUEST['deletePic']."'";	
			$conn->setsql($sql2); 			
			$conn->updateDB();

			$sql2="SELECT * FROM bolesti_pics WHERE bolestID='".$_REQUEST['edit']."'";	
			$conn->setsql($sql2); 			
			$conn->getTableRows();
			if($conn->numberrows < 1)	
			{
				$sql2="UPDATE bolesti SET has_pic=0 WHERE bolestID='".$_REQUEST['edit']."'";	
				$conn->setsql($sql2); 			
				$conn->updateDB();
			}
 		
			
			
			
			unlink($fileToDelete);
			unlink($thumbToDelete);
		

?>
<script type="text/javascript">
       window.location.href='edit_bolesti.php?edit=<?=$_REQUEST['edit']?>';
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
   
   
<script type="text/javascript" src="js/ajaxtabs/ajaxtabs.js"></script>
<link rel="stylesheet" type="text/css" href="js/ajaxtabs/ajaxtabs.css" />

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
	function getSubCats(mainCat)
	{
		new Ajax.Updater('SubCatsDiv', 'bolesti_inc/Ajax_subCats.php?mainCat='+mainCat, {
		  method: 'get',onSuccess: function() {
	                       new Effect.Opacity('SubCatsDiv', {duration: 1.0, from:0.3, to:1.0});
						
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
	  <?php include("bolesti_inc/left-1.php");  ?>  
  </div>


  
  <div id="LEFT-2" style="float:left; width:150px;margin:0px;"> 
  	  <?php include("bolesti_inc/left-2.php");  ?>  
  </div>
  
   <div id="HEADER" style="height:320px; background-image:url(images/header_bgr_red.gif);background-position:top; background-repeat:repeat-x;">          
         <div id="BANER_KVADRAT_AND_NEWS"style="float:left; width:650px; margin-left:10px; margin-top:15px;">
       <?php  include("bolesti_inc/baner-kvadrat.inc.php");  ?>  
     </div>  
   </div>
     
  <div id="CENTER" style="float:left;margin-left:0px;width:660px;">
 	
     <div id="MAIN" style="float:left; width:500px; margin-top:0px;">
        <?php include("bolesti_inc/main.php");  ?>  
     </div>
     <div id="RIGHT" style="float:left;margin-left:10px; width:150px;margin-top:20px;">
        <?php include("bolesti_inc/right.php");  ?>  
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