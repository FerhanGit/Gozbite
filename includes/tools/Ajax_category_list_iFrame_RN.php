<?php
   include_once("../includes/header.inc.php");
   

   $response = "";
    
   $target  = $_GET["target"];
   $width 	= $_GET['width'];    
  ?>
 
     		<select style="width:<?=($width-10)?>px;" name="category" id="category" ">
			<option value ="">категория...</option>
           <?php
             		$sql="SELECT * FROM ".$target."_category WHERE parentID = 0 ORDER BY name";
					$conn->setsql($sql);
					$conn->getTableRows();
					$resultCat=$conn->result;
					$numCat=$conn->numberrows;
			
					for ($i=0;$i<$numCat;$i++)
	               {?>      
				 	  <option value = "<?=$resultCat[$i]['id']?>"   <?=$_REQUEST['doctor_category']==$resultCat[$i]['id']?'selected':''?>  ><?=$resultCat[$i]['name']?></option> 
	                             
	               <?php } ?>
			  </select>
	<?php  
      
     
     
?>