<rss version="2.0">
	<channel>
		<title>GoZbiTe.Com - насладата от живота!</title>
		<link>http://GoZbiTe.Com/</link>
		<description>GoZbiTe.Com - насладата от живота!</description>
		<image>
                <title>GoZbiTe.Com - насладата от живота!</title>
                <url>http://GoZbiTe.Com/images/logce.png</url>
                <link>http://www.GoZbiTe.Com/</link>
                <width>144</width>
                <height>45</height>
         </image>
		
		<language>bg</language>
		<copyright>2009-2011 GoZbiTe.Com</copyright>

		


<?php

	//Adding a feed. Genarally this protion will be in a loop and add all feeds.

	  include_once("../includes/header.inc.php");
   
   
     
	$conn =  new mysqldb();							    
	
// -------------------------------- SELECT na vsi4ki СТАТИИ ---------------------------------------	
	$sql = sprintf("SELECT * FROM posts WHERE picURL <> '' AND active = '1' ORDER BY date DESC LIMIT 5");
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	
	
// ------------------------------------------------------------------------------------------------		

	for ($i=0;$i<$nums;$i++)
	{		
		$sql = sprintf("SELECT name FROM post_category WHERE id = '".$result[$i]['post_category']."'");
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultCat   = $conn->result['name'];
		
	
			?>
					
			<item>
			<title><![CDATA[<?=$result[$i]['title']?>]]></title>			
			<link><![CDATA[http://GoZbiTe.Com/прочети-статия-<?=$result[$i]['postID']?>,<?=myTruncateToCyrilic($result[$i]['title'],200,'_','') ?>.html]]></link>
			<guid isPermaLink="true"><![CDATA[http://GoZbiTe.Com/прочети-статия-<?=$result[$i]['postID']?>,<?=myTruncateToCyrilic($result[$i]['title'],200,'_','') ?>.html]]></guid>
			<category><?=$resultCat?></category>
			<pubDate><?=date("r",strtotime($result[$i]['date']))?></pubDate>
			<description><![CDATA[ <?=$result[$i]['body']?>]]></description>
			<enclosure url="http://www.GoZbiTe.Com/pics/posts/<?=$result[$i]['picURL']?>" length="90000" type="image/jpeg"/>
			
			
			</item>

			<?php
		
	
	}
	
	
	
// -------------------------------- SELECT na vsi4ki РЕЦЕПТИ ---------------------------------------	
	$sql="SELECT r.id as 'id', r.title as 'title', r.info as 'info', r.has_pic as 'has_pic', r.registered_on as 'registered_on' FROM recipes r WHERE r.active = '1'  ORDER BY r.registered_on DESC LIMIT 10 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultRecipes   = $conn->result;
	$numsRecipes 	  = $conn->numberrows;	
	
// ------------------------------------------------------------------------------------------------		

	for ($i=0;$i<$numsRecipes;$i++)
	{		
		$sql="SELECT rc.id as 'id', rc.name as 'name' FROM recipes r, recipe_category rc, recipes_category_list rcl WHERE rcl.recipe_id = r.id AND rcl.category_id = rc.id AND r.active = '1' AND r.id = '".$resultRecipes[$i]['id']."' ";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultCatRecipe   = $conn->result['name'];
		
	
		if ($resultRecipes[$i]['has_pic']=='1')
		{
			$sql="SELECT * FROM recipe_pics WHERE recipeID='".$resultRecipes[$i]['id']."'";
			$conn->setsql($sql);
			$conn->getTableRows();
			$resultPics[$i]=$conn->result;
			$numPics[$i]=$conn->numberrows;
		}
		
	   if(is_file('../pics/recipes/'.$resultPics[$i][0]['url_big'])) $picFile= 'pics/recipes/'.$resultPics[$i][0]['url_big'];
	   else $picFile = 'pics/recipes/no_photo_big.jpg';
	   	

	  	$sql="SELECT r.id as 'id', pr.id as 'product_id', pr.product as 'product' FROM recipes r, recipes_products pr WHERE pr.recipe_id = r.id AND r.id = '".$resultRecipes[$i]['id']."' ORDER BY pr.product ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numRecipeProducts   	  = $conn->numberrows;
		$resultRecipeProducts  	  = $conn->result;
	
	
		$products = "";
		if($numRecipeProducts > 0)
		{
			$products .= '<h4>Продукти</h4>';
			$products .= '<table>';
			for ($d=0; $d<count($resultRecipeProducts); $d++)
			{
				$products .= "<tr><td style='color:#666666; font-weight:bold;'> &rarr;</td> <td>  <font style='color:#FF6600;'>".$resultRecipeProducts[$d]['product']."</font> </td></tr>"; 
			
			}
			
			$products .= '</table>';
		}
		

		
		?>
			
		
							
			<item>
			<title><![CDATA[<?=$resultRecipes[$i]['title']?>]]></title>			
			<link><![CDATA[http://GoZbiTe.Com/разгледай-рецепта-<?=$resultRecipes[$i]['id']?>,<?=myTruncateToCyrilic($resultRecipes[$i]['title'],200,'_','') ?>.html]]></link>
			<guid isPermaLink="true"><![CDATA[http://GoZbiTe.Com/разгледай-рецепта-<?=$resultRecipes[$i]['id']?>,<?=myTruncateToCyrilic($resultRecipes[$i]['title'],200,'_','') ?>.html]]></guid>
			<category><?=$resultCatRecipe?></category>
			<pubDate><?=date("r",strtotime($resultRecipes[$i]['registered_on']))?></pubDate>
			<description><![CDATA[ <?=$products.'<br /><br /> | <h4>Начин на приготвяне &rarr; </h4>'.$resultRecipes[$i]['info']?>]]></description>
			<enclosure url="http://www.GoZbiTe.Com/<?=$picFile?>" length="90000" type="image/jpeg"/>
			
			
			</item>

			<?php
		
	
	}
  
	
	
	
	
	
	
// -------------------------------- SELECT na vsi4ki НАпитки ---------------------------------------	
	$sql="SELECT d.id as 'id', d.title as 'title', d.info as 'info', d.has_pic as 'has_pic', d.registered_on as 'registered_on' FROM drinks d WHERE d.active = '1' ORDER BY d.registered_on DESC LIMIT 10 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultDrinks   = $conn->result;
	$numsDrinks 	= $conn->numberrows;	
	
// ------------------------------------------------------------------------------------------------		

	for ($i=0;$i<$numsDrinks;$i++)
	{		
		$sql="SELECT dc.id as 'id', dc.name as 'name' FROM drinks d, drink_category dc, drinks_category_list dcl WHERE dcl.drink_id = r.id AND dcl.category_id = dc.id AND d.active = '1' AND d.id = '".$resultDrinks[$i]['id']."' ";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultCatDrink   = $conn->result['name'];
		
	
		if ($resultDrinks[$i]['has_pic']=='1')
		{
			$sql="SELECT * FROM drink_pics WHERE drinkID='".$resultDrinks[$i]['id']."'";
			$conn->setsql($sql);
			$conn->getTableRows();
			$resultPics[$i]=$conn->result;
			$numPics[$i]=$conn->numberrows;
		}
		
	   if(is_file('../pics/drinks/'.$resultPics[$i][0]['url_big'])) $picFile= 'pics/drinks/'.$resultPics[$i][0]['url_big'];
	   else $picFile = 'pics/drinks/no_photo_big.jpg';
	   	

	    $sql="SELECT d.id as 'id', pr.id as 'product_id', pr.product as 'product' FROM drinks d, drinks_products pr WHERE pr.drink_id = d.id AND d.id = '".$resultDrinks[$i]['id']."' ORDER BY pr.product ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$numDrinkProducts   	  = $conn->numberrows;
		$resultDrinkProducts  	  = $conn->result;
	
	
		$products = "";
		if($numRecipeProducts > 0)
		{
			$products .= '<h4>Продукти</h4>';
			$products .= '<table>';
			for ($d=0; $d<count($resultDrinkProducts); $d++)
			{
				$products .= "<tr><td style='color:#666666; font-weight:bold;'> &rarr;</td> <td>  <font style='color:#FF6600;'>".$resultDrinkProducts[$d]['product']."</font> </td></tr>"; 
			
			}
			
			$products .= '</table>';
		}
		

		
			?>
					
			<item>
			<title><![CDATA[<?=$resultDrinks[$i]['title']?>]]></title>			
			<link><![CDATA[http://GoZbiTe.Com/разгледай-напитка-<?=$resultDrinks[$i]['id']?>,<?=myTruncateToCyrilic($resultDrinks[$i]['title'],200,'_','') ?>.html]]></link>
			<guid isPermaLink="true"><![CDATA[http://GoZbiTe.Com/разгледай-напитка-<?=$resultDrinks[$i]['id']?>,<?=myTruncateToCyrilic($resultDrinks[$i]['title'],200,'_','') ?>.html]]></guid>
			<category><?=$resultCatDrink?></category>
			<pubDate><?=date("r",strtotime($resultDrinks[$i]['registered_on']))?></pubDate>
			<description><![CDATA[ <?=$products.'<br /><br /> | <h4>Начин на приготвяне &rarr; </h4>'.$resultDrinks[$i]['info']?>]]></description>
			<enclosure url="http://www.GoZbiTe.Com/<?=$picFile?>" length="90000" type="image/jpeg"/>
			
			
			</item>

			<?php
		
	
	}
  
	
	
	
		
	
// -------------------------------- SELECT na vsi4ki Opisaniq ---------------------------------------		
	$sql="SELECT g.id as 'id', g.title as 'title', g.registered_on as 'registered_on', g.info as 'info', g.has_pic as 'has_pic', g.active as 'active' FROM guides g WHERE g.active = '1' ORDER BY g.registered_on DESC LIMIT 5 ";
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultGuides=$conn->result;
	$numGuides=$conn->numberrows;
	
// ------------------------------------------------------------------------------------------------		

	for ($g=0;$g<$numGuides;$g++)
	{		
			
		if ($resultGuides[$g]['has_pic']=='1')
		{
			$sql="SELECT * FROM guide_pics WHERE guideID='".$resultGuides[$g]['id']."'";
			$conn->setsql($sql);
			$conn->getTableRows();
			$resultPics[$g]=$conn->result;
			$numPics[$g]=$conn->numberrows;
		}
		
		   if(is_file('../pics/guides/'.$resultPics[$g][0]['url_big'])) $picFile= 'pics/guides/'.$resultPics[$g][0]['url_big'];
		   else $picFile = 'pics/guides/no_photo_big.jpg';
	   	
			?>
					
			<item>
			<title><![CDATA[ <?=$resultGuides[$g]['title']?>]]></title>			
			<link><![CDATA[ http://GoZbiTe.Com/разгледай-справочник-<?=$resultGuides[$g]['id']?>,<?=myTruncateToCyrilic($resultGuides[$g]['title'],200,'_','') ?>.html]]></link>
			<guid isPermaLink="true"><![CDATA[ http://GoZbiTe.Com/разгледай-справочник-<?=$resultGuides[$g]['id']?>,<?=myTruncateToCyrilic($resultGuides[$g]['title'],200,'_','') ?>.html]]></guid>
			<category>GoZbiTe.Com</category>
			<pubDate><?=date("r",strtotime($resultGuides[$g]['registered_on']))?></pubDate>
			<description><![CDATA[ <?='<h4>Описание &rarr; </h4>'.$resultGuides[$g]['info']?>]]></description>
			<enclosure url="http://www.GoZbiTe.Com/<?=$picFile?>" length="90000" type="image/jpeg"/>
			
			
			</item>

			<?php
		
	
	}
  
	
	
	
	
		
// -------------------------------- SELECT na vsi4ki Aphorismi ---------------------------------------		
	$sql="SELECT a.aphorismID as 'aphorismID',
	              a.title as 'title',								             
	               a.body as 'body',
		            a.picURL as 'picURL',
		             a.date as 'date',
			          a.active as 'active'
			           FROM aphorisms a
				        WHERE '1' = '1' 
				         ORDER BY a.date DESC 
				          LIMIT 5 ";
	
	$conn->setsql($sql);
	$conn->getTableRows();
	$resultAphorisms=$conn->result;
	$numAphorisms=$conn->numberrows;
	
// ------------------------------------------------------------------------------------------------		

	for ($g=0;$g<$numAphorisms;$g++)
	{		
			
		   if(is_file('../pics/aphorisms/'.$resultAphorisms[$g]['picURL'])) $picFile= 'pics/aphorisms/'.$resultAphorisms[$g]['picURL'];
		   else $picFile = 'pics/aphorisms/no_photo_big.jpg';
	   	
			?>
					
			<item>
			<title><![CDATA[ <?=$resultAphorisms[$g]['body']?>]]></title>			
			<link><![CDATA[ http://GoZbiTe.Com/прочети-афоризъм-<?=$resultAphorisms[$g]['aphorismID']?>,<?=myTruncateToCyrilic($resultAphorisms[$g]['body'],200,'_','') ?>.html]]></link>
			<guid isPermaLink="true"><![CDATA[ http://GoZbiTe.Com/прочети-афоризъм-<?=$resultAphorisms[$g]['aphorismID']?>,<?=myTruncateToCyrilic($resultAphorisms[$g]['body'],200,'_','') ?>.html]]></guid>
			<category>GoZbiTe.Com</category>
			<pubDate><?=date("r",strtotime($resultAphorisms[$g]['date']))?></pubDate>
			<description><![CDATA[ <?=$resultAphorisms[$g]['body']?>]]></description>
			<enclosure url="http://www.GoZbiTe.Com/<?=$picFile?>" length="90000" type="image/jpeg"/>
			
			
			</item>

			<?php
		
	
	}
  
	
	
?>
</channel>
</rss>
<?php //header('Content-Type: application/xml'); ?>