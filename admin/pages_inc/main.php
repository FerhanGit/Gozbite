<div id="Main_Top" style="float:left; width:500px; ">
	  <div id="ARTICLE" style="float:left; margin-top:20px; margin-bottom:20px; height:12px; width:23px; padding-left:0px; background-image:url(images/h6.gif); background-position:left; background-repeat:no-repeat;">
	   </div> <div style=" float:left; margin-top:18px;  margin-bottom:20px; margin-left:0px; padding-left:5px; font-size: 11px; font-family:  Arial, Helvetica, sans-serif; background-image:url(images/grey_dot.png); background-position:bottom; background-repeat:repeat-x;">АДМИН - Страници</div>
     
      
      <div id="whiteDIV" style="background-color:#F5F5F5;float:left;margin-left:10px;width:490px;" >	</div> 
    <!-- Text na ARTICLE -->
        <div id="tabs" style="float:left; height:auto; margin:0px 0px 0px 10px; padding-left:10px; width:480px; background-color:#F5F5F5; font-size: 12px; color: #467B99;" >
                          
                              
            <ul id="maintab" class="shadetabs">
                <li><a href="pages_inc/edit_pages.php?edit=<?=$_REQUEST['edit']?>" rel="ajaxcontentarea"><?=getPageTitle($_REQUEST['edit'])?></a></li>	
                                               
            </ul>
            <div id="ajaxcontentarea" class="contentstyle"></div>    
            <script type="text/javascript">
            //Start Ajax tabs script for UL with id="maintab" Separate multiple ids each with a comma.
            startajaxtabs("maintab");
            </script>		 

            	
          <!--Krai na Text na ARTICLE -->
          
        </div>	<!-- KRAI na tabs -->
     
      <div id="Main_Top_Bottom" style="background-color:#F5F5F5;float:left;margin-left:10px; padding-top:10px;width:490px;" >	 </div>
     
</div>	<!-- KRAI na Main_Top -->

     

    
 <script type="text/javascript">

Event.observe(window, 'load', function() { 	   
Nifty("div.ofr_top","tl");
Nifty("div.ofr_down","bl br");
Nifty("div.paging","all");
Nifty("div.newsDIVContainer","all");
Nifty("div.newsButton","tr bl big");
Nifty("div.last_posts","tr bl big");
Nifty("div.niftyTitle","tr bl big");

expandtab("maintab", 0);
$("maintab").scrollTo();

}
);

	
</script>
        