<?php 
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
$msg = '';
$errmsg = '';
	

	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Misc/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Fetch.php';
//	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Edit.php';
//	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Delete.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
	
	use classes\implementation\LetterType as impLetterType;
	use classes\implementation\Misc as impMisc;
	use classes\Pagination as impPage;

	$addLetter    = new impLetterType\Add();
	$fetchStages  = new impMisc\Fetch();
	$fetchLetter  = new impLetterType\Fetch();
	//	$deleteLetter = new impLetterType\Delete();
//	$editLetter   = new impLetterType\Edit();
	$fetchPage = new impPage\Pagination();

		if(isset($_POST['submitLetterType']))
		 {			
		 	 $stage          = (int)trim($_POST['stage']);
		 	 $sub_stage      = (int)trim($_POST['sub_stage']);
		 	 $name           = trim($_POST['name']);
		 	 $title          = trim($_POST['title']);				
			 $letter_no      = trim($_POST['letter_no']);
			 $subject        = trim($_POST['subject']);
			 $header_file_path = trim($_POST['header_file_path']);
			 $body_file_path = trim($_POST['body_file_path']);
			 $note_file_path = trim($_POST['note_file_path']);
			
			 if($name=='' || strlen($name) > 150)
			 	$errMsg[] = "Please Enter Name less than 150 charactor".'<br/>';
			 
			 if($title=='' || strlen($title) > 150)
			 	$errMsg[] = "Please Enter Title File Path less than 150 charactor".'<br/>';
			 
			 if($letter_no=='' || strlen($letter_no) > 150)
			 	$errMsg[] = "Please Enter Leter No less than 100 charactor".'<br/>';
			 
			 if($subject=='' || strlen($subject) > 150)
			 	$errMsg[] = "Please Enter Place less than 150 charactor".'<br/>';
			 
			 if($header_file_path=='' || strlen($header_file_path) > 150)
			 	$errMsg[] = "Please Enter Body File Path less than 150 charactor".'<br/>';
			 
			 if($body_file_path=='' || strlen($body_file_path) > 150)
			 	$errMsg[] = "Please Enter Body File Path less than 150 charactor".'<br/>';
			 
			 if($note_file_path=='' || strlen($note_file_path) > 150)
			 	$errMsg[] = "Please Enter Note File Path less than 150 charactor".'<br/>';
			
			 
	
			
		 if(count($errMsg) == 0)
		 {
			 
			 $flag = $addLetter->addLetterType(
			 		$stage,
			 		$sub_stage,
			 		$name,
			 		$title,			 				 		
			 		$letter_no,
			 		$subject,
			 		$header_file_path,
			 		$body_file_path,
                    $note_file_path );
			 
			 if ($flag == 1)
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
	
	
	$stages = $fetchStages->getAllStages();
	$letterTypes = $fetchLetter->getAllLetterTypes();
//print_r($LetterTypes);
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
	            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="letter_type" 
	            id="letter_type" method="post" onsubmit="return validateLetterType()">
							<h3>Letter Details</h3>
	     					<div style="width:80%;margin-left:1%">
								<div class="clear"></div>
								<div class="left">
										<div class="clear"></div>
										<div class="left">Name <span class="red">*</span></div>
										<div class="right">
										<input type="text"  placeholder="Name" name="name" id="name" maxlength="5" />											
										</div>	
										
										<div class="clear"></div>
										<div class="left">Title File Path<span class="red">*</span></div>
										<div class="right">
										<input type="text"  placeholder="Title" name="title" id="title"/>											
										</div>
										
										<div class="clear"></div>
										<div class="left">Letter Number <span class="red">*</span></div>
										<div class="right">
										<input type="text"  placeholder="Letter Number" name="letter_no" id="letter_no" onKeyPress="return number(event)"/>											
										</div>
											
										<div class="clear"></div>
										<div class="left">Subject <span class="red">*</span></div>
										<div class="right">
										<input type="text"  placeholder="Subject" name="subject" />											
										</div>
																	
						
								</div>
								
								
								<div class="right">										
										<div class="clear"></div>
										<div class="left">Header File Path <span class="red">*</span></div>
										<div class="right">
										<input type="text"  placeholder="Header File Path" name="header_file_path" id="header_file_path"/>											
										</div>	
										
									    <div class="clear"></div>
										<div class="left">Body File Path <span class="red">*</span></div>
										<div class="right">
										<input type="text"  placeholder="Body File Path" name="body_file_path" id="body_file_path"/>											
										</div>
										
										<div class="clear"></div>
										<div class="left">Note File Path <span class="red">*</span></div>
										<div class="right">
										<input type="text"  placeholder="Note File Path" name="note_file_path" id="note_file_path"/>											
										</div>
										
										<div class="clear"></div>
								        <div class="left">Completed Stage  <span class="red">*</span></div>
								        <div class="right">
									<select name="stage"  onchange="change_sub_stages(this.value);">
										<option value="">Select</option>
										<?php
			     						for($i =0;$i<count($stages);$i++)
											{
										?>
			     							<option value="<?php echo $stages[$i]['id']; ?>"><?php echo $stages[$i]['stage_name']; ?></option>
			     						<?php 
											}
			     						?>
									</select>
									</div>
									
									<div class="clear"></div>							
							       <div id="received">
								   <input type="hidden" name="sub_stages" id="sub_stages" value='' />
							       </div> 
							       
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
			     					<th width="7%">Letter No.</th>
			     					<th width="10%">Title</th>			     							     					
			     			 		<th style="width:7%;">Edit</th>
			     			 		
			     					
			     				</tr>
			     				<?php
									     					
								for($i =0;$i<count($letterTypes);$i++)
								{										
								
								$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
     											
     						<tr class="<?php echo $class; ?>" >
     						<td align="center"><?php echo $i+1; ?></td>
                            <td><?php echo $letterTypes[$i]['letter_type_name'];?></td>
				     		<td><?php echo $letterTypes[$i]['letter_no']; ?> </td>
				     		<td><?php echo $letterTypes[$i]['title_file_path']; ?> </td>
				     		<td><a href="#">Edit</a>				     			
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
	 
		<script type="text/javascript" src="../../js/masking/ga.js"></script>
		 
	</body>
</html>
