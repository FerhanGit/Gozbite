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
    
   
   
   
    <!-- ============== EXTRA RESULT INCLUDE ================= -->
    <?php
    
    if (($_POST['marka']!="") or ($_REQUEST['carID']!="")) 
	{
	?>
	
    
      
    <div id="SCROLL_NEWS_CONTAINER" style="float:left; width:160px; margin:0px 0px 0px 5px; overflow:hidden;">      
      <table width="160" border="0">
          <tr>
            <td rowspan="4" width="3" bgcolor="#0D959F"></td>
            <td colspan="2"><img src="images/up.jpg"></td>
            </tr>
          <tr>
            <td><div  style="width:135px;" align="left" class="news_scroll">
            
            <marquee direction="up" onMouseOver="this.stop();" onMouseOut="this.start();" SCROLLDELAY=100 SCROLLAMOUNT=2>   
        
            <?php
            
            if (($_POST['marka']!="") && ($_POST['marka']!="-1")) 
            {
                    
             //------------------------- EXTRA RESULTS -------------------------------
                            
                $sql="SELECT DISTINCT(c.id) as 'id', mk.name as 'marka', md.name as 'model', c.price as 'price', l.name as 'location', cr.name as 'currency', at.name as 'avto_type' , cl.name as 'color', f.name as 'fuel', c.updated_on as 'updated_on', c.year_made as 'year_made', c.description as 'description', c.probeg as 'probeg', c.has_pic as 'has_pic'  FROM cars c,marka mk, model md, currency cr, avto_type at, color cl, fuel f, locations l, cars_details cd  WHERE c.marka=mk.id AND c.model=md.id AND c.avto_type=at.id AND c.color=cl.id AND c.fuel = f.id AND c.currency = cr.id AND c.location_id = l.id AND c.marka='".$_POST['marka']."' ORDER BY marka";
                $conn->setsql($sql);
                $conn->getTableRows();
                $resultExtra=$conn->result;
                $numExtra=$conn->numberrows;
                
                for ($i=0;$i<$numExtra;$i++)
                {
                ?>
                <div style="border:double; border-color:#666666;height:60px; width:60px;" ><a href="search.php?carID=<?=$resultExtra[$i]['id']?>"><img width="60" height="60" src="pics/cars/<?php if($resultExtra[$i]['has_pic']=='1') print $resultExtra[$i]['id']."_0_thumb.jpg"; else print "no_photo_thumb.png";?>" /></a></div>		
                <div style="margin-top:0px;margin-bottom:20px;"><a href="search.php?carID=<?=$resultExtra[$i]['id']?>"><?php print $resultExtra[$i]['marka']."|".$resultExtra[$i]['model']."<br /> Цена:".$resultExtra[$i]['price']." ".$resultExtra[$i]['currency'];?></a></div>
                    
                <?php 
                } 
             
            //------------------------- END EXTRA RESULTS ---------------------------	
                        
                        
            }
            else 
            {
                    
             //------------------------- ELSE EXTRA RESULTS -------------------------------
                            
                $sql="SELECT DISTINCT(c.id) as 'id', mk.name as 'marka', md.name as 'model', c.price as 'price', l.name as 'location', cr.name as 'currency', at.name as 'avto_type' , cl.name as 'color', f.name as 'fuel', c.updated_on as 'updated_on', c.year_made as 'year_made', c.description as 'description', c.probeg as 'probeg', c.has_pic as 'has_pic'  FROM cars c,marka mk, model md, currency cr, avto_type at, color cl, fuel f, locations l, cars_details cd  WHERE c.marka=mk.id AND c.model=md.id AND c.avto_type=at.id AND c.color=cl.id AND c.fuel = f.id AND c.currency = cr.id AND c.location_id = l.id AND c.marka=(SELECT marka FROM cars WHERE id ='".$_GET['carID']."') ORDER BY marka";
                $conn->setsql($sql);
                $conn->getTableRows();
                $resultExtra=$conn->result;
                $numExtra=$conn->numberrows;
                
                for ($i=0;$i<$numExtra;$i++)
                {
                ?>
                <div style="border:double; border-color:#666666;height:60px; width:60px;" ><a href="search.php?carID=<?=$resultExtra[$i]['id']?>"><img width="60" height="60" src="pics/cars/<?php if($resultExtra[$i]['has_pic']=='1') print $resultExtra[$i]['id']."_0_thumb.jpg"; else print "no_photo_thumb.png";?>" /></a></div>		
                <div style="margin-top:0px;margin-bottom:20px;"><a href="search.php?carID=<?=$resultExtra[$i]['id']?>"><?php print $resultExtra[$i]['marka']."|".$resultExtra[$i]['model']."<br /> Цена:".$resultExtra[$i]['price']." ".$resultExtra[$i]['currency'];?></a></div>
                    
                <?php 
                } 
             
            //------------------------- END ELSE EXTRA RESULTS ---------------------------	
                        
                        
            }
              
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

<?php } ?>
    <!-- ============== END EXTRA RESULT INCLUDE ================= -->
        
    
 	<div style="float:left;width:150px; margin-top:0px;"><img src="images/but1.gif" width="150" height="42"></div>
