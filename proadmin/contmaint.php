<?php

			session_start();
		
				$currcont = $_REQUEST['contactid'];
				$currcust = $_REQUEST['custid'];

	//require_once 'cfg.inc';
	if ($_POST['submitins']) {
		
		$sinssql = "insert into contact
			(custid, lastname, firstname, email, phone)
			values
			('" . $_POST['custid'] . "', '" .
			$_POST['lastname'] . "', '" .
			$_POST['firstname'] . "', '" .
			$_POST['email'] . 
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
		
		$supdsql = "update contact
			set lastname='" . $_POST['lastname'] . "', " . 
			"firstname='" . $_POST['firstname'] . "', " .
			"email='" . $_POST['email'] . "', " .
			"phone='" . $_POST['phone'] . "' where contactid=" . $currcont;

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

	<div style="width: 600px; font: 9pt/9pt arial, tahoma; text-align: left; margin: 10px 0 0 60px;">

			<a href="tpmain.php?i=contact.php&custid=<?php echo $currcust; ?>" title="Cancel - Go Back">
					<img src="images/goback.png" width="50"></a>

<?php

	if($_GET['ac']=='a') {
		
		echo '<h4>Contact Maintenance - Add a Contact</h4>';
		
		?>		
	
				<form action="tpmain.php?i=contmaint.php&ac=a" method="POST">
					<table cellpadding="5">
					<tr><td width="100" class="tbllabels">Last Name: </td><td><input type="text" name="lastname" size="30" maxlength="150"></td></tr>
					<tr><td width="100" class="tbllabels">First Name: </td><td><input type="text" name="firstname" size="30" maxlength="30"></td></tr>
					<tr><td width="150" class="tbllabels">Email: </td><td><input type="text" name="email" size="60" maxlength="150"></td></tr>
					<tr><td width="60" class="tbllabels">Phone: </td><td><input type="text" name="phone" size="30" maxlength="20"></td></tr>
				</table>
				
						<!-- echo '<input type="hidden" name="ss" value="insert">';  -->
			
				<br><br>
				<input type="hidden" name="custid" value="<?php echo $currcust; ?>">
				<input type="submit" name="submitins" value="Save">
				</form>

		<?php
		}
		?>
		
	
	<?php
			
			if($_GET['ac']=='e') {

	?>		

			<h4>Cotact Maintenance - Edit Contact Details</h4>
				<form action="tpmain.php?i=contmaint.php&ac=e" method="POST">
				<table cellpadding="5">

		<?php	
			$editquery = "select * FROM contact c 
						where c.contactid=" . $currcont;
						//echo $editquery;
			$sql = mysql_query($editquery);
			while($row = mysql_fetch_array($sql)){ 	
					echo '<tr><td width="120" class="tbllabels">Last Name: </td><td><input type="text" name="lastname" size="60" maxlength="40" value="' . $row['lastname'] . '"></td></tr>';
					echo '<tr><td class="tbllabels">First Name: </td><td><input type="text" name="firstname" size="60" maxlength="40" value="' . $row['firstname'] . '"></td></tr>';
					echo '<tr><td class="tbllabels">Email: </td><td><input type="text" name="email" size="100" maxlength="150" value="' . $row['email'] . '"></td></tr>';
					echo '<tr><td class="tbllabels">Phone: </td><td><input type="text" name="phone" size="30" maxlength="20" value="' . $row['phone'] . '"></td></tr>';
				}
				echo '</table>';
				
					echo '<input type="hidden" name="contactid" value="' . $currcont . '">'; 
		?>	
				<br><br>
				<input type="submit" name="submitupd" value="Save">
				</form>

		<?php
		}
		?>



		

</div>
