<?php 
	session_start();
	
	if(!isset($_SESSION['user']['user_name']) && $_SESSION['user']['role_id']!=2)
		header('location:../../index.php');
	
	require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Fetch.php';		
	
	use classes\Implementation\ClosingOfFile as impCof;
	
	$fetchCof      = new impCof\Fetch();
	
	$addresseeDetails = $fetchCof->getDispatchAddressee($_GET['applicationId']);

//print_r($addresseeDetails);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../css/styles.css">
		<link rel="stylesheet" href="../../css/pagination.css">
		
		<script type="text/javascript">

		function applicationAction(str)
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
		xmlhttp.open("GET","applicationAction.php?q="+str,true);
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
	     		
	     		 <div class="clear"></div>
	     		<?php if(isset($_GET['msg']) && $_GET['msg'] != '')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-green">
	     			<?php echo $_GET['msg'];?>	
	     		</div>
	     		<?php 
	     		}
	     		?>
	     		<?php if(isset($_GET['errmsg']) && $_GET['errmsg'] != '')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-red">
	     			<?php echo $_GET['errmsg'];?>	
	     		</div>
	     		<?php 
	     		}
	     		?>
	     		
	     		<div class="clear"></div>
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Dispatch Dairy</div>
	     				<div id="right-title"></div>
	     				
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px">
		     				<table id="table-records">
			     				<tr>
			     					<th width="2%" >Sr.No.</th>	
			     					<th width="15%">Addresse Name Type</th>		     					
			     					<th width="15%">Address</th>
			     					<th width="25%">City</th>			     					
			     					<th width="10%">Action</th>					
			     					</tr>
			     				<?php
			     				$hc_address1='';
			     				$hc_address2='';
			                    $city='';
			     				$state_name='';
			     				$pincode='';
	     						
	     							for($i =0;$i<count($addresseeDetails);$i++)
									{
																				
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
				     				<tr class="<?php echo $class; ?>" align="center">
				     					<td><?php if(isset($_GET['page']) && $_GET['page']>1) {  echo $recordCounter+$i+1; } else if(isset($_GET['page']) && $_GET['page']==1) echo $i+1; else echo $i+1; ?></td>
				     					<td><?php echo $addresseeDetails[$i]['addressee_name']; ?></td>
				     					<td><?php echo $addresseeDetails[$i]['address1']; ?></td>
				     					<td><?php echo $addresseeDetails[$i]['city']; ?></td>				     					
				     					<td> <a href = "dispatch.php?applicationId=<?php echo $addresseeDetails[$i]['application_id'] ?>&applicant_id=<?php echo $addresseeDetails[$i]['applicant_id']; ?>&stage_id=<?php echo $addresseeDetails[$i]['stage_id']; ?>">Dispatch </a></td>				     				
				     				</tr>
		     					
		     			     	<?php 
									}									
		     					?>
		     					
		     				</table>
		     				<div id="light" class="white_content" style="width:23%;height:30%"></div>
        							<div id="fade" class="black_overlay"></div>
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
