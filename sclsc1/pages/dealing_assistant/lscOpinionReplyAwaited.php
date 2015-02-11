<?php 
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
	require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Edit.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
	
	
	
	use classes\Implementation\ClosingOfFile as impCof;	
	use classes\Pagination as impPage;
	
	
	$fetchCof      = new impCof\Fetch();
	$editCof       = new impCof\Edit();
	$addCof        = new impCof\Add();	
	$fetchPage     = new impPage\Pagination();

	
	if (isset($_GET['action']) && isset($_GET['applicationId']))
	{		
		$stage_id =4;
		$sub_stage_id =0;
		
	$flag = $editCof-> upApplicationStatus($_GET['applicationId'], $stage_id, $sub_stage_id);
	
		if ($flag== 1)
		{
			$msg = "Application Send to Secand Openion.";
			header("Location:primaFacieDecision.php?msg=$msg");
		}
		else
		{
			$errmsg = "failed ?? Please try again Later.";
			header("Location:primaFacieReplyAwaited.php?errmsg=$errmsg");
		}
	
	} 
	
	$targetpage = 'lscOpinionReplyAwaited.php';
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
		
	}
	
	$stageId=77;
	$subStageId=83;
	$diary = $fetchCof->getAllApplicationDetails($stageId, $subStageId, $limit, $start);
	$Records = $fetchCof->getAllApplicationCount($stageId, $subStageId);
	$url ='';
	$pagination = $fetchPage->paginations($page, $Records, $limit, $targetpage, $adjacents, $url);
	
	
//	print_r($diary);


?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../css/styles.css">
		<link rel="stylesheet" href="../../css/pagination.css">
		
		<script type="text/javascript">

		function applicationAction(str)
		{	
								
			document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'
		if (str.length==0)
		  {
		  document.getElementById("light").innerHTML="";
		  return;
		  }
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
		    document.getElementById("light").innerHTML=xmlhttp.responseText;
		    }
		  }
		xmlhttp.open("GET","applicationAction.php?q="+str,true);
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
	     				<li><a href="index.php">Dashboard &nbsp;&nbsp;&nbsp;&nbsp;</a>/</li>
	     				<li><a href="pendingCOF.php">Closing of file &nbsp;&nbsp;&nbsp;&nbsp;</a>/</li>
	     				<li><a href="lscOpinion.php">LSC Opinion &nbsp;&nbsp;&nbsp;&nbsp;</a>/</li>
	     				<li><a href="#">LSC Opinion Reply Awaited</a></li>
	     			</ul>
	     		</div>
	     		
	     	<div class="clear"></div>
	     		<?php if($_GET['msg'] != '')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-green">
	     			<?php echo $_GET['msg'];?>	
	     		</div>
	     		<?php 
	     		}
	     		?>
	     		<?php if($_GET['errmsg'] != '')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-red">
	     			<?php echo $_GET['errmsg'];	?>	
	     		</div>
	     		<?php 
	     		}
	     		?>
	     		
	     		<div class="clear"></div>
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Recent Diary</div>
	     				<div id="right-title"></div>
	     				
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px">
		     				<table id="table-records">
			     				<tr>
			     					<th width="2%" >Sr.No.</th>	
			     					<th width="15%">Application Type</th>		     					
			     					<th width="10%">Application No.</th>
			     					<th width="25%">Applicant Name</th>				     								     					
			     					<th width="10%">Status</th>		
			     					 <th width="15%"> Decision over Opinion	</th>			
			     					</tr>
			     				<?php
			     				$hc_address1='';
			     				$hc_address2='';
			                    $city='';
			     				$state_name='';
			     				$pincode='';
	     						
	     							for($i =0;$i<count($diary);$i++)
									{								    
									    $primaFacieReply = $fetchCof->primaFacieReply($diary[$i]['id'], $stageId);
									   // print_r($primaFacieReply);
									    $is_in_favour = $primaFacieReply['is_in_favour'];
									    
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
				     				<tr class="<?php echo $class; ?>" align="center">
				     					<td><?php if(isset($_GET['page']) && $_GET['page']>1) {  echo $recordCounter+$i+1; } else if(isset($_GET['page']) && $_GET['page']==1) echo $i+1; else echo $i+1; ?></td>
				     					<td><?php echo $diary[$i]['appli_type_name']; ?></td>
				     					<td><a href="view_application.php?applicationId=<?php echo $diary[$i]['id'] ?>"><?php echo $diary[$i]['diary_no']; ?></a></td>
				     					<td><?php echo $diary[$i]['applicant_name']; ?></td>	
				     					<td>
				     					<?php 
				     					if($is_in_favour==1)
				     					{
				     						echo "Decision in Favour";				     					
				     					?>
				     					<a href="primaFacieReplyAwaited.php?applicationId=<?php echo $diary[$i]['id'] ?>&action=up"  onclick="return confirm('Are you sure you want to go to Secand Opinion?')">Second Opinion</a>
				     					<?php
				     					}
				     					else 
				     					{
				     					?>		
				     						     								     					
				     					 <a href="#">Wait for Reply</a>
				     					 <?php } ?>
				     					 </td>
				     					 <td>
				     					 <?php 
				     					 if($is_in_favour==1)
				     					 {
				     					 	echo "Decision Submited";
				     					 }
				     					 else
				     					 {
				     					 ?>
				     					  <a href="primaFacieDecisionReply.php?applicationId=<?php echo $diary[$i]['id'] ?>&appliNo=<?php echo $diary[$i]['diary_no']; ?>">Decision</a>	
				     						<?php } ?>	
				     					</td>		     				
				     				</tr>  				
		     					
		     			     	<?php 
									}									
									 echo $pagination;									 
		     					?>
		     					
		     				</table>
		     				<div id="light" class="white_content" style="width:23%;height:30%"></div>
        							<div id="fade" class="black_overlay"></div>
			     		</div>
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
			</script>
	</body>
</html>
