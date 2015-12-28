<?php
if(!empty($_REQUEST['category']) or !empty($_REQUEST['question_category']))
{
	$sql="SELECT postID,title FROM posts WHERE body LIKE '%".get_question_category($_REQUEST['category']?$_REQUEST['category']:$_REQUEST['question_category'])."%' OR title LIKE '%".get_question_category($_REQUEST['category']?$_REQUEST['category']:$_REQUEST['question_category'])."%' ORDER BY RAND() DESC LIMIT 5";
}
else 
{
	$sql="SELECT postID,title FROM posts ORDER BY RAND() DESC LIMIT 5";
}
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultLastHospitals=$conn->result;
		$numLastHospitals=$conn->numberrows;
				
?>
<div id="orange_dqsno" style="float:left;">
    <div id="orange_dqsno_otpred" align="center" style="float:left; width:140px; height:18px; padding:0px 5px 2px 5px; color: #FFFFFF; font-size: 12px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; background-image:url(images/right_gorno_<?=$theme_color?>.png);">Статии от областа 
            <?php //include("inc/user_info.inc.php")?>		  
    </div>
</div>

<div style="float:left; background-color:#F7F7F7; margin-bottom:10px;">

<div id="BANER-LEFT" align="left" style="float:left; width:148px; font-weight:normal; font-size:12px; color:#666666; padding:10px 0px 10px 0px;  border-left: 1px solid #999999;border-right: 1px solid #999999;">
<?php
if($numLastHospitals>0)
for($i=0;$i<$numLastHospitals;$i++)
{
?>
  <div class="last_posts" style=" float:left; margin:5px; width:140px; background-color:#E7E7E7;">
	<div style="margin:5px;"><a href="posts.php?postID=<?=$resultLastHospitals[$i]['postID']?>" ><?=$resultLastHospitals[$i]['title']?></a></div>
  </div>
<?php
}
else 
{
?>
  <div class="last_posts" style=" float:left; margin:5px; width:140px; background-color:#E7E7E7;">
	<div style="margin:5px;">Няма статии от тази област</div>
  </div>
<?php
}
?>
</div>

<div style="float:left;"><img width="150" src="images/<?=$theme_color?>_bottom.png"></div>


</div>









<div id="orange_dqsno" style="float:left;">
    <div id="orange_dqsno_otpred" align="center" style="float:left; width:140px; height:18px; padding:0px 5px 2px 5px; color: #FFFFFF; font-size: 12px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; background-image:url(images/right_gorno_<?=$theme_color?>.png);">Реклама 
            <?php //include("inc/user_info.inc.php")?>		  
    </div>
</div>

<div style="float:left; background-color:#F7F7F7; margin-bottom:10px;">

	<div id="BANER-RIGHT" align="justify" style="float:left; width:148px;  font-weight:normal; font-size:12px; color:#666666; padding:10px 0px 10px 0px;  border-left: 1px solid #999999;border-right: 1px solid #999999;">
	  <div style="float:left;margin:4px;">
	  
	<!--/* OpenX Javascript Tag v2.4.4 */-->

<!--/*
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  *   'http://localhost/WS/openx/www/delivery/...'
  * to
  *   'https://localhost/WS/openx/www/delivery/...'
  *
  * This noscript section of this tag only shows image banners. There
  * is no width or height in these banners, so if you want these tags to
  * allocate space for the ad before it shows, you will need to add this
  * information to the <img> tag.
  *
  * If you do not want to deal with the intricities of the noscript
  * section, delete the tag (from <noscript>... to </noscript>). On
  * average, the noscript tag is called from less than 1% of internet
  * users.
  */-->

<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://localhost/WS/openx/www/delivery/ajs.php':'http://localhost/WS/openx/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?zoneid=5&amp;source=NEWS_140x300");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href='http://localhost/WS/openx/www/delivery/ck.php?n=a53bdd45&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://localhost/WS/openx/www/delivery/avw.php?zoneid=5&amp;source=NEWS_140x300&amp;n=a53bdd45' border='0' alt='' /></a></noscript>

	  </div>
	</div>
	
	<div style="float:left;"><img width="150" src="images/<?=$theme_color?>_bottom.png"></div>


</div>







<div id="orange_dqsno" style="float:left;">
    <div id="orange_dqsno_otpred" align="center" style="float:left; width:140px; height:18px; padding:0px 5px 2px 5px; color: #FFFFFF; font-size: 12px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; background-image:url(images/right_gorno_<?=$theme_color?>.png);">Не е за изпускане
            <?php //include("inc/user_info.inc.php")?>		  
    </div>
</div>

<div style="float:left; background-color:#F7F7F7; margin-bottom:10px;">

	<div id="BANER-LEFT" style="float:left; width:148px;  font-weight:normal; font-size:12px; color:#666666; padding:10px 0px 10px 0px;  border-left: 1px solid #999999;border-right: 1px solid #999999;">
	  <div style="float:left;margin:15px;" >
	<script type="text/javascript"><!--
google_ad_client = "pub-7084745543699987";
/* 120x600, created 8/23/08 */
google_ad_slot = "3207160219";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
	  </div>
	</div>
	
	
	<div style="float:left;"><img width="150" src="images/<?=$theme_color?>_bottom.png"></div>


</div>




<div id="orange_dqsno" style="float:left;">
    <div id="orange_dqsno_otpred" align="center" style="float:left; width:140px; height:18px; padding:0px 5px 2px 5px; color: #FFFFFF; font-size: 12px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; background-image:url(images/right_gorno_<?=$theme_color?>.png);">Намери си имота 
            <?php //include("inc/user_info.inc.php")?>		  
    </div>
</div>

<div style="float:left; background-color:#F7F7F7; margin-bottom:10px;">

	<div id="BANER-LEFT" align="justify" style="float:left; width:148px;  font-weight:normal; font-size:12px; color:#666666; padding:10px 0px 10px 0px;  border-left: 1px solid #999999;border-right: 1px solid #999999;">
	  <div style="float:left;margin:5px;">
	  <iframe src="http://largo.bg/largo_search_baner.php?width=140" width="140" height="220" frameborder="0" scrolling="No">
</iframe>
	  </div>
	</div>
	
	
	<div style="float:left;"><img width="150" src="images/<?=$theme_color?>_bottom.png"></div>


</div>
