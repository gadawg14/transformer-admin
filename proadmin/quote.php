<?php

			session_start();
			
	if($_GET[p]){
		unset($_SESSION['searchfld']);
		unset($_SESSION['searchval']);
		unset($_SESSION['contactidfilt']);
		unset($_SESSION['custidfilt']);
		
	}		

	if ($_REQUEST['custid']){
		unset($_SESSION['searchfld']);
		unset($_SESSION['searchval']);
		$_SESSION['custidfilt']=$_REQUEST['custid'];
		
	}
	
	if ($_REQUEST['contactid']){
		unset($_SESSION['searchfld']);
		unset($_SESSION['searchval']);
		$_SESSION['contactidfilt']=$_REQUEST['contactid'];
	
	}

	if ($_POST['searchsubmit']) {
		unset($_SESSION['contactidfilt']);
		unset($_SESSION['custidfilt']);
		$_SESSION['searchfld']=$_POST['sfld'];
		$_SESSION['searchval']=$_POST['sval'];
	}
	

	$sortdesc='';
	$dataquery = "select q.quoteid, c.custid, c.name as custname, con.contactid, con.lastname, con.firstname,
								concat(con.lastname, ',', con.firstname) as searchname, q.transtype,
								q.* FROM quote q 
								join customer c on c.custid = q.custid
								join contact con on con.contactid=q.contactid
								where 1";
	$cntquery = "select count(*) as Num from quote q
							join customer c on c.custid=q.custid
							join contact con on con.contactid=q.contactid
							where 1";
	
	if ($_SESSION['searchfld']) {
		$dataquery .= " and " . $_SESSION['searchfld'] . " like '%" . $_SESSION['searchval'] . "%'";	
		$cntquery .= " and " . $_SESSION['searchfld'] . " like '%" . $_SESSION['searchval'] . "%'";	
		$sortdesc = 'Sorted by Quotes whose <b>' . strtoupper($_SESSION['searchfld']) . 
			'</b> is like <b>*' . 
			strtoupper($_SESSION['searchval']) . '*</b><br><br>';
	}

	if ($_SESSION['custidfilt']){
		$dataquery .= " and c.custid = " . $_SESSION['custidfilt'];	
		$cntquery .= " and c.custid = " . $_SESSION['custidfilt'];	
		
	}
	
	if ($_SESSION['contactidfilt']){
		$dataquery .= " and q.contactid = " . $_SESSION['contactidfilt'];	
		$cntquery .= " and q.contactid = " . $_SESSION['contactidfilt'];	
		
	}
	

	$dataquery .= " order by c.name, q.date desc";
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

<h4 style="margin: 0 0 10px 0;">Quote List</h4>

<div style="clear: both; float: left; width: 700px; margin-bottom: 20px; border:1px solid black;
		padding: 6px;">

<b>Search:</b> <br><br>
	<form action="tpmain.php?i=quote.php" method="POST" name="quotesearch">
	Field: <select name="sfld">
					<option value="date">Date</option>
					<option value="c.name">Company Name</option>
					<option value="searchname">Contact Name (Last,First)</option>
				</select>					
	&nbsp; &nbsp; &nbsp;
	Search String: <input type="text" name="sval" size="50"> <br><br>
	<input type="submit" name="searchsubmit" value="Search">
</form>

</div>

<div style="clear: both; float: left; width: 700px; margin-bottom: 20px;">

<!--
	<div style="float: left;">
		<a href="tpmain.php?i=quotemaint.php&ac=a" title="Add New Quote">
				<img src="images/add-icon.png" width="50"></a>
	</div>
-->

			<div style="float: right; padding: 5px; font:9pt/10pt tahoma, georgia, arial;">
<?php
			
			echo 'Page ' . $pnum . ' of ' . $total_pages . ' : ' . $total_results . ' Quotes<br><br>'; 
			
			// Build Previous Link 
			$prev = $pnum - 1;
			echo '<table><tr><td valign="top">';
			echo ($pnum > 1) ? '<a href="' . $_SERVER['PHP_SELF'] . '?i=quote.php&pnum=' . $prev . '" title="Previous Page">'.
						'<img src="images/previous-icon.png" width="20"></a> &nbsp <b>|</b> ' : 
						'<img src="images/previous-icon.png" width="20"> <b>|</b> ';	
			
			for($i = 1; $i <= $total_pages; $i++){ 
			    if(($pnum) == $i){ 
			        echo '<font size="+1">' . $i . '</font>'; 
			        } else { 
			            echo "<a href=\"".$_SERVER['PHP_SELF']."?i=quote.php&pnum=$i\">$i</a> "; 
			    } 
			} 
			
			// Build Next Link 
			if($pnum < $total_pages){ 
			    $next = ($pnum + 1); 
			    echo '<b>|</b> <a href="' . $_SERVER['PHP_SELF'] . '?i=quote.php&pnum=' . $next . '" title="Next Page">' .
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
	<table id="box-table-a"><thead>
	<tr>
	<th scope="col" width="50" colspan="2"><b>Actions</b></th>
	<th scope="col" width="100"><b>Number</b></th>
	<th scope="col" width="180"><b>Company</b></th>
	<th scope="col" width="140"><b>Contact</b></th>
	<th scope="col" width="100"><b>Date</b></th>
	<th scope="col" width="80"><b>TP Admin</b></th>
	<th scope="col"  width="80"><b>Kva</b></th>
	<th scope="col" width="80"><b>Trans</b></th>
</tr></thead>
		<tbody>

<?php
			//echo $dataquery;
			echo $sortdesc;
			$sql = mysql_query($dataquery . " LIMIT $from, $max_results");
			$i = 0;
			//echo $dataquery . '<br><br>';
			//echo $sql;
			while($row = mysql_fetch_array($sql)){ 
					echo "<tr>";
			    // Build your formatted results here. 
			    echo '<td width="30"><a href="tpmain.php?i=quotmaint.php&ac=e&quoteid=' . $row['quoteid'] . '" title="Edit">
			    					<img src="images/edit-icon.png" width="20"></a></td>';
			    echo '<td width="30"><a href="tpquotegen.php?quoteid=' . $row['quoteid'] . '" title="Generate PDF" target="_blank">
			    					<img src="images/pdf-icon.png" width="20"</a></td>';    
			    //echo '<td width="50"><a href="tpmain.php?i=contact.php&custid=' . $row['custid'] . '" title="Contacts Page">
			    	//				<img src="images/person-icon.png" width="20"</a></td>';    
			        //echo '<td>', $row['custid'];
			    echo '<td>' . $row['quotenum'] . '</td>' . "\n";
			    echo '<td>' . $row['custname'] . '</td>' . "\n";
			    echo '<td>' . 	$row['searchname'], '</a></td>', "\n";
			    echo '<td>', $row['date'] .'</td>', "\n";
		        echo '<td>', $row['tpadmin'] .'</td>', "\n";
	            echo '<td>', $row['kva'] .'</td>', "\n";
	            echo '<td>', $row['transtype'] .'</td>', "\n";			
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

