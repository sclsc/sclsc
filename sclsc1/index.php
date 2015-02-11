<?php 
	session_start();
	$_SESSION['base_url'] = $_SERVER['DOCUMENT_ROOT'].'/sclsc1';
	require_once  'classes/Implementation/Users/Fetch.php';
	use classes\Implementation\Users as IUser;
	$errmsg = '';
	
	if(isset($_POST['login']))
	{    
		$fetchUser = new IUser\Fetch();
		
		$userName = pg_escape_string($_POST['user_name']);
		$userPass = pg_escape_string($_POST['password']);
		$id = $fetchUser->verifyLogin($userName, $userPass);
		if($id != 0)
		{	
			$user = $fetchUser->getUserDetails($id);			
			$_SESSION['user']['id'] = $id;
			$_SESSION['user']['user_name'] = $user['user_name'];
			$_SESSION['user']['email_id'] = $user['email_id'];
			$_SESSION['user']['role_id'] = $user['role_id'];
			$_SESSION['base_url'] = $_SERVER['DOCUMENT_ROOT'].'/sclsc1';
			$_SESSION['base_file_url'] ='../../';
		//	echo $user['role_id']; exit;
			
			if (isset($user[role_id]) && $user[role_id]==1)
				header("location:pages/diary/index.php");
			elseif (isset($user[role_id]) && $user[role_id]==2)
				header("location:pages/dispatch/index.php");
			elseif (isset($user[role_id]) && $user[role_id]==3)
				header("location:pages/index.php");
			elseif (isset($user[role_id]) && $user[role_id]==4)
				header("location:pages/admin/index.php");
		}
		else 
			$errmsg = 'Login failed'; 
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="css/style.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
		<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
		<script type="text/javascript">
		window.onload = function(){
			document.getElementById("user_name").focus();
		};


		function validateForm()
		{	
			//alert('Hi');
			var form = document.user_login;
			
			if(form.user_name.value == "")
			{
			alert( "Please Enter User Name !!" );
			form.user_name.focus();
			return false;
			}
			if(form.password.value == "")
			{
			alert( "Please Enter Password !!" );
			form.password.focus();
			return false;
			}
					
				return true;
				 
			}
		
		</script>		
    </head>
	<body >
		<div style="width:450px; margin:auto">
		 <div class="wrapper" style="margin-top:100px;" >
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
	     			?>
	     		</div>
	     		<div class="clear"></div>
	     		<div id="form">
	     				<div class="title1" style="height:20px;">
		     				<div id="left-title">User Login</div>
		     				<div id="right-title" style="position:relative;margin:-4px 6px 0 0;">
		     				</div>
		     			</div>
		     			<form name="user_login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" onsubmit="return validateForm()">
		     				<div style="border:1px solid #4b8df8;background-color:#fff;padding:30px;">
			     				<table>
			     					<tr>
			     						<td align="right">Username</td>
			     						<td><div style="width:10px;"></div></td>
										<td><input type="text" name="user_name" id="user_name" placeholder="Enter User Name" /></td>
			     					</tr>
			     					<tr>
			     						<td><div class="clear"></div></td>
			     					</tr>
			     					<tr>
			     						<td align="right">Password</td>
										<td></td>
										<td><input type="password" name="password" id="password" placeholder="Password" /></td>
			     					</tr>
			     					<tr>
			     						<td></td>
			     						<td></td>
										<td><input class="login-form-button" type="submit" name="login" value="Login" /></td>
			     					</tr>
			     				</table>
			     				
			     			</div>
	     				</form>
	     		</div>
	    </div>
	    </div>
	</body>
</html>
