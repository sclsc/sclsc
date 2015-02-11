<?php 
	session_start();
	
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
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
	


	$targetpage = 'diary.php';
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
		<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<script src="../../../js/masking/jquery-1.js"></script>
		<script src="../../../js/masking/jquery.js"></script>
		<script src="../../../js/diary-validation.js"></script>
		<link rel="stylesheet" href="../../../css/pagination.css">
			<link rel="stylesheet" href="../../../css/chosen/docsupport/style.css">
  		<link rel="stylesheet" href="../../../css/chosen/docsupport/prism.css">
  		<link rel="stylesheet" href="../../../css/chosen/chosen.css">
		
	  	 	<script type="text/javascript">
		$(document).ready(function(){
			$('#application_search').keyup(function(){				
				$.ajax({
					    type: "POST",
					    url: "ajax/searchDiary.php?diary_no="+$('#application_search').val(),
					    success: function(result){
						    $('#records').html(result);
					      }
					});
				});
			});	
		</script> 
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
	     		<div class="title1" style="height:20px;">
	     				<div id="left-title" class="left" style="text-align:left;">All Diary List</div>
	     			<div id="right-title" style="text-align: right;width:300px;float:right;align:middle;">
	     			<input type="text" placeholder="Enter Diary Number" name="application_search" id="application_search" value=""/>
	     			</div> 
	     			</div>
	     			<div id="records" style="border:2px solid #4b8df8;padding:7px">
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
