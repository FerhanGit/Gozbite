<div id="BANER_KVADRAT_AND_NEWS_DIV" style="float:left;padding:0px 0px 0px 0px;">
	
      
   	<div id="NEWS" style="float:left; width:330px;margin-left:10px;color:#FF8400;">
			 <?php
	
				$colorArr[0] = 'blue';
				$colorArr[1] = 'red';
			    $colorArr[2] = 'green';
				$colorArr[3] = 'green';
				   
				$itmNum = 4;
				   	 
			?>
				 
				 		<div id="newsButtons" style="float:right;width:270px;padding-left:10px;" align="center">
			<?php
					
					if($itmNum > 0)
					{
						for ($i=0;$i<$itmNum;$i++)
					   	{		   			
			?>
							<img id="newsButton<?=$i?>" class="newsButton" style="float:left;margin:2px 10px 2px 0px;width:30px;height:30px;cursor:pointer;cursor:hand;" align="center" onmouseover="window.clearInterval(t);onMouseOverUpdate(<?=$i?>);" onmouseout="t=window.setInterval('autoUpdate()', 30000);count=<?=(($i+1)<4)?($i+1):0?>;"  src="images/<?=$colorArr[$i]?>_six.png" />
			<?php
					   	}
					}
					else print "В момента няма значими новини...";
			?>
					</div>
					
					
				<div style="float:left;">
					<div class="newsDIVContainer" id="newsDIVContainer" style="width:320px;float:left;margin-top:10px;margin-bottom:0px;">
						<div id="newsDIV" style="width:320px;height:250px;overflow:hidden;"></div>
					</div>
				  
			<script type="text/javascript">
				
				var count = '0';
				function autoUpdate()
				{
					var typeArr= new Array(4)
					typeArr[0]="posts";
					typeArr[1]="bolesti";
					typeArr[2]="hospitals";
					typeArr[3]="doctors";
					
					new Ajax.Updater('newsDIV', 'index_inc/Ajax_'+typeArr[count]+'_ticker.php', {
					  method: 'get',onSuccess: function() {
				                       new Effect.Opacity('newsDIV', {duration: 0.5, from:0.5, to:1.0});
									   new Effect.Opacity('newsDIVContainer', {duration: 0.5, from:0.5, to:1.0});
				              }
					});
					
					$('newsButton0').src="images/blue_six.png";
					$('newsButton1').src="images/red_six.png";
					$('newsButton2').src="images/green_six.png";
					$('newsButton3').src="images/green_six.png";
					$('newsButton'+count).src="images/orange_six.png";
					
					count ++;
					if(count == 4) {count = 0;}
					
				}
				
				Event.observe(window, 'load', function() 
				{ 	   
					t=window.setInterval("autoUpdate()", 30000);
					autoUpdate();
				});
				
					
				function onMouseOverUpdate(count2)
				{
					var typeArr= new Array(4)
					typeArr[0]="posts";
					typeArr[1]="bolesti";
					typeArr[2]="hospitals";
					typeArr[3]="doctors";
					
					new Ajax.Updater('newsDIV', 'index_inc/Ajax_'+typeArr[count2]+'_ticker.php', {
					  method: 'get',onSuccess: function() {
					  	 			   new Effect.Opacity('newsDIV', {duration: 0.5, from:0.5, to:1.0});
				                       new Effect.Opacity('newsDIVContainer', {duration: 0.5, from:0.5, to:1.0});
				              			}
					});	
					
					$('newsButton0').src="images/blue_six.png";
					$('newsButton1').src="images/red_six.png";
					$('newsButton2').src="images/green_six.png";
					$('newsButton3').src="images/green_six.png";
					$('newsButton'+count2).src="images/orange_six.png";
					
					
				}
				
			</script>
				
			
					
				</div>
				
	
   	</div>
   	
   	<div id="BANER_KVADRAT" style="float:left; width:310px;padding-right:0px;overflow:hidden;">

   

   		<div style="float:right;background-image:url(images/reklama_<?=$theme_color?>.png);margin-bottom:15px; height:28px; width:144px; background-repeat:no-repeat; font-size:12px; color:#FFFFFF;"></div>
   		<div style="float:left;border-style:double;">

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
   var m3_u = (location.protocol=='https:'?'https://www.intermobile-bg.com/openx/www/delivery/ajs.php':'http://www.intermobile-bg.com/openx/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?zoneid=4");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>-->
</script><noscript><a href='http://www.intermobile-bg.com/openx/www/delivery/ck.php?n=af261e3c&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://www.intermobile-bg.com/openx/www/delivery/avw.php?zoneid=4&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=af261e3c' border='0' alt='' /></a></noscript>

   		</div>
   	</div>
</div>