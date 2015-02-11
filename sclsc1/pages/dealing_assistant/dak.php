<?php 
	session_start();
	
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
	require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/State/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Users/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Category/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThrough/Fetch.php';
	
	use classes\Implementation\Category as impCategory;
	use classes\Implementation\Diary as impDiary;
	use classes\Implementation\State as impState;
	use classes\Implementation\Users as impUser;
	use classes\Implementation\RecievedThrough as impThrough;
	use classes\Pagination as impPage;
	
	$fetchCategory = new impCategory\Fetch();
	$fetchDiary = new impDiary\Fetch();
	$fetchState = new impState\Fetch();
	$fetchUser = new impUser\Fetch();
	$fetchThrough = new impThrough\Fetch();
	$fetchPage     = new impPage\Pagination();
	
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
	}
	
	$diary = $fetchDiary->getUserSpecificPendingDiary($limit, $start,$_SESSION['user']['id']);
	$Records = $fetchDiary->getUserSpecificPendingDiaryCount($_SESSION['user']['id']);
	$url ='';
	$pagination = $fetchPage->paginations($page, $Records, $limit, $targetpage, $adjacents, $url);
	//print_r($diary);
	$nextDiaryNumber = $fetchDiary->getNextDiaryId();
	$states = $fetchState->getAllStates();
	$dealingUsers = $fetchUser->getDealingUsers();
	$categoryIds = $fetchCategory->getEnabledCategoryIds();
	$received_through_type = $fetchThrough->getReceivedThroughType();

?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="<?php echo $_SESSION['base_file_url']; ?>css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../css/styles.css">
		<link rel="stylesheet" href="../../css/pagination.css">
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
	     				<li><a href="index.php">Dashboard &nbsp;&nbsp;&nbsp;</a>/</li>
	     				<li><a href="#">Dok</a></li>
	     			</ul>
	     		</div>
	     		<div class="clear"></div>
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Recent Diary</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px">
		     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     					<th width="2%" >S/N</th>
			     					<th width="8%"><a href="#">Diary No.</a></th>
			     					<th width="25%"><a href="#">Subject</a></th>
			     					<th width="12%"><a href="#">Applicant</a></th>
			     					<th width="13%"><a href="#">State</a></th>
			     					<th width="2%"><a href="#">Letter Date</a></th>
			     					<th width="2%"><a href="#">Recieved Date</a></th>
			     					<th width="2%"><a href="#">Status</a></th>
			     				</tr>
			     				<?php
	     						
	     							for($i =0;$i<count($diary);$i++)
									{
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
				     				<tr class="<?php echo $class; ?>">
				     					<td><?php echo $i+1; ?></td>
				     					<td>
				     						<a ><?php echo $diary[$i]['diary_no']?></a>
        									<div id="light" class="white_content"></div>
        									<div id="fade" class="black_overlay"></div>
				     					<td><?php echo $diary[$i]['subject']; ?></td>
				     					<td><?php echo $diary[$i]['applicant']; ?></td>
				     					<td><?php echo $diary[$i]['state_name']; ?></td>
				     					<td><?php echo $diary[$i]['date_of_letter']; ?></td>
				     					<td><?php echo $diary[$i]['recieved_date']; ?></td>
				     					<td>
				     						<?php 
				     							$status = $diary[$i]['is_taken'] == 1 ? "Done":"New";
				     							if($status == 'Done')
				     							{
				     							?>
				     								<a style="color:#fff;background-color:green;padding:5px;">
				     								<?php echo $status;?>
				     							</a>
				     							<?php 		
				     							}
				     							else 
				     							{
				     						?>
				     							<a href="second_stage.php?id=<?php echo $diary[$i]['id'];?>" style="color:#fff;background-color:red;padding:5px;">
				     								<?php echo $status;?>
				     							</a>
				     						<?php 
				     							}
				     						 ?>
				     					</td>
				     				</tr>
	     						<?php 
									}echo $pagination;
		     					?>
		     					
		     				</table>
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
