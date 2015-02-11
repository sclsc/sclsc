<?php 
	session_start();
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
	
	
	require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Fetch.php';
    require_once $_SESSION['base_url'].'/classes/Implementation/DocInAppliType/Fetch.php';
    require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Edit.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
		
	use classes\implementation\Diary as impDiary;
	use classes\implementation\DocInAppliType as impApplication;
	use classes\implementation\ClosingOfFile as impCof;
	use classes\Pagination as impPage;
	
	$fetchAppli = new impDiary\Fetch();
	$addDoc     = new impDiary\Add();
	$editCof    = new impCof\Edit();
	$fetchDoc   = new impApplication\Fetch();
	$fetchPage  = new impPage\Pagination();
	
	$msg='';
	$errmsg='';
	
   if(isset($_POST['submit']) && $_POST['submit']=='Submit')
	{
		//print_r($_POST); exit;
	
		foreach ($_POST['applicant_name'] as $val)
		{				
			$doc_name[]= $_POST['doc_name'.$val];			
		}
	//	print_r($doc_name) ; exit;

			$appliId = $addDoc->addApplicantionDoc(
					$_POST['diary'], 
					$_POST['application_id'], 
					$_POST['applicant_name'],
					$doc_name, 
					$_POST['receivedDate'] );
			
			$stage_id =2;
			$sub_stage_id =13;
			$flag    = $editCof-> upApplicationStatus($appliId, $stage_id, $sub_stage_id);
			if($flag == 1)
			{
				$msg = "Document has been Submited Successfully.";
				header("location:application_doc.php?msg=$msg&alert=success");
			}
			else 
			{
				$errmsg = "Some error occured";
				header("location:application_doc.php?msg=$errmsg");
			}
		}

		/*

	if(isset($_GET['action']) && $_GET['action']=='del'){
		$flag = $deleteDoc->deleteDocument($_GET['id']);
		if($flag == 1)
		{
			$msg = "Document has been Deleted successfully.";
			header("location:addDocument.php?msg=$msg&alert=success");
		}
		else
		{
			$errmsg = "Some error occured";
			header("location:addDocument.php?msg=$errmsg");
		}
	}
	*/
	
		$singleApplication = $fetchAppli->getSingleApplicationDoc($_GET['appliId']);
	//print_r($singleApplication);

		$docType = $fetchDoc->getAllmatchingData($singleApplication[0]['appli_type_id']);
		//print_r($docType);
		
		$applicants = $fetchAppli->getApplicants($_GET['appliId']);
	//	echo	count($applicants);
		//print_r($applicants);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Dashboard</title>
		<link href="../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../css/styles.css">
		<script type="text/javascript" src="../../js/masking/jquery-1.js"></script>
		<script type="text/javascript" src="../../js/masking/jquery.js"></script>
		<link href="../../css/pagination.css" rel="stylesheet">
	</head>
	<body>
		
		<?php require_once $_SESSION['base_url'].'/include/header.php';?>
			
			 <div class="wrapper" >
			<div id="left-wrapper">	
				<?php include_once 'include/side-menu.php';?>
			</div>
			
			<div id="right-wrapper">
				<div id="breadcrumb">
	     			<ul>
	     				<li><a href="index.php">Dashboard &nbsp;&nbsp;&nbsp;/</a></li>
	     				<li><a href="doc_completion.php">Document Completion &nbsp;&nbsp;&nbsp;/</a></li>
	     				<li><a href="application_doc.php">Document Request Type&nbsp;&nbsp;&nbsp;/</a></li>
	     				<li><a href="#">Applicant Add New Document</a></li>
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
	     				<div id="left-title">Add Applicant Document Document</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;height:250px;padding:7px ">
		     			<div style="width:60.0%;margin-left:10%">
		     				<form name="addDocument" action="#" method="post" onsubmit="return validate();">
		     				<?php 
								for($i = 0; $i < count ( $applicants ); $i ++)
								 {							 
								 ?>
								<div class="clear"></div>
								
								<div class="left">Applicat Name :-</div>
								<div class="right" style="margin-top:6px;">					
									<input	type="checkbox" name="applicant_name[]" id="applicant_name" value="<?php echo $applicants[$i]['id']; ?>" />
										<?php  echo $applicants[$i]['applicant_name']; ?>								
								</div>
									<div class="clear"></div>
								<div class="left">Document Name <span class="red">*</span></div>
								<div class="right">						
								<div style="margin:auto;width:90%">
								<div class="clear"></div>										
							<?php for($j=0;$j<count($docType);$j++)
			                      {				                  
			                     ?>
										 <div class="right">
										 <input	type="checkbox" name="doc_name<?php echo $applicants[$i]['id']; ?>[]" id="doc_name" value="<?php echo $docType[$j]['doc_type_id']; ?>" />
										 <?php echo $docType[$j]['doc_name']; ?>
										 </div> 
										<?php } ?>
								    </div>
								    <div class="clear"></div>
								   
								</div>
								 <?php  } ?>
								
								<!-- <div class="clear"></div>
									<div class="left"> Is Active</div>
									<div class="right">
										<input type="checkbox" name="isActive" id="isActive" />
									</div> -->
								<div class="clear"></div>
								<div class="clear"></div>
								<div class="left"></div>
								<div class="right">
								<input type="hidden" name="application_id" value="<?php echo $_GET['appliId'];?>" />
								<input type="hidden" name="receivedDate" value="<?php echo $singleApplication[0]['received_date'];?>" />
								<input type="hidden" name="diary" value="<?php echo $singleApplication[0]['diary_no'];?>" />
									<input type="submit" class="form-button" name="submit" value="Submit" />
								</div>
							</form>
							</div>
						</div>
					
		     		</div>
		     		<div class="clear"></div>
	     			
	     			
		     		</div>
	     		</div>
	     		<script>
					function validate(){
							var appele=document.getElementById('applicant_name');
							var docele=document.getElementById('doc_name');
							if(appele.value=='')
							{
								alert('Please Select Application Type');
								appele.focus();
								return false;
							}	
						/*	if(docele.checked==false)						
							{
								alert('Select Document Type');
								docele.focus();
								return false;
							}	*/						
						}
					function init(){
							document.getElementById('application_name').focus();
					}
					window.onload=init;
	     		</script>
	
	</body>
</html>