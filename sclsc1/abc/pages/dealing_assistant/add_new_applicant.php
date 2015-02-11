<?php 
	session_start();
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
	
	$msg = '';
	$errmsg = '';
	$test = '';
	$address1='';
	$address2='';
	$applicant_city='';
	$applicant_state='';
	$applicant_pincode='';
	$reg_flag = array();
	
	require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Edit.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/State/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Eligibility/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Add.php';
	
	use classes\Implementation\State as impState;
	use classes\Implementation\Diary as impDiary;
	use classes\Implementation\Eligibility as impEligibility;
	
	$fetchDiary = new impDiary\Fetch();
	$editDiary = new impDiary\Edit();
	$addDiary = new impDiary\Add();
	$fetchState = new impState\Fetch();
	$fetchEligibility = new impEligibility\Fetch();
	
		if(isset($_GET['action']) && $_GET['action'] == 'del' && isset($_GET['id']) && $_GET['id'] != '')
		{
		 	//$flag = $editDiary->deleteApplicant($_GET['id']);
		}

		if(isset($_POST['addApplicant']) && $_POST['addApplicant']=='Add Applicant')
		 {
		 	$diaryNo         =  trim($_POST['diary_number']);
			$applicationType =	(int)trim($_POST['application_type']);
			$applicantName   =	trim($_POST['applicant_name']);
			$convictNo       = 	trim($_POST['convict_number']);
			$age             =	(int)trim($_POST['age']);
			$dob             =	trim($_POST['dob']);
			$fatherName      = 	trim($_POST['father_name']);
			$mobileNumber    = 	trim($_POST['mobile_number']);
			$contactNumber   =	trim($_POST['contact_number']);
			$mailId          = 	trim($_POST['mail_id']);
			$address1        = 	trim($_POST['address1']);
			$address2        = 	trim($_POST['address2']);
			$city            =	trim($_POST['applicant_city']);
			$state           = 	(int)trim($_POST['applicant_state']);
			$pincode         =	(int)trim($_POST['applicant_pincode']);
			$eligibilityCondition = $_POST['eligibility_condition'];
			$applicantConvictNo   = trim($_POST['custody_convict_number']);
			$custodyState         =	trim($_POST['custody_state']);
			$custodyJail          =	trim($_POST['custody_jails']);
			$recievedDate         = date('Y-m-d',strtotime($recievedDate));
				 
				$addApplicantFlag  = $addDiary->addApplicant
			 	(
			 		    $_GET['id'], 
			 		    $applicantName, 
			 			$fatherName, 
			 			$dob, 
			 			$age, 
			 			$address1, 
			 			$address2, 
			 			$city, 
			 			$state, 
			 			$pincode, 
			 			$mobileNumber, 
			 			$contactNumber, 
						$mailId,
			 			$eligibilityCondition, 
			 			$convictNo, 
			 			$custodyJail, 
			 			$applicationType, 
			 			$recievedThrough, 
			 			$applicantConvictNo
				);
				$appId =$_GET['id'];
				$msg = 'Applicant Registered Successfully';
				header("Location:success_stage.php?id=$appId&msg=$msg");			
		}
		
 $states = $fetchState->getAllStates();
 $eligibilityCondition = $fetchEligibility->getAllEligibilityConditions();
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
		<script src="../../js/validation.js"></script>
		<script>
			function change_received_type(str)
			{
				if (str.length==0)
				  {
				  	document.getElementById("received").innerHTML="";
				  	return;
				 }
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    document.getElementById("received").innerHTML=xmlhttp.responseText;
			    }
			  }
			xmlhttp.open("GET","received_through.php?q="+str,true);
			xmlhttp.send();
			}		
		
		function showAllMattchingJails(str)
			{
				if (str.length==0)
				  {
				  	document.getElementById("received").innerHTML="";
				  	return;
				 }
				
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    document.getElementById("showJails").innerHTML=xmlhttp.responseText;
			    }
			  }
			xmlhttp.open("GET","ajax/jails.php?q="+str,true);
			xmlhttp.send();
			}		
		
			function showJail()
			{
				if($('#isJail').is(":checked"))   
			        $("#jail").show();
			    else
			        $("#jail").hide();
			}
		</script>
		
		<script type="text/javascript">
		 $(document).ready(function(){
			 $('#dob').change(function(){
			 $.ajax({
			 type: "POST",
			 url: "ajax/ageCalculation.php?received_date="+$('#received_date').val()+"&dob="+$('#dob').val(),
			 success: function(result){
			 // alert(result);
			 $('#age').val(result);
			 }
			 });
			 });
			
			 });
		
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
	     				<li><a href="index.php">Home /</a></li>
	     				<li><a href="#">Application Details</a></li>
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
	     		<?php if($errmsg != '')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-red">
	     			<?php echo $errmsg;?>	
	     		</div>
	     		<?php 
	     		}
	     		?>	
	     		<div class="clear"></div>
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">Applicant Details</div>
     				<div class="right-title" >Application No. : <?php ?></div>
	     		</div>
	     			

     				<form action="add_new_applicant.php?id=<?php echo $_GET['id']?>" name="applicant_detail" id="applicant_detail" method="post" onsubmit="return validateApplicant(<?php echo $_SESSION['received_through_type']; ?>)">
			     		<div style="height:auto;border:1px solid #4b8df8;">
							<h3>Applicant Details</h3>
	     					<div style="width:80%;margin-left:1%">
								<div class="clear"></div>
								<div class="left">
										<div class="left"> Applicant Name <span class="red">*</span></div>
										<div class="right">
											<input type="text" id="applicant_name" placeholder=" Applicant Name" name="applicant_name" />
										</div>
										<div class="clear"></div>
										<div class="left">DOB</div>
										<div class="right">
											<input type="text" id="dob" placeholder=" Date of Birth " onblur="dobValidation(applicant_detail)" name="dob" value="<?php ?>" />
										</div>
										
										<div class="clear"></div>
										<div class="left">Age</div>
										<div class="right">
											<input type="text" id="age" placeholder=" Applicant Age" name="age"  />
										</div>
										<div class="clear"></div>
										<div style="text-align: center">
											<input checked type="radio" name="rel" value="S/O">S/O &nbsp;
											<input type="radio" name="rel" value="D/O">D/O&nbsp;
											<input type="radio" name="rel" value="W/O">W/O&nbsp;
										</div>
										<div class="clear"></div>
										<div class="left">Father/Husband Name</div>
										<div class="right">
											<input type="text" id="father_name" placeholder=" Father/Husband Name" name="father_name"  value="" />
										</div>
								</div>
								
								<div class="right">
										<div class="clear"></div>
										<div class="left">Convict Number</div>
										<div class="right">
											<input type="text" id="convict_no" placeholder=" Convict Number" name="convict_no" value="<?php ?>" />
										</div>
										
										<div class="clear"></div>
										<div class="left">Mobile No. </div>
										<div class="right">
											<input type="text" id="mobile_number" placeholder=" Mobile Number" name="mobile_number" />
										</div>
										<div class="clear"></div>
										<div class="left">Other Contact No.  </div>
										<div class="right">
											<input type="text" id="contact_number" placeholder=" Contact Number" name="contact_number" maxlength="12" size="12"/>
										</div>
										<div class="clear"></div>
										<div class="left">E-mail ID</div>
										<div class="right">
											<input type="text" id="applicant_mail_id" placeholder="E-mail ID" name="mail_id" />
										</div>
										
								</div>
							</div>
							<div class="clear"></div>
							<h3>Applicant Address</h3>
							<div style="width:90%;margin:auto;padding:12px; 0;">
								<div style="padding-bottom:20px;">
										
										<div class="custom-left1">
											<input type="text" id="address1" placeholder=" Address1" name="address1"  />
										</div>
										
										<div class="custom-left1">
											<input type="text" id="address2" placeholder=" Address2" name="address2" />
										</div>
										<div class="clear"></div>
										<div class="clear"></div>
										<div class="clear"></div>
										<div class="custom-left">
											<input type="text" id="applicant_city" placeholder=" Applicant City" name="applicant_city" />
										</div>
										<div class="custom-left">
											<select name="applicant_state" id="applicant_state">
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
											<input type="text" id="applicant_pincode" placeholder=" Pincode" name="applicant_pincode" />
										</div>
											
										
									</div>
							</div>
							<div class="clear"></div>
							<h3>Eligibility Condition</h3>
							<div >
								<div style="margin:auto;width:90%">
								<div class="clear"></div>
										
										<?php
											 //print_r($eligibilityCondition);
											 for($i =0;$i<count($eligibilityCondition);$i++)
											 {
											 if($eligibilityCondition[$i]['id'] == 14)
											 {
											 ?>
											 <div class="right">
											 <input <?php if($_SESSION['received_through_type'] != 33) { ?>onclick="showJail();" <?php } else { ?>checked="checked"<?php }?> type="checkbox" name="eligibility_condition[]" id="isJail" value="<?php echo $eligibilityCondition[$i]['id']; ?>" />
											 <?php echo $eligibilityCondition[$i]['eligibility_condition']; ?>
											 </div> 
											 <?php 
											 }
											 if($i%2 == 0 && $eligibilityCondition[$i]['id'] != 14)
											 { 
											 
											 ?>
											 <div class="right">
											 <input type="checkbox" name="eligibility_condition[]" id="" value="<?php echo $eligibilityCondition[$i]['id']; ?>" />
											 <?php echo $eligibilityCondition[$i]['eligibility_condition']; ?>
											 </div>
											 <?php 
											 }else if ($i%2 != 0 && $eligibilityCondition[$i]['id'] != 14)
											 {
											 ?>
											 <div class="right">
											 <input type="checkbox" name="eligibility_condition[]" id="" value="<?php echo $eligibilityCondition[$i]['id']; ?>" />
											 <?php echo $eligibilityCondition[$i]['eligibility_condition']; ?>
											 </div> 
											 <?php 
											 }
											 }
											 ?>	
										
								</div>
						<div id="jail">
							<div class="clear"></div>
							<h3>Jail Details</h3>
							<div style="width:90%;margin:auto;padding:12px; 0;">
								<div style="padding-bottom:20px;">
										<div class="clear"></div>
										<div class="clear"></div>
										<div class="custom-left2">Convict Number</div>
										<div class="custom-left">
											 <input type="text" id="custody_convict_number" placeholder=" Enter Convict Number" name="custody_convict_number" />
										</div>
										<div class="custom-left">
											<select name="custody_state" id="custody_state" onchange="showAllMattchingJails(this.value)" >
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
											<select name="custody_jails" id="showJails">
				     							<option value=''>Select Jail</option>
				     						</select>
										</div>
									
									</div>
							</div>
						</div>
								<div class="clear"></div>
								<div style="border:1px solid #ddd;margin-bottom:8px;"></div>
								
								<div style="text-align:center">
									<input onclick="return validateEligibility();" class="form-button" type="submit" name="addApplicant" value="Add Applicant" />									
								</div>
								<div class="clear"></div>
							</div>
							
						</div>
					</form>
					<div >
					<div class="clear"></div>
						
				
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				
	     		<script type="text/javascript">
					jQuery(function($){
						$("#mobile_number").mask("999-999-9999", {placeholder: 'XXX/XXX/XXXX'});
                        $("#applicant_pincode").mask("999999", {placeholder: 'XXXXXX'});
                        $("#dob").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
					});
					$(document).ready(function() {
					    $('form:first *:input[type!=hidden]:first').focus();
					});
				</script>
	     	</div>
	    </div>
		<script type="text/javascript" src="../../js/masking/ga.js"></script>
		 
	</body>
</html>
