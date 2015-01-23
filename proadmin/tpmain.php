<?php

			session_start();

			if ($_POST['uid']) {
				$_SESSION['username'] = $_POST['uid'];
				$_SESSION['password'] = $_POST['pwd'];
			}
			
include '../cfg.inc';
dbconn();

//chkcreds();

	$page = $_GET['p'];
		//$menuitems[]=array(1, "/index.php", "Home");
		$menuitems[]=array(1, "customer.php", "Companies"); 
		//$menuitems[]=array(2, "contact.php", "Contacts"); 
		$menuitems[]=array(2, "quote.php", "Quotes"); 
		$menuitems[]=array(3, "logout.php", "Logout"); 
		//$menuitems[]=array(5, "ad_createalbum.php", "Photo Gallery"); 
		//$menuitems[]=array(6, "ad_addimage.php", "Add Gallery Image"); 
						
	
	
?>


<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="adminstyle.css" rel="stylesheet" type="text/css">

</head>
<body style="text-align: center;">
	
<?php
		if (!chkcreds()) {
			echo '<br>login failed, please try again<br><a href="http://www.transformerpro.com/proadmin/login.html">Return to login page</a>';
	} else {
	
	?>
	
<div style="width: 900px; margin: 0px auto; padding-bottom: 20px;">
		<div style="width: 900px; text-align: left; border-bottom: 1px solid black;">
				<a href="http://www.transformerpro.com"><img src="../images/tplogo_newtriag_bigblacktext_refl_600.png" border="0"></a>
		</div>
		<div style="float: right; margin: 10px 0 0 0; width: 100%; font: bold 9pt/9pt arial, tahoma;">
			
											<?php
										
										foreach ($menuitems as $menuitem) {
											if ($menuitem['0'] == $page) {
												$curr = 'currmenuitem';
											} else {
												$curr = '';
											}
								
											echo '<div class="menuitem ' . $curr . '"><a href="tpmain.php?p=' . 
												$menuitem['0'] . '">' . $menuitem['2'] . '</a> </div>';
										}
									?>
			
			
			
											</div>

		<div style="float: left; width: 100%; margin-top: 30px; margin-left: 10px; text-align: left;
				font: 9pt/9pt arial, tahoma;">			
<?php		
									if ($_GET['i']) {
										include $_GET['i'];
									} elseif (! $page) {
										include 'customer.php';
									} else { 
										include $menuitems[$page-1][1];
									}
		
?>

	</div>
	
	<?

	}
?>

<div style="margin: 0 0 100px; 0;">
	&nbsp;
</div>

</div>
</div>

</body>
</html>