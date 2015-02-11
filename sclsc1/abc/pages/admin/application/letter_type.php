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
//	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Edit.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Delete.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
	
	use classes\implementation\LetterType as impLetterType;
	use classes\implementation\Misc as impMisc;
	use classes\Pagination as impPage;

	$addLetter    = new impLetterType\Add();
	$fetchStages  = new impMisc\Fetch();
	$fetchLetter  = new impLetterType\Fetch();
	$deleteLetter = new impLetterType\Delete();
//	$editLetter   = new impLetterType\Edit();
	$fetchPage = new impPage\Pagination();
	
		if(isset($_POST['submitLetterType']))
		 {	
		 			
		 	 $name                =  trim($_POST['name']);
			 $stage               = (int)trim($_POST['stage']);
			 $sub_stages          = (int)trim($_POST['sub_stages']);	
			 $fileName = $_FILES["filepath"]["name"];
			 $fileTmpLoc = $_FILES["filepath"]["tmp_name"];
			 // Path and file name
			 $filepath = $_SESSION['base_url'] . "/pages/admin/application/Letter/".$fileName;
			   
			  if($name=='' || strlen($name) > 150)
			 	$errMsg[] = "Please Enter Name less than 150 charactor".'<br/>';
			
			if(count($errMsg) == 0)
		 {
			 
			 $LetterId = $addLetter->addLetterType(
			 		$name,
			 		$stage,
				    $sub_stages,
                    $filepath);
		
			
			 $fileName = $_FILES["filepath"]["name"];
			 $str=explode('.', $fileName);
			 $fileName=$str[0].'_'.$LetterId;
			 $NewfileName=$fileName.'.'.$str[1];
			 $fileTmpLoc = $_FILES["filepath"]["tmp_name"];
			 // Path and file name
			 $filepath = $_SESSION['base_url'] . "/pages/admin/application/Letter/".$NewfileName;
			 $moveResult = move_uploaded_file($fileTmpLoc, $filepath);
			 
			 if ($LetterId != 1)
			 {
			 	$msg = "Letter Type Add Successfully.";
			 	header("Location:letter_type.php?msg=$msg");
			 }
			 else
			 {
			 	$errmsg = "Letter Type failed ?? Please try again Later.";
			 	header("Location:letter_type.php?errmsg=$errmsg");
			 }
			 
		 }
	}
	
	if(isset($_GET['Letter_id']) && $_GET['action']=='del')
	{
		$LetterDel= $deleteLetter->deleteLetter($_GET['Letter_id']);
		if($LetterDel==1)
		{
			$msg = "Letter Type has been deleted successfully.";
			header("location:letter_type.php?msg=$msg&alert=success");
		}
		else
		{
			$errmsg='Error ?? try again Later';
			header("location:letter_type.php?msg=$msg");
		}
	}
	
	$stage_id = $fetchStages->getAllStages();
	$letterTypes = $fetchLetter->getAllLetterTypes();
	
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
     				<div id="left-title">Letter Type</div>
     				<div class="right-title" >&nbsp;</div>
	     		</div>
	           <div style="height:auto;border:1px solid #4b8df8;">
	          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="letter_type" id="letter_type" method="post" onsubmit="return validateLetterType()" enctype="multipart/form-data">
							<h3>Letter Details</h3>
	     					<div style="width:80%;margin-left:1%">
								<div class="clear"></div>
									<div class="clear"></div>
										<div class="left" style="width:15%;">Type Name <span class="red">*</span></div>
										<div class="right" style="width:80%;">
										<input type="text"  placeholder="Name" name="name" id="name" maxlength="100" />											
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
			     							<option value="<?php echo $stage_id[$i]['id']; ?>"><?php echo $stage_id[$i]['stage_name']; ?></option>
			     						<?php 
											}
											
			     						?>
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
				     					<input type="hidden" id="application_id" name="application_id" 
				     					value="<?php echo $_POST['application_id'];?>"/>	
				     					<input type="hidden" id="slpAction" name="slpAction" 
				     					value="<?php echo $_POST['slpAction'];?>"/>					
									<input class="form-button" type="submit" name="submitLetterType" value="Submit"/>
									
								</div>
								  </form>
							</div>
						
				
						
					<div class="clear"></div>
	     			<div class="clear"></div>
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Letter Type List</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px;">
	     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     				 	<th width="2%" >Sr.No.</th>
			     					<th width="10%">Letter Type </th>
			     					<th width="7%">Stage</th>
			     					<th width="10%">Sub Stage</th>			     							     					
			     			 		<th style="width:7%;">Edit</th>
			     			 		<th style="width:7%;">Delete</th>
			     			 		
			     					
			     				</tr>
			     				<?php
									     					
								for($i =0;$i<count($letterTypes);$i++)
								{										
								$class = ($i % 2 == 0) ? 'even' : 'odd';
								$stage_name=$fetchStages->getStageName($letterTypes[$i]['stage_id']);
								$sub_stage_name=$fetchStages->getSubStagesname($letterTypes[$i]['stage_id']);
							
								?>
     											
     						<tr class="<?php echo $class; ?>" >
     						<td align="center"><?php echo $i+1; ?></td>
                        <!--     <td><a href="<?php //echo "../../../letter/samples/inlineall.php?name=".$letterTypes[$i]['type_name'];?>" target="_blank"><?php //echo $letterTypes[$i]['type_name'];?></a></td> -->
				     		 <td><?php echo $letterTypes[$i]['type_name'];?></td>
				     		<td><?php echo $stage_name; ?> </td>
				     		<td><?php echo $sub_stage_name; ?> </td>
				     		<td><a href="EditLetter_type.php?Letter_id=<?php echo $letterTypes[$i]['id']; ?>&action=edit">Edit</a>
				     		<td><a href="letter_type.php?Letter_id=<?php echo $letterTypes[$i]['id']; ?>&action=del">Delete</a>					     			
					     	</td>
     					</tr>
	     				<?php 
							}
							//echo $pagination;
     					?>
		     				</table>
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
		 
	</body>
</html>
