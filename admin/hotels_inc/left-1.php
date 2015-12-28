<div style="float:left;  background-color:#F5F5F5; "><img style="margin:20px 10px 20px 10px;" src="images/logce.png"><img src="images/logo.png" width="159" height="83"></div>
	
<table style="float:left" width="160"  border="0" cellspacing="0" cellpadding="0"> 
              <tr> 
                <td rowspan="2" valign="top"><img src="images/floorer_08.gif" width="49" height="113" alt="" /></td> 
                <td valign="top"><a href="index.php"><img src="images/r2.gif" width="31" height="20" border="0" alt="" /></a></td> 
             	<td><img src="images/floorer_10.gif" width="80" height="20" alt="" /></td> 
  </tr> 
              <tr> 
                <td><img src="images/floorer_11.gif" width="31" height="93" alt="" /></td> 
               <td><img src="images/floorer_12.jpg" width="80" height="93" alt="" /></td> 
  </tr> 
    </table>


    
    
    <!-- ============== RSS INCLUDE ================= -->
        
     <div id="SCROLL_NEWS_CONTAINER" style="float:left; width:160px;margin:0px 0px 0px 0px; overflow:inherit;">    
       <table width="160" border="0">
            <tr>
            <td rowspan="4" width="3" bgcolor="#0D959F"></td>
            <td colspan="2"><img src="images/up.jpg"></td>
            </tr>
          <tr>
            <td>
            <div  style="width:135px;" align="left" class="news_scroll">            
           		<?php include("inc/rss_include.php")?>            
            </div>
            </td>    
          </tr>
          <tr>
            <td colspan="2"><img src="images/down.gif"></td>
            </tr>						
		</table>    
    </div>
    
   <!-- ============== END RSS INCLUDE ================= -->
    
   
 	<div style="float:left;width:150px; margin-top:0px;"><img src="images/but1.gif" width="150" height="42"></div>
   
   
    <!-- ============== EXTRA RESULT INCLUDE ================= -->
    <?php
    
    if (($_REQUEST['hospital_category']!="") or ($_REQUEST['category']!="")) 
	{
		$sql="SELECT name FROM hospital_category WHERE id='".($_REQUEST['category']?$_REQUEST['category']:$_REQUEST['hospital_category'])."'";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultCatName=$conn->result['name'];
	?>
	
    
      
    <div id="SCROLL_NEWS_CONTAINER" style="float:left; width:160px; margin:0px 0px 0px px; overflow:hidden;">  
    <div style="color:#FF6600; font-weight:bold;" align="center">Още <?=$resultCatName?>   </div> 
      <table width="160" border="0">
          <tr>
            <td rowspan="4" width="3" bgcolor="#0D959F"></td>
            <td colspan="2"><img src="images/up.jpg"></td>
            </tr>
          <tr>
            <td><div  style="width:135px;" align="left" class="news_scroll">
            
            <marquee direction="up" onMouseOver="this.stop();" onMouseOut="this.start();" SCROLLDELAY=100 SCROLLAMOUNT=2>   
        
            <?php
            
            include("more.inc.php");
              
           ?>
           
            </marquee>
            
            </div>
            </td>    
          </tr>
          <tr>
            <td colspan="2"><img src="images/down.gif"></td>
            </tr>
		</table>     
    </div>
    
	<div style="float:left;width:150px; margin-top:0px;"><img src="images/but1.gif" width="150" height="42"></div>

<?php } ?>
    <!-- ============== END EXTRA RESULT INCLUDE ================= -->
        
    
 	