<div id="BANER_KVADRAT_AND_NEWS_DIV" style="float:left;padding:10px 0px 10px 0px;">
<?php 
	  if(isset($_REQUEST['get']))
	  { ?>
      
         <div class="left_pic">   
         <?php
	         	if(isset($_REQUEST['get']))	  {
					$stuff=getPageContent($_REQUEST['get']);
				}
				if($stuff['title']<>'') print $stuff['title']; 
		?>
				
	         
	 <?php
				print $stuff['body'] ;			
}				
		?>
			
         </div>
</div>