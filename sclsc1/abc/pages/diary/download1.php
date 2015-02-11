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
	use classes\Pagination as impPage;

	$fetchCategory = new impCategory\Fetch();
	$fetchDiary = new impDiary\Fetch();
	$fetchState = new impState\Fetch();
	$fetchThrough = new impThrough\Fetch();
	$fetchPage     = new impPage\Pagination();
	
	$allDiary = array();
	$url = '';
	
	$categoryIds = $fetchCategory->getEnabledCategoryIds();
	$received_through_type = $fetchThrough->getReceivedThroughType();
	$states = $fetchState->getAllStates();
	$targetpage = 'download.php';
	$adjacents = 2;
	$limit = 1;
	$start = 0;
	$page = 0;
	
	if(isset($_GET['page']))
	{
		$page = $_GET['page'];
		if($page)
			$start = ($page - 1) * $limit;
		else
			$start = 0;
	}
	if(isset($_POST['submit']))
	{
		switch ($_POST['type'])
		{
			case 'daily' : $allDiaries = $fetchDiary->getSpecificDiary($_POST['dailyDate'],$_POST['category'],$limit,$start);
							$Records = $fetchDiary->getSpecificDiaryCount($_POST['dailyDate'],$_POST['category']);
							$pagination = $fetchPage->paginations($page,$Records,$limit,$targetpage,$adjacents);
							$url = '?dailyDate='.$_POST['dailyDate'].'&type=daily&category='.$_POST['category'];
							break;
				
			case 'monthly' : $allDiaries = $fetchDiary->getMonthlyDiary($_POST['month'],$_POST['year'],$_POST['category'],$limit,$start);
							$Records = $fetchDiary->getSpecificDiaryCount($_POST['month'],$_POST['year']);
							$pagination = $fetchPage->paginations($page,$Records,$limit,$targetpage,$adjacents);
							$url = '?month='.$_POST['month'].'&year='.$_POST['year'].'&type=monthly&category='.$_POST['category'];
							break;
				
			case 'betweenDate' : $allDiaries = $fetchDiary->getDateSpecificDiary($_POST['fromDate'],$_POST['toDate'],$_POST['category'],$limit,$start);
							$Records = $fetchDiary->getDateSpecificDiaryCount($_POST['fromDate'],$_POST['toDate'],$_POST['category']);
							$url = '?fromDate='.$_POST['fromDate'].'&toDate='.$_POST['toDate'].'&type=betweenDate&category='.$_POST['category'];
							$pagination = $fetchPage->paginations($page,$Records,$limit,$targetpage,$adjacents);
							break;
				
			default : echo "Select an option";break;
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../css/style.css" rel="stylesheet" />
		<link href="../../css/pagination.css" rel="stylesheet">
		<script type="text/javascript" src="../../js/masking/jquery-1.js"></script>
		<script type="text/javascript" src="../../js/masking/jquery.js"></script>
		<link rel="stylesheet" href="../../css/styles.css">
		<style>
			.type{
				display:none
			}
		</style>
		<script>
		function showCustomer(str)
		{
			switch (str)
			{
			case 'daily': $(".type").hide(); $("#daily").show();
				break;
				
			case 'monthly': $(".type").hide(); $("#monthly").show();
				break; 	

			case 'betweenDate': $(".type").hide(); $("#betweenDate").show();
				break;

			default : $(".type").hide();
				break;
			}
		}
		$(document).ready(function() {
		    if ($("select[name=type] option:selected").val() == 'daily') {
		        $("#daily").attr("style", "display:block");
		    }
		    if ($("select[name=type] option:selected").val() == 'monthly') {
		        $("#monthly").attr("style", "display:block");
		    }
		    if ($("select[name=type] option:selected").val() == 'betweenDate') {
		        $("#betweenDate").attr("style", "display:block");
		    }
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
	     				<li><a href="diary.php">Diary /</a></li>
	     				<li><a href="diary.php">Report</a></li>
	     			</ul>
	     		</div>
	     	   		
	     		<div class="clear"></div>
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
		     				<div id="left-title">Generate Report</div>
		     				<div id="right-title"></div>
		     			</div>
	     			<div style="border:2px solid #4b8df8;padding:20px 10px;height:40px;">
		     			<form action="download.php" method="post">
		     			<!-- <div style="float:left;margin-right:20px;">
		     					<select name="category" required="required">
		     						<option value="">Select Category</option>
										<?php for($i = 0; $i < count($categoryIds); $i++)
										{
											if($categoryIds[$i]['id'] == $_POST['category'])
											{
										?>
												<option selected="selected" value="<?php echo $categoryIds[$i]['id']; ?>"><?php echo $categoryIds[$i]['category_name']; ?></option>
										<?php 
											$i++;
											}
										?>
										<option value="<?php echo $categoryIds[$i]['id']; ?>"><?php echo $categoryIds[$i]['category_name']; ?></option>
										<?php 
										}
										?>
		     					</select>
		     				</div> -->	
		     				<div style="float:left;margin-right:20px;">
		     					<select name="received_through_type" id="received_through_type" class="chosen-select" onchange="change_received_type(this.value);">
										<option value="">Received Through</option>
										<?php
			     						for($i =0;$i<count($received_through_type);$i++)
										{
										?>
		     								<option value="<?php echo $received_through_type[$i]['id']?>"<?php if($received_through_type[$i]['id']==$received_through_type) { echo "selected=selected"; } ?> ><?php echo $received_through_type[$i]['appli_through_type_name']; ?></option>
		     							<?php 
										}
			     						?>
									</select> 
		     				</div>
		     				<div style="float:left;margin-right:20px;">
		     					<select name="state" required="required" id="applicant_state">
		     							<option value=''>Select State</option>
		     						<?php
		     						for($i =0;$i<count($states);$i++)
									{
									?>
		     							<option value="<?php echo $states[$i]['id']; ?>"><?php echo $states[$i]['state_name']; ?></option>
		     						<?php 
									}
		     						?>
		     						</select>
		     				</div>
		     				<div style="float:left;margin-right:20px;">
		     					<select name="type"  required="required" onchange="showCustomer(this.value)" >
		     						<option value="">Select Type</option>
	     							<option value="daily" <?php if($_POST['type'] == 'daily') echo "selected" ;?>>Daily</option>
		     						<option value="monthly" <?php if($_POST['type'] == 'monthly') echo "selected" ;?>>Monthly</option>
		     						<option value="betweenDate" <?php if($_POST['type'] == 'betweenDate') echo "selected" ;?>>Between Dates</option>
									
	     						</select>
		     				</div>
		     				<div id="daily" class="type">
		     					<div style="float:left;margin-right:20px;"><input name="dailyDate" value="<?php echo $_POST['dailyDate']; ?>" id="date0" PLaceholder="Enter Date" size="10"  maxlength="10" style="width: 90px;" type="text" /></div>
		     				</div>
		     				<div id="monthly" class="type">
		     					<div style="float:left;margin-right:20px;">
									<select name="month" >
										<option  value="">Select Month</option>
										<option <?php if($_POST['month'] == '1') echo "selected" ;?> value="1">JAN</option>
										<option <?php if($_POST['month'] == '2') echo "selected" ;?> value="2">FEB</option>
										<option <?php if($_POST['month'] == '3') echo "selected" ;?> value="3">MAR</option>
										<option <?php if($_POST['month'] == '4') echo "selected" ;?> value="4">APR</option>
										<option <?php if($_POST['month'] == '5') echo "selected" ;?> value="5">MAY</option>
										<option <?php if($_POST['month'] == '6') echo "selected" ;?> value="6">JUN</option>
										<option <?php if($_POST['month'] == '7') echo "selected" ;?> value="7">JULY</option>
										<option <?php if($_POST['month'] == '8') echo "selected" ;?> value="8">AUG</option>
										<option <?php if($_POST['month'] == '9') echo "selected" ;?> value="9">SEP</option>
										<option <?php if($_POST['month'] == '10') echo "selected" ;?> value="10">OCT</option>
										<option <?php if($_POST['month'] == '11') echo "selected" ;?> value="11">NOV</option>
										<option <?php if($_POST['month'] == '12') echo "selected" ;?> value="12">DEC</option>
									</select>
								</div>
								<div style="float:left;margin-right:20px;">	
									<select name="year" >
										<option value="">Select Year</option>
										<option <?php if($_POST['year'] == '2014') echo "selected" ;?> value="2014">2014</option>
										<option <?php if($_POST['year'] == '2013') echo "selected" ;?> value="2013">2013</option>
										<option <?php if($_POST['year'] == '2012') echo "selected" ;?> value="2012">2012</option>
										<option <?php if($_POST['year'] == '2011') echo "selected" ;?> value="2011">2011</option>
										<option <?php if($_POST['year'] == '2010') echo "selected" ;?> value="2010">2010</option>
										<option <?php if($_POST['year'] == '2009') echo "selected" ;?> value="2009">2009</option>
										<option <?php if($_POST['year'] == '2008') echo "selected" ;?> value="2008">2008</option>
										<option <?php if($_POST['year'] == '2007') echo "selected" ;?> value="2007">2007</option>
										<option <?php if($_POST['year'] == '2006') echo "selected" ;?> value="2006">2006</option>
										<option <?php if($_POST['year'] == '2005') echo "selected" ;?> value="2005">2005</option>
										<option <?php if($_POST['year'] == '2004') echo "selected" ;?> value="2004">2004</option>
										<option <?php if($_POST['year'] == '2003') echo "selected" ;?> value="2003">2003</option>
										<option <?php if($_POST['year'] == '2002') echo "selected" ;?> value="2002">2002</option>
										<option <?php if($_POST['year'] == '2001') echo "selected" ;?> value="2001">2001</option>
									</select>
								</div>
							</div>
		     				<div id="betweenDate" class="type">
		     					<div style="float:left;margin-right:20px;"><input name="fromDate" value="<?php echo $_POST['fromDate']; ?>"  id="date1" PLaceholder="From Date" size="10" maxlength="10" style="width: 90px;" type="text" /></div>
								<div style="float:left;margin-right:20px;"><input name="toDate" value="<?php echo $_POST['toDate']; ?>"  id="date2" size="10" placeholder="To Date" maxlength="10" style="width: 90px;" type="text" /></div>
							</div>
							<div style="float:left;margin:0px 30px;">
								<input type="submit" name="submit" value="Generate" class="form-button"  />
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
	     			if(isset($_POST['submit']))
					{
						
					?>
	     		<div class="clear"></div>
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
		     				<div id="left-title">Diary List</div>
		     				<div id="right-title"><a href="generate.php<?php echo $url; ?>">Download</a></div>
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
			     					<th width="2%">Letter Date</th>
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
				     					<td><?php echo $allDiaries[$i]['date_of_letter']; ?></td>
				     					<td><?php echo $allDiaries[$i]['recieved_date']; ?></td>
				     				</tr>
     						<?php 
								}
	     					?>
	     					<tr>
	     						<td>
	     							<?php echo $pagination?>
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
