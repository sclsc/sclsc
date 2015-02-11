<?php 
	session_start();
	if(!isset($_SESSION['user']['user_name']) && $_SESSION['user']['role_id']!=2)
		header('location:../../index.php');
	
	$msg = '';
	$errmsg = '';
	
	require_once $_SESSION['base_url'].'/classes/Implementation/Users/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThroughType/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThrough/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/State/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/ApplicationTypes/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Eligibility/Fetch.php';
	
	use classes\Implementation\Users as impUser;
	use classes\Implementation\RecievedThroughType as impRecievedThroughType;
	use classes\Implementation\RecievedThrough as impRecievedThrough;
	use classes\Implementation\Diary as impDairy;
	use classes\Implementation\State as impState;
	use classes\Implementation\ApplicationTypes as impAppType;
	use classes\Implementation\Eligibility as impEligibility;
	
	$fetchUser = new impUser\Fetch();
	$fetchThrough = new impRecievedThrough\Fetch();
	$fetchApp = new impDairy\Fetch();
	$fetchState = new impState\Fetch();
	$fetchAppType = new impAppType\Fetch();
	$fetchEligibility = new impEligibility\Fetch();
	
	$applicationDetails = $fetchApp->getDiaryDetails($_GET['id']);
	print_r($applicationDetails);
	$eligibilityCondition = $fetchEligibility->getAllEligibilityConditions();
	$recieved_date = date("d-m-Y", strtotime($applicationDetails[0]['recieved_date']));
	$applicantEligibilities = $fetchEligibility->getApplicationEligibilities($fetchApp->getApplicantId($applicationDetails[0]['id']));
	$received_through_type_ids = $fetchThrough->getReceivedThroughType();
	$states = $fetchState->getAllStates();
	$applicationTypes = $fetchAppType->getAllApplicationType();
	//print_r($applicationTypes);
	
	$father = substr($applicationDetails[0]['father_name'],4);
	 
	if(isset($_POST['submit']))
	{
		print_r($_REQUEST);
		/* $addDiaryFlag = $addDiary->registerDiaryByDeelingAssistant(
			
				
		) */
	}
	
//echo	$applicationDetails[0]['appli_through_type_id'];
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
		<link rel="stylesheet" href="../../css/chosen/docsupport/style.css">
  		<link rel="stylesheet" href="../../css/chosen/docsupport/prism.css">
  		<link rel="stylesheet" href="../../css/chosen/chosen.css">
		
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
			    loadJS = function(src) {
			    	 var jsLink = $("<script type='text/javascript' src='"+src+"'>");
			    	 $("head").append(jsLink); 
			    	 }; 
			    	 loadJS("../../js/through.js");
			    				    
			    }
			  }
			xmlhttp.open("GET","ajax/received_through.php?q="+str,true);
			xmlhttp.send();
			}			
		
	
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
			//alert("yaha tk working");
			if($('#isJail').is(":checked"))   
		        $("#jail").show();
		    else
		        $("#jail").hide();
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
	     				<li><a href="#">Home </a></li>
	     				
	     			</ul>
	     		</div>
	     	
	     		<div class="clear"></div>
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">Backlog Data Entry Module</div>
     				<div class="right-title" id="diary_num">&nbsp;</div>
	     		</div>
	     		<form action="new_application.php" method="post" onsubmit="return validateDiary()" name="diary">
		     		<div style="height:900px;border:1px solid #4b8df8;">
						<h3>Diary Details</h3>
     					<div style="width:80%;margin-left:10%">
     					<div class="left">
							<div class="clear"></div>
							<div class="left"> Diary Number <span class="red">*</span></div>
							<div class="right">
								<input type="text" name="diary_number" id="diary_number" placeholder=" Diary Number " value="<?php echo $applicationDetails[0]['diary_no']; ?>" readonly />
							</div>
							<div class="clear"></div>
							<div class="left"> Received Through </div>
							<div class="right">
								<select name="received_through_type" id="received_through_type" class="chosen-select" onchange="change_received_type(this.value);">
									<option value="">Select</option>
									<?php
		     						for($i =0;$i<count($received_through_type_ids);$i++)
										{
									?>
		     							<option value="<?php echo $received_through_type_ids[$i]['id']?>"<?php if($received_through_type_ids[$i]['id']==$applicationDetails[0]['appli_through_type_id']) { echo "selected=selected"; } ?> ><?php echo $received_through_type_ids[$i]['appli_through_type_name']; ?></option>
		     						<?php 
										}
		     						?>
								</select>
							</div>
						</div>
						<div class="right">
							<div class="clear"></div>
							<div class="left"> Received Date <span class="red">*</span></div>
							<div class="right">
								<input type="text" id="received_date" name="received_date" placeholder=" Received Date " onblur="myFunction(diary)" value="<?php echo $recieved_date ?>" readonly />
							</div>
							<div class="clear"></div>
							<div id="received">
								<input type="hidden" name="received_through" id="received_through" value='0' />
							</div> 
						</div>
						</div><div class="clear"></div>
						<h3>Applicant Details</h3>
						<div style="width:80%;margin-left:1%">
								<div class="clear"></div>
								<div class="left">
										<input type="hidden" name="id" value="<?php echo $_GET['id']?>">
										<div class="left"> Applicant Name <span class="red">*</span></div>
										<div class="right">
											<input type="text" id="applicant_name" placeholder=" Applicant Name" name="applicant_name" value="<?php echo $applicationDetails[0]['applicant'] ?>" />
										</div>
										<div class="clear"></div>
										<div class="left">DOB</div>
										<div class="right">
											<input type="text" id="dob" placeholder=" Date of Birth " onblur="dobValidation(diary)" name="dob"  />
										</div>
										<div class="clear"></div>
										<div class="left">Age</div>
										<div class="right">
											<input type="text" id="age" placeholder=" Applicant Age" name="age"  />
										</div>
										<div class="clear"></div>
										<div style="text-align: center">
											<input checked type="radio" name="rel" value="S/O">S/O &nbsp;
											<input <?php if($_SESSION[$_GET['id']]['rel'] == 'D/O') echo "checked"; ?> type="radio" name="rel" value="D/O">D/O&nbsp;
											<input <?php if($_SESSION[$_GET['id']]['rel'] == 'W/O') echo "checked"; ?> type="radio" name="rel" value="W/O">W/O&nbsp;
										</div>
										<div class="clear"></div>
										<div class="left">Father/Husband Name</div>
										<div class="right">
											<input type="text" id="father_name" placeholder=" Father/Husband Name" name="father_name"  value="<?php echo $father ?>" />
										</div>
								</div>
								
								<div class="right">
										<?php if(!isset($applicationDetails[0]['recieved_through'])){?>
										<div class="clear"></div>
										<div class="left">Convict Number</div>
										<div class="right">
											<input type="text" id="convict_no" placeholder=" Convict Number" name="convict_no" value="<?php if(isset($_SESSION[$_GET['id']]['applicant_convict_no'])) echo $_SESSION[$_GET['id']]['applicant_convict_no']?>" />
										</div>
										<?php }?>
										<div class="clear"></div>
										<div class="left">Mobile No. </div>
										<div class="right">
											<input type="text" id="mobile_number" placeholder=" Mobile Number" name="mobile_number" />
										</div>
										<div class="clear"></div>
										<div class="left">Other Contact No.  </div>
										<div class="right">
											<input type="text" id="contact_number" placeholder=" Contact Number" name="contact_number" maxlength="12" size="12" value="<?php echo $applicationDetails[0]['contact_number'] ?>" />
										</div>
										<div class="clear"></div>
										<div class="left">E-mail ID</div>
										<div class="right">
											<input type="text" id="applicant_mail_id" placeholder="E-mail ID" name="mail_id"  value="<?php echo $applicationDetails[0]['mail_id'] ?>" />
										</div>
										
								</div>
							</div>
							<div class="clear"></div>
							<h3>Applicant Address</h3>
							<div style="width:90%;margin:auto;padding:12px; 0;">
								<div style="padding-bottom:20px;">
										
										<div class="custom-left1">
											<input type="text" id="address1" placeholder=" Address1" name="address1"  value="<?php echo $applicationDetails[0]['sender_address1']?>" />
										</div>
										
										<div class="custom-left1">
											<input type="text" id="address2" placeholder=" Address2" name="address2"  value="<?php echo $applicationDetails[0]['sender_address2']?>" />
										</div>
										<div class="clear"></div>
										<div class="clear"></div>
										<div class="clear"></div>
										<div class="custom-left">
											<input type="text" id="applicant_city" placeholder=" Applicant City" name="applicant_city"  value="<?php echo $applicationDetails[0]['sender_city']?>" />
										</div>
										<div class="custom-left">
											<select name="applicant_state" id="applicant_state">
				     							<option value=''>Select State</option>
				     						<?php
				     						for($i =0;$i<count($states);$i++)
												{
												?>
				     								<option value="<?php echo $states[$i]['id']; ?>" <?php if($states[$i]['id'] == $applicationDetails[0]['sender_state']) { echo 'selected'; } ?>><?php echo $states[$i]['state_name']; ?></option>
				     							<?php 
												}
				     						?>
				     						</select>
										</div>
										<div class="custome-left"></div>
										<div class="custom-left">
											<input type="text" id="applicant_pincode" placeholder=" Pincode" name="applicant_pincode" value="<?php echo $applicationDetails[0]['pincode']?>" />
										</div>
											
										
									</div>
							</div>
							<div class="clear"></div>
							<h3>Eligibility Condition</h3>
							<div >
								<div style="margin:auto;width:90%">
								<div class="clear"></div>
										
									<?php
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
											<input type="text" id="custody_convict_number" placeholder=" Convict Number" name="custody_convict_number"  value="<?php if(isset($_SESSION[$_GET['id']]['custody_convict_number'])) echo $_SESSION[$_GET['id']]['custody_convict_number']?>" />
										</div>
										<div class="custom-left">
											<select name="custody_state" id="custody_state" onchange="showAllMattchingJails(this.value)" >
				     							<option value=''>Select State</option>
				     						<?php
				     						for($i =0;$i<count($states);$i++)
												{
											?>
				     							<option value="<?php echo $states[$i]['id']; ?>" <?php if($states[$i]['id'] == $_SESSION[$_GET['id']]['custody_state']) { echo 'selected'; } ?>><?php echo $states[$i]['state_name']; ?></option>
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
							<h3>Legal Aid Sought for</h3>
							<div style="width:20%;">
									<div class="clear"></div>	
									<div class="custom-left">
										Application Type
									</div>
									<div class="custom-right">
									<select name="application_type" id="application_type"  >
				     							<option value=''>Select Application Type</option>
				     						<?php
				     						for($i =0;$i<count($applicationTypes);$i++)
												{
											?>
				     							<option value="<?php echo $applicationTypes[$i]['id']; ?>" ><?php echo $applicationTypes[$i]['appli_type_name']; ?></option>
				     						<?php 
												}
				     						?>
				     						</select>
				     						</div>
							</div>
						<div class="clear"></div>
						<div style="width:100%;text-align:center;margin-top:20px;">	
							<input class="form-button" type="submit" name="submit" value="Save" />
						</div>
						</div>
						</div>
						
				</form>
				
	     		<script type="text/javascript">
					jQuery(function($){
						$("#received_date").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
					});
					$(document).ready(function() {
					    $('form:first *:input[type!=hidden]:first').focus();
					});
				</script>
				<script type="text/javascript">
					jQuery(function($){
						$("#mobile_number").mask("999-999-9999", {placeholder: 'XXX/XXX/XXXX'});
                        $("#applicant_pincode").mask("999999", {placeholder: 'XXXXXX'});
                      //  $("#dob").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
					});
					$(document).ready(function() {
					    $('form:first *:input[type!=hidden]:first').focus();
					});
				</script>
					<script src="../../js/chosen/jquery.min.js" type="text/javascript"></script>
				  <script src="../../js/chosen/chosen.jquery.js" type="text/javascript"></script>
				  <script src="../../js/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
				  		<script type="text/javascript">
						    var config = {
						      '.chosen-select'           : {},
						      '.chosen-select-deselect'  : {allow_single_deselect:true},
						      '.chosen-select-no-single' : {disable_search_threshold:10},
						      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
						      '.chosen-select-width'     : {width:"95%"}
						    }
						    for (var selector in config) {
						      $(selector).chosen(config[selector]);
						    }
				  </script>
	  		
			     		
		     		</div>
	     		</div>
		
		<script type="text/javascript" src="../../js/masking/ga.js"></script>
		<script type="text/javascript">
			    if (typeof(_gat)=='object')
		        setTimeout(function(){
		            try {
		                var pageTracker=_gat._getTracker("UA-10112390-1");
		                pageTracker._trackPageview()
		            } catch(err) {}
		        }, 1500);	

			function change_received_type2(str,str2)
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
			xmlhttp.open("GET","ajax/received_through2.php?q="+str+"&y="+str2,true);
			xmlhttp.send();
			}	
			window.onload=change_received_type2(<?php echo $applicationDetails[0]['appli_through_type_id']; ?>,<?php echo $applicationDetails[0]['recieved_through']; ?>);		
			
		</script>
	</body>
</html>
