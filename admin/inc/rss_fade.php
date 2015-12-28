<div align="center">
<script type="text/javascript">
var tickercontents=new Array()	
</script>
<?php
 
//$rssFeed = "http://dnes.dir.bg/rss20.xml";
$rssFeed= "http://news.ibox.bg/rss_1";
$xml=simplexml_load_file($rssFeed, null, LIBXML_NOCDATA);
$news="";
$i=0;
foreach($xml->channel->item as $val)
	{
		
		$title = $val->title; 
		$url = $val->enclosure['url'];		
		$link=(string) $val->link;				
		$description=(string) $val->description;
		$body=(string) $val->body;
		$pubDate=(string) $val->pubDate;
		
	if($url)
	{
		$news .='<a href='.$link.' target="_blank"><img width="60" height="60" src='.$url.' style="float: left; margin: 0px 2px 0px 0px; border:double; border-color:#666666;" />';
	}
	  	$news .= '<i>'.$title.'</i><br style="clear: left" />';
      	$news .= $description.'<br style="clear: left" />';
      
		$news .= '<hr><br style="clear: left" /></a>';
	
	?>
		<script type="text/javascript">
		tickercontents['<?php print $i;?>']='<?php print $news;?>'
		</script>
	<?php
		$i++;
	}


?>



<script type="text/javascript">
var tickerwidth="135px"
var tickerheight="290px"
var fontcss="font: 9px Verdana;"
var tickdelay=3000 //delay btw messages
var highlightspeed=5 //2 pixels at a time.
var highlightcolor="#99FF99"
var backdroptextcolor="#E1E1E1"

////Do not edit pass this line////////////////

document.write('<style>#highlighterbg a{color:'+backdroptextcolor+'}</style>')
document.write('<div style="position:relative;left:0px;top:0px; width:'+tickerwidth+'; '+fontcss+'">')
document.write('<span id="highlighterbg" style="position:absolute;left:0;top:0;color:'+backdroptextcolor+'; width:'+tickerwidth+';"></span><span id="highlighter" style="position:absolute;left:0;top:0;clip:rect(auto auto auto auto); background-color:'+highlightcolor+'; width:'+tickerwidth+';height:'+tickerheight+';"></span>')
document.write('</div>')

var currentmessage=0
var clipbottom=1

function changetickercontent(){
msgheight=clipbottom=crosstick.offsetHeight
crosstick.style.clip="rect("+msgheight+"px auto auto 0px)"
crosstickbg.innerHTML=tickercontents[currentmessage]
crosstick.innerHTML=tickercontents[currentmessage]
highlightmsg()
}

function highlightmsg(){
//var msgheight=crosstick.offsetHeight
if (clipbottom>0){
clipbottom-=highlightspeed
crosstick.style.clip="rect("+clipbottom+"px auto auto 0px)"
beginclip=setTimeout("highlightmsg()",20)
}
else{
clipbottom=msgheight
clearTimeout(beginclip)
if (currentmessage==tickercontents.length-1) currentmessage=0
else currentmessage++
setTimeout("changetickercontent()",tickdelay)
}
}

function start_ticking(){
crosstickbg=document.getElementById? document.getElementById("highlighterbg") : document.all.highlighterbg
crosstick=document.getElementById? document.getElementById("highlighter") : document.all.highlighter
crosstickParent=crosstick.parentNode? crosstick.parentNode : crosstick.parentElement
if (parseInt(crosstick.offsetHeight)>0)
crosstickParent.style.height=crosstick.offsetHeight+'px'
else
setTimeout("crosstickParent.style.height=crosstick.offsetHeight+'px'",100) //delay for Mozilla's sake
changetickercontent()
}

if (document.all || document.getElementById)
window.onload=start_ticking

</script>
</div>
