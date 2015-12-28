<style type="text/css">.border {	border: 0.5px #666666;}</style>
<?php 
include('class_paging.php');
include('dbcon.inc');
mysql_select_db('floorer');

    $page = $_GET['page']; 
    $limit = 5; 
	
    $result1 = mysql_query("select count(*) from `aforizmi`"); 	
    $total = mysql_result($result1, 0, 0); 
	
    $pager  = Pager::getPagerData($total, $limit, $page); 
    $offset = $pager->offset; 
    $limit  = $pager->limit; 
    $page   = $pager->page; 
	
    $query = "select * from `aforizmi` order by `id` ASC limit $offset, $limit"; 	
    $result1 = mysql_query($query); 
	
echo '<table width="75%" class="border" align="center" bgcolor="#F1F1F1">
  <tr>
    <td ><div align="center"><b><u>Афоризъм</u></b></div></td>
    <td><div align="center"><b><u>Автор</u></b></div></td>
    <td colspan="2"><div align="center"><b><u>Опции</u></b></div></td>
  </tr>';
      while($result=mysql_fetch_array($result1)) 
	{
 echo '<tr>
    <td align="center">'.$result['tekst'].'</td>
    <td align="center">'.$result['avtor'].'</td>
    <td align="center"><a href="?cmd=add_aforizmi&page='.$page.'">Добави</a></td>	
	 <td align="center"><a href="del_aforizmi.php?page='.$page.'&id='.$result['id'].'">Изтрий</a></td>	
  </tr>';}
 echo ' </table>';

 echo "<div align='center'>";

     if ($page == 1) 
        echo "Назад"; 
    else           
        echo "<a href=\"zabavno.php?open=aforizmi&page=" . ($page - 1) . "\">&nbsp;Назад&nbsp;</a>"; 
    for ($i = 1; $i <= $pager->numPages; $i++) { 
        echo " "; 
        if ($i == $pager->page) 
            echo "Страница $i"; 
        else 
            echo "<a href=\"zabavno.php?open=aforizmi&page=$i\">&nbsp;Страница $i&nbsp;</a>"; 
			
	} 
    if ($page == $pager->numPages) 
        echo " Напред "; 
    else         
        echo "<a href=\"zabavno.php?open=aforizmi&page=" . ($page + 1) . "\">&nbsp;Напред &nbsp;</a>"; 
mysql_close();
?></div>