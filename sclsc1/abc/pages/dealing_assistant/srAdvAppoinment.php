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
		<link href="<?php echo $_SESSION['base_file_url']; ?>css/style.css" rel="stylesheet" />
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
	     				<li><a href="index.php">Dashboard &nbsp;&nbsp;&nbsp;</a>/</li>
	     				<li><a href="#">Senior Advocate Appoinment</a></li>
	     			</ul>
	     		</div>
	     		<div class="clear"></div>
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Senior Advocate Appoinment</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px">
		     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     				<th width="13%"><a href="srAdvAppoinmentApplication.php">Sr. Advocate Appoinment </a></th>				     						
			     				<th width="13%"><a href="srAdvLetter.php">Letter generation for opinion</a></th>	     					
			     					<th width="10%"><a href="srAdvSendDispatch.php">Send for Dispatch</a></th>
			     					<th width="10%"><a href="srAdvToBeDispatched.php">To be Dispatched</a></th>
			     					<th width="10%"><a href="srAdvReplyAwaited.php">Reply Awaited</a></th>
			     					<th width="10%"><a href="srAdvReminderGenerated.php">Reminder to be Generated</a></th>			     						     							     					
			     				</tr>
			     		
			     		</table>
			     		</div>
			     		
		     		</div>
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
			</script>
	</body>
</html>
