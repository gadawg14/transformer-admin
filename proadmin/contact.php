<?php

			session_start();

	$currcust = $_REQUEST['custid'];

	$sortdesc='';
	$dataquery = "select * FROM contact c";
	//$cntquery = "select count(*) as Num from contact";
	
	$dataquery .= " where c.custid=$currcust";

	$custnamesql = 'select name from customer where custid=' . $_GET['custid'];
	$custname=mysql_result(mysql_query($custnamesql),0);

	$dataquery .= " order by lastname, firstname asc";
	

	//echo $cntquery;
	
/*
if(!isset($_GET['pnum'])){ 
    $pnum = 1; 
} else { 
    $pnum = $_GET['pnum']; 
} 
$max_results = 3; 
$total_results = mysql_result(mysql_query($cntquery),0);

$total_pages = ceil($total_results / $max_results); 
$from = (($pnum * $max_results) - $max_results);
*/
?>


<div style="margin: 0px auto; width: 100%;">

<div style="width: 100%; margin: 0 0 0 20px;">

<h4 style="margin: 10px 0 10px 0;">Contact List</h4>
<?php
	echo '<h3>' . ucwords($custname) . '</h3><br><br>';
?>

<!--

<div style="clear: both; float: left; width: 700px; margin-bottom: 20px; border:1px solid black;
		padding: 6px;">

<b>Search:</b> <br><br>
	<form action="tpmain.php?i=contact.php" method="POST" name="contsearch">
	Field: <select name="sfld">
					<option value="lastname">Last Name</option>
					<option value="firstname">First Name</option>
					<option value="email">Email</option>
				</select>					
	&nbsp; &nbsp; &nbsp;
	Search String: <input type="text" name="sval" size="50"> &nbsp; &nbsp; &nbsp;
	<input type="submit" name="searchsubmit" value="Search">
</form>

</div>
-->

<div style="clear: both; float: left; width: 700px; margin-bottom: 30px;">

	<div style="float: left; margin-bottom: 20px;">
		<a href="tpmain.php?i=contmaint.php&ac=a&custid=<?php echo $currcust; ?>" title="Add New Contact">
				<img src="images/new-cust.png" width="50"></a>
	</div>


			<div style="float: right; padding: 5px; font:9pt/10pt tahoma, georgia, arial;">
<?php
			/*
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
			*/
?>
</div>

<div style="clear: both; width: 100%;">
	
	<div style="font: 9pt/9pt arial, tahoma; text-align: left; margin: 30px 0 0 0;">
	<table id="box-table-a"><thead>
	<tr>
	<th scope="col" colspan="3">Actions</th>
	<th scope="col" width="120">Last Name</th>
	<th scope="col" width="120">First Name</th>
	<th scope="col" width="160">Email</th>
<th scope="col" width="80">Phone</th></thead>


	</tr>

<?php
			echo $sortdesc;
			//echo $dataquery;
			$sql = mysql_query($dataquery);
			$i = 0;
			while($row = mysql_fetch_array($sql)){ 
					echo "<tr>";
			    // Build your formatted results here. 
			    echo '<td width="30"><a href="tpmain.php?i=contmaint.php&ac=e&contactid=' . $row['contactid'] . '&custid=' . $currcust . '" title="Edit">
			    					<img src="images/edit-icon.png" width="20"></a></td>';
			    echo '<td width="30"><a href="tpmain.php?i=contmaint.php&ac=d&id=' . $row['contactid'] . '" title="Delete">
			    					<img src="images/delete.png" width="20"</a></td>';    
			    echo '<td width="50"><a href="tpmain.php?i=quotmaint.php&ac=a&contactid=' . $row['contactid'] . '&custid=' . $currcust . '" title="New Quote">
			    					<img src="images/documentadd-icon.png" width="20"</a></td>';    
			        //echo '<td>', $row['custid'];
			    echo '<td>' . $row['lastname'] . '</td>' . "\n";
			    echo '<td>' . 	$row['firstname'], '</a></td>', "\n";
			    echo '<td>', $row['email'] .'</td>', "\n";
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

