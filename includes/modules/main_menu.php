<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	$main_menu = "";
	
	$main_menu .='<ul id="awesome-menu">

	<li><a class="homeLi" href="начална-страница,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" '.($params['page_name']=='home'?'style="background-position: 0 -45px;"':'').' title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Начало] body=[Връщане в главната страница на GoZbiTe.Com!]\'>НАЧАЛО</a></li>

	<li><a class="recipesLi" href="разгледай-рецепти,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" '.(($params['page_name']=='recipes' OR $params['page_name']=='edit_recipe')?'style="background-position: -125px -45px;"':'').' title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Рецепти] body=[Вкусни готварски рецепти с месо, вегетариански, със зеленчуци,плодове, апетитни десерти, торти, дребни сладки, тестени изделия, екзотични рецепти и още...!]\'>Рецепти</a></li>

	<li><a class="postsLi" href="прочети-статии,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" '.(($params['page_name']=='posts' OR $params['page_name']=='edit_posts')?'style="background-position: -250px -45px;"':'').' title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Статии] body=[Актуални статии от областта на кулинарията и здравословното хранене, както и много полезни съвети!]\'>Статии</a></li>

	<li><a class="drinksLi" href="разгледай-напитки,екзотични_коктейли_алкохолни_безалкохолни_шейкове_сиропи_нектари_концентрати.html" '.(($params['page_name']=='drinks' OR $params['page_name']=='edit_drink')?'style="background-position: -375px -45px;"':'').' title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Напитки] body=[Алкохолни и безалкохолни напитки, екзотични коктейли, ароматни кофеинови напитки, освежаващи шейкове, чайове, сиропи, нектари и още...!]\'>Напитки</a></li>

	<li><a class="guideLi" href="разгледай-справочник,храните_по_света_витамини_минерали_плодове_зеленчуци_история_на_рецепти_световни_кухни_още.html" '.(($params['page_name']=='guides' OR $params['page_name']=='edit_guide')?'style="background-position: -500px -45px;"':'').'  title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Справочник А-Я] body=[Пълен кулинарен справочник с информация за видовете храни и продукти, състав на храните, качества и недостатаци, описания на терминологията и още...!]\'>Справочник А-Я</a></li>

	<li><a class="firmsLi" href="разгледай-фирми,сладкарница_ресторант_пицария_магазин_бар_закусвалня_вносител_храни_кръчма.html" '.(($params['page_name']=='firms' OR $params['page_name']=='edit_firm')?'style="background-position: -625px -45px;"':'').'  title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Заведения/Фирми] body=[Списък с най-изисканите заведения и фирми, техните контакти и описание с богат текстов и снимков материал!]\'>Болести</a></li>

	<li><a class="freetimeLi" href="javasctipt:void(0);return false;" '.(in_array($params['page_name'], array('locations', 'edit_location', 'bolesti', 'edit_bolesti', 'locations', 'edit_location')) ? 'style="background-position: -750px -45px;"' : '').'>Свободно време</a></li>

	<li><a class="forumLi" href="разгледай-форум,интересни_кулинарни_теми_потърси_съвет_или_помогни.html" '.(($params['page_name']=='forum' OR $params['page_name']=='edit_questions')?'style="background-position: -875px -45px;"':'').'  title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Форум] body=[Мястото, където сайта е Ваш!<br /><hr>  Всеки потребител може да публикува свои мнения и коментари!]\'>Форум</a></li>';

	$main_menu .='</ul>';
	
    $main_menu .='
<ul id="awesome-sub-menu">

	<li><a class="destinationsLi" href="разгледай-дестинации,описание_на_градове_села_курорти_дестинации_от_цял_свят.html" '.(($params['page_name']=='locations' OR $params['page_name']=='edit_location')?'style="background-position: 0 -45px;"':'').' title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Дестинации] body=[Пълно описание на Дестинации от цял свят с богат текстов, снимков и видео материал!]\'>Дестинации</a></li>

	<li><a class="bolestiLi" href="разгледай-болести,симптоми_лечение_и_описания_на_заболявания.html" '.(($params['page_name']=='bolesti' OR $params['page_name']=='edit_bolesti')?'style="background-position: -110px -45px;"':'').' title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Болести] body=[Описания на Заболявание и техните симптоми!]\'>Болести</a></li>

	<li><a class="aphorismsLi" href="прочети-афоризми,интересни_афоризми_крилати_фрази.html" '.(($params['page_name']=='aphorisms' OR $params['page_name']=='edit_aphorisms')?'style="background-position: -220px -45px;"':'').'  title=\'offsetx=[15] offsety=[15] windowlock=[on] cssbody=[dvbdy1] cssheader=[dvhdr1] header=[Фрази] body=[Списък с огромен брой потребителски мисли и фрази, както и такива на велики личности от световната история!]\'>Фрази</a></li>';

	$main_menu .='</ul>';
	
	//$main_menu .='<hr style="float:left;  width:980px; background-color:#0099FF; border-color:#0099FF; margin-left:10px; margin-top:20px;margin-bottom:5px;">';
	$main_menu .='<div style="float:left; width:980px;margin:10px auto;text-align:center;clear:left;">';
	$main_menu .= require("includes/modules/googleAdsenseFooter_728_90.php"); // Pokazva GoogleAdsense   
	$main_menu .='</div>';
	//$main_menu .='<hr style="float:left;  width:980px; background-color:#0099FF; border-color:#0099FF; margin-left:10px; margin-top:20px;">';


	return $main_menu;


?>