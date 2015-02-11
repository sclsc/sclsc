<?php 
	session_start();
	error_reporting(0);
	$msg = '';
	$errmsg = '';
	require_once $_SESSION['base_url'].'/classes/Implementation/StageType/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Misc/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/StageType/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/StageType/Delete.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/StageType/Edit.php';
	
	
	use classes\implementation\StageType as impStageType;
	use classes\implementation\Misc as impMisc;
	
	$addStagename   = new impStageType\Add();
	$fetchStages  = new impMisc\Fetch();
	$fetchStagename  = new impStageType\Fetch();
	$deleteStage = new impStageType\Delete();
	$editStage   = new impStageType\Edit();
	$Stage_id=$_POST['Stage_id'];
   if(isset($_POST['submitSatgeType']))
	{
		$flag = $editStage->updateStage($_POST['Stage_id'],$_POST['stage_name'],$_POST['stage_page']);
		
		if($flag == 1)
		{
			$msg = "Stage_type has been Updated successfully.";
			header("location:editstage_type.php?Stage_id=$Stage_id&msg=$msg&alert=success");
		}
		else
		{
			$errmsg = "Some error occured";
			header("location:editstage_type.php??Stage_id=$Stage_id&msg=$errmsg");
		}
	}
		
		
		//$stagename = $fetchStages->getAllStages();
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
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">Stage Type</div>
     				<div class="right-title" >&nbsp;</div>
	     		</div>
	           <div style="height:auto;border:1px solid #4b8df8;">
	          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="stage_name" id="stage_name" method="post"  enctype="multipart/form-data">
							<h3>Stage Name</h3>
	     					<div style="width:80%;margin-left:1%">
								<div class="clear"></div>
									<div class="clear"></div>
										<div class="left" style="width:15%;">Stage Name </div>
										<div class="right" >
										<input type="text"  placeholder="Stage Name" name="stage_name" id="stage_name" maxlength="100" value="<?php echo $Stagedetails[0]['stage_name'];?>" />											
										</div>
										
										<div class="clear"></div>
								        <div class="left" style="width:15%;">Stage Page</div>
								        <div class="right">
									   <input type="text"  placeholder="Satge Page" name="stage_page" id="stage_page" maxlength="100" value="<?php echo $Stagedetails[0]['stage_page'];?>" />	
									   </div>
									</div>
										<div class="clear"></div>
			     						<div class="clear"></div>
							
				     			        <div style="text-align:center;padding:10px 0;">	
				     					<input type="hidden" id="Stage_id" name="Stage_id" 
				     					value="<?php echo $_GET['Stage_id'];?>"/>					
									<input class="form-button" type="submit" name="submitSatgeType" value="Submit"/>
									
								</div>
								  </form>
							</div>
						
				
						
					
						</div>
					</div>
				
	     	</div>
	     		</div>	
	 
		<script type="text/javascript" src="../../js/masking/ga.js"></script>
		 
	</body>
</html>