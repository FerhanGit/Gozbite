<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$archive_and_baner_120_240 = "";
	$archive_and_baner_120_240 .= '<li class="boxRightHalf" style="margin-right:0;padding-right:0px;">
		<div class="title" style="margin-bottom:10px">Архив - Статии</div>
		 <div class="contentBox">';
			$archive_and_baner_120_240 .= '<div id="calback">
							<div id="calendar"></div>
						</div>'; 
	$archive_and_baner_120_240 .= '</div>';
		
		$archive_and_baner_120_240 .= '<div class="title" style="margin-top:20px;margin-bottom:10px">Реклама</div>
		 <div class="contentBox">			
        	<div style="z-index:1;">
				
				<script type=\'text/javascript\'><!--//<![CDATA[
				   var m3_u = (location.protocol==\'https:\'?\'https://www.gozbite.com/openx/www/delivery/ajs.php\':\'http://www.gozbite.com/openx/www/delivery/ajs.php\');
				   var m3_r = Math.floor(Math.random()*99999999999);
				   if (!document.MAX_used) document.MAX_used = \',\';
				   document.write ("<scr"+"ipt type=\'text/javascript\' src=\'"+m3_u);
				   document.write ("?zoneid=2&amp;source=gozbite");
				   document.write (\'&amp;cb=\' + m3_r);
				   if (document.MAX_used != \',\') document.write ("&amp;exclude=" + document.MAX_used);
				   document.write (document.charset ? \'&amp;charset=\'+document.charset : (document.characterSet ? \'&amp;charset=\'+document.characterSet : \'\'));
				   document.write ("&amp;loc=" + escape(window.location));
				   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
				   if (document.context) document.write ("&context=" + escape(document.context));
				   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
				   document.write ("\'><\/scr"+"ipt>");
				//]]>-->
				</script><noscript><a href=\'http://www.gozbite.com/openx/www/delivery/ck.php?n=af6c55c8&amp;cb=INSERT_RANDOM_NUMBER_HERE\' target=\'_blank\'><img src=\'http://www.gozbite.com/openx/www/delivery/avw.php?zoneid=2&amp;source=gozbite&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=af6c55c8\' border=\'0\' alt=\'\' /></a></noscript>

			</div>';
      		 
	$archive_and_baner_120_240 .= '</div><br />	
    </li>';
	
	
	return $archive_and_baner_120_240;
	  
	?>
