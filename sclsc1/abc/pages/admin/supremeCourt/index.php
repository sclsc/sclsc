<?php 
	session_start();
	if(!isset($_SESSION['user_name']))
		header('location:../../login.php');
	$diary_number='';
	$received_date='';
	$received_through_type='';
	$received_through='';
	
	$msg = '';
	$errmsg = '';
	$reg_flag = array();
	$lastDiaryNumber = '';
	
	require_once '../../classes/implementation/users/Fetch.php';
	require_once '../../classes/implementation/misc/Fetch.php';
	require_once '../../classes/implementation/diary/Fetch.php';
	
	use classes\implementation\users as impUser;
	use classes\implementation\misc as impMisc;
	use classes\implementation\diary as impDairy;
	
	$fetchUser = new impUser\Fetch();
	$fetchMisc = new impMisc\Fetch();
	$fetchApplicationAdvocate = new impDairy\Fetch();
	
	
	
	$received_through_type_ids = $fetchMisc->getReceivedThroughType();
	
	if(isset($_SESSION['diary_number']))
	{
		$diary_number          =  $_SESSION['diary_number'];
		$received_date         =  $_SESSION['received_date'];
		$received_through_type =  $_SESSION['received_through_type'];
		$received_through      =  $_SESSION['received_through'];
		
	/*	$diary        = explode('/',$diary_number);
		$diary_number = $diary[0];
		$year         = $diary[1];
	*/
	}
	
	$targetpage = 'index.php';
	$adjacents = 2;
	$limit = 10;
	$start = 0;
	$page = 0;
	
	if(isset($_GET['page']))
	{
		$page = $_GET['page'];
		if($page){
			$start = ($page - 1) * $limit;
			$recordCounter=$start;
		}
		else
			$start = 0;
		$applicationAdvocate= $fetchApplicationAdvocate->getCurrentApplicationDetails($limit,$start,$_SESSION['id']);
		$Records = $fetchApplicationAdvocate->getCurrentApplicationCount($_SESSION['id']);
	
		//$url = 'fromDate='.$_GET['fromDate'].'&toDate='.$_GET['toDate'].'&application_type='.$_GET['application_type'].'&through_type='.$_GET['through_type'].'&last_statge='.$_GET['last_statge'].'&state='.$_GET['state'];
		$url='';
		$pagination = $fetchMisc->paginations($page,$Records,$limit,$targetpage,$adjacents,$url);
	
	}
	
	if(!isset($_GET['page'])){
		$applicationAdvocate= $fetchApplicationAdvocate->getCurrentApplicationDetails($limit,$start,$_SESSION['id']);
	
		$Records = $fetchApplicationAdvocate->getCurrentApplicationCount($_SESSION['id']);
	
		//$url = 'fromDate='.$_GET['fromDate'].'&toDate='.$_GET['toDate'].'&application_type='.$_GET['application_type'].'&through_type='.$_GET['through_type'].'&last_statge='.$_GET['last_statge'].'&state='.$_GET['state'];
		$url='';
		$pagination = $fetchMisc->paginations($page,$Records,$limit,$targetpage,$adjacents,$url);
	}
	
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
		<script src="../../js/validation.js"></script>
		
		<script>
		function change_received_type(str)
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
			xmlhttp.open("GET","received_through.php?q="+str,true);
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
	     				<li><a href="#">Home </a></li>
	     				
	     			</ul>
	     		</div>
	     		<div class="clear"></div>
	     		<?php if(isset($_SESSION['msg']) && !isset($_SESSION['alert']))
	     		{	
	     		?>
	     	   	<div id="breadcrumb-red">
	     			<?php echo $_SESSION['msg'];?>	
	     		</div>
	     		<?php 
	     		unset($_SESSION['msg']);
	     		unset($_SESSION['alert']);
	     		}
	     		 if(isset($_SESSION['msg']) && isset($_SESSION['alert']))
	     		{	
	     		?>
	     	   <div id="breadcrumb-green">
	     			<?php echo $_SESSION['msg']; ?>
	     		</div>
	     		<?php 
	     		unset($_SESSION['msg']);
	     		unset($_SESSION['alert']);
	     		} 	     		
	     		?>
	     		<div class="clear"></div>
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">Backlog Data Entry Module</div>
     				<div class="right-title" id="diary_num">&nbsp;</div>
	     		</div>
	     		<form action="applicant_details.php" method="post" onsubmit="return validateDiary()" name="diary">
		     		<div style="height:240px;border:1px solid #4b8df8;">
						<h3>Diary Details</h3>
     					<div style="width:60%;margin-left:10%">
							<div class="clear"></div>
							<div class="left"> Diary Number <span class="red">*</span></div>
							<div class="right">
								<input type="text" name="diary_number" id="diary_number" placeholder=" Diary Number " value="<?php echo $diary_number; ?>" />
							</div>
							<div class="clear"></div>
							<div class="left"> Received Date <span class="red">*</span></div>
							<div class="right">
								<input type="text" id="received_date" name="received_date" placeholder=" Received Date " onblur="myFunction(diary)" value="<?php echo $received_date; ?>" />
							</div>
							<div class="clear"></div>
							<div class="left"> Received Through </div>
							<div class="right">
								<select name="received_through_type" id="received_through_type" onchange="change_received_type(this.value);">
									<option value="">Select</option>
									<?php
		     						for($i =0;$i<count($received_through_type_ids);$i++)
										{
									?>
		     							<option value="<?php echo $received_through_type_ids[$i]['id']?>"<?php if($received_through_type_ids[$i]['id']==$received_through_type) { echo "selected=selected"; } ?> ><?php echo $received_through_type_ids[$i]['appli_through_type_name']; ?></option>
		     						<?php 
										}
		     						?>
								</select> 
							</div>
							<div class="clear"></div>
							
							<div id="received">
								<input type="hidden" name="received_through" id="received_through" value='' />
							</div> 
								
							<div class="clear"></div>
							<div class="left"></div>
							<div class="right">
								<input type="submit" class="form-button" name="submitDiary" value="Next" />
							</div>
						</div>
					</div>
				</form>
	     		<script type="text/javascript">
					jQuery(function($){
						$("#received_date").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
					});
					$(document).ready(function() {
					    $('form:first *:input[type!=hidden]:first').focus();
					});
				</script>
				
	  		<div class="clear"></div>
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Today Entries</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px;">
		     			<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     					<th width="2%" >Sr.No.</th>	
			     					<th width="15%">Application Type</th>		     					
			     					<th width="15%">Application No.</th>
			     					<th width="25%">Applicant Name</th>
			     					<th width="15%">Received Date</th>
			     					<th width="20%">Last Complited Statge</th>
			     					<th width="10%">Edit</th>					
			     					</tr>
			     				<?php
			     				$hc_address1='';
			     				$hc_address2='';
			                    $city='';
			     				$state_name='';
			     				$pincode='';
	     						
	     							for($i =0;$i<count($applicationAdvocate);$i++)
									{
																				
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
				     				<tr class="<?php echo $class; ?>" align="center">
				     					<td><?php if(isset($_GET['page']) && $_GET['page']>1) {  echo $recordCounter+$i+1; } else if(isset($_GET['page']) && $_GET['page']==1) echo $i+1; else echo $i+1; ?></td>
				     					<td><?php echo $applicationAdvocate[$i]['appli_type_name']; ?></td>
				     					<td><a href="view_application.php?applicationId=<?php echo $applicationAdvocate[$i]['id'] ?>"><?php echo $applicationAdvocate[$i]['diary_no']; ?></a></td>
				     					<td><?php echo $applicationAdvocate[$i]['applicant_name']; ?></td>
				     					<td><?php echo date("d-m-Y", strtotime($applicationAdvocate[$i]['received_date'])); ?></td>
				     					<td><?php echo $applicationAdvocate[$i]['stage_name']; ?></td>
				     					<td><a href="editIndex.php?applicationId=<?php echo $applicationAdvocate[$i]['id'] ?>">Edit</a></td>				     				
				     				</tr>
	     						
		     					
		     			     	<?php 
									}
									
									 echo $pagination;
		     					?>
		     					
		     				</table>
			     		</div>
			     		
		     		</div>
	     		</div>
		
		<script type="text/javascript" src="../../js/masking/ga.js"></script>
		<script type="text/javascript">
		    if (typeof(_gat)=='object')
		        setTimeout(function(){
		            try {
		                var pageTracker=_gat._getTracker("UA-10112390-1");
		                pageTracker._trackPageview()
		            } catch(err) {}
		        }, 1500);	

			function change_received_type2(str,str2)
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
			xmlhttp.open("GET","received_through2.php?q="+str+"&y="+str2,true);
			xmlhttp.send();
			}	
			window.onload=change_received_type2(<?php echo $received_through_type; ?>,<?php echo $received_through; ?>);		
		</script>
	</body>
</html>
