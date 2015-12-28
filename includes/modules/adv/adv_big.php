<?php

/*
* Имаме името на текущата страница , в която се зарежда този блок - $params['page_name'];
*/

	
   	$adv_big = "";
   	
if($params['sub_page'] != 'web') // We hide this section if the page is 'web'	
{		
	$adv_big .= '<div class="detailsDiv" style="float:left; width:960px; margin-bottom:20px; margin-right:0px; border-top:3px solid #FF6600; color:#FFFFFF; padding:5px; background-color:#CC9900;">
					<h4 style="color:#FFFFFF;">Участие в портала GoZbiTe.Com</h4>			
				</div>
		<br style="clear:left;"/>';
		
	$adv_big .= '<ul id="awesome-menu_adv">
				<li><a class="homeLi" href="разгледай-рекламни-оферти-auditory,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" '.(($_REQUEST['get']=='auditory')?'style="background-position: 0 -50px;"':'').'>Аудитория</a></li>
			
				<li><a class="offersLi" href="разгледай-рекламни-оферти-base,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" '.(($_REQUEST['get']=='base')?'style="background-position: -150px -50px;"':'').'>Безплатно участие</a></li>
			
				<li><a class="tripsLi" href="разгледай-рекламни-оферти-banner,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" '.(($_REQUEST['get']=='banner')?'style="background-position: -300px -50px;"':'').'>Банерна реклама</a></li>
			
				<li><a class="hotelsLi" href="разгледай-рекламни-оферти-alternative,вкусни_готварски_рецепти_с_месо_вегетариански_зеленчуци_плодове_десерти_торти_сладки_коктейли.html" '.(($_REQUEST['get']=='alternative')?'style="background-position: -450px -50px;"':'').'>Алтернативна реклама</a></li>
			
			</ul>';	
}		
	
		$adv_big .= require_once($params['sub_page'].'.php');
	

	
$adv_big .= '	<div class="main-body-top"></div>	
		
    Сметка за банков превод <br />
    <b>IBAN</b>: BG93 RZBB 9155 1004 5831 66 <br />
    <b>BIC</b>: RZBBBGSF<br />
    Райфайзенбанк (България) ЕАД<br /><br />				

    <div class="main-body-bottom"></div>



    <div class="main-body-top"></div>	

    <style>

    A.epay-button             { border: solid  1px #FFF; background-color: Maroon; padding: 6px; color: #FFF; background-image: none; font-weight: normal; padding-left: 20px; padding-right: 20px; }
    A.epay-button:hover       { border: solid  1px #ABC; background-color: Maroon; padding: 6px; color: #FFF; background-image: none; font-weight: normal; padding-left: 20px; padding-right: 20px; }

    A.epay                    { text-decoration: none; border-bottom: dotted 1px Maroon; color: Maroon; font-weight: bold; }
    A.epay:hover              { text-decoration: none; border-bottom: solid  1px Maroon; color: Maroon; font-weight: bold; }

    TABLE.epay-view    { white-space: nowrap; background-color: #CCC; }

    /********** VIEWES **********************************************************/

    TD.epay-view            { width: 100%; text-align: center; background-color: #DDD; }
    TD.epay-view-header     {                                  background-color: Maroon; color: #FFF; height: 30px; }
    TD.epay-view-name       { width:  25%; text-align: right;  background-color: #E9E9F9; border-bottom: none;  height: 30px; }
    TD.epay-view-value      { width:  75%; text-align: left;   background-color: #E9E9F9; border-bottom: none; white-space: normal; }

    INPUT.epay-button         { border: solid  1px #FFF; background-color: Maroon; padding: 4px; color: #FFF; background-image: none; padding-left: 20px; padding-right: 20px; }
    INPUT.epay-button:hover   { border: solid  1px #ABC; background-color: Maroon; padding: 4px; color: #FFF; background-image: none; padding-left: 20px; padding-right: 20px; }

    </style>

    </form>
    <form action="https://www.epay.bg/" method=post>
    <table class=epay-view cellspacing=1 cellpadding=4 width=700>
    <tr>
    <td class=epay-view-header align=center>Описание</td>
    <td class=epay-view-header align=center>Сума*</td>
    </tr>
    <tr>
    <td class=epay-view-value><b>Заплатете Услугата on-line</b></td>
    <td class=epay-view-name><input type=text name=TOTAL value="" id="TOTAL" size=5> Лв.</td>
    </tr>
    <tr>
    <td colspan=2 class=epay-view-name>
    <input class=epay-button type=submit name=BUTTON:EPAYNOW value="   Плащане on-line   " onclick="if(document.getElementById(\'TOTAL\').value > 0) { sendMailWhenEpayBg(document.getElementById(\'TOTAL\').value) }">
    </td>
    </tr>
    <tr>
    <td colspan=2 class=epay-view-name style="white-space: normal; font-size: 10">
    Плащането се осъществява чрез <a class=epay href="https://www.epay.bg/">ePay.bg</a> - Интернет системата за плащане с банкови карти и микросметки
    </td>
    </tr>
    </table>
    <input type=hidden name=PAGE value="paylogin">
    <input type=hidden name=MIN value="6042735676">
    <input type=hidden name=INVOICE value="">
    <input type=hidden name=DESCR value="Zaplatete Vashata Usluga on-line">
    <input type=hidden name=URL_OK value="http://www.gozbite.com">
    <input type=hidden name=URL_CANCEL value="http://www.gozbite.com">
    </form>

    <form>
    <br />

    <b>*В полето "Сума" въведете стойността, която трябва да заплатите он-лайн, след което натиснете бутона "Плащане on-line" за да бъдете прехвърлени към системата на ePay.bg!</b>	

    <div class="main-body-bottom"></div>



    <div class="main-body-top"></div>	

    <font style="color:#CC9900;">За въпроси и/или коментари Ви молим да се свържете с екипа на <a href=\'http://gozbite.com/разгледай-страница-feedback,задайте_въпрос_напишете_коментар_препоръка_или_мнение.html\'>GoZbiTe.Com</a></font>!

    <div class="main-body-bottom"></div>';


$adv_big .= '<script>';	
for ($i=1;$i<16;$i++) 
{
	$adv_big .= 'TooltipManager.addURL("view_adv_'.$_REQUEST['get'].'_'.$i.'", "help/view_adv_'.$_REQUEST['get'].'_'.$i.'.html", 500, 500);';
}
$adv_big .= '</script>'; 

return $adv_big;

?>