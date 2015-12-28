<?
//  
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// | Description:													      	|
// | class to manage data in grid using AJAX		  						|	
// | 																		|	
// +------------------------------------------------------------------------+
// | Author				: Neeraj Thakur <neeraj_th@yahoo.com>   	|
// | Created Date     	: 28-08-2006                  						|
// | Last Modified    	: 28-08-2006                  						|
// | Last Modified By 	: Neeraj Thakur                  					|
// +------------------------------------------------------------------------+

class clsAJAX 
{
	public $dbhost;
	public $dbuname;
	public $dbpass;
	public $dbname;
	
	private $arrTable = "lekarstva_simptoms";
	public $arrFields = array('id', 'name');
	
	public function __construct()
	{
		$dbhost = "localhost";
		$dbuname = "ohbolibg_ohboli";
		$dbpass = "fsdboing";
		$dbname = "ohbolibg_ohboli";

		$db = mysql_connect($dbhost, $dbuname, $dbpass);
		if (!$db) {  die('There was a problem with the database, please try back later db.php'); }
		mysql_select_db($dbname, $db);
	}
	
	public function showList($id='')
	{	
			$textout = "";
			$param = $_GET['param'];
			$dir = $_GET['dir'];
			if(strlen($param)>0){				
				
			$sortupimg = '^';
			$sortdownimg = 'v';
			
			$param = $_REQUEST['param'];
			$dir = $_REQUEST['dir'];
			
//start fields generation
			if ( $_GET['dir'] == 'desc' )
			{
				$textout .= '<tr class="txtheading">';
				for ( $i = 0 ; $i < count($this->arrFields) ; $i ++ )
				{
					$textout .= ($_GET['param'] == $this->arrFields[$i])?'<td><a href="#" onClick=getagents("'.$this->arrFields[$i].'","")>'.$this->arrFields[$i].'</a> '.$sortdownimg.'</td>':'<td><a href="#" onClick=getagents("'.$this->arrFields[$i].'","")>'.$this->arrFields[$i].'</a></td>';					
				}
				$textout .= '<td></td><td></td>';
				$textout .= '</tr>';
			}
			else
			{
				$textout .= '<tr class="txtheading">';
				for ( $i = 0 ; $i < count($this->arrFields) ; $i ++ )
				{
					$textout .= ($_GET['param'] == $this->arrFields[$i])?'<td><a href="#" onClick=getagents("'.$this->arrFields[$i].'","desc")>'.$this->arrFields[$i].'</a> '.$sortupimg.'</td>':'<td><a href="#" onClick=getagents("'.$this->arrFields[$i].'","desc")>'.$this->arrFields[$i].'</a></td>';					
				}
				$textout .= '<td></td><td></td>';
				$textout .= '</tr>';
			}			

//end fields generation

				$arrf='';
				for ( $i = 0 ; $i < count($this->arrFields) ; $i ++ )
				{
					$arrf .= ','.$this->arrFields[$i];
				}

				$q = 'SELECT '.substr($arrf,1,strlen($arrf)).' FROM '.$this->arrTable.' ORDER BY '.$param.' '.$dir;

				$result = mysql_query($q);
				while( $myrow = mysql_fetch_array($result) ){
					if ( $id == $myrow[$this->arrFields[0]] )
					{					
//edit as per fields controls
					   $textout .= '
					   			<tr class="txtcontents">
									<td><input type="text" size="15" class="textbox" name="txtId" id="txtId" readonly value="'.$myrow[$this->arrFields[0]].'"></td>
									<td><input type="text" size="15" class="textbox" name="txtName" id="txtName" value="'.$myrow[$this->arrFields[1]].'"></td>
									<td><a href="#" onClick=saveRecord("save",'.$myrow[$this->arrFields[0]].',"'.$param.'","'.$dir.'")>Save</a> </td>
									<td>| <a href="#" onClick=getagents("'.$param.'","'.$dir.'")>Cancel</a></td>
								</tr>
							';
					}
					else
					{
					   $textout .= '<tr class="txtcontents">';
						for ( $i = 0 ; $i < count($this->arrFields) ; $i ++ )
						{
							$textout .= '<td width="18%">'.$myrow[$this->arrFields[$i]].'</td>';
						}
						$textout .= '<td><a href="#" onClick=manipulateRecord("update",'.$myrow[$this->arrFields[0]].',"'.$param.'","'.$dir.'")>Update</a> </td>
									<td>| <a href="#" onClick=manipulateRecord("delete",'.$myrow[$this->arrFields[0]].',"'.$param.'","'.$dir.'")>Delete</a></td>
								</tr>';
					}
				}				
			} else {
				$textout='<tr><td colspan="6">No record available..</td></tr>';
			}
		if ( $_REQUEST['mode'] != "new" )
		{
			$textout .= '<tr><td height="20" valign="bottom" class="txtcontents" colspan="6">
			<a href="#" onClick=newRecord("new","'.$param.'","'.$dir.'")>New</a>
			</td></tr>';
		}
		else if ( $_REQUEST['mode'] == "new" )
		{
					   $textout .= '
					   			<tr class="txtcontents">
									<td></td>
									<td><input type="text" size="15" class="textbox" name="txtName" id="txtName" value="'.$myrow[$this->arrFields[1]].'"></td>
									<td><a href="#" onClick=saveNewRecord("newsave","'.$param.'","'.$dir.'")>Save</a> </td>
									<td>| <a href="#" onClick=getagents("'.$param.'","'.$dir.'")>Cancel</a></td>
								</tr>
							';
		}
		
		echo "<table cellspacing=\"0\" border=\"0\" cellpadding=\"2\" align=\"center\" width=\"70%\">".$textout."</table>";
	}
	
	public function deleteRecord($id='')
	{
		$result = mysql_query('delete from '.$this->arrTable.' where id = '.$id);
	}	
	
	public function saveEditedRecord()
	{
		$q = 'update '.$this->arrTable.' set  name = "'.$_REQUEST['name'].'" where id ='.$_REQUEST['id'];
		$result = mysql_query($q);
	}
	
	public function saveNewRecord()
	{
		$q = 'insert into '.$this->arrTable.'(name) values("'.$_REQUEST['name'].'")';
		$result = mysql_query($q);
	}
}

$obj = new clsAJAX();

if ( $_REQUEST['mode'] == "delete" )
{
	$obj->deleteRecord($_REQUEST['id']);
	echo $obj->showList();
}

if ( $_REQUEST['mode'] == "update" )
{
	$obj->showList($_REQUEST['id']);
}

if ( $_REQUEST['mode'] == "save" )
{
	$obj->saveEditedRecord();
	$obj->showList();
}

if ( $_REQUEST['mode'] == "newsave" )
{
	$obj->saveNewRecord();
	$obj->showList();
}

if ( $_REQUEST['mode'] == "new" )
{
	$obj->showList();
}

if ( $_REQUEST['mode'] == "list" )
{
	$obj->showList();
}
?>