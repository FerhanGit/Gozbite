 <?php 
		  	  if (isset($_SESSION['valid_user']))
		  	  {
		  	  	print "<font color='#467B99'>".$_SESSION['valid_user']."</font> Вие сте в системата!<hr>";		  	  
		  	  	print "Вашият принос:<br /> <font color='#467B99'>".($_SESSION['cnt_bolest']>0?$_SESSION['cnt_bolest']:0)."</font> болести<br />";
		  	   	print "<font color='#467B99'>".($_SESSION['cnt_post']>0?$_SESSION['cnt_post']:0)."</font> статии<br />";
		  	   	print "<font color='#467B99'>".($_SESSION['cnt_news']>0?$_SESSION['cnt_news']:0)."</font> новини<hr> ";
		  	   	print "Последно сте били с нас на <font color='#467B99'>".$_SESSION['last_login']."</font> ч.";
		  	  			  	  
		  	  }
		      else 
		  	     print "Вие излязохте успешно!";
?>