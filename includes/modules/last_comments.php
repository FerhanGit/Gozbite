<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/


	   require_once("includes/functions.php");
	   require_once("includes/config.inc.php");
	   require_once("includes/bootstrap.inc.php");
   
   		$conn = new mysqldb();
   
   		$last_comments = "";
		$last_comments .= '<div class="boxRight">
							<div class="title" style="margin-bottom:10px">Последни коментари</div>
						      	<div class="contentBox">';
  	
		$sql="SELECT commentID, post_id, autor_type, autor, sender_name, comment_body, created_on FROM post_comment ORDER BY created_on DESC LIMIT 1";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultLastCommentsPosts 	= $conn->result;
		$numLastCommentsPosts 		= $conn->numberrows;
		
		$sql="SELECT commentID, bolestID, autor_type, autor, sender_name, comment_body, created_on FROM bolest_comment ORDER BY created_on DESC LIMIT 1";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultLastCommentsBolesti 	= $conn->result;
		$numLastCommentsBolesti 		= $conn->numberrows;
		
		$sql="SELECT commentID, lekarstvoID, autor_type, autor, sender_name, comment_body, created_on FROM lekarstvo_comment ORDER BY created_on DESC LIMIT 1";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultLastCommentsLekarstva 	= $conn->result;
		$numLastCommentsLekarstva 		= $conn->numberrows;
		
		$sql="SELECT commentID, doctorID, autor_type, autor, sender_name, comment_body, created_on FROM doctor_comment ORDER BY created_on DESC LIMIT 1";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultLastCommentsDoctors 	= $conn->result;
		$numLastCommentsDoctors 	= $conn->numberrows;
		
		$sql="SELECT commentID, firmID, autor_type, autor, sender_name, comment_body, created_on FROM hospital_comment ORDER BY created_on DESC LIMIT 1";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultLastCommentsHospitals 	= $conn->result;
		$numLastCommentsHospitals 		= $conn->numberrows;
		
		
		$sql="SELECT questionID, autor_type, autor, question_title, question_body, created_on FROM questions ORDER BY created_on DESC LIMIT 1";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultLastCommentsForum 	= $conn->result;
		$numLastCommentsForum 		= $conn->numberrows;
		
		
		if ($numLastCommentsPosts > 0)
	    {	
	    	$last_comments .= '<table>';
	    	
	    	for ($i=0; $i<$numLastCommentsPosts; $i++)
	    	{
	    		$sql="SELECT postID, title FROM posts WHERE postID = '".$resultLastCommentsPosts[$i]['post_id']."'";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultLastCommentsPostsInfo 	= $conn->result;
				$numLastCommentsPostsInfo 	= $conn->numberrows;
		
	    	$last_comments .= '<tr>
				<td>			
				<div class="postBig">
				<div class="detailsDiv" style="float:left;cursor:pointer; width:280px;margin-bottom:10px; border-top:3px solid #E4DFC8; padding:5px; background-color:#F1F1F1;">
				 <h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; background: #F1F1F1 url(../images/gradient_tile.png) repeat 0 -5px;"><a href="прочети-статия-'.$resultLastCommentsPosts[$i]['post_id'].','.myTruncateToCyrilic($resultLastCommentsPostsInfo[0]['title'],50,' ','').'.html" style="font-size:12px; font-weight:bold;" >Относно '.$resultLastCommentsPostsInfo[0]['title'] .'</a></h3>
			   	<a href="прочети-статия-'.$resultLastCommentsPosts[$i]['post_id'].','.myTruncateToCyrilic($resultLastCommentsPostsInfo[0]['title'],50,' ','').'.html" style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" >		    		
			    &rarr; '.myTruncate($resultLastCommentsPosts[$i]['comment_body'], 150, " ") .' <br />
				</a>
		    	</div> 
		    	</div>	    	
		    	</td>
		 		</tr>	';
	    	}
	    	$last_comments .= '</table>';
    	}
    	
    	
    	
    	
    	if ($numLastCommentsForum > 0)
	    {	
	    	$last_comments .= '<table>';
	    	
	    	for ($i=0; $i<$numLastCommentsForum; $i++)
	    	{
	    				
	    	$last_comments .= '<tr>
				<td>			
				<div class="postBig">
				<div class="detailsDiv" style="float:left;cursor:pointer; width:280px;margin-bottom:10px; border-top:3px solid #E4DFC8; padding:5px; background-color:#F1F1F1;">
				 <h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; background: #F1F1F1 url(../images/gradient_tile.png) repeat 0 -5px;"><a href="разгледай-форум-тема-'.$resultLastCommentsForum[$i]['questionID'].','.myTruncateToCyrilic($resultLastCommentsForum[$i]['question_title'],50,' ','').'.html" style="font-size:12px; font-weight:bold;" >Относно '.$resultLastCommentsForum[$i]['question_title'].'</a></h3>
			   	<a href="разгледай-форум-тема-'.$resultLastCommentsForum[$i]['questionID'].','.myTruncateToCyrilic($resultLastCommentsForum[$i]['question_title'],50,' ','').'.html" style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" >		    		
			    &rarr; '.myTruncate($resultLastCommentsForum[$i]['question_body'], 150, " ") .' <br />
				</a>
		    	</div> 
		    	</div>	    	
		    	</td>
		 		</tr>';
	    	}
	    	$last_comments .= '</table>';
    	}
    	
    	
    	
    	
    	
    	if ($numLastCommentsBolesti > 0)
	    {	
	    	$last_comments .= '<table>';
	    	
	    	
	    	for ($i=0; $i<$numLastCommentsBolesti; $i++)
	    	{
	    		$sql="SELECT bolestID, title FROM bolesti WHERE bolestID = '".$resultLastCommentsBolesti[$i]['bolestID']."'";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultLastCommentsBolestiInfo 	= $conn->result;
				$numLastCommentsBolestiInfo 	= $conn->numberrows;
		
	    	$last_comments .= '<tr>
				<td>			
				<div class="postBig">
				<div class="detailsDiv" style="float:left;cursor:pointer; width:280px;margin-bottom:10px; border-top:3px solid #E4DFC8; padding:5px; background-color:#F1F1F1;">
				 <h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; background: #F1F1F1 url(../images/gradient_tile.png) repeat 0 -5px;"><a href="разгледай-болест-'.$resultLastCommentsBolesti[$i]['bolestID'].','.myTruncateToCyrilic($resultLastCommentsBolestiInfo[0]['title'],50,' ','').'.html" style="font-size:12px; font-weight:bold;" >Относно '.$resultLastCommentsBolestiInfo[0]['title'].'</a></h3>
			   	<a href="разгледай-болест-'.$resultLastCommentsBolesti[$i]['bolestID'].','.myTruncateToCyrilic($resultLastCommentsBolestiInfo[0]['title'],50,' ','').'.html" style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" >		    		
			    &rarr; '.myTruncate($resultLastCommentsBolesti[$i]['comment_body'], 150, " ") .' <br />
				</a>
		    	</div> 
		    	</div>	    	
		    	</td>
		 		</tr>';
	    	}
	    	$last_comments .= '</table>';
	  
    	}
    	
    	
    	
    	
    	
    	if ($numLastCommentsLekarstva > 0)
	    {	
	    	$last_comments .= '<table>';
	    	
	    	for ($i=0; $i<$numLastCommentsLekarstva; $i++)
	    	{
	    		$sql="SELECT lekarstvoID, title FROM lekarstva WHERE lekarstvoID = '".$resultLastCommentsLekarstva[$i]['lekarstvoID']."'";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultLastCommentsLekarstvaInfo 	= $conn->result;
				$numLastCommentsLekarstvaInfo 	= $conn->numberrows;
		
	    	$last_comments .= '<tr>
				<td>			
				<div class="postBig">
				<div class="detailsDiv" style="float:left;cursor:pointer; width:280px;margin-bottom:10px; border-top:3px solid #E4DFC8; padding:5px; background-color:#F1F1F1;">
				 <h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; background: #F1F1F1 url(../images/gradient_tile.png) repeat 0 -5px;"><a href="разгледай-лекарство-'.$resultLastCommentsLekarstva[$i]['lekarstvoID'].','.myTruncateToCyrilic($resultLastCommentsLekarstvaInfo[0]['title'],50,' ','').'.html" style="font-size:12px; font-weight:bold;" >Относно '.$resultLastCommentsLekarstvaInfo[0]['title'].'</a></h3>
			   	<a href="разгледай-лекарство-'.$resultLastCommentsLekarstva[$i]['lekarstvoID'].','.myTruncateToCyrilic($resultLastCommentsLekarstvaInfo[0]['title'],50,' ','').'.html" style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" >		    		
			    &rarr; '.myTruncate($resultLastCommentsLekarstva[$i]['comment_body'], 150, " ") .' <br />
				</a>
		    	</div> 
		    	</div>	    	
		    	</td>
		 		</tr>';	
			
	    	
	    	}
	    	$last_comments .= '</table>';
    	}
    	
    	
    	
    	
    	
		if ($numLastCommentsDoctors > 0)
	    {	
	    	$last_comments .= '<table>';
	    	
	    	
	    	for ($i=0; $i<$numLastCommentsDoctors; $i++)
	    	{
	    		$sql="SELECT id, CONCAT(first_name,' ',last_name) as 'name' FROM doctors WHERE id = '".$resultLastCommentsDoctors[$i]['doctorID']."'";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultLastCommentsDoctorsInfo 	= $conn->result;
				$numLastCommentsDoctorsInfo 	= $conn->numberrows;
		
	    	$last_comments .= '<tr>
				<td>			
				<div class="postBig">
				<div class="detailsDiv" style="float:left;cursor:pointer; width:280px;margin-bottom:10px; border-top:3px solid #E4DFC8; padding:5px; background-color:#F1F1F1;">
				 <h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; background: #F1F1F1 url(../images/gradient_tile.png) repeat 0 -5px;"><a href="разгледай-лекар-'.$resultLastCommentsDoctors[$i]['doctorID'].','.myTruncateToCyrilic($resultLastCommentsDoctorsInfo[0]['name'],50,' ','').'.html" style="font-size:12px; font-weight:bold;" >Относно '.$resultLastCommentsDoctorsInfo[0]['name'].'</a></h3>
			   	<a href="разгледай-лекар-'.$resultLastCommentsDoctors[$i]['doctorID'].','.myTruncateToCyrilic($resultLastCommentsDoctorsInfo[0]['name'],50,' ','').'.html" style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" >		    		
			    &rarr; '.myTruncate($resultLastCommentsDoctors[$i]['comment_body'], 150, " ") .' <br />
				</a>
		    	</div> 
		    	</div>	    	
		    	</td>
		 		</tr>';		
			
	    	 
	    	}
	    
	    	$last_comments .= '</table>';
	 
    	}
    	
    	
    	
    	if ($numLastCommentsHospitals > 0)
	    {	
	    	$last_comments .= '<table>';
	    	
	    	
	    	for ($i=0; $i<$numLastCommentsHospitals; $i++)
	    	{
	    		$sql="SELECT id, name FROM hospitals WHERE id = '".$resultLastCommentsHospitals[$i]['firmID']."'";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultLastCommentsHospitalsInfo 	= $conn->result;
				$numLastCommentsHospitalsInfo 	= $conn->numberrows;
		
	    	
	    		    	
		    	$last_comments .= '<tr>
				<td>			
				<div class="postBig">
				<div class="detailsDiv" style="float:left;cursor:pointer; width:280px;margin-bottom:10px; border-top:3px solid #E4DFC8; padding:5px; background-color:#F1F1F1;">
				 <h3 style="margin: 10px 0px 0px 0px; padding-left:5px; font-size:12px; color: #FF6600; background: #F1F1F1 url(../images/gradient_tile.png) repeat 0 -5px;"><a href="разгледай-здравно-заведение-'.$resultLastCommentsHospitals[$i]['firmID'].','.myTruncateToCyrilic($resultLastCommentsHospitalsInfo[0]['name'],50,' ','').'.html" style="font-size:12px; font-weight:bold;" >Относно '.$resultLastCommentsHospitalsInfo[0]['name'].'</a></h3>
			   	<a href="разгледай-здравно-заведение-'.$resultLastCommentsHospitals[$i]['firmID'].','.myTruncateToCyrilic($resultLastCommentsHospitalsInfo[0]['name'],50,' ','').'.html" style="font-size:12px; color:#000; font-weight:normal; text-decoration:none;" >		    		
			    &rarr; '.myTruncate($resultLastCommentsHospitals[$i]['comment_body'], 150, " ") .' <br />
				</a>
		    	</div> 
		    	</div>	    	
		    	</td>
		 		</tr>';		
			
	    	
	    	}
	    	
	    	$last_comments .= '</table>';
	    
    	}
    	
    	$last_comments .= '</div>
    	</div>';
   
   return $last_comments;
   ?>
   	