<?php

			session_start();

//echo 'code syntax is ok';
require_once('../cfg.inc');
require('../fpdf/fpdf.php');


$quoteid = $_GET['quoteid'];

dbconn();


class PDF extends FPDF {

	//Page header
	function Header() {
		//$currypos=$this->gety();
		}

	//Page footer
	function Footer(){
	    //Position at 1.5 cm from bottom
	    $this->SetY(-16);

	    //Page number
	    //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}


	$pdf=new PDF();
$pdf->AliasNbPages();

$sql = "select q.*, q.transtype as transname, c.name as custname,
		c.city as custcity, c.state as custstate, c.zip as custzip,
		concat(co.firstname, ' ' ,co.lastname) as conwholename, 
		d.fullname as tpadmin
 from quote q 
	 join customer c on c.custid=q.custid
	join contact co on co.contactid=q.contactid
	join creds d on d.username=q.tpadmin
	where q.quoteid=" . $quoteid;
$qryres = mysql_query($sql);
while ($row = mysql_fetch_array($qryres)) {
		$pdf->addpage();
		//$currypos=$pdf->gety();
		//$pdf->sety($currypos);
		$pdf->setleftmargin(10);
	    $pdf->SetFont('Arial','B',11);
		$pdf->Image('../images/tplogo_newtriag_bigblacktext_refl_600.png',10,8,80);
		$pdf->sety(30);
		$pdf->Cell(100,5,'133 Riverfront Dr., Copperhill, TN  37317', 0,1);
		$pdf->Cell(80,5,'Phone: 423-241-5136',0,1);
		$pdf->setleftmargin(100);
		$pdf->sety(30);
		$pdf->Cell(90,5,ucwords($row['custname']),0,1);
		$pdf->Cell(90,5,ucwords($row['custcity']) . ', ' . strtoupper($row['custstate']) . '  ' . $row['custzip'],0,1);
		$pdf->cell(90,5,'Contact: ' . ucwords($row['conwholename']),0,1);
		
		$pdf->Ln(5);


		$pdf->setleftmargin(10);
		$pdf->Ln(3);
		$pdf->setfont('Arial', 'B', 10);
		$pdf->cell(80,4,'Quote ' .  $row['quotenum'] . ' Prepared by ' . ucwords($row['tpadmin']) ,0,1);
		$pdf->Ln(4);
		$pdf->cell(100,4,$row['qty'] . ' ' . $row['condition'] . ' ' . $row['phase'] . 
						' ' . $row['transname'] . ' Transformer Quote',0,1);
		$pdf->Ln(4);
		$tblx=$pdf->gety();
		$pdf->setfont('Arial','',10);
		$pdf->cell(50,5,$row['kva'] . ' Kva', 0,1);
		$pdf->cell(50,5,$row['privolt'] . ' Primary Voltage', 0,1);
		if (strlen($row['taps'])>0){
			$pdf->cell(50,5,'Taps: ' . $row['taps'], 0,1);
		}
		$pdf->cell(50,5,$row['secvolt'] . ' Secondary Voltage', 0,1);
		if ($row['hz']!='N/A' ) {
			$pdf->cell(50,5,$row['hz'] . ' Hz', 0,1);
		}
		
		if ($row['connections']!='N/A' ) {
			$pdf->cell(50,5,$row['connections'] . ' Connections', 0,1);
		}
		if ($row['oiltype']!='N/A'){
			$pdf->cell(50,5,$row['oiltype'] . ' Oil' , 0,1);
		}
		if ($row['windings']!='N/A'){
		$pdf->cell(50,5,$row['windings'] . ' Windings', 0,1);
	}
		if ($row['enclosure']!='N/A'){
					$pdf->cell(50,5,$row['enclosure'] . ' Enclosure', 0,1);
				}
				if ($row['degrise']!='N/A'){
					$pdf->cell(50,5,$row['degrise'] . ' Degree Rise', 0,1);
				}
		if (strlen($row['addtlspec'])>0){
			$pdf->cell(20,5,'Additional Notes: ',0);
			$pdf->setleftmargin(40);
			$pdf->multicell(100,5, $row['addtlspec'], 0);
			$pdf->setleftmargin(10);
		}
		//$pdf->sety($tblx);
		//$pdf->Ln(1);
		//$pdf->setleftmargin(60);
		//$pdf->cell(100,5, $row['privolt'], 0,1);
		//$pdf->cell(100,5,$row['secvolt'], 0,1);
		//$pdf->cell(100,5,$row['connections'], 0,1);
		//$pdf->cell(100,5,$row['oiltype'], 0,1);
		//$pdf->cell(100,5,$row['windings'], 0,1);
		//$pdf->cell(100,5,$row['enclosure'], 0,1);
		//$pdf->cell(100,5,$row['degrise'], 0,1);
		//$pdf->multicell(100,5,$row['addtlspecs'], 0);
		$pdf->SetLeftMargin(10);
		$pdf->Ln(5);
		$curry=$pdf->gety();
		$pdf->cell(50,5,'Warranty',0,1);
		$pdf->cell(50,5,'Freight Terms',0,1);
		$pdf->cell(50,5,'Pay Terms',0,1);
		$pdf->cell(50,5,'Leadtime to Ship',0,1);
		$pdf->cell(50,5,'Price per Unit',0,1);
		$pdf->Ln(5);
		$pdf->setleftmargin(60);
		$pdf->sety($curry);
		$pdf->cell(50,5,$row['warranty'],0,1);
		$pdf->cell(50,5,$row['freightterms'],0,1);
		$pdf->cell(50,5,$row['paymentterms'],0,1);
		$pdf->cell(50,5,$row['leadtime'],0,1);
		$pdf->cell(50,5,$row['priceperunit'],0,1);
		$pdf->setfont('Arial','B',8);
		if (strlen($row['discdetails'])>0){
			$pdf->cell(50,5,$row['discdetails'],0,1);
		}
				
		
		
		
		$pdf->Ln(20);
	    $pdf->SetFont('Arial','BI',10);
	    $pdf->setleftmargin(10);
	    $pdf->Ln(1);
		$pdf->cell(190,5,'Huge stock, great service, fast quotes and expedited delivery!',0,1,'C');
		$pdf->cell(190,5,'www.transformerpro.com',0,1,'C');
		$pdf->cell(190,5,'Sell Us Your Transformer! 423-241-5136  24/7 Customer Service', 0,1,'C');
	}


$pdf->Output();




?>
