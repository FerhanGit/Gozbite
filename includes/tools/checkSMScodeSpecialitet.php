<?php
  
   require_once '../header.inc.php';
	


   $Period = '7';
   
   if(isset($_REQUEST['sendCode'])) {
      $izbran = trim(htmlspecialchars($_REQUEST['izbran']));
      $servID = 6044;
      
      $errors = "";
      $message = "";

      if(!isset($izbran) || (strlen($izbran) <= 0))
         $errors = "<br /><span class = \"txt10 orange\">Моля, въведете получения код в полето! </span>";

      if(strlen($errors) <= 0) 
      {
						
			function mobio_checkcode($servID, $code, $debug=0) 
			{

				$res_lines = file("http://www.mobio.bg/code/checkcode.php?servID=$servID&code=$code");
			
				$ret = 0;
				if($res_lines) {
			
					if(strstr("PAYBG=OK", $res_lines[0])) {
						$ret = 1;
					}else{
						if($debug)
							echo $line."\n";
					}
				}else{
					if($debug)
						echo "Unable to connect to mobio.bg server.\n";
					$ret = 0;
				}
			
				return $ret;
			}
			
			
			
			
			if(mobio_checkcode($servID, $izbran, 0) === 1) 
			{
				
				if($_REQUEST['content'] == 'recipe')
				{	     	   	

					$sql = "SELECT id FROM recipes WHERE is_Featured = '1' AND is_Featured_from > (NOW() - INTERVAL $Period DAY)";
					$conn->setsql($sql);
					$conn->getTableRows();
					$resultSpecials = $conn->result;
					$numSpecials 	= $conn->numberrows;
		
					if($numSpecials < 1)
					{
						$sql = "UPDATE recipes SET  is_Featured = '1', is_Featured_code = '".$izbran."', is_Featured_from = NOW(), is_Featured_end = (NOW() + INTERVAL $Period DAY) WHERE id='".$_REQUEST['content_id']."'";
						$conn->setsql($sql);
						$conn->updateDB();
						echo "<font color='red'><b>Валиден КОД! Вашата рецепта е добавена в секция Специалитет за срок от $Period дни!</b></font>";
				
					}
					else echo "<font color='red'><b>Вашата рецепта вече се намира в секция Специалитет за период от $Period дни! Моля въведете новия код след като изтече този период!</b></font>";
				
				}
				
				
				if($_REQUEST['content'] == 'drink')
				{	     	   	

					$sql = "SELECT id FROM drinks WHERE is_Featured = '1' AND is_Featured_from > (NOW() - INTERVAL $Period DAY)";
					$conn->setsql($sql);
					$conn->getTableRows();
					$resultSpecials = $conn->result;
					$numSpecials 	= $conn->numberrows;
		
					if($numSpecials < 1)
					{
						$sql = "UPDATE drinks SET  is_Featured = '1', is_Featured_code = '".$izbran."', is_Featured_from = NOW(), is_Featured_end = (NOW() + INTERVAL $Period DAY) WHERE id='".$_REQUEST['content_id']."'";
						$conn->setsql($sql);
						$conn->updateDB();
						echo "<font color='red'><b>Валиден КОД! Вашата напитка е добавена в секция Специалитет за срок от $Period дни!</b></font>";
				
					}
					else echo "<font color='red'><b>Вашата напитка вече се намира в секция Специалитет за период от $Period дни! Моля въведете новия код след като изтече този период!</b></font>";
				
				}
	
	
			}
			else
			{
				echo "<font color='red'><b>Невалиден КОД!</b></font>";
			}



  
      }
   }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <title>GoZbiTe.Com | Изпрати SMS и направи <?=($_REQUEST['content'] == 'recipe')?'рецептата':'напитката'?> си Специалитет</title>
   <link rel = "stylesheet" href="../css/c.css" />
   <style>
      body {
            margin: 0 auto;
            padding: 0;
            text-align: center;
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 11px;
            background: url(none);
            background-color: #898989;
      }
   </style>
<script language = "JavaScript">

   function checkForCorrectCode() {
         theForm = document.itemform;
         
     	  if(theForm.izbran.value.length == 0) {
             alert('Моля, въведете коректен код!');
             theForm.izbran.value = "";
             theForm.izbran.focus();
             return false;
          }
   }
</script>
</head>
<body>
<form method = "post" name = "itemform" action = "checkSMScodeSpecialitet.php" >

<input type = "hidden" id = "content" name = "content" value = "<?=$_REQUEST['content']?>" />
<input type = "hidden" id = "content_id" name = "content_id" value = "<?=$_REQUEST['content_id']?>" />

<table cellspacing = "0" cellpadding = "0" border = "0" style = "background-color: #F7F7F7; margin: 15px 10px 3px 10px; padding: 0;" width = "382">
   <tr>
      <td style = "width: 6px; height: 6px; background: url(../img/fr_or_top_l_bw.gif); background-position: bottom left; background-repeat: no-repeat;"></td>
      <td style = "width: 370px; height: 6px; background: url(../img/fr_or_top_bw.gif); background-position: bottom; background-repeat: repeat-x;"></td>
      <td style = "width: 6px; height: 6px; background: url(../img/fr_or_top_r_bw.gif); background-position: bottom right; background-repeat: no-repeat;"></td>
   </tr>
   <tr>
      <td style = "background: url(../img/fr_or_l_bw.gif); width: 6px; height: 100%; background-position: bottom; background-repeat: repeat-y;"></td>
      <td valign = "top" bgcolor = "#F7F7F7" align = "center">
         <table border = "0" cellspacing = "0" cellpadding = "3">
            <caption><strong>Въведи получения код и направи <?=($_REQUEST['content'] == 'recipe')?'рецептата':'напитката'?> си Специалитет</strong></caption>
            <tr><td colspan = "2">&nbsp;</td></tr>
            <tr><td colspan = "2" style = "height: 10px;"></td></tr>
            <tr>
               <td align = "right"><label for = "izbran">Въведете получения код:</label></td>
               <td><input type = "text" id = "izbran" name = "izbran" value = "" /></td>
            </tr>           
            <tr><td colspan = "2">&nbsp;</td></tr>
            <tr>
               <td align = "right" colspan = "2" style = "padding-right: 67px; padding-bottom: 20px;"><input type="submit" name = "sendCode" value = "Направи Специалитет" onclick = "return checkForCorrectCode();"  />&nbsp;<input type = "button" value = "затвори" onclick = "window.self.close()" /></td>
            </tr>
         </table>
      </td>
      <td valign = "top" style = "background: url(../img/fr_or_r_bw.gif); width: 6px; height: 100%; background-repeat: repeat-y;">&nbsp;</td>
   </tr>
   <tr>
      <td style = "width: 6px; height: 6px; background: url(../img/fr_or_bot_l_bw.gif); background-repeat: no-repeat;"></td>
      <td style = "width: 370px; height: 6px; background: url(../img/fr_or_bot_bw.gif); background-repeat: repeat-x;"></td>
      <td style = "width: 6px; height: 6px; background: url(../img/fr_or_bot_r_bw.gif); background-repeat: no-repeat;"></td>
   </tr>
</table>

</form>
</body>
</html>