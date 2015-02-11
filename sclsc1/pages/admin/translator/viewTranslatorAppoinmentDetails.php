<?php 
	session_start();
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');

	$msg = '';
	$errmsg = '';
	$abc=0;
	
	 require_once $_SESSION['base_url'].'/classes/Implementation/Translator/Fetch.php';

	
	use classes\Implementation\Translator as impTranslator;	
	
	$fetchTranslator = new impTranslator\Fetch();

		 $allTranslator = $fetchTranslator->singleTranslatorOnPannel($_GET['translatorId']);	

//print_r($alladvocate);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<link rel="stylesheet" href="../../../css/styles.css">
		<script src="../../../js/jquery.min.js"></script>
		<script src="../../../js/masking/jquery-1.js"></script>
		<script src="../../../js/masking/jquery.js"></script>
		<script src="../../../js/validation.js"></script>	
		<link href="../../../css/pagination.css" rel="stylesheet">

	</head>
	<body >
	<?php include_once 'include/header.php';?>
	    <div class="wrapper" >
			<div id="left-wrapper">	
				<?php include_once 'include/side-menu.php';?>
			</div>
			<div id="right-wrapper">
				<div id="breadcrumb">
	     			<ul>
	     				<li><a href="#">Home </a></li>
	     				<li><div class="right-title" style="color:#1D8CD6"><?php echo date('l jS \of F Y h:i:s A'); ?></div></li>
	     				
	     			</ul>
	     		</div>
	     		<div class="clear"></div>
	     			     		
	     		<div class="clear"></div>
	     		<?php if(isset($_GET['msg']) && $_GET['msg']!='')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-green" align="center">
	     			<?php echo $_GET['msg'];?>	
	     		</div>
	     		<?php 
	     		}
	     		if(isset($_GET['errmsg']) && $_GET['errmsg']!='')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-red" align="center">
	     			<?php echo $_GET['errmsg'];?>	
	     		</div>
	     		<?php 
	     		}
	     										
				if ($errmsg != "")
					echo '<div class="errmsg" align="center">' . $errmsg . '</div>';
				
				elseif ($msg != "")
					echo '<div class="msg" align="center">' . $msg . '</div>';
				?>
	     		<div class="clear"></div>
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">Translator Appointmented Applications</div>
     				<!-- <div class="right-title"><a href="advocate_registration.php" class="login-button" style="font-size: 16px;">Add New Advocate</a></div> -->
	     		</div>				
	  		<div class="clear"></div>	
	     			<div style="border:2px solid #4b8df8;padding:7px;">
		     			<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     			<tr width="100%">
	     					<th width="6%">Sr. No.</th>
	     					<th width="15%"> Name</th>
	     					<th width="14%"> Code</th>
	     					<th width="15%">Email Id</th>
	     					<th width="15%">Mobile No</th>	     					
	     					<th width="15%">Date of Appointment</th>
	     					<th width="15%">Application No.</th>	     					
	     					
	     				</tr>	
     				       <?php 			
     						for($i =0;$i<count($allTranslator);$i++)
								{										
							$class = ($i % 2 == 0) ? 'even' : 'odd';
							?>
				     		<tr class="<?php echo $class; ?>">
	     					<td><?php echo $i+1; ?></td>	     					
	     					 <td><?php echo $allTranslator[$i]['translator_name']; ?></td>
	     					 <td><?php echo $allTranslator[$i]['medium_code']; ?></td>
	     					<td><?php echo $allTranslator[$i]['email_id']; ?></td>
	     					<td><?php echo $allTranslator[$i]['contactno1']; ?></td>
                            <td><?php if ($allTranslator[$i]['appointment_date']!='') echo date("d-m-Y", strtotime($allTranslator[$i]['appointment_date'])); ?></td>
                            <td><?php echo $allTranslator[$i]['diary_no']; ?></td>
	     				</tr>    						
		     					
		     			     	<?php 
									}									
								//	 echo $pagination;
		     					?>
		     					
		     				</table>
			     		</div>
			     		<div class="right-title" ><button onclick="goBack()">Go Back</button></div>
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
<script>
function goBack() {
    window.history.back()
}
</script>
	</body>
</html>
