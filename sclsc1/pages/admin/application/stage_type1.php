<?php 
	session_start();
	error_reporting(0);
	$msg = '';
	$errmsg = '';
	require_once $_SESSION['base_url'].'/classes/Implementation/StageType/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Misc/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/StageType/Edit.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/StageType/Delete.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/StageType/Fetch.php';
	
	
	use classes\implementation\StageType as impStageType;
	use classes\implementation\Misc as impMisc;
	
	$addStagename   = new impStageType\Add();
	$fetchStages  = new impMisc\Fetch();
	$fetchStagename  = new impStageType\Fetch();
	$editStage   = new impStageType\Edit();
	$deleteStage = new impStageType\Delete();
	
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
		$msg = '';
		$errmsg = '';
		if(isset($_POST['submitSatgeType']))
		{
		//print_r($_POST);exit;	
			$stage_name   =  trim($_POST['stage_name']);
			$stage_page   =  trim($_POST['stage_page']);
			
			if($stage_name=='' || strlen($stage_name) > 20)
				$errMsg[] = "Please Enter Stage Name".'<br/>';

			if($stage_page=='')
				$errMsg[] = "Please Enter Satge Page".'<br/>';
			
			if(count($errMsg) == 0)
			{
			   $flag = $addStagename->addSatgeType(
						$stage_name,
						$stage_page );
			
				if($flag == 1)
				{
					$msg = "Stage Name Add Successfully.";
					header("Location:stage_type.php?msg=$msg");
				}
				else
				{
					$errmsg = "Stage Name failed ?? Please try again Later.";
					header("Location:stage_type.php?errmsg=$errmsg");
				}
			}
		
			
		}

		if(isset($_GET['Stage_id']) && $_GET['action']=='del')
		{
			$StageDel= $deleteStage->deleteStage($_GET['Stage_id']);
			if($StageDel==1)
			{
				$msg = "Stage has been deleted successfully.";
				header("location:stage_type.php?msg=$msg&alert=success");
			}
			else
			{
				$errmsg='Error ?? try again Later';
				header("location:stage_type.php?msg=$msg");
			}
		}
		$Stage_id=$_POST['Stage_id'];
		 if(isset($_POST['update']))
	{
	
		$flag = $editStage->updateStage($_POST['Stage_id'],$_POST['stage_name'],$_POST['stage_page']);
		
		if($flag == 1)
		{
			$msg = "Stage_type has been Updated successfully.";
			header("location:stage_type.php?Stage_id=$Stage_id&msg=$msg&alert=success");
		}
		else
		{
			$errmsg = "Some error occured";
			header("location:stage_type.php??Stage_id=$Stage_id&msg=$errmsg");
		}
	}
	if(isset($_POST['cancel']) && $_POST['cancel']=="Cancel")
	{
		header('Location:stage_type.php');
	}
		
		$stagename = $fetchStages->getAllStages();
		$Stagedetails = $fetchStagename->getStageTypes($_GET['Stage_id']);
		//print_r($Stagedetails);
		
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
		<script>
		function addStage()
		{	
			$("#addLegalAddApplication").show();
			$("#addLegalAddApplication1").hide();
		}
		function addStageHide()
		{	
			$("#addLegalAddApplication").hide();
			$("#addLegalAddApplication1").show();
		}
		

		window.onload=addStageHide;
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
	     				<li><a href="#">Satge Type</a></li>
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
	     		<div id="breadcrumb" >
	     		<?php if(!isset($_GET['Stage_id'])) { ?>
	     		<div style="padding-bottom:13px;"><a id="addLegalAddApplication1" class="form-button" onclick="addStage();">Add New</a></div>
	     		<?php } ?>
	     		<div <?php if ($_GET['action'] != 'edit'){ ?>id="addLegalAddApplication"  <?php }?> >
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">Stage Type</div>
     				<div class="right-title" >&nbsp;</div>
	     		</div>
	          
	          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="stage_name" id="stage_name" method="post" onsubmit="return validateStageType()"  enctype="multipart/form-data">
							<h3>Stage Name</h3>
	     					<div style="width:80%;margin-left:1%">
								<div class="clear"></div>
									<div class="clear"></div>
										<div class="left" style="width:15%;">Stage Name<span class="red">*</span>	 </div>
										<div class="right" >
										<input type="text"  placeholder="Stage Name" name="stage_name" id="stage_name" maxlength="100" value="<?php if(isset($Stagedetails[0]['stage_name'])) { echo $Stagedetails[0]['stage_name']; } else echo '';?>"/>											
										</div>
										
										<div class="clear"></div>
								        <div class="left" style="width:15%;">Stage Page<span class="red">*</span>	</div>
								        <div class="right">
									   <input type="text"  placeholder="Satge Page" name="stage_page" id="stage_page" maxlength="100" value="<?php if(isset($Stagedetails[0]['stage_page'])) { echo $Stagedetails[0]['stage_page']; } else echo '';?>"/>
									   </div>
									</div>
										<div class="clear"></div>
			     						<div class="clear"></div>
							
				     			        <div style="text-align:center;padding:10px 0;">	
				     					<?php if(isset($_GET['Stage_id']) && $_GET['action']=="edit"){?>
				     					<input type="submit" name="update" value="Update" class="form-button" />
				     					<input type="submit" name="cancel" value="Cancel" class="form-button" />
				     					<input type="hidden" id="Stage_id" name="Stage_id" 
				     					value="<?php echo $_GET['Stage_id'];?>"/>	
				     					<?php }else {?>				
									<input class="form-button" type="submit" name="submitSatgeType" value="Submit"/>
									<?php }?>
								</div>
								  </form>
													
				 </div>
				 </div>
						
					<div class="clear"></div>
	     			<div class="clear"></div>
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Satge Type List</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px;">
	     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     				 	<th width="2%" >Sr.No.</th>
			     					<th width="10%">Satge Name </th>
			     					<th width="7%">Stage Page</th>
			     					<th style="width:7%;">Edit</th>
			     			 		<th style="width:7%;">Delete</th>
			     			 		
			     					
			     				</tr>
			     			<?php
			     			for($i =0;$i<count($stagename);$i++)
							{
								$class = ($i % 2 == 0) ? 'even' : 'odd';
							?>	
     											
     						<tr class="<?php echo $class; ?>" >
     						<td align="center"><?php echo $i+1; ?></td>
                            <td>
                            <?php echo $stagename[$i]['stage_name'];?> </td>
				     		<td> <?php  echo $stagename[$i]['stage_page']; ?> </td>
				     		<td><a href="stage_type.php?Stage_id=<?php echo $stagename[$i]['id']; ?>&action=edit" >Edit</a>
				     					
				     		</td>
				     	<!--  	<td><a href="editstage_type.php?Stage_id=<?php //echo $stagename[$i]['id']; ?>&action=edit">Edit</a>-->
				     		<td><a href="stage_type.php?Stage_id=<?php echo $stagename[$i]['id']; ?>&action=del">Delete</a>					     			
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