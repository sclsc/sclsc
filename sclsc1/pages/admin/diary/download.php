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
	
	//print_r($_REQUEST);
	use classes\implementation\Diary as impDiary;
	use classes\implementation\Category as impCategory;
	use classes\Implementation\State as impState;
	use classes\Implementation\RecievedThrough as impThrough;
	use classes\Implementation\Users as impUser;
	use classes\Pagination as impPage;

	$fetchCategory = new impCategory\Fetch();
	$fetchDiary    = new impDiary\Fetch();
	$fetchState    = new impState\Fetch();
	$fetchThrough  = new impThrough\Fetch();
	$fetchUser     = new impUser\Fetch();
	$fetchPage     = new impPage\Pagination();
	
	$allDiary = array();
	$url = '';
	

	$targetpage = 'advanceDiarySearch.php';
	$adjacents = 2;
	$limit = 10;
	$start = 0;
	$page = 0;
	
	if(isset($_GET['page']))
	{
		$page = $_GET['page'];
		if($page)
			$start = ($page - 1) * $limit;
		else
			$start = 0;
		
	
		$allDiaries = $fetchDiary->getSpecificDiary($_GET['fromDate'],$_GET['toDate'],(int)$_GET['user'],(int)$_GET['received_through_type'],(int)$_GET['state'],$limit,$start);
		$Records = $fetchDiary->getSpecificDiaryCount($_GET['fromDate'],$_GET['toDate'],(int)$_GET['user'],(int)$_GET['received_through_type'],(int)$_GET['state']);
		$url = 'fromDate='.$_GET['fromDate'].'&toDate='.$_GET['toDate'].'&user='.(int)$_GET['user'].'&received_through_type='.(int)$_GET['received_through_type'].'&state='.(int)$_GET['state'];
		//	$url ='';
		$pagination = $fetchPage->paginations($page,$Records,$limit,$targetpage,$adjacents, $url);
	}
	if(isset($_POST['submit']))
	{
        $allDiaries = $fetchDiary->getSpecificDiary($_POST['fromDate'],$_POST['toDate'],(int)$_POST['user'],(int)$_POST['received_through_type'],(int)$_POST['state'],$limit,$start);
		$Records = $fetchDiary->getSpecificDiaryCount($_POST['fromDate'],$_POST['toDate'],(int)$_POST['user'],(int)$_POST['received_through_type'],(int)$_POST['state']);
		$url = 'fromDate='.$_POST['fromDate'].'&toDate='.$_POST['toDate'].'&user='.(int)$_POST['user'].'&received_through_type='.(int)$_POST['received_through_type'].'&state='.(int)$_POST['state'];
	//	$url ='';
		$pagination = $fetchPage->paginations($page,$Records,$limit,$targetpage,$adjacents, $url);

	}
	
	
	$categoryIds = $fetchCategory->getEnabledCategoryIds();
	$received_through = $fetchThrough->getThroughType();
	$states = $fetchState->getAllStates();
	$users = $fetchUser->getAllUsers();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../../css/style.css" rel="stylesheet" />
		<link href="../../../css/pagination.css" rel="stylesheet">
		<script type="text/javascript" src="../../../js/masking/jquery-1.js"></script>
		<script type="text/javascript" src="../../../js/masking/jquery.js"></script>
		<link rel="stylesheet" href="../../../css/styles.css">
		<style>
			.type{
				display:none
			}
		</style>
	
		
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
	     				<li><a href="index.php">Dashboard &nbsp;&nbsp;&nbsp;/</a></li>
	     				<li><a href="#">Generate Report</a></li>
	     				
	     			</ul>
	     		</div>
	     	   		
	     		<div class="clear"></div>
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
		     				<div id="left-title">Generate Report</div>
		     				<div id="right-title"></div>
		     			</div>
	     			<div style="border:2px solid #4b8df8;padding:20px 10px;height:40px;">
		     			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
		     			<div style="float:left;margin-right:10px;">
		     					<select name="user" >
		     						<option value="All">Mark To</option>
										<?php for($i = 0; $i < count($users); $i++)
										{											
										?>										
										<option value="<?php echo $users[$i]['id']; ?>" <?php if($users[$i]['id']==$_POST['user'] || $users[$i]['id']==$_GET['user']) { echo "selected=selected"; } ?> ><?php echo $users[$i]['user_name']; ?></option>
										<?php 
										}
										?>
		     					</select>
		     				</div> 
		     				<div style="float:left;margin-right:10px;">
		     					<select name="received_through_type" id="received_through_type" class="chosen-select" onchange="change_received_type(this.value);">
										<option value="All">Received Through</option>
										<?php
			     						for($i =0;$i<count($received_through);$i++)
										{											
										?>
		     								<option value="<?php echo $received_through[$i]['id']?>"<?php if($received_through[$i]['id']==$_POST['received_through_type'] || $received_through[$i]['id']==$_GET['received_through_type']) { echo "selected=selected"; } ?> ><?php echo $received_through[$i]['designation']; ?></option>
		     							<?php											
										}
			     						?>
									</select> 
		     				</div>
		     				<div style="float:left;margin-right:10px;">
		     					<select name="state" id="applicant_state">
		     							<option value="All">Select State</option>
		     						<?php
		     						for($i =0;$i<count($states);$i++)
									{
									?>
		     							<option value="<?php echo $states[$i]['id']; ?>" <?php if($states[$i]['id']==$_POST['state'] || $states[$i]['id']==$_GET['state']) { echo "selected=selected"; } ?> ><?php echo $states[$i]['state_name']; ?></option>
		     						<?php 
									}
		     						?>
		     						</select>
		     				</div>
		     				
		     				<div>
		     					<div style="float:left;margin-right:10px;"><input name="fromDate" value="<?php if(isset($_POST['fromDate'])) echo $_POST['fromDate'];  else  echo $_GET['fromDate'];  ?>"  id="date1" PLaceholder="From Date" size="10" maxlength="10" style="width: 90px;" type="text" required="required"/></div>
								<div style="float:left;margin-right:10px;"><input name="toDate" value="<?php if(isset($_POST['toDate'])) echo $_POST['toDate']; else echo $_GET['toDate'] ?>"  id="date2" size="10" placeholder="To Date" maxlength="10" style="width: 90px;" type="text" required="required"/></div>
							</div>
							<div style="float:left;margin:0px 10px;">
								<input type="submit" name="submit" value="Show" class="form-button"  />
							</div>
						</form>
						<script type="text/javascript">
						jQuery(function($){
							$("#date0").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
							$("#date1").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
							$("#date2").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
						});
						</script>
		     		</div>
		     		
	     		</div>
	     		<?php
	     			if(isset($_POST['submit']) || isset($_GET['page']))
					{						
					?>
	     		<div class="clear"></div>
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
		     				<div id="left-title">Diary List</div>
		     				<div id="right-title"><a href="generate1.php?<?php echo $url; ?>">Download</a></div>
		     			</div>
	     			<div style="border:2px solid #4b8df8;padding:0px 10px;">
		     			<div class="clear"></div>
		     			<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
		     				<tr width="100%">
			     					<th width="2%" >S/N</th>
			     					<th width="8%">Diary No.</th>
			     					<th width="25%">Subject</th>
			     					<th width="12%">Applicant</th>
			     					<th width="10%">Mark To</th>
			     					<th width="13%">State</th>			     					
			     					<th width="2%">Recieved Date</th>
			     				</tr>
		     				<?php
		     				if(count($allDiaries) == 0)
		     				{
		     				?>
		     					<tr>
		     						<td colspan="5">No records found..</td>
		     					</tr>
     						<?php 
		     				}
		     				//print_r($allDiaries);
     						for($i =0;$i<count($allDiaries);$i++)
								{
									$class = ($i % 2 == 0) ? 'even' : 'odd';
							?>
				     				<tr class="<?php echo $class; ?>">
				     					<td><?php echo $i+1; ?></td>
				     					<td><a href="diary-details.php?id=<?php echo $allDiaries[$i]['id']; ?>"><?php echo $allDiaries[$i]['diary_no']; ?></a></td>
				     					<td><?php echo $allDiaries[$i]['subject']; ?></td>
				     					<td><?php echo $allDiaries[$i]['applicant']; ?></td>
				     					<td><?php echo $allDiaries[$i]['mark_to']; ?></td>
				     					<td><?php echo $allDiaries[$i]['sender_state']; ?></td>				     					
				     					<td><?php echo $allDiaries[$i]['recieved_date']; ?></td>
				     				</tr>
     						<?php 
								}echo $pagination;
	     					?>
	     					<tr>
	     						<td>
	     							
	     						</td>
	     					</tr>
		     			</table>
		     		</div>
	     		</div>
	     		<?php 
				}
	     		?>
	     	</div> 
	    </div>
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
