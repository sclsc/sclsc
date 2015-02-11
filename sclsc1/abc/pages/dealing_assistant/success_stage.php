<?php 
	session_start();
	
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
	require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Fetch.php';

	use classes\Implementation\Diary as impDiary;
	
	$fetchDiary = new impDiary\Fetch();
	
	$applicants = $fetchDiary->getApplicants($_GET['id']);
//echo	count($applicants);
	//print_r($applicants);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../css/style.css" rel="stylesheet" />
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
	     				<li><a href="index.php">Dashboard</a></li>
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
	     		<div class="clear"></div>
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Recent Diary</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px">
		     			<div style="width:500px;margin:auto;">
		     				<a href="add_new_applicant.php?id=<?php echo $_GET['id']?>" class="form-button">Add Another Applicat</a>
		     			</div>		
			     	</div>
			     	
			     	<div class="clear"></div>
						
						<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
				     			<tr width="100%">
			     					<th width="2%" >S/N</th>
			     					<th width="8%">Applicant Name</th>
			     					<th width="35%">Address</th> 		
			     				    <th WIDTH="5%">Mobile Number</th>
			     					<th width="5%">Contact Number</th>
			     					<th width="15%">Email ID</th>
			     					<th width="5%">Action</th>
			     				</tr>
			     				<?php 
			     				
			     				$address1=$address2=$applicant_city=$applicant_state=$applicant_pincode='';
			     					for($i=0;$i<count($applicants);$i++)
					     				{
					     					$class = ($i % 2 == 0) ? 'even' : 'odd';
					     					
					     					if ($applicants[$i]['applicant_address_line1']!='')
					     					{
					     						$address1=$applicants[$i]['applicant_address_line1'].',';
					     					}
					     					if ($applicants[$i]['applicant_address_line2']!='')
					     					{
					     						$address2=$applicants[$i]['applicant_address_line2'].',';
					     					}
					     					if ($applicants[$i]['applicant_city']!='')
					     					{
					     						$applicant_city=$applicants[$i]['applicant_city'].',';
					     					}
					     					if ($applicants[$i]['applicant_state']!='')
					     					{
					     						$applicant_state=','.$applicants[$i]['applicant_state'];
					     					}
					     					if ($applicants[$i]['applicant_pincode']!='')
					     					{
					     						$applicant_pincode=','.$applicants[$i]['applicant_pincode'];
					     					}
					     		?>
			     					<tr class="<?php echo $class; ?>">
			     						<td><?php echo $i+1; ?></td>
			     						<td><?php echo $applicants[$i]['applicant_name']; ?></td>
			     						<td><?php echo $address1.$address2.$applicant_city.$applicant_state.$applicant_pincode; ?></td>			     						
			     						<td><?php echo $applicants[$i]['applicant_mobile_no']; ?></td>
			     						<td><?php echo $applicants[$i]['applicant_contact_no']; ?></td>
			     						<td><?php echo $applicants[$i]['applicant_email_id']; ?></td>
			     						<td>
			     							<a href="applicant_details.php?action=edit&id=<?php echo $applicants[$i]['id']; ?>">Edit</a>
			     							<!-- <a href="applicant_details.php?action=del&id=<?php echo $applicants[$i]['id']; ?>">Delete</a> -->
			     						</td>
			     					</tr>
			     						<?php 
			     						$address1=$address2=$applicant_city=$applicant_state=$applicant_pincode='';
											}
				     					?>
			     			</table>
	     		</div>
	     	</div>
	     </div>
	</body>
</html>
