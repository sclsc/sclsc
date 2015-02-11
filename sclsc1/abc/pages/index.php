<?php 
	session_start();
	
	if(!isset($_SESSION['user']['user_name']))
		header('location:../index.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../css/style.css" rel="stylesheet" />
	</head>
	<body >
				<div style="width:25%;float:right;padding-top:5px;height:100%;">
				<div style="height:30px;margin-bottom:5px;text-align:right">
				      <?php if(!isset($_SESSION['user']['user_name']))
				      {	
				      ?><a href="login.php" class="login-button">Login</a>
				      <?php 
				      }else 
				      {	
				      ?>
				      <a>Welcome <span style="color:blue"><?php echo $_SESSION['user']['user_name']; ?></span></a>&nbsp;<a href="../logout.php"><span style="color:red">Logout</span></a>
				      <?php 
				      }
				      ?>
				</div>
				
			</div>
		<div class="wrapper">	
			<div style="width:30%;margin:auto;padding-top:200px;">
				<ul class="unordered_list">							
					<li><a href="advocate/index.php">Advocate</a></li>
					<li><a href="seniorAdvocate/index.php">Senior Advocate</a></li>
				 	<li><a href="translator/index.php">Transalator</a></li> 	
					<li><a href="dealing_assistant/index.php">Dealing Assistant</a></li>						
				</ul>
			</div>
		</div>			
	</body>
</html>
