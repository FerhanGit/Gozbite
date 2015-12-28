<?php
	ini_set('max_execution_time', '1750');
	
	include("includes/header.inc.php");
   
   
   
  	$xml = "";
   
  	$xml .= '<?xml version=\'1.0\' encoding=\'UTF-8\'?>';
	$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
			    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

	
	$conn =  new mysqldb();							    
	
// ----------------------------------------- СТАТИИ -----------------------------------------------
	$sql = sprintf("SELECT * FROM posts ORDER BY date DESC LIMIT 10000");
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://GoZbiTe.Com/прочети-статия-'.$result[$i]["postID"].','.myTruncateToCyrilic($result[$i]['title'],200,"_","").'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d",strtotime($result[$i]['date'])).'</lastmod>';
		$xml .= '<changefreq>hourly</changefreq>';
		$xml .= '<priority>1.0</priority>';		
		$xml .= '</url>';
		
	}	
	
	
	$sql = sprintf("SELECT * FROM post_category ORDER BY name DESC LIMIT 1000");
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://GoZbiTe.Com/статии-категория-'.$result[$i]["id"].','.myTruncateToCyrilic($result[$i]['name'],200,"_","").'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d").'</lastmod>';
		$xml .= '<changefreq>weekly</changefreq>';
		$xml .= '<priority>1.0</priority>';		
		$xml .= '</url>';
		
	}	
// ------------------------------------------------------------------------------------------------		



// ----------------------------------------- ФИРМИ -----------------------------------------------
	$sql="SELECT id, name,registered_on FROM firms ORDER BY registered_on DESC  LIMIT 10000";
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://GoZbiTe.Com/разгледай-фирма-'.$result[$i]["id"].','.myTruncateToCyrilic($result[$i]['name'],200,"_","").'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d",strtotime($result[$i]['registered_on'])).'</lastmod>';
		$xml .= '<changefreq>daily</changefreq>';
		$xml .= '<priority>0.9</priority>';		
		$xml .= '</url>';
		
	}	
	
	
	
	$sql = sprintf("SELECT * FROM firm_category ORDER BY name DESC LIMIT 1000");
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://GoZbiTe.Com/фирми-категория-'.$result[$i]["id"].','.myTruncateToCyrilic($result[$i]['name'],200,"_","").'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d").'</lastmod>';
		$xml .= '<changefreq>weekly</changefreq>';
		$xml .= '<priority>0.9</priority>';		
		$xml .= '</url>';
		
	}	
// ------------------------------------------------------------------------------------------------		





// ----------------------------------------- РЕЦЕПТИ -----------------------------------------------
	$sql="SELECT id, title, registered_on FROM recipes ORDER BY registered_on DESC LIMIT 10000";
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://GoZbiTe.Com/разгледай-рецепта-'.$result[$i]["id"].','.myTruncateToCyrilic($result[$i]['title'],200,"_","").'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d",strtotime($result[$i]['registered_on'])).'</lastmod>';
		$xml .= '<changefreq>daily</changefreq>';
		$xml .= '<priority>0.8</priority>';		
		$xml .= '</url>';
		
	}	
	
	
	
	$sql = sprintf("SELECT * FROM recipe_category ORDER BY name DESC LIMIT 1000");
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://GoZbiTe.Com/рецепти-категория-'.$result[$i]["id"].','.myTruncateToCyrilic($result[$i]['name'],200,"_","").'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d").'</lastmod>';
		$xml .= '<changefreq>weekly</changefreq>';
		$xml .= '<priority>0.9</priority>';		
		$xml .= '</url>';
		
	}	
// ------------------------------------------------------------------------------------------------		





// ----------------------------------------- НАПИТКИ -----------------------------------------------
	$sql="SELECT id, title, registered_on FROM drinks ORDER BY registered_on DESC LIMIT 10000";
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://GoZbiTe.Com/разгледай-напитка-'.$result[$i]["id"].','.myTruncateToCyrilic($result[$i]['title'],200,"_","").'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d",strtotime($result[$i]['registered_on'])).'</lastmod>';
		$xml .= '<changefreq>daily</changefreq>';
		$xml .= '<priority>0.8</priority>';		
		$xml .= '</url>';
		
	}	
	
	
	$sql = sprintf("SELECT * FROM drink_category ORDER BY name DESC LIMIT 1000");
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://GoZbiTe.Com/напитки-категория-'.$result[$i]["id"].','.myTruncateToCyrilic($result[$i]['name'],200,"_","").'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d").'</lastmod>';
		$xml .= '<changefreq>weekly</changefreq>';
		$xml .= '<priority>0.9</priority>';		
		$xml .= '</url>';
		
	}	
// ------------------------------------------------------------------------------------------------		







// ----------------------------------------- Описания от Справочника -----------------------------------------------
	$sql="SELECT id, title, registered_on FROM guides ORDER BY registered_on DESC LIMIT 10000";
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://GoZbiTe.Com/разгледай-справочник-'.$result[$i]["id"].','.myTruncateToCyrilic($result[$i]['title'],200,"_","").'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d",strtotime($result[$i]['registered_on'])).'</lastmod>';
		$xml .= '<changefreq>daily</changefreq>';
		$xml .= '<priority>0.8</priority>';		
		$xml .= '</url>';
		
	}	
// ------------------------------------------------------------------------------------------------		




// ----------------------------------------- Форум -----------------------------------------------
	$sql="SELECT questionID, created_on, question_title  FROM questions ORDER BY created_on DESC LIMIT 10000";
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://GoZbiTe.Com/разгледай-форум-тема-'.$result[$i]["questionID"].','.myTruncateToCyrilic($result[$i]['question_title'],200,"_","").'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d",strtotime($result[$i]['created_on'])).'</lastmod>';
		$xml .= '<changefreq>daily</changefreq>';
		$xml .= '<priority>0.7</priority>';		
		$xml .= '</url>';
		
	}	
	
	
	
	$sql = sprintf("SELECT * FROM question_category ORDER BY name DESC LIMIT 1000");
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://GoZbiTe.Com/форум-категория-'.$result[$i]["id"].','.myTruncateToCyrilic($result[$i]['name'],200,"_","").'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d").'</lastmod>';
		$xml .= '<changefreq>weekly</changefreq>';
		$xml .= '<priority>0.9</priority>';		
		$xml .= '</url>';
		
	}	
// ------------------------------------------------------------------------------------------------		


	

// ----------------------------------------- Дестинации -----------------------------------------------
	$sql="SELECT l.id as 'id', l.name as 'location_name', lt.name as 'locType' FROM locations l, location_types lt WHERE l.loc_type_id = lt.id AND ( LENGTH(l.info)>10 OR l.id IN (SELECT locationID FROM location_pics)) AND lt.id = l.loc_type_id ORDER BY l.name LIMIT 10000";
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://gozbite.com/разгледай-дестинация-'.$result[$i]["id"].','.myTruncateToCyrilic($result[$i]['locType'].'_'.$result[$i]['location_name'],200,"_","").'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d").'</lastmod>';
		$xml .= '<changefreq>daily</changefreq>';
		$xml .= '<priority>0.9</priority>';		
		$xml .= '</url>';
		
	}	
// ------------------------------------------------------------------------------------------------		






// ----------------------------------------- Болести -----------------------------------------------
	$sql="SELECT bolestID, date, title FROM bolesti ORDER BY date DESC LIMIT 1000";
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://gozbite.com/разгледай-болест-'.$result[$i]["bolestID"].','.myTruncateToCyrilic($result[$i]['title'],200,"_","").'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d",strtotime($result[$i]['date'])).'</lastmod>';
		$xml .= '<changefreq>daily</changefreq>';
		$xml .= '<priority>0.9</priority>';		
		$xml .= '</url>';
		
	}	
	
	
	
	$sql = sprintf("SELECT * FROM bolest_category ORDER BY name DESC LIMIT 1000");
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://gozbite.com/болести-категория-'.$result[$i]["id"].','.myTruncateToCyrilic($result[$i]['name'],200,"_","").'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d").'</lastmod>';
		$xml .= '<changefreq>weekly</changefreq>';
		$xml .= '<priority>0.9</priority>';		
		$xml .= '</url>';
		
	}	
	
	
	
	$sql = sprintf("SELECT * FROM bolest_simptoms ORDER BY name DESC LIMIT 1000");
	$conn->setsql($sql);
	$conn->getTableRows();
	$result   = $conn->result;
	$nums 	  = $conn->numberrows;	

	for ($i=0;$i<$nums;$i++)
	{
		$xml .= '<url>';
		$xml .= '<loc>http://gozbite.com/болести-симптом-'.$result[$i]["id"].',характерен_симптом_'.myTruncateToCyrilic($result[$i]['name'],200,"_","").'.html</loc>';
		$xml .= '<lastmod>'.date("Y-m-d").'</lastmod>';
		$xml .= '<changefreq>weekly</changefreq>';
		$xml .= '<priority>0.9</priority>';		
		$xml .= '</url>';
		
	}	
// ------------------------------------------------------------------------------------------------		

	
	

	

	$xml .= '</urlset>';
	
	header('Content-Type: application/xml');
	
	print $xml;
	?>