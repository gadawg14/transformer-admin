<?php
	
	//require_once 'cfg.inc';
	if ($_POST['submitins']) {
		
		$sinssql = "insert into quote
			(quotenum, custid,contactid,`condition`,qty, transtype, kva, phase, privolt, secvolt, oiltype, windings, connections, enclosure, degrise,
					date, tpadmin, leadtime, freightterms, warranty, paymentterms, priceperunit, addtlspec, note, discdetails, hz, taps)
			values
			('" . $_POST['qnum'] . "', " . $_POST['custid'] . ", " . $_POST['contactid'] . ", '" .
			$_POST['condition'] . "', '" . $_POST['qty'] . "', '" . $_POST['transtype'] . "', '" .  $_POST['kva'] . "','" .
			$_POST['phase'] . "','" .	$_POST['privolt'] . "','" . 	$_POST['secvolt'] . "','" . $_POST['oiltype'] . "','" .
			$_POST['windings'] . "','" . 	$_POST['connections'] . "','" . $_POST['enclosure'] . "','" .	$_POST['degrise'] . "','" .
			$_POST['date'] . "','" . $_POST['tpadmin'] . "','" . 	$_POST['leadtime'] . "','" . $_POST['freightterms'] . "','" .
			$_POST['warranty'] . "','" . $_POST['payterms'] . "','" . $_POST['ppu'] . "','" . $_POST['addtlspec'] . "','" .
			$_POST['intnote'] . "','" . $_POST['discdetails'] . "','" . $_POST['hz'] . "','" . $_POST['taps'] .
			 	"')";
			
			$sqlres = mysql_query($sinssql); 
			if ($sqlres) {
				$dbmsg = '<table><tr><td width="100"><img src="images/success-icon.png" width="50"></td>
												<td valgn="top"><b><i>Record Added</i></b></td><td> &nbsp; &nbsp - <a href="tpmain.php?i=quote.php&custid=' . 
						$_REQUEST['custid'] . '&contactid=' . $_REQUEST['contactid'] . '">Go to Quote List to preview / edit</a></td></tr></table>';
				$justadd = true;
			} else {
				$dbmsg = 'record not added - contact your friendly programmer' . mysql_error() . '<br>' . $sinssql;
			}
			
			//echo $dbmsg;
		
	}

	if ($_POST['submitupd']) {
		
		$supdsql = "update quote
			set `condition`='" . $_POST['condition'] . "', " . 
			"transtype='" . $_POST['transtype'] . "', " .
			"qty=" . $_POST['qty'] . ", " .
			"leadtime='" . $_POST['leadtime'] . "', " .
			"freightterms='" . $_POST['freightterms'] . "', " .
			"warranty='" . $_POST['warranty'] . "', " .
			"paymentterms='" . $_POST['payterms'] . "', " .
			"priceperunit='" . $_POST['ppu'] . "', " .
			"note='" . $_POST['intnote'] . "', " .
			"addtlspec='" . $_POST['addtlspec'] . "', " .
			"discdetails='" . $_POST['discdetails'] . "', " .
			"kva='" . $_POST['kva'] . "', " .
			"phase='" . $_POST['phase'] . "', " .
			"privolt='" . $_POST['privolt'] . "', " .
			"secvolt='" . $_POST['secvolt'] . "', " .
			"oiltype='" . $_POST['oiltype'] . "', " .
			"windings='" . $_POST['windings'] . "', " .
			"connections='" . $_POST['connections'] . "', " .
			"enclosure='" . $_POST['enclosure'] . "', " .
			"degrise='" . $_POST['degrise'] . "', " .
			"date='" . $_POST['date'] . "', " .
			"hz='" . $_POST['hz'] . "', " .
			"taps='" . $_POST['taps'] . "', " .
			"tpadmin='" . $_POST['tpadmin'] . "'" .
			" where quoteid=" . $_POST['quoteid'];

			$sqlres = mysql_query($supdsql); 
			if ($sqlres) {
				$dbmsg = '<b><i>Record Updated</i></b>';
				$justadd = true;
			} else {
				$dbmsg = 'record not updated - contact your friendly programmer' . mysql_error() . '<br>' . $supdsql;
			}
			echo $dbmsg;
	}
	

	if ($_REQUEST['custid'] && $_REQUEST['contactid'] && $_REQUEST['ac']=='a'){
				$currcont = $_REQUEST['contactid'];
				$currcust = $_REQUEST['custid'];
			
				//echo $currcont;
				//echo $currcust;
				$getheadersql = "select c.name as custname, concat(con.firstname, ' ', con.lastname) as contname, con.email
												from customer c 
												join contact con on con.custid=c.custid
												where c.custid=" . $currcust . 
												" and con.contactid=" . $currcont;
				$custname=mysql_result(mysql_query($getheadersql),0,0);
				$contname=mysql_result(mysql_query($getheadersql),0,1);
				$contemail=mysql_result(mysql_query($getheadersql),0,2);
				
				$newqnumsql="select count(*) from quote";
				$qnum = mysql_result(mysql_query($newqnumsql),0,0) + 3700 . strtoupper(substr($_SESSION['username'],-1));
				
 	}
 
 	if ($_GET['ac']=='e'){
 			
 			$currquote = $_REQUEST['quoteid'];
 			$getheadersql="select cust.name, q.contactid
 										from customer cust
 										join quote q on q.custid=cust.custid
 										where q.quoteid=" . $currquote;
 			//echo $getheadersql;
			$custname=mysql_result(mysql_query($getheadersql),0,0);
			$contid=mysql_result(mysql_query($getheadersql),0,1);
 		
 	}
 
 


?>

	<div style="width: 800px; font: 9pt/9pt arial, tahoma; text-align: left; margin: 10px 0 0 60px;">

			
			<?php
			
			if ($_POST['submitins']) {
				echo $dbmsg;
			} else {
				echo '<a href="tpmain.php?i=quote.php" title="Cancel - Go Back">
					<img src="images/goback.png" width="50"></a>';
				}
	
	
	if($_GET['ac']=='a') {
		
		echo '<h4>Quote Maintenance - Add a Quote</h4>';
		echo '<div style="margin: 0 0 0 20px;">';
		echo '<h3>' . $custname . '</h3>';
		echo '<h3>' . $contname . ' - ' . $contemail . '</h3>';
		echo '</div>';
		
		?>		
	
				<form action="tpmain.php?i=quotmaint.php&ac=a" method="POST">
					<table cellpadding="5">
						
					<tr><td width="200" class="tbllabels">Quote Number: </td><td><input type="text" name="qnum" size="20" maxlength="20" 
							value="<?php echo $qnum; ?>" readonly="readonly"></td></tr>
					<tr><td width="200" class="tbllabels">Quote Date: </td><td><input type="text" name="date" size="20" maxlength="10" value="<?php echo date('Y-m-d'); ?>"></td></tr>
					<!-- <tr><td width="200" class="tbllabels">TP Admin: </td><td><select name="tpadmin">
												<option value="LJ">Lindsay Jackson</option>
												<option value="LB">Lynn Brackett</option>
												<option value="CA">Casey Allen</option>
						-->
					<tr><td width="200" class="tbllabels">TP Admin: </td><td><input type="text" name="tpadmin" size="20" maxlength="10" 
								value="<?php echo strtoupper($_SESSION['username']); ?>" readonly="readonly"></td></tr>

	
					<tr><td width="200" class="tbllabels">Transformer Type: </td><td><select name="transtype">
												<option value="Pole Mount">Pole Mount</option>
												<option value="Pad Mount">Pad Mount</option>
												<option value="Dry Type">Dry Type</option>
												<option value="Substation">Substation</option>
								
											</select></td></tr>
					<tr><td width="200" class="tbllabels">Quantity: </td><td><input type="text" name="qty" size="20" maxlength="2" value="1"></td></tr>
					<tr><td class="tbllabels">Condition: </td><td><select name="condition">
												<option value="New">New</option>
												<option value="Refurbished">Refurbished</option>
												<option value="Used">Used</option>
												<option value="Unused">Unused</option>
												<option value="EOK">EOK</option>
											</select></td></tr>
					<tr><td class="tbllabels">Kva: </td><td><input type="text" name="kva" size="50" maxlength="50"></td></tr>
					<tr><td class="tbllabels">Phase: </td><td><select name="phase">
												<option value="Single">Single Phase</option>
												<option value="3 Phase">3 Phase</option>
											</select></td></tr>
					<tr><td class="tbllabels">Primary Voltage: </td><td><input type="text" name="privolt" size="50" maxlength="50"></td></tr>
					<tr><td class="tbllabels">Taps: </td><td><input type="text" name="taps" size="50" maxlength="50"></td></tr>
					<tr><td class="tbllabels">Secondary Voltage: </td><td><input type="text" name="secvolt" size="50" maxlength="50"></td></tr>
					<tr><td class="tbllabels">Oil Type: </td><td><select name="oiltype">
												<option value="N/A">N/A</option>
												<option value="Mineral">Mineral</option>
												<option value="FR3">FR3</option>
												<option value="Silicone">Silicone</option>
											</select></td></tr>
					<tr><td class="tbllabels">Windings: </td><td><select name="windings">
												<option value="N/A">N/A</option>
												<option value="All Aluminum">All Aluminum</option>
												<option value="All Copper">All Copper</option>
												<option value="Aluminum HV / Copper LV">Aluminum HV / Copper LV</option>
												<option value="Copper HV / Aluminum LV">Copper HV / Aluminum LV</option>
											</select></td></tr>
					<tr><td class="tbllabels">Connections: </td><td><select name="connections">
												<option value="N/A" selected="selected">N/A</option>
												<option value="Dead Front / Loop Feed">Dead Front / Loop Feed</option>
												<option value="Dead Front / Radial Feed">Dead Front / Radial Feed</option>
												<option value="Live Front / Loop Feed">Live Front / Loop Feed</option>
												<option value="Live Front / Radial Feed">Live Front / Radial Feed</option>
											</select></td></tr>
					<tr><td class="tbllabels">Enclosure: </td><td><select name="enclosure">
												<option value="N/A">N/A</option>
												<option value="Indoor">Indoor</option>
												<option value="Outdoor">Outdoor</option>
											</select></td></tr>
					<tr><td class="tbllabels">Degree Rise: </td><td><select name="degrise">
												<option value="N/A">N/A</option>
												<option value="55">55</option>
												<option value="65">65</option>
												<option value="55/65">55/65</option>
												<option value="80">80</option>
												<option value="115">115</option>
												<option value="150">150</option>
											</select></td></tr>
					<tr><td class="tbllabels">Hz: </td><td><select name="hz">
												<option value="60">60</option>
												<option value="50">50</option>
											</select></td></tr>
					<tr><td class="tbllabels">Warranty: </td><td><select name="warranty">
												<option value="1 Year">1 Year</option>
												<option value="2 Year">2 Year</option>
												<option value="As Is">As Is</option>
											</select></td></tr>
					<tr><td class="tbllabels">Payment Terms: </td><td><select name="payterms">
												<option value="Net 30">Net 30</option>
												<option value="Net 60">Net 60</option>
												<option value="Pay with Order">Pay with Order</option>
												<option value="Payment Prior to Shipment">Payment Prior to Shipment</option>
												<option value="To Be Determined">To Be Determined</option>
											</select></td></tr>
					<tr><td class="tbllabels">Freight Terms: </td><td><select name="freightterms">
												<option value="Freight Included">Freight Included</option>
												<option value="Freight Is Additional">Freight Is Additional</option>
												<option value="Customer Arranges Freight">Customer Arranges Freight</option>
											</select></td></tr>

					<tr><td class="tbllabels">Lead Time: </td><td><input type="text" name="leadtime" size="80" maxlength="150"></td></tr>
					<tr><td class="tbllabels">Price Per Unit: </td><td><input type="text" name="ppu" size="50" maxlength="10"></td></tr>
					<tr><td valign="top" class="tbllabels">Internal Note: </td><td><textarea cols="50" rows="3" name="intnote"></textarea></td></tr>
					<tr><td valign="top" class="tbllabels">Additional Notes: </td><td><textarea cols="50" rows="3" name="addtlspec"></textarea></td></tr>
					<tr><td valign="top" class="tbllabels">Discount Details: </td><td><textarea cols="50" rows="3" name="discdetails"></textarea></td></tr>


				</table>
				
						<!-- echo '<input type="hidden" name="ss" value="insert">';  -->
			
				<br><br>
				<input type="hidden" name="custid" value="<?php echo $currcust; ?>">
				<input type="hidden" name="contactid" value="<?php echo $currcont; ?>">
				<input type="submit" name="submitins" value="Save">
				</form>

	<?php
				}
			
			if($_GET['ac']=='e') {

	?>		

			<h4>Quote Maintenance - Edit Quote Details</h4>
				<form action="tpmain.php?i=quotmaint.php&ac=e" method="POST">
				<table cellpadding="5">

		<?php	
			$editquery = "select * FROM quote q 
						where q.quoteid=" . $currquote;
						//echo $editquery;
			$sql = mysql_query($editquery);
			while($row = mysql_fetch_array($sql)){ 	


					echo '<tr><td width="200" class="tbllabels">Quote Number: </td><td><input type="text" name="qnum" size="20" maxlength="20" value="' . $row['quotenum'] . '" readonly="readonly"></td></tr>';
					echo '<tr><td width="200" class="tbllabels">Quote Date: </td><td><input type="text" name="date" size="20" maxlength="10" value="' . $row['date'] . '"></td></tr>';
					
					/*
					echo '<tr><td width="200" class="tbllabels">TP Admin: </td><td><select name="tpadmin">';
						$tpaarr=array('LJ', 'LB', 'CA');
						foreach($tpaarr as $tpa){
							$selected='';
								if($tpa==$row['tpaadmin']){ 
									$selected = 'selected="selected"';
									}
								echo '<option value="' . $tpa . '" ' . $selected . '>' . $tpa . '</option>';
						}
						
					echo '</select></td></tr>';
					*/
					echo '<tr><td width="200" class="tbllabels">TP Admin: </td><td><input type="text" name="tpadmin" size="20" maxlength="20" value="' . strtoupper($row['tpadmin']) . '" readonly="readonly"></td></tr>';
					
					echo '<tr><td width="200" class="tbllabels">Transformer Type: </td><td><select name="transtype">';
						$ttarr=array('Pole Mount', 'Pad Mount', 'Dry Type', 'Substation');
						foreach($ttarr as $tt){
							$selected='';
								if($tt==$row['transtype']){ 
									$selected = 'selected="selected"';
									}
								echo '<option value="' . $tt . '" ' . $selected . '>' . $tt . '</option>';
						}
						
					echo '</select></td></tr>';

					echo '<tr><td width="200" class="tbllabels">Quantity: </td><td><input type="text" name="qty" size="20" maxlength="2" value="' . $row['qty'] . '"></td></tr>';
					
					echo '<tr><td class="tbllabels">Condition: </td><td><select name="condition">';
						$condarr=array('New', 'Refurbished', 'Used', 'Unused', 'EOK');
						foreach($condarr as $cond){
							$selected='';
								if($cond==$row['condition']){ $selected = 'selected="selected"'; }
								echo '<option value="' . $cond . '" ' . $selected . '>' . $cond . '</option>';
								}
						echo '</select></td></tr>';

					echo '<tr><td class="tbllabels">Kva: </td><td><input type="text" name="kva" size="50" maxlength="50" value="' . $row['kva'] . '"></td></tr>';

					echo '<tr><td class="tbllabels">Phase: </td><td><select name="phase">';
						$pharr=array('Single Phase', '3 Phase');
						foreach($pharr as $ph){
							$selected='';
								if($ph==$row['phase']){ $selected = 'selected=selected'; }
								echo '<option value="' . $ph . '" ' . $selected . '>' . $ph . '</option>';
								}
						echo '</select></td></tr>';


					echo '<tr><td class="tbllabels">Primary Voltage: </td><td><input type="text" name="privolt" size="50" maxlength="50" value="' . $row['privolt'] . '"></td></tr>';
					echo '<tr><td class="tbllabels">Taps: </td><td><input type="text" name="taps" size="50" maxlength="50" value="' . $row['taps'] . '"></td></tr>';
					echo '<tr><td class="tbllabels">Secondary Voltage: </td><td><input type="text" name="secvolt" size="50" maxlength="50" value="' . $row['secvolt'] . '"></td></tr>';

					echo '<tr><td class="tbllabels">Oil Type: </td><td><select name="oiltype">';
						$otarr=array('N/A','Mineral', 'FR3', 'Silicone');
						foreach($otarr as $ot){
							$selected='';
								if($ot==$row['oiltype']){ $selected = 'selected=selected'; }
								echo '<option value="' . $ot . '" ' . $selected . '>' . $ot . '</option>';
								}
						echo '</select></td></tr>';

					echo '<tr><td class="tbllabels">Windings: </td><td><select name="windings">';
						$windarr=array('N/A','All Aluminum', 'All Copper', 'Aluminum HV / Copper LV');
						foreach($windarr as $wind){
							$selected='';
								if($wind==$row['windings']){ $selected = 'selected=selected'; }
								echo '<option value="' . $wind . '" ' . $selected . '>' . $wind . '</option>';
								}
						echo '</select></td></tr>';


					echo '<tr><td class="tbllabels">Connections: </td><td><select name="connections">';
						$connarr=array('N/A','Dead Front / Loop Feed', 'Dead Front / Radial Feed', 'Live Front / Loop Feed', 'Live Front / Radial Feed');
						foreach($connarr as $conn){
							$selected='';
								if($conn==$row['connections']){ $selected = 'selected="selected"'; }
									echo '<option value="' . $conn . '" ' . $selected . '>' . $conn . '</option>';
								}
						echo '</select></td></tr>';


					echo '<tr><td class="tbllabels">Enclosure: </td><td><select name="enclosure">';
						$encarr=array('N/A','Indoor', 'Outdoor');
						foreach($encarr as $enc){
							$selected='';
								if($enc==$row['enclosure']){ $selected = 'selected=selected'; }
								echo '<option value="' . $enc . '" ' . $selected . '>' . $enc . '</option>';
								}
						echo '</select></td></tr>';

					echo '<tr><td class="tbllabels">Degree Rise: </td><td><select name="degrise">';
						$degarr=array('N/A','55', '65', '55/65','80','115','150');
						foreach($degarr as $deg){
							$selected='';
								if($deg==$row['degrise']){ $selected = 'selected="selected"'; }
								echo '<option value="' . $deg . '" ' . $selected . '>' . $deg . '</option>';
								}
						echo '</select></td></tr>';

					echo '<tr><td class="tbllabels">Hz: </td><td><select name="hz">';
						$hzarr=array('60','50');
						foreach($hzarr as $hz){
							$selected='';
								if($hz==$row['hz']){ $selected = 'selected=selected'; }
									echo '<option value="' . $hz . '" ' . $selected . '>' . $hz . '</option>';
								}
						echo '</select></td></tr>';


					echo '<tr><td class="tbllabels">Warranty: </td><td><select name="warranty">';
						$warrarr=array('1 Year', '2 Year','As Is');
						foreach($warrarr as $warr){
							$selected='';
								if($warr==$row['warranty']){ $selected = 'selected=selected'; }
									echo '<option value="' . $warr . '" ' . $selected . '>' . $warr . '</option>';
								}
						echo '</select></td></tr>';


					echo '<tr><td class="tbllabels">Payment Terms: </td><td><select name="payterms">';
						$payarr=array('Net 30', 'Net 60', 'Pay with Order', 'Payment Prior to Shipment', 'To Be Determined');
						foreach($payarr as $pay){
							$selected='';
								if($pay==$row['paymentterms']){ $selected = 'selected=selected'; }
									echo '<option value="' . $pay . '" ' . $selected . '>' . $pay . '</option>';
								}
						echo '</select></td></tr>';
					
					echo '<tr><td class="tbllabels">Freight Terms: </td><td><select name="freightterms">';
						$frarr=array('Freight Included', 'Freight Is Additional', 'Customer Arranges Freight');
						foreach($frarr as $fr){
							$selected='';
								if($fr==$row['freightterms']){ $selected = 'selected=selected'; }
									echo '<option value="' . $fr . '" ' . $selected . '>' . $fr . '</option>';
								}
						echo '</select></td></tr>';



					echo '<tr><td class="tbllabels">Lead Time: </td><td><input type="text" name="leadtime" size="80" maxlength="150" value="'. $row['leadtime'] . '"></td></tr>';
					echo '<tr><td class="tbllabels">Price Per Unit: </td><td><input type="text" name="ppu" size="50" maxlength="10" value="' . $row['priceperunit'] . '"></td></tr>';
					echo '<tr><td valign="top" class="tbllabels">Internal Note: </td><td><textarea cols="50" rows="3" name="intnote">' .  $row['note'] . '</textarea></td></tr>';
					echo '<tr><td valign="top" class="tbllabels">Additional Notes: </td><td><textarea cols="50" rows="3" name="addtlspec">' . $row['addtlspec'] . '</textarea></td></tr>';
					echo '<tr><td valign="top" class="tbllabels">Discount Details: </td><td><textarea cols="50" rows="3" name="discdetails">' .  $row['discdetails'] . '</textarea></td></tr>';
				}
				echo '</table>';
				
					echo '<input type="hidden" name="quoteid" value="' . $currquote . '">'; 
		?>	
				<br><br>
				<input type="submit" name="submitupd" value="Save">
				</form>

		<?php
		}
		?>



		

</div>
