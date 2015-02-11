<?php 
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
	
	$msg = '';
	$errmsg = '';
	$reg_flag = array();
	
	require_once $_SESSION['base_url'].'/classes/Implementation/State/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Dispatcher/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Edit.php';
	
	use classes\Implementation\State as impState;
	use classes\Implementation\Dispatcher as impDispatcher;
	use classes\Implementation\ClosingOfFile as impCof;
	
	$addDispatch = new impDispatcher\Add();
	$editCof    = new impCof\Edit();
	$fetchState = new impState\Fetch();


	
		if(isset($_POST['submitDispatch']))
		 {		 	
		 //	print_r($_POST); exit;
		 	 $application_id = (int)trim($_POST['application_id']);
			 $name           = trim($_POST['name']);
			 $place          = trim($_POST['place']);
			 $subject        = trim($_POST['subject']);
			 $file_head      = trim($_POST['file_head']);
			 $stamp_received = (float)trim($_POST['stamp_received']);
			 $stamp_affixed  = (float)trim($_POST['stamp_affixed']);
			 $stamp_balance  = (float)trim($_POST['stamp_balance']);
			 $remarks        = trim($_POST['remarks']);
			 $address1       = trim($_POST['address1']);
			 $address2       = trim($_POST['address2']);
			 $city           = trim($_POST['city']);
			 $state          = (int)trim($_POST['state']);
			 $pincode        = (int)trim($_POST['pincode']);
		
			 
			 if($name=='' || strlen($name) > 150)
			 	$errMsg[] = "Please Enter Full Name less than 150 charactor".'<br/>';
			 
			 if($place!='' && strlen($place) > 100)
			 	$errMsg[] = "Please Enter Place less than 100 charactor".'<br/>';
			 
			 if($place!='' && strlen($stamp_received) > 100)
			 	$errMsg[] = "Please Enter Place less than 100 charactor".'<br/>';
			 
			 if($subject=='' || strlen($subject) > 250)
			 	$errMsg[] = "Please Enter Subject less than 250 charactor".'<br/>';
			 
			 if($file_head=='' || strlen($file_head) > 250)
			 	$errMsg[] = "Please Enter File Head less than 250 charactor".'<br/>';
			 
			 if($stamp_received!=0  && strlen($stamp_received) > 5)
			 	$errMsg[] = "Please Enter Stamp Received less than 5 Legth".'<br/>';
			 
			 if($stamp_affixed!=0 && strlen($stamp_affixed) > 5)
			 	$errMsg[] = "Please Enter Stamp Affixed less than 5 Legth".'<br/>';
			 
			 if($stamp_balance!=0 && strlen($stamp_balance) > 5)
			 	$errMsg[] = "Please Enter Stamp Balance less than 5 Legth".'<br/>';
			 
			 if($address1=='' || strlen($address1) > 250)
			 	$errMsg[] = "Please Enter Address Line 1 less than 100 charactor".'<br/>';
			 
			 if($state=='')
			 	$errMsg[] = "Please Select State".'<br/>';

			 
		 if(count($errMsg) == 0)
		 {
			 
			 $applicationId = $addDispatch->addDispatcher(
			 		$application_id,
			 		$name,
			 		$place,			 		
			 		$subject,
			 		$file_head,
			 		$stamp_received,
			 		$stamp_affixed,
			 		$stamp_balance,
			 		$remarks,
			 		$address1,
			 		$address2,
			 		$city,
			 		$state,
			 		$pincode );
		
			 $stage_id = 2;
			 $sub_stage_id = 16;			 
			 $flag = $editCof->upDispatchStatus($applicationId, $stage_id, $sub_stage_id);
			 
			 if ($flag == 1)
			 {
			 	$msg = "Dispach Record Has been Registered successfully.";
			 	header("Location:index.php?msg=$msg");
			 }
			 else
			 {
			 	$errmsg = "Dispach failed ?? Please try again Later.";
			 	header("Location:index.php?errmsg=$errmsg");
			 }
			 
		 }
	}
		
		
		
$states = $fetchState->getAllStates();

		
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
	     				<li><a href="index.php">Home /</a></li>
	     				<li><a href="#">Dispatch Details</a></li>
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
     				<div id="left-title">Dispatch Details</div>
     				<div class="right-title" >Application No. : <?php echo $_GET['appliNo'].$_POST['appliNo'];?></div>
	     		</div>
	           <div style="height:auto;border:1px solid #4b8df8;">
	            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="dispatch_detail" 
	            id="dispatch_detail" method="post" onsubmit="return validateDispatch()">
							<h3>Dispatch Details</h3>
	     					<div style="width:80%;margin-left:1%">
								<div class="clear"></div>
								<div class="left">
										<div class="left"> Full Name <span class="red">*</span></div>
										<div class="right">
											<input type="text" id="name" placeholder=" Full Name" name="name" maxlength="150"/>
										</div>
										<div class="clear"></div>
										<div class="left">Place</div>
										<div class="right">
											<input type="text" id="place" placeholder="Place" name="place" maxlength="100"/>
										</div>
										
										<div class="clear"></div>
										<div class="left">Subject <span class="red">*</span></div>
										<div class="right">
										<input type="text"  placeholder="Subject" name="subject" maxlength="150"/>											
										</div>
										
										<div class="clear"></div>
										<div class="left">File Head <span class="red">*</span></div>
										<div class="right">
											<input type="text" id="file_head" placeholder="File Head" name="file_head" maxlength="50"/>
										</div>
								</div>
								
								<div class="right">
										<div class="clear"></div>
										<div class="left">Stamp Received</div>
										<div class="right">
											<input type="text" id="stamp_received" placeholder="Stamp Received " name="stamp_received" />
										</div>
										
										<div class="clear"></div>
										<div class="left">Stamp Affixed</div>
										<div class="right">
											<input type="text" id="stamp_affixed" placeholder="Stamp Affixed" name="stamp_affixed" />
										</div>
										<div class="clear"></div>
										<div class="left">Stamp Balance</div>
										<div class="right">
											<input type="text" id="stamp_balance" placeholder="Stamp Balance" name="stamp_balance" maxlength="12"/>
										</div>
										<div class="clear"></div>
										<div class="left">Remarks</div>
										<div class="right">
										<textarea rows="4" cols="50" id="remarks" name="remarks" placeholder="Remark">
										
										</textarea>
										
										</div>
										
								</div>
							</div>
							<div class="clear"></div>
							<h3>Dispatch Address Details</h3>
							<div style="width:90%;margin:auto;padding:12px; 0;">
								<div style="padding-bottom:20px;">
										
										<div class="custom-left1">
											<input type="text" id="address1" placeholder=" Address Line 1" name="address1" maxlength="100"/>
										</div>
										
										<div class="custom-left1">
											<input type="text" id="address2" placeholder=" Address Line 2" name="address2" maxlength="100"/>
										</div>
										<div class="clear"></div>
										<div class="clear"></div>
										<div class="clear"></div>
										<div class="custom-left">
											<input type="text" id="city" placeholder="Dispach City" name="city" />
										</div>
										<div class="custom-left">
											<select name="state" id="state">
				     							<option value=''>Select State</option>
				     						<?php
				     						for($i =0;$i<count($states);$i++)
												{
											?>
				     							<option value="<?php echo $states[$i]['id']; ?>"><?php echo $states[$i]['state_name']; ?></option>
				     						<?php 
												}
				     						?>
				     						</select>
										</div>
										<div class="custome-left"></div>
										<div class="custom-left">
											<input type="text" id="pincode" placeholder=" Pincode" name="pincode" />
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
