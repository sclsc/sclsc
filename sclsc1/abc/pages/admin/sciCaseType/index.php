<?php 
	session_start();
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
	require_once $_SESSION['base_url'].'/classes/Implementation/SciCaseType/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/SciCaseType/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/SciCaseType/Delete.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/SciCaseType/Edit.php';
	
	use classes\Implementation\SciCaseType as impSciCaseType;
	
	$fetchSciCaseType = new impSciCaseType\Fetch();
	$addSciCaseType = new impSciCaseType\Add();
	$deleteSciCaseType=new impSciCaseType\Delete();
	$editSciCaseType=new impSciCaseType\Edit();
	$msg='';
	$errmsg='';
	
	if(isset($_POST['submit']))
	{
		if(!empty($_POST['case_name']) || str_len($_POST['case_name'])>50)
		{
			$err = "Please Enter Full Name less than 50 charactor".'<br/>';
		}
		else 
		{
			$checkFlag = $fetchSciCaseType->checkScCaseType($_POST['case_name']);
			if($checkFlag != 1)
			{
				$flag = $addSciCaseType->addScCaseType($_POST['case_name']);
			
				if($flag == 1)
				{
					$msg = "SCI Case Type has been added successfully.";
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
				$msg = "SCI Case Type Already Exist";
				header("location:index.php?msg=$msg");
			}
		}
	}
		
	
	if(isset($_GET['applicationId']) && $_GET['action']=='del')
		{
			$SciCaseTypeDel= $deleteSciCaseType->delScCaseType($_GET['applicationId']);
			if($SciCaseTypeDel==1)
			{
				$msg = "SCI Case Type has been deleted successfully.";
				header("location:index.php?msg=$msg&alert=success");
			}
			else
			{
				$msg='Error ?? try again Later';
				header("location:index.php?msg=$msg");
			}
		}
	
	if(isset($_POST['edit_case_type_id']) && $_POST['update']=='Update')
	{
	
		$checkFlag = $fetchSciCaseType->checkScCaseType($_POST['edit_case_type_name']);
		if($checkFlag != 1)
		{
		$SciCaseTypeEdit= $editSciCaseType->updateScCaseType($_POST['edit_case_type_id'],$_POST['edit_case_type_name']);
		print_r($_REQUEST);
		if($SciCaseTypeEdit == 1)
		{			
	        $msg = "SCI Case Type has been updated successfully";	
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
			$msg='SCI Case Type Already Exist';
			header("location:index.php?msg=$msg");
		}
	}
	
	$caseTypes = $fetchSciCaseType->getAllScCaseType();

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
			var name = document.getElementById('case_name').value;
			
			if(name == '')
			{
				alert("Enter Case Name");
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
	     				<li><a href="#">SCI Case Type</a></li>
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
	     				<div id="left-title">Add SCI Case Type</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;height:120px;padding:7px ">
		     			<div style="width:60.0%;margin-left:10%">
		     				<form action="index.php" method="post" onsubmit="return validateForm()">
								<div class="clear"></div>
								<div class="left"> Name <span class="red">*</span></div>
								<div class="right">
									<input type="text" id="case_name" placeholder=" Enter SC Case Type Name" name="case_name" />
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
	     				<div id="left-title">SCI Case Type List</div>
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
	     						
	     							for($i =0;$i<count($caseTypes);$i++)
									{
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
								<form method="POST" action="index.php" id="myForm">
				     				<tr class="<?php echo $class; ?>">
				     					<td><?php echo $i+1; ?></td>
				     					<td>
				     					<?php if(isset($_GET['applicationId']) && ($_GET['applicationId']==$caseTypes[$i]['id']) && ($_GET['action']=='edit')) { ?>		     						
				     					<input type="hidden" name="edit_case_type_id"  value="<?php echo $caseTypes[$i]['id']; ?>" >
				     					<input type="hidden" name="update"  value="Update" >
				     					<input type="text" name="edit_case_type_name" id="edit_case_type_name_<?php echo $caseTypes[$i]['id']; ?>"  value="<?php echo $caseTypes[$i]['case_type_name']; ?>" >
				     					
				     					<?php } else { echo $caseTypes[$i]['case_type_name'];?>
				     						 	
				     				<?php } ?>
				     		</td>
				     		
				     					<td>
				     					<?php if(isset($_GET['applicationId']) && ($_GET['applicationId']==$caseTypes[$i]['id']) && ($_GET['action']=='edit')) { ?>	
				     					<input type="submit" name="update" value="Update" />/<a href="index.php">Cancel</a><?php }else{?>
				     					<a href="index.php?applicationId=<?php echo $caseTypes[$i]['id']; ?>&action=edit">Edit</a><?php }?>
				     					</td>
				     					
				     				
				     					
				     					<td><a href="index.php?applicationId=<?php echo $caseTypes[$i]['id']; ?>&action=del">Delete</a></td>
				     				
				     				
				     				
				     				</tr>
				     				</form>
	     						<?php 
									}
		     					?>
		     				</table>
			     		</div>
		     		</div>
	     		</div>
	     	</div> 
	     	
	   <script type="text/javascript" src="js/masking/ga.js"></script>
	   <script type="text/javascript">
				
			   window.onload = function() {
				   
				   var action='<?php echo $_GET['action']?>';
				   var appId='<?php echo $_GET['applicationId']?>';
					var str='edit_case_type_name_';
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
