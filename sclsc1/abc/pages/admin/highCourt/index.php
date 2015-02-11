<?php 
	session_start();
	//error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
	require_once $_SESSION['base_url'].'/classes/Implementation/HighCourt/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/HighCourt/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/HighCourt/Edit.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/HighCourt/Delete.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/State/Fetch.php';

	//require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
	
	use classes\Implementation\HighCourt as impHighCourt;
	use classes\Implementation\State as impState;
	//use classes\Implementation\RecievedThroughType as impRecievedThroughType;
	use classes\Pagination as clsPagination;
	
	$addHigh = new impHighCourt\Add();
	$FetchHigh = new impHighCourt\Fetch();
	$EditHigh = new impHighCourt\Edit();
	$DeleteHigh = new impHighCourt\Delete();
	$fetchState = new impState\Fetch();
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
		$states = $fetchState->getAllStates();
		$appliThroughType = $fetchRecievedThrough->getAllReceivedThrough($limit,$start);
		$throughType = $fetchRecievedThroughType->getThroughType();
		$Records = $fetchRecievedThrough->getAllReceivedThroughCount();
		//echo $Records; exit;
		$url = 'fromDate='.$_GET['fromDate'].'&toDate='.$_GET['toDate'].'&application_type='.$_GET['application_type'].'&through_type='.$_GET['through_type'].'&last_statge='.$_GET['last_statge'].'&state='.$_GET['state'];
		//	$url='';
		$paging = $pagination->paginations($page,$Records,$limit,$targetpage,$adjacents,$url);
	
	}

	
	if(isset($_POST['submit']))
	{
		//print_r($_POST);exit;
		$hc_name   =  trim($_POST['hc_name']);
		$bench     =  trim($_POST['bench']);
		$email_id   =  trim($_POST['email_id']);
		$mobile_no   =  trim($_POST['mobile_no']);
		$hc_address1   =  trim($_POST['hc_address1']);
		$hc_address2   =  trim($_POST['hc_address2']);
		$city   =  trim($_POST['city']);
		$state   =  trim($_POST['state']);
		$pincode   =  trim($_POST['pincode']);
	
		$flag = $addHigh->addHighcourt(
					$hc_name,
					$bench,
					$email_id,
					$mobile_no,$hc_address1,$hc_address2,$city,$state,$pincode);
				
			if($flag == 1)
			{
				$msg = "Highcourt Name Add Successfully.";
				header("Location:index.php?msg=$msg&alert=success");
			}
			else
			{
				$errmsg = "Highcourt Name failed ?? Please try again Later.";
				header("Location:index.php?errmsg=$errmsg");
			}
	}
	if(isset($_GET['HighCourtId']) && $_GET['action']=="delete"){
		$DelHigh= $DeleteHigh->delHighCourt($_GET['HighCourtId']);
		if($DelHigh==1)
		{
			$msg = "High Court has been deleted successfully";
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
	if(isset($_GET['HighCourtId']) && $_GET['action']=="edit"){
	  $FetchHighCourtId= $FetchHigh->getHighCourtDetailId($_GET['HighCourtId']);
	//  print_r($FetchHighCourtId);
	}
	if(isset($_POST['update']) && $_POST['update']=="Update")
	{
		$HighCourtDetailEdit=$EditHigh->updateHighCourtDetail($_POST['HighCourtId'],$_POST['hc_name'],$_POST['bench'],$_POST['email_id'],$_POST['mobile_no'],$_POST['hc_address1'],$_POST['hc_address2'],$_POST['city'],$_POST['state'],$_POST['pincode']);
		if($HighCourtDetailEdit==1)
		{
			$msg = "High Court has been updated successfully";
			///$url = "index.php?msg=$msg&alert=success&page=".$_POST['page'];
			header("location:index.php?msg=$msg&alert=success");
		}
		else
		{
			$msg='Error ?? try again Later';
			header("location:index.php?msg=$msg");
		}
		
	}
	
	$states = $fetchState->getAllStates();
	$HighcourtDetails = $FetchHigh->getHighcourtDetails();
	
	
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
	     				<li><a href="#">High Court</a></li>
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
		     				<div id="left-title">High Court Application</div>
		     				<div id="right-title"></div>
		     			</div>
		     			<form name="form1" id="form1" action="index.php" method="post" onsubmit="return validateHighCourtForm()">
		     			<div style="border:2px solid #4b8df8;padding:7px;height:420px;">
			     			
			     			<div style="width:60%;margin-left:10%;float:left;">
			     				
								
								<div class="clear"></div>
								<div class="left"> High Court Name<span class="red">*</span></div>
								<div class="right">
									<input type="text" name="hc_name" id="hc_name" placeholder=" Enter High Court Name " value="<?php if(isset($FetchHighCourtId[0]['hc_name'])) { echo $FetchHighCourtId[0]['hc_name']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> Bench <span class="red">*</span></div>
								<div class="right">
									<input type="text" name="bench" id="bench" placeholder=" Enter Bench Name" value="<?php if(isset($FetchHighCourtId[0]['bench'])) { echo $FetchHighCourtId[0]['bench']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> Email ID<span class="red">*</span></div>
								<div class="right">
									<input type="text" name="email_id" id="email_id" placeholder=" Enter Email ID " value="<?php if(isset($FetchHighCourtId[0]['email_id'])) { echo $FetchHighCourtId[0]['email_id']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> Contact No.<span class="red">*</span></div>
								<div class="right">
									<input type="text" name="mobile_no" id="mobile_no" placeholder=" Enter Contact Number "  maxlength="12" size="12" value="<?php if(isset($FetchHighCourtId[0]['mobile_no'])) { echo $FetchHighCourtId[0]['mobile_no']; } ?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> Address <span class="red">*</span></div>
								<div class="right">
									<input type="text" name="hc_address1" id="hc_address1" placeholder=" Address Line1 " value="<?php if(isset($FetchHighCourtId[0]['hc_address1'])) { echo $FetchHighCourtId[0]['hc_address1']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> </div>
								<div class="right">
									<input type="text" name="hc_address2" id="hc_address2" placeholder=" Address Line2 " value="<?php if(isset($FetchHighCourtId[0]['hc_address2'])) { echo $FetchHighCourtId[0]['hc_address2']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> City <span class="red">*</span></div>
								<div class="right">
									<input type="text" name="city" id="city" placeholder=" City " value="<?php if(isset($FetchHighCourtId[0]['city'])) { echo $FetchHighCourtId[0]['city']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> State <span class="red">*</span></div>
								<div class="right">
									<select id="state" name="state">
										<option value="">Select State</option>
										<?php
			     						for($i =0;$i<count($states);$i++)
											{
										?>
			     							<option <?php if(isset($FetchHighCourtId[0]['state']) &&  $FetchHighCourtId[0]['state']==$states[$i]['id']){ ?> selected <?php }?>value="<?php echo $states[$i]['id']; ?>"><?php echo $states[$i]['state_name']; ?></option>
			     						<?php 
											}
			     						?>
									</select>
								</div>
								
								<div class="clear"></div>
								<div class="left"> Pincode</div>
								<div class="right">
									<input type="text" name="pincode" id="pincode" placeholder=" Pincode " value="<?php if(isset($FetchHighCourtId[0]['pincode'])) { echo $FetchHighCourtId[0]['pincode']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"></div>
								<div class="right">
								<?php if(isset($_GET['HighCourtId']) && $_GET['action']=="edit"){?>
								<input type="hidden" name="HighCourtId" value="<?php echo $_GET['HighCourtId']; ?>" />
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
	     				<div id="left-title"> High Court List</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px;">
	     			<?php echo $paging;?>
		     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     					<th>Sr.No.</th>
			     					<th>High Court Name</th>
			     					<th>Bench Name</th>
			     					<th>Email_ID</th>			     					
			     					<th>City</th>
			     					<th>Edit</th>
			     					<th>Delete</th>
			     					
			     		
			     					
			     				</tr>
			     				<?php			     				
			     				
			     				
	     							for($i =0;$i<count($HighcourtDetails);$i++)
									{
										
										
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
				     				<tr class="<?php echo $class; ?>">
				     					<td><?php if(isset($_GET['page']) && $_GET['page']>1) {  echo $recordCounter+$i+1; } else if(isset($_GET['page']) && $_GET['page']==1) echo $i+1; else echo $i+1; ?></td>
				     					<td><?php echo $HighcourtDetails[$i]['hc_name']; ?></td>
				     					<td><?php echo $HighcourtDetails[$i]['bench']; ?></td>
				     					<td><?php echo $HighcourtDetails[$i]['email_id']; ?></td>
				     					<td><?php echo $HighcourtDetails[$i]['city']; ?></td>				     					
				     					
				     					
				     					
				     					
				     					
				     					<td><a href="index.php?HighCourtId=<?php echo $HighcourtDetails[$i]['id']; ?>&action=edit">Edit</a></td>
				     					
				     				
				     					
				     					<td><a href="index.php?HighCourtId=<?php echo $HighcourtDetails[$i]['id']; ?>&action=delete">Delete</a></td>
				     					
				     				
				     					
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
			     	