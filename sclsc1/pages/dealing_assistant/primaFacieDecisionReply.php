<?php 
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
	
	$msg = '';
	$errmsg = '';
	$reg_flag = array();
	
	require_once $_SESSION['base_url'].'/classes/Implementation/State/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Edit.php';
	
	use classes\Implementation\State as impState;
	use classes\Implementation\Dispatcher as impDispatcher;
	use classes\Implementation\ClosingOfFile as impCof;
	
	$addCof = new impCof\Add();
	$editCof    = new impCof\Edit();
	$fetchState = new impState\Fetch();


	
		if(isset($_POST['submitDispatch']))
		 {		 	
		 //	print_r($_POST); exit;
		 	 $application_id = (int)trim($_POST['application_id']);
			 $name           = (int)trim($_POST['name']);
			 $opinion_letter = (int)trim($_POST['opinion_letter']);
			 $subject        = trim($_POST['subject']);
			 $opinion_sought_summary = trim($_POST['opinion_sought_summary']);
			 $received_date  = trim($_POST['received_date']);
			 $secretary_order= trim($_POST['secretary_order']);
			 $is_in_favour   = (float)$_POST['is_in_favour'];
			 $is_lsc         = (float)$_POST['is_lsc'];
			 $opinion_received_summary = trim($_POST['opinion_received_summary']);
	 
			 if($name=='' || strlen($name) > 150)
			 	$errMsg[] = "Please Enter Full Name less than 150 charactor".'<br/>';		 
			 
			 if($subject=='' || strlen($subject) > 250)
			 	$errMsg[] = "Please Enter Subject less than 250 charactor".'<br/>';
			 
			 if($secretary_order=='' || strlen($secretary_order) > 100)
			 	$errMsg[] = "Please Enter File Head less than 250 charactor".'<br/>';
			 
			 
		 if(count($errMsg) == 0)
		 {
		 	$stage_id = 4;
		 	$sub_stage_id = 24;
			$flag = $addCof-> addOpinionDecision(
			 		$application_id,
			 		$name,
			 		$opinion_letter,			 		
			 		$subject,
			 		$opinion_sought_summary,
			 		$received_date,
			 		$secretary_order,
			 		$is_in_favour,
					$is_lsc,
			 		$opinion_received_summary,
	                $stage_id );		
						 
		//	 $flag = $editCof->upDispatchStatus($applicationId, $stage_id, $sub_stage_id);
			 
			 if ($flag == 1)
			 {
			 	$msg = "Dispach Record Has been Registered successfully.";
			 	header("Location:primaFacieReplyAwaited.php?msg=$msg");
			 }
			 else
			 {
			 	$errmsg = "Dispach failed ?? Please try again Later.";
			 	header("Location:index.php?errmsg=$errmsg");
			 }
			 
		 }
	}
		
		
		
//$states = $fetchState->getAllStates();

		
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
		<script src="../../js/dispatchValidation.js"></script>

		
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
	     				<li><a href="index.php">Dashboard &nbsp;&nbsp;&nbsp;&nbsp;</a>/</li>
	     				<li><a href="primaFacieFit.php">Prima Facie Fit &nbsp;&nbsp;&nbsp;</a>/</li>
	     				<li><a href="primaFacieReplyAwaited.php">Applications Prima Facie Reply Awaited&nbsp;&nbsp;&nbsp;</a>/</li>
	     				<li><a href="#">Prima Facie Decision Reply</a></li>
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
     				<div id="left-title">Prima Facie Decision Reply</div>
     				<div class="right-title" >Application No. : <?php echo $_GET['appliNo'].$_POST['appliNo'];?></div>
	     		</div>
	           <div style="height:auto;border:1px solid #4b8df8;">
	            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="dispatch_detail" 
	            id="dispatch_detail" method="post" onsubmit="return validateDispatch()">
							<h3>Decision Reply Details</h3>
	     					<div style="width:80%;margin-left:1%">
								<div class="clear"></div>
								<div class="left">
										<div class="left"> Adviser <span class="red">*</span></div>
										<div class="right">
											<input type="text" id="name" placeholder="Full Name" name="name" maxlength="150"/>
										</div>
										<div class="clear"></div>
										<div class="left">Opinion Letter</div>
										<div class="right">
											<input type="text" id="opinion_letter" placeholder="Opinion Letter" name="opinion_letter" maxlength="100"/>
										</div>
										
										<div class="clear"></div>
										<div class="left">Subject <span class="red">*</span></div>
										<div class="right">
										<input type="text"  placeholder="Subject" name="subject" maxlength="150"/>											
										</div>
										
                                        <div class="clear"></div>
										<div class="left">Sought Summary</div>
										<div class="right">
										<textarea rows="4" cols="50" id="opinion_sought_summary" name="opinion_sought_summary" placeholder="Opinion Sought Summary"></textarea>										
										</div>
								</div>
								
								<div class="right">
										<div class="clear"></div>
										<div class="left">Received Date</div>
										<div class="right">
											<input type="text" id="received_date" placeholder="Received Date" name="received_date" />
										</div>										
										<div class="clear"></div>
										<div class="left">Secretary Order</div>
										<div class="right">
											<input type="text" id="secretary_order" placeholder="Secretary Order" name="secretary_order" />
										</div>
										<div class="clear"></div>
										<div class="left">Is in Favour</div>
										<div class="right">
											<input type="checkbox" id="is_in_favour" name="is_in_favour" value="1"/>
										</div>
										<div class="clear"></div>
										<div class="left">Is LSC</div>
										<div class="right">
											<input type="checkbox" id="is_lsc" name="is_lsc" value="1"/>
										</div>
										<div class="clear"></div>
										<div class="left">Received Summary</div>
										<div class="right">
										<textarea rows="4" cols="50" id="opinion_received_summary" name="opinion_received_summary" placeholder="Opinion Received Summary"></textarea>										
										</div>
										
								</div>
							</div>
							
					
			     			<div class="clear"></div>
			     	<div class="clear"></div>
							
				     			<div style="text-align:center;padding:10px 0;">	
				     					<input type="hidden" id="application_id" name="application_id" 
				     					value="<?php if(isset($_GET['applicationId'])) echo $_GET['applicationId']; else echo $_POST['applicationId'];?>"/>	
				     					<input type="hidden" id="appliNo" name="appliNo" 
				     					value="<?php if(isset($_GET['appliNo'])) echo $_GET['appliNo']; else echo $_POST['appliNo'];?>"/>					
									<input class="form-button" type="submit" name="submitDispatch" value="Submit" />
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
