 <?php 
 session_start();
 
 require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Edit.php';
 
 use classes\Implementation\ClosingOfFile as impCof;
 
 $editCof     = new impCof\Edit();
 
 if (isset($_POST['application_id']) && $_POST['secand_opinion']=="Secand Opinion")
 { 	
 	$application_id = $_POST['application_id'];
 	
		 if ($_POST['slpAction']=="Opinion Required")
		 { 	
		 header("Location:reGenerateOpinionLetter.php?application_id=$application_id");
		 }
		 
		else if ($_POST['slpAction']=="Decision over Opinion")
		 {
		 	header("Location:primaFacieDecisionReply.php?applicationId=$application_id");
		 } 
		 else 
		 {
		 	$stage_id =17;
		 	$sub_stage_id =0;
		 	$flag = $editCof-> upApplicationStatus($application_id, $stage_id, $sub_stage_id);
			 
			 if ($flag ==1)
			 {
			 	$msg = "Application Status is set to File Closing.";
			 	header("Location:index.php?msg=$msg");
			
			 }
			 else
			 {
			 	$errmsg = "Failed ?? Please try again Later.";
			 	header("Location:cof.php?errmsg=$errmsg");
			 }
			 
		 }
 
 }
 
 ?>
 <script>		
	function submit(){		
		$('#form1').submit();
		$('#light').fade();
	
		}
 </script>
		<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</a>	
		
		<div style="font-size:24px;color:#4b8df8;text-align:center;width:100%;padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #eee">&nbsp;</div>
	
		<div style="font-size:24px;color:#4b8df8;width:100%;padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #eee">If Documents received from advocate ?</div>
		     		
     	
     	<div align="left">
     	<form id="form1" action="fitForFilingAction.php" method="POST">
     		<input type="radio" name="slpAction" value="Opinion Required" onclick="submit()"> If opinion Required from another Advocate <br/>
     		<input type="radio" name="slpAction" value="Decision over Opinion"  onclick="submit()"> Decision over Opinion <br/>
     		<input type="radio" name="slpAction" value="Not Required"  onclick="submit()"> Opinion not Required
     		<input type="hidden" name="application_id" value="<?php echo $_GET['q'];?>"> 
     		<input type="hidden" name="secand_opinion" value="Secand Opinion">    		
		</form>
		</div>
		     
		     	

		     		
		     		
		     				