<?php 
	session_start();
//	error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
	
	require_once $_SESSION['base_url'].'/classes/Implementation/Users/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Users/Edit.php';

	
	
	use classes\Implementation\Users as impUsers;
	
	$FetchUser = new impUsers\Fetch();
	$EditUser  = new impUsers\Edit();

	
	$msg='';
	$errmsg='';
	
	if(isset($_POST['submit']))
	{//echo 'dhskfjkd';die;
		$user  	=  (int) trim($_POST['user']);
		$password     =  trim($_POST['password']);
		$changpassword     =  trim($_POST['changpassword']);
	
		$flag = $EditUser->changepassword($user,$password);
			if($flag == 1)
			{
				$msg = "Password has updated Successfully.";
				header("Location:changepassword.php?msg=$msg&alert=success");
			}
			else
			{
				$errmsg = "Password falied ?? Please try again Later.";
				header("Location:changepassword.php?errmsg=$errmsg");
			}
		
		
	}
	
	$UserDetails = $FetchUser->getAllUsers();
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
		<script type="text/javascript" src="./../../js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript">
	     $(document).ready(function() {
		 
		     $('#form1').submit(function(){

		    	 if($('#form1 #user').val()=='')
					{
						alert('Please Select User');
						$('#form1 #user').focus();
						return false;
					}
					if($('#form1 #password').val()=='')
					{
						alert('Please Enter New Password');
						$('#form1 #password').focus();
						return false;
					}
					
					if($('#form1 #changpassword').val()=='')
					{
						alert('Please Enter Change Password');
						$('#form1 #changpassword').focus();
						return false;
					}
					if($('#form1 #password').val()!=$('#form1 #changpassword').val())
					{
						alert('Password does not match');
						//$('#form1 #password').value="";
						//$('#form1 #changpassword').value="";
						$('#form1 #password').focus();
						$('#form1 #changpassword').focus();
						return false;
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
	     				<li><a href="../changepassword.php">Change Password</a></li>
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
	     		
	     			<div  >
		     			<div class="title1" style="height:20px;">
		     				<div id="left-title">Change Password</div>
		     				<div id="right-title"></div>
		     			</div>
		     			<form name="form1" id="form1"  method="post" >
		     			<div style="border:2px solid #4b8df8;padding:7px;height:420px;">
			     			
			     			<div style="width:60%;margin-left:10%;float:left;">
			     				
								<div class="clear"></div>
								<div class="left"> Users </div>
								<div class="right">
									<select id="user" name="user">
										<option value="">Select User</option>
										<?php
									for($i = 0; $i < count ($UserDetails); $i ++) {
										?>
										<option value="<?php echo $UserDetails[$i]['id']; ?>" ><?php echo $UserDetails[$i]['user_name'].'('.$UserDetails[$i]['designation'].')'; ?></option>
									<?php
									}
									?>
									</select>
								</div>
								<div class="clear"></div>
								<div class="left">New Password <span class="red">*</span></div>
								<div class="right">
									<input type="password" name="password" id="password" placeholder=" Enter New Password"  />
								</div>
								<div class="clear"></div>
								<div class="left">Confirm Password <span class="red">*</span></div>
								<div class="right">
									<input type="password" name="changpassword" id="changpassword" placeholder=" Enter Confirm Password" />
								</div>
								
								<div class="clear"></div>
								<div class="left"></div>
								<div class="right">
								
									<input type="submit" name="submit" value="Submit" class="form-button" />
									
								</div>
							</div>	
							<div id="right-title" style="float:right;"><div id="table"></div></div>
							<div class="clear"></div>
				     	</div>
				     	
				     	
				     
				     	</form>
				     	
				     </div>
				     
				     
				     </div>
			     </div>
	     		</div>
	</body>
</html>
			     	