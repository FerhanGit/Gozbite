<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/
	require_once("includes/functions.php");
	require_once("includes/config.inc.php");
	require_once("includes/bootstrap.inc.php");
   
   	$conn = new mysqldb();
   
   
	$home_page_lilavo = "";
	
	
	//********************************** Броя на всяка информационна единица *******************************//
		
		
		$sql="SELECT COUNT(id) as cnt_firms FROM firms";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultCntFirms = $conn->result['cnt_firms'];
		
		
		$sql="SELECT COUNT(id) as cnt_recipes FROM recipes";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultCntRecipes = $conn->result['cnt_recipes'];
		
		
		$sql="SELECT COUNT(postID) as cnt_posts FROM posts";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultCntPosts = $conn->result['cnt_posts'];
		
		
		$sql="SELECT COUNT(id) as cnt_drinks FROM drinks";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultCntDrinks = $conn->result['cnt_drinks'];
		
		
		$sql="SELECT COUNT(id) as cnt_guides FROM guides";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultCntGuides = $conn->result['cnt_guides'];
	
		
		$sql="SELECT COUNT(bolestID) as cnt_bolesti FROM bolesti";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultCntBolesti = $conn->result['cnt_bolesti'];
		
		
		$sql="SELECT COUNT(aphorismID) as cnt_aphorisms FROM aphorisms";
		$conn->setsql($sql);
		$conn->getTableRow();
		$resultCntAphorisms = $conn->result['cnt_aphorisms'];
	
	
					
		$sql = array();
		$sql[]="SELECT COUNT(q.questionID) as cnt_comments FROM questions q";
		$sql[]="SELECT COUNT(pc.commentID) as cnt_comments FROM post_comment pc";
		$sql[]="SELECT COUNT(rc.commentID) as cnt_comments FROM recipe_comment rc";
		$sql[]="SELECT COUNT(dc.commentID) as cnt_comments FROM drink_comment dc";
		$sql[]="SELECT COUNT(fc.commentID) as cnt_comments FROM firm_comment fc";
		$sql[]="SELECT COUNT(gc.commentID) as cnt_comments FROM guide_comment gc";
		$sql[]="SELECT COUNT(bc.commentID) as cnt_comments FROM bolest_comment bc";
		$sql[]="SELECT COUNT(lc.commentID) as cnt_comments FROM location_comment lc";
		$resultCntComments = 0;
		foreach($sql  as $query)
		{
			$conn->setsql($query);
			$conn->getTableRow();
			$resultCntComments += $conn->result['cnt_comments'];
		}
		unset($sql);
	
	//******************************************************************************************************//
	
	
				
		$home_page_lilavo .= '<ul id="intro">
					<li id="services"><h3>Най-ново</h3>
					<br />
					<p style="margin:0px;">
						
						<iframe align="center"  valign="middle" src="http://www.gozbite.com/includes/tools/post_ticker.php" height="260" width="310" frameborder="0" scrolling="No" allowTransparency="true" style="background-color:transparent;"></iframe>';
						
		$home_page_lilavo .='</p></li>
					<li id="more"><h3>В GoZbiTe.Com ще намерите</h3><p> &rarr; <a href="разгледай-рецепти,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">'.$resultCntRecipes.' Готварски Рецепти </a><br /> &rarr; <a href="разгледай-напитки,екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">'.$resultCntDrinks.' Напитки </a><br />  &rarr; <a href="прочети-статии,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html">'.$resultCntPosts.' Статии и Полезни съвети </a><br /> &rarr; <a href="разгледай-справочник,екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html">'.$resultCntGuides.' Описания в Справочника </a><br /> &rarr; <a href="разгледай-болести,симптоми_лечение_и_описания_на_заболявания.html">'.$resultCntBolesti.' Описани Заболявания </a><br /> &rarr; <a href="разгледай-фирми,сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html">'.$resultCntFirms.' Заведения / Фирми </a><br /> &rarr; <a href="прочети-афоризми,интересни_афоризми_крилати_фрази.html">'.$resultCntAphorisms.' Фрази/Афоризми </a><br /><!-- &rarr; <a href="разгледай-форум,интересни_кулинарни_теми_потърси_съвет_или_помогни.html"><?php //print $resultCntComments;?> Коментари </a></p> <br /><h3 style="font-weight:bold;" ><div title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Бързо търсене!] body=[&rarr; Само с едно кликване на мишката върху избраното <span style="color:#FF6600;font-weight:bold;">населено място</span> системата извършва последователно търсене за Ресторанти, Пицарии, Механи, Таверни, Барове, Сладкарници, Закусвални, Дискотеки, Клубове, Магазини и др., намиращи се в съответното <span style="color:#FF6600;font-weight:bold;">населено място</span>.]\'></>Търси Заведение / Фирма</div></h3>--> <iframe align="center"  valign="middle" src="http://www.gozbite.com/includes/tools/flash_map_main.php" height="170" width="300" frameborder="0" scrolling="No" allowTransparency="true" style="background-color:transparent;"></iframe></li>
				</ul>';
		
		return $home_page_lilavo;
	  
	?>
