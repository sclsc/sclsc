<?php 
	session_start();
	if(!isset($_SESSION['user']))
		header('location:../../login.php');

	$msg = '';
	$errmsg = '';
	$abc=0;
	/*	
	require_once $_SESSION['base_url'].'/classes/Implementation/Advocate/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Advocate/Edit.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Advocate/Delete.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
	
	use classes\Implementation\Advocate as impAdvocate;
	use classes\Pagination as impPage;
	
	$fetchAdvocate = new impAdvocate\Fetch();
	$editAdvocate  = new impAdvocate\Edit();
	$delAdvocate   = new impAdvocate\Delete();
	$fetchPage     = new impPage\Pagination();

	if (isset($_GET['action']) && $_GET['action']=='up' && $_GET['advocateId']!='')
	{
	$activeStatus=$_GET['activeStatus'];
	$advocateId=$_GET['advocateId'];
	
	$abc = $editAdvocate->upAvocateStatus($advocateId,$activeStatus);
	if ($abc==1)
		$msg = "Adovcate Status Has been Updated successfully.";
	else
		$errmsg- 'update faild';
	}

	 
	 if (isset($_GET['action']) && $_GET['action']=='del' && $_GET['advocateId']!='')
	 {	 	
	 	$advocateId=$_GET['advocateId'];
	 		 
	 	$abc = $delAdvocate->delAvocate($advocateId);
	 	if ($abc==1)
	 		$msg = "Adovcate Has been Deleted Successfully.";
	 	else
	 		$errmsg- 'update faild';
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
		
		$alladvocate = $fetchAdvocate->getAllAdvocates($limit,$start);
	    $Records = $fetchAdvocate->getAllAdvocatesCount();
		$url='';
		$pagination = $fetchPage->paginations($page, $Records, $limit, $targetpage, $adjacents, $url);
	}
	else
	{
		 $alladvocate = $fetchAdvocate->getAllAdvocates($limit,$start);		
		 $Records = $fetchAdvocate->getAllAdvocatesCount();
		 $url='';
    	 $pagination = $fetchPage->paginations($page, $Records, $limit, $targetpage, $adjacents, $url);		
	}
	
//	print_r($Records);		
//print_r($alladvocate);
 
 */
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<script src="../../js/jquery.min.js"></script>
		<script src="../../js/masking/jquery-1.js"></script>
		<script src="../../js/masking/jquery.js"></script>
		<script src="../../js/validation.js"></script>	
		<link href="../../css/pagination.css" rel="stylesheet">

	</head>
	<body >
	<?php include_once 'include/header.php';?>
	    <div class="wrapper" >
			<div id="left-wrapper">	
				<?php include_once 'include/side-menu.php';?>
			</div>
			<div id="right-wrapper">
				<div id="breadcrumb">
	     			<ul>
	     				<li><a href="#">Home </a></li>
	     				<li><div class="right-title" style="color:#1D8CD6"><?php echo date('l jS \of F Y h:i:s A'); ?></div></li>
	     				
	     			</ul>
	     		</div>
	     		<div class="clear"></div>
	     			     		
	     		<div class="clear"></div>
	     		<?php if(isset($_GET['msg']) && $_GET['msg']!='')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-green" align="center">
	     			<?php echo $_GET['msg'];?>	
	     		</div>
	     		<?php 
	     		}
	     		if(isset($_GET['errmsg']) && $_GET['errmsg']!='')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-red" align="center">
	     			<?php echo $_GET['errmsg'];?>	
	     		</div>
	     		<?php 
	     		}
	     										
				if ($errmsg != "")
					echo '<div class="errmsg" align="center">' . $errmsg . '</div>';
				
				elseif ($msg != "")
					echo '<div class="msg" align="center">' . $msg . '</div>';
				?>
	     		<div class="clear"></div>
	     	<!-- 	<div class="title1" style="height:20px;">
     				<div id="left-title">Advocate List</div>
     				<div class="right-title"><a href="advocate_registration.php" class="login-button" style="font-size: 16px;">Add New Advocate</a></div>
	     		</div>				
	  		<div class="clear"></div>	
	     			<div style="border:2px solid #4b8df8;padding:7px;">
		     			<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     			<tr width="100%">
	     					<th width="6%">Sr. No.</th>
	     					<th width="15%"> Name</th>
	     					<th width="14%"> Code</th>
	     					<th width="15%">Email Id</th>
	     					<th width="15%">Mobile No</th>	     					
	     					<th width="15%">Date of Enrolment</th>	     					
	     					<th width="8%">Status</th>
	     					<th width="8%">Edit</th>
	     					<th width="8%">Delete</th>
	     				</tr>	
     				       <?php 			
     						for($i =0;$i<count($alladvocate);$i++)
								{	
									if($alladvocate[$i]['is_active']==TRUE)
									{
										$status="Active";
										$activeStatus = 0;
									}
									else
									{
										$status="Deactive";
										$activeStatus = 1;
									}	
							$class = ($i % 2 == 0) ? 'even' : 'odd';
							?>
				     		<tr class="<?php echo $class; ?>" align="center">
	     					<td><?php echo $i+1; ?></td>	     					
	     					 <td><a href="view_adv_details.php?advocateId=<?php echo $alladvocate[$i]['id']; ?>" ><?php echo $alladvocate[$i]['advocate_name']; ?></a></td>
	     					 <td><?php echo $alladvocate[$i]['advocate_code']; ?></td>
	     					<td><?php echo $alladvocate[$i]['email_id']; ?></td>
	     					<td><?php echo $alladvocate[$i]['contact_no1']; ?></td>
                            <td><?php if ($alladvocate[$i]['start_date']!='') echo date("d-m-Y", strtotime($alladvocate[$i]['start_date'])); ?></td>
                            <td><a href="index.php?advocateId=<?php echo $alladvocate[$i]['id']; ?>&activeStatus=<?php echo $activeStatus; ?>&action=up"><?php echo $status; ?></a></td>
                            <td> <a href="#">Edit</a></td>
                            <td><a href="index.php?advocateId=<?php echo $alladvocate[$i]['id']; ?>&action=del">Delete</a></td>
	     				</tr>    						
		     					
		     			     	<?php 
									}									
									 echo $pagination;
		     					?>
		     					
		     				</table>
			     		</div> 
			     		
		     		</div>
	     		</div>-->
		
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
