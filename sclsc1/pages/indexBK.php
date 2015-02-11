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
		<div class="wrapper">	
			<div style="width:30%;margin:auto;padding-top:200px;">
				<ul class="unordered_list">
					<!--	<li><a href="admin/index.php">Admin</a></li>	 -->				
					<li><a href="advocate/index.php">Advocate</a></li>
					<li><a href="seniorAdvocate/index.php">Senior Advocate</a></li>
				 	<li><a href="translator/index.php">Transalator</a></li> 					
					<!-- <li><a href="diary/index.php">Diary</a></li> -->
					<li><a href="dealing_assistant/index.php">Dealing Assistant</a></li>
						<!--<li><a href="dispatch/index.php">Dispatcher</a></li> -->
				</ul>
			</div>
		</div>			
	</body>
</html>
