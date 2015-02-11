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
	     				<li><a href="index.php">Dashboard &nbsp;&nbsp;&nbsp;&nbsp;</a>/</li>
	     				<li><a href="#">Closing of file &nbsp;&nbsp;&nbsp;&nbsp;</a></li>
	     			</ul>
	     		</div>
	     		<div class="clear"></div>
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Pending for Closing of File</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px">
		     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">		
			     					<th width="10%"><a href="cof.php">MIsc. File </a></th>	
			     					<th width="10%"><a href="#">Non Prosecution File</a></th>
			     					<th width="10%"><a href="#">Non Eligibility File</a></th>
			     								     						     							     					
			     				</tr>
			     				
			     				<tr width="100%">		
			     					<th width="10%"><a href="lscOpinion.php">LSC Opinion</a></th>
			     					<th width="20%"><a href="documentReturnLetter.php">Letter to be Generated for Document Return </a></th>
			     					<th width="20%"><a href="docReturnSendDispatch.php">Send for Dispatch (Document Return)</a></th>
			     					<th width="15%"><a href="docReturnToBeDispatched.php">Dispatched (Document Return)</a></th>
			     					<th width="10%"><a href="miscDocDispatched.php">To be Closed</a></th>			     						     							     					
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
