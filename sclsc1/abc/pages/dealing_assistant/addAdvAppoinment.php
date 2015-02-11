<?php 
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
	
	$msg = '';
	$errmsg = '';
	$reg_flag = array();
	
	require_once $_SESSION['base_url'].'/classes/Implementation/Advocate/Fetch.php';	
	require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Edit.php';
	
	use classes\Implementation\Advocate as impAdvocate;
	use classes\Implementation\ClosingOfFile as impCof;
	
	$addCof        = new impCof\Add();	
	$editCof       = new impCof\Edit();
	$fetchAdvocate = new impAdvocate\Fetch();

		if(isset($_POST['submitDispatch']))
		 {		 	
		 	//print_r($_POST); exit;
		 	 $application_id  = (int)trim($_POST['application_id']);
			 $app_date       = trim($_POST['app_date']);
			 $adv_name       = trim($_POST['adv_name']);			
		
			 $isSrAdv =FALSE;
			 $applicationId = $addCof->addAdvocateApponment($application_id, $app_date, $adv_name, $isSrAdv);
		
			 $stage_id = 5;
			 $sub_stage_id = 1;			 
			 $flag = $editCof->upApplicationStatus($application_id, $stage_id, $sub_stage_id);
			 
			 if ($flag == 1)
			 {
			 	$msg = "Advocate Appoinmented successfully.";
			 	header("Location:index.php?msg=$msg");
			 }
			 else
			 {
			 	$errmsg = "Appoinmented failed ?? Please try again Later.";
			 	header("Location:index.php?errmsg=$errmsg");
			 }
			 
		 
	}

$alladvocateList = $fetchAdvocate->getAdvocatesList();	
//print_r($alladvocateList);
		
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../css/styles.css">
		<script src="../../js/jquery.min.js"></script>
		<script src="../../js/masking/jquery-1.js"></script>
		<script src="../../js/masking/jquery.js"></script>
		<script src="../../js/dispatchValidation.js"></script>

		
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
	     				<li><a href="index.php">Dashboard /</a></li>
	     				<li><a href="advAppoinment.php">Advocate Appoinment &nbsp;&nbsp;&nbsp;&nbsp;</a>/</li>
	     				<li><a href="advAppoinmentApplication.php">Advocate Appoinment List </a></li>
	     				<li><a href="#">Advocate Appoinment</a></li>
	     			</ul>
	     		</div>
	     		<div class="clear"></div>
	     		<?php if($msg != '')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-green">
	     			<?php echo $msg;?>	
	     		</div>
	     		<?php 
	     		}
	     		?>
	     		<?php if($errmsg != '' )
	     		{	
	     		?>
	     	   	<div id="breadcrumb-red">
	     			<?php echo $errmsg;
	     			?>	
	     		</div>
	     		<?php 
	     		}
	     		?>	
	     		<div class="clear"></div>
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">Advocate Appoinment</div>
     				<div class="right-title" >Application No. : <?php echo $_GET['appliNo'].$_POST['appliNo'];?></div>
	     		</div>
	           <div style="height:auto;border:1px solid #4b8df8;">
	            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="advAppoinment" 
	            id="advAppoinment" method="post" >
							<h3>Appoinment Details</h3>
	     					<div style="width:80%;margin-left:1%">
								<div class="clear"></div>
								<div class="left" >
										<div class="left"> Full Name <span class="red">*</span></div>
										<div class="right" >
											<select name="adv_name" id="adv_nemae" multiple style="height:30%" required="required">				     							
				     						<?php
				     						for($i =0;$i<count($alladvocateList);$i++)
												{
											?>
				     							<option value="<?php echo $alladvocateList[$i]['id']; ?>"><?php echo $alladvocateList[$i]['advocate_name']; ?></option>
				     						<?php 
												}
				     						?>
				     						</select>
										</div>
										
								</div>
								
								<div class="right">
										<div class="clear"></div>
										<div class="left">Appoinment Date</div>
										<div class="right">
											<input type="text" id="app_date" placeholder="Appoinment Date" name="app_date" value="<?php echo date("d-m-Y"); ?>" required="required"/>
										</div>
										
										</div>
					</div>
							
					
			     			<div class="clear"></div>
			     	<div class="clear"></div>
							
				     			<div style="text-align:center;padding:10px 0;">	
				     					<input type="hidden" id="application_id" name="application_id" 
				     					value="<?php if(isset($_GET['application_id'])) echo $_GET['application_id']; else echo $_POST['application_id'];?>"/>	
				     					<input type="hidden" id="appliNo" name="appliNo" 
				     					value="<?php if(isset($_GET['appliNo'])) echo $_GET['appliNo']; else echo $_POST['appliNo'];?>"/>					
									<input class="form-button" type="submit" name="submitDispatch" value="Submit" />
								</div>
							
						</form>
						
						</div>
					</div>
				
				
	     		<script type="text/javascript">
					jQuery(function($){
						$("#mobile_number").mask("999-999-9999", {placeholder: 'XXX/XXX/XXXX'});
                        $("#pincode").mask("999999", {placeholder: 'XXXXXX'});
                        $("#dob").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
					});
					$(document).ready(function() {
					    $('form:first *:input[type!=hidden]:first').focus();
					});
				</script>
	     	</div>
	 
		<script type="text/javascript" src="../../js/masking/ga.js"></script>
		 
	</body>
</html>
