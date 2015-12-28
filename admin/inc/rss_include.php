<?php
 
//$rssFeed = "http://dnes.dir.bg/rss20.xml";
$rssFeed= "http://news.ibox.bg/rss_1";
$xml=simplexml_load_file($rssFeed, null, LIBXML_NOCDATA);

echo '<br/><marquee onMouseOver="this.stop();" onMouseOut="this.start();" behavior="scroll" direction="up" scrollamount="2" scrolldelay="100">';
if(is_object($xml) && !empty($xml))
foreach($xml->channel->item as $val)
	{
		
		$title = $val->title; 
		$url = $val->enclosure['url'];		
		$link=(string) $val->link;				
		$description=(string) $val->description;
		$body=(string) $val->body;
		$pubDate=(string) $val->pubDate;
		
	?>	
	 <div style="font-size:9px;">
	<?php if($url)
	{?>
		<a href='<?=$link?>' target="_blank"><img width="60" height="60" src='<?=$url?>' style="float: left; margin: 0px 2px 0px 0px; border:double; border-color:#666666;" /></a>
	<?php
	}
	  print '<a href="'.$link.'" target="_blank"><i>'.$title."</i><br style='clear: left' />";
      echo $description.'<br style="clear: left" />';
      echo '</div><br style="clear: left" />';
	print "<hr><br style='clear: left' /></a>";
	}

echo '</marquee>';

?>