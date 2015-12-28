<div id="BANER_KVADRAT_AND_NEWS_DIV" style="float:left;padding:10px 0px 10px 0px;">
<?php 
	 require_once("../inc/dblogin.inc.php");
  
		$get = myTruncateMy($_SERVER['HTTP_REFERER'],'get');
		$get = str_replace('get=','',$get);
	  if(isset($get))
	  { ?>
      
         <div class="left_pic">   
         <?php
	         	if(isset($get))	  {
					$stuff=getPageContent($get);
				}
				if($stuff['title']<>'') print $stuff['title']; 
		?>
				
	         
	 <?php
				print $stuff['body'] ;			
}				
		?>
			
         </div>
</div>