<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

$adv_menu = "";

$adv_menu .= '<ul id="awesome-menu_adv">
	<li><a class="homeLi" href="разгледай-рекламни-оферти-auditory,статии_за_здравето_лекарства_заболявания_болници_лекари.html" '.(($pageName=='adv' && $_REQUEST['get']=='auditory')?'style="background-position: 0 -50px;"':'').'>Аудитория</a></li>

	<li><a class="offersLi" href="разгледай-рекламни-оферти-base,статии_за_здравето_лекарства_заболявания_болници_лекари.html" '.(($pageName=='adv' && $_REQUEST['get']=='base')?'style="background-position: -150px -50px;"':'').'>Безплатно участие</a></li>

	<li><a class="tripsLi" href="разгледай-рекламни-оферти-banner,статии_за_здравето_лекарства_заболявания_болници_лекари.html" '.(($pageName=='adv' && $_REQUEST['get']=='banner')?'style="background-position: -300px -50px;"':'').'>Банерна реклама</a></li>

	<li><a class="hotelsLi" href="разгледай-рекламни-оферти-alternative,статии_за_здравето_лекарства_заболявания_болници_лекари.html" '.(($pageName=='adv' && $_REQUEST['get']=='alternative')?'style="background-position: -450px -50px;"':'').'>Алтернативна реклама</a></li>

	<li><a class="firmsLi" href="разгледай-рекламни-оферти-packages,статии_за_здравето_лекарства_заболявания_болници_лекари.html" '.(($pageName=='adv' && $_REQUEST['get']=='packages')?'style="background-position: -600px -50px;"':'').'>Пакети</a></li>

	
</ul>';

return $adv_menu;
?>

