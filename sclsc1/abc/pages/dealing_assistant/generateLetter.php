<?php 
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
$msg = '';
$errmsg = '';
	
		require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Fetch.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Add.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Edit.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Fetch.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThrough/Fetch.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/DocInAppliType/Fetch.php';		
		
		use classes\Implementation\ClosingOfFile as impCof;
		use classes\implementation\LetterType as impLetterType;
		use classes\Implementation\RecievedThrough as impRecievedThrough;
		use classes\implementation\DocInAppliType as impApplication;
		
		$fetchCof    = new impCof\Fetch();
		$addCof      = new impCof\Add();
		$editCof     = new impCof\Edit();
		$fetchLetter = new impLetterType\Fetch();
		$fetchRecievedThrough = new impRecievedThrough\Fetch();
		$fetchDoc    = new impApplication\Fetch();
	
		if(isset($_POST['submitDispatch']))
		 {		 	
		// print_r($_POST); exit;
		 	 $application_id = (int)trim($_POST['application_id']);			
			 $subject        = trim($_POST['subject']);	
			 $letterType     = (int)trim($_POST['letterType']);
			 $to             = $_POST['to'];
			 $copyTo         = (int)$_POST['copyTo'];

			 
			 if($subject=='' && strlen($subject) > 150)
			 	$errMsg[] = "Please Enter Place less than 100 charactor".'<br/>';
			 
			 if($letterType=='')
			 	$errMsg[] = "Please Enter Letter Type".'<br/>';
			
		 if(count($errMsg) == 0)
		 {
			$applicationStatus = $fetchCof->getApplicationStatus($application_id);
            $currentStage=$applicationStatus['stage_id'];
            $currentSubStage=$applicationStatus['sub_stage_id'];			
            $stage_id = $currentStage;
            $sub_stage_id = $currentSubStage+1;
            
			 $appliId = $addCof->generateLetter(
			 		$application_id,
			 		$letterType,			 				 		
			 		$subject,
			 		$to,
			 		$copyTo,
                    $stage_id );
			 
					 
			 $flag = $editCof-> upApplicationStatus($appliId, $stage_id, $sub_stage_id);
			 
			 if ($flag ==1)
			 {
			 	$msg = "Letter Generate Successfully.";
			 	header("Location:../../letter/samples/inlineall.php?appliId=$appliId&name=Testing-Letter");
			 //	header("Location:generateLetterDetails.php?appliId=$appliId&msg=$msg");
			 }
			 else
			 {
			 	$errmsg = "Letter Generate failed ?? Please try again Later.";
			 	header("Location:cof.php?errmsg=$errmsg");
			 }
			 
		 }
	}

	if (isset($_POST['application_id']))
	{
		$applicationId=$_POST['application_id'];
	}
	else 
	{
		$applicationId=$_GET['application_id'];
	}
$allApplicants = $fetchCof->getApplicats($applicationId);
$application = $fetchCof->getApplicationDetails($applicationId);
$appli_type_id = $application[0]['appli_type_id'];

$recievedThrough = $fetchRecievedThrough->getThrough($appli_type_id);
$allApplicationDoc = $fetchDoc->getSingleDocRequest($appli_type_id);
$allApplicationDocCount = count($allApplicationDoc);
$letterTypes = $fetchLetter->getAllLetterTypes();
//print_r($recievedThrough);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../css/styles.css">
		<script src="../../js/jquery.min.js"></script>
		<script src="../../js/masking/jquery-1.js"></script>
		<script src="../../js/masking/jquery.js"></script>
		<script src="../../js/cofValidation.js"></script>

		<script>
		function change_letter_type(str)
			{
				
				if (str.length==0)
				  {
				  	document.getElementById("letterSubject").innerHTML="";
				  	return;
				 }
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    document.getElementById("letterSubject").innerHTML=xmlhttp.responseText;
			    loadJS = function(src) {
			    	 var jsLink = $("<script type='text/javascript' src='"+src+"'>");
			    	 $("head").append(jsLink); 
			    	 }; 
			    	 loadJS("../../js/through.js");
			    				    
			    }
			  }
			xmlhttp.open("GET","ajax/getLetterSubject.php?q="+str,true);
			xmlhttp.send();
			}
		</script>
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
	     				<li><a href="index.php">Dashboard &nbsp;&nbsp;&nbsp; / </a></li>
	     				<li><a href="#">Generate Letter</a></li>
	     			</ul>
	     		</div>
	     		<div class="clear"></div>
	     		<?php if($msg != '')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-green">
	     			<?php echo $msg;?>	
	     		</div>
	     		<?php 
	     		}
	     		?>
	     		<?php if($errmsg != '' || count($errMsg) > 0)
	     		{	
	     		?>
	     	   	<div id="breadcrumb-red">
	     			<?php echo $errmsg;
	     			
	     			foreach($errMsg as $val) {
	     				echo $val;
	     			}
	     			
	     			?>	
	     		</div>
	     		<?php 
	     		}
	     		?>	
	     		<div class="clear"></div>
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">Generate Letter</div>
     				<div class="right-title" >&nbsp;</div>
	     		</div>
	           <div style="height:auto;border:1px solid #4b8df8;">
	            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="dispatch_detail" 
	            id="dispatch_detail" method="post" onsubmit="return validateCOF()">
							<h3>Dispatch Details</h3>
	     					<div style="width:80%;margin-left:1%">
								<div class="clear"></div>
								<div class="right">
										<div class="clear"></div>
										<div class="left">Letter Type <span class="red">*</span></div>
										<div class="right">										
										<select name="letterType" id="letterType" onchange="change_letter_type(this.value);">
				     							<option value=''>Select Letter Type</option>
				     						<?php
				     						for($i =0;$i<count($letterTypes);$i++)
												{
												?>
				     								<option value="<?php echo $letterTypes[$i]['id']; ?>" ><?php echo $letterTypes[$i]['type_name']; ?></option>
				     							<?php 
												}
				     						?>
				     						</select>											
										</div>										
										<div class="clear"></div>
										<div class="left"> To <span class="red">*</span></div><br/>
										<div class="right">
									<?php 	for($i=0;$i<count($allApplicants);$i++) { 
									
										$applicantCompletedDoc = $fetchCof->applicantCompletedDoc($applicationId, $allApplicants[$i]['id']);
										
										if($applicantCompletedDoc < $allApplicationDocCount)
										{
										?>
											<input type="hidden" id="to"  name="to[]" 
											value="<?php echo $allApplicants[$i]['id']?>"/>&nbsp;&nbsp;<?php echo $i+1; ?>&nbsp;)&nbsp; -> <?php echo $allApplicants[$i]['applicant_name']?><br/>
										<?php 
										} 
									} 
									?>
										</div>								
										
								</div>
								
								
								<div class="right">
										<div class="clear"></div>
										<div id="letterSubject">&nbsp;</div>
										
										<div class="clear"></div>										
										<div class="left">Copy To <span class="red">*</span></div><br/>
										<div class="right">
									
											<input type="hidden" id="copyTo"  name="copyTo" 
											value="<?php echo $recievedThrough[0]['id']?>"/>&nbsp;&nbsp;<b><?php echo $recievedThrough[0]['designation'].', '.$recievedThrough[0]['appli_through_name'];?></b><br/>
									
										</div>
										
										
								</div>
							</div>														
					
			     			<div class="clear"></div>
			     	<div class="clear"></div>
							
				     			<div style="text-align:center;padding:10px 0;">	
				     			
				     					<input type="hidden" id="application_id" name="application_id" 
				     					value="<?php if (isset($_POST['application_id'])) echo $_POST['application_id']; else echo $applicationId; ?>" />	
				     									
									<input class="form-button" type="submit" name="submitDispatch" value="Generate Letter" />
									
								</div>
							
						</form>
						
						</div>
					</div>
				
				
	     		<script type="text/javascript">
					jQuery(function($){
						$("#mobile_number").mask("999-999-9999", {placeholder: 'XXX/XXX/XXXX'});
                        $("#pincode").mask("999999", {placeholder: 'XXXXXX'});
                        $("#dob").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
					});
					$(document).ready(function() {
					    $('form:first *:input[type!=hidden]:first').focus();
					});
				</script>
	     	</div>
	 
		<script type="text/javascript" src="../../js/masking/ga.js"></script>
		 
	</body>
</html>
