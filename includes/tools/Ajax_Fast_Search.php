<?php
   require_once("../header.inc.php");
		
  
	if(detect_i_explorer()) 
	foreach ($_REQUEST as $key => $value)
	{
		$_REQUEST[$key] = iconv("windows-1251","UTF-8",$value);
	}


   $response = "";
   
	$pg_current = $_REQUEST['pg_current'];
	
// --------------------------- START SEARCH ------------------------------
	

	if($pg_current == 'posts')
	{
		if(empty($_REQUEST['post_category'])) $_REQUEST['post_category'] = $_REQUEST['category'];
		$_REQUEST['post_category'] = $_REQUEST['post_sub_category']?$_REQUEST['post_sub_category']:$_REQUEST['post_category'];
	 	
	 	$and="";
		if ($_REQUEST['post_body'] != "")  $and .= " AND (p.title LIKE '%".$_REQUEST['post_body']."%' OR p.body LIKE '%".$_REQUEST['post_body']."%')"; // Това е за Таговете и за Търсачката 
		if ($_REQUEST['post_category']!="")  $and .= " AND (p.post_category='".$_REQUEST['post_category']."' OR p.post_category IN (SELECT id FROM post_category WHERE parentID = '".$_REQUEST['post_category']."') )";
		if ($_REQUEST['fromDate']!="")  $and .= " AND p.date > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
		if ($_REQUEST['toDate']!="")  $and .= " AND p.date < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
		
		if ($_REQUEST['picCheck']!="")  $and .= " AND p.picURL <> '' "; // not in use for now
		 		
				
		 	    
	    $sql="SELECT p.postID as 'postID' FROM posts p, post_category pc WHERE p.post_category=pc.id AND p.active = '1' $and ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$total=$conn->numberrows;
	}	
	elseif($pg_current == 'drinks')
	{
		
	
		if(empty($_REQUEST['drink_category'])) $_REQUEST['drink_category'] = $_REQUEST['category']; 
		 	$_REQUEST['drink_category'] = $_REQUEST['drink_sub_category']?$_REQUEST['drink_sub_category']:$_REQUEST['drink_category'];
		 	
			
	 		if ($_REQUEST['drink_category']!="")  
			{
				$sql="SELECT dcl.drink_id as 'drink_id' FROM drinks d, drink_category dc, drinks_category_list dcl WHERE dcl.drink_id = d.id AND dcl.category_id = dc.id  AND (dcl.category_id = '".$_REQUEST['drink_category']."' OR dcl.category_id IN (SELECT id FROM drink_category WHERE parentID='".$_REQUEST['drink_category']."') )";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numDrinksByCats    = $conn->numberrows;
				$resultDrinksByCats = $conn->result;
				for($n=0;$n<$numDrinksByCats;$n++)
				{
					$DrinksByCatsArr[]=$resultDrinksByCats[$n]['drink_id'];
				}
				if(is_array($DrinksByCatsArr))
				$DrinksByCats = implode(',',$DrinksByCatsArr);
				else $DrinksByCats = '-1';
			}
			
			
			
			
	 		$and="";
	 		if ($DrinksByCats!="")  $and .= " AND d.id IN (".$DrinksByCats.")";
	 		if ($_REQUEST['title'] != "")  $and .= " AND (d.title LIKE '%".$_REQUEST['title']."%' OR d.info LIKE '%".$_REQUEST['title']."%')";
	 			
						
		    $sql="SELECT d.id as 'id', d.title as 'title', d.registered_on as 'registered_on' FROM drinks d WHERE d.active = '1' $and ";
			$conn->setsql($sql);
			$conn->getTableRows();
			$resultDrinks=$conn->result;
			$total=$conn->numberrows;
	
	
	
	
	}	
	elseif($pg_current == 'firms')
	{
		
		if(empty($_REQUEST['firm_category'])) $_REQUEST['firm_category'] = $_REQUEST['category'];
			$_REQUEST['firm_category'] = $_REQUEST['firm_sub_category']?$_REQUEST['firm_sub_category']:$_REQUEST['firm_category'];
		 
			
			if ($_REQUEST['firm_category']!="")  
			{
				$sql="SELECT f.id as 'firm_id' FROM firms f, firm_category fc, firms_category_list fcl WHERE fcl.firm_id = f.id AND fcl.category_id = fc.id AND (fcl.category_id = '".$_REQUEST['firm_category']."' OR fcl.category_id IN (SELECT id FROM firm_category WHERE parentID='".$_REQUEST['firm_category']."') )";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numFirmByCats    = $conn->numberrows;
				$resultFirmByCats = $conn->result;
				for($n=0;$n<$numFirmByCats;$n++)
				{
					$firmsByCatsArr[]=$resultFirmByCats[$n]['firm_id'];
				}
				if(is_array($firmsByCatsArr))
				$firmsByCats = implode(',',$firmsByCatsArr);
				else $firmsByCats = '-1';
			}
	
	 		$and="";
	 		if ($_REQUEST['firm_name']!="")  $and .= " AND f.name LIKE '%".$_REQUEST['firm_name']."%'";
	 		if ($_REQUEST['address']!="")  $and .= " AND f.address LIKE '%".$_REQUEST['address']."%'";
	 		if ($firmsByCats!="")  $and .= " AND f.id IN (".$firmsByCats.")";
	 		if ($_REQUEST['manager']!="")  $and .= " AND f.manager LIKE '%".$_REQUEST['manager']."%'";
	 		if ($_REQUEST['phone']!="")  $and .= " AND f.phone LIKE '%".$_REQUEST['phone']."%'";
	 		if ($_REQUEST['email']!="")  $and .= " AND f.email LIKE '%".$_REQUEST['email']."%'";
	 		if ($_REQUEST['description']!="")  $and .= " AND f.description LIKE '%".$_REQUEST['description']."%'";
	 		if(is_array($_REQUEST['cityName']))$locations = implode(',',$_REQUEST['cityName']);
	 		else $locations = $_REQUEST['cityName'];
			if (($_REQUEST['cityName']!="") && ($_REQUEST['cityName']!="-1")) $and .= " AND f.location_id IN (".implode(',',getSuccessors($locations)).")";
			if ($_REQUEST['fromDate']!="")  $and .= " AND f.registered_on > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
	 		if ($_REQUEST['toDate']!="")  $and .= " AND f.registered_on < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
	 		
	 	    
		    $sql="SELECT f.id as 'id', f.name as 'firm_name', f.phone as 'phone', f.address as 'address', f.email as 'email', f.manager as 'manager', l.name as 'location', lt.name as 'locType', f.registered_on as 'registered_on', f.description as 'description', f.has_pic as 'has_pic' FROM firms f, locations l, location_types lt WHERE f.location_id = l.id  AND l.loc_type_id = lt.id AND f.active = '1' $and ";
			$conn->setsql($sql);
			$conn->getTableRows();
			$total=$conn->numberrows;	
	
	}
	elseif($pg_current == 'recipes')
	{
		
		if(empty($_REQUEST['recipe_category'])) $_REQUEST['recipe_category'] = $_REQUEST['category']; 
		 	$_REQUEST['recipe_category'] = $_REQUEST['recipe_sub_category']?$_REQUEST['recipe_sub_category']:$_REQUEST['recipe_category'];
		 	
			
	 		if ($_REQUEST['recipe_category']!="")  
			{
				$sql="SELECT rcl.recipe_id as 'recipe_id' FROM recipes r, recipe_category rc, recipes_category_list rcl WHERE rcl.recipe_id = r.id AND rcl.category_id = rc.id  AND (rcl.category_id = '".$_REQUEST['recipe_category']."' OR rcl.category_id IN (SELECT id FROM recipe_category WHERE parentID='".$_REQUEST['recipe_category']."') )";
				$conn->setsql($sql);
				$conn->getTableRows();
				$numRecipesByCats    = $conn->numberrows;
				$resultRecipesByCats = $conn->result;
				for($n=0;$n<$numRecipesByCats;$n++)
				{
					$RecipesByCatsArr[]=$resultRecipesByCats[$n]['recipe_id'];
				}
				if(is_array($RecipesByCatsArr))
				$RecipesByCats = implode(',',$RecipesByCatsArr);
				else $RecipesByCats = '-1';
			}
			
			
			
	 		$and="";
	 		if ($RecipesByCats!="")  $and .= " AND r.id IN (".$RecipesByCats.")";
	 		if ($_REQUEST['title'] != "")  $and .= " AND (r.title LIKE '%".$_REQUEST['title']."%' OR r.info LIKE '%".$_REQUEST['title']."%')";
	 			
            if (isset($_REQUEST['kuhnq']) && $_REQUEST['kuhnq'] != "")  
			{
				$and .= " AND kl.kuhnq_id = ".$_REQUEST['kuhnq'] . " ";
			}
			
			
		    $sql="SELECT r.id as 'id', r.title as 'title', r.registered_on as 'registered_on' FROM recipes r, kuhni k, kuhni_list kl  WHERE r.active = '1' AND k.id = kl.kuhnq_id AND kl.recipe_id = r.id AND r.from_vkusnotiiki_net <> 1 $and ";
			$conn->setsql($sql);
			$conn->getTableRows();
			$resultRecipes=$conn->result;
			$total=$conn->numberrows;
            
			
	}
	elseif($pg_current == 'bolesti')
	{
		
		if(empty($_REQUEST['bolest_category'])) $_REQUEST['bolest_category'] = $_REQUEST['category'];
		$_REQUEST['bolest_category'] = $_REQUEST['bolest_sub_category']?$_REQUEST['bolest_sub_category']:$_REQUEST['bolest_category'];
	 	

		if ($_REQUEST['bolest_category']!="")  
		{
			$sql="SELECT bcl.bolest_id as 'bolest_id' FROM bolesti b, bolest_category bc, bolesti_category_list bcl WHERE bcl.bolest_id = b.bolestID AND bcl.category_id = bc.id AND (bcl.category_id = '".$_REQUEST['bolest_category']."' OR bcl.category_id IN (SELECT id FROM bolest_category WHERE parentID='".$_REQUEST['bolest_category']."') )";
			$conn->setsql($sql);
			$conn->getTableRows();
			$numBolestiByCats    = $conn->numberrows;
			$resultBolestiByCats = $conn->result;
			for($n=0;$n<$numBolestiByCats;$n++)
			{
				$bolestiByCatsArr[]=$resultBolestiByCats[$n]['bolest_id'];
			}
			if(is_array($bolestiByCatsArr))
			$bolestiByCats = implode(',',$bolestiByCatsArr);
			else $bolestiByCats = -1;
		}
		
	
		
		
		
		if (is_array($_REQUEST['bolest_simptom']) && count($_REQUEST['bolest_simptom'])>0 ) 
		{
			$sql="SELECT bsl.bolest_id as 'bolest_id' FROM bolesti b, bolest_simptoms bs, bolesti_simptoms_list bsl WHERE bsl.bolest_id = b.bolestID AND bsl.simptom_id = bs.id AND bsl.simptom_id IN (".implode(',',$_REQUEST['bolest_simptom']).")";
			$conn->setsql($sql);
			$conn->getTableRows();
			$numBolestiBySimptoms    = $conn->numberrows;
			$resultBolestiBySimptoms = $conn->result;
			for($n=0;$n<$numBolestiBySimptoms;$n++)
			{
				$bolestiBySimptomsArr[]=$resultBolestiBySimptoms[$n]['bolest_id'];
			}
			if(is_array($bolestiBySimptomsArr))
			$bolestiBySimptoms = implode(',',$bolestiBySimptomsArr);
			else $bolestiBySimptoms = -1;
		}
		elseif (!is_array($_REQUEST['bolest_simptom']) && $_REQUEST['bolest_simptom']<>'') 
		{
			$sql="SELECT bsl.bolest_id as 'bolest_id' FROM bolesti b, bolest_simptoms bs, bolesti_simptoms_list bsl WHERE bsl.bolest_id = b.bolestID AND bsl.simptom_id = bs.id AND bsl.simptom_id IN (".$_REQUEST['bolest_simptom'].")";
			$conn->setsql($sql);
			$conn->getTableRows();
			$numBolestiBySimptoms    = $conn->numberrows;
			$resultBolestiBySimptoms = $conn->result;
			for($n=0;$n<$numBolestiBySimptoms;$n++)
			{
				$bolestiBySimptomsArr[]=$resultBolestiBySimptoms[$n]['bolest_id'];
			}
			if(is_array($bolestiBySimptomsArr))
			$bolestiBySimptoms = implode(',',$bolestiBySimptomsArr);
			else $bolestiBySimptoms = -1;
		}
		
		
		
		
		
		
 		 $and="";
 		if ($bolestiByCats!="")  $and .= " AND b.bolestID IN (".$bolestiByCats.")";
 		if ($bolestiBySimptoms!="")  $and .= " AND b.bolestID IN (".$bolestiBySimptoms.")"; 		
 		if ($_REQUEST['bolest_body'] != "")  $and .= " AND (b.title LIKE '%".$_REQUEST['bolest_body']."%' OR b.body LIKE '%".$_REQUEST['bolest_body']."%')"; // Това е за Таговете и за Търсачката 
 		if ($_REQUEST['autor_type']!="")  $and .= " AND b.autor_type LIKE '%".$_REQUEST['autor_type']."%'"; 
 		if ($_REQUEST['autor']!="")  $and .= " AND b.autor == '".$_REQUEST['autor']."'"; 
 		if ($_REQUEST['bolest_source']!="")  $and .= " AND b.source LIKE '%".$_REQUEST['bolest_source']."%'"; 
 		if ($_REQUEST['bolest_autor']!="")  $and .= " AND b.autor LIKE '%".$_REQUEST['bolest_autor']."%'"; 	 		
 		if ($_REQUEST['fromDate']!="")  $and .= " AND b.date > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
 		if ($_REQUEST['toDate']!="")  $and .= " AND b.date < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
 		
 		if ($_REQUEST['picCheck']!="")  $and .= " AND b.has_pic = '1' "; 
			
		
		
 	    
	    $sql="SELECT b.bolestID as 'bolestID', b.date as 'date', b.title as 'title', b.body as 'body', b.has_pic as 'has_pic', b.autor_type as 'autor_type', b.autor as 'autor', b.source as 'source' FROM bolesti b WHERE 1=1 AND b.active = '1' $and ";
		$conn->setsql($sql);
		$conn->getTableRows();
		$total=$conn->numberrows;
			

	}
	elseif($pg_current == 'forums')
	{
		
 		 $and="";
 		if(empty($_REQUEST['question_category'])) $_REQUEST['question_category'] = $_REQUEST['category'];		
	
		if ($_REQUEST['fromDate']!="")  $and .= " AND q.created_on > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
		if ($_REQUEST['toDate']!="")  $and .= " AND q.created_on < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
		if ($_REQUEST['question_category']!="")  $and .= " AND q.category='".$_REQUEST['question_category']."'";
		if ($_REQUEST['question_body'] != "")  $and .= " AND (q.question_title LIKE '%".$_REQUEST['question_body']."%' OR q.question_body LIKE '%".$_REQUEST['question_body']."%')"; // Това е за Таговете и за Търсачката 
									
	
		//$sql="SELECT q.questionID as 'questionID', q.parentID as 'parentID', q.created_on as 'created_on', q.question_body as 'question_body', q.question_title as 'question_title', qc.name as 'category' FROM questions q, question_category qc WHERE q.category=qc.id AND q.parentID = '0' AND q.active = '1' $and ORDER BY q.created_on DESC";
		$sql="SELECT q.questionID as 'questionID', q.parentID as 'parentID', q.created_on as 'created_on', q.question_body as 'question_body', q.question_title as 'question_title', qc.name as 'category' FROM questions q, question_category qc WHERE q.category=qc.id AND q.active = '1' $and ORDER BY q.created_on DESC";
		$conn->setsql($sql);
		$conn->getTableRows();
		$total=$conn->numberrows;	
			
	}
	elseif($pg_current == 'aphorisms')
	{
		
 		 $and="";
 		if ($_REQUEST['aphorism_body'] != "")  $and .= " AND (a.title LIKE '%".$_REQUEST['aphorism_body']."%' OR a.body LIKE '%".$_REQUEST['aphorism_body']."%')"; // Това е за Таговете и за Търсачката 
 		if ($_REQUEST['autor_type']!="")  $and .= " AND a.autor_type LIKE '%".$_REQUEST['autor_type']."%'"; 
 		if ($_REQUEST['autor']!="")  $and .= " AND a.autor = '".$_REQUEST['autor']."'"; 
 		if ($_REQUEST['aphorism_autor']!="")  $and .= " AND a.autor LIKE '%".$_REQUEST['aphorism_autor']."%'"; 	 		
 		if ($_REQUEST['fromDate']!="")  $and .= " AND a.date > STR_TO_DATE('".$_REQUEST['fromDate']."','%d.%m.%Y %H.%i')";
 		if ($_REQUEST['toDate']!="")  $and .= " AND a.date < STR_TO_DATE('".$_REQUEST['toDate']."','%d.%m.%Y %H.%i')"; 
 			 						
	
	    $sql="SELECT DISTINCT(a.aphorismID) as 'aphorismID' FROM aphorisms a WHERE a.active = '1' $and";	
		$conn->setsql($sql);
		$conn->getTableRows();
		$total=$conn->numberrows;	
			
	}
	
	
	
	$response .= "<input type='submit' value='Търси сред ".$total." резултата'  id='search_btn' title='търси' name='search_btn' >";
					
	
   print $response;
?>