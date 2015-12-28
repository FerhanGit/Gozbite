<?php




	$sql="SELECT n.newsID as 'newsID', n.date as 'date', n.title as 'title', n.body as 'body', n.picURL as 'picURL', n.autor as 'autor', n.source as 'source', nc.name as 'category' FROM news n, news_category nc WHERE n.news_category=nc.id ORDER BY rand() LIMIT 1";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultNewsRandom=$conn->result;
	$numNewsRandom=$conn->numberrows;

	$sql="SELECT news_id, SUM(cnt) as 'cnt' FROM log_news WHERE news_id='".$resultNewsRandom['newsID']."' GROUP BY news_id";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultNewsRandomCnt=$conn->result;
?>

<div  id="newsDiv" style="float:left; margin-top:10px; margin-bottom:10px; width:420px;">
		<div style="float:left;width:420px;">
			<div style="float:left;"><a href="javascript:void(0);" onclick="newsFsize(2)" title="увеличи размера на текста" style="font-size:16px;">A+|</a> <a href="javascript:void(0);" onclick="newsFsize_d()" title="нормален размер" style="font-size:14px;">A|</a> <a href="javascript:void(0);" onclick="newsFsize(-2)" title="намали размера на текста" style="font-size:12px;">A-</a></div>
			<div style="float:right; margin-right:2px;" ><?php printf("<a href = \"javascript://\" onclick = \"window.open('news_inc/sendtofriend.php?newsID=%d', 'sndWin', 'top=0, left=0, width=440px, height=500px, resizable=yes, toolbars=no, scrollbars=yes');\" class = \"smallOrange\">", $resultNewsRandom['newsID']);?><img style="margin-left:5px;" src="images/send_to_friend.png" alt="Изпрати на приятел" width="14" height="14"></a></div>
		</div>			
		<div style="float:right; margin-right:0px;margin-bottom:20px; width:400px; " align="right"><span style="color:#333333;"><i><u><?=$resultNewsRandom['source'] ?></i></u></span></div>
	    <div style="float:left; margin-left:20px;margin-bottom:10px; width:400px; " align="left"><strong style="color:#FF8400;"><?=$resultNewsRandom['title'] ?></strong></div>
	    <div style="float:left; margin-left:0px; width:420px;">
		 <div style="float:left; margin-left:5px; padding:0px; width:400px; font-size: 14px; color: #333333;" align="justify">
		  <table><tr>
			<td style="width:15px;" bgcolor="#E7E7E7">&nbsp;&nbsp;&nbsp;</td>
			<td style="padding:10px;">
			 <div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
				<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultNewsRandom['date'] ?></i></div></div>
				<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:10px;"><?=$resultNewsRandom['category']?></div>
			</div>
			  <div id="newsBodyDiv"  style="margin-top:5px; width:420px; overflow:hidden; ">
       			<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; width:250px; overflow:hidden; " ><img width="250" src="pics/news/<?=$resultNewsRandom['picURL']?>" /></div>
	<?php print stripslashes($resultNewsRandom['body']); ?>

		</tr></table>
   		  </div>
		   	
   		  
   		    		  
<div id="starDiv" style=" float:left;width:200; margin-top:20px;"> </div>
<?php 
	$sql="SELECT rating, times_rated FROM news WHERE newsID = '".$resultNewsRandom['newsID']."' ";
	$conn->setsql($sql);
	$conn->getTableRow();
	$RatingResult = $conn->result;
?>
<script language='javascript' type='text/javascript'>
   new Starbox('starDiv', <?=$RatingResult['rating']?>, { rerate: false, max: 6, stars: 6, buttons: 12, color:'#FF6600',hoverColor:'#B9F4A8', total: <?=$RatingResult['times_rated']?>, indicator: ' Рейтинг #{average} от #{total} гласа', ghosting: true ,onRate: function(element, info) {
   	var indicator = element.down('.indicator');
  	var restore = indicator.innerHTML;
    indicator.update('Вие дадохте оценка ' + info.rated.toFixed(2));
    window.setTimeout(function() { indicator.update('Благодарности!') }, 2000);
    //window.setTimeout(function() { indicator.update(restore) }, 4000);
    new Effect.Highlight(indicator);
    
     
	}});
	
function saveStar(event) {
			
	  new Ajax.Request('news_inc/savestar.php?newsID=<?=$resultNewsRandom['newsID']?>', {
	    parameters: event.memo,  
	    onSuccess: function(transport) {
		   	var indicator = $('starDiv').down('.indicator');
		    if (transport.responseText){   
		    	window.setTimeout(function() { indicator.update(transport.responseText) }, 4000);  	    	  		    	    	
		    }     
		    else indicator.update('Вие ще сте пръв с Вашата оценка');	  
			}
		}
	  );
}
         
document.observe('starbox:rated', saveStar);


</script>




   		  <div style="float:right; margin-right:0px; margin-top:20px; width:420px; " align="right"><span style="color:#FF8400"><u>Прочетено <?=$resultNewsRandomCnt['cnt']?$resultNewsRandomCnt['cnt']:1 ?> пъти</u></span></div>
   		
	    </div>
	  </div>