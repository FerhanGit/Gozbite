<?php	
$pageName = 'edit_news';

include_once("inc/dblogin.inc.php");
require_once("classes/News.class.php");

$page = $_REQUEST['page']; 
   

//=========================================================

if (!isset($_SESSION['valid_user'])) 
{
?>
	<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href='../login.php';</script> 
<?php 
exit;
}

// -------------------------------------------------------

if ($_SESSION['user_kind']<>2)
{
?>
	<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href='../index.php';</script> 
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
    	 
    	 	    
        $sql="INSERT INTO news_comment SET newsID='".$_REQUEST['newsID']."',
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
        	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='edit_news.php?newsID=<?=$_REQUEST['newsID']?>';</script> 
        <?php 
    }
}
//================== Край на Вкарване на Коментари =======================================


	
// ------------------СТАРТ на Редактиране на Коментари -----------------------
   
//=========================================================
 if (isset($_REQUEST['edit_comment_btn']))
 {
     for ($n=0;$n<sizeof($_REQUEST['newsID']);$n++)
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
        	 
        	 	    
            $sql="UPDATE news_comment SET comment_body='".addslashes($_REQUEST['comment_body'][$n])."',
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
            	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='edit_news.php?newsID=<?=$_REQUEST[$n]['newsID']?>';</script> 
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
        	<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href='login.php';</script> 
        <?php 
        exit;
        }
    	 
    	 	    
        $sql="DELETE FROM news_comment WHERE commentID='".$_REQUEST['deleteComment']."'	 ";
    	$conn->setsql($sql);
    	$last_ID=$conn->updateDB();
    		 
?>
<script type="text/javascript">
       window.location.href='edit_news.php';
</script> 
	 	 	
<?php
  
}


// --------------------Край на коментарите --------------------------------	


    
// --------------------------- START SEARCH ------------------------------
	
	
if ((isset($_REQUEST['search_btn'])) or (isset($page)) or (!empty($_REQUEST['category'])))
{
			if(empty($_REQUEST['news_category'])) $_REQUEST['news_category'] = $_REQUEST['category'];

	
			$and="";
	 		if ($_REQUEST['news_title']!="")  $and .= " AND n.title LIKE '%".$_REQUEST['news_title']."%'";
	 		if ($_REQUEST['news_category']!="")  $and .= " AND (n.news_category='".$_REQUEST['news_category']."' OR n.news_category IN (SELECT id FROM news_category WHERE parentID = '".$_REQUEST['news_category']."') )";
	 		if ($_REQUEST['news_sub_category']!="")  $and .= " AND (n.news_category='".$_REQUEST['news_sub_category']."' OR n.news_category IN (SELECT id FROM news_category WHERE parentID = '".$_REQUEST['news_sub_category']."') )";
	 		if ($_REQUEST['news_body']!="")  $and .= " AND n.body LIKE '%".$_REQUEST['news_body']."%'";
	 		if ($_REQUEST['nеws_source']!="")  $and .= " AND n.source LIKE '%".$_REQUEST['nеws_source']."%'"; 
	 		if ($_REQUEST['news_autor']!="")  $and .= " AND n.source LIKE '%".$_REQUEST['nеws_source']."%'"; 
	 		if ($_REQUEST['fromDate']!="")  $and .= " AND n.date > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
	 		if ($_REQUEST['toDate']!="")  $and .= " AND n.date < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
	 		
			if ($_REQUEST['picCheck']!="")  $and .= " AND n.picURL <> 'NULL' "; 
	 		
		
			
			
			if ((isset($_REQUEST['orderby'])) && ($_REQUEST['orderby']!=""))
			{
				switch ($_REQUEST['orderby'])
				{
					
					
					case 'date': $orderby = 'n.date DESC';
					break;
										
					case 'nеws_source': $orderby = 'n.source';
					break;
					
					case 'nеws_category': $orderby = 'nc.name';
					break;
					
					case 'news_title': $orderby = 'n.title';
					break;
					
					case 'news_body': $orderby = 'n.body';
					break;
					
					case 'news_autor': $orderby = 'n.autor';
					break;
							
														
					default : $orderby = 'n.date DESC';
					break;
				}
			}
			else $orderby= 'n.date DESC';
			
	 	    
    $sql="SELECT n.newsID as 'newsID', n.date as 'date', n.title as 'title', n.body as 'body', n.picURL as 'picURL', n.autor as 'autor', n.source as 'source', nc.name as 'category' FROM news n, news_category nc WHERE n.news_category=nc.id $and ORDER BY $orderby";
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
	    
	$sql="SELECT n.newsID as 'newsID', n.date as 'date', n.title as 'title', n.body as 'body', n.picURL as 'picURL', n.autor as 'autor', n.source as 'source', nc.name as 'category' FROM news n, news_category nc WHERE n.news_category=nc.id $and ORDER BY $orderby LIMIT $limitvalue , $pp";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultNews=$conn->result;
	$numNews=$conn->numberrows;

	$sql="SELECT id, name FROM news_category WHERE parentID = '".($_REQUEST['news_category']?$_REQUEST['news_category']:$_REQUEST['category'])."' ORDER BY name";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultChildCats=$conn->result;
	$numChildCats=$conn->numberrows;
} 


else 
{

	$sql="SELECT n.newsID as 'newsID', n.date as 'date', n.title as 'title', n.body as 'body', n.picURL as 'picURL', n.autor as 'autor', n.source as 'source', nc.name as 'category' FROM news n, news_category nc WHERE n.news_category=nc.id ORDER BY date DESC";
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

	    
	$sql="SELECT n.newsID as 'newsID', n.date as 'date', n.title as 'title', n.body as 'body', n.picURL as 'picURL', n.autor as 'autor', n.source as 'source', nc.name as 'category' FROM news n, news_category nc WHERE n.news_category=nc.id ORDER BY date DESC LIMIT $limitvalue,$pp";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultNews=$conn->result;
	$numNews=$conn->numberrows;

	
	$sql="SELECT id, name FROM news_category WHERE parentID = '".($_REQUEST['news_category']?$_REQUEST['news_category']:$_REQUEST['category'])."' ORDER BY name";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultChildCats=$conn->result;
	$numChildCats=$conn->numberrows;
	
}






// -------------------------------------- EDIT ----------------------------------------------------
	 
			
	 if (isset($_REQUEST['edit_btn']))
	 {
	 	
	 	$news = new news($conn);
	 	
	 	$editID=$_REQUEST['edit'];
		$news->id = $editID;
		
		$news->title			= $_REQUEST['news_title'];
		$news->body				= $_REQUEST['news_body'];		
		$news->autor 			= $_SESSION['userID'];
		$news->autor_type 		= $_SESSION['user_type'];
		$news->source 			= $_REQUEST['news_source'];
		$news->news_category	= $_REQUEST['news_sub_category']?$_REQUEST['news_sub_category']:$_REQUEST['news_category'];
		$news->updated_by		= $_SESSION['userID'];
		$news->date				= 'NOW()';
			
	    if($news->update($_FILES["news_pic"]))
	    $newsID = $news->id;
	    $last_ID = $newsID;
		
	   
?>
<script type="text/javascript">
       window.location.href='edit_news.php?edit=<?=$editID?>';
</script> 
	 	 	
<?php	
		  	 
// --------------------------------------------------------------------------------
	
} // krai na edit	




// ------------------------- INSERT hospital -----------------------------------------

if (isset($_REQUEST['insert_btn']) && ($_REQUEST['news_title']!="") && ($_REQUEST['news_body']!="") && ($_REQUEST['news_category']!="") && ($_REQUEST['news_source']!=""))
{
	 	  	 	 	 	 	 	
	 
		$news = new news($conn);
	 	
	 			
		$news->title			= $_REQUEST['news_title'];
		$news->body				= $_REQUEST['news_body'];		
		$news->autor 			= $_SESSION['userID'];
		$news->autor_type 		= $_SESSION['user_type'];
		$news->source 			= $_REQUEST['news_source'];
		$news->news_category	= $_REQUEST['news_sub_category']?$_REQUEST['news_sub_category']:$_REQUEST['news_category'];
		$news->updated_by		= $_SESSION['userID'];
		$news->date				= 'NOW()';
			
	    if($news->create($_FILES["news_pic"]))
	    $newsID = $news->id;
	    $last_ID = $newsID;
	 
	 ?>	
	<script type="text/javascript">
       window.location.href='edit_news.php?edit=<?=$last_ID?>';
	</script> 
	<?php 	 
		 	 
		 
}	
// --- Край на INSERT ----------------------
	 

	 


if (isset($_REQUEST['deletePic']))
{
	$news = new news($conn);
	
	$picParts = explode(".",$_REQUEST['deletePic']);
	$editID=$picParts[0];
	$news->id = $editID;
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$news->deletePic($matches[0][0]);	
	
	?>
	
	<script type="text/javascript">
       window.location.href='edit_news.php?edit=<?=$editID?>';
	</script> 
	
	<?php

	
}







if (isset($_REQUEST['delete']))
{
	$news = new news($conn);
	
	$deleteID=$_REQUEST['delete'];
	$news->id = $deleteID; 	
    $news->deleteNews();	
		
    ?>	
	<script type="text/javascript">
       window.location.href='edit_news.php';
	</script> 
	<?php 	 
		 
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
<link href="css/style.css" rel="stylesheet" type="text/css" />
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
		new Ajax.Updater('SubCatsDiv', 'news_inc/Ajax_subCats.php?mainCat='+mainCat, {
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
	  <?php include("news_inc/left-1.php");  ?>  
  </div>


  
  <div id="LEFT-2" style="float:left; width:150px;margin:0px;"> 
  	  <?php include("news_inc/left-2.php");  ?>  
  </div>
  
  <div id="HEADER" style="height:320px; background-image:url(images/header_bgr_blue.gif);background-position:top; background-repeat:repeat-x;">          
        <div id="BANER_KVADRAT_AND_NEWS"style="float:left; width:650px; margin-left:10px; margin-top:15px;">
       <?php  include("news_inc/baner-kvadrat.inc.php");  ?>  
     </div>    
   </div>
     
  <div id="CENTER" style="float:left;margin-left:0px;width:660px;">
 	 <div id="MAIN" style="float:left; width:500px; margin-top:0px;">
        <?php  include("news_inc/main.php");  ?>  
     </div>
     <div id="RIGHT" style="float:left;margin-left:10px; width:150px;margin-top:20px;">
        <?php include("news_inc/right.php");  ?>  
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