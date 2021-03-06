<?php 
	session_start();
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
error_reporting(0);
	$msg = '';
	$errmsg = '';
	$abc=0;
	
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

	
	$targetpage = 'advOnPannel.php';
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
	     $allAdvocateList = $fetchAdvocate->getAdvocatesList();

	     
     if(isset($_GET['submit']))
     {
     	$alladvocate = $fetchAdvocate->searchAdvocatesOnPannel($_GET['fromDate'], $_GET['toDate'], (int)$_GET['advocate_name'], $limit, $start);
     	$Records = $fetchAdvocate->searchAdvocatesOnPannelCount($_GET['fromDate'], $_GET['toDate'], (int)$_GET['advocate_name']);
     	$url = 'fromDate='.$_GET['fromDate'].'&toDate='.$_GET['toDate'].'&advocate_name='.(int)$_GET['advocate_name'];
     	//	$url ='';
     	$pagination = $fetchPage->paginations($page,$Records,$limit,$targetpage,$adjacents, $url);	     
     }
	

	
//	print_r($Records);		
//print_r($alladvocate);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<link rel="stylesheet" href="../../../css/styles.css">
		<script src="../../../js/jquery.min.js"></script>
		<script src="../../../js/masking/jquery-1.js"></script>
		<script src="../../../js/masking/jquery.js"></script>
		<script src="../../../js/validation.js"></script>	
		<link href="../../../css/pagination.css" rel="stylesheet">

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
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">Search Appointmented Advocate List</div>
     				<!-- <div class="right-title"><a href="advocate_registration.php" class="login-button" style="font-size: 16px;">Add New Advocate</a></div> -->
	     		</div>	
 
	     			<div style="border:2px solid #4b8df8;padding:20px 10px;height:40px;">
		     			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="GET">
		     				     		<div style="float:left;margin-right:10px;">
		     					<select name="advocate_name" >
		     						<option value="0">All Advocate</option>
										<?php for($i = 0; $i < count($allAdvocateList); $i++)
										{											
										?>										
										<option value="<?php echo $allAdvocateList[$i]['id']; ?>" <?php if($allAdvocateList[$i]['id']==$_GET['advocate_name'] || $allAdvocateList[$i]['id']==$_GET['advocate_name']) { echo "selected=selected"; } ?> ><?php echo $allAdvocateList[$i]['advocate_name']; ?></option>
										<?php 
										}
										?>
		     					</select>
		     	</div>
		     				<div style="float:center;margin-right:10px;">
		     					<div style="float:left;margin-right:10px;"><input name="fromDate" value="<?php if(isset($_GET['fromDate'])) echo $_GET['fromDate'];  else  echo $_GET['fromDate'];  ?>"  id="date1" PLaceholder="From Date" size="10" maxlength="10" style="width: 90px;" type="text" required="required"/></div>
								<div style="float:left;margin-right:10px;"><input name="toDate" value="<?php if(isset($_GET['toDate'])) echo $_GET['toDate']; else echo $_GET['toDate'] ?>"  id="date2" size="10" placeholder="To Date" maxlength="10" style="width: 90px;" type="text" required="required"/></div>
							</div>
							<div style="float:left;margin:0px 10px;">
								<input type="submit" name="submit" value="Show" class="form-button"  />
							</div>
						</form>
						<script type="text/javascript">
						jQuery(function($){							
							$("#date1").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
							$("#date2").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
						});
						</script>
		     		</div>
		     		<?php
	     			if(isset($_GET['submit']) || isset($_GET['page']))
					{						
					?>			
	  		<div class="clear"></div>	
	     			<div style="border:2px solid #4b8df8;padding:7px;">
		     			<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     			<tr width="100%">
	     					<th width="5%">Sr. No.</th>
	     					<th width="25%"> Name</th>
	     					<th width="14%"> Code</th>	     						     					
	     					<th width="5%">No. of Appointment</th>
	     					<th width="7%">View Details</th>	     					
	     					
	     				</tr>	
     				       <?php 			
     						for($i =0;$i<count($alladvocate);$i++)
								{										
							$class = ($i % 2 == 0) ? 'even' : 'odd';
							?>
				     		<tr class="<?php echo $class; ?>">
	     					<td><?php echo $i+1; ?></td>	     					
	     					 <td><?php echo $alladvocate[$i]['advocate_name']; ?></td>
	     					 <td><?php echo $alladvocate[$i]['advocate_code']; ?></td>
	     					<td><?php echo $alladvocate[$i]['count']; ?></td>
	     					<td><a href="viewAdvAppoinmentDetails.php?advocateId=<?php echo $alladvocate[$i]['id']; ?>" >View Applications</a></td>                           
                           
	     				</tr>    						
		     					
		     			     	<?php 
									}									
									 echo $pagination;
		     					?>
		     					
		     				</table>
			     		</div>
			     		<div class="right-title" ><button onclick="goBack()">Go Back</button></div>
		     		</div>
		     		
		     		<?php 
				}
	     		?>
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
<script>
function goBack() {
    window.history.back()
}
</script>
	</body>
</html>
