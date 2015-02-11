<?php 
	session_start();
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
	
    require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Fetch.php';
    require_once $_SESSION['base_url'].'/classes/Implementation/ClosingOfFile/Edit.php';
	
	use classes\Implementation\ClosingOfFile as impCof;
	
	$fetchCof = new impCof\Fetch();
	$editCof  = new impCof\Edit();
	
	$msg ='';
	$errmsg= '';
	
	if (isset($_POST['upDispatchStatus']))
	{
		
		$applicationStatus = $fetchCof->getApplicationStatus($_POST['application_id']);	
		$currentStage = $applicationStatus['stage_id'];
		$currentSubStage = $applicationStatus['sub_stage_id'];
		
		$stage_id = $currentStage;
		$sub_stage_id = $currentSubStage+1;
		$flag = $editCof->upApplicationStatus($_POST['application_id'], $stage_id, $sub_stage_id);
		
		if ($flag== 1)
		{
			$msg = "Letter Send to Dispatch.";
			header("Location:index.php?msg=$msg");
		}
		else
		{
			$errmsg = "failed ?? Please try again Later.";
			header("Location:generateLetterDetails.php?errmsg=$errmsg");
		}	
	
	}
	

	$GeneratedLetter     = $fetchCof->getGeneratedLetter($_GET['appliId']);
    $noofApplication     = count($GeneratedLetter);
	$allApplicants       = $fetchCof->getLetterAddresse($GeneratedLetter[0]['id']);
	$noofApplicants      = count($allApplicants);
	//print_r($allApplicants);
	
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
	xmlhttp.open("GET","lettersApplicantDetails.php?q="+str,true);
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
	     				<li><a href="#">View Generate Letter Details</a></li>
	     			</ul>
	     		</div>
	     	   	
	     		<?php if(isset($_GET) || $msg != '')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-green">
	     			<?php echo $msg;
	     			
	     			echo  $_GET['msg']
	     			?>	
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
     				<div id="left-title">Generate Letter Details</div>
     				<div class="right-title" >&nbsp;</div>
	     		</div>
	     			
	     	<div style="border:2px solid #4b8df8;padding:7px;height:220px;">
	  	<div class="clear"></div>
	  		<div class="clear"></div>
	     		<div class=".container">
	     		
	     		         <div class="leftDiv">     		
									<div class="clear"></div>
									<div class=""><b>Letter Type : </b> <?php echo $GeneratedLetter[0]['type_name'];?></div>
					                <div class="clear"></div>
					                
					                <div class="clear"></div>
									<div class=""><b>Subject  : </b> <?php echo $GeneratedLetter[0]['subject'];?></div>
					                <div class="clear"></div>									
	     		          </div>  
	     		          
	     		          
	     		           		
	     	
	     			
	     		          <div class="rightDiv">  	     	
	     	                         <?php if($noofApplicants>0) { ?>
	     		        
									<div class="clear"></div>
									<div class=""><b> To : </b> 
								
                       		<?php 
									$applicant='';									
	             					for($i=0;$i<count($allApplicants);$i++) { 

									if ($allApplicants[$i]['is_to']==1)
									{
										if($i+1!=$noofApplicants)
										{
											$applicant = $allApplicants[$i]['addressee_name']."&nbsp;,&nbsp";
										}
										else 
										{
											$applicant = $allApplicants[$i]['addressee_name'];
										}
										
									}
										
										?>							
									
									<a href = "javascript:void(0)" onclick = "applicantDetails(<?php echo $allApplicants[$i]['id']?>)"><?php echo $applicant; ?></a>
					
									<?php $applicant=''; } ?>
									<div id="light" class="white_content"></div>
        							<div id="fade" class="black_overlay"></div>
									</div>
									
									
									
									<div class="clear"></div>
									<div class=""><b> Copy To : </b> 
								
	                       		<?php 
									$applicant='';
	             					for($i=0;$i<count($allApplicants);$i++) { 

									if ($allApplicants[$i]['is_to']==0)
									{
										if($i+1!=$noofApplicants)
										{
											$applicant = $allApplicants[$i]['addressee_name']."&nbsp;,&nbsp";
										}
										else 
										{
											$applicant = $allApplicants[$i]['addressee_name'];
										}
										
									}
										
										?>							
									
									<a href = "javascript:void(0)" onclick = "applicantDetails(<?php echo $allApplicants[$i]['id']?>)"><?php echo $applicant; ?></a>
					
									<?php $applicant=''; } ?>
									<div id="light" class="white_content"></div>
        							<div id="fade" class="black_overlay"></div>
									</div>
									
									<div class="clear"></div>
									<?php } ?>									 	
			              </div>
		
				</div>	
		<div class="clear"></div>					
	    <div class="clear"></div>			
	   <hr>   
	<div class="clear"></div> 
	  	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>"; method="post" >	
							
				     			<div style="text-align:center;padding:10px 0;">
									<a href="reGenerateLetter.php?application_id=<?php echo $_GET['appliId']?>" class="form-button" name="first">Regenerate</a>
									<a href="../../letter/samples/inlineall.php?name=<?php echo $GeneratedLetter[0]['letter_type_name'];?>&appliId=<?php echo $_GET['appliId']?>" class="form-button" name="first" target="_blank">View Letter</a>
									<input type="hidden" name="application_id" value="<?php echo $_GET['appliId']?>">
									<input class="form-button" type="submit" name="upDispatchStatus" value="Sent to Dispatch" />
								</div>
							
						</form>
					
	<?php   } else { ?>
     		                         	
     		     <div id="breadcrumb-red">
     			<?php echo "Application Not Found"; ?> </div>	    		                         	
     		                         
  <?php } ?>  		                         
	     		                   
	     				</div> 	     						
	     		</div> 
	     		</div>
	     		</div>
	     		
	     			
	     	<!--  </div> 
	     	  <div class="right-title" ><button onclick="goBack()">Go Back</button></div>	    
	     	  	</div> --> 
	     	  	
	 
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
			     	