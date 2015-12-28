<?php
include_once("../inc/dblogin.inc.php");

 $newsID=substr($_SERVER['HTTP_REFERER'],strpos($_SERVER['HTTP_REFERER'],"newsID=")+7);

if (isset($newsID))
{
	
	$sql="SELECT n.newsID as 'newsID', n.date as 'date', n.title as 'title', n.body as 'body', n.picURL as 'picURL', n.autor as 'autor', n.source as 'source', nc.name as 'category' FROM news n, news_category nc WHERE n.news_category=nc.id AND newsID='".$newsID."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultNewsBig=$conn->result;	
	
	
	$sql="SELECT news_id, SUM(cnt) as 'cnt' FROM log_news WHERE news_id='".$newsID."' GROUP BY news_id";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultNewsCnt=$conn->result;	
	
	
	$sql="SELECT commentID, sender_name , sender_email , comment_body , parentID , created_on  FROM news_comment WHERE newsID='".$newsID."' ORDER BY created_on DESC";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultNewsComment=$conn->result;	
    $numNewsComment=$conn->numberrows;
	

	
}


?>
<div style="float:left; margin-top:10px; margin-bottom:10px; width:420px;">
		<div style="float:right; margin-right:0px;margin-bottom:20px; width:400px; " align="right"><span style="color:#333333"><i><u><?=$resultNewsBig['source'] ?></i></u></span></div>
	    <div style="float:left; margin-left:20px;margin-bottom:10px; width:400px; " align="left"><strong style="color:#FF8400"><?=$resultNewsBig['title'] ?></strong></div>
	    <div style="float:left; margin-left:0px; width:420px;">
		 <div style="float:left; margin-left:5px; padding:0px; width:400px; font-size: 14px; color: #333333;" align="justify">
		  <table><tr>
			<td style="width:15px;" bgcolor="#E7E7E7">&nbsp;&nbsp;&nbsp;</td>
			<td style="padding:10px;">
			 <div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
				<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultNewsBig['date'] ?></i></div></div>
				<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"><?=$resultNewsBig['category']?></div>
			</div>
			  <div  style="margin-top:5px; width:420px; overflow:hidden; ">
       			<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; width:250px; overflow:hidden; " ><img src="../pics/news/<?=$resultNewsBig['picURL']?>" /></div>
	<?php print stripslashes($resultNewsBig['body']); ?>

		</tr></table>
   		  </div>

   		  <div style="float:right; margin-right:0px; margin-top:20px; width:400px; " align="right"><span style="color:#FF8400;float:right; margin-right:0px;"><u>Прочетено <?=$resultNewsCnt['cnt']?$resultNewsCnt['cnt']:1 ?> пъти</u></span></div>
   		
	    </div>
	  </div>
	    
	    	 <br style="clear:both;"/> 
	
		<hr style="float:left; margin:20px 20px 0px 20px; width:420px;" /> 	   
	    
	    	<a style="float:right;margin-right:20px;margin-top:10px;" href="javascript://" onclick=" new Effect.toggle($('readComment'),'Blind'); ">Коментари (<?=$numNewsComment?>)</a> 
	    	   		    	
					<br style="clear:both;"/> 
				<div id="readComment" style="float:left;display:none;margin-left:20px;">
				
				
			<?php if($numNewsComment>0)
	    	{
	    	    for($i=0;$i<$numNewsComment;$i++)
	    	    {
	    	?>	    	
                 <div style="float:left; margin-left:0px; width:460px;">
		 			<div style="float:left; margin-left:5px; padding:0px; width:410px; font-size: 14px; color: #467B99;" align="justify">
            		  <table>
            		  	<tr>
            				<td width="15px" bgcolor="#E7E7E7"></td>
            				<td style="padding:10px;">
            			 		<div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:245px; background-repeat:no-repeat; font-size:12px; color:#000000;">
            						<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultNewsComment[$i]['created_on'] ?></i></div></div>
            						<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"><?=$resultNewsComment[$i]['sender_name']?></div>
            					</div>
            			  		<div  style="margin-top:5px; width:360px; overflow:hidden; ">
                   		
            	        <?php print stripslashes($resultNewsComment[$i]['comment_body']); ?>
            
            		  </tr>
            		</table>
		 		 </div>		   
	    	  </div>
	    	
	    	<?php   
                } 
	    	}    	   	
	    	
	    	?>
	    	
	    	 <br />
	    	 
	    	  <hr style="float:left; margin:20px 20px 0px 0px; width:420px;"/> 	   
	    
	    	<a style="float:right;margin-right:20px;margin-top:10px;" href="javascript://" onclick=" new Effect.toggle($('writeComment'),'Blind'); ">Коментирай</a> 
	    	
				<br style="clear:both;"/> 
				 
				 <div id="writeComment" style="float:left;display:none;margin-left:20px;">
				  
				 <br style="clear:both;"/> 
				  
    				 	<input type="hidden" name="newsID" value="<?=$newsID?>"/>
    				  Името Ви:<br /> <input type="text" name="sender_name" id="sender_name" maxlength="30"/>
    				  <br /> 
    				  <br /> 
    				  Е-мейлът Ви:<br /> <input type="text" name="sender_email" id="sender_email" maxlength="30"/>
    				  <br /> 
    				  <br /> 
    				  				
    				 Текст на Коментара:<br /> 
    				 <textarea rows = "4" cols = "40"  name="comment_body" id="comment_body" ></textarea>
    								  
    				  <br />  <br /> 
    				  <input type="image"  value="Добави" src="images/btn_gren_insert.png" id="insert_comment_btn" title="Добави Коментар" name="insert_comment_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
						
    			</div>
		  		
			</div>		   
				
  </div>
