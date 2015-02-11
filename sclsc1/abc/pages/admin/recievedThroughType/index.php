<?php 
	session_start();	
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	  
	require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThroughType/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThroughType/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThroughType/Edit.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThroughType/Delete.php';
	
	use classes\Implementation\RecievedThroughType as impRecievedThroughType;
	
	$addRecievedThroughType = new impRecievedThroughType\Add();
	$fetchRecievedThroughType = new impRecievedThroughType\Fetch();
	$editRecievedThroughType=new impRecievedThroughType\Edit();
	$delRecievedThroughType=new impRecievedThroughType\Delete();
	
	$msg ='';
	$errmsg= '';
	if(isset($_POST['submit']))
	{
		if(!empty($_POST['through_type_name']) || str_len($_POST['through_type_name'])>50)
		{
			$err = "Please Enter Full Name less than 50 charactor".'<br/>';
		}
		else
		{
			$checkFlag = $fetchRecievedThroughType->checkThroughType($_POST['through_type_name']);
			if($checkFlag != 1)
			{
				$flag = $addRecievedThroughType->addThroughType($_POST['through_type_name']);
				if($flag == 1)
				{
					$msg = "Through type has been added successfully";
					header("location:index.php?msg=$msg&alert=success");
				}
				else
				{
					$msg = "some error occured!";
					header("location:index.php?msg=$msg");
				}
			}
			else
			{
				$msg = "Through type Already Exist";
				header("location:index.php?msg=$msg");
			}
		}
		
	}
	$applicationThroughTypes = $fetchRecievedThroughType->getThroughType();
	
	if(isset($_GET['applicationId']) && $_GET['action']=='del')
	{
		$RecievedThroughTypeDel= $delRecievedThroughType->delRecievedThroughType($_GET['applicationId']);
		if($RecievedThroughTypeDel==1)
		{
			$msg = "Through type has been deleted successfully";
			header("location:index.php?msg=$msg&alert=success");
		}
		else
		{
			$errmsg='Error ?? try again Later';
			header("location:index.php?msg=$msg");
		}
	}
	
 if(isset($_POST['edit_application_through_type_id']) && $_POST['update']=='Update')
  {
	 if(!isset($_POST['edit_application_through_type_name']) || $_POST['edit_application_through_type_name']=="")
	 {
			$msg='Enter Edit Through Name';
	 header("location:index.php?msg=$msg");
	 }
	else 
	{
		$checkFlag = $fetchRecievedThroughType->checkThroughType($_POST['edit_application_through_type_name']);
	  if($checkFlag!=1)
		{
		$RecievedThroughTypeEdit= $editRecievedThroughType->updateRecievedThroughType($_POST['edit_application_through_type_id'],$_POST['edit_application_through_type_name']);
		
		if($RecievedThroughTypeEdit==1)
		{
			$msg = "Through type has been updated successfully";
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
			$msg='Through type Already Exists';
			header("location:index.php?msg=$msg");
	}
	
  }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
	    <title>Welcome to SCLSC</title>
		<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<link href="../../../css/pagination.css" rel="stylesheet">
		<script type="text/javascript" src="../../../js/masking/jquery-1.js"></script>
		<script type="text/javascript" src="../../../js/masking/jquery.js"></script>
		<script type="text/javascript">
		function validateForm() {
			var name = document.getElementById('name').value;
			
			if(name == '')
			{
				alert("Enter Through Type Name");
				return false;
			}
			
		}	
	
		</script>
		    
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
	     				<li><a href="../index.php">Home &nbsp;&nbsp;&nbsp;/</a></li>
	     				<li><a href="#">Application Through Type</a></li>
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
	     				<div id="left-title">Add Application Recieved Through Type</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<form name="form1" action="index.php" method="post" onsubmit="return validateForm()">
	     			<div style="border:2px solid #4b8df8;padding:7px;height:120px;">
		     			<div style="width:60%;margin-left:10%">
		     				<div class="clear"></div>
							<div class="left"> Name <span class="red">*</span></div>
							<div class="right">
								<input type="text" name="through_type_name" id="name" placeholder=" Enter Application Through Type Name " />
							</div>
							<div class="clear"></div>
							<div class="left"></div>
							<div class="right">
								<input type="submit" name="submit" value="Submit" class="form-button" />
							</div>
						</div>	
			     	</div>
			     	</form><div class="clear"></div>
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Received Through Type List</div>
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
	     						
	     							for($i =0;$i<count($applicationThroughTypes);$i++)
									{
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
								<form method="POST" action="index.php" name="form2">
				     				<tr class="<?php echo $class; ?>">
				     					<td><?php echo $i+1; ?></td>
				     					<td>
				     					<?php if(isset($_GET['applicationId']) && $_GET['applicationId']==$applicationThroughTypes[$i]['id'] && $_GET['action']=="edit"){ ?>
				     					<input type="hidden" name="edit_application_through_type_id"  value="<?php echo $applicationThroughTypes[$i]['id']; ?>" >
				     					<input type="text" name="edit_application_through_type_name" id="edit_application_through_type_name_<?php echo $applicationThroughTypes[$i]['id']; ?>" value="<?php echo $applicationThroughTypes[$i]['appli_through_type_name']; ?>" >
				     					
				     					<?php }else{ echo $applicationThroughTypes[$i]['appli_through_type_name']; }?>  					
				     					</td>
				     					
				     			
				     					
				     					<td>
				     					<?php if(isset($_GET['applicationId']) && $_GET['applicationId']==$applicationThroughTypes[$i]['id'] && $_GET['action']=="edit"){ ?>
				     					<input type="submit"  name="update" value="Update">/<a href="index.php ">Cancel</a>
				     					<?php }else {?>
				     					<a href="index.php?applicationId=<?php echo $applicationThroughTypes[$i]['id']; ?>&action=edit">Edit</a>
				     					<?php } ?>
				     					</td>
				     					
				     					
				     					
				     					<td><a href="index.php?applicationId=<?php echo $applicationThroughTypes[$i]['id']; ?>&action=del">Delete</a></td>
				     					
				     				
				     				
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
					var str='edit_application_through_type_name_';
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
	</body>
</html>