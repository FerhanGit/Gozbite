<?php 

$return = "";
$return .= '<div id="BANER_KVADRAT_AND_NEWS_DIV" style="padding:10px 0px 10px 0px;">';

	
	$get = $_REQUEST['get'];
		
	$page = $_REQUEST['page'];

	if(isset($get))
	{ 	  	
		switch ($get)
		{
			case 'firms' :
			{
				if($_GET['orderby'] == 'cnt') $orderby = 'cnt DESC';
				elseif( isset($_GET['orderby']) && $_GET['orderby'] != 'cnt') $orderby = $_GET['orderby'];
				elseif(empty($_GET['orderby'])) $orderby = 'cnt DESC';
				if($_GET['orderby'] == 'firm_category_name') $orderby = 'cnt DESC';
					
				$sql="SELECT lf.firm_id as 'firm_id', f.name as 'firm', l.id as 'location_id', l.name as 'location', lt.name as 'locType', f.registered_on as 'registered_on',  SUM(lf.cnt) as 'cnt' FROM firms f, log_firm lf, locations l, location_types lt WHERE f.location_id = l.id  AND l.loc_type_id = lt.id AND f.active = '1' AND lf.firm_id=f.id GROUP BY lf.firm_id ORDER BY $orderby";
				$conn->setsql($sql);
				$conn->getTableRows();
				$total = $conn->numberrows;
								
				//----------------- paging ----------------------				
						$pp = 10; 	
						$numofpages = ceil($total / $pp);
						if (!isset($page) or ($page == "")) 
						{
							$page = 1;
						}
						$limitvalue = $page * $pp - ($pp);
				// -----------------------------------------------   

				$sql="SELECT lf.firm_id as 'firm_id', f.name as 'firm', l.id as 'location_id', l.name as 'location', lt.name as 'locType', f.registered_on as 'registered_on',  SUM(lf.cnt) as 'cnt' FROM firms f, log_firm lf, locations l, location_types lt WHERE f.location_id = l.id  AND l.loc_type_id = lt.id AND f.active = '1' AND lf.firm_id=f.id GROUP BY lf.firm_id ORDER BY $orderby LIMIT $limitvalue , $pp";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultFirms  = $conn->result;
				$numFirms  = $conn->numberrows;
				
				$return .= '<table width="100%">
				<tr style="font-weight:bold;color:black;"><td><a href="разгледай-статистика-'.$_GET['get'].','.$page.',firm,статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html">Наименование</a></td><td><a href="?get='.$_GET['get'].'&orderby=location">Локация</a></td><td><a href="разгледай-статистика-'.$_GET['get'].','.$page.',firm_category_name,статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html">Категория</a></td><td><a href="разгледай-статистика-'.$_GET['get'].','.$page.',registered_on,статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html">Дата на регистрация</a></td><td><a href="разгледай-статистика-'.$_GET['get'].','.$page.',cnt,статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html">Брой преглеждания</a></td></tr>';
				
				
				for ($i=0;$i<$numFirms;$i++)
				{
					$sql="SELECT fc.id as 'firm_category_id', fc.name as 'firm_category_name' FROM firms f, firm_category fc, firms_category_list fcl WHERE fcl.firm_id = f.id AND fcl.category_id = fc.id AND f.id = '".$resultFirms[$i]['firm_id']."' ";
					$conn->setsql($sql);
					$conn->getTableRows();
					$numItmCats  	= $conn->numberrows;
					$resultItmCats  = $conn->result;
					
					if($i % 2 == 0) $bgcolor = '#CCCCCC';
					else $bgcolor = '#F0F0F0';
					$rand = rand(0,($numItmCats-1));
				
					$return .= '<tr bgcolor="'.$bgcolor.'"><td><a href="разгледай-фирма-'.$resultFirms[$i]['firm_id'].','.myTruncateToCyrilic($resultFirms[$i]['firm'],100,'_','').'.html">'.$resultFirms[$i]['firm'].'</a></td><td><a href="разгледай-дестинация-'.$resultFirms[$i]['location_id'] .','.myTruncateToCyrilic($resultFirms[$i]['locType']." ".$resultFirms[$i]['location'],100,'_','') .'.html">'.$resultFirms[$i]['locType'].' '.$resultFirms[$i]['location'].'</a></td><td><a href="фирми-категория-'.$resultItmCats[$rand]['firm_category_id'].','.myTruncateToCyrilic($resultItmCats[$rand]['firm_category_name'],100,'_','').'.html">'.$resultItmCats[$rand]['firm_category_name'].'</td><td>'.$resultFirms[$i]['registered_on'].'</td><td>'.$resultFirms[$i]['cnt'].'</td></tr>';
				

				}
		$return .= '</table>';
				
				$return .= "<div class=\"paging\" style=\"  width:340px; margin:10px 30px 20px 60px; padding:5px 0 5px 0;\" align='center'>";
				
				$return .= per_page("разгледай-статистика-".$get.",%page".($_GET['orderby'] <> '' ? ','.$_GET['orderby']:'').",статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html", "2", $numofpages, $page); 
				$return .= "</div>";
				break;
			}
			case 'recipes' :
			{
				if($_GET['orderby'] == 'cnt') $orderby = 'cnt DESC';
				elseif( isset($_GET['orderby']) && $_GET['orderby'] != 'cnt') $orderby = $_GET['orderby'];
				elseif(empty($_GET['orderby'])) $orderby = 'cnt DESC';
				if($_GET['orderby'] == 'recipe_category_name') $orderby = 'cnt DESC';
				
			
				$sql="SELECT lr.recipe_id as 'recipe_id', r.title as 'recipe',  SUM(lr.cnt) as 'cnt'  FROM recipes r, log_recipe lr WHERE lr.recipe_id = r.id AND r.active = '1' GROUP BY lr.recipe_id ORDER BY $orderby";
				$conn->setsql($sql);
				$conn->getTableRows();
				$total  = $conn->numberrows;
				
				//----------------- paging ----------------------				
						$pp = 10; 	
						$numofpages = ceil($total / $pp);
						if (!isset($page) or ($page == "")) 
						{
							$page = 1;
						}
						$limitvalue = $page * $pp - ($pp);
				// -----------------------------------------------   
				
				$sql="SELECT lr.recipe_id as 'recipe_id', r.title as 'recipe',  SUM(lr.cnt) as 'cnt'  FROM recipes r, log_recipe lr WHERE lr.recipe_id = r.id AND r.active = '1' GROUP BY lr.recipe_id ORDER BY $orderby LIMIT $limitvalue , $pp";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultRecipes  = $conn->result;
				$numRecipes  = $conn->numberrows;
				
				$return .= '
				<table width="100%">
				<tr style="font-weight:bold;color:black;"><td><a href="разгледай-статистика-'.$_GET['get'].','.$page.',recipe,статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html">Наименование</a></td><td><a href="разгледай-статистика-'.$_GET['get'].','.$page.',recipe_category_name,статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html">Категория</a></td><td><a href="разгледай-статистика-'.$_GET['get'].','.$page.',cnt,статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html">Брой преглеждания</a></td></tr>';
				
				
				for ($i=0;$i<$numRecipes;$i++)
				{
					$sql="SELECT rc.id as 'recipe_category_id', rc.name as 'recipe_category_name' FROM recipes r, recipe_category rc, recipes_category_list rcl WHERE rcl.recipe_id = r.id AND rcl.category_id = rc.id AND r.id = '".$resultRecipes[$i]['recipe_id']."' ";
					$conn->setsql($sql);
					$conn->getTableRows();
					$numItmCats  	= $conn->numberrows;
					$resultItmCats  = $conn->result;
					
					if($i % 2 == 0) $bgcolor = '#CCCCCC';
					else $bgcolor = '#F0F0F0';
					$rand = rand(0,($numItmCats-1));
				
					$return .= '<tr bgcolor="'.$bgcolor.'"><td><a href="разгледай-рецепта-'.$resultRecipes[$i]['recipe_id'].','.myTruncateToCyrilic($resultRecipes[$i]['recipe'],100,'_','') .'.html ">'.$resultRecipes[$i]['recipe'].'</a></td><td><a href="рецепти-категория-'.$resultItmCats[$rand]['recipe_category_id'].','.myTruncateToCyrilic($resultItmCats[$rand]['recipe_category_name'],100,'_','') .'.html">'.$resultItmCats[$rand]['recipe_category_name'].'</td><td>'.$resultRecipes[$i]['cnt'].'</td></tr>';
				
				 
				}
$return .= '
				</table>';
			
				$return .= "<div class=\"paging\" style=\" width:340px; margin:10px 30px 20px 60px; padding:5px 0 5px 0;\" align='center'>";
				$return .= per_page("разгледай-статистика-".$get.",%page".($_GET['orderby'] <> '' ? ','.$_GET['orderby']:'').",статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html", "2", $numofpages, $page); 
				$return .= "</div>";
				break;
			}
			
			case 'drinks' :
			{
				if($_GET['orderby'] == 'cnt') $orderby = 'cnt DESC';
				elseif( isset($_GET['orderby']) && $_GET['orderby'] != 'cnt') $orderby = $_GET['orderby'];
				elseif(empty($_GET['orderby'])) $orderby = 'cnt DESC';
				if($_GET['orderby'] == 'drink_category_name') $orderby = 'cnt DESC';
				
			
				$sql="SELECT lr.drink_id as 'drink_id', r.title as 'drink',  SUM(lr.cnt) as 'cnt'  FROM drinks r, log_drink lr WHERE lr.drink_id = r.id AND r.active = '1' GROUP BY lr.drink_id ORDER BY $orderby";
				$conn->setsql($sql);
				$conn->getTableRows();
				$total  = $conn->numberrows;
				
				//----------------- paging ----------------------				
						$pp = 10; 	
						$numofpages = ceil($total / $pp);
						if (!isset($page) or ($page == "")) 
						{
							$page = 1;
						}
						$limitvalue = $page * $pp - ($pp);
				// -----------------------------------------------   
				
				$sql="SELECT lr.drink_id as 'drink_id', r.title as 'drink',  SUM(lr.cnt) as 'cnt'  FROM drinks r, log_drink lr WHERE lr.drink_id = r.id AND r.active = '1' GROUP BY lr.drink_id ORDER BY $orderby LIMIT $limitvalue , $pp";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultDrinks  = $conn->result;
				$numDrinks  = $conn->numberrows;
				
				$return .= '
				<table width="100%">
				<tr style="font-weight:bold;color:black;"><td><a href="разгледай-статистика-'.$_GET['get'].','.$page.',drink,статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html">Наименование</a></td><td><a href="разгледай-статистика-'.$_GET['get'].','.$page.',drink_category_name,статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html">Категория</a></td><td><a href="разгледай-статистика-'.$_GET['get'].','.$page.',cnt,статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html">Брой преглеждания</a></td></tr>';
							
				for ($i=0;$i<$numDrinks;$i++)
				{
					$sql="SELECT rc.id as 'drink_category_id', rc.name as 'drink_category_name' FROM drinks r, drink_category rc, drinks_category_list rcl WHERE rcl.drink_id = r.id AND rcl.category_id = rc.id AND r.id = '".$resultDrinks[$i]['drink_id']."' ";
					$conn->setsql($sql);
					$conn->getTableRows();
					$numItmCats  	= $conn->numberrows;
					$resultItmCats  = $conn->result;
					
					if($i % 2 == 0) $bgcolor = '#CCCCCC';
					else $bgcolor = '#F0F0F0';
					$rand = rand(0,($numItmCats-1));
				
					$return .= '	<tr bgcolor="'.$bgcolor.'"><td><a href="разгледай-напитка-'.$resultDrinks[$i]['drink_id'].','.myTruncateToCyrilic($resultDrinks[$i]['drink'],100,'_','') .'.html ">'.$resultDrinks[$i]['drink'].'</a></td><td><a href="напитки-категория-'.$resultItmCats[$rand]['drink_category_id'].','.myTruncateToCyrilic($resultItmCats[$rand]['drink_category_name'],100,'_','') .'.html">'.$resultItmCats[$rand]['drink_category_name'].'</td><td>'.$resultDrinks[$i]['cnt'].'</td></tr>';
				
			 
				}
				$return .= '
				</table>';
				
				$return .= "<div class=\"paging\" style=\" width:340px; margin:10px 30px 20px 60px; padding:5px 0 5px 0;\" align='center'>";
				$return .= per_page("разгледай-статистика-".$get.",%page".($_GET['orderby'] <> '' ? ','.$_GET['orderby']:'').",статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html", "2", $numofpages, $page); 
				$return .= "</div>";
				break;
			}	
			
			case 'guides' :
			{
				if($_GET['orderby'] == 'cnt') $orderby = 'cnt DESC';
				elseif( isset($_GET['orderby']) && $_GET['orderby'] != 'cnt') $orderby = $_GET['orderby'];
				elseif(empty($_GET['orderby'])) $orderby = 'cnt DESC';
				
			
				$sql="SELECT lr.guide_id as 'guide_id', r.title as 'guide',  SUM(lr.cnt) as 'cnt'  FROM guides r, log_guide lr WHERE lr.guide_id = r.id AND r.active = '1' GROUP BY lr.guide_id ORDER BY $orderby";
				$conn->setsql($sql);
				$conn->getTableRows();
				$total  = $conn->numberrows;
				
				//----------------- paging ----------------------				
						$pp = 10; 	
						$numofpages = ceil($total / $pp);
						if (!isset($page) or ($page == "")) 
						{
							$page = 1;
						}
						$limitvalue = $page * $pp - ($pp);
				// -----------------------------------------------   
				
				$sql="SELECT lr.guide_id as 'guide_id', r.title as 'guide',  SUM(lr.cnt) as 'cnt'  FROM guides r, log_guide lr WHERE lr.guide_id = r.id AND r.active = '1' GROUP BY lr.guide_id ORDER BY $orderby LIMIT $limitvalue , $pp";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultGuides  = $conn->result;
				$numGuides  = $conn->numberrows;
				
				$return .= '
				<table width="100%">
				<tr style="font-weight:bold;color:black;"><td><a href="разгледай-статистика-'.$_GET['get'].','.$page.',guide,статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html">Наименование</a></td><td><a href="разгледай-статистика-'.$_GET['get'].','.$page.',cnt,статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html">Брой преглеждания</a></td></tr>';
								
				
				for ($i=0;$i<$numGuides;$i++)
				{
					
					if($i % 2 == 0) $bgcolor = '#CCCCCC';
					else $bgcolor = '#F0F0F0';
					$rand = rand(0,($numItmCats-1));
				
					$return .= '<tr bgcolor="'.$bgcolor.'"><td><a href="разгледай-справочник-'.$resultGuides[$i]['guide_id'].','.myTruncateToCyrilic($resultGuides[$i]['guide'],100,'_','') .'.html ">'.$resultGuides[$i]['guide'].'</a></td><td>'.$resultGuides[$i]['cnt'].'</td></tr>';
				
			
				}
				$return .= '
				</table>';
			
				$return .= "<div class=\"paging\" style=\" width:340px; margin:10px 30px 20px 60px; padding:5px 0 5px 0;\" align='center'>";
				$return .= per_page("разгледай-статистика-".$get.",%page".($_GET['orderby'] <> '' ? ','.$_GET['orderby']:'').",статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html", "2", $numofpages, $page); 
				$return .= "</div>";
				break;
			}					
			case 'posts' :
			{
				if($_GET['orderby'] == 'cnt') $orderby = 'cnt DESC';
				elseif( isset($_GET['orderby']) && $_GET['orderby'] != 'cnt') $orderby = $_GET['orderby'];
				elseif(empty($_GET['orderby'])) $orderby = 'cnt DESC';
				if($_GET['orderby'] == 'post_category_name') $orderby = 'cnt DESC';
				
			
				$sql="SELECT lp.post_id as 'post_id', p.postID as 'postID', p.date as 'date', p.title as 'post',  SUM(lp.cnt) as 'cnt', pc.id as 'post_category_id', pc.name as 'post_category_name' FROM posts p, post_category pc, log_post lp WHERE lp.post_id = p.postID AND p.post_category=pc.id GROUP BY lp.post_id ORDER BY $orderby";
				$conn->setsql($sql);
				$conn->getTableRows();
				$total  = $conn->numberrows;
				
				//----------------- paging ----------------------				
						$pp = 10; 	
						$numofpages = ceil($total / $pp);
						if (!isset($page) or ($page == "")) 
						{
							$page = 1;
						}
						$limitvalue = $page * $pp - ($pp);
				// -----------------------------------------------   
				
				$sql="SELECT lp.post_id as 'post_id', p.postID as 'postID', p.date as 'date', p.title as 'post',  SUM(lp.cnt) as 'cnt', pc.id as 'post_category_id', pc.name as 'post_category_name' FROM posts p, post_category pc, log_post lp WHERE lp.post_id = p.postID AND p.post_category=pc.id GROUP BY lp.post_id ORDER BY $orderby LIMIT $limitvalue , $pp";
				$conn->setsql($sql);
				$conn->getTableRows();
				$resultPosts  = $conn->result;
				$numPosts  = $conn->numberrows;
				
				$return .= '<table width="100%">
				<tr style="font-weight:bold;color:black;"><td><a href="разгледай-статистика-'.$_GET['get'].','.$page.',post,статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html">Наименование</a></td><td><a href="разгледай-статистика-'.$_GET['get'].','.$page.',post_category_name,статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html">Категория</a></td><td><a href="разгледай-статистика-'.$_GET['get'].','.$page.',cnt,статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html">Брой преглеждания</a></td></tr>';
				
			
				for ($i=0;$i<$numPosts;$i++)
				{
					if($i % 2 == 0) $bgcolor = '#CCCCCC';
					else $bgcolor = '#F0F0F0';
					
				$return .= '<tr bgcolor="'.$bgcolor.'"><td><a href="прочети-статия-'.$resultPosts[$i]['post_id'].','.myTruncateToCyrilic($resultPosts[$i]['post'],100,'_','').'.html">'.$resultPosts[$i]['post'].'</a></td><td><a href="статии-категория-'.$resultPosts[$i]['post_category_id'].','.myTruncateToCyrilic($resultPosts[$i]['post_category_name'],100,'_','').'.html">'.$resultPosts[$i]['post_category_name'].'</td><td>'.$resultPosts[$i]['cnt'].'</td></tr>';
								
				}
				$return .= '</table>';
			
				$return .= "<div class=\"paging\" style=\" width:340px; margin:10px 30px 20px 60px; padding:5px 0 5px 0;\" align='center'>";
				//echo '<b>Общо страници: '.ceil($numofpages).'</b><br>';
				$return .= per_page("разгледай-статистика-".$get.",%page".($_GET['orderby'] <> '' ? ','.$_GET['orderby']:'').",статистика_пицарии_ресторанти_заведения_статии_рецепти_напитки.html", "2", $numofpages, $page); 
				$return .= "</div>";
				break;
			}
		}
	}				

	
$return .= '</div>';

return $return;

?>