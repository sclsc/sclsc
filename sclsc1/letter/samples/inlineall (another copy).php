	<?php
	session_start();
//error_reporting(0);
	
	if(isset($_GET['name']))
		$_SESSION['letter_type_name']=$_GET['name'];
	
	if(isset($_GET['appliId']))
	$_SESSION['appliId']=$_GET['appliId'];
	
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Fetch.php';
	
	use classes\Connection as Conn;
	use classes\implementation\LetterType as impLetterType;
	use classes\Implementation\ClosingOfFile as impCof;
	
	$fetchLetter  = new impLetterType\Fetch();
	$fetchCof = new impCof\Fetch();
	
	$letterTypes = $fetchLetter->getLetterTypesByName($_SESSION['letter_type_name']);
	$GeneratedLetter     = $fetchCof->getGeneratedLetter($_SESSION['appliId']);
	$a=0;
	if (isset($GeneratedLetter[$a]['id']))
	$_SESSION['lettersDispId']=$GeneratedLetter[$a]['id'];
	
	$allApplicants       = $fetchCof->getLetterAddresse($_SESSION['lettersDispId']);
	$noofApplicants      = count($allApplicants);
//print_r($allApplicants)	;

$fullAddressTo=$address_line1=$address_line2=$city=$state_name=$pincode=$applicant_contact_no=$applicant_mobile_no=$applicantTo ='';	
for($i=0;$i<count($allApplicants);$i++) {

	if ($allApplicants[$i]['is_to']==1)
	{
		if($i+1!=$noofApplicants)
		{
			$applicantTo .= $allApplicants[$i]['addressee_name']."&nbsp;,&nbsp";
		}
		else
		{
			$applicantTo .= $allApplicants[$i]['addressee_name'];
		}
		$address_line1=$allApplicants[0]['address1'].', ';
		$address_line2=$allApplicants[0]['address2'].', ';
		$city=$allApplicants[0]['city'].', ';
		$state=$allApplicants[0]['state'].', ';
		$pincode=', '.$allApplicants[0]['pincode'];
		$state=$allApplicants[0]['state'];
		
		$applicant_state=$state;
		$con = Conn\Connection::getConnection();
		$query = "SELECT state_name FROM tbl_states WHERE id = :state_id";
		$stmt = $con->prepare($query);
		$stmt->bindParam(':state_id', $applicant_state, PDO::PARAM_INT);
		$stmt->execute();
		while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
			$state_name = $row['state_name'];
		
		$fullAddressTo .=	$address_line1.$address_line2.$city.$state_name.$pincode.'<br>';
	}
	
}

$fullAddressCopyTo=$address_line1=$address_line2=$city=$state_name=$pincode=$applicant_contact_no=$applicant_mobile_no=$applicantCopyTo ='';
for($i=0;$i<count($allApplicants);$i++) {

	if ($allApplicants[$i]['is_to']==0)
	{
		if($i+1!=$noofApplicants)
		{
			$applicantCopyTo .= $allApplicants[$i]['addressee_name']."&nbsp;,&nbsp";
		}
		else
		{
			$applicantCopyTo .= $allApplicants[$i]['addressee_name'];
		}
		
		$address_line1=$allApplicants[0]['address1'].', ';
		$address_line2=$allApplicants[0]['address2'].', ';
		$city=$allApplicants[0]['city'].', ';
		$state=$allApplicants[0]['state'].', ';
		$pincode=', '.$allApplicants[0]['pincode'];
		$state=$allApplicants[0]['state'];
		
		$applicant_state=$state;
		$con = Conn\Connection::getConnection();
		$query = "SELECT state_name FROM tbl_states WHERE id = :state_id";
		$stmt = $con->prepare($query);
		$stmt->bindParam(':state_id', $applicant_state, PDO::PARAM_INT);
		$stmt->execute();
		while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
			$state_name = $row['state_name'];
		
$fullAddressCopyTo .= $address_line1.$address_line2.$city.$state_name.$pincode.'<br>';
	}

}

	$header_file_path=$_SESSION['base_url']."/letter/samples/header/header_".$_SESSION['letter_type_name'].".txt";
	$data = file_get_contents($header_file_path); //read the file
	$convert = explode("\n", $data); //create array separate by new line
	
	$body_file_path=$_SESSION['base_url']."/letter/samples/body/letter_body_".$_SESSION['letter_type_name'].".txt";
	$body = file_get_contents($body_file_path); //read the file
	$body_convert = explode("\n", $body); //create array separate by new line
	
	if(isset($_GET['action']) && $_GET['action']=='download')
	{
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment; Filename=".$_SESSION['letter_type_name'].".doc");
	}

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml">';
echo '<head>';
//echo '<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\" />';
echo '<title>'.$_SESSION['letter_type_name'].'</title>';
echo '</head>	<body>';	

	 for($i=0;$i<count($convert);$i++){
		echo '<p id="heading'.$i.';"   style="text-align:center;font-size:20px;padding:0px;line-height:1;align:top;">'.$convert[$i].'</p>';
	 }
	
	echo '<p id="title"   style="text-align:center;font-size:26px;padding:0px;">'. $letterTypes[0]['title_file_path'] .'</p>';
	echo '<p>Letter No. :- '.$letterTypes[0]['letter_no'].'</div><div style="text-align:right;">Date:- '. date('d-m-Y').'</div><div style="clear:both;"></p>';
	echo '<p>'.
	'To :- '.$applicantTo.'<br>'. 
	'Address :-  '.$fullAddressTo.'<br>'. 
	'</p>';
	
	echo '<p id="subject">Subject :- '.$letterTypes[0]['subject_file_path'].'</p>';
	echo '<br>	<p id="salutation" >Sir/Mam,</p>';
	echo '<br>';
	
   for ($i=0;$i<count($body_convert);$i++)
   {   
	echo '<div style="margin:0px;" >'. $body_convert[$i].'</div>';
   } 
		
	echo '<br><div style="float:left;width:20%;">Thanking You!</div><div style="float:right;width:20%">Yours Faithfully</div><div style="clear:both;"></div>';
	
	echo '<div style="float:left;width:20%;">&nbsp;</div><div id="taglist"  style="float:right;margin-top:0px;width:30%;text-align:right;">-----------------------</div><div style="clear:both;"></div>';
	echo '<br><p>'.
			'Copy To :- '.$applicantCopyTo.'<br>'.
			'Address :-  '.$fullAddressCopyTo.'<br>'.
			'</p>';
	
	echo '<a id="download" href="inlineall.php?action=download" class="links" onclick="hide()">Download</a>';
	echo '</body></html>';
  
?>