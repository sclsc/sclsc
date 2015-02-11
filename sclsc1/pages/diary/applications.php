<?php 
	session_start();
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	

	require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Fetch.php';
	//require_once $_SESSION['base_url'].'/classes/implementation/ClosingOfFile/Delete.php';
	//require_once $_SESSION['base_url'].'/classes/implementation/misc/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
	
	use classes\implementation\ClosingOfFile as impCof;
	//use classes\implementation\misc as impMisc;
	use classes\Pagination as impPage;
	
	//$fetchMisc = new impMisc\Fetch();
	$fetchApplication = new impCof\Fetch();
	//$deletApplication = new impCof\Delete();
	$fetchPage     = new impPage\Pagination();
	
	$msg='';
	$errmsg='';
	$targetpage = 'applications.php';
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
		$applications= $fetchApplication->getApplication($limit,$start);
		$Records = $fetchApplication->getApplicationCount();
		
		$url='';
		$pagination = $fetchPage->paginations($page, $Records, $limit, $targetpage, $adjacents, $url);
	
//print_r($applications);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../css/styles.css">
		<link href="../../css/pagination.css" rel="stylesheet">
		<script type="text/javascript" src="../../js/masking/jquery-1.js"></script>
		<script type="text/javascript" src="../../js/masking/jquery.js"></script>
	 	<script type="text/javascript">
		$(document).ready(function(){
			$('#application_search').keyup(function(){
				$.ajax({
					    type: "POST",
					    url: "applicationByDiary.php?diary_no="+$('#application_search').val(),
					    success: function(result){
						    $('#records').html(result);
					      }
					});
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
	     				<li><a href="index.php">Dashboard /</a></li>
	     				<li><a href="#">All Applications</a></li>
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
	     		if(isset($_GET['msg']))  { ?> 
	     		 <div id="breadcrumb-green">
	     	  
	     			<?php echo $_GET['msg']; ?>
	     		</div>  		
	     		<?php } ?>	
	     		<div class="clear"></div>
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title" class="left" style="text-align:left;">All Applications</div>
	     			<div id="right-title" style="text-align: right;width:300px;float:right;align:middle;">
	     			<input type="text" placeholder="Enter Diary Number" name="application_search" id="application_search" value=""/>
	     			</div> 
	     			</div>
	     			<div id="records" style="border:2px solid #4b8df8;padding:7px;">
		     				<table id="table-records" cellspacing="0px">
			     				<tr>
			     					<th width="2%" >Sr.No.</th>	
			     					<th width="15%">Application Type</th>		     					
			     					<th width="15%">Application No.</th>
			     					<th width="25%">Applicant Name</th>
			     					<th width="15%">Received Date</th>
			     					<th width="10%">Ation</th>		     					
			     				</tr>
			     				
			     				<?php
			     				$hc_address1='';
			     				$hc_address2='';
			                    $city='';
			     				$state_name='';
			     				$pincode='';
	     						
	     							for($i =0;$i<count($applications);$i++)
									{
																				
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
				     				<tr class="<?php echo $class; ?>" align="center">
				     					<td><?php if(isset($_GET['page']) && $_GET['page']>1) {  echo $recordCounter+$i+1; } else if(isset($_GET['page']) && $_GET['page']==1) echo $i+1; else echo $i+1; ?></td>
				     					<td><?php echo $applications[$i]['appli_type_name']; ?></td>
				     					<td><a href="view_application.php?applicationId=<?php echo $applications[$i]['id'] ?>"><?php echo $applications[$i]['diary_no']; ?></a></td>
				     					<td><?php echo $applications[$i]['applicant_name']; ?></td>
				     					<td><?php echo date("d-m-Y", strtotime($applications[$i]['received_date'])); ?></td>
				     					<td><a href="#"> Action </a></td>
				     					
				     					
				     				</tr>
	     						<?php 
									}
									
									echo $pagination;
		     					?>
		     					
		     				</table>
			     		</div>
		     		</div>
	     		</div>
	     	
	     	<script type="text/javascript">
						jQuery(function($){
							$("#pincode").mask("999999", {placeholder: 'XXXXXX'});
						});
					</script>
	   <script type="text/javascript" src="js/masking/ga.js"></script>
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
