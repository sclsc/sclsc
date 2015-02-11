<?php 
	session_start();
	
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
	
	$msg = '';
	$errMsg = array();
	$reg_flag = array();
	$lastDiaryNumber = '';
	
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
	
	if(isset($_POST['submit']))
	{
		$addDiary = new impDiary\Add();
		
		$category           = (int) trim($_POST['category']);
		$diaryNo            = (string) trim($_POST['diaryNo']);
		$recievedDate       = (string) trim($_POST['recievedDate']);
		$letterNo           = (string) trim($_POST['letterNo']);
		$letterDate         = (string) trim($_POST['letterDate']);
		$received_through   = (int) trim($_POST['recieved_through']);
		$sender             = (string) trim($_POST['sender']);
		$mailId             = (string) trim($_POST['mailId']);
		$contactNumber      = (int) trim($_POST['contactNumber']);
		$fatherName         = (string) trim($_POST['father_name']);
		$address1           = (string) trim($_POST['address1']);
		$address2           = (string) trim($_POST['address2']);
		$city               = (string) trim($_POST['city']);
		$state              = (int) trim($_POST['state']);
		$pincode            = (int) trim($_POST['pincode']);
		$subject            = (string) trim($_POST['subject']);
		$description        = (string) trim($_POST['description']);
		$markTo             = (int) trim($_POST['mark_to']);
		
		if(!empty($category) && (!is_numeric($category) || strlen($category) > 2))
			$errMsg[] = "Invalid Category";
		
		if(!empty($diaryNo) && strlen($diaryNo) > 15)
			$errMsg[] = "Invalid Diary Number";
			
		if(!empty($recievedDate) && strlen($recievedDate) != 10)
			$errMsg[] = "Invalid Recieved Date ";
		
		if(!empty($letterDate) && strlen($letterDate) != 10)
			$errMsg[] = "Invalid Letter Date ";
			
		if(!empty($letterNo) && strlen($letterNo) > 50)
			$errMsg[] = "Invalid Letter Number";
		
		if(!empty($received_through) && (!is_numeric($received_through) || strlen($received_through) > 4))
			$errMsg[] = "Invalid Recieved Through ";

		if(!empty($sender) && strlen($sender) > 100)
			$errMsg[] = "Invalid Sender";
		
		if(!empty($mailId) && !filter_var($mailId, FILTER_VALIDATE_EMAIL))
				$errMsg[] = "Invalid Mail Id";
		
		if(!empty($contactNumber) && (!is_numeric($contactNumber) || strlen($contactNumber) > 14))
			$errMsg[] = "Invalid Contact Number";
		
		if(!empty($fatherName) && strlen($fatherName) > 100)
			$errMsg[] = "Invalid Father Name";
		
		if(!empty($address1) && strlen($address1) > 150)
			$errMsg[] = "Invalid Address1";
		
		if(!empty($address2) && strlen($address2) > 150)
			$errMsg[] = "Invalid Address2";
		
		if(!empty($city) && strlen($city) > 150)
			$errMsg[] = "Invalid City";
		
		if(!empty($state) && !is_numeric($state))
			$errMsg[] = "Invalid State";
		
		if(!empty($pincode) && (!is_numeric($pincode) || strlen($pincode) != 6))
			$errMsg[] = "Invalid Pncode";
		
		if(!empty($subject) && strlen($subject) > 150)
			$errMsg[] = "Invalid Subject";
		
		if(!empty($description) && strlen($description) > 999)
			$errMsg[] = "Length of description must be less than 1000 character long";
		
		if(!empty($markTo) && !is_numeric($markTo))
			$errMsg[] = "Invalid Mark To";
		
		$letterDate = date("m-d-Y", strtotime($letterDate));
		$recievedDate = date("m-d-Y", strtotime($recievedDate));
		$fatherName = !empty($fatherName) ? $_POST['rel'].' '.$fatherName:''; 
		
		 if(count($errMsg) == 0)
		{  
			$lastDiaryNumber = $addDiary->registerDiary(
			    (int)$_POST['category'],
			 	$_POST['diaryNo'],
				$recievedDate,
				trim($_POST['letterNo']),
				$letterDate,
				(int)$_POST['recieved_through'],
				trim($_POST['sender']),
				trim($_POST['mailId']),
				(int) trim($_POST['contactNumber']),
				trim($fatherName),
				trim($_POST['address1']),
				trim($_POST['address2']),
				trim($_POST['city']),
				(int)$_POST['state'],
				(int)$_POST['pincode'],
				trim($_POST['subject']),
				trim($_POST['description']),
				(int)$_POST['mark_to']
				);
			 
			 if($lastDiaryNumber != '')
				$msg = "Diary Has been registered successfully.";
			else 
				$errMsg[] = 'Diary Registration failed';
		}
		else 
			$errMsg[] = "Wrong Input"; 
		
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
	}
	
	$diary = $fetchDiary->getAllDiary($limit, $start);
	$Records = $fetchDiary->getAllDiaryCount();
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
		<link href="../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../css/styles.css">
		<script src="../../js/masking/jquery-1.js"></script>
		<script src="../../js/masking/jquery.js"></script>
		<script src="../../js/diary-validation.js"></script>
		<link rel="stylesheet" href="../../css/pagination.css">
			<link rel="stylesheet" href="../../css/chosen/docsupport/style.css">
  		<link rel="stylesheet" href="../../css/chosen/docsupport/prism.css">
  		<link rel="stylesheet" href="../../css/chosen/chosen.css">
		
	   <!--  <script src="../../js/jquery-latest.min.js" type="text/javascript"></script>
	   	<script src="../../js/script.js"></script>
	   -->
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
			xmlhttp.open("GET","ajax/received_through.php?q="+str,true);
			xmlhttp.send();
			}			
		function showDiaryDetails(str)
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
		
		xmlhttp.open("GET","ajax/diary_details.php?q="+str,true);
		xmlhttp.send();
		}		
		</script>
		
	</head>
	<body>
	<?php require_once $_SESSION['base_url'].'/include/header.php';?>
	    <div class="wrapper" >
			<div id="left-wrapper">	
				<?php include_once 'include/side-menu.php';?>
			</div>
			<div id="right-wrapper">
				
			<div id="breadcrumb">
	     			<ul>
	     				<li><a href="index.php">Dashboard &nbsp;&nbsp;&nbsp; /</a></li>
	     				<li><a href="#">All Diary List</a></li>
	     			</ul>
	     		</div>
	     		<div id="breadcrumb">
	     			<?php
	     				 if(count($errMsg))
	     				 {
	     			?>
	     				<div class="errmsg">
	     			<?php 
	     					print_r($errMsg);
	     			?>
	     				</div>
	     			<?php 
	     				 }
	     				 if($msg != '')
	     				 {
	     			?>
	     				<div class="msg">
	     			<?php 
	     				 	echo $msg.' Please note Down the Diary Number <b>'.' ' .$lastDiaryNumber.'</b>';	
	     			?>
	     				</div>
	     			<?php 
	     				 }
	     			?>
	     		</div>
	     		
	     		<div class="clear"></div>
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">All Diary List</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px">
		     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     					<th width="2%">S/N</th>
			     					<th width="8%">Diary No.</th>
			     					<th width="25%">Subject</th>
			     					<th width="12%">Applicant</th>
			     					<th width="10%">Mark To</th>
			     					<th width="13%">State</th>			     					
			     					<th width="2%">Recieved Date</th>
			     				</tr>
			     				<?php
	     						
	     							for($i =0;$i<count($diary);$i++)
									{
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
				     				<tr class="<?php echo $class; ?>">
				     					<td><?php echo $i+1; ?></td>
				     					<td>
				     						<a href = "javascript:void(0)" onclick = "showDiaryDetails(<?php echo $diary[$i]['id']?>)"><?php echo $diary[$i]['diary_no']?></a>
        									<div id="light" class="white_content"></div>
        									<div id="fade" class="black_overlay"></div>
				     					<td><?php echo $diary[$i]['subject']; ?></td>
				     					<td><?php echo $diary[$i]['applicant']; ?></td>
				     					<td><?php echo $diary[$i]['user_name']; ?></td>
				     					<td><?php echo $diary[$i]['state_name']; ?></td>				     					
				     					<td><?php echo $diary[$i]['recieved_date']; ?></td>
				     				</tr>
	     						<?php 
									}echo $pagination;
		     					?>
		     					
		     				</table>
			     		</div>
		     		</div>
	     		</div>
	     	</div>
	     	<div class="clear"></div>
	     	<div class="clear"></div>
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
			
			<script src="../../js/chosen/jquery.min.js" type="text/javascript"></script>
				  <script src="../../js/chosen/chosen.jquery.js" type="text/javascript"></script>
				  <script src="../../js/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
				  		<script type="text/javascript">
						    var config = {
						      '.chosen-select'           : {},
						      '.chosen-select-deselect'  : {allow_single_deselect:true},
						      '.chosen-select-no-single' : {disable_search_threshold:10},
						      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
						      '.chosen-select-width'     : {width:"95%"}
						    }
						    for (var selector in config) {
						      $(selector).chosen(config[selector]);
						    }
				  </script>
	</body>
</html>
