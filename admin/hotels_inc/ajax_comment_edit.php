<?php
   include_once("../inc/dblogin.inc.php");
   
  


   $response = "";
   
	          
        $sql="SELECT * FROM doctor_comment WHERE doctorID='".$_REQUEST['all_doctorID']."' ORDER BY created_on DESC";
		$conn->setsql($sql);
		$conn->getTableRows();
		$resultComment=$conn->result;
		$numComment=$conn->numberrows;
			

      if($numComment > 0) {
          for($k=0;$k<$numComment;$k++)
          {
          
                    $response .= "  <input type='hidden' name='doctorID[]' value=".$resultComment[$k]['doctorID'].">";
                    $response .= "  <input type='hidden' name='commentID[]' value=".$resultComment[$k]['commentID'].">";
    				$response .= "Името Ви:<br /> <input type='text' name='sender_name[]' id='sender_name'".$k." maxlength='30' value=".$resultComment[$k]['sender_name'].">";
    				$response .= " <br />"; 
    				$response .= "<br />"; 
    				$response .= "Е-мейлът Ви:<br /> <input type='text' name='sender_email[]' id='sender_email'".$k." maxlength='30' value=".$resultComment[$k]['sender_email'].">";
                    $response .= " <br />"; 
    				$response .= "<br />"; 
    				$response .= "<br />"; 
    				  				
    				$response .= "<a onclick=\"if(!confirm('Сигурни ли сте?')){return false;}\" href='?deleteComment=".$resultComment[$k]['commentID']."'><img style='margin-left:5px;' src='images/page_white_delete.png' width='14' height='14'></a>";
					
    				$response .= " Текст на Коментар Номер ".$k.":<br />"; 
    			
        		/*	 include_once("FCKeditor/fckeditor.php");
        		         $oFCKeditor = new FCKeditor('comment_body') ;
        		         $oFCKeditor->BasePath   = "FCKeditor/";
        		         $oFCKeditor->Width      = '500';
        		         $oFCKeditor->Height     = '300' ;
        		         $oFCKeditor->Value      = $resultComment[$k]['comment_body'];
        		    
        		    $response .=   $oFCKeditor->Create();

				*/   

    				$response .= "<textarea name='comment_body[]' id='comment_body'".$k.">".$resultComment[$k]['comment_body']."</textarea>";
    				
    				
    				$response .= "  <br />"; 
          }		  
      	
     }
     
   

   print $response;
?>