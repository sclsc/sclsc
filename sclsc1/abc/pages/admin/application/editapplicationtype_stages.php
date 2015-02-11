<?php 
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
		$msg = '';
		$errmsg = '';
		
		require_once $_SESSION['base_url'].'/classes/Implementation/ApplicationTypesStage/Add.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/Misc/Fetch.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/ApplicationTypes/Fetch.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/ApplicationTypesStage/Fetch.php';
		//require_once $_SESSION['base_url'].'/classes/Implementation/SubStageType/Delete.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/ApplicationTypesStage/Edit.php';
		
		
		use classes\implementation\ApplicationTypesStage as impApplicationStageType;
		use classes\implementation\Misc as impMisc;
		use classes\implementation\ApplicationTypes as impApplication;
		use classes\Pagination as impPage;
		
		
		$fetchStages  = new impMisc\Fetch();
		$fetchApplication = new impApplication\Fetch();
		$addApplicationStage   = new impApplicationStageType\Add();
		$fetchApplicationStage   = new impApplicationStageType\Fetch();
		$editApplicationSubStage   = new impApplicationStageType\Edit();
		//$deleteStage = new impSubStageType\Delete();
		
    	 $applicationstage_id=$_GET['applicationstage_id'];
	
	if(isset($_POST['submitApplicationSatgeType']))
	{
		$checkFlag = $fetchApplicationStage->checkApplicationTypestages($_POST['stage_name'],$_POST['application_type']);
		if($checkFlag != 1)
		{
		  $flag = $editApplicationSubStage->updateApplicationStage($_POST['applicationstage_id'],$_POST['application_type'],$_POST['stage_name']);
	
		if($flag == 1)
		{
			$msg = "ApplicationType stage has been Updated successfully.";
			header("location:applicationtype_stages.php?msg=$msg");
		}
		else
		{
			$errmsg = "Some error occured";
			header("location:applicationtype_stages.php?errmsg=$errmsg");
		}
		}
		else
		{
		   $msg = "Already Exist";
		  	header("location:applicationtype_stages.php?msg=$msg");
		}
	}
		
	if(isset($_POST['cancel']) && $_POST['cancel']=="Cancel")
	{
		header('Location:applicationtype_stages.php');
	}
		$stagename = $fetchStages->getAllStages();
		$applicationTypes = $fetchApplication->getApplicationType();
		$applicationTypestages = $fetchApplicationStage->getApplicationTypeStage($applicationstage_id);
		$applicationsatges = $fetchApplicationStage->getapplicationstage();
		
	
		
	?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<script src="../../../js/jquery.min.js"></script>
		<script src="../../../js/masking/jquery-1.js"></script>
		<script src="../../../js/masking/jquery.js"></script>
		<script src="../../../js/dispatchValidation.js"></script>
		<script type="text/javascript">
	     $(document).ready(function() {
		     $('#applicationtype_name').submit(function(){
					if($('#applicationtype_name #application_type').val()=='')
					{
						alert('Please Select application type ');
						$('#applicationtype_name #application_type').focus();
						return false;
					}
					if($('#applicationtype_name #stage_name').val()=='')
					{
						alert('Please Select stage name ');
						$('#applicationtype_name #stage_name').focus();
						return false;
					}
					
			 });
		});
	   </script>
		
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
	     				<li><a href="index.php">Home /</a></li>
	     				<li><a href="#">Application Type Stage</a></li>
	     			</ul>
	     		</div>
	     		
	     		<div class="clear"></div>
	     			<?php if($msg != '' || $_GET['msg']!='')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-green">
	     			<?php echo $msg;
	     			echo $_GET['msg']; 
	     			?>	
	     		</div>
	     		<?php 
	     		}
	     		?>
	     		<?php if($errmsg != '' || count($errMsg) > 0)
	     		{	
	     		?>
	     	   	<div id="breadcrumb-red">
	     			<?php echo $errmsg;
	     			
	     			foreach($errMsg as $val) {
	     				echo $val;
	     			}
	     			
	     			?>	
	     		</div>
	     		<?php 
	     		}
	     		?>	
	     		<div class="clear"></div>
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">ApplicationType Stage</div>
     				<div class="right-title" >&nbsp;</div>
	     		</div>
	           <div style="height:auto;border:1px solid #4b8df8;">
	          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"name="substage_name" id="substage_name" method="post"  enctype="multipart/form-data">
							<h3>ApplicationType Stage</h3>
	     					<div style="width:80%;margin-left:1%">
								
										
										
									<div class="clear"></div>
									<div class="clear"></div>
								        <div class="left" style="width:15%;">Application </div>
								        <div class="right">
									   <select name="application_type" ">
										<option value="">Select</option>
										<?php
			     						for($i =0;$i<count($applicationTypes);$i++)
											{
										?>
			     							<option value="<?php echo $applicationTypes[$i]['id']; ?>" <?php if($applicationTypestages[0]['application_type_id']==$applicationTypes[$i]['id']) echo "selected=selected"; ?>><?php echo $applicationTypes[$i]['appli_type_name']; ?></option>
			     						<?php 
											}
											
			     						?>
									</select>
									</div>
									<div class="clear"></div>
								        <div class="left" style="width:15%;">Stage </div>
								        <div class="right">
									   <select name="stage_name">
										<option value="">Select</option>
										<?php
			     						for($i =0;$i<count($stagename);$i++)
											{
										?>
			     							<option value="<?php echo $stagename[$i]['id']; ?>" <?php if($applicationTypestages[0]['stage_id']==$stagename[$i]['id']) echo "selected=selected"; ?>><?php echo $stagename[$i]['stage_name']; ?></option>
			     						<?php 
											}
											
			     						?>
									</select>
									</div>
										</div>
										<div class="clear"></div>
			     						<div class="clear"></div>
							
				     			        <div style="text-align:center;padding:10px 0;">	
				     				 <input type="hidden" id="applicationstage_id" name="applicationstage_id" 
				     					value="<?php echo $_GET['applicationstage_id'];?>"/>				
									<input class="form-button" type="submit" name="submitApplicationSatgeType" value="Update"/>
									<input type="submit" name="cancel" value="Cancel" class="form-button" />
									
								</div>
								  </form>
							</div>
							
							<div class="clear"></div>
	     			<div class="clear"></div>
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Application Type Stage </div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px;">
	     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     				 	<th width="2%" >Sr.No.</th>
			     					<th width="10%">Application Type Name </th>
			     					<th width="7%">Stage Name</th>
			     					<th style="width:7%;">Edit</th>
			     			 		<th style="width:7%;">Delete</th>
			     			 	</tr>
			     			<?php
			     			for($i =0;$i<count($applicationsatges);$i++)
							{
								$applicationSatgename=$fetchApplicationStage->getApplicationStageName($applicationsatges[$i]['id']);
								//print_r($applicationSatgename);
								$class = ($i % 2 == 0) ? 'even' : 'odd';
							?>	
     											
     						<tr class="<?php echo $class; ?>" >
     						<td align="center"><?php echo $i+1; ?></td>
                            <td><?php  echo $applicationsatges[$i]['appli_type_name'];?></td>
				     		<td><?php for($j=0;$j<count($applicationSatgename);$j++)
			                    {
				                  echo $applicationSatgename[$j]['stage_name']."<br />";				
			                    }
			                     ?> </td>
			                     <td> <?php for($l=0;$l<count($applicationSatgename);$l++)
			                    {
				                 // echo $SubStage_Name[$l]['stage_page']."<br />";?>	
				                  <a href="editapplicationtype_stages.php?applicationstage_id=<?php echo $applicationSatgename[$l]['id']; ?>&action=edit">Edit</a><br>
			                    
				     		<?php }?></td>
				     		<td>
				     	     <?php for($m=0;$m<count($applicationSatgename);$m++)
			                    {
				                 // echo $SubStage_Name[$l]['stage_page']."<br />";?>	
				                  <a href="applicationtype_stages.php?applicationstage_id=<?php echo $applicationSatgename[$m]['id']; ?>&action=del">Delete</a><br>
			                    
				     		<?php }?>	
				     		</td>
     					</tr>
     					<?php } ?>
	     				
		     				</table>
		     			</div>
						</div>
					</div>
				
	     	</div>
	     		</div>	
	 
		<script type="text/javascript" src="../../js/masking/ga.js"></script>
		 
	</body>
</html>