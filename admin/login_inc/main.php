<div id="Main_Top" style="float:left; width:500px; ">
	  <div id="ARTICLE" style="float:left;height:56px; width:500px; padding-left:30px; background-image:url(images/h6.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:25px;margin-bottom:0px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Начало АДМИН</div>
      </div>
	<div id="whiteDIV" style="background-color:#F5F5F5;float:left;margin-left:20px;" >	 
<!-- Text na ARTICLE -->
        <div id="tabs" style="float:left; height:auto;  padding:0px 20px 0px 20px; width:440px; background-color:#F5F5F5; font-size: 14px; color: #467B99;" >
                          
            <ul id="maintab" class="shadetabs">
                <li class="selected"><a href="random_cars.php" rel="ajaxcontentarea">Избрана</a></li>				
            </ul>
            <div id="ajaxcontentarea" class="contentstyle" ></div>    
            <script type="text/javascript">
            //Start Ajax tabs script for UL with id="maintab" Separate multiple ids each with a comma.
            startajaxtabs("maintab")
            </script>		 
          <!--Krai na Text na ARTICLE -->
          
        </div>	<!-- KRAI na ARTICLE -->
      </div>
      <div id="Main_Top_Bottom" style="background-color:#F5F5F5;float:left;margin-left:20px;width:480px;" >	 
      </div>
</div>	<!-- KRAI na Main_Top -->

    
    
<div id="Main_Bottom" style="float:left; margin-top:0px; width:500px;">	  
	     <div id="ARTICLE_LIST" style="float:left; margin-left:0px;margin-top:5px; height:31px; padding-left:30px; padding-bottom:0px; background-image:url(images/h5.gif); background-position:left; background-repeat:no-repeat;">
	       <div style=" float:left; margin-top:12px; font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif;">Новини</div>
	     </div>
	 
	  
	  <!-- ARTICLES LIST -->	  
	<?php
	  for ($i=0;$i<$numNews;$i++)
		{
	?>		
	 
	<div class="ofr_top" id="ofr_top<?=$i?>" style="width:500px; float:left; display:none;"> </div>
	
	<div id="OFFER<?=$i?>" class="offer" onMouseover="this.style.backgroundColor='lightblue';$('ofr_top<?=$i?>').show();$('ofr_down<?=$i?>').show();" onmouseout="this.style.backgroundColor='#FFFFFF';$('ofr_top<?=$i?>').hide();$('ofr_down<?=$i?>').hide();"
         onMouseout="this.style.backgroundColor='#FFFFFF';" style="float:left;background-color:#FFFFFF; width:500px;">
                <div  style="float:left; margin-left:20px; width:500px; " align="left"><strong style="color:#FF8400"><?=$resultNews[$i]['title'] ?></strong></div>
                
                 <div style="float:left; margin-left:5px; padding:0px; width:460px; font-size: 14px; color: #467B99;" align="justify">
                  <table>
                  	<tr>
                        <td width="15px" bgcolor="#E7E7E7"></td>
                        <td style="padding:10px;">
                         <div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:218px; background-repeat:no-repeat; font-size:12px; color:#000000;">
                            <div style=" float:left; margin-left:6px; width:150px;" ><?=$resultNews[$i]['date'] ?></div>
                            <div style="float:left; margin-left:15px;" ></div>
                          </div>
                          <div  style="margin-top:5px; width:410px; overflow:hidden; ">
                            <div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; height:80px; width:80px; overflow:hidden; " ><img width="80" height="80" src="../pics/news/<?=$resultNews[$i]['newsID']?>_thumb.jpg" /></div>
	                <?php print stripslashes(substr($resultNews[$i]['body'],0,500))."..."; ?>
	           		 <div align="right"><a href="edit_news.php?page=<?=$page?>&newsID=<?=$resultNews[$i]['newsID'] ?>">Още</а></div>
	            
	               	</tr>
	               </table>
            	  </div>
            
       </div>    
   
	<div class="ofr_down" id="ofr_down<?=$i?>" style="width:500px; float:left; display:none;"></div>  
	<?php } ?>

		<!-- KRAI na ARTICLE LIST-->	   
	
	</div>	
	<!-- KRAI na Main_Bottom -->
<script type="text/javascript">
Event.observe(window, 'load', function() { 	   
Rounded("div.ofr_top","tl","#FFF","lightblue");
Rounded("div.ofr_down","bl br","#FFF","lightblue");
}
);
</script>
        