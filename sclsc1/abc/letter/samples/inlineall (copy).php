	<?php
	session_start();
//error_reporting(0);
	
	if(isset($_GET['name']))
		$_SESSION['letter_type_name']=$_GET['name'];
	$_SESSION['appliId']=$_GET['appliId'];
	
	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Fetch.php';
	
	use classes\implementation\LetterType as impLetterType;
	use classes\Implementation\ClosingOfFile as impCof;
	
	$fetchLetter  = new impLetterType\Fetch();
	$fetchCof = new impCof\Fetch();
	
	$letterTypes = $fetchLetter->getLetterTypesByName($_SESSION['letter_type_name']);
	//$letterTypes     = $fetchCof->getGeneratedLetter($_SESSION['appliId']);
	
//print_r($letterTypes)	;
	
	
	$header_file_path=$_SESSION['base_url']."/letter/samples/header/header_".$_SESSION['letter_type_name'].".txt";
	$data = file_get_contents($header_file_path); //read the file
	$convert = explode("\n", $data); //create array separate by new line
	
	$body_file_path=$_SESSION['base_url']."/letter/samples/body/letter_body_".$_SESSION['letter_type_name'].".txt";
	$body = file_get_contents($body_file_path); //read the file
	$body_convert = explode("\n", $body); //create array separate by new line
	
	if(isset($_GET['action']) && $_GET['action']=='download')
	{
	/* header("Content-Type: application/vnd.ms-word"); 
	header("Expires: 0"); 
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	header("content-disposition: attachment;filename=letter.doc"); */
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment; Filename=".$_SESSION['letter_type_name'].".doc");
	}
	
	    
		
	
	
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml">';
echo '<head>';
//echo '<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\" />';
echo '<title></title>';
echo '</head>	<body>';	
		
	
	 for($i=0;$i<count($convert);$i++){
		echo '<div id="heading'.$i.';"   style="text-align:center;font-size:20px;padding:0px;line-height:1;align:top;">'.$convert[$i].'</div>';
	 }
	echo '<div id="title"   style="text-align:center;font-size:26px;padding:0px;">'. $letterTypes[0]['title_file_path'] .'</div>';
	echo '<br>	<div style="float:left;width:50%" >'.$letterTypes[0]['letter_no'].'</div><div style="text-align:right;">Date:- '. date('d-m-Y').'</div><div style="clear:both;"></div>';
	echo '<br>	<div id="nameAddress"  style="float:left;width:100%;line-height:1.5;padding-top:10px;">'.
	'Name				<br>'. 
	'Address line1			<br>'. 
	'Address line2			<br>'. 
	'Address line3			<br>'. 
	'</div>';
	
	echo '<br/>	<p id="subject">Subject: <b style="font-size:16px;padding-left:10px;">'.$letterTypes[0]['subject_file_path'].'</b></p>';
	echo '<br>	<p id="salutation" >Sir/Mam,</p>';
	echo '<br>';
	
	 for ($i=0;$i<count($body_convert);$i++){    
	
	echo '<div style="margin:0px;" >'. $body_convert[$i]	.'</div>';
	} 
	
	echo '<br><div style="float:left;width:20%;">Thanking You!</div><div style="float:right;width:20%">Yours Faithfully</div><div style="clear:both;"></div>';
	
	echo '<br><br><div style="float:left;width:20%;">&nbsp;</div><div id="taglist"  style="float:right;margin-top:0px;width:30%;text-align:right;">-----------------------</div><div style="clear:both;"></div>';
	echo '<br><br> <br>	Copy To :- <div id="taglist"  style="width:40%;"> inline, editing, floating, CKEditor </div>';
	echo '<a id="download" href="inlineall.php?action=download" class="links" onclick="hide()">Download</a>';
	echo '</body></html>';
	
	  
?>