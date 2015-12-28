<?php

/**
 * Implements Bogof (Buy one get one free) promotion.
 * There are two categories:
 *	   One with games that are valid bogof games, which means only games from that category
 *	   trigger the bogof promotion.
 *	   The second list is with the free games available.
 *
 * Specifications:
 *		If you buy a game from the "buy" bogof category, you are eligible
 *		for free game from "free" bogof category.
 *		If you are buying a free game check is made to ensure the game is free and you
 *		are eligible for the free download.
 */
class PROFILE extends Page
{
	var $site = NULL;
	var $page_name = 'profile';
	
	var $events = array(
		'header' 	=> 'displayHeaderLinks',	
		'menu' 	=> 'displayMainMenu',	
		'main'		=> 'displayMainStuff',
		'right'	=> 'displayRightColumn',
		'footer'	=> 'displayFooter',
		'profile.validation' => 'checkValidData',
		'title_key_words' => 'titleKeyWords',
		'footer_overlay_div' => 'footerOverlayDiv',
	);

	function PROFILE(& $site)
	{	
		global $conn;
		$this->site = & $site;	
		
	
	}

	

	function isActive()
	{
		return true;
	}




	function displayHeaderLinks($params)
	{
		global $conn;
		$header_section = &$params['header_section'];
		$prms = array('page_name' => Pages::getCurrentPageName());
		$header_section .= Pages::loadModule('header_links',$prms);	
	}
	

	function displayMainMenu($params)
	{
		global $conn;
		$header_section = &$params['header_section'];
		$prms = array('page_name' => Pages::getCurrentPageName());
		$header_section .= Pages::loadModule('main_menu',$prms);			
	}
	


	

function displayMainStuff($params)
{
	global $conn;
	$main_section = &$params['main_section'];
	
	if(basename($GLOBALS['_SERVER']['SCRIPT_NAME']) == 'edit.php')
	{				
		$prms = array('page_name' => Pages::getCurrentPageName());		
		$main_section .= Pages::loadModule(Pages::getCurrentPageName().'/profile_big',$prms);	
	}	
}
	



function displayRightColumn($params)
{
	global $conn;
	$right_section = &$params['right_section'];
	$prms = array('page_name' => Pages::getCurrentPageName());
	
	if(basename($GLOBALS['_SERVER']['SCRIPT_NAME']) == 'edit.php')
	{
		$right_section .= Pages::loadModule(Pages::getCurrentPageName().'/insert_edit_profile',$prms);	
	}
	
	$right_section .= Pages::loadModule('register_button',$prms);	
	$right_section .= Pages::loadModule('fb_fun_box',$prms);	
	$right_section .= Pages::loadModule('fb_tw',$prms);	
	$right_section .= Pages::loadModule('na_focus',$prms);	
	$right_section .= Pages::loadModule('baner_300_250',$prms);	
	$right_section .= Pages::loadModule('aphorisms_button',$prms);	
	$right_section .= Pages::loadModule('relax',$prms);					 
				
	$right_section .= Pages::loadModule('bulletin',$prms);
   	
	$right_section .= Pages::loadModule('locations/locations_intro',$prms);	

	$right_section .= Pages::loadModule('pr_stuff',$prms);	
	
	$right_section .= '<ul class="TwoHalf">';
		$right_section .= Pages::loadModule('baner_120_240',$prms);	
		$right_section .= Pages::loadModule('archive',$prms);	
	$right_section .='</ul>';    		
	
	$right_section .= Pages::loadModule('googleAdsense_300x250px',$prms);	
	$right_section .= Pages::loadModule('survey',$prms);	
	 	 	
	$right_section .= Pages::loadModule('fb_activity',$prms);					 
	
}


	

function displayFooter($params)
{
	global $conn;
	$footer_section = &$params['footer_section'];
	$prms = array('page_name' => Pages::getCurrentPageName());

	$footer_section .= Pages::loadModule('footer_links',$prms);		  
}

	

function checkValidData($params)
{
	$valid_data = "";	

	 $valid_data .= '<script language = "JavaScript">
      
 	function checkForCorrectData(type) {
         theForm = document.searchform;         

         if(theForm.fname.value.length == 0) {
             alert(\'Моля, въведете Име!\');
             theForm.fname.value = "";
             theForm.fname.focus();
             return false;
          }

         if(theForm.lname.value.length == 0)  {
             alert(\'Моля, въведете Фамилия!\');
             theForm.lname.value = "";
             theForm.lname.focus();
             return false;
          }';

       	if (isset($_SESSION['valid_user']))
		{
			
	   		$valid_data .= "if(theForm.username.value != '".$_SESSION['valid_user']."')
	   		{
	   			var pars = 'type=' + type + '&username=' + theForm.username.value ;
	   		
		   		new Ajax.Request('includes/tools/Ajax_Check_Unique_Username.php', {method: 'post',parameters: pars,
		   			 onSuccess: function(transport) { 
		   			    if (transport.responseText.match(/exist/))
		   			    {
		   			    	alert('Избраното потребителско име е заето!Моля, въведете потребителско име!');
		   			   		theForm.username.value = \"\";
		                	theForm.username.focus();
		                	return false;
		   			    }
		   			 }
		   			 	   		
		   	   	}) ;	
	   		}";
	   		
	   		
			}
	   		else 
	   		{
	   		$valid_data .= "
	   			var pars = 'type=' + type + '&username=' + theForm.username.value ;	   		
		   		new Ajax.Request('includes/tools/Ajax_Check_Unique_Username.php', {method: 'post',parameters: pars,
		   			 onSuccess: function(transport) { 
		   			    if (transport.responseText.match(/exist/))
		   			    {
		   			    	alert('Избраното потребителско име е заето!Моля, въведете потребителско име!');
		   			   		theForm.username.value = \"\";
		                	theForm.username.focus();
		                	return false;
		   			    }
		   			 }		   			 	   		
		   	   	}) ;";	

		  
	   		}
	   		
       $valid_data .= "
         if(theForm.username.value.length == 0) {
            alert('Моля, въведете потребителско име!');
            theForm.username.value = \"\";
            theForm.username.focus();
            return false;
         }
         if(theForm.username.value.length < 5) {
            alert('Моля, въведете потребителско име по-голямо от 5 символа!');
            theForm.username.value = \"\";
            theForm.username.focus();
            return false;
         }
          if(theForm.password.value.length < 5) {
            alert('Моля, въведете парола (по-голяма от 5 символа)!');
            theForm.password.value = \"\";
            theForm.password.focus();
            return false;
         }
          if(theForm.password.value != theForm.password2.value) {
            alert('Двете пароли не съвпадат!');
            theForm.password2.value = \"\";
            theForm.password2.focus();
            return false;
         }
         
         
        
	        emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
			if (emailPattern.test(theForm.email.value)){
					
			}
			else {
				alert('Моля, въведете коректен Е-мейл адрес!');
	           	theForm.email.value = \"\";
	           	theForm.email.focus();
				return (false);
			}

                
		  	if(theForm.cityName.value.length == 0)  
			{
	             alert('Моля, изберете населено място!');
	             theForm.cityName.value = \"\";
	             theForm.cityName.focus();
	             return false;
	         }
	         

         	if(theForm.verificationcode.value.length == 0)  
            {
             	alert('Моля, въведете коректен код за сигурност!');
             	theForm.verificationcode.value = \"\";
             	theForm.verificationcode.focus();
             	return false;
          	}

      	}     
  	 </script>";
              
      print $valid_data;
       
	}

	
	
	
	

	
	function titleKeyWords()
	{		
		// KEY WORDS - Slagame gi w HEADER-a na vsqka stranica
		if(isset($_SESSION['userID']))
		{
			print 'Редактиране на потребителски профил  - '.get_user_nameByUserID($_SESSION['userID']).' - Потребители, с възможност да публикуват статии, коментари , описания на хранителни продукти и съставки, рецепти и напитки';
		}
		else 
		{
			print 'Редактиране на потребителски профил. Потребители, с възможност да публикуват статии, коментари , описания на хранителни продукти и съставки, рецепти и напитки';
		}
	
	}
	
	
	
	
	
	function footerOverlayDiv($params)
	{
		global $conn;
		$footer_overlay = &$params['footer_overlay'];
		$prms = array('page_name' => Pages::getCurrentPageName());	
		$footer_overlay .= Pages::loadModule('footer_overlay_div_banner',$prms);	
	}
	
	
	
}





?>