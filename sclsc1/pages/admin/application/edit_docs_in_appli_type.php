<?php 
	session_start();
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');	
	
	require_once $_SESSION['base_url'].'/classes/Implementation/ApplicationTypes/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/DocumentTypes/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/DocInAppliType/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/DocInAppliType/Edit.php';
	
	use classes\implementation\DocInAppliType as impDocInAppliType;
	use classes\implementation\DocumentTypes as impDocType;
	use classes\implementation\ApplicationTypes as impApplication;

	$fetchApplication = new impApplication\Fetch();
	$fetchDoc         = new impDocType\Fetch();
	$fetchDocAppli    = new impDocInAppliType\Fetch();
	$editDocAppli     = new impDocInAppliType\Edit();
	

	$msg='';
	$errmsg='';
	
   if(isset($_POST['submit']))
	{
		//print_r($_POST); 
	//	print_r($_POST['hiddenDoc']);	exit;
	
		
   		$flag = $editDocAppli->updateDocAplliType($_POST['application_name'],$_POST['doc_name'],$_POST['hiddenDoc']);
			if($flag == 1)
			{
				$msg = "Applicattion Request has been Updated successfully.";
				header("location:docs_in_appli_type.php?msg=$msg&alert=success");
			}
			else 
			{
				$errmsg = "Some error occured";
				header("location:docs_in_appli_type.php?msg=$errmsg");
			}
		}

	$applicationTypes = $fetchApplication->getAllApplicationType(Null,Null);
	$documents        = $fetchDoc->getAllDocuments(Null,Null);	
	$docRequestType   = $fetchDocAppli->getSingleDocRequest($_GET['appliId']);

//print_r($documents).'=========';
//	print_r($docRequestType);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Dashboard</title>
		<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<script type="text/javascript" src="../../js/masking/jquery-1.js"></script>
		<script type="text/javascript" src="../../js/masking/jquery.js"></script>
		<link href="../../../css/pagination.css" rel="stylesheet">
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
	     				<li><a href="index.php">Home &nbsp;&nbsp;&nbsp;/</a></li>
	     				<li><a href="#">Document Request Type</a></li>
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
	     				<div id="left-title">Document Request Type</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;height:250px;padding:7px ">
		     			<div style="width:60.0%;margin-left:10%">
		     				<form name="addDocument" action="#" method="post" onsubmit="return validate();">
								<div class="clear"></div>
								<div class="left">Application Type <span class="red">*</span></div>
								<div class="right">							
									<select name="application_name" id="application_name">
									<option value=''>Select</option>
									<?php
									for($i = 0; $i < count ( $applicationTypes ); $i ++) {
										?>
										<option value="<?php echo $applicationTypes[$i]['id']; ?>" <?php if ($applicationTypes[$i]['id']==$_GET['appliId']) { echo  "selected=selected"; } ?> ><?php echo $applicationTypes[$i]['appli_type_name']; ?></option>
									<?php
									}
									?>
									</select>
								</div>
									<div class="clear"></div>
								<div class="left">Document Name <span class="red">*</span></div>
								<div class="right">						
								<div style="margin:auto;width:90%">
								<div class="clear"></div>										
										<?php									
										 for($i =0;$i<count($documents);$i++)
										 {										
										 ?>
										 <div class="right">
										 <input	type="checkbox" name="doc_name[]" id="doc_name" value="<?php echo $documents[$i]['id']; ?>"
										  <?php if(in_array($documents[$i]['id'], $docRequestType)) { echo "checked=checked"; } ?> />
										 <?php echo $documents[$i]['doc_name']; ?>
										 </div> 
										<?php } ?>
								    </div>
								</div>
								
								
								<!-- <div class="clear"></div>
									<div class="left"> Is Active</div>
									<div class="right">
										<input type="checkbox" name="isActive" id="isActive" />
									</div> -->
								
								<div class="clear"></div>
								<div class="left"></div>
								<div class="right">
								<?php foreach($docRequestType as $value)
								{
								  echo '<input type="hidden" name="hiddenDoc[]" value="'. $value. '">';								  
								} 
								?>
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
							var appele=document.getElementById('application_name');
							var docele=document.getElementById('doc_name');
							if(appele.value=='')
							{
								alert('Please Select Application Type');
								appele.focus();
								return false;
							}							
								var i, chks = document.getElementById('doc_name');
								for (i = 0; i < chks.length; i++){
								    if (chks[i].checked){
								        return true;
								    }else{
								    	alert('Please Select Document Type');
								        docele.focus();
								        return false;
								    }
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