<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/
    require_once("includes/functions.php");
    require_once("includes/config.inc.php");
    require_once("includes/bootstrap.inc.php");

    $conn = new mysqldb();



    $right_menu = "";
        
    $right_menu .= ' <div class="boxRight">
	<div class="title">Подменю</div>
	<div class="contentBox"> ';
	 
/* Тук добавяме тези страници където ще се появява страничното меню! */
$titlesArray['posts'] 			= 'Статии'.(($_REQUEST['search'] == 1) ? (' &rarr; Търси') : ($_REQUEST['category'] > 0 ? (' &rarr; '.get_post_category($_REQUEST['category'])) : ' &rarr; Категории'));
$titlesArray['edit_posts'] 		= 'Статии'.(($_REQUEST['search'] == 1) ? (' &rarr; Търси') : ($_REQUEST['category'] > 0 ? (' &rarr; '.get_post_category($_REQUEST['category'])) : ' &rarr; Публикуване'));
$titlesArray['recipes'] 		= 'Готварски Рецепти'.(($_REQUEST['search'] == 1) ? (' &rarr; Търси') : ($_REQUEST['category'] > 0 ? (' &rarr; '.get_recipe_category($_REQUEST['category'])) : ' &rarr; Категории'));
$titlesArray['edit_recipe']		= 'Готварски Рецепти'.(($_REQUEST['search'] == 1) ? (' &rarr; Търси') : ($_REQUEST['category'] > 0 ? (' &rarr; '.get_recipe_category($_REQUEST['category'])) : ' &rarr; Публикуване'));
$titlesArray['firms'] 			= 'Организации'.(($_REQUEST['search'] == 1) ? (' &rarr; Търси') : ($_REQUEST['category'] > 0 ? (' &rarr; '.get_firm_category($_REQUEST['category'])) : ' &rarr; Категории'));
$titlesArray['edit_firm'] 		= 'Организации'.(($_REQUEST['search'] == 1) ? (' &rarr; Търси') : ($_REQUEST['category'] > 0 ? (' &rarr; '.get_firm_category($_REQUEST['category'])) : ' &rarr; Регистриране'));
$titlesArray['drinks'] 			= 'Напитки'.(($_REQUEST['search'] == 1) ? (' &rarr; Търси') : ($_REQUEST['category'] > 0 ? (' &rarr; '.get_drink_category($_REQUEST['category'])) : ' &rarr; Категории'));
$titlesArray['edit_drink']		= 'Напитки'.(($_REQUEST['search'] == 1) ? (' &rarr; Търси') : ($_REQUEST['category'] > 0 ? (' &rarr; '.get_drink_category($_REQUEST['category'])) : ' &rarr; Регистриране'));
$titlesArray['forum']			= 'Форум'.(($_REQUEST['search'] == 1) ? (' &rarr; Търси') : ($_REQUEST['category'] > 0 ? (' &rarr; '.get_question_category($_REQUEST['category'])) : ' &rarr; Категории'));
$titlesArray['cards'] 			= 'Картички/Покани'.(($_REQUEST['search'] == 1) ? (' &rarr; Търси') : ($_REQUEST['category'] > 0 ? (' &rarr; '.get_card_category($_REQUEST['category'])) : ' &rarr; Категории'));
$titlesArray['edit_card']		= 'Картички/Покани'.(($_REQUEST['search'] == 1) ? (' &rarr; Търси') : ($_REQUEST['category'] > 0 ? (' &rarr; '.get_card_category($_REQUEST['category'])) : ' &rarr; Публикуване'));
$titlesArray['bolesti'] 		= 'Болести';
$titlesArray['edit_bolesti']		= 'Болести';
$titlesArray['forums'] 			= 'Форум'.(($_REQUEST['search'] == 1) ? (' &rarr; Търси') : ($_REQUEST['category'] > 0 ? (' &rarr; '.get_question_category($_REQUEST['category'])) : ' &rarr; Категории'));
$titlesArray['edit_forums']		= 'Форум'.(($_REQUEST['search'] == 1) ? (' &rarr; Търси') : ($_REQUEST['category'] > 0 ? (' &rarr; '.get_question_category($_REQUEST['category'])) : ' &rarr; Публикуване'));


if(isset($titlesArray[$params['page_name']]))
{


$right_menu .= '<div id="mDiv"  style=" float:left; width:300px; padding:10px 0px 0px 5px;">
 
  
   	<div class="detailsDiv" style="float:left; width:250px; text-align:center; margin-bottom:20px; margin-left:20px; border-top:3px solid #0099FF; padding:5px; background-color:#F1F1F1;">
		'.$titlesArray[$params['page_name']].'
	</div>

 <br style="clear:left;"/>
 
<table border="0" style="float:left; width:300px; " cellpadding="2" cellspacing="0">

 <tr>
  <td width="300">
    
<ul style="margin:0px;padding:0px; list-style : none; line-height:1.5 ;">';

if($params['page_name']=='recipes')
{

    $right_menu .= '<li><!--1nd drop down menu -->                                                

<img id="img_search_recipe" src="images/menu_strelka_'.($_GET['search'] == 1?'orange':'white').'.png" />&nbsp;<a onmouseover="$(\'img_search_recipe\').src=\'images/menu_strelka_orange.png\';" onmouseout="if('.(($_GET['search'] == 1)?'true':'false').') { $(\'img_search_recipe\').src=\'images/menu_strelka_orange.png\'; } else { $(\'img_search_recipe\').src=\'images/menu_strelka_white.png\'; }" class="orange10px" href="търси-рецепта,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" target="_self">ТЪРСИ</a><br />';


$right_menu .=  "<hr>";
$right_menu .= "<div style='float:left; width:150px; overflow:hidden;'>";

$sql = "SELECT id,name FROM recipe_category WHERE parentID=0 ORDER BY  rank, name";
$conn->setsql($sql);
$conn->getTableRows();
$resultMenuRecipes = $conn->result;
$numMenuRecipes = $conn->numberrows;
$halfNum = ceil($numMenuRecipes/2);
for($d=0;$d<$numMenuRecipes;$d++)
{
$right_menu .= '<img id="img_recipe'.$d.'" src="images/menu_strelka_'.($resultMenuRecipes[$d]['id']==$_REQUEST['category']?'orange':'white').'.png" />&nbsp;<a onmouseover="$(\'img_recipe'.$d.'\').src=\'images/menu_strelka_orange.png\';" onmouseout="if('.(($resultMenuRecipes[$d]['id'] == $_REQUEST['category'])?'true':'false').') { $(\'img_recipe'.$d.'\').src=\'images/menu_strelka_orange.png\'; } else { $(\'img_recipe'.$d.'\').src=\'images/menu_strelka_white.png\'; }"  href="рецепти-категория-'.$resultMenuRecipes[$d]['id'].','.myTruncateToCyrilic($resultMenuRecipes[$d]['name'],200,'_','') .'.html" target="_self">'.$resultMenuRecipes[$d]['name'].'</a><br />';


	if($halfNum == ($d+1))
	{
		$right_menu .= "</div><div style='float:left; width:150px; overflow:hidden;'>";
	
	}
} 
$right_menu .= '</div>
</li>';
 }


 

if($params['page_name']=='drinks')
{
$right_menu .= '<li><!--1nd drop down menu -->                                                

<img id="img_search_drink" src="images/menu_strelka_'.($_GET['search'] == 1?'orange':'white').'.png" />&nbsp;<a onmouseover="$(\'img_search_drink\').src=\'images/menu_strelka_orange.png\';" onmouseout="if('.(($_GET['search'] == 1)?'true':'false').') { $(\'img_search_drink\').src=\'images/menu_strelka_orange.png\'; } else { $(\'img_search_drink\').src=\'images/menu_strelka_white.png\'; }" class="orange10px" href="търси-напитка,екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html" target="_self">ТЪРСИ</a><br />';


$right_menu .= "<hr>";
$right_menu .= "<div style='float:left; width:150px; overflow:hidden;'>";


$sql = "SELECT id,name FROM drink_category WHERE parentID=0 ORDER BY  rank, name";
$conn->setsql($sql);
$conn->getTableRows();
$resultMenuDrinks = $conn->result;
$numMenuDrinks = $conn->numberrows;
$halfNum = ceil($numMenuDrinks/2);
for($d=0;$d<$numMenuDrinks;$d++)
{
$right_menu .= '<img id="img_drink'.$d.'" src="images/menu_strelka_'.($resultMenuDrinks[$d]['id']==$_REQUEST['category']?'orange':'white').'.png" />&nbsp;<a onmouseover="$(\'img_drink'.$d.'\').src=\'images/menu_strelka_orange.png\';" onmouseout="if('.(($resultMenuDrinks[$d]['id'] == $_REQUEST['category'])?'true':'false').') { $(\'img_drink'.$d.'\').src=\'images/menu_strelka_orange.png\'; } else { $(\'img_drink'.$d.'\').src=\'images/menu_strelka_white.png\'; }"  href="напитки-категория-'.$resultMenuDrinks[$d]['id'].','.myTruncateToCyrilic($resultMenuDrinks[$d]['name'],200,'_','') .'.html" target="_self">'.$resultMenuDrinks[$d]['name'].'</a><br />';

	if($halfNum == ($d+1))
	{
		$right_menu .= "</div><div style='float:left; width:150px; overflow:hidden;'>";
	
	} 
} 
$right_menu .= '</div>
</li>';
}





if($params['page_name']=='cards')
{
$right_menu .= '<li>';                                                


if($_SESSION['user_kind'] == 2) 
{
	$right_menu .= '<img id="img_redaktirai_card" src="images/menu_strelka_'.($pageName == 'edit_card'?'orange':'white').'.png" />&nbsp;<a onmouseover="$(\'img_redaktirai_card\').src=\'images/menu_strelka_orange.png\';"onmouseout="$(\'img_redaktirai_card\').src=\'images/menu_strelka_white.png\';"  class="orange10px"  href="добави-нова-картичка,екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html" target="_self">Добави</a><br />';
}


$right_menu .= "<hr>";
$right_menu .= "<div style='float:left; width:150px; overflow:hidden;'>";

$sql = "SELECT id,name FROM card_category WHERE parentID=0 ORDER BY  rank, name";
$conn->setsql($sql);
$conn->getTableRows();
$resultMenuCards = $conn->result;
$numMenuCards = $conn->numberrows;
$halfNum = ceil($numMenuCards/2);
for($d=0;$d<$numMenuCards;$d++)
{
$right_menu .= '<img id="img_card'.$d.'" src="images/menu_strelka_'.($resultMenuCards[$d]['id']==$_REQUEST['category']?'orange':'white').'.png" />&nbsp;<a onmouseover="$(\'img_card'.$d.'\').src=\'images/menu_strelka_orange.png\';" onmouseout="if('.(($resultMenuCards[$d]['id'] == $_REQUEST['category'])?'true':'false').') { $(\'img_card'.$d.'\').src=\'images/menu_strelka_orange.png\'; } else { $(\'img_card'.$d.'\').src=\'images/menu_strelka_white.png\'; }"  href="картички-категория-'.$resultMenuCards[$d]['id'].','.myTruncateToCyrilic($resultMenuCards[$d]['name'],200,'_','') .'.html" target="_self">'.$resultMenuCards[$d]['name'].'</a><br />';

	if($halfNum == ($d+1))
	{
		$right_menu .= "</div><div style='float:left; width:150px; overflow:hidden;'>";
	}
} 
$right_menu .= '</div>
</li>';
} 










if($params['page_name']=='firms')
{
$right_menu .= '<li><!--2st drop down menu -->                                
<img id="img_search_firms" src="images/menu_strelka_'.($_GET['search'] == 1?'orange':'white').'.png" />&nbsp;<a onmouseover="$(\'img_search_firms\').src=\'images/menu_strelka_orange.png\';" onmouseout="if('.(($_GET['search'] == 1)?'true':'false').') { $(\'img_search_firms\').src=\'images/menu_strelka_orange.png\'; } else { $(\'img_search_firms\').src=\'images/menu_strelka_white.png\'; }" class="orange10px" href="търси-фирма,сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html" target="_self">ТЪРСИ</a><br />';


if($_SESSION['user_kind'] == 2) 
{
$right_menu .= '<img id="img_redaktirai_firm" src="images/menu_strelka_'.($pageName == 'edit_firm'?'orange':'white').'.png" />&nbsp;<a onmouseover="$(\'img_redaktirai_firm\').src=\'images/menu_strelka_orange.png\';" onmouseout="$(\'img_redaktirai_firm\').src=\'images/menu_strelka_white.png\';"  class="orange10px"  href="добави-нова-фирма,сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html" target="_self">РЕГИСТРИРАЙ</a><br />';

}
elseif(isset($_SESSION['valid_user']) && $_SESSION['user_type'] == 'firm')
{
	$right_menu .= '<img id="img_redaktirai_firm" src="images/menu_strelka_'.($pageName == 'edit_firm'?'orange':'white').'.png" />&nbsp;<a onmouseover="$(\'img_redaktirai_firm\').src=\'images/menu_strelka_orange.png\';" onmouseout="$(\'img_redaktirai_firm\').src=\'images/menu_strelka_white.png\';"  class="orange10px"  href="редактирай-фирма-'.$_SESSION['userID'].','.myTruncateToCyrilic($_SESSION['name'],200,'_','').'.html" target="_self">РЕДАКТИРАЙ ПРОФИЛ</a><br />';
 
}

$right_menu .= "<hr>";
$right_menu .= "<div style='float:left; width:150px; overflow:hidden;'>";

$sql = "SELECT id,name FROM firm_category WHERE parentID=0 ORDER BY  rank, name";
$conn->setsql($sql);
$conn->getTableRows();
$resultMenuFirms = $conn->result;
$numMenuFirms = $conn->numberrows;
$halfNum = ceil($numMenuFirms/2);
for($h=0;$h<$numMenuFirms;$h++)
{
$right_menu .= '<img id="img_firm'.$h.'" src="images/menu_strelka_'.($resultMenuFirms[$h]['id']==$_REQUEST['category']?'orange':'white').'.png" />&nbsp;<a onmouseover="$(\'img_firm'.$h.'\').src=\'images/menu_strelka_orange.png\';" onmouseout="if('.(($resultMenuFirms[$h]['id'] == $_REQUEST['category'])?'true':'false').') { $(\'img_firm'.$h.'\').src=\'images/menu_strelka_orange.png\'; } else { $(\'img_firm'.$h.'\').src=\'images/menu_strelka_white.png\'; }"  href="фирми-категория-'.$resultMenuFirms[$h]['id'].','.(myTruncateToCyrilic($resultMenuFirms[$h]['name'],200,'_','') ).'.html" target="_self">'.$resultMenuFirms[$h]['name'].'</a><br />';

	if($halfNum == ($h+1))
	{
		$right_menu .= "</div><div style='float:left; width:150px; overflow:hidden;'>";
	
	} 
} 
$right_menu .= '</div>
</li>';
}



if($params['page_name']=='posts')
{
    $right_menu .= '<li>
    <!--4nd drop down menu -->                                    
    <img id="img_search_statiq" src="images/menu_strelka_white.png" />&nbsp;<a onmouseover="$(\'img_search_statiq\').src=\'images/menu_strelka_orange.png\';" onmouseout="$(\'img_search_statiq\').src=\'images/menu_strelka_white.png\';"  class="orange10px" href="търси-статия,полезни_кулинарни_статии_рецепти.html" target="_self">ТЪРСИ</a><br />';

    $right_menu .= "<hr style='width:280px;'>";
    $right_menu .= "<div style='float:left; width:150px; overflow:hidden;'>";

    $sql = "SELECT id,name FROM post_category WHERE parentID=0 ORDER BY name";
    $conn->setsql($sql);
    $conn->getTableRows();
    $resultMenuPosts = $conn->result;
    $numMenuPosts = $conn->numberrows;
    $halfNum = ceil($numMenuPosts/2);
    for($d=0;$d<$numMenuPosts;$d++)
    {
    $right_menu .= '<img id="img_post'.$d.'" src="images/menu_strelka_'.($resultMenuPosts[$d]['id']==$_REQUEST['category']?'orange':'white').'.png" />&nbsp;<a onmouseover="$(\'img_post'.$d.'\').src=\'images/menu_strelka_orange.png\';" onmouseout="$(\'img_post'.$d.'\').src=\'images/menu_strelka_white.png\';"   href="статии-категория-'.$resultMenuPosts[$d]['id'].','.myTruncateToCyrilic($resultMenuPosts[$d]['name'],50,'_','') .'.html" target="_self">'.$resultMenuPosts[$d]['name'].'</a><br />';

            if($halfNum == ($d+1))
            {
                    $right_menu .= "</div><div style='float:left; width:150px; overflow:hidden;'>";

            } 
    } 
    $right_menu .= '</div>
    </li>';
}



if($params['page_name']=='bolesti')
{
$right_menu .= '<li><!--3nd drop down menu -->                                              

<img id="img_search_bolest" src="images/menu_strelka_white.png" />&nbsp;<a onmouseover="$(\'img_search_bolest\').src=\'images/menu_strelka_orange.png\';"onmouseout="$(\'img_search_bolest\').src=\'images/menu_strelka_white.png\';"  class="orange10px" href="търси-болест,симптоми_лечение_и_описания_на_заболявания.html" target="_self">ТЪРСИ</a><br />';


if(isset($_SESSION['valid_user'])) 
{
    $right_menu .= '<img id="img_redaktirai_bolest" src="images/menu_strelka_white.png" />&nbsp;<a onmouseover="$(\'img_redaktirai_bolest\').src=\'images/menu_strelka_orange.png\';"onmouseout="$(\'img_redaktirai_bolest\').src=\'images/menu_strelka_white.png\';"  class="orange10px"  href="добави-нова-болест,симптоми_лечение_и_описания_на_заболявания.html" target="_self">Добави/Редактирай</a><br />'; 
}


$right_menu .=  "<hr style='width:280px;'>";
$right_menu .=  "<div style='float:left; width:150px; overflow:hidden;'>";


$sql = "SELECT id,name FROM bolest_category WHERE parentID=0 ORDER BY name";
$conn->setsql($sql);
$conn->getTableRows();
$resultMenuBolesti = $conn->result;
$numMenuBolesti = $conn->numberrows;
$halfNum = ceil($numMenuBolesti/2);
for($i=0;$i<$numMenuBolesti;$i++)
{
    $right_menu .= '<img id="img_bolest'.$i.'" src="images/menu_strelka_'.($resultMenuBolesti[$i]['id']==$_REQUEST['category']?'orange':'white').'.png" />&nbsp;<a onmouseover="$(\'img_bolest'.$i.'\').src=\'images/menu_strelka_orange.png\';" onmouseout="$(\'img_bolest'.$i.'\').src=\'images/menu_strelka_white.png\';"  href="болести-категория-'.$resultMenuBolesti[$i]['id'].','.myTruncateToCyrilic($resultMenuBolesti[$i]['name'],50,'_','') .'.html" target="_self">'.$resultMenuBolesti[$i]['name'].'</a><br />';

	if($halfNum == ($i+1))
	{
		$right_menu .=  "</div><div style='float:left; width:150px; overflow:hidden;'>";
	
	} 
} 
$right_menu .= '</div>

</li>';
}





if($params['page_name']=='forums')
{
$right_menu .= '<li><!--3nd drop down menu -->                                                
<img id="img_search_questions" src="images/menu_strelka_white.png" />&nbsp;<a onmouseover="$(\'img_search_questions\').src=\'images/menu_strelka_orange.png\';" onmouseout="$(\'img_search_questions\').src=\'images/menu_strelka_white.png\';"  class="orange10px" href="търси-форум-тема,интересни_кулинарни_теми_потърси_съвет_или_помогни.html" target="_self">ТЪРСИ</a><br />';


$right_menu .= "<hr style='width:280px;'>";
$right_menu .= "<div style='float:left; width:150px; overflow:hidden;'>";

$sql = "SELECT id,name FROM question_category WHERE parentID=0 ORDER BY name";
$conn->setsql($sql);
$conn->getTableRows();
$resultMenuQuestions = $conn->result;
$numMenuQuestions = $conn->numberrows;
$halfNum = ceil($numMenuQuestions/2);
for($i=0;$i<$numMenuQuestions;$i++)
{

$right_menu .= '<img id="img_questions'.$i.'" src="images/menu_strelka_'.($resultMenuQuestions[$i]['id']==$_REQUEST['category']?'orange':'white').'.png" />&nbsp;<a onmouseover="$(\'img_questions'.$i.'\').src=\'images/menu_strelka_orange.png\';" onmouseout="$(\'img_questions'.$i.'\').src=\'images/menu_strelka_white.png\';"  href="форум-категория-'.$resultMenuQuestions[$i]['id'].','.myTruncateToCyrilic($resultMenuQuestions[$i]['name'],50,'_','') .'.html" target="_self">'.$resultMenuQuestions[$i]['name'].'</a><br />';

	if($halfNum == ($i+1))
	{
		$right_menu .= "</div><div style='float:left; width:150px; overflow:hidden;'>";
	
	} 
} 
$right_menu .= '</div>
</li>';

}





$right_menu .= '</ul>

</td>

 </tr>
</table>

</div>';

} 
$right_menu .= '<br style="clear:left;"/><br style="clear:left;"/>

</div></div>';
        
	return $right_menu;
	 
?>
