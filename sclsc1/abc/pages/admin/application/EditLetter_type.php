<?php 
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
		$msg = '';
		$errmsg = '';
	

	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Misc/Fetch.php';	
	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Edit.php';
//	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Delete.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
	
	use classes\implementation\LetterType as impLetterType;
	use classes\implementation\Misc as impMisc;
	use classes\Pagination as impPage;

	$addLetter    = new impLetterType\Add();
	$fetchStages  = new impMisc\Fetch();
	$fetchLetter  = new impLetterType\Fetch();
//	$deleteLetter = new impLetterType\Delete();
	$editLetter   = new impLetterType\Edit();
	$fetchPage = new impPage\Pagination();
	
	
	$msg='';
	$errmsg='';
	
	if(isset($_POST['submitLetterType']))
	{
		$fileName = $_FILES["filepath"]["name"];
		$fileTmpLoc = $_FILES["filepath"]["tmp_name"];
		// Path and file name
		$filepath = $_SESSION['base_url'] . "/pages/admin/application/Letter/".$fileName;
	     $Letter_id= $_POST['Letter_id'];
		$flag = $editLetter->updateLetter($_POST['Letter_id'],$_POST['name'],$_POST['stage'],$_POST['sub_stages'],$filepath);
	 	$fileName = $_FILES["filepath"]["name"];
		$str=explode('.', $fileName);
		$fileName=$str[0].'_'.$Letter_id;
		$NewfileName=$fileName.'.'.$str[1];
		$fileTmpLoc = $_FILES["filepath"]["tmp_name"];
		// Path and file name
		$filepath = $_SESSION['base_url'] . "/pages/admin/application/Letter/".$NewfileName;
		$moveResult = move_uploaded_file($fileTmpLoc, $filepath);
		
		if($flag == 1)
		{
			$msg = "Letter_type has been Updated successfully.";
			header("location:EditLetter_type.php?Letter_id=$Letter_id&msg=$msg&alert=success");
		}
		else
		{
			$errmsg = "Some error occured";
			header("location:EditLetter_type.php??Letter_id=$Letter_id&msg=$errmsg");
		}
	}
	
	$stage_id = $fetchStages->getAllStages();
//	$letterTypes = $fetchLetter->getAllLetterTypes();
    $letterdetails = $fetchLetter->getLetterTypes($_GET['Letter_id']);

	
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
		function change_sub_stages(str)
			{
				if (str.length==0)
				  {
				  	document.getElementById("received").innerHTML="";
				  	return;
				 }
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    document.getElementById("received").innerHTML=xmlhttp.responseText;
			    loadJS = function(src) {
			    	 var jsLink = $("<script type='text/javascript' src='"+src+"'>");
			    	 $("head").append(jsLink); 
			    	 }; 
			    	 loadJS("../../js/through.js");
			    				    
			    }
			  }
			       xmlhttp.open("GET","include/sub_stages.php?q="+str,true);
			       xmlhttp.send();
			}			
		
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
	     				<li><a href="#">Letter Type</a></li>
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
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">Letter Type</div>
     				<div class="right-title" >&nbsp;</div>
	     		</div>
	           <div style="height:auto;border:1px solid #4b8df8;">
	          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?Letter_id='.$_GET['Letter_id'];?>" name="letter_type" id="letter_type" method="post" onsubmit="return validateLetterType()" enctype="multipart/form-data">
							<h3>Letter Details</h3>
						
	     					<div style="width:80%;margin-left:1%">
								<div class="clear"></div>
									<div class="clear"></div>
										<div class="left" style="width:15%;">Type Name <span class="red">*</span></div>
										<div class="right" style="width:80%;">
										<input type="text"  placeholder="Name" name="name" id="name" maxlength="100" value="<?php echo $letterdetails[0]['type_name'];?>" />											
										</div>
										
										
										
										
										<div class="clear"></div>
								        <div class="left" style="width:15%;">Stage </div>
								        <div class="right">
									<select name="stage"  onchange="change_sub_stages(this.value);">
									
										<option value="">Select</option>
										<?php
			     						for($i =0;$i<count($stage_id);$i++)
											{
										?>
										<option value="<?php echo $stage_id[$i]['id']; ?>" <?php if($letterdetails[0]['stage_id']==$stage_id[$i]['id']) echo "selected=selected"; ?>><?php echo $stage_id[$i]['stage_name']; ?></option>
			     						<?php } ?>
									</select>
									</div>
									
									<div class="clear"></div>							
							       <div id="received">
								   <input type="hidden" name="sub_stages" id="sub_stages" value='' />
							       </div> 
										<div class="clear"></div>
										<div class="left" style="width:15%;">File upload</div>
										<div class="right" style="width:80%;">
										<input type="file"  placeholder="Name" name="filepath" id="filepath" maxlength="100" />																					
										</div>	
										</div>
										<div class="clear"></div>
			     						<div class="clear"></div>
							
				     			        <div style="text-align:center;padding:10px 0;">	
				     					<input type="hidden" id="Letter_id" name="Letter_id" 
				     					value="<?php echo $_GET['Letter_id'];?>"/>	
				     					
									<input class="form-button" type="submit" name="submitLetterType" value="Submit"/>
									
								</div>
								
								  </form>
							</div>
						
				
						
					
	     			
						</div>
					</div>
				
				
	     		<script type="text/javascript">
					jQuery(function($){
						$("#mobile_number").mask("999-999-9999", {placeholder: 'XXX/XXX/XXXX'});
                        $("#pincode").mask("999999", {placeholder: 'XXXXXX'});
                        $("#closing_date").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
					});
					$(document).ready(function() {
					    $('form:first *:input[type!=hidden]:first').focus();
					});
				</script>
	     	</div>
	     		</div>	
	 
		<script type="text/javascript" src="../../js/masking/ga.js"></script>
		
	<script type="text/javascript">
	function change_sub_stages2(str,str2)
	{
		
		if (str.length==0)
		  {
		  	document.getElementById("received").innerHTML="";
		  	return;
		 }
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("received").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","ajax/sub_stages2.php?q="+str+"&y="+str2,true);
	xmlhttp.send();
	}
	
			window.onload=change_sub_stages2(<?php echo $letterdetails[0]['stage_id']; ?>,<?php echo $letterdetails[0]['sub_stage_id']; ?>);		
			
		</script>
		 
	</body>
</html>

