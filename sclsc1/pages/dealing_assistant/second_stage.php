<?php 
	session_start();
	
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');

?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../css/styles.css">
		<link rel="stylesheet" href="../../css/pagination.css">
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
	     				<li><a href="index.php">Dashboard</a></li>
	     			</ul>
	     		</div>
	     		<div class="clear"></div>
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Recent Diary</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px">
		     			<div style="width:500px;margin:auto;">
		     				<a href="new_application.php?id=<?php echo $_GET['id']?>" class="form-button">New Application</a>
		     				
		     				<a href="document_under_application.php" class="form-button">Document Under Application</a>
		     			</div>		
			     	</div>				
						
	     		</div>
	     	</div>
	     </div>
	</body>
</html>
