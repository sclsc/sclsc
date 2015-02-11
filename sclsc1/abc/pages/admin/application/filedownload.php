<?php 
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
$msg = '';
$errmsg = '';
	
   //  require_once $_SESSION['base_url'].'/pages/admin/application/PHPExcel_1.7.9_odt';
	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Misc/Fetch.php';	
//	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Edit.php';
//	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Delete.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
	   
	use classes\implementation\LetterType as impLetterType;
	use classes\implementation\Misc as impMisc;
	use classes\Pagination as impPage;

	$addLetter    = new impLetterType\Add();
	$fetchStages  = new impMisc\Fetch();
	$fetchLetter  = new impLetterType\Fetch();
	//	$deleteLetter = new impLetterType\Delete();
//	$editLetter   = new impLetterType\Edit();
	$fetchPage = new impPage\Pagination();

if(isset($_POST['submitLetterType']))
	 {	
	 	
	 	
	 	
	    /*Name of the document file*/
		//$document = 'sample.odt';
		 
		/**Function to extract text*/
		/*function extracttext($filename) {
			
		    //Check for extension
		    $ext = end(explode('.', $filename));
		 
		    //if its docx file
		    if($ext == 'docx')
		    $dataFile = "word/document.xml";
		    //else it must be odt file
		    else
		    $dataFile = "content.xml";    
		       
		    //Create a new ZIP archive object
		    $zip = new ZipArchive;
		 
    // Open the archive file
    if (true === $zip->open($filename)) {
        // If successful, search for the data file in the archive
        if (($index = $zip->locateName($dataFile)) !== false) {
            // Index found! Now read it to a string
            $text = $zip->getFromIndex($index);
            // Load XML from a string
            // Ignore errors and warnings
            $xml = DOMDocument::loadXML($text, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            // Remove XML formatting tags and return the text
            return strip_tags($xml->saveXML());
        }
        //Close the archive file
        $zip->close();
    }
 
    // In case of failure return a message
    return "File not found";
}*/
	 	
					
	 	

	 	$inputFile = $_SESSION['base_url'] . "/pages/admin/application/sample.odt";
	 	$outputFile = "letter.odt";
	 	$fi = fopen($inputFile, 'r');
	 	//echo $fi;
	 	$source = '';
	 	while (!feof($fi)) {
	 		//echo 
	 		//echo fgetc($fi);
	 		$source .= fgetc($fi);
	 		//echo $source;die;
	 		$source = str_replace('#firstname','jyoti', $source);
	 		$source = str_replace('#subject','gupta', $source);
	 		$source = str_replace('#address','Delhi', $source);
	 		
	 	}
	 	//echo $source;die;
	 	fclose($fi);
	 	//fwrite($outputFile, $source);
	 	file_put_contents($outputFile,$source);
	 	
				/*	$handle = fopen('sample.odt','rb');
					$content = 'sample.odt';
					
					while (!feof($handle))
					{
						$content .= fread($handle, 1);
					}
					fclose($handle);
					
					$handle = fopen('sample.odt','wb');
					$content = str_replace('#firstname','jyoti', $content);
					$content = str_replace('#lastname','gupta', $content);
					
					fwrite($handle, $content);
					fclose($handle);

 */






/*
			$text= extracttext($document);
			//echo $text;
			$file = fopen('file.odt', 'w+');
			fwrite($file, $text);
		     readfile('file.odt');
			fclose();

			 header('Content-disposition: attachment; filename="letter.odt"');
			 header('Content-Type: application/vnd.oasis.opendocument.text');
 
			// this is slightly magic
			File_Archive::extract(
	        File_Archive::readMulti(    // read sources
			   array(
            // a) an existing archive
            File_Archive::read("template.zip/"),
            // b) our memory buffers to be named
            File_Archive::readMemory($content_xml, "content.xml"),
        )
    ),
    File_Archive::toArchive(  // combine sources into one output
        'letter.odt',
        File_Archive::toOutput(false),  // send to stdout = browser
        $type = 'zip'
    )
);
	*/
	}
	
	
	$stages = $fetchStages->getAllStages();
	$letterTypes = $fetchLetter->getAllLetterTypes();
//print_r($LetterTypes);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<script src="../../../js/jquery.min.js"></script>
		<script src="../../../js/masking/jquery-1.js"></script>
		<script src="../../../js/masking/jquery.js"></script>
		<script src="../../../js/dispatchValidation.js"></script>

		</head>
	<body >
	<?php require_once $_SESSION['base_url'].'/include/header.php';?>
	    <div class="wrapper" >
			<div id="left-wrapper">	
				<?php include_once 'include/side-menu.php';?>
			</div>
			<div id="right-wrapper">
				<div id="breadcrumb">
	     			<ul>
	     				<li><a href="index.php">Home /</a></li>
	     				<li><a href="#">Letter Type</a></li>
	     			</ul>
	     		</div>
	     		<div class="clear"></div>
	     		
	     		<div class="clear"></div>
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">File Type</div>
     				<div class="right-title" >&nbsp;</div>
	     		</div>
	           <div style="height:auto;border:1px solid #4b8df8;">
	            <!--<form action="<?php //echo "../../../pages/admin/application/viewfile.php";?>" name="letter_type" id="letter_type" method="post" onsubmit="return validateLetterType()">-->
	            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="letter_type" id="letter_type" method="post" onsubmit="return validateLetterType()">
							<h3>File Details</h3>
	     					<div style="width:80%;margin-left:1%">
								<div class="clear"></div>
									<div class="clear"></div>
										<div class="left" style="width:15%;">First Name <span class="red">*</span></div>
										<div class="right" style="width:80%;">
										<input type="text"  placeholder="firstname" name="firstname" id="name" maxlength="100" value="ABCD" />											
										</div>
										
										<div class="clear"></div>
										<div class="left" style="width:15%;">Last Name </div>
										<div class="right" style="width:80%;">
										<input type="text"  placeholder="lastname" name="lastname" id="letter_no" maxlength="100" value="Def"/>											
										</div>
										
										<div class="clear"></div>
										<div class="left" style="width:15%;">Address </div>
										<div class="right" style="width:80%;">
										<input type="text"  placeholder="address" name="address" id="title" maxlength="100" value="dsdjskdjs"/>											
										</div>
										
										<div class="clear"></div>
										<div class="left" style="width:15%;">Subject <span class="red" >*</span></div>
										<div class="right" style="width:80%;">
										<input type="text"  placeholder="subject" name="subject" value="cslcksl" />											
										</div>
										
										<div class="clear"></div>							
								       <div id="received">
									   <input type="hidden" name="sub_stages" id="sub_stages" value='' />
								       </div> 
							       
							 </div>
																	
					
			     			<div class="clear"></div>
			     			<div class="clear"></div>
							
				     			<div style="text-align:center;padding:10px 0;">	
				     					<input type="hidden" id="application_id" name="application_id" 
				     					value="<?php echo $_POST['application_id'];?>"/>	
				     					<input type="hidden" id="slpAction" name="slpAction" 
				     					value="<?php echo $_POST['slpAction'];?>"/>					
									<input class="form-button" type="submit" name="submitLetterType" value="Submit"/>
									
								</div>
								</form>
							</div>
						
						</div>
					</div>
				
				
	     		<script type="text/javascript">
					jQuery(function($){
						$("#mobile_number").mask("999-999-9999", {placeholder: 'XXX/XXX/XXXX'});
                        $("#pincode").mask("999999", {placeholder: 'XXXXXX'});
                        $("#closing_date").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
					});
					$(document).ready(function() {
					    $('form:first *:input[type!=hidden]:first').focus();
					});
				</script>
	    
	 
		<script type="text/javascript" src="../../js/masking/ga.js"></script>
		 
	</body>
</html>
