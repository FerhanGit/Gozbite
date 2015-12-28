<?php
     	ini_set('max_execution_time', '1750');
		include("inc/dblogin.inc.php");
		
	
	    
      
    
	
   /*== INSERT NEW COMPANY ==*/
   if(isset($add)) {
      $package_name                 = trim(htmlspecialchars($package_name));
      $offers_limit            		= trim(htmlspecialchars($offers_limit));
      $months            			= trim(htmlspecialchars($months));
      $total_price             		= trim(htmlspecialchars($total_price));
      $one_month_price            	= trim(htmlspecialchars($one_month_price));
      $price_for_one_offer          = trim(htmlspecialchars($price_for_one_offer));
      $concession        			= trim(htmlspecialchars($concession));
     

      
      if(!isset($Error)) {
         
      	$sql = "INSERT INTO msh_packages SET name='".$package_name."',
      											offers_limit = '".$offers_limit."',
      											months = '".$months."',
      											total_price = '".$total_price."',
      											one_month_price = '".$one_month_price."',
      											price_for_one_offer = '".$price_for_one_offer."',
      											concession = '".$concession."'
      											";
      	$conn->setsql($sql);
      	$lastID = $conn->insertDB();
      	
      	?>
      	 <script type = "text/javascript">
      	 document.location="edit_msh_packages.php?package_id=<?=$lastID?>";
      	 </script>
        <?php 
      }
   }

   /*== UPDATE COMPANY ==*/
   if (isset($save) && ($package_id > 0) ) {
      $package_name                 = trim(htmlspecialchars($package_name));
      $offers_limit            		= trim(htmlspecialchars($offers_limit));
      $months            			= trim(htmlspecialchars($months));
      $total_price             		= trim(htmlspecialchars($total_price));
      $one_month_price            	= trim(htmlspecialchars($one_month_price));
      $price_for_one_offer          = trim(htmlspecialchars($price_for_one_offer));
      $concession        			= trim(htmlspecialchars($concession));
     
      
       if(!isset($Error)) {
         
      	$sql = "UPDATE msh_packages SET name='".$package_name."',
      											offers_limit = '".$offers_limit."',
      											months = '".$months."',
      											total_price = '".$total_price."',
      											one_month_price = '".$one_month_price."',
      											price_for_one_offer = '".$price_for_one_offer."',
      											concession = '".$concession."'
      											WHERE id='".$package_id."'
      											";
         $conn->setsql($sql);
      	 $conn->updateDB();
      }
   }

   /*== END ACTIONS ==*/

   if (isset($package_id) && $package_id > 0) {
      $actionTitle = "Редактиране";
      		
      	 $sql = "SELECT * FROM msh_packages WHERE id='".$package_id."'	";
         $conn->setsql($sql);
      	 $conn->getTableRow();
      	 $resultPackage = $conn->result;
      	 
      	 
  } else {
      $actionTitle   = "Добавяне";
	  
	}
   
?>
<!doctype html public "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv = "Content-Type" content = "text/html; charset=utf-8" />
   <title>ЛАРГО.БГ - Административна част | Фирми</title>
   <link rel = "Stylesheet" type = "text/css" href = "css/admin_styles.css" media = "screen" />
   <script type = "text/javascript" src = "js/shared_functions.js"></script>
   <script type = "text/javascript">
      function checkForCorrectData() {
         theForm = document.itemform;
/*
         if(theForm.address.value.length == 0) {
            alert('Моля, въведете адреса на фирмата!');
            theForm.address.focus();
            return false;
         }

         if(theForm.manager.value.length == 0) {
            alert('Моля, въведете управител на фирмата!');
            theForm.manager.focus();
            return false;
         }

         if(theForm.contact.value.length == 0) {
            alert('Моля, въведете имената на лице за контакт!');
            theForm.contact.focus();
            return false;
         }

         if(theForm.phones.value.length == 0) {
            alert('Моля, въведете телефон(и)!');
            theForm.phones.focus();
            return false;
         }

         if((theForm.email.value.length == 0) || (theForm.email.value.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/)==-1)) {
            alert('Моля, въведете ВАЛИДЕН e-mail!');
            theForm.email.value = "";
            theForm.email.focus();
            return false;
         }
*/
         theForm.confirmOK.value = 1;
      }
   </script>
   <script type = "text/javascript" src = "http://dev.virtualearth.net/mapcontrol/v4/mapcontrol.js"></script>
</head>
<body onload = "startList(); ">
<form name = "itemform" method = "POST" >
<input type = "hidden" name = "GoOut" />
<input type = "hidden" name = "package_id" value = "<?php print $package_id; ?>" />

<div id = "header"><h1 style = "float: left;">ЛАРГО.БГ - Административна част | Пакети</h1>
</div>
<?php
   include_once("inc/menu.inc.php");
?>
<div id = "content" style = "width: 1020px;">
<?php
   if(isset($Error))
      printf("<div class = \"error\" style = \"padding: 3px 3px 3px 3px; width: 100%%; border: solid 1px #ca0000; background-color: #ffffff;\">%s</div>", $Error);
?>
   <fieldset style = "width: auto;">
   <?php
      print "<legend>&nbsp;Пакети | ".$actionTitle." на пакет&nbsp;</legend>\n";
   ?>
      <div style = "float: left; margin: 10px 10px 10px 5px; background-color: #efefef;">
         
         
         
         <div style = "margin: 10px 10px 10px 10px;">
            <label for = "package_name">Наименование на кирилица</label><br />
            <?php
               printf("<input type = \"text\" id = \"package_name\" name = \"package_name\" value = \"%s\" size = \"40\" />\n", $resultPackage['name']);
            ?>
         </div>
         
         
         <div style = "margin: 10px 10px 10px 10px;">
            <label for = "offers_limit">Максимален брой оферти</label><br />
            <?php
               printf("<input type = \"text\" id = \"offers_limit\" name = \"offers_limit\" value = \"%s\" size = \"40\" />\n", $resultPackage['offers_limit']);
            ?>
         </div>
         
         
          <div style = "margin: 10px 10px 10px 10px;">
            <label for = "months">За период от</label><br />
            <?php
               printf("<input type = \"text\" id = \"months\" name = \"months\" value = \"%s\" size = \"40\" />\n", $resultPackage['months']);
            ?>
         </div>
         
         <div style = "margin: 10px 10px 10px 10px;">
            <label for = "total_price">Общо цена</label><br />
            <?php
               printf("<input type = \"text\" id = \"total_price\" name = \"total_price\" value = \"%s\" size = \"40\" />\n", $resultPackage['total_price']);
            ?>
         </div>
         
         
         <div style = "margin: 10px 10px 10px 10px;">
            <label for = "one_month_price ">Цена за 1 месец</label><br />
            <?php
               printf("<input type = \"text\" id = \"one_month_price\" name = \"one_month_price\" value = \"%s\" size = \"40\" />\n", $resultPackage['one_month_price'] );
            ?>
         </div>
         
         
          <div style = "margin: 10px 10px 10px 10px;">
            <label for = "price_for_one_offer">Цена на 1 оферта за 1 месец</label><br />
            <?php
               printf("<input type = \"text\" id = \"price_for_one_offer\" name = \"price_for_one_offer\" value = \"%s\" size = \"40\" />\n", $resultPackage['price_for_one_offer'] );
            ?>
         </div>
         
          <div style = "margin: 10px 10px 10px 10px;">
            <label for = "concession">Отстъпка</label><br />
            <?php
               printf("<input type = \"text\" id = \"concession\" name = \"concession\" value = \"%s\" size = \"40\" />\n", $resultPackage['concession'] );
            ?>
         </div>
         
                 
       
         <div style = "margin: 10px 10px 10px 10px;">
         <?php
            if ($package_id > 0)
               print "<input type = \"submit\" name = \"save\" value = \"запиши\" class = \"buttonInv\" style = \"width: 265px; height: 30px; font-size: 14px;\">";
            else
               print "<input type = \"submit\" name = \"add\" value = \"запиши\" class = \"buttonInv\" style = \"width: 265px; height: 30px; font-size: 14px;\">";
         ?>
         </div>
      </div>

     
   </fieldset>
</div>
<input type = "hidden" name = "confirmOK">
</form>
</body>
</html>
<?php
   $conn->closedbconnection();
?>