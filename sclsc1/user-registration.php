<?php 
	session_start();
	$msg = '';
	$errmsg = '';
	require_once 'classes/Implementation/Users/Add.php';
	require_once 'classes/Implementation/Misc/Fetch.php';
	
	use classes\Implementation\Users as IUser;
	use classes\Implementation\Misc as IMisc;
	
	$fetchMisc = new impMisc\Fetch();
	
	if(isset($_POST['addUser']))
	{
		$addUser = new IUser\Add();
		$reg_flag = $addUser->registerUser($_POST['userName'],
			$_POST['password'],
			$_POST['firstName'],
			$_POST['lastName'],
			$_POST['designation'],
			$_POST['contactNumber1'],
			$_POST['contactNumber2'],
			$_POST['emailId'],
			$_POST['role']);
		if($reg_flag == 1)
			$msg = "User has been registered successfully.";
		else 
			$errmsg = 'User Registration failed';
	}
	
	$roleIds = $fetchMisc->getRole();
//print_r($roleIds);
	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="css/style.css" rel="stylesheet" />
	</head>
	<body>
	<?php include_once 'include/header.php';?>
	    <div class="wrapper">
			<div id="left-wrapper">	
				<?php // include_once 'include/side-menu.php';?>
			</div>
			<div id="right-wrapper">
				
				<div id="breadcrumb">
	     			<?php
	     				 if($errmsg != '')
	     				 {
	     			?>
	     				<div class="errmsg">
	     			<?php 
	     					echo $errmsg;
	     			?>
	     				</div>
	     			<?php 
	     				 }
	     				 if($msg != '')
	     				 {
	     			?>
	     				<div class="msg">
	     			<?php 
	     				 	echo $msg." <a href='login.php'>Login</a> to contiue";	
	     			?>
	     				</div>
	     			<?php 
	     				 }
	     			?>
	     		</div>
	     		<div class="clear"></div>
	     		<div id="form">
	     				<div class="title1" style="height:20px;">
		     				<div id="left-title">User Registration</div>
		     				<div id="right-title"></div>
		     			</div>
		     			<form action="user-registration.php" method="post">
		     			<div style="border:1px solid #4b8df8;background-color:#fff;height:230px;">
			     			<div style="width:50%;float:left;">
		     					<div class="clear"></div>
		     					<div class="left"> User Name *</div>
			     				<div class="right"><input type="text" id="userName" name="userName" placeholder="User Name"/></div>
			     				<div class="clear"></div>
			     				<div class="left"> 	Password *</div>
			     				<div class="right"><input type="password" name="password" placeholder="Password" /></div>
			     				<div class="clear"></div>
			     				<div class="left"> First Name *</div>
			     				<div class="right"><input type="text" name="firstName" placeholder="First Name" id="firstName" /></div>
			     				<div class="clear"></div>
			     				<div class="left"> Last Name *</div>
			     				<div class="right"><input type="text" name="lastName" placeholder="Last Name" id="lastName" /></div>
			     				<div class="clear"></div>
			     				<div class="left"> Role *</div>
			     				<div class="right">
			     					<select name="role" >
			     						<option value="">Select</option>
										<?php for($i = 0; $i < count($roleIds); $i++)
										{
										?>
										<option value="<?php echo $roleIds[$i]['id']; ?>"><?php echo $roleIds[$i]['role_name']; ?></option>
										<?php 
										}
										?>
									</select>
			     				</div>
			     			</div>
			     			<div style="width:50%;float:right;">
			     				<div class="clear"></div>
			     				<div class="left"> Email ID *</div>
			     				<div class="right"><input type="text" name="emailId" placeholder="mailId" id="mailId" /></div>
			     				<div class="clear"></div>
			     				<div class="left"> Contact Number 1 *</div>
			     				<div class="right"><input type="text" name="contactNumber1" placeholder="Contact NUmber 1" id="contactNUmber1" /></div>
			     				<div class="clear"></div>
		     					<div class="left"> 	Contact Number 2 </div>
		     					<div class="right"><input type="text" name="contactNumber2" placeholder="contactNumber 2" id="contactNUmber2" /></div>
		     					<div class="clear"></div>
			     				<div class="left"> Designation *</div>
			     				<div class="right"><input type="text" name="designation" placeholder="designation" /></div>
		     					<div class="clear"></div>
			     				<div class="left"> </div>
			     				<div class="right"><input type="submit" name="addUser" value="Add User" class="form-button" /></div>
			     			</div>
		     			</div>
	     			</form>
	     		</div>
	     	</div>
	    </div>
	    <div class="clear"></div>
	    <div style="height:150px;"></div>
	    <div id="footer" style="height:40px;background-color:#333">
	</body>
</html>
