<?php
include_once("../inc/dblogin.inc.php");

 $postID=substr($_SERVER['HTTP_REFERER'],strpos($_SERVER['HTTP_REFERER'],"postID=")+7);

if (isset($postID))
{
	
	$sql="SELECT p.postID as 'postID', p.date as 'date', p.title as 'title', p.body as 'body', p.picURL as 'picURL', p.autor as 'autor', p.source as 'source', pc.name as 'category' FROM posts p, post_category pc WHERE p.post_category=pc.id AND p.postID='".$postID."'";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultPostsBig=$conn->result;	
	
	
	$sql="SELECT post_id, SUM(cnt) as 'cnt' FROM log_posts WHERE post_id='".$postID."' GROUP BY post_id";
	$conn->setsql($sql);
	$conn->getTableRow();
	$resultPostsCnt=$conn->result;	
	
	
	$sql="SELECT commentID, sender_name , sender_email , comment_body , parentID , created_on  FROM post_comment WHERE postID='".$postID."' ORDER BY created_on DESC";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultPostsComment=$conn->result;	
    $numPostsComment=$conn->numberrows;
	

	
}


?>
<div style="float:left; margin-top:10px; margin-bottom:10px; width:420px;">
 		<div style="float:right; margin-right:0px;margin-bottom:20px; width:400px; " align="right"><span style="color:#467B99"><i><u><?=$resultPostsBig['source'] ?></i></u></span>
 		</div>
	    <div style="float:left; margin-left:20px;margin-bottom:10px; width:400px; " align="left"><strong style="color:#FF8400"><?=$resultPostsBig['title'] ?></strong>
	    </div>
	    <div style="float:left; margin-left:0px; width:420px;">
		 <div style="float:left; margin-left:5px; padding:0px; width:400px; font-size: 14px; color: #467B99;" align="justify">
		  <table><tr>
			<td style="width:15px;" bgcolor="#E7E7E7">&nbsp;&nbsp;&nbsp;</td>
			<td style="padding:10px;">
			 <div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:280px; background-repeat:no-repeat; font-size:12px; color:#000000;">
				<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultPostsBig['date'] ?></i></div></div>
				<div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"><?=$resultPostsBig['category']?></div>
			</div>
			 <div  style="margin-top:5px; width:400px; overflow:hidden; ">
       			<div style="float:left; border:double; border-color:#666666; margin-left:0px;margin-right:10px; width:250px; overflow:hidden; " ><a href="edit_posts.php?postID=<?=$postID?>"><img src="../pics/posts/<?php if($resultPostsBig['picURL']<>'') print $postID.".jpg"; else print "no_photo_big.png";?>" /></a>
       			</div>
			<?php print stripslashes($resultPostsBig['body']); ?>
		
				</tr>
			</table>
				
			<div style="float:right; margin-right:10px; width:420px; " align="right"><span style="color:#FF8400"><u>Прочетена <?=$resultPostsCnt['cnt'] ?> пъти</u></span></div>
   		  </div>
		   
	    </div>
	    
	    	 <br style="clear:both;"/> 
	
		<hr style="float:left; margin:20px 20px 0px 20px; width:420px;" /> 	   
	    
	    	<a style="float:right;margin-right:0px;margin-top:10px;" href="javascript://" onclick=" new Effect.toggle($('readComment'),'Blind'); ">Коментари (виж/скрий)</a> 
	    	   		    	
					<br /> 
				<div id="readComment" style="float:left;display:none;margin-left:0px;">
				
				
			<?php if($numPostsComment>0)
	    	{
	    	    for($i=0;$i<$numPostsComment;$i++)
	    	    {
	    	?>	    	
                 <div style="float:left; margin-left:0px; width:460px;">
		 			<div style="float:left; margin-left:5px; padding:0px; width:420px; font-size: 14px; color: #467B99;" align="justify">
            		  <table>
            		  	<tr>
            				<td width="15px" bgcolor="#E7E7E7"></td>
            				<td style="padding:10px;">
            			 		<div style="background-image:url(images/fon_header_blue.png); margin-left:0px;margin-bottom:10px; height:20px; width:218px; background-repeat:no-repeat; font-size:12px; color:#000000;">
            					<div style="float:left; margin-left:10px;"><div style="float:left; color:#000000; "><i><?=$resultPostsComment[$i]['created_on'] ?></i></div><div style="float:right; font-weight:bold; color:#FFFFFF; margin-right:5px;"><?=$resultPostsComment[$i]['sender_name']?></div></div>
            					</div>
            			  		<div  style="margin-top:5px; width:360px; overflow:hidden; ">
                   		
            	        <?php print stripslashes($resultPostsComment[$i]['comment_body']); ?>
            
            		  </tr>
            		</table>
		 		 </div>		   
	    	  </div>
	    	
	    	<?php   
                } 
	    	}    	   	
	    	
	    	?>
	    	
	    	 <br />
	    	 
	    	  <hr style="float:left; margin:20px 20px 0px 20px; width:420px;"/> 	   
	    
	    	<a style="float:right;margin-right:0px;margin-top:10px;" href="javascript://" onclick=" new Effect.toggle($('writeComment'),'Blind'); ">Коментирай (виж/скрий)</a> 
	    	
				 <br /> 
				 
				 <div id="writeComment" style="float:left;display:none;margin-left:0px;">
				  
				  <br /> 
				  
    				 	<input type="hidden" name="postID" value="<?=$postID?>"/>
    				  Името Ви:<br /> <input type="text" name="sender_name" id="sender_name" maxlength="30"/>
    				  <br /> 
    				  <br /> 
    				  Е-мейлът Ви:<br /> <input type="text" name="sender_email" id="sender_email" maxlength="30"/>
    				  <br /> 
    				  <br /> 
    				  				
    				 Текст на Коментара:<br /> 
    				 <textarea rows = "4" cols = "40"  name="comment_body" id="comment_body" ></textarea>
    								  
    				  <br /> 
    				  <input type="image"  value="Добави" src="images/btn_gren_insert.png" id="insert_comment_btn" title="Добави Коментар" name="insert_comment_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
						
    			</div>
		  		
			</div>		   
				
  </div>
