<?php 
	session_start();	
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
	require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThrough/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThrough/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThrough/Delete.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThrough/Edit.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/State/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThroughType/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
	
	use classes\Implementation\RecievedThrough as impRecievedThrough;
	use classes\Implementation\State as impState;
	use classes\Implementation\RecievedThroughType as impRecievedThroughType;
	use classes\Pagination as clsPagination;
	
	$addRecievedThrough = new impRecievedThrough\Add();
	$fetchRecievedThrough = new impRecievedThrough\Fetch();
	$fetchState = new impState\Fetch();
	$fetchRecievedThroughType = new impRecievedThroughType\Fetch();
	$pagination = new clsPagination\Pagination();
	$delRecievedThrough=new impRecievedThrough\Delete();
	$editRecievedThrough=new impRecievedThrough\Edit();
	
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
		if(!empty($_POST['appli_through_type_name']) && strlen($_POST['appli_through_type_name'])>50)
		{
			$err = "Please Enter Full Name less than 50 charactor".'<br/>';
			$f=1;
		}
		if(!empty($_POST['city']) && strlen($_POST['city'])>50)
		{
			$err = "Please Enter Full Name less than 50 charactor".'<br/>';
			$f=1;
		}
		if($f==0)
		{
			$checkFlag = $fetchRecievedThrough->checkThrough($_POST['appli_through_type_name']);
			if($checkFlag != 1)
			{
				$flag = $addRecievedThrough->addReceivedThrough($_POST['received_through_type'],$_POST['designation'],$_POST['appli_through_type_name'],$_POST['email_id'],$_POST['contact_number'],$_POST['address_line1'],$_POST['address_line2'],$_POST['city'],$_POST['state'],$_POST['pincode']);
				if($flag == 1)
				{
					$msg = "Through type has been added successfully";
					header("location:index.php?msg=$msg&alert=success");
				}
				else
				{
					$msg = "Some error occured!";
					header("location:index.php?msg=$msg");
				}
			}
			else
			{
				$msg = "Already Exist";
				header("location:index.php?msg=$msg");
			}	
		}
		
	}

	
	
	if(isset($_GET['applicationId']) && $_GET['action']=="delete"){
		$RecievedThroughDel= $delRecievedThrough->delRecievedThrough($_GET['applicationId']);
		if($RecievedThroughDel==1)
		{
			$msg = "Through type has been deleted successfully";
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
	if(isset($_GET['applicationId']) && $_GET['action']=="edit"){
		$through= $fetchRecievedThrough->getThrough($_GET['applicationId']);
	}
	if(isset($_POST['update']) && $_POST['update']=="Update"){
		$RecievedThroughEdit=$editRecievedThrough->updateRecievedThrough($_POST['id'],$_POST['received_through_type'],$_POST['designation'],$_POST['appli_through_type_name'],$_POST['email_id'],$_POST['contact_number'],$_POST['address_line1'],$_POST['address_line2'],$_POST['city'],$_POST['state'],$_POST['pincode']);
		if($RecievedThroughEdit==1)
		{
			$msg = "Recieved Through has been updated successfully";
			///$url = "index.php?msg=$msg&alert=success&page=".$_POST['page'];
			header("index.php?msg=$msg&alert=success");
		}
		else
		{
			$msg='Error ?? try again Later';
			header("location:index.php?msg=$msg");
		}
		
	}
	
 if(!isset($_GET['page'])){
	$states = $fetchState->getAllStates();
	$appliThroughType = $fetchRecievedThrough->getAllReceivedThrough($limit,$start);
	$throughType = $fetchRecievedThroughType->getThroughType();
	$Records = $fetchRecievedThrough->getAllReceivedThroughCount();
	//echo $Records; exit;
	//$url = 'fromDate='.$_GET['fromDate'].'&toDate='.$_GET['toDate'].'&application_type='.$_GET['application_type'].'&through_type='.$_GET['through_type'].'&last_statge='.$_GET['last_statge'].'&state='.$_GET['state'];
	$url='';
	$paging = $pagination->paginations($page,$Records,$limit,$targetpage,$adjacents,$url);
} 
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
			<script src="../../../js/validation.js"></script>
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
		<script type="text/javascript">
		$(document).ready(function(){
			$('#state').change(function(){
				
				if($('#received_through_type').val()!='' && $('#state').val()!=''){
					$.ajax({
						type:'POST',
						url:'ajax/throughTypeName.php?throughTypeId='+$('#received_through_type').val()+'&state='+$('#state').val()+'&throughTypeName='+$('#received_through_type option:selected').text(),
						success:function(result){
							$('#table').html(result);
	
							}
	
					});
				}
			});
			$('#received_through_type').change(function(){
						
						if($('#received_through_type').val()!='' && $('#state').val()!=''){
							$.ajax({
								type:'POST',
								url:'ajax/throughTypeName.php?throughTypeId='+$('#received_through_type').val()+'&state='+$('#state').val()+'&throughTypeName='+$('#received_through_type option:selected').text(),
								success:function(result){
									$('#table').html(result);
			
									}
			
							});
						}
					});
			
			$('#appli_through_type_name').keyup(function(){
						
						if($('#received_through_type').val()!='' && $('#state').val()!=''){
							$.ajax({
								type:'POST',
								url:'ajax/throughTypeName.php?throughTypeId='+$('#received_through_type').val()+'&state='+$('#state').val()+'&throughTypeName='+$('#received_through_type option:selected').text()+'&name='+$('#appli_through_type_name').val(),
								success:function(result){
									$('#table').html(result);
			
									}
			
							});
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
	     				<li><a href="#">Application Through</a></li>
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
		     				<div id="left-title">Legal Aid Application Through</div>
		     				<div id="right-title"></div>
		     			</div>
		     			<form name="form1" id="form1" action="index.php" method="post" onsubmit="return validateAppThroughForm()">
		     			<div style="border:2px solid #4b8df8;padding:7px;height:420px;">
			     			
			     			<div style="width:60%;margin-left:10%;float:left;">
			     				<div class="clear"></div>
								<div class="left"> Through Type <span class="red">*</span></div>
								<div class="right">
									<select name="received_through_type" id="received_through_type">
										<option value="">Select</option>
										<?php
			     						for($i =0;$i<count($throughType);$i++)
											{
										?>
			     							<option <?php if(isset($through[0]['appli_through_type_id']) && $through[0]['appli_through_type_id']== $throughType[$i]['id']){?> selected <?php }?>value="<?php echo $throughType[$i]['id']; ?>"><?php echo $throughType[$i]['appli_through_type_name']; ?></option>
			     						<?php 
											}
			     						?>		
									</select> 
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
			     							<option <?php if(isset($through[0]['state']) &&  $through[0]['state']==$states[$i]['id']){ ?> selected <?php }?>value="<?php echo $states[$i]['id']; ?>"><?php echo $states[$i]['state_name']; ?></option>
			     						<?php 
											}
			     						?>
									</select>
								</div>
								<div class="clear"></div>
								<div class="left"> Addressee Designation<span class="red">*</span></div>
								<div class="right">
									<input type="text" name="designation" id="designation" placeholder=" Enter Designation " value="<?php if(isset($through[0]['designation'])) { echo $through[0]['designation']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> Name <span class="red">*</span></div>
								<div class="right">
									<input type="text" name="appli_through_type_name" id="appli_through_type_name" placeholder=" Application Through Name " value="<?php if(isset($through[0]['appli_through_name'])) { echo $through[0]['appli_through_name']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> Email ID</div>
								<div class="right">
									<input type="text" name="email_id" id="email_id" placeholder=" Enter Email ID " value="<?php if(isset($through[0]['email_id'])) { echo $through[0]['email_id']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> Contact No.</div>
								<div class="right">
									<input type="text" name="contact_number" id="contact_number" placeholder=" Enter Contact Number "  maxlength="12" size="12" value="<?php if(isset($through[0]['contact_no'])) { echo $through[0]['contact_no']; } ?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> Address </div>
								<div class="right">
									<input type="text" name="address_line1" id="address_line1" placeholder=" Address Line1 " value="<?php if(isset($through[0]['address_line1'])) { echo $through[0]['address_line1']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> </div>
								<div class="right">
									<input type="text" name="address_line2" id="address_line2" placeholder=" Address Line2 " value="<?php if(isset($through[0]['address_line2'])) { echo $through[0]['address_line2']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"> City <span class="red">*</span></div>
								<div class="right">
									<input type="text" name="city" id="city" placeholder=" City " value="<?php if(isset($through[0]['city'])) { echo $through[0]['city']; } else echo '';?>" />
								</div>
								
								<div class="clear"></div>
								<div class="left"> Pincode</div>
								<div class="right">
									<input type="text" name="pincode" id="pincode" placeholder=" Pincode " value="<?php if(isset($through[0]['pincode'])) { echo $through[0]['pincode']; } else echo '';?>" />
								</div>
								<div class="clear"></div>
								<div class="left"></div>
								<div class="right">
								<?php if(isset($_GET['applicationId']) && $_GET['action']=="edit"){?>
								<input type="hidden" name="id" value="<?php echo $through[0]['id']; ?>" />
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
	     				<div id="left-title"> Application Through List</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px;">
	     			<?php echo $paging;?>
		     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     					<th>Sr.No.</th>
			     					<th>Through Type</th>
			     					<th>Designation</th>
			     					<th>Through Name</th>			     					
			     					<th>Contact Details</th>			     					
			     					<th>State</th>
			     					
    						
			     					
			     					<th>Edit</th>
			     					
			     		
			     					
			     					<th>Delete</th>
			     					
			     		
			     					
			     				</tr>
			     				<?php			     				
			     				$address_line1=$address_line2=$city=$state=$pincode=$contact_no=$email_id='';
			     				
	     							for($i =0;$i<count($appliThroughType);$i++)
									{
										if(isset($appliThroughType[$i]['address_line1']) && $appliThroughType[$i]['address_line1']!='')
										{
											$address_line1=$appliThroughType[$i]['address_line1'].',';
										}
										if(isset($appliThroughType[$i]['address_line2']) && $appliThroughType[$i]['address_line2']!='')
										{
											$address_line2=$appliThroughType[$i]['address_line2'].',';
										}
										if(isset($appliThroughType[$i]['city']) && $appliThroughType[$i]['city']!='')
										{
											$city=$appliThroughType[$i]['city'];
										}
									/*	if(isset($appliThroughType[$i]['state']) && $appliThroughType[$i]['state']!='')
										{
											$state=$appliThroughType[$i]['state'];
										}*/
										if(isset($appliThroughType[$i]['pincode']) && $appliThroughType[$i]['pincode']!='')
										{
											$pincode=','.$appliThroughType[$i]['pincode'];
										}
										
										if(isset($appliThroughType[$i]['contact_no']) && $appliThroughType[$i]['contact_no']!='')
										{
											$contact_no='</br><b> Contact No.- </b>'.$appliThroughType[$i]['contact_no'];
										}
										if(isset($appliThroughType[$i]['email_id']) && $appliThroughType[$i]['email_id']!='')
										{
											$email_id='</br><b> Email ID- </b>'.$appliThroughType[$i]['email_id'];
										}
										
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
				     				<tr class="<?php echo $class; ?>">
				     					<td><?php if(isset($_GET['page']) && $_GET['page']>1) {  echo $recordCounter+$i+1; } else if(isset($_GET['page']) && $_GET['page']==1) echo $i+1; else echo $i+1; ?></td>
				     					<td><?php echo $appliThroughType[$i]['through_type']; ?></td>
				     					<td><?php echo $appliThroughType[$i]['designation']; ?></td>
				     					<td><?php echo $appliThroughType[$i]['appli_through_name']; ?></td>				     					
				     					<td><?php echo $address_line1.$address_line2.$city.$pincode.$contact_no.$email_id; ?></td>
				     					<td><?php echo $appliThroughType[$i]['state']; ?></td>
				     					
				     					
				     					
				     					<td><a href="index.php?applicationId=<?php echo $appliThroughType[$i]['id']; ?>&action=edit">Edit</a></td>
				     					
				     				
				     					
				     					<td><a href="index.php?applicationId=<?php echo $appliThroughType[$i]['id']; ?>&action=delete">Delete</a></td>
				     					
				     				
				     					
				     				</tr>
	     						<?php 
	     						$address_line1=$address_line2=$city=$state=$pincode=$contact_no=$email_id='';
									}
		     					?>
		     				</table>
			     		</div>
		     		</div>
	     		</div>
	     	</div> 
	     	
	     	<script type="text/javascript">
				jQuery(function($){
					$("#pincode").mask("999999", {placeholder: 'XXXXXX'});					
				//	$("#contact_number").mask("9999-999-9999", {placeholder: 'XXXX/XXX/XXXX'});
				});
			</script>
			 <script type="text/javascript">
	   $(document).ready(function() {
		    $('form:first *:input[type!=hidden]:first').focus();
		    $('#form1').submit(function(){
					if($('#form1 #received_through_type').val()=='')
					{
						alert('Please Select ');
						$('#form1 #received_through_type').focus();
						return false;
					}
					if($('#form1 #state').val()=='')
					{
						alert('Please Select ');
						$('#form1 #state').focus();
						return false;
					}
					
					if($('#form1 #designation').val()=='')
					{
						alert('Please Enter Designation ');
						$('#form1 #designation').focus();
						return false;
					}
					if($('#form1 #appli_through_type_name').val()=='')
					{
						alert('Please Enter Name ');
						$('#form1 #appli_through_type_name').focus();
						return false;
					}
					if($('#form1 #city').val()=='')
					{
						alert('Please Enter City ');
						$('#form1 #city').focus();
						return false;
					}
			    });
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
			     	