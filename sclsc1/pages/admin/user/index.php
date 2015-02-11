<?php 
	session_start();
	//error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
	require_once $_SESSION['base_url'].'/classes/Implementation/Users/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Users/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Users/Edit.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Users/Delete.php';
	//require_once $_SESSION['base_url'].'/classes/Implementation/State/Fetch.php';

	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
	
	use classes\Implementation\Users as impUsers;
	//use classes\Implementation\State as impState;
	use classes\Pagination as clsPagination;
	
	$addUser   = new impUsers\Add();
	$FetchUser = new impUsers\Fetch();
	$EditUser  = new impUsers\Edit();
	$DeleteUser = new impUsers\Delete();
//	$fetchState = new impState\Fetch();
	/*
	$pagination = new clsPagination\Pagination();
	*/
	
	$msg='';
	$errmsg='';
	$targetpage = 'index.php';
	$adjacents = 2;
	$limit = 10;
	$start = 0;
	$page = 0;
	$paging='';
	$f=0;
	
	if(isset($_GET['page']))
	{
		$page = $_GET['page'];
		if($page){
			$start = ($page - 1) * $limit;
			$recordCounter=$start;
		}
		else
			$start = 0;
		//$states = $fetchState->getAllStates();
		//$appliThroughType = $fetchRecievedThrough->getAllReceivedThrough($limit,$start);
		//$throughType = $fetchRecievedThroughType->getThroughType();
		//$Records = $fetchRecievedThrough->getAllReceivedThroughCount();
		//echo $Records; exit;
		$url = 'fromDate='.$_GET['fromDate'].'&toDate='.$_GET['toDate'].'&application_type='.$_GET['application_type'].'&through_type='.$_GET['through_type'].'&last_statge='.$_GET['last_statge'].'&state='.$_GET['state'];
		//	$url='';
		$paging = $pagination->paginations($page,$Records,$limit,$targetpage,$adjacents,$url);
	
	}

	
	if(isset($_POST['submit']))
	{
		$role  		  =  (int) trim($_POST['role']);
		$username     =  trim($_POST['username']);
		$password     =  trim($_POST['password']);
		$firstname    =  trim($_POST['firstname']);
		$lastname     =  trim($_POST['lastname']);
		$designation  =  trim($_POST['designation']);
		$email_id     =  trim($_POST['email_id']);
		$mobile_no1   = (int) trim($_POST['mobile_no1']);
		$mobile_no2   = (int) trim($_POST['mobile_no2']);
		
		$checkFlag = $FetchUser->checkApplicationType($_POST['email_id']);
		if($checkFlag != 1)
		{
		  $flag = $addUser->registerUser($role,
					$username,
				    $password,
				    $firstname,
				    $lastname,
				    $designation,
					$email_id,
					$mobile_no1,$mobile_no2
					);
			if($flag == 1)
			{
				$msg = "User Name Add Successfully.";
				header("Location:index.php?msg=$msg&alert=success");
			}
			else
			{
				$errmsg = "User failed ?? Please try again Later.";
				header("Location:index.php?errmsg=$errmsg");
			}
		}
		else
		{
			$msg = "User  Already Exist";
			header("location:index.php?msg=$msg");
		}
	}
	if(isset($_GET['UserId']) && $_GET['action']=="delete"){
		$DelUser= $DeleteUser->delUser($_GET['UserId']);
		if($DelUser==1)
		{
			$msg = "User has been deleted successfully";
		  header("location:index.php?msg=$msg&alert=success");
		}
		else
		{
			$msg='Error ?? try again Later';
			header("location:index.php?msg=$msg");
		}
	}
	//print_r($throughType);
	if(isset($_POST['cancel']) && $_POST['cancel']=="Cancel")
	{
		header('Location:index.php');
	}
	if(isset($_GET['UserId']) && $_GET['action']=="edit"){
	  $FetchUserId= $FetchUser->getUserDetails($_GET['UserId']);
	}
	if(isset($_POST['update']) && $_POST['update']=="Update")
	{
		$UserDetailEdit=$EditUser->updateUserDetail($_POST['UserId'],$_POST['role'],$_POST['username'],$_POST['password'],$_POST['firstname'],$_POST['lastname'],$_POST['designation'],$_POST['email_id'],$_POST['mobile_no1'],$_POST['mobile_no2']);
		if($UserDetailEdit==1)
		{
			$msg = "Users has been updated successfully";
			///$url = "index.php?msg=$msg&alert=success&page=".$_POST['page'];
			header("location:index.php?msg=$msg&alert=success");
		}
		else
		{
			$msg='Error ?? try again Later';
			header("location:index.php?msg=$msg");
		}
		
	}
	
	//$states = $fetchState->getAllStates();
	$UserDetails = $FetchUser->getAllUsers();
	
	
	//print_r($HighcourtDetails);
 /*if(!isset($_GET['page'])){

	$appliThroughType = $fetchRecievedThrough->getAllReceivedThrough($limit,$start);
	$throughType = $fetchRecievedThroughType->getThroughType();
	$Records = $fetchRecievedThrough->getAllReceivedThroughCount();
	//echo $Records; exit;
	//$url = 'fromDate='.$_GET['fromDate'].'&toDate='.$_GET['toDate'].'&application_type='.$_GET['application_type'].'&through_type='.$_GET['through_type'].'&last_statge='.$_GET['last_statge'].'&state='.$_GET['state'];
	$url='';
	$paging = $pagination->paginations($page,$Records,$limit,$targetpage,$adjacents,$url);
} */
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<link href="../../css/pagination.css" rel="stylesheet">
		<script type="text/javascript" src="../../../js/masking/jquery-1.js"></script>
		<script type="text/javascript" src="../../../js/masking/jquery.js"></script>
			<script src="../../../js/dispatchValidation.js"></script>
		<script>
		function addApplicant()
		{	
			$("#addLegalAddApplication").show();
			$("#addLegalAddApplication1").hide();
		}
		function addApplicantHide()
		{	
			$("#addLegalAddApplication").hide();
			$("#addLegalAddApplication1").show();
		}

		window.onload=addApplicantHide;
		</script>
		<script type="text/javascript" src="./../../js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript">
	     $(document).ready(function() {
		   // alert('dssk');
		     $('#form1').submit(function(){
			     //alert('dsssssss');
					if($('#form1 #role').val()=='')
					{
						alert('Please select role');
						$('#form1 #role').focus();
						return false;
					}
					
					if($('#form1 #username').val()=='')
					{
						alert('Please Enter username');
						$('#form1 #username').focus();
						return false;
					}
					if($('#form1 #password').val()=='')
					{
						alert('Please Enter password');
						$('#form1 #password').focus();
						return false;
					}
			 });
		});
	   </script> 
<script type="text/javascript">
$(document).ready(function() {
	$("#email_id").keyup(function (e) {
	
		//removes spaces from username
		$(this).val($(this).val().replace(/\s/g, ''));
		
		var username = $(this).val();
		if(username.length < 4){$("#user-result").html('');return;}
		
		if(username.length >= 4){
			$("#user-result").html('<img src="../../../images/ajax-loader.gif" />');
			$.post('ajax/check_username.php', {'email_id':email_id}, function(data) {
			  $("#user-result").html(data);
			});
		}
	});	
});
</script>	
	</head>
	<body >
	<?php include_once $_SESSION['base_url'].'/include/header.php';?>
	    <div class="wrapper" >
			<div id="left-wrapper">	
				<?php include_once 'include/side-menu.php';?>
			</div>
			
			<div id="right-wrapper">
				<div id="breadcrumb">
	     			<ul>
	     				<li><a href="../index.php">Home &nbsp;&nbsp;&nbsp;/</a></li>
	     				<li><a href="#">User</a></li>
	     			</ul>
	     		</div>
	     	   	<div class="clear"></div>	  
	     	   	   	   	
		   <?php if(isset($_GET['msg']) && !isset($_GET['alert'])) {	?>		     	
	     	   	<div id="breadcrumb-red">	     	   	
	       <?php echo $_GET['msg'];?>		     			
	     		</div>	     		
	       <?php } if(isset($_GET['msg']) && isset($_GET['alert'])) {	 ?>	     		
	     	    <div id="breadcrumb-green">	     	   
	       <?php echo $_GET['msg']; ?>	     			
	     		</div>	     		
	       <?php } ?>	
	     		<?php if(isset($err) && $err != '')
	     			{	
	     		?>
	     		<div id="breadcrumb-red">
	     			<?php  echo $err; ?>
	     		</div>
	     		<?php 
	     			}
	     		?>
	     		<div class="clear"></div>
	     		<div id="breadcrumb" >
	     		<div style="padding-bottom:13px;"><a id="addLegalAddApplication1" class="form-button" onclick="addApplicant();">Add New</a></div>
	     			<div <?php if ($_GET['action'] != 'edit'){ ?>id="addLegalAddApplication" <?php }?> >
		     			<div class="title1" style="height:20px;">
		     				<div id="left-title">User Application</div>
		     				<div id="right-title"></div>
		     			</div>
		     			<form name="form1" id="form1" action="index.php" method="post" onsubmit="return validateHighCourtForm()">
		     			<div style="border:2px solid #4b8df8;padding:7px;height:420px;">
			     			
			     			<div style="width:60%;margin-left:10%;float:left;">
			     				
								<div class="clear"></div>
								<div class="left"> Role <span class="red">*</span></div>
								<div class="right">
									<select id="role" name="role">
										<option value="">Select Role</option>
										<option value="1" <?php if($FetchUserId['role_id']=='1') { echo "selected=selected"; } ?>>Dealing Assistant</option>
										<option value="2" <?php if($FetchUserId['role_id']=='2') { echo "selected=selected"; } ?>>Secratory</option>
										<option value="3" <?php if($FetchUserId['role_id']=='3') { echo "selected=selected"; } ?>>Admin</option>
										<option value="4" <?php if($FetchUserId['role_id']=='4') { echo "selected=selected"; } ?>>Super Admin</option>
			     					</select>
								</div>
								<div class="clear"></div>
								<div class="left"> User Name<span class="red">*</span></div>
								<div class="right">
									<input type="text" name="username" id="username" placeholder=" Enter Username " value="<?php if(isset($FetchUserId['user_name'])) { echo $FetchUserId['user_name']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> Paasword <span class="red">*</span></div>
								<div class="right">
									<input type="password" name="password" id="password" placeholder=" Enter Password" value="<?php if(isset($FetchUserId['password'])) { echo $FetchUserId['password']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> First Name</div>
								<div class="right">
									<input type="text" name="firstname" id="firstname" placeholder=" Enter Firstname " value="<?php if(isset($FetchUserId['first_name'])) { echo $FetchUserId['first_name']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> Last Name</div>
								<div class="right">
									<input type="text" name="lastname" id="lastname" placeholder=" Enter Lastname" value="<?php if(isset($FetchUserId['last_name'])) { echo $FetchUserId['last_name']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> Designation</div>
								<div class="right">
									<input type="text" name="designation" id="designation" placeholder=" Enter Designation" value="<?php if(isset($FetchUserId['designation'])) { echo $FetchUserId['designation']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> Email ID</div>
								<div class="right">
									<input type="text" name="email_id" id="email_id" placeholder=" Enter Email ID " value="<?php if(isset($FetchUserId['email_id'])) { echo $FetchUserId['email_id']; } else echo '';?>" />
								  <span id="user-result"></span>
								</div>
								<div class="clear"></div>
								<div class="left"> Mobile No.</div>
								<div class="right">
									<input type="text" name="mobile_no1" id="mobile_no1" placeholder=" Enter Contact Number1 "  maxlength="12" size="12" value="<?php if(isset($FetchUserId['contact_no_1'])) { echo $FetchUserId['contact_no_1']; } ?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> Other Contact No.</div>
								<div class="right">
									<input type="text" name="mobile_no2" id="mobile_no2" placeholder=" Enter Contact Number2 "  maxlength="12" size="12" value="<?php if(isset($FetchUserId['contact_no_2'])) { echo $FetchUserId['contact_no_2']; } ?>" />
								</div>
								
								<div class="clear"></div>
								<div class="left"></div>
								<div class="right">
								<?php if(isset($_GET['UserId']) && $_GET['action']=="edit"){?>
								<input type="hidden" name="UserId" value="<?php echo $_GET['UserId']; ?>" />
								<input type="hidden" name="page" value="<?php echo $_GET['page1']; ?>" />
								<input type="submit" name="update" value="Update" class="form-button" />&nbsp;
								<input type="submit" name="cancel" value="Cancel" class="form-button" />
								<?php }else {?>
									<input type="submit" name="submit" value="Submit" class="form-button" />
									<?php } ?>
								</div>
							</div>	
							<div id="right-title" style="float:right;"><div id="table"></div></div>
							<div class="clear"></div>
				     	</div>
				     	
				     	
				     
				     	</form>
				     	
				     </div>
				     
				     
				     </div>
			     	<div class="clear"></div>
			     	<div class="title1" style="height:20px;">
	     				<div id="left-title"> User List</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px;">
	     			<?php echo $paging;?>
		     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     					<th>Sr.No.</th>
			     					<th>Name</th>
			     					<th>Email_ID</th>			     					
			     					<th>Designation</th>
			     					<th>Edit</th>
			     					<th>Delete</th>
			     					
			     		
			     					
			     				</tr>
			     				<?php			     				
			     				
			     				
	     							for($i =0;$i<count($UserDetails);$i++)
									{
										
										
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
				     				<tr class="<?php echo $class; ?>">
				     					<td><?php if(isset($_GET['page']) && $_GET['page']>1) {  echo $recordCounter+$i+1; } else if(isset($_GET['page']) && $_GET['page']==1) echo $i+1; else echo $i+1; ?></td>
				     					<td width="10%"><?php echo $UserDetails[$i]['first_name'] .' '.$UserDetails[$i]['last_name'] ; ?></td>
				     					<td><?php echo $UserDetails[$i]['email_id']; ?></td>
				     					<td><?php echo $UserDetails[$i]['designation']; ?></td>				     					
				     					
				     					
				     					
				     					
				     					
				     					<td><a href="index.php?UserId=<?php echo $UserDetails[$i]['id']; ?>&action=edit">Edit</a></td>
				     					
				     				
				     					
				     					<td><a href="index.php?UserId=<?php echo $UserDetails[$i]['id']; ?>&action=delete">Delete</a></td>
				     					
				     				
				     					
				     				</tr>
	     						<?php 
	     						
									}
		     					?>
		     				</table>
			     		</div>
		     		</div>
	     		</div>
	     	</div> 
	     	
	     	<script type="text/javascript">
				jQuery(function($){
				//	$("#pincode").mask("999999", {placeholder: 'XXXXXX'});					
				//	$("#contact_number").mask("9999-999-9999", {placeholder: 'XXXX/XXX/XXXX'});
				});
			</script>
		
	   <script type="text/javascript" src="js/masking/ga.js"></script>
		<script type="text/javascript">
		    if (typeof(_gat)=='object')
		        setTimeout(function(){
		            try {
		                var pageTracker=_gat._getTracker("UA-10112390-1");
		                pageTracker._trackPageview()
		            } catch(err) {}
		        }, 1500);
		</script>
	</body>
</html>
			     	