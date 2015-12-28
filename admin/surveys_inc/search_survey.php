<div><a href="javascript:void(0);" onclick=" new Effect.toggle($('searchDiv'),'Blind'); ">Търси</a></div>
<div id="searchDiv" style="float:left; margin-top:10px; width:420px;display:none;" >

	
				  <div style="float:left; margin-left:0px; margin-top:10px; margin-bottom:10px; height:20px; width:100px;">
					
					<input type="image" value="Търси" src="images/btn_blue.png" id="search_btn" title="търси" name="search_btn" style="border: 0pt none ; display: inline;" height="20" type="image" width="96">
											
				  </div>
				  <div style="float:left;margin:10px;margin-left:0px;width:420px;"> 
                        <fieldset style="float:left;width:420px;margin-bottom:20px;">
				       <legend>&nbsp;Дата на публикация</legend> <br />        
                       <?php     
							printf("    от <input type = \"text\" id = \"fromDate\" name = \"fromDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalFDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете начална дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)",  date("d.m.Y",strtotime($resultEdit['fromDate'])));
							printf("    до <input type = \"text\" id = \"toDate\" name = \"toDate\" value = \"%s\" size = \"10\" maxlength = \"10\" reaonly = \"readonly\" />&nbsp;<a href = \"javascript: showCal('CalTDate')\"><img src = \"images/calendar.png\" width = \"16\" height = \"16\" border = \"0\" alt = \"Изберете крайна дата\" style = \"vertical-align: top;\"></a>(дд.мм.гггг)",  date("d.m.Y",strtotime($_REQUEST['toDate'])));
					   ?>   
					    </fieldset>   
				  	
					 
			 </div> 
			 <div style="float:left;margin:10px;margin-left:0px;width:420px;">               	  		 
	             <div style="float:left;margin:10px;margin-left:0px;width:200px;">  
                       Ключова дума в текста: <br />  <input type="text" name="search_survey_body" id="search_survey_body"  style="overflow:no;width:200px;" value="<?=$_REQUEST['question_body']?>"/>
                 </div>             
             </div> 
  			   
             <div style="float:left;margin:10px;margin-left:0px;width:420px;"> 
                      	<div  id = "city" style = "float:left; overflow-y: auto;overflow-x: none;">
                                По колко на страница?: <br />   <select style="width:200px;" name="limit" id="limit" >
					  				<option value="">Избери</option>
					  				<option value="5"  <?=($_REQUEST['limit'] == 5)?'selected':''?> >5</option>
									<option value="10"  <?=($_REQUEST['limit'] == 10)?'selected':''?> >10</option>
									<option value="20"  <?=($_REQUEST['limit'] == 20)?'selected':''?> >20</option>
									<option value="50"  <?=($_REQUEST['limit'] == 550)?'selected':''?> >50</option>
									<option value="100"  <?=($_REQUEST['limit'] == 100)?'selected':''?> >100</option>					  			
				  								  			
				  				</select>
                         </div>                             
                            
			  </div>           
               		
				
          
	 </div>
				  
				  