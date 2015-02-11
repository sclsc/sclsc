<?php 
	session_start();
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
	require_once $_SESSION['base_url'].'/classes/Implementation/Eligibility/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Eligibility/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Eligibility/Delete.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Eligibility/Edit.php';
	
	use classes\Implementation\Eligibility as impEligibility;
	
	$fetchEligibility= new impEligibility\Fetch();
	$addEligibility= new impEligibility\Add();
	$deletEligibility=new impEligibility\Delete();
	$editEligibility=new impEligibility\Edit();
	$msg='';
	$errmsg='';
	
	if(isset($_POST['submit']))
	{
		if(!empty($_POST['eligibility_condition_name']) && strlen($_POST['eligibility_condition_name']) > 50)
		{
			$err = "Please Enter Full Name less than 50 charactor".'<br/>';
				
		}
		else 
		{
			$checkFlag = $fetchEligibility->checkForDuplicateEligibilityCondition($_POST['eligibility_condition_name']);
			if($checkFlag != 1)
			{
				$flag = $addEligibility->addElegibilityCondition($_POST['eligibility_condition_name']);
				if($flag == 1)
				{
					$msg = "Elegibility Condition has been added successfully.";
					header("location:index.php?msg=$msg&alert=success");
				}
				else
				{
					$msg = "Some error occured";
					header("location:index.php?msg=$msg");
				}
			}
			else 
			{
				$msg = "Elegibility Condition Already Exist";
				header("location:index.php?msg=$msg");
			}
		}
	}
	$eligibiltyConditions = $fetchEligibility->getAllEligibilityCondition();
	//print_r($courts);
 	if(isset($_GET['applicationId']) && $_GET['action']=='del')
	{
		$diaryDel= $deletEligibility->delEleigibilityCondition($_GET['applicationId']);
		if($diaryDel==1)
		{
			$msg = "Elegibility Condition Deleted successfully.";
			header("location:index.php?msg=$msg&alert=success");
		}
		else
		{
			$msg='Error ?? try again Later';
			header("location:index.php?msg=$msg");
		}
	}
	
	if(isset($_POST['condition_id']) && $_POST['update']=='Update')
	{
		$checkFlag = $fetchEligibility->checkForDuplicateEligibilityCondition($_POST['eligibility_condition_name']);
		if($checkFlag!=1){
			
		$EligibilityEdit= $editEligibility->updateEligibityCondition($_POST['condition_id'],$_POST['eligibility_condition_name']);
		if($EligibilityEdit==1)
		{
			$msg = "Elegibility Condition Updated successfully.";
			header("location:index.php?msg=$msg&alert=success");
		}
		else
		{
			$msg='Error ?? try again Later';
			header("location:index.php?msg=$msg");
		}
	}
	else 
	{
			$msg="Elegibility Condition Already Exist";
			header("location:index.php?msg=$msg");
	}
} 
	
//	print_r($_SESSION['role_id']);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<link href="../../../css/pagination.css" rel="stylesheet">
		<script type="text/javascript" src="../../../js/masking/jquery-1.js"></script>
		<script type="text/javascript" src="../../../js/masking/jquery.js"></script>
		<script type="text/javascript">
		function validateForm() {
			var name = document.getElementById('eligibility_condition_name').value;
			
			if(name == '')
			{
				alert("Enter Eligibility Condition");
				return false;
			}
		}	
		</script>
		
		
	</head>
	<body >
		<?php include_once $_SESSION['base_url'].'/pages/admin/include/header.php'; ?>
	    <div class="wrapper" >
			<div id="left-wrapper">	
				<?php include_once 'include/side-menu.php';?>
			</div>
			
			<div id="right-wrapper">
				<div id="breadcrumb">
	     			<ul>
	     				<li><a href="../index.php">Home &nbsp;&nbsp;&nbsp;/</a></li>
	     				<li><a href="#">Eligibilty Condition</a></li>
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
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Add Eligibility Condition</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;height:120px;padding:7px ">
		     			<div style="width:60.0%;margin-left:10%">
		     				<form action="index.php" method="post" onsubmit="return validateForm()">
								<div class="clear"></div>
								<div class="left">Eligibility Condition <span class="red">*</span></div>
								<div class="right">
									<input type="text" id="eligibility_condition_name" placeholder=" Enter Eligibility Condition Name" name="eligibility_condition_name" />
								</div>
								<div class="clear"></div>
								<div class="left"></div>
								<div class="right">
									<input type="submit" class="form-button" name="submit" value="Submit" />
								</div>
							</form>
							</div>
						</div>
		     		</div>
		     		<div class="clear"></div>
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Eligibility Condition</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px;">
		     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     					<th width="2%" >Sr.No.</th>
			     					<th width="25%">Name</th>
			     					
			     				
			     					
			     					<th width="2%">Edit</th>
			     					
			     			
			     					
			     					<th width="2%">Delete</th>
			     					
			     				
			     					
			     				</tr>
			     				<?php
	     						
	     							for($i =0;$i<count($eligibiltyConditions);$i++)
									{
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
								<form method="POST" action="index.php" id="myForm" >
				     				<tr class="<?php echo $class; ?>" id="edit_<?php echo $i; ?>">
				     					<td><?php echo $i+1; ?></td>
				     					<td>
				     					<?php if(isset($_GET['applicationId']) && ($_GET['applicationId']==$eligibiltyConditions[$i]['id']) && ($_GET['action']=='edit')) { ?>		     						
				     					<input type="hidden" name="condition_id"  value="<?php echo $eligibiltyConditions[$i]['id']; ?>" >
				     					<input type="hidden" name="update"  value="Update" >
				     					<input type="text" name="eligibility_condition_name" id="eligibility_condition_name_<?php echo $eligibiltyConditions[$i]['id']; ?>"  value="<?php echo $eligibiltyConditions[$i]['eligibility_condition']; ?>" >
				     					
				     					
				     					<?php } else { echo $eligibiltyConditions[$i]['eligibility_condition']; } ?>		 	
				     				
				     		          </td>
				     		          
				     		        
				     		          
				     					<td>
				     					<?php if(isset($_GET['applicationId']) && ($_GET['applicationId']==$eligibiltyConditions[$i]['id']) && ($_GET['action']=='edit')) { ?>	
				     					<input type="submit" name="update" value="Update" />/<a href="index.php">Cancel</a><?php }else{?>
				     					<a href="index.php?applicationId=<?php echo $eligibiltyConditions[$i]['id']; ?>&action=edit#edit_<?php echo $i; ?>">Edit</a><?php }?>
				     					</td>
				     					
				     					
				     					
				     					<td><a href="index.php?applicationId=<?php echo $eligibiltyConditions[$i]['id']; ?>&action=del">Delete</a></td>
				     				
				     				
				     				
				     				</tr>
				     				</form>
	     						<?php 
									}
		     					?>
		     				</table>
			     		</div>
		     		</div>
	     		</div>
	     
	     	
		   <script type="text/javascript" src="js/masking/ga.js"></script>
	   	   <script type="text/javascript">
				
			   window.onload = function() {
				   
				   var action='<?php echo $_GET['action']?>';
				   var appId='<?php echo $_GET['applicationId']?>';
					var str='eligibility_condition_name_';
				   var id=str+appId;
				   
				  if(action=='edit')
					   document.getElementById(id).focus();
				  
		    		};
		    		
	   </script>
	   
	   <script type="text/javascript">
			   $(document).ready(function() {
				    $('form:first *:input[type!=hidden]:first').focus();
				});
	   </script>
	
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
function myFunction() {
    document.getElementById("myForm").submit();
}
</script>
	</body>
</html>
