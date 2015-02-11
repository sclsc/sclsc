<?php 
	session_start();
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
	
	require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/State/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Users/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Category/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThrough/Fetch.php';
	
	use classes\Implementation\Category as impCategory;
	use classes\Implementation\ClosingOfFile as impCof;
	use classes\Implementation\State as impState;
	use classes\Implementation\Users as impUser;
	use classes\Implementation\RecievedThrough as impThrough;
	
	$fetchCategory = new impCategory\Fetch();
	$fetchCof = new impCof\Fetch();
	$fetchState = new impState\Fetch();
	$fetchUser = new impUser\Fetch();
	$fetchThrough = new impThrough\Fetch();
	
	$msg ='';
	$errmsg= '';

	$states              = $fetchState->getAllStates();
	$appliThroughType    = $fetchThrough->getReceivedThroughType();
	$throughType         = $fetchCof->getThroughType();
	$applicationDetails  = $fetchCof->getApplicationDetails($_GET['applicationId']);
    $noofApplication     = count($applicationDetails);
	$allApplicants       = $fetchCof->getApplicats($_GET['applicationId']);
	$noofApplicants      = count($allApplicants);
//	print_r($applicationDetails);
	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../css/styles.css">
		<link href="../../css/pagination.css" rel="stylesheet">
		<script type="text/javascript" src="../../js/masking/jquery-1.js"></script>
		<script type="text/javascript" src="../../js/masking/jquery.js"></script>
		
		<script type="text/javascript">
		    $(document).ready(function() {
		        $(".flip").click(function() {
		            $(".panel").slideToggle("slow");
		        });
		    });
		</script>
		<script>
	function showAdvocate(str)
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
		xmlhttp.open("GET","advocateDetails.php?q="+str,true);
		xmlhttp.send();
		}	


  function showSrAdvocate(str)
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
		xmlhttp.open("GET","srAdvocateDetails.php?q="+str,true);
		xmlhttp.send();
		}	

 function showThroughDetails(str)
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
		xmlhttp.open("GET","appThroughDetails.php?q="+str,true);
		xmlhttp.send();
		}	

function applicantDetails(str)
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
	xmlhttp.open("GET","applicantDetails.php?q="+str,true);
	xmlhttp.send();
	}	

		</script>
		
		
<style type="text/css">
.container {
    width: 300px;
}
.leftDiv {
    max-width: 100%;
  //  background:red;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
    -ms-text-overflow:ellipsis;
    float: left;
    padding-left:10px;
    width: 550px;
    
}
.rightDiv {
 //   background:yellow;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
    -ms-text-overflow:ellipsis;
    text-align: left;
     padding-left:0px;
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
	     				<li><a href="index.php">Dashboard /</a></li>
	     				<li><a href="#">View Application</a></li>
	     			</ul>
	     		</div>
	     	   	
	     		<?php if($msg != '')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-green">
	     			<?php echo $msg;?>	
	     		</div>
	     		<?php 
	     		}
	     		?>
	     		<?php if($errmsg != '')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-red">
	     			<?php echo $errmsg;?>	
	     		</div>
	     		<?php } if($noofApplication>0) { ?>		
	     		<div class="clear"></div>
	 	   		<div id="breadcrumb">
	 	   		<div class="clear"></div>
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">Application Details</div>
     				<div class="right-title" >&nbsp;</div>
	     		</div>
	     			
	     	<div style="border:2px solid #4b8df8;padding:7px;height:320px;">
	
	     		<div class=".container">
	     		
	     		         <div class="leftDiv">     		
									<div class="clear"></div>
									<div class=""><b>Legal Aid sought for : </b> <?php echo $applicationDetails[0]['appli_type_name'];?></div>
					                <div class="clear"></div>
									
	     		          </div>   		
	     	
	     			
	     		          <div class="rightDiv">  		
	     	
	     	                        <div class="clear"></div>
									<div class=""><b> Last Completed Stage : </b> <?php echo $applicationDetails[0]['stage_name'];?></div>
								
									<div class="clear"></div> 	
			              </div>
								
			
				
				</div>	
				
	<div class="clear"></div>			
	   <hr>   
	<div class="clear"></div> 
	  	
	   <div class=".container">

	     		<div class="leftDiv">    		
									<div class="clear"></div>
									<div class=""><b>Application No : </b> <?php echo $applicationDetails[0]['diary_no'];?></div>
					                <div class="clear"></div>
									<div class="clear"></div>
									<div class=""><b> Received date :</b> <?php echo date("d-m-Y", strtotime($applicationDetails[0]['received_date']));?></div>
									
									<div class="clear"></div>						
											
	     		
	     		</div>
	     		
	     		           <div class="rightDiv">  
	     		           		
	     		        <?php  if($noofApplicants>0) { ?>
	     		        
									<div class="clear"></div>
									<div class=""><b>Applicant Name : </b> 
								
	                       		<?php 
									$applicant='';
	             					for($i=0;$i<count($allApplicants);$i++) { 
									
										if($i+1!=$noofApplicants)
										{
											$applicant = $allApplicants[$i]['applicant_name']."&nbsp;,&nbsp";
										}
										else 
										{
											$applicant = $allApplicants[$i]['applicant_name'];
										}
										
								//	}
										
										?>							
									
									<a href = "javascript:void(0)" onclick = "applicantDetails(<?php echo $allApplicants[$i]['id']?>)"><?php echo $applicant; ?></a>
					
									<?php } ?>
									<div id="light" class="white_content"></div>
        							<div id="fade" class="black_overlay"></div>
									</div>
									
									<div class="clear"></div>
									<?php } ?>
									
									
							<?php  if(isset($applicationDetails[0]['appli_through_name'])) { ?>	
								
									<div class="clear"></div>
									<div class=""> <b>Received Through :</b> <a href = "javascript:void(0)" onclick = "showThroughDetails(<?php echo $applicationDetails[0]['through_id']?>)"> <?php echo $applicationDetails[0]['appli_through_name'];?> </a></div>									
									<div class="clear"></div>
								
									  	
								<?php } ?>
									
							</div>	    
	     		
	   
	
 <?php  if($applicationDetails[0]['stage_id']==3)  { ?> 
 
 	<div class="clear"></div>			
	   <hr>   
	<div class="clear"></div> 
	
		      <div class=".container">
	     			
	     			      <div class="leftDiv"> 
	     			                <div class="clear"></div>
									<div class=""><b> Legal Aid File No. :</b>  <?php echo $applicationDetails[0]['legal_aid_grant_no']; ?></div>
									
	     			       		    <div class="clear"></div>
									<div class="clear"></div>
									<div class=""><b>Advocate Name : </b> <a href = "javascript:void(0)" onclick = "showAdvocate(<?php echo $applicationDetails[0]['advocate_id']?>)"><?php echo $applicationDetails[0]['advocate_name']; ?></a></div>
									
									<div class="clear"></div>								
									<div class="clear"></div>
									<div class=""><b> Appointment Date  : </b>  <?php echo date("d-m-Y", strtotime($applicationDetails[0]['appointment_date'])); ?> </div>
								
									<div class="clear"></div>								
									<div class="clear"></div>				
									
							</div>
							
							
									
 <?php } elseif($applicationDetails[0]['stage_id']==4)  {  ?>  
 
 	<div class="clear"></div>
	   <hr>   
	<div class="clear"></div> 
	     	<div class=".container">
			
	     			      <div class="leftDiv">  
	     			                <div class="clear"></div>
									<div class=""><b> Legal Aid File No. :</b>  <?php echo $applicationDetails[0]['legal_aid_grant_no']; ?></div>	
										
									<div class="clear"></div>
									<div class="clear"></div>
									<div class=""><b>Advocate Name : </b><a href = "javascript:void(0)" onclick = "showAdvocate(<?php echo $applicationDetails[0]['advocate_id']?>)"><?php echo $applicationDetails[0]['advocate_name']; ?></a> </div>
									
									<div class="clear"></div>								
									<div class="clear"></div>
									<div class=""><b> Appointment Date  : </b>  <?php echo date("d-m-Y", strtotime($applicationDetails[0]['appointment_date'])); ?></div>
								    <div class="clear"></div>
									<div class="clear"></div>
						
							</div>			
				
					
	     			      <div class="rightDiv">
	     			      
	     			                <div class="clear"></div>
									<div class=""><b> Case Number  : </b>  <?php echo $applicationDetails[0]['case_type_name'].' / '.$applicationDetails[0]['case_number'].' / '.$applicationDetails[0]['case_year']; ?> </div>
	                                <div class="clear"></div>
									<div class="clear"></div>
									<div class=""><b> Petitioner :</b> <?php echo $applicationDetails[0]['petitioner']; ?></div>
									
									<div class="clear"></div>		
									<div class="clear"></div>
									<div class=""><b> Respondent :</b> <?php echo $applicationDetails[0]['respondent']; ?></div>
				
					</div>
						
		<?php  if($noofApplication>=2) {
			
			$srAdvocateDetailsDetails = $fetchCof->getSrAdvocateDetails($_GET['applicationId']);
		
			if($srAdvocateDetailsDetails[0]['sr_advocate_name']!='' && $srAdvocateDetailsDetails[0]['id']!='')
			{			
			?>
			
		                     <div class="leftDiv"> 
	     			                
								
									<div class=""><b>Sr. Advocate Name :</b>  <a href = "javascript:void(0)" onclick = "showSrAdvocate(<?php echo $srAdvocateDetailsDetails[0]['id']?>)"><?php echo $srAdvocateDetailsDetails[0]['sr_advocate_name']; ?></a></div>
									
																
									<div class="clear"></div>
									<div class=""><b> Appointment Date  : </b>  <?php echo date("d-m-Y", strtotime($srAdvocateDetailsDetails[0]['appointment_date']));  ?> </div>
								
															
									<div class="clear"></div>				
									
							</div>				
								
					
	<?php   }
		  }  
		}
	}  	     		 
	 else {
 ?>
     		                         	
     		     <div id="breadcrumb-red">
     			<?php echo "Application Not Found"; ?> </div>	    		                         	
     		                         
  <?php } ?>  		                         
	     		                   
	     				</div> 	     						
	     		</div> 
	     			
	     	  </div> 
	     	  <div class="right-title" ><button onclick="goBack()">Go Back</button></div>	    
	     	  	</div>
	     	  	
	     	</div>	     	
     				
	     		
	   </div>
	   </div>
			<script>
			function goBack() {
			    window.history.back()
			}
			</script>	
	     	<script type="text/javascript">
				jQuery(function($){
					$("#pincode").mask("999999", {placeholder: 'XXXXXX'});
					$("#contact_number").mask("999-999-9999", {placeholder: 'XXX/XXX/XXXX'});
				});
			</script>
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
			     	