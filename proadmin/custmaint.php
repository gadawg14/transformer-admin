<?php
	
				session_start();
	
	
	//require_once 'cfg.inc';
	if ($_POST['submitins']) {
		
		$sinssql = "insert into customer
			(name, city, state, zip, phone)
			values
			('" . $_POST['name'] . "', '" .
			$_POST['city'] . "', '" .
			$_POST['state'] . "', '" .
			$_POST['zip'] . 
			"', '" . $_POST['phone'] . 
			"')";
			$sqlres = mysql_query($sinssql); 
			if ($sqlres) {
				$dbmsg = '<b><i>Record Added</i></b>';
				$justadd = true;
			} else {
				$dbmsg = 'record not added - contact your friendly programmer' . mysql_error() . '<br>' . $sinssql;
			}
			
			echo $dbmsg;
		
	}

	if ($_POST['submitupd']) {
		
		$supdsql = "update customer
			set name='" . $_POST['name'] . "', " . 
			"city='" . $_POST['city'] . "', " .
			"state='" . $_POST['state'] . "', " .
			"zip='" . $_POST['zip'] . "' where custid=" . $_POST['id'];

			$sqlres = mysql_query($supdsql); 
			if ($sqlres) {
				$dbmsg = '<b><i>Record Updated</i></b>';
				$justadd = true;
			} else {
				$dbmsg = 'record not updated - contact your friendly programmer' . mysql_error() . '<br>' . $supdsql;
			}
			
			echo $dbmsg;
		
	}





?>

	<div style="width: 600px; font: 9pt/9pt arial, tahoma; text-align: left; margin: 30px 0 0 60px;">

			<a href="tpmain.php?i=customer.php" title="Cancel - Go Back">
					<img src="images/goback.png" width="50"></a>

<?php

	if($_GET['ac']=='a') {
		
		echo '<h4>Company Maintenance - Add a Company</h4>';
		
		?>		
	
				<form action="tpmain.php?i=custmaint.php&ac=a" method="POST">
					<table cellpadding="5">
					<tr><td width="120" class="tbllabels">Company Name: </td><td><input type="text" name="name" size="50" maxlength="150"></td></tr>
					<tr><td class="tbllabels">City: </td><td><input type="text" name="city" size="30" maxlength="30"></td></tr>
					<tr><td class="tbllabels">State: </td><td><input type="text" name="state" size="10" maxlength="2"></td></tr>
					<tr><td class="tbllabels">Zip: </td><td><input type="text" name="zip" size="20" maxlength="5"></td></tr>
					<tr><td class="tbllabels">Phone: </td><td><input type="text" name="phone" size="30" maxlength="20"></td></tr>
				</table>
				
						<!-- echo '<input type="hidden" name="ss" value="insert">';  -->
			
				<br><br>
				<input type="submit" name="submitins" value="Save">
				</form>

		<?php
		}
		?>
		
	
	<?php
			
			if($_GET['ac']=='e') {
				$currcust = $_REQUEST['id'];
	?>		

			<h4>Company Maintenance - Edit Company Details</h4>
				<form action="tpmain.php?i=custmaint.php&ac=e" method="POST">
				<table cellpadding="5">

		<?php	
			$editquery = "select * FROM customer c 
						where c.custid=" . $currcust;
						//echo $editquery;
			$sql = mysql_query($editquery);
			while($row = mysql_fetch_array($sql)){ 	
					echo '<tr><td width="120" class="tbllabels">Company Name: </td><td><input type="text" name="name" size="50" maxlength="150" value="' . $row['name'] . '"></td></tr>';
					echo '<tr><td class="tbllabels">City: </td><td><input type="text" name="city" size="30" maxlength="30" value="' . $row['city'] . '"></td></tr>';
					echo '<tr><td class="tbllabels">State: </td><td><input type="text" name="state" size="10" maxlength="2" value="' . $row['state'] . '"></td></tr>';
					echo '<tr><td class="tbllabels">Zip: </td><td><input type="text" name="zip" size="20" maxlength="5" value="' . $row['zip'] . '"></td></tr>';
					echo '<tr><td class="tbllabels">Phone: </td><td><input type="text" name="phone" size="30" maxlength="20" value="' . $row['phone'] . '"></td></tr>';
				}
				echo '</table>';
				
					echo '<input type="hidden" name="id" value="' . $_GET['id'] . '">'; 
		?>	
				<br><br>
				<input type="submit" name="submitupd" value="Save">
				</form>

		<?php
		}
		?>



		

</div>
