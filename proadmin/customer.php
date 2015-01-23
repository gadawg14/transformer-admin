<?php

			session_start();

	if ($_POST['searchsubmit']) {
		$_SESSION['searchfld']=$_POST['sfld'];
		$_SESSION['searchval']=$_POST['sval'];
	}

	$sortdesc='';
	$dataquery = "select * FROM customer c ";
	$cntquery = "select count(*) as Num from customer";
	
	if ($_SESSION['searchfld']) {
		$dataquery .= "where " . $_SESSION['searchfld'] . " like '%" . $_SESSION['searchval'] . "%'";	
		$cntquery .= " where " . $_SESSION['searchfld'] . " like '%" . $_SESSION['searchval'] . "%'";	
		$sortdesc = 'Sorted by Companies/Customers whose <b>' . strtoupper($_SESSION['searchfld']) . 
			'</b> is like <b>*' . 
			strtoupper($_SESSION['searchval']) . '*</b><br><br>';
	}

	$dataquery .= " order by c.name asc";
	//echo $cntquery;
	
if(!isset($_GET['pnum'])){ 
    $pnum = 1; 
} else { 
    $pnum = $_GET['pnum']; 
} 
$max_results = 10; 
$total_results = mysql_result(mysql_query($cntquery),0);

$total_pages = ceil($total_results / $max_results); 
$from = (($pnum * $max_results) - $max_results);

?>


<div style="margin: 0px auto; width: 100%;">

<div style="width: 100%; margin: 0 0 0 20px;">

<h4 style="margin: 0 0 10px 0;">Company List</h4>

<div style="clear: both; float: left; width: 700px; margin-bottom: 20px; border:1px solid black;
		padding: 6px;">

<b>Search:</b> <br><br>
	<form action="tpmain.php?i=customer.php" method="POST" name="custsearch">
	Field: <select name="sfld">
					<option value="name">Company Name</option>
					<option value="city">City</option>
					<option value="state">State</option>
				</select>					
	&nbsp; &nbsp; &nbsp;
	Search String: <input type="text" name="sval" size="50"> &nbsp; &nbsp; &nbsp;
	<input type="submit" name="searchsubmit" value="Search">
</form>

</div>

<div style="clear: both; float: left; width: 700px; margin-bottom: 20px;">

	<div style="float: left;">
		<a href="tpmain.php?i=custmaint.php&ac=a" title="Add New Company">
				<img src="images/add-icon.png" width="50"></a>
	</div>


			<div style="float: right; padding: 5px; font:9pt/10pt tahoma, georgia, arial;">
<?php
			
			echo 'Page ' . $pnum . ' of ' . $total_pages . ' : ' . $total_results . ' Companies/Customers<br><br>'; 
			
			// Build Previous Link 
			$prev = $pnum - 1;
			echo '<table><tr><td valign="top">';
			echo ($pnum > 1) ? '<a href="' . $_SERVER['PHP_SELF'] . '?i=customer.php&pnum=' . $prev . '" title="Previous Page">'.
						'<img src="images/previous-icon.png" width="20"></a> &nbsp <b>|</b> ' : 
						'<img src="images/previous-icon.png" width="20"> <b>|</b> ';	
			
			for($i = 1; $i <= $total_pages; $i++){ 
			    if(($pnum) == $i){ 
			        echo '<font size="+1">' . $i . '</font>'; 
			        } else { 
			            echo "<a href=\"".$_SERVER['PHP_SELF']."?i=customer.php&pnum=$i\">$i</a> "; 
			    } 
			} 
			
			// Build Next Link 
			if($pnum < $total_pages){ 
			    $next = ($pnum + 1); 
			    echo '<b>|</b> <a href="' . $_SERVER['PHP_SELF'] . '?i=customer.php&pnum=' . $next . '" title="Next Page">' .
			    '<img src="images/next-icon.png" width="20"></a>'; 
			} else {
			    echo ' <b>|</b> <img src="images/next-icon.png" width="20">';	
			}
			
			echo '</td></tr></table>';
			
			echo '</div>';
?>
</div>

<div style="clear: both; width: 100%;">
	
	<div style="font: 9pt/9pt arial, tahoma; text-align: left; margin: 30px 0 0 0;">
	<table id="box-table-a" rules="rows" cellspacing="20" border="0"><thead>
	<tr>
	<th scope="col" colspan="4"><b>Actions</b></th>
	<th scope="col" width="180"><b>Company Name</b></th>
	<th scope="col" width="100"><b>City</b></th>
	<th scope="col" width="40"><b>State</b></th>
	<th scope="col" width="80"><b>Zip</b></th>
			<th scope="col" width="120"><b>Phone</b></th>

</tr></thead>

<?php
			echo $sortdesc;
			$sql = mysql_query($dataquery . " LIMIT $from, $max_results");
			$i = 0;
			while($row = mysql_fetch_array($sql)){ 
					echo "<tr>";
			    // Build your formatted results here. 
			    echo '<td width="30"><a href="tpmain.php?i=custmaint.php&ac=e&id=' . $row['custid'] . '" title="Edit">
			    					<img src="images/edit-icon.png" width="20"></a></td>';
			    echo '<td width="30"><a href="tpmain.php?i=custmaint.php&ac=d&id=' . $row['custid'] . '" title="Delete">
			    					<img src="images/delete.png" width="20"</a></td>';    
			    echo '<td width="30"><a href="tpmain.php?i=contact.php&custid=' . $row['custid'] . '" title="Contacts Page">
			    					<img src="images/person-icon.png" width="20"</a></td>';    
			    echo '<td width="50"><a href="tpmain.php?i=quote.php&custid=' . $row['custid'] . '" title="Quote List">
			    					<img src="images/files-icon.png" width="20"</a></td>';    
			        //echo '<td>', $row['custid'];
			    echo '<td>' . $row['name'] . '</td>' . "\n";
			    echo '<td>' . 	$row['city'], '</a></td>', "\n";
			    echo '<td>', $row['state'] .'</td>', "\n";
			        echo '<td>', $row['zip'] .'</td>', "\n";
			            echo '<td>', $row['phone'] .'</td>', "\n";
			
			    echo '</tr>';
			    
			    /*
			    	if($_GET['id'] && $_GET['id']==$row['custid']){
				    		echo '<tr><td colspan="9"><table style="margin-left: 30px;"><tr><td colspan="3" style="font: bold 11pt/12pt Tahoma, Arial;">Contacts</td></tr>';
				    		echo '<tr><td><b>Actions</b></td><td width="100"><b>Last Name</b></td><td width="100"><b>First Name</b>
				    				</td><td width="180"><b>Email</b></td><td width="60"><b>Phone</b></td></tr>';
			    		$contsql = 'select * from contact where custid=' . $row['custid'];
			    		$contres=mysql_query($contsql);
			    		while($controw = mysql_fetch_array($contres)) {
							echo '<tr><td><a href="tpmain.php?i=contmaint.php?id=' . $controw['contactid'] . '" title="Edit Contact"><img src="images/edit-icon.png" width="20"></a></td>';
							echo '<td>' . $controw['lastname'] . '</td>';
							echo '<td>' . $controw['firstname'] . '</td>';
							echo '<td>' . $controw['email'] . '</td>';
							echo '<td>' . $controw['phone'] . '</td></tr></table>';
			    		
			    			
			    		}
			    		
			    	}
			    
			    */
			    
			} 
			
			echo '</table>','</div>';


?>

	
</div>
</div>

