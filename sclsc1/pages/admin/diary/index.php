<?php 
	session_start();
	//error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
	$msg = '';
	$errMsg = array();
	$reg_flag = array();
	$lastDiaryNumber = '';
	
	require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Edit.php';
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
	$EditDiary = new impDiary\Edit();
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
	if(isset($_GET['id']) && $_GET['action']=="edit"){
		$FetchDairyId= $fetchDiary->getDiaryDetailById($_GET['id']);
		 //print_r($FetchDairyId);
	}
	if(isset($_POST['update']))
	{
		$id					= (int) trim($_POST['id']);         
		$category           = (int) trim($_POST['category']);
		$letterNo           = (string) trim($_POST['letterNo']);
		$letterDate         = (string) trim($_POST['letterDate']);
		$received_through   = (int) trim($_POST['received_through_type']);
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
		
		$DairyDetailEdit=$EditDiary->updateDiary($id,$category,$letterNo,$letterDate,$received_through,$sender,$mailId,$contactNumber,$fatherName,$address1,$address2,$city,$state,$pincode,$subject,$description,$markTo);
		if($DairyDetailEdit==1)
		{
			$msg = "Dairy has been updated successfully";
			///$url = "index.php?msg=$msg&alert=success&page=".$_POST['page'];
			//header("location:index.php?msg=$msg&alert=success");
		}
		else
		{
			$msg='Error ?? try again Later';
			header("location:index.php?msg=$msg");
		}
	}
	$diary = $fetchDiary->getTodaysDiary($limit, $start);
	$Records = $fetchDiary->getTodaysDiaryCount();
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
		<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<script src="../../../js/masking/jquery-1.js"></script>
		<script src="../../../js/masking/jquery.js"></script>
		<script src="../../../js/diary-validation.js"></script>
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
	     				 //	echo $msg.' Please note Down the Diary Number <b>'.' ' .$lastDiaryNumber.'</b>';	
	     		echo $msg;	?>
	     				</div>
	     			<?php 
	     				 }
	     			?>
	     		</div>
	     		<div class="clear"></div>
	     		<div id="form">
	     				<div class="title1" style="height:20px;">
		     				<div id="left-title">Diary Registration</div>
		     				<div id="right-title" style="position:relative;margin:-4px 6px 0 0;">
		     					<!-- <form action="search-results.php" method="post" name="advSearch" >
		     						<input type="text" id="advSearch" name="advSearch1" placeholder="Enter keywords for Search" />
		     					</form>
		     				 -->
		     					<div id="stage"></div>
		     				</div>
		     			</div>
		     			<form action="index.php" method="post" onsubmit="return validateDiary()" name="diary">
		     			<div style="border:1px solid #4b8df8;background-color:#fff;height:660px;padding:8px 0px">
			     			<h3>Case Details</h3>
			     			<div style="width:50%;float:left;">
		     					<div class="clear"></div>
		     					<div class="left"> Category *</div>
			     				<div class="right">
			     					<select name="category" id="category" required="required" >
			     						<option value="">Select Category</option>
										<?php for($i = 0; $i < count($categoryIds); $i++)
										{
										?>
										<option value="<?php echo $categoryIds[$i]['id']; ?>" <?php if(isset($FetchDairyId[0]['category_id']) &&  $FetchDairyId[0]['category_id']==$categoryIds[$i]['id']){ ?> selected <?php }?>><?php echo $categoryIds[$i]['category_name']; ?></option>
										<?php 
										}
										?>
									</select>
			     				</div>
			     				<div class="clear"></div>
			     				<div id="diaryNo">
			     					<div class="left"> Diary No. *</div>
			     					<div class="right"><input  type="text" id="diary_no" name="diaryNo" readonly value="<?php echo $nextDiaryNumber; ?>" /></div>
			     				</div>
			     				<div class="clear"></div>
			     				<div class="left"> Recieved Date *</div>
			     				<div class="right"><input placeholder="dd-mm-yyyy" readonly required="required" type="text" id="recieved_date" name="recievedDate" value="<?php if(isset($FetchDairyId[0]['recieved_date'])) { $myFormatForView=  date("d-m-Y", strtotime($FetchDairyId[0]['recieved_date']));echo $myFormatForView; } else echo date('d-m-Y'); ?>" size="10" maxlength="10" required="required" /></div>
			     				<div class="clear"></div>
			     			</div>
			     			<div style="width:50%;float:right;">
			     				<div class="clear"></div>
			     				<div class="left"> 	Letter Reference No. </div>
			     				<div class="right"><input type="text" id="letter_no" name="letterNo" placeholder="Letter Number" value="<?php if(isset($FetchDairyId[0]['letter_no'])) { echo $FetchDairyId[0]['letter_no']; } else echo '';?>" /></div>
			     				<div class="clear"></div>
			     				
			     				<div class="left"> Letter Date *</div>
			     				<div class="right"><input required="required" type="text" name="letterDate" id="letter_date" size="10" maxlength="10" required="required" placeholder="dd-mm-yyyy" value="<?php if(isset($FetchDairyId[0]['date_of_letter'])) { $myFormatForView=  date("d-m-Y", strtotime($FetchDairyId[0]['date_of_letter']));echo $myFormatForView; } else echo '';?>"/></div>
		     					<div class="clear"></div>
		     					
								<div class="left"> Received Through </div>
								<div class="right">
									<select name="received_through_type" id="received_through_type" class="chosen-select" onchange="change_received_type(this.value);" value="<?php if(isset($FetchDairyId[0]['letter_no'])) { echo $FetchDairyId[0]['letter_no']; } else echo '';?>">
										<option value="">Select</option>
										<?php
			     						for($i =0;$i<count($received_through_type);$i++)
										{
										?>
		     								<option value="<?php echo $received_through_type[$i]['id']?>"<?php if(isset($FetchDairyId[$i]['recieved_through']) && $FetchDairyId[$i]['recieved_through']== $received_through_type[$i]['id']) { echo "selected=selected"; } ?> ><?php echo $received_through_type[$i]['appli_through_type_name']; ?></option>
		     							<?php 
										}
			     						?>
									</select> 
								</div>
								<div class="clear"></div>
								<div id="received">
									<input type="hidden" name="recieved_through" id="recieved_through"  value='' />
								</div>
		     				</div>
		     				<div class="clear"></div>
		     				<h3>Applicant Details</h3>
		     				<div class="clear"></div>
		     				<div style="width:50%;float:left;">
		     					<div class="left"> Sender/Applicant *</div>
			     				<div class="right"><input required="required" type="text" name="sender" placeholder="Name" id="applicant_name" value="<?php if(isset($FetchDairyId[0]['applicant'])) { echo $FetchDairyId[0]['applicant']; } else echo '';?>" /></div>
		     					<div class="clear"></div>
		     					<div class="left">Title</div>
			     				<div class="right">
									<input checked type="radio" name="rel" value="S/O">S/O &nbsp;
									<input type="radio" name="rel" value="D/O">D/O&nbsp;
									<input type="radio" name="rel" value="W/O">W/O&nbsp;
								</div>
								<div class="clear"></div>
								<div class="left">Father/Husband Name</div>
								<div class="right">
									<input type="text" id="father_name" placeholder=" Father/Husband Name" name="father_name" value="<?php if(isset($FetchDairyId[0]['father_name'])) { echo $FetchDairyId[0]['father_name']; } else echo '';?>" />
								</div>
		     					<div class="clear"></div>
		     					<div class="left"> Email ID</div>
			     				<div class="right"><input type="text" name="mailId" placeholder="Email ID" id="applicant_mail_id" value="<?php if(isset($FetchDairyId[0]['mail_id'])) { echo $FetchDairyId[0]['mail_id']; } else echo '';?>" /></div>
			     				<div class="clear"></div>
			     				<div class="left"> Contact No</div>
			     				<div class="right"><input type="text" name="contactNumber" id="contact_number"  placeholder="Contact Number" maxlength="14" size="14" value="<?php if(isset($FetchDairyId[0]['contact_number'])) { echo $FetchDairyId[0]['contact_number']; } else echo '';?>" /></div>
			     				<div class="clear"></div>
			     				
		     				</div>
			     			<div style="width:50%;float:right;">
			     				<div class="clear"></div>
		     					<div class="left"> Address *</div>
		     					<div class="right"><input required="required" type="text" name="address1" id="address1" placeholder="Address1" value="<?php if(isset($FetchDairyId[0]['sender_address1'])) { echo $FetchDairyId[0]['sender_address1']; } else echo '';?>" /></div>
		     					<div class="clear"></div>
		     					<div class="left"></div>
		     					<div class="right"><input type="text" name="address2" placeholder="Address2" id="address2" value="<?php if(isset($FetchDairyId[0]['sender_address2'])) { echo $FetchDairyId[0]['sender_address2']; } else echo '';?>"/></div>
		     					<div class="clear"></div>
		     					<div class="left"> Village/City/District *</div>
		     					<div class="right"><input required="required" id="applicant_city" type="text" name="city" placeholder="Village / City / District" value="<?php if(isset($FetchDairyId[0]['sender_city'])) { echo $FetchDairyId[0]['sender_city']; } else echo '';?>"/></div>
			     				<div class="clear"></div>
		     					<div class="left"> State *</div>
		     					<div class="right">
		     						<select name="state" required="required" id="applicant_state">
		     							<option value=''>Select</option>
		     						<?php
		     						for($i =0;$i<count($states);$i++)
									{
									?>
		     							<option value="<?php echo $states[$i]['id']; ?>"  <?php if(isset($FetchDairyId[0]['sender_state']) &&  $FetchDairyId[0]['sender_state']==$states[$i]['id']){ ?> selected <?php }?>><?php echo $states[$i]['state_name']; ?></option>
		     						<?php 
									}
		     						?>
		     						</select>
		     					</div>
		     					<div class="clear"></div>
		     					<div class="left"> Pincode </div>
		     					<div class="right"><input type="text" id="applicant_pincode" name="pincode" placeholder="XXXXXX" value="<?php if(isset($FetchDairyId[0]['pincode'])) { echo $FetchDairyId[0]['pincode']; } else echo '';?>"/></div>
		     				</div>
		     				<div class="clear"></div>
		     				<h3>Subject</h3>
		     				<div style="width:82%;margin-left:18%">
		     					<div style="float:left;width:8%;padding-top:4px;font-size:13px;color:#333">Subject *</div>
	     						<div style="float:right;width:91%">
	     							<input required="required" type="text" id="subject" name="subject" placeholder=" Enter Subject" value="<?php if(isset($FetchDairyId[0]['subject'])) { echo $FetchDairyId[0]['subject']; } else echo '';?>"/>
	     						</div>
		     					<div class="clear"></div>
		     					<div style="float:left;width:8%;padding-top:4px;font-size:13px;color:#333">Description</div>
	     						<div style="float:right;width:91%">
	     							<textarea rows="7" cols="30" name="description" id="description" placeholder=" Write Some Description" /></textarea>
	     						</div>
		     					<div class="clear"></div>
		     					<div style="width:60%;float:left">
			     					<div style="float:left;width:12%;padding-top:4px;font-size:13px;color:#333">Mark To *</div>
	     						<div style="float:left;width:50%;padding-left:3%">
	     							<select name="mark_to" required="required" id="mark_to" >
			     						<option value="">Select</option>
										<?php for($i = 0; $i < count($dealingUsers); $i++)
										{
										?>
										<option value="<?php echo $dealingUsers[$i]['id']; ?>" <?php if(isset($FetchDairyId[0]['mark_to']) &&  $FetchDairyId[0]['mark_to']==$dealingUsers[$i]['id']){ ?> selected <?php }?>><?php echo $dealingUsers[$i]['user_name']; ?></option>
										<?php 
										}
										?>
									</select>
	     						</div>
	     						<div style="margin-left:15%;padding-top:20px;">
	     						<div class="clear"></div>
	     						<?php if(isset($_GET['id']) && $_GET['action']=="edit"){?>
				     					<input type="submit" name="update" value="Update" class="form-button" />
				     			<!--  	<input type="submit" name="cancel" value="Cancel" class="form-button" /> -->
				     					<input type="hidden" id="id" name="id" 
				     					value="<?php echo $_GET['id'];?>"/>	
				     					<?php }else {?>					
						         <input type="submit" name="submit" value="Add Diary" class="form-button" />
						         <?php } ?>
	     						
	     						
	     						</div>
	     						</div>
		     				</div>
		     			</div>
		     		</form>
	     			<script type="text/javascript">
						jQuery(function($){
							$("#recieved_date").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
							$("#letter_date").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
							$("#pincode").mask("999999", {placeholder: 'XXXXXX'});
						});
					</script>
	     		</div>
	     		<?php if ($Records>0) { ?>
	     		
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
			     					<th width="8%"><a href="diary.php?orderBy=diary_no">Diary No.</a></th>
			     					<th width="25%"><a href="diary.php?orderBy=subject">Subject</a></th>
			     					<th width="12%"><a href="diary.php?orderBy=sender">Applicant</a></th>
			     					<th width="10%"><a href="diary.php?orderBy=mark_to">Mark To</a></th>
			     					<th width="13%"><a href="diary.php?orderBy=state">State</a></th>			     					
			     					<th width="2%"><a href="diary.php?orderBy=recieved_date">Recieved Date</a></th>
			     					<th width="2%"><a href="index.php">Action</a></th>
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
				     					<td><a href="index.php?action=edit&id=<?php echo $diary[$i]['id']; ?>">Edit</a>&nbsp;&nbsp;&nbsp;<a href="index.php?action=del&id=<?php echo $diary[$i]['id']; ?>">Delete</a></td>
				     				
				     				</tr>
	     						<?php 
									}
									echo $pagination;
		     					?>
		     					
		     				</table>
			     		</div>
		     		</div>
		     		<?php } ?>
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
