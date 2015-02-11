<?php 
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
		$msg = '';
		$errmsg = '';
		
		require_once $_SESSION['base_url'].'/classes/Implementation/SubStageType/Add.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/Misc/Fetch.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/SubStageType/Delete.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/SubStageType/Fetch.php';
		require_once $_SESSION['base_url'].'/classes/Implementation/SubStageType/Edit.php';
		
		
		use classes\implementation\SubStageType as impSubStageType;
		use classes\implementation\Misc as impMisc;
		
		$fetchStages  = new impMisc\Fetch();
		$addStagename   = new impSubStageType\Add();
		$deleteStage = new impSubStageType\Delete();
		$fetchSubStagename  = new impSubStageType\Fetch();
		$editSubStage   = new impSubStageType\Edit();
		
		if(isset($_POST['submitSubSatgeType']))
		{
			//print_r($_POST);exit;
			$stage_name   =  (int)trim($_POST['stage_name']);
			$substage_name   =  trim($_POST['substage_name']);
			$stage_page   =  trim($_POST['stage_page']);
				
			if($substage_name=='' || strlen($substage_name) > 20)
				$errMsg[] = "Please Enter Sub Stage Name".'<br/>';
		
			if($stage_page=='')
				$errMsg[] = "Please Enter Satge Page".'<br/>';

			if(count($errMsg) == 0)
			{
			 $flag = $addStagename->addSubSatgeType(
					$stage_name,
					$substage_name,
					$stage_page );
			
			if($flag == 1)
			{
				$msg = "SubStage Name Add Successfully.";
				header("Location:subsatge_type.php?msg=$msg");
			}
			else
			{
				$errmsg = "SubStage Name failed ?? Please try again Later.";
				header("Location:subsatge_type.php?errmsg=$errmsg");
			}
		}
				
		}
		if(isset($_GET['SubStage_id']) && $_GET['action']=='del')
		{
			$SubStageDel= $deleteStage->deleteSubStage($_GET['SubStage_id']);
			if($SubStageDel==1)
			{
				$msg = "SubStage has been deleted successfully.";
				header("location:subsatge_type.php?msg=$msg&alert=success");
			}
			else
			{
				$errmsg='Error ?? try again Later';
				header("location:subsatge_type.php?msg=$msg");
			}
		}
		
		
		$SubStage_id=$_POST['SubStage_id'];
		//echo $SubStage_id;exit;
		if(isset($_POST['update']))
		{
		
			$flag = $editSubStage->updateSubStage($SubStage_id,$_POST['stage_name'],$_POST['substage_name'],$_POST['stage_page']);
			//echo $flag;exit;
			if($flag == 1)
			{
				$msg = "SubStage_type has been Updated successfully.";
				header("location:subsatge_type.php?SubStage_id=$SubStage_id&msg=$msg&alert=success");
			}
			else
			{
				$errmsg = "Some error occured";
				header("location:subsatge_type.php??SubStage_id=$SubStage_id&msg=$errmsg");
			}
		}
	
		if(isset($_POST['cancel']) && $_POST['cancel']=="Cancel")
		{
			header('Location:subsatge_type.php');
		}
		
		$substagename = $fetchStages->getSubStagesid();
		$stagename = $fetchStages->getAllStages();
		$SubStagedetails = $fetchSubStagename->getSubStageTypes($_GET['SubStage_id']);
		//print_r($SubStagedetails);
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
		 <script type="text/javascript">
	     $(document).ready(function() {
		    // alert('dssk');
		     $('#substage_name').submit(function(){
					if($('#substage_name #stage_name').val()=='')
					{
						alert('Please Select stage_name ');
						$('#substage_name #stage_name').focus();
						return false;
					}
					if($('#substage_name #substagename').val()=='')
					{
						alert('Please Enter Sub Stage name ');
						$('#substage_name #substagename').focus();
						return false;
					}
					if($('#substage_name #stage_page').val()=='')
					{
						alert('Please Enter Stage Page');
						$('#substage_name #stage_page').focus();
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
	     				<li><a href="#">SubStage Type</a></li>
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
	     		
	     		<div style="padding-bottom:13px;"><a id="addLegalAddApplication1" class="form-button" onclick="addStage();">Add New</a></div>
	     		<?php if(!isset($_GET['SubStage_id'])) { ?>
	     		<div <?php if($_GET['action'] != 'edit'){ ?>id="addLegalAddApplication"  <?php }?> >
	     		<div class="clear"></div>
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">SubStage Type</div>
     				<div class="right-title" >&nbsp;</div>
	     		</div>
	           
	          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"name="substage_name" id="substage_name" method="post" onsubmit="return validateSubStageType()" enctype="multipart/form-data">
							<h3>SubStage</h3>
	     					<div style="width:80%;margin-left:1%">
								
										
										<div class="clear"></div>
								        <div class="left" style="width:15%;">Stage </div>
								        <div class="right">
									   <select name="stage_name" id="stage_name">
										<option value="">Select</option>
										<?php
			     						for($i =0;$i<count($stagename);$i++)
											{
										?>
			     							<option value="<?php echo $stagename[$i]['id']; ?>" <?php if(isset($SubStagedetails[0]['parent_id'])==$stagename[$i]['id']) echo "selected=selected"; ?>><?php echo $stagename[$i]['stage_name']; ?></option>
			     						<?php 
											}
											
			     						?>
									</select>
									</div>
									<div class="clear"></div>
									<div class="clear"></div>
										<div class="left" style="width:15%;">SubStage <span class="red">*</span> </div>
										<div class="right" style="width:80%;">
										<input type="text"  placeholder="Name" name="substage_name" id="substagename" maxlength="100" value="<?php if(isset($SubStagedetails[0]['stage_name'])) { echo $SubStagedetails[0]['stage_name']; } else echo '';?>" />											
										</div>
										
								  <div class="clear"></div>
									<div class="clear"></div>
										<div class="left" style="width:15%;">Stage Page <span class="red">*</span></div>
										<div class="right" style="width:80%;">
										<input type="text"  placeholder="Name" name="stage_page" id="stage_page" maxlength="100" value="<?php if(isset($SubStagedetails[0]['stage_page'])) { echo $SubStagedetails[0]['stage_page']; } else echo '';?>"/>											
										</div>		
									
									
										</div>
										<div class="clear"></div>
			     						<div class="clear"></div>
							
				     			        <div style="text-align:center;padding:10px 0;">	
				     							
									
									<?php if(isset($_GET['SubStage_id']) && $_GET['action']=="edit"){?>
				     					<input type="submit" name="update" value="Update" class="form-button" />
				     					<input type="submit" name="cancel" value="Cancel" class="form-button" />
				     					<input type="hidden" id="SubStage_id" name="SubStage_id" 
				     					value="<?php echo $_GET['SubStage_id'];?>"/>	
				     					<?php }else {?>				
									<input class="form-button" type="submit" name="submitSubSatgeType" value="Submit"/>
									<?php }?>
									
								</div>
								  </form>
						</div><?php } ?>
						</div>
				
						
					<div class="clear"></div>
	     			<div class="clear"></div>
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">SubStage Type</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px;">
	     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     				 	<th width="2%" >Sr.No.</th>
			     				 	<th width="10%">Satge Name </th>
			     					<th width="10%">SubSatge Name </th>
			     					<th width="7%">Stage Page</th>
			     					<th style="width:7%;">Edit</th>
			     			 		<th style="width:7%;">Delete</th>
			     			 		
			     					
			     				</tr>
			     			<?php
			     			for($i =0;$i<count($substagename);$i++)
							{
								$SubStage_Name = $fetchStages->getSubStages($substagename[$i]['id']);
								$class = ($i % 2 == 0) ? 'even' : 'odd';
							?>	
     											
     						<tr class="<?php echo $class; ?>" >
     						<td align="center"><?php echo $i+1; ?></td>
     						<td ><?php  echo $substagename[$i]['stage_name'];?> </td>
     						
     						 
     						 
                            <td>
                             <?php for($j=0;$j<count($SubStage_Name);$j++)
			                    {
				                  echo $SubStage_Name[$j]['stage_name']."<br />";				
			                    }
			                     ?>
                           
                            </td>
                           
				     		<td>
				     		<?php for($k=0;$k<count($SubStage_Name);$k++)
			                    {
				                  echo $SubStage_Name[$k]['stage_page']."<br />";				
			                    }
			                     ?>
				     		 </td>
				     		
				     		<td>
				     		<?php for($l=0;$l<count($SubStage_Name);$l++)
			                    {
				                 // echo $SubStage_Name[$l]['stage_page']."<br />";?>	
				                  <a href="editsubstage_type.php?SubStage_id=<?php echo $SubStage_Name[$l]['id']; ?>&action=edit">Edit</a><br>
			                    
				     		<?php }?>
				     		</td>
				     		
				     		<td>
				     		<?php for($m=0;$m<count($SubStage_Name);$m++)
			                    {
				                 // echo $SubStage_Name[$l]['stage_page']."<br />";?>	
				                 <a href="subsatge_type.php?SubStage_id=<?php echo $SubStage_Name[$m]['id']; ?>&action=del">Delete</a></br>
			                    
				     		<?php }?>
				     							     			
					     	</td>
					     	
     					</tr>
     					<?php }?>
	     				
		     				</table>
		     			</div>
						</div>
					</div>
				
	     	</div>
	     		</div>	
	 
		<script type="text/javascript" src="../../js/masking/ga.js"></script>
		 
	</body>
</html>