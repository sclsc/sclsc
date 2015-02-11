<?php 
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
$msg = '';
$errmsg = '';
	
		require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Fetch.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Add.php';
		
		use classes\Implementation\ClosingOfFile as impCof;
		$fetchCof = new impCof\Fetch();
		$addCof = new impCof\Add();
	
		if(isset($_POST['submitDispatch']))
		 {		 	
		 //	print_r($_POST); exit;
		 	 $application_id = (int)trim($_POST['application_id']);			
			 $subject        = trim($_POST['subject']);	
			 $letterType     = trim($_POST['letterType']);
			 $to             = $_POST['to'];
			 $copyTo         = $_POST['copyTo'];

			 
			 if($subject=='' && strlen($subject) > 150)
			 	$errMsg[] = "Please Enter Place less than 100 charactor".'<br/>';
			 
			 if($letterType=='')
			 	$errMsg[] = "Please Enter Letter Type".'<br/>';
			 
			 foreach ($to as $val) 
			 {
			 	if (in_array($val, $copyTo))
			 	{
			 		$errMsg[] = "Please Select To and CopyTo Applicant Must be Different (Not Same) ".'<br/>';
			 		break;
			 	}
			 }
			

			 
		 if(count($errMsg) == 0)
		 {
			 
			 $flag = $addCof->generateLetter(
			 		$application_id,
			 		$letterType,			 				 		
			 		$subject,
			 		$to,
			 		$copyTo );
			 
			 if ($flag == 1)
			 {
			 	$msg = "Letter Generate Successfully.";
			 	header("Location:cof.php?msg=$msg");
			 }
			 else
			 {
			 	$errmsg = "Letter Generate failed ?? Please try again Later.";
			 	header("Location:cof.php?errmsg=$errmsg");
			 }
			 
		 }
	}
	
$allApplicants       = $fetchCof->getApplicats($_POST['application_id']);
//print_r($allApplicants);
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
	     				<li><a href="#">Closing The File</a></li>
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
     				<div id="left-title">Closing The File</div>
     				<div class="right-title" >&nbsp;</div>
	     		</div>
	           <div style="height:auto;border:1px solid #4b8df8;">
	            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="dispatch_detail" 
	            id="dispatch_detail" method="post" onsubmit="return validateCOF()">
							<h3>Closing The File</h3>
	     					<div style="width:80%;margin-left:1%">
								<div class="clear"></div>
								<div class="right">
										<div class="clear"></div>
										<div class="left">Closing Stage <span class="red">*</span></div>
										<div class="right">
										<input type="text"  placeholder="Closing Stage" name="closing_stage" id="closing_stage" maxlength="5" onKeyPress="return number(event)"/>											
										</div>										
						
								</div>
								
								
								<div class="right">
										<div class="clear"></div>
										<div class="left">Closing Date <span class="red">*</span></div>
										<div class="right">
										<input type="text"  placeholder="Closing Date" name="closing_date" id="closing_date"/>											
										</div>
										
								</div>
							</div>														
					
			     			<div class="clear"></div>
			     	<div class="clear"></div>
							
				     			<div style="text-align:center;padding:10px 0;">	
				     					<input type="hidden" id="application_id" name="application_id" 
				     					value="<?php echo $_POST['application_id'];?>"/>	
				     					<input type="hidden" id="slpAction" name="slpAction" 
				     					value="<?php echo $_POST['slpAction'];?>"/>					
									<input class="form-button" type="submit" name="submitDispatch" value="Generate Letter"/>
									
								</div>
							
						</form>
						
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
	     	</div>
	 
		<script type="text/javascript" src="../../js/masking/ga.js"></script>
		 
	</body>
</html>
