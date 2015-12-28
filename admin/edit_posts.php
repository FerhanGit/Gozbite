<?php
$pageName = 'edit_posts';
	
include_once("inc/dblogin.inc.php");
require_once("classes/Post.class.php");

$page = $_REQUEST['page']; 
   
	
// ------------------СТАРТ на Вкарване на Коментари -----------------------
   
//=========================================================
 if (isset($_REQUEST['insert_comment_btn']))
 {
     
     if ((!empty($_REQUEST['sender_name'])) && (!empty($_REQUEST['sender_email'])) && (!empty($_REQUEST['comment_body'])))
     {
     		 
        if (!isset($_SESSION['valid_user'])) 
        {
        ?>
        	<script type="text/javascript">alert("Не сте оторизиран за тази секция");window.location.href='login.php';</script> 
        <?php 
        exit;
        }
    	 
    	 	    
        $sql="INSERT INTO post_comment SET post_id='".$_REQUEST['postID']."',
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
        	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='posts.php?postID=<?=$_REQUEST['postID']?>';</script> 
        <?php 
    }
}

// --------------------Край на коментарите --------------------------------	
	
	
// ------------------СТАРТ на Редактиране на Коментари -----------------------
   
//=========================================================
 if (isset($_REQUEST['edit_comment_btn']))
 {
     for ($n=0;$n<sizeof($_REQUEST['postID']);$n++)
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
        	 
        	 	    
             $sql="UPDATE post_comment SET  comment_body='".addslashes($_REQUEST['comment_body'][$n])."',
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
            	<script type="text/javascript">alert("Не сте попълнили задължителните полета!");window.location.href='edit_posts.php?postID=<?=$_REQUEST[$n]['postID']?>';</script> 
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
    	 
    	 	    
        $sql="DELETE FROM post_comment WHERE commentID='".$_REQUEST['deleteComment']."'	 ";
    	$conn->setsql($sql);
    	$last_ID=$conn->updateDB();
    		 
?>
<script type="text/javascript">
       window.location.href='edit_posts.php';
</script> 
	 	 	
<?php
  
}


// ------------------------- Край на коментарите --------------------------	








    
// --------------------------- START SEARCH ------------------------------
	
	
if ((isset($_REQUEST['search_btn'])) or (isset($page)) or (!empty($_REQUEST['category'])))
{
		
			if(empty($_REQUEST['post_category'])) $_REQUEST['post_category'] = $_REQUEST['category'];
			$_REQUEST['post_category'] = $_REQUEST['post_sub_category']?$_REQUEST['post_sub_category']:$_REQUEST['post_category'];
	 	
			
			$and="";
	 		if ($_REQUEST['post_title']!="")  $and .= " AND p.title LIKE '%".$_REQUEST['post_title']."%'";
	 		if ($_REQUEST['post_category']!="")  $and .= " AND (p.post_category='".$_REQUEST['post_category']."' OR p.post_category IN (SELECT id FROM post_category WHERE parentID = '".$_REQUEST['post_category']."') )";
	 		if ($_REQUEST['post_body']!="")  $and .= " AND p.body LIKE '%".$_REQUEST['post_body']."%'";
	 		if ($_REQUEST['post_source']!="")  $and .= " AND p.source LIKE '%".$_REQUEST['post_source']."%'"; 
	 		if ($_REQUEST['post_autor']!="")  $and .= " AND p.source LIKE '%".$_REQUEST['post_source']."%'"; 	 		
	 		if ($_REQUEST['fromDate']!="")  $and .= " AND p.date > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
	 		if ($_REQUEST['toDate']!="")  $and .= " AND p.date < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
	 		
	 		if ($_REQUEST['picCheck']!="")  $and .= " AND p.picURL <> '' "; 
	 		
				
			
			
			if ((isset($_REQUEST['orderby'])) && ($_REQUEST['orderby']!=""))
			{
				switch ($_REQUEST['orderby'])
				{
					
					
					case 'date': $orderby = 'p.date DESC';
					break;
										
					case 'post_source': $orderby = 'p.source';
					break;
					
					case 'post_category': $orderby = 'pc.name';
					break;
					
					case 'post_title': $orderby = 'p.title';
					break;
					
					case 'post_body': $orderby = 'p.body';
					break;
					
					case 'post_autor': $orderby = 'p.autor';
					break;
							
														
					default : $orderby = 'p.date DESC';
					break;
				}
			}
			else $orderby= 'p.date DESC';
			
	 	    
    $sql="SELECT p.postID as 'postID', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category=pc.id $and ORDER BY $orderby";
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
	    
	$sql="SELECT p.postID as 'postID', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category=pc.id $and ORDER BY $orderby LIMIT $limitvalue,$pp";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultPosts=$conn->result;
	$numPosts=$conn->numberrows;

	
	$sql="SELECT id, name FROM post_category WHERE parentID = '".($_REQUEST['post_category']?$_REQUEST['post_category']:$_REQUEST['category'])."' ORDER BY name";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultChildCats=$conn->result;
	$numChildCats=$conn->numberrows;
	
} 


else 
{

	$sql="SELECT p.postID as 'postID', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category=pc.id ORDER BY p.date DESC";
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
	    
	$sql="SELECT p.postID as 'postID', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category=pc.id ORDER BY p.date DESC LIMIT $limitvalue,$pp";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultPosts=$conn->result;
	$numPosts=$conn->numberrows;

	
	$sql="SELECT id, name FROM post_category WHERE parentID = '".($_REQUEST['post_category']?$_REQUEST['post_category']:$_REQUEST['category'])."' ORDER BY name";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultChildCats=$conn->result;
	$numChildCats=$conn->numberrows;
	
}
// ----------------------------------- krai search -------------------------------------------






// -------------------------------------- EDIT ----------------------------------------------------
	 
			
	 if (isset($_REQUEST['edit_btn']))
	 {
	 	
	 	$post = new Post($conn);
	 	
	 	$editID=$_REQUEST['edit'];
		$post->id = $editID;
		
		$post->title			= $_REQUEST['post_title'];
		$post->body				= $_REQUEST['post_body'];		
		$post->autor 			= $_SESSION['userID'];
		$post->autor_type 		= $_SESSION['user_type'];
		$post->source 			= $_REQUEST['post_source'];
		$post->post_category	= $_REQUEST['post_sub_category']?$_REQUEST['post_sub_category']:$_REQUEST['post_category'];
		$post->updated_by		= $_SESSION['userID'];
		$post->date				= 'NOW()';
			
	    if($post->update($_FILES["post_pic"]))
	    $postID = $post->id;
	    $last_ID = $postID;
		
	   
?>
<script type="text/javascript">
       window.location.href='edit_posts.php?edit=<?=$editID?>';
</script> 
	 	 	
<?php	
		  	 
// --------------------------------------------------------------------------------
	
} // krai na edit	




// ------------------------- INSERT hospital -----------------------------------------

if (isset($_REQUEST['insert_btn']) && ($_REQUEST['post_title']!="") && ($_REQUEST['post_body']!="") && ($_REQUEST['post_category']!="") && ($_REQUEST['post_source']!=""))
{
	 	  	 	 	 	 	 	
	 
		$post = new Post($conn);
	 	
	 			
		$post->title			= $_REQUEST['post_title'];
		$post->body				= $_REQUEST['post_body'];		
		$post->autor 			= $_SESSION['userID'];
		$post->autor_type 		= $_SESSION['user_type'];
		$post->source 			= $_REQUEST['post_source'];
		$post->post_category	= $_REQUEST['post_sub_category']?$_REQUEST['post_sub_category']:$_REQUEST['post_category'];
		$post->updated_by		= $_SESSION['userID'];
		$post->date				= 'NOW()';
			
	    if($post->create($_FILES["post_pic"]))
	    $postID = $post->id;
	    $last_ID = $postID;
	 
	 ?>	
	<script type="text/javascript">
       window.location.href='edit_posts.php?edit=<?=$last_ID?>';
	</script> 
	<?php 	 
		 
}	
// --- Край на INSERT ----------------------
	 

	 


if (isset($_REQUEST['deletePic']))
{
	$post = new Post($conn);
	
	$picParts = explode(".",$_REQUEST['deletePic']);
	$editID=$picParts[0];
	$post->id = $editID;
		
	$subject = $picParts[1];
	$pattern = '/^[0-9]{1,12}/';
	preg_match($pattern, $subject , $matches, PREG_OFFSET_CAPTURE);
	
	$post->deletePic($matches[0][0]);	
	
	?>	
	<script type="text/javascript">
       window.location.href='edit_posts.php?edit=<?=$editID?>';
	</script> 
	<?php

	
}







if (isset($_REQUEST['delete']))
{
	$post = new Post($conn);
	
	$deleteID=$_REQUEST['delete'];
	$post->id = $deleteID; 	
    $post->deletePost();	

 	?>	
	<script type="text/javascript">
       window.location.href='edit_posts.php';
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
		new Ajax.Updater('SubCatsDiv', 'posts_inc/Ajax_subCats.php?mainCat='+mainCat, {
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
new Ajax.PeriodicalUpdater('user_info_test_div', 'test_Proto_Ajax.php', {
  method: 'get', frequency: 3, decay: 2
});
</script>




<script type="text/javascript">

function jumpBlank(selObj) {
  eval("document.location.href='?category="+selObj.options[selObj.selectedIndex].value+"'");
 // selObj.selectedIndex=0;
}


</script>




<div id="CONTAINER" style="margin:0px;width:auto; ">
	
  <div id="LEFT-1" style="float:left; width:160px;margin:0px;">
	  <?php include("posts_inc/left-1.php");  ?>  
  </div>


  
  <div id="LEFT-2" style="float:left; width:150px;margin:0px;"> 
  	  <?php include("posts_inc/left-2.php");  ?>  
  </div>
  
  
  <div id="HEADER" style="height:320px; background-image:url(images/header_bgr_blue.gif);background-position:top; background-repeat:repeat-x;">          
        <div id="BANER_KVADRAT_AND_NEWS"style="float:left; width:650px; margin-left:10px; margin-top:15px;">
       <?php  include("posts_inc/baner-kvadrat.inc.php");  ?>  
     </div>    
   </div>
     
  <div id="CENTER" style="float:left;margin-left:0px;width:660px;">
 	 <div id="MAIN" style="float:left; width:500px; margin-top:0px;">
        <?php  include("posts_inc/main.php");  ?>  
     </div>
     <div id="RIGHT" style="float:left;margin-left:10px; width:150px;margin-top:20px;">
        <?php include("posts_inc/right.php");  ?>  
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