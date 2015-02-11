<?php 
	session_start();
	if(!isset($_SESSION))
		header('location:../../login.php');
	require_once '../../classes/implementation/diary/Fetch.php';
	require_once '../../classes/implementation/state/Fetch.php';
	
	use classes\implementation\diary as impDiary;
	use classes\implementation\state as impState;
	
	$fetchState = new impState\Fetch();
	$states = $fetchState->getAllStates();
	
	$fetchDiary = new impDiary\Fetch();
	$allDiary = $fetchDiary->getAllDiary();
	$searchResults = array();
	$msg = '';
	if(isset($_POST['advSearch1']))
	{
		$searchResults = $fetchDiary->getAdvanceSearchResults($_POST['advSearch1']);
		if(count($searchResults) == 0)
			$msg = 'No records found';
	}
	if(isset($_POST['advName']))
		$searchResults = $fetchDiary->getSearchResults($_POST['keyword'],$_POST['check'],$_POST['fromDate'],$_POST['toDate'],$_POST['state']);
	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="../../js/masking/jquery-1.js"></script>
		<script type="text/javascript" src="../../js/masking/jquery.js"></script>
				
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
	     				<li><a href="search-results.php">Search Results</a></li>
	     			</ul>
	     		</div>
	     		<div id="search2" style="margin-top:5px;">
	     		
	     		<div id="breadcrumb" >
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Search Results</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:0px 10px;">
	     				
	     				<div>
		     				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
								<div style="width:450px;float:left">
									<input type="text" id="advName" value="<?php if(isset($_POST['advName'])) echo $_POST['keyword'] ;?>" name="keyword" PlaceHolder = "Enter Keyword" />
								</div>
								<div style="float:left;margin-top:6px;margin-right:20px;">
									<input  name="advName" type="submit" value="Search" />
								</div>
								<div style="float:left;margin-top:6px;">
									<input  name="reset" type="reset" value="Reset" />
								</div>
								<div style="clear: both;height:5px;"></div>
								<div style="float: left">
									Search In : <input type="checkbox" checked name="check[]" <?php if(in_array("diary_no",$_POST['check'])) echo "checked" ;?> value="diary_no" /><span class="font"> Diary No.</span>
								</div>
								<input type="hidden" checked name="check[]" value="" />
								<div style="float:left">
									<input type="checkbox" name="check[]" value="subject" <?php if(in_array("subject",$_POST['check'])) echo "checked" ;?> /><span class="font"> Subject</span>
								</div>
								<div style="float :left">
									<input type="checkbox" name="check[]" value="letter_no" <?php if(in_array("letter_no",$_POST['check'])) echo "checked" ;?> /><span class="font"> Letter No.</span>
								</div>
								<div style="float :left">
									<input type="checkbox" name="check[]" value="applicant" <?php if(in_array("applicant",$_POST['check'])) echo "checked" ;?> /><span class="font"> Applicant</span>
								</div>
								<div style="float :left">
									<input type="checkbox" name="check[]" value="contact_no" <?php if(in_array("contact_no",$_POST['check'])) echo "checked" ;?> /><span class="font"> Contact No.</span>
								</div>
								<div style="float :left">
									<input type="checkbox" name="check[]" value="mail_id" <?php if(in_array("mail_id",$_POST['check'])) echo "checked" ;?> /><span class="font"> Mail Id</span>
								</div>
								<div style="clear: both;height:5px"></div>
								<div style="float:left;margin-right:20px;margin-top:8px;">
									Between : 
								</div>
								<div style="width:120px;margin-right:20px;float:left;margin-top:6px;">
									<input type="text" id="date0" value="<?php if(isset($_POST['fromDate'])) echo $_POST['fromDate'] ;?>" name="fromDate" PlaceHolder = "Start Date" />
								</div>
								<div style="width:120px;float:left;margin-right:20px;margin-top:6px">
									<input type="text" id="date1" name="toDate" value="<?php if(isset($_POST['toDate'])) echo $_POST['toDate'] ;?>" PlaceHolder = "End Date" />
								</div>
								<div style="float :left;margin-top:6px;;">
									<select name="state">
										<option value="">Select State</option>
										<?php for($i = 0; $i < count($states); $i++)
										{
											if($states[$i]['id'] == $_POST['state'])
											{
										?>
												<option selected="selected" value="<?php echo $states[$i]['id']; ?>"><?php echo $states[$i]['state_name']; ?></option>
										<?php 
											$i++;
											}
										?>
										<option value="<?php echo $states[$i]['id']; ?>"><?php echo $states[$i]['state_name']; ?></option>
										<?php 
										}
										?>
									</select> 
								</div>
							</form>	
							<script type="text/javascript">
						jQuery(function($){
							$("#date0").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
							$("#date1").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
						});
						</script>
		     			</div>
	     				
	     			<div class="clear"></div>
	     			
	     			<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
	     			<?php if(count($searchResults) == 0)
		     			{		
		     		?>
		     			<tr width="100%">
	     					<th width="6%">Sr. No.</th>
	     					<th width="14%">Diary No.</th>
	     					<th width="22%">Subject</th>
	     					<th width="15%">Applicant</th>
	     					<th width="15%">Letter No.</th>
	     					<th width="8%">Date</th>
	     				</tr>	
		     			<tr>
	     					<td colspan="6">
	     						No Records found...
	     					</td>
	     				</tr>
	     			<?php
		     			}else
		     			{ 
	     			?>
	     				<tr>
	     					<td colspan="6">
	     						<div style="padding:5px;color:green;font-size:16px;"><?php echo count($searchResults); ?> records found</div>
	     					</td>
	     				</tr>
	     				<tr width="100%">
	     					<th width="6%">Sr. No.</th>
	     					<th width="14%">Diary No.</th>
	     					<th width="22%">Subject</th>
	     					<th width="15%">Applicant</th>
	     					<th width="15%">Letter No.</th>
	     					<th width="8%">Date</th>
	     				</tr>	
	     				<?php 			
	     						for($i =0;$i<count($searchResults);$i++)
									{
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
					     				<tr class="<?php echo $class; ?>">
					     					<td><?php echo $i+1; ?></td>
					     					<td><a href="diary-details.php?id=<?php echo $allDiary[$i]['id']; ?>"><?php echo $searchResults[$i]['diary_no']; ?></a></td>
					     					<td><?php echo $searchResults[$i]['subject']; ?></td>
					     					<td><?php echo $searchResults[$i]['applicant']; ?></td>
					     					<td><?php echo $searchResults[$i]['letter_no']; ?></td>
					     					<td><?php echo $searchResults[$i]['recieved_date']; ?></td>
					     				</tr>
					     		<?php 
					     			}
		     					}
	     						?>
		     			</table>
		     		</div>
	     			
	       		</div>
	     		</div>
	     			
		     	</div>    		
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
