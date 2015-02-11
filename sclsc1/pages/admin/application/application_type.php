<?php 
	session_start();
	if(!isset($_SESSION['user']))
		header('location:../../login.php');
	
	require_once $_SESSION['base_url'].'/classes/Implementation/ApplicationTypes/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/ApplicationTypes/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/ApplicationTypes/Edit.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/ApplicationTypes/Delete.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
	
	
	
	use classes\implementation\ApplicationTypes as impApplication;
	use classes\Pagination as impPage;
	
	$fetchApplication = new impApplication\Fetch();
	$addApplication   = new impApplication\Add();
	$deletApplication = new impApplication\Delete();
	$editApplication  = new impApplication\Edit();
	$fetchPage        = new impPage\Pagination();
	
	$msg='';
	$errmsg='';
		
	if(isset($_POST['submit']))
	{
		$checkFlag = $fetchApplication->checkApplicationType($_POST['application_name']);
		if($checkFlag != 1)
		{
			$flag = $addApplication->addApplicationType($_POST['application_name']);
			if($flag == 1)
			{
				$msg = "Application Type has been added successfully.";
				header("location:application_type.php?msg=$msg&alert=success");
			}
			else 
			{
				$msg = "Some error occured";
				header("location:application_type.php?msg=$msg");
			}
		}
		else
		{
			$msg = "Application Type Already Exist";
			header("location:application_type.php?msg=$msg");
		}
	}
	
	if(isset($_GET['applicationId']) && $_GET['action']=='del')
	{
		$applicationDel= $deletApplication->delApplication($_GET['applicationId']);
		if($applicationDel==1)
		{
			$msg = "Application Type has been deleted successfully.";
			header("location:application_type.php?msg=$msg&alert=success");
		}
		else
		{
			$errmsg='Error ?? try again Later';
		header("location:application_type.php?msg=$msg");
	    }
	}

	if(isset($_POST['edit_application_id']) && $_POST['update']=='Update')
	{
		
		$checkFlag = $fetchApplication->checkApplicationType($_POST['edit_application_name']);
		
		if($checkFlag!=1){
		$applicationEdit= $editApplication->updateApplication($_POST['edit_application_id'],$_POST['edit_application_name']);
		if($applicationEdit==1)
		{
			$msg = "Application Type has been updated successfully.";
			header("location:application_type.php?msg=$msg&alert=success");
		}
		else
		{
			$errmsg='Error ?? try again Later';
			header("location:application_type.php?msg=$msg");
		}
	}
	else 
	 {
			$msg='Already Exist';
		header("location:application_type.php?msg=$msg");
	 }
		
}

	$targetpage = 'appliocation_type.php';
	$adjacents = 2;
	$limit = 5;
	$start = 0;
	$page = 0;
	
	if(isset($_GET['page']))
	{
		$page = $_GET['page'];
		if($page){
			$start = ($page - 1) * $limit;
			$recordCounter=$start;
		}
		else
		$start = 0;
		$applicationTypes = $fetchApplication->getAllApplicationType($limit,$start);
	    $Records     = $fetchApplication->getAllApplicationCount();
		$url='';
		$pagination = $fetchPage->paginations($page, $Records, $limit, $targetpage, $adjacents, $url);
	}
	else
	{
		 $applicationTypes = $fetchApplication->getAllApplicationType($limit,$start);		
		 $Records     = $fetchApplication->getAllApplicationCount();
		 $url='';
    	 $pagination = $fetchPage->paginations($page, $Records, $limit, $targetpage, $adjacents, $url);		
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
		<script type="text/javascript" src="../../js/masking/jquery-1.js"></script>
		<script type="text/javascript" src="../../js/masking/jquery.js"></script>
		<link href="../../../css/pagination.css" rel="stylesheet">
		<script type="text/javascript">
		function validateForm() {
			var name = document.getElementById('application_name').value;
			
			if(name == '')
			{
				alert("Enter Application Name");
				return false;
			}
		}	
		</script>
	
	</head>
	<body>
	<?php include_once 'include/header.php';?>
	    <div class="wrapper" >
			<div id="left-wrapper">	
				<?php include_once 'include/side-menu.php';?>
			</div>
			
			<div id="right-wrapper">
				<div id="breadcrumb">
	     			<ul>
	     				<li><a href="index.php">Home &nbsp;&nbsp;&nbsp;/</a></li>
	     				<li><a href="#">Legal Aid Application Type</a></li>
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
	       	
	     		<div class="clear"></div>
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Add Legal Aid Application Type</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;height:120px;padding:7px ">
		     			<div style="width:60.0%;margin-left:10%">
		     				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateForm()">
								<div class="clear"></div>
								<div class="left"> Name <span class="red">*</span></div>
								<div class="right">
									<input type="text" id="application_name" placeholder=" Enter Application Type Name" name="application_name" />
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
	     				<div id="left-title">Legal Aid Application Type List</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px;">
		     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     					<th width="2%" >Sr.No.</th>
			     					<th width="25%">Legal Aid Application Type</th> 			     					
			     					<th width="2%">Edit</th>			     					
			     					<th width="2%">Delete</th>   					
			     				</tr>
			     				<?php	     						
	     							for($i =0;$i<count($applicationTypes);$i++)
									{
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
								<form method="POST" name="form2" action="application_type.php">
				     				<tr class="<?php echo $class; ?>">
				     					<td><?php echo $i+1; ?></td>
				     					<td>
				     					<?php if(isset($_GET['application_id']) && $_GET['application_id']==$applicationTypes[$i]['id'] && $_GET['action']=="edit"){ ?>
				     									     					
				     					<input type="hidden" name="edit_application_id"  value="<?php echo $applicationTypes[$i]['id']; ?>" >
				     					<input type="text" name="edit_application_name" id="edit_application_name_<?php echo $applicationTypes[$i]['id']; ?>" value="<?php echo $applicationTypes[$i]['appli_type_name']; ?>" >
				     					
				     				<?php } else { echo $applicationTypes[$i]['appli_type_name']; } ?>
				     				
				     					</td> 				     				
				     					<td>
				     					<?php if(isset($_GET['application_id']) && $_GET['application_id']==$applicationTypes[$i]['id'] && $_GET['action']=="edit"){ ?>
				     					<input type="submit"  name="update" value="Update">/<a href="application_type.php">Cancel</a>
				     					<?php } else { ?>
				     					<a href="application_type.php?application_id=<?php echo $applicationTypes[$i]['id']; ?>&action=edit">Edit</a>
				     					<?php } ?>
				     					</td>			     				
				     					<td><a href="application_type.php?applicationId=<?php echo $applicationTypes[$i]['id']; ?>&action=del">Delete</a></td>   					
				     						
				     				</tr>
				     				</form>
	     						<?php 
									}
									echo $pagination;
		     					?>
		     				</table>
			     		</div>
		     		</div>
	     		</div>
	     	
	     	
	   <script type="text/javascript" src="js/masking/ga.js"></script>
	   	     <script type="text/javascript">
				
			   window.onload = function() {
				   
				   var action='<?php echo $_GET['action']?>';
				   var appId='<?php echo $_GET['application_id']?>';
					var str='edit_application_name_';
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
					function validate(){
							var appele=document.getElementById('application_name');							
							if(appele.value=='')
							{
								alert('Please Enter Application Type Name');
								appele.focus();
								return false;
							}												
						}
					function init(){
							document.getElementById('application_name').focus();
					}
					window.onload=init;
	     		</script>	
		
	</body>
</html>
